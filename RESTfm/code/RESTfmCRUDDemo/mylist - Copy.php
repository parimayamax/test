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
$credentials = 'Admin:';

// RESTfm demonstration URI
$RESTfmDemoURI = 'http://' . $credentials . '@localhost/RESTfm/FMPHP_Sample/layout/Form%20View';

// *** Main *** //
echo "<pre>\n";

$response = array();                // Response array for result from RESTfm. 
try {
    RESTfmClientLib::call($response, 'GET', $RESTfmDemoURI . '.json', $data);
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




exit;
