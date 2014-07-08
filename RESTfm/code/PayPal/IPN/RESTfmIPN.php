<?php
/**
 * Listener service for PayPal Instant Payment Notification (IPN).
 *
 * Requires FileMaker Server and RESTfm v2.0
 *
 * @copyright
 * © 2013 Goya Pty Ltd.
 *
 * @license
 * This file is subject to the Goya Software License contained in the LICENSE
 * file distributed with this package.
 *
 * References:
 *  https://www.x.com/developers/paypal/documentation-tools/ipn/integration-guide/IPNIntro
 *  https://www.x.com/developers/PayPal/documentation-tools/code-sample/216623
 */

// *** Configurable variables *** //

// Full URL to RESTfm e.g.: https://username:password@hostname/RESTfm
$RESTfmBaseURL = 'https://username:password@localhost/RESTfm';

// Payments layout must contain fields listed in $IPNFieldsRequired (see below).
$RESTfmIPNPayments = $RESTfmBaseURL . '/IPNListener/layout/Payments';

// Log layout must contain Message and IPNMessage fields.
// Errors will be logged here.
$RESTfmIPNLog = $RESTfmBaseURL . '/IPNListener/layout/Log';

// URL provided by PayPal to validate IPN messages.
// For testing: https://www.sandbox.paypal.com/cgi-bin/webscr
// For production: https://www.paypal.com/cgi-bin/webscr
$IPNcallbackURL = 'https://www.sandbox.paypal.com/cgi-bin/webscr';

// List of fields to be extracted from IPN message. These fields _must_ exist
// in the IPN message _and_ the $RESTfmIPNPayments layout.
$IPNFieldsRequired = array(
    'IPNMessage',               // Required - Raw message as received.
    'IPNValidationResult',      // Required - Result of message validation.
    // Optional fields to break out of message:
    'txn_id',
);

// Disable PHP error reporting to http output, fatal errors will still be
// logged by webserver. Recommended for production use.
ini_set('display_errors', '0');

// *** Main *** //

$IPN = new IPN();

$RESTfm = new RESTfm();

try {
    if (! $IPN->parse()) {
        // No data to parse, just exit quietly.
        exit;
    }

    $RESTfm->setURL($RESTfmIPNPayments);
    $recordID = $RESTfm->create($IPN->getData($IPNFieldsRequired));

    $IPN->validate($IPNcallbackURL);

    $RESTfm->update($recordID, array(
        'IPNValidationResult' => $IPN->getValidationResult(),
    ));
} catch (Exception $e) {
    try {
        // Write error to Log layout.
        $RESTfm->setURL($RESTfmIPNLog);
        $RESTfm->create(array(
            'Message' => $e->getMessage(),
            'IPNMessage' => $IPN->getRawMessage(),
        ));
    } catch (Exception $ee) {
        // Unable to write to Log layout. Trigger a fatal error instead.
        trigger_error(
            'Log write failure: ' . $ee->getMessage() . "\n" .
            '    ' . $e->getMessage() . ': ' . $IPN->getRawMessage() . "\n",
            E_USER_ERROR
        );
    }
}

exit;

// *** Class definitions *** //

class IPN {
    /**
     * IPN message handling class.
     */

    /**
     * @var string Raw IPN Message as recieved.
     */
    protected $_rawIPNMessage;

    /**
     * @var string Validation request string.
     */
    protected $_validationRequest;

    /**
     * @var string Validation result string.
     */
    protected $_validationResult;

    /**
     * Parse received IPN message.
     *
     * @returns True if any POST data was received.
     */
    public function parse () {
        // Adapted from x.com example code.
        // https://www.x.com/developers/PayPal/documentation-tools/code-sample/216623

        // STEP 1: Read POST data

        // reading posted data from directly from $_POST causes serialization
        // issues with array data in POST
        // reading raw POST data from input stream instead.

        // Testing:
        //$this->_rawIPNMessage = 'mc_gross=19.95&protection_eligibility=Eligible&address_status=confirmed&payer_id=LPLWNMTBWMFAY&tax=0.00&address_street=1+Main+St&payment_date=20%3A12%3A59+Jan+13%2C+2009+PST&payment_status=Completed&charset=windows-1252&address_zip=95131&first_name=Test&mc_fee=0.88&address_country_code=US&address_name=Test+User&notify_version=2.6&custom=&payer_status=verified&address_country=United+States&address_city=San+Jose&quantity=1&verify_sign=AtkOfCXbDm2hu0ZELryHFjY-Vb7PAUvS6nMXgysbElEn9v-1XcmSoGtf&payer_email=gpmac_1231902590_per%40paypal.com&txn_id=61E67681CH3238416&payment_type=instant&last_name=User&address_state=CA&receiver_email=gpmac_1231902686_biz%40paypal.com&payment_fee=0.88&receiver_id=S8XGHLYDW9T3S&txn_type=express_checkout&item_name=&mc_currency=USD&item_number=&residence_country=US&test_ipn=1&handling_amount=0.00&transaction_subject=&payment_gross=19.95&shipping=0.00';
        // Also Testing:
        //parse_str($this->_rawIPNMessage, $_POST);

        $this->_rawIPNMessage  = file_get_contents('php://input');

        $raw_post_array = explode('&', $this->_rawIPNMessage);
        $myPost = array();
        foreach ($raw_post_array as $keyval) {
          $keyval = explode ('=', $keyval);
          if (count($keyval) == 2)
             $myPost[$keyval[0]] = urldecode($keyval[1]);
        }

        if (count($myPost) == 0) {
            return false;
        }

        // read the post from PayPal system and add 'cmd'
        $req = 'cmd=_notify-validate';
        if(function_exists('get_magic_quotes_gpc')) {
           $get_magic_quotes_exists = true;
        }
        foreach ($myPost as $key => $value) {
           if($get_magic_quotes_exists == true && get_magic_quotes_gpc() == 1) {
                $value = urlencode(stripslashes($value));
           } else {
                $value = urlencode($value);
           }
           $req .= "&$key=$value";
        }

        $this->_validationRequest = $req;

        return true;
    }

    /**
     * Return the requested fields from the IPN message.
     *
     * @param array $fieldNames Array of required field names to return.
     *
     * @throws Exception if any required field names are missing from message.
     *
     * @return array Associative array of fieldName => value pairs.
     */
    public function getData ($fieldNames) {
        $a = array();

        foreach ($fieldNames as $fieldName) {
            if (isset($_POST[$fieldName])) {
                $a[$fieldName] = $_POST[$fieldName];
            } elseif ($fieldName != 'IPNMessage' &&
                      $fieldName != 'IPNValidationResult') {
                throw new Exception('IPN::getData(): Required field not found in message: ' .
                                    $fieldName);
            }
        }

        // Special field for preserving raw message data.
        $a['IPNMessage'] = $this->_rawIPNMessage;

        return $a;
    }

    /**
     * Validate received IPN message with PayPal.
     *
     * @param string $callbackURL PayPal callback URL to validate IPN message.
     *
     * @throws Exception on error.
     */
    public function validate ($callbackURL) {
        // Adapted from x.com example code.
        // https://www.x.com/developers/PayPal/documentation-tools/code-sample/216623

        // STEP 2: Post IPN data back to paypal to validate

        $ch = curl_init($callbackURL);
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $this->_validationRequest);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Connection: Close'));

        // In wamp like environments that do not come bundled with root authority certificates,
        // please download 'cacert.pem' from "http://curl.haxx.se/docs/caextract.html" and set the directory path
        // of the certificate as shown below.
        // curl_setopt($ch, CURLOPT_CAINFO, dirname(__FILE__) . '/cacert.pem');

        $this->_validationResult = curl_exec($ch);

        if(curl_errno($ch)) {
            throw new Exception('IPN::validate(): Curl error: ' .
                curl_errno($ch) . ' ' . curl_error($ch)
            );
        }

        if (curl_getinfo($ch, CURLINFO_HTTP_CODE) > 200) {
            // Unexpected return code, abort.
            throw new Exception('IPN::validate(): Code not 200: ' .
                $this->_validationResult
            );
        }

        curl_close($ch);
    }

    /**
     * Validation Result getter.
     */
    public function getValidationResult () {
        return $this->_validationResult;
    }

    /**
     * Raw IPN Message getter.
     */
    public function getRawMessage () {
        return $this->_rawIPNMessage;
    }

};

class RESTfm {
    /**
     * RESTfm communication class.
     */

    /**
     * @var string RESTfm URL
     */
    protected $_URL;

    /**
     * URL setter.
     */
    public function setURL ($URL) {
        $this->_URL = $URL;
    }

    /**
     * Create a record at $_URL from supplied data.
     *
     * @param array $dataArray Associative array of fieldName => value pairs.
     *
     * @throws Exception on error.
     */
    public function create ($dataArray) {
        $restfmData = array('data' => array($dataArray));

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->_URL . '.json');
        //curl_setopt($ch, CURLOPT_USERPWD, $username . ':' . $password);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_FAILONERROR, false);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($restfmData));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                            'Content-Type: application/json; charset=UTF-8',
                            )
                    );

        // Submit the requested operation to RESTfm.
        $result = curl_exec($ch);

        if(curl_errno($ch)) {
            throw new Exception('RESTfm::create(): Curl error: ' .
                curl_errno($ch) . ' ' . curl_error($ch)
            );
        }

        $returnedData = json_decode($result, TRUE);

        if (curl_getinfo($ch, CURLINFO_HTTP_CODE) == 500) {
            // Use FileMaker error codes from response.
            throw new Exception('RESTfm::create(): Filemaker error: ' .
                $returnedData['info']['X-RESTfm-FM-Status'] . ' ' .
                $returnedData['info']['X-RESTfm-FM-Reason']
            );
        } elseif (curl_getinfo($ch, CURLINFO_HTTP_CODE) >= 400) {
            // Use RESTfm error codes from response.
            throw new Exception('RESTfm::create(): RESTfm error: ' .
                $returnedData['info']['X-RESTfm-Status'] . ' ' .
                $returnedData['info']['X-RESTfm-Reason']
            );
        }

        curl_close($ch);

        return $returnedData['meta'][0]['recordID'];
    }

    /**
     * Update a record at $_URL with supplied data.
     *
     * @param string $recordID Record ID to apply data to.
     * @param array $dataArray Associative array of filedName => value pairs.
     *
     * @throws Exception on error.
     */
    public function update ($recordID, $dataArray) {
        $restfmData = json_encode(array('data' => array($dataArray)));

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->_URL . '/' . rawurlencode($recordID) . '.json');
        //curl_setopt($ch, CURLOPT_USERPWD, $username . ':' . $password);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_FAILONERROR, false);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                            'Content-Length: ' . strlen($restfmData),
                            'Content-Type: application/json; charset=UTF-8',
                            )
                    );
        curl_setopt($ch, CURLOPT_POSTFIELDS, $restfmData);

        // Submit the requested operation to RESTfm.
        $result = curl_exec($ch);

        if(curl_errno($ch)) {
            throw new Exception('RESTfm::update(): Curl error: ' .
                curl_errno($ch) . ' ' . curl_error($ch)
            );
        }

        $returnedData = json_decode($result, TRUE);

        if (curl_getinfo($ch, CURLINFO_HTTP_CODE) == 500) {
            // Use FileMaker error codes from response.
            throw new Exception('RESTfm::update(): Filemaker error: ' .
                $returnedData['info']['X-RESTfm-FM-Status'] . ' ' .
                $returnedData['info']['X-RESTfm-FM-Reason']
            );
        } elseif (curl_getinfo($ch, CURLINFO_HTTP_CODE) >= 400) {
            // Use RESTfm error codes from response.
            throw new Exception('RESTfm::update(): RESTfm error: ' .
                $returnedData['info']['X-RESTfm-Status'] . ' ' .
                $returnedData['info']['X-RESTfm-Reason']
            );
        }

        curl_close($ch);
    }

};
