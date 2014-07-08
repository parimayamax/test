<?php
/**
 * RESTfmClientLib static class.
 *
 * This client library provides a simple interface to RESTfm communication. See
 * documentation for RESTfmClientLib::call() below.
 *
 * @copyright
 *  © 2013 Goya Pty Ltd.
 *
 * @author
 *  Gavin Stewart
 *
 * @license
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 */
class RESTfmClientLib {

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
     * @throws Exception on cURL error (returns cURL error code), or on JSON
     *         decode error (returns code 9999).
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
                CURLOPT_USERAGENT, 'RESTfmClientLib',
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

        // Throw an exception if JSON decoding has errors.
        if (json_last_error() !== JSON_ERROR_NONE) {
            switch (json_last_error()) {
                case JSON_ERROR_DEPTH:
                    $jsonError = 'JSON decode error - Maximum stack depth exceeded';
                    break;
                case JSON_ERROR_STATE_MISMATCH:
                    $jsonError = 'JSON decode error - Underflow or the modes mismatch';
                    break;
                case JSON_ERROR_CTRL_CHAR:
                    $jsonError = 'JSON decode error - Unexpected control character found';
                    break;
                case JSON_ERROR_SYNTAX:
                    $jsonError = 'JSON decode error - Syntax error, malformed JSON';
                    break;
                case JSON_ERROR_UTF8:
                    $jsonError = 'JSON decode error - Malformed UTF-8 characters, possibly incorrectly encoded';
                    break;
                default:
                    $jsonError = 'JSON decode error - Unknown error';
                    break;
            }
            throw new Exception($jsonError . ":\n" . $result, '9999');
        }

        curl_close($ch);
        return NULL;
    }

};
