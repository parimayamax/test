<?php
/**
 * Demonstration of POST, GET, PUT and DELETE (or Create, Read, Update and
 * Delete, a.k.a CRUD) functionality with RESTfm.
 *
 * This application may be run from the command line with the php executable.
 *
 * The current Username and Password for the RESTfm demonstration database
 * may be found at: http://www.restfm.com/demo
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

// RESTfm Client Library is required. It includes documentation on calling
// parameters.
require_once('../RESTfmClientLib/RESTfmClientLib.php');

// Username:Password for RESTfm demo site, find current credentials here:
// http://www.restfm.com/demo
$credentials = 'write:restfm';

// RESTfm demonstration URI
$RESTfmDemoURI = 'http://' . $credentials . '@demo.restfm.com/RESTfm/postcodes/layout/brief%20postcodes';

// *** Main *** //
echo "<pre>\n";

// POST (Create):
echo "POST (Create) a new record.\n";
$data = array();                    // New data array to submit to RESTfm.
$data[] = array(                    // Append a record to data array.
    'Pcode' => 9999,
    'Locality' => 'RESTfmCRUDDemo',
    'Comments' => 'New record.',
);
$response = array();                // Response array for result from RESTfm.
try {
    RESTfmClientLib::call($response, 'POST', $RESTfmDemoURI . '.json', $data);
} catch (Exception $e) {            // A cURL error will raise an exception.
    trigger_error(
        'cURL error (' . $e->getCode() . '): ' . $e->getMessage(),
        E_USER_ERROR
    );
}
var_dump($response);                // See what RESTfm responded with.
if ($response['info']['X-RESTfm-Status'] != 201) {
    echo "RESTfm POST did not complete successfully, exiting.\n";
    exit;
}

// GET (Read):
$recordID = $response['meta'][0]['recordID'];
echo "\nGET (Read) the new record: $recordID\n";
$response = array();                // Response array for result from RESTfm.
try {
    RESTfmClientLib::call($response, 'GET', $RESTfmDemoURI . '/' . $recordID . '.json');
} catch (Exception $e) {            // A cURL error will raise an exception.
    trigger_error(
        'cURL error (' . $e->getCode() . '): ' . $e->getMessage(),
        E_USER_ERROR
    );
}
var_dump($response);                // See what RESTfm responded with.
if ($response['info']['X-RESTfm-Status'] != 200) {
    echo "RESTfm GET did not complete successfully, exiting.\n";
    exit;
}

// PUT (Update):
echo "\nPUT (Update) the record: $recordID\n";
$data = array();                    // New data array to submit to RESTfm.
$data[] = array(                    // Append a record to data array.
    'Comments' => 'Update only this field.',
);
$response = array();                // Response array for result from RESTfm.
try {
    RESTfmClientLib::call($response, 'PUT', $RESTfmDemoURI . '/' . $recordID . '.json', $data);
} catch (Exception $e) {            // A cURL error will raise an exception.
    trigger_error(
        'cURL error (' . $e->getCode() . '): ' . $e->getMessage(),
        E_USER_ERROR
    );
}
var_dump($response);                // See what RESTfm responded with.
if ($response['info']['X-RESTfm-Status'] != 200) {
    echo "RESTfm PUT did not complete successfully, exiting.\n";
    exit;
}

// GET (Read) 2 - To see record changes after Update:
echo "\nGET (Read) 2 the updated record: $recordID\n";
$response = array();                // Response array for result from RESTfm.
try {
    RESTfmClientLib::call($response, 'GET', $RESTfmDemoURI . '/' . $recordID . '.json');
} catch (Exception $e) {            // A cURL error will raise an exception.
    trigger_error(
        'cURL error (' . $e->getCode() . '): ' . $e->getMessage(),
        E_USER_ERROR
    );
}
var_dump($response);                // See what RESTfm responded with.
if ($response['info']['X-RESTfm-Status'] != 200) {
    echo "RESTfm GET 2 did not complete successfully, exiting.\n";
    exit;
}

// DELETE (Delete):
echo "\nDELETE (Delete) the record: $recordID\n";
$response = array();                // Response array for result from RESTfm.
try {
    RESTfmClientLib::call($response, 'DELETE', $RESTfmDemoURI . '/' . $recordID . '.json');
} catch (Exception $e) {            // A cURL error will raise an exception.
    trigger_error(
        'cURL error (' . $e->getCode() . '): ' . $e->getMessage(),
        E_USER_ERROR
    );
}
var_dump($response);                // See what RESTfm responded with.
if ($response['info']['X-RESTfm-Status'] != 200) {
    echo "RESTfm DELETE did not complete successfully, exiting.\n";
    exit;
}

exit;
