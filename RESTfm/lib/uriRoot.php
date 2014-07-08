<?php
/**
 * @copyright
 * © 2011-2014 Goya Pty Ltd.
 *
 * @license
 * This file is subject to the Goya Software License contained in the LICENSE
 * file distributed with this package.
 *
 * @author
 *  Gavin Stewart
 */

require_once 'RESTfm/RESTfmResource.php';
require_once 'RESTfm/RESTfmResponse.php';
require_once 'RESTfm/QueryString.php';






class uriRoot extends RESTfmResource {

const URI = '';














function get($request) {
$vc83160b8 = BackendFactory::make($request);
$v85e2c809 = $vc83160b8->makeOpsDatabase();
$v1736fd6e = $v85e2c809->readDatabases();

$v32a0cc19 = new RESTfmQueryString(TRUE);

$v9adcfedf = new RESTfmResponse($request);
$v20ae8ce5 = $v9adcfedf->format;

$v666cb476 = NULL;
if (isset($v32a0cc19->RFMlink)) {
$v666cb476 = $v32a0cc19->RFMlink;
unset($v32a0cc19->RFMlink);
}


 
 $v1736fd6e->setIteratorSection('data');
foreach($v1736fd6e as $v5ae87d2c => $v5969e3f1) {
$vc1601e44 = $v5969e3f1['database'];
$ved7b4d72 = $request->baseUri.'/'.RESTfmUrl::encode($vc1601e44).'.'.$v20ae8ce5.$v32a0cc19->build();
if (isset($v666cb476)) {
if ($v666cb476 == 'layout') {
$ved7b4d72 = $request->baseUri.'/'.RESTfmUrl::encode($vc1601e44).'/layout.'.$v20ae8ce5.$v32a0cc19->build();
} elseif ($v666cb476 == 'script') {
$ved7b4d72 = $request->baseUri.'/'.RESTfmUrl::encode($vc1601e44).'/script.'.$v20ae8ce5.$v32a0cc19->build();
}
}

$v1736fd6e->setSectionData2nd('meta', $v5ae87d2c, 'href', $ved7b4d72);
}

$v9adcfedf->setStatus(Response::OK);
$v9adcfedf->setData($v1736fd6e);
return $v9adcfedf;
}

};
