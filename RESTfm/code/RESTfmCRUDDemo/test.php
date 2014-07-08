<?php
	$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
	$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
	$offset = ($page-1)*$rows;
	$result = array();
	
	require_once('../RESTfmClientLib/RESTfmClientLib.php');
	
// Username:Password for RESTfm demo site, find current credentials here:
// http://www.restfm.com/demo
$credentials = 'adminP:ctiuser';

// RESTfm demonstration URI
$RESTfmDemoURI = 'http://' . $credentials . '@localhost/RESTfm/CTI_REG_web/layout/Web%20Event';


// *** Main *** //
//echo "<pre>\n";

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

 

$homepage = file_get_contents('http://192.168.1.140/RESTfm/CTI_REG_web/layout/Web%20Event.json?&RFMmax=15&RFMsF1=ev_date_d&RFMsV1=>06%2F20%2F2014');
  
//var_dump($response);                // See what RESTfm responded with.
//print_r($response);
//print_r($response['data']);
/*if ($response['info']['X-RESTfm-Status'] != 201) {
    echo "RESTfm POST did not complete successfully, exiting.\n";
    exit;
}
*/
/*print_r($response['nav']);
print_r($response['data']);*/
 $obj = json_decode($homepage);
$rs_data=$obj->{'data'};

$totalrecords=count($obj->{'data'});
$result["total"] = $totalrecords;
$items = array();

	 for($k=0;$k<count($rs_data);$k++){
		 if($rs_data[$k]){
		array_push($items,$rs_data[$k]);
		 }
	}
	$result["rows"] = $items;
	 
	 echo json_encode($result);
	
	

 
?>