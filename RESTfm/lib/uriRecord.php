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
require_once 'RESTfm/RESTfmQueryString.php';
require_once 'RESTfm/RESTfmData.php';






class uriRecord extends RESTfmResource {

const URI = '/{database}/layout/{layout}/{rawRecordID}';














function get($request, $vc1601e44, $v0df5ea79, $vd5b4f949) {
$vc1601e44 = RESTfmUrl::decode($vc1601e44);
$v0df5ea79 = RESTfmUrl::decode($v0df5ea79);
$vd5b4f949 = RESTfmUrl::decode($vd5b4f949);

$vc83160b8 = BackendFactory::make($request, $vc1601e44);

$v5fae05d8 = $vc83160b8->makeOpsRecord($vc1601e44, $v0df5ea79);
$v5fae05d8->setSingle(TRUE);

$v29d016a4 = new RESTfmData();
$v29d016a4->setSectionData('meta', $vd5b4f949, array('recordID' => $vd5b4f949));
$v1736fd6e = $v5fae05d8->read($v29d016a4);

$v9adcfedf = new RESTfmResponse($request);
$v20ae8ce5 = $v9adcfedf->format;


 
 $v1736fd6e->setIteratorSection('meta');
foreach($v1736fd6e as $v5ae87d2c => $v5969e3f1) {
$ved7b4d72 = $request->baseUri.'/'.
RESTfmUrl::encode($vc1601e44).'/layout/'.
RESTfmUrl::encode($v0df5ea79).'/'.
RESTfmUrl::encode($v5969e3f1['recordID']).'.'.$v20ae8ce5;
$v1736fd6e->setSectionData2nd('meta', $v5ae87d2c, 'href', $ved7b4d72);
}

$v9adcfedf->setData($v1736fd6e);
$v9adcfedf->setStatus(Response::OK);
return $v9adcfedf;
}




























function put($request, $vc1601e44, $v0df5ea79, $vd5b4f949) {
$vc1601e44 = RESTfmUrl::decode($vc1601e44);
$v0df5ea79 = RESTfmUrl::decode($v0df5ea79);
$vd5b4f949 = RESTfmUrl::decode($vd5b4f949);

$vc83160b8 = BackendFactory::make($request, $vc1601e44);

$v5fae05d8 = $vc83160b8->makeOpsRecord($vc1601e44, $v0df5ea79);
$v5fae05d8->setSingle(TRUE);

$ve59aa5e2 = $request->getRESTfmParameters();


 if (isset($ve59aa5e2->RFMscript)) {
$v5049c6f5 = NULL;
if (isset($ve59aa5e2->RFMscriptParam)) {
$v5049c6f5 = $ve59aa5e2->RFMscriptParam;
}
$v5fae05d8->setPostOpScript($ve59aa5e2->RFMscript, $v5049c6f5);
}
if (isset($ve59aa5e2->RFMpreScript)) {
$v5049c6f5 = NULL;
if (isset($ve59aa5e2->RFMpreScriptParam)) {
$v5049c6f5 = $ve59aa5e2->RFMpreScriptParam;
}
$v5fae05d8->setPreOpScript($ve59aa5e2->RFMpreScript, $v5049c6f5);
}
if (isset($ve59aa5e2->RFMappend)) {
$v5fae05d8->setAppend();
}
if (isset($ve59aa5e2->RFMelsePOST)) {
$v5fae05d8->setUpdateElseCreate();
}


 
 $v29d016a4 = $request->getRESTfmData();
$v29d016a4->setSectionData2nd('meta', 0, 'recordID', $vd5b4f949);

$v1736fd6e = $v5fae05d8->update($v29d016a4);

$v9adcfedf = new RESTfmResponse($request);
$v20ae8ce5 = $v9adcfedf->format;


 
 $v1736fd6e->setIteratorSection('meta');
foreach($v1736fd6e as $v5ae87d2c => $v5969e3f1) {
$ved7b4d72 = $request->baseUri.'/'.
RESTfmUrl::encode($vc1601e44).'/layout/'.
RESTfmUrl::encode($v0df5ea79).'/'.
RESTfmUrl::encode($v5969e3f1['recordID']).'.'.$v20ae8ce5;
$v1736fd6e->setSectionData2nd('meta', $v5ae87d2c, 'href', $ved7b4d72);
}

$v9adcfedf->setData($v1736fd6e);
$v9adcfedf->setStatus(Response::OK);
return $v9adcfedf;
}
























function delete($request, $vc1601e44, $v0df5ea79, $vd5b4f949) {
$vc1601e44 = RESTfmUrl::decode($vc1601e44);
$v0df5ea79 = RESTfmUrl::decode($v0df5ea79);
$vd5b4f949 = RESTfmUrl::decode($vd5b4f949);

$vc83160b8 = BackendFactory::make($request, $vc1601e44);

$v5fae05d8 = $vc83160b8->makeOpsRecord($vc1601e44, $v0df5ea79);
$v5fae05d8->setSingle(TRUE);

$ve59aa5e2 = $request->getRESTfmParameters();


 if (isset($ve59aa5e2->RFMscript)) {
$v5049c6f5 = NULL;
if (isset($ve59aa5e2->RFMscriptParam)) {
$v5049c6f5 = $ve59aa5e2->RFMscriptParam;
}
$v5fae05d8->setPostOpScript($ve59aa5e2->RFMscript, $v5049c6f5);
}
if (isset($ve59aa5e2->RFMpreScript)) {
$v5049c6f5 = NULL;
if (isset($ve59aa5e2->RFMpreScriptParam)) {
$v5049c6f5 = $ve59aa5e2->RFMpreScriptParam;
}
$v5fae05d8->setPreOpScript($ve59aa5e2->RFMpreScript, $v5049c6f5);
}


 
 $v29d016a4 = $request->getRESTfmData();
$v29d016a4->setSectionData2nd('meta', 0, 'recordID', $vd5b4f949);

$v1736fd6e = $v5fae05d8->delete($v29d016a4);

$v9adcfedf = new RESTfmResponse($request);
$v9adcfedf->setData($v1736fd6e);
$v9adcfedf->setStatus(Response::OK);
return $v9adcfedf;
}
}
