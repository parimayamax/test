<?php
require_once('../RESTfmClientLib/RESTfmClientLib.php');
	
// Username:Password for RESTfm demo site, find current credentials here:
// http://www.restfm.com/demo
$credentials = 'adminP:ctiuser';

// RESTfm demonstration URI
//$RESTfmDemoURI = 'http://' . $credentials . '@localhost/RESTfm/CTI_REG_web/layout/Web%20Event';

$RESTfmDemoURI = 'http://' . $credentials . '@localhost/RESTfm/CTI_REG_web/layout/Web%20Event';

 

//postcodes/layout/brief%20postcodes.json?RFMmax=2

// *** Main *** //
echo "<pre>\n";

$response = array();                // Response array for result from RESTfm. 
try {
   $get_array= RESTfmClientLib::call($response, 'GET', $RESTfmDemoURI . '.json', $data);
  // print_r($get_array[5]['meta']);
} catch (Exception $e) {            // A cURL error will raise an exception.
    trigger_error(
        'cURL error (' . $e->getCode() . '): ' . $e->getMessage(),
        E_USER_ERROR
    );
}



var_dump($response);                // See what RESTfm responded with.
//print_r($response);
//print_r($response['data']);
/*if ($response['info']['X-RESTfm-Status'] != 201) {
    echo "RESTfm POST did not complete successfully, exiting.\n";
    exit;
}
*/
echo  $totalrecords=count($response['data']);

?>