<?php
/**
 * FastSpring Validation service.
 *
 * Call with two query string parameters:
 *  key=<SharedKey>
 *  val=<SearchValue>
 *
 * Returns status code 200 if query exists, otherwise returns 403.
 *
 * Requires FileMaker Server and RESTfm v2.0
 *
 * @copyright
 *  © 2013 Goya Pty Ltd.
 *
 * @author
 *  Gavin Stewart
 *
 * @license
 *  This file is subject to the Goya Software License contained in the LICENSE
 *  file distributed with this package.
 */

$RESTfmURL = 'https://username:password@server/RESTfm/database/layout/SomeLayout.json';

$RESTfmQueryString = 'RFMsF1=FieldName&RFMsV1=';

// Shared 'API' key with FastSpring. Make up your own unique value here.
$SharedKey = 'abcdef1234567890';


// *** Main *** //

if (!isset($_GET['val']) ||
        !isset($_GET['key']) ||
        $_GET['key'] !== $SharedKey) {
    header('HTTP/1.1 500');
    echo "Incorrect format.";
    exit;
}

// Call RESTfm
$response = array();
$callURI = $RESTfmURL . '?' . $RESTfmQueryString . rawurlencode($_GET['val']);
//echo "Calling URI: $callURI\n"; // Debug
try {
    RESTfm::call($response, 'GET', $callURI);
} catch (Exception $e) {
    // Trigger a fatal error.
    header('HTTP/1.1 500');
    trigger_error(
        'cURL error (' . $e->getCode() . '): ' . $e->getMessage(),
        E_USER_ERROR
    );
}

//var_dump($response); // Debug

if ($response['info']['X-RESTfm-Status'] >= 200 &&
        $response['info']['X-RESTfm-Status'] <= 299) {
    header('HTTP/1.1 200');
    echo "valid";
} else {
    header('HTTP/1.1 403');
    echo "invalid";
}

exit;


/**
 * RESTfm client static class.
 *
 * @copyright
 *  © 2013 Goya Pty Ltd.
 *
 * @author
 *  Gavin Stewart
 *
 * @license
 *  This file is subject to the Goya Software License contained in the LICENSE
 *  file distributed with this package.
 */
class RESTfm {

    /**
     * @var array
     *  Map of generic method names to HTTP method names.
     */
    protected static $_genericMethodNames = array (
        'CREATE' => 'POST',
        'READ' => 'GET',
        'UPDATE' => 'PUT',
        'DELETE' => 'DELETE',
    );

    /**
     * Call RESTfm.
     *
     * @param array &$response
     *  Response from RESTfm returned as a mult-dimensional associative array.
     *
     * @param string $method
     *  Method to call RESTfm with.
     *  May be one of: POST, GET, PUT, DELETE
     *   OR
     *  May be one of: CREATE, READ, UPDATE, DELETE
     *
     * @param string URI
     *  URI to call RESTfm on.
     *  Must use .json extension.
     *  Must be properly urlencoded.
     *  May include query string parameters.
     *  May include authentication credentials.
     *  In the form:
     *    https://username:password@hostname/RESTfm/database/layout/some%20layout.json?RFMsomething=1
     *
     * @param array $data
     *  Optional data to be submitted to RESTfm.
     *  Array of Associative Arrays. Each associative Array represents one row
     *  of filedName => value pairs.
     *  In the form:
     *     array( // Array of rows
     *          array('Field1' => 'value1', 'Field2' => 'value2'), // First row
     *          array('Field1' => 'value3', 'Field2' => 'value4'), // Second row
     *          . . .
     *      );
     *
     * @throws Exception on cURL error.
     *
     * @return NULL
     *  All information returned from RESTfm will appear in $response.
     */
    public function call (&$response, $method, $URI, $data = NULL) {

        // Translate generic method names to HTTP method names.
        if (isset(self::$_genericMethodNames[$method])) {
            $method = self::$_genericMethodNames[$method];
        }

        // Common cURL setup and options.
        $ch = curl_init();
        $options = array(
                CURLOPT_URL => $URI,
                CURLOPT_SSL_VERIFYPEER => FALSE,
                CURLOPT_FAILONERROR => FALSE,
                CURLOPT_HEADER => FALSE,
                CURLOPT_RETURNTRANSFER => TRUE,
                CURLOPT_CUSTOMREQUEST => $method,
        );

        // Are we sending data ?
        if ($data !== NULL) {
            $json = json_encode(array('data' => $data));
            $options = $options + array(
                CURLOPT_HTTPHEADER => array(
                            'Content-Length: ' . strlen($json),
                            'Content-Type: application/json; charset=UTF-8',
                ),
                CURLOPT_POSTFIELDS =>  $json,
            );
        }

        // Apply options.
        curl_setopt_array($ch, $options);

        // Submit the requested operation to RESTfm.
        $result = curl_exec($ch);

        // Throw an exception if cURL has errors.
        if(curl_errno($ch)) {
            $curlError = curl_error($ch);
            $curlErrno = curl_errno($ch);
            curl_close($ch);

            throw new Exception($curlError, $curlErrno);
        }

        // Decode JSON response into $response reference variable.
        $response = json_decode($result, TRUE);

        return NULL;
    }

};
