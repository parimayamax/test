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
require_once 'RESTfm/RESTfmDataSimple.php';






class uriLayout extends RESTfmResource {

const URI = '/{database}/layout/{layout}';






































function get($request, $vc1601e44, $v0df5ea79) {
$vc1601e44 = RESTfmUrl::decode($vc1601e44);
$v0df5ea79 = RESTfmUrl::decode($v0df5ea79);

$vc83160b8 = BackendFactory::make($request, $vc1601e44);
$v2223bf33 = $vc83160b8->makeOpsLayout($vc1601e44, $v0df5ea79);
$ve59aa5e2 = $request->getRESTfmParameters();

if (isset($ve59aa5e2->RFMmetaFieldOnly)) {
$v1736fd6e = $v2223bf33->readMetaField();
$v9adcfedf = new RESTfmResponse($request);
$v9adcfedf->setStatus(Response::OK);
$v9adcfedf->setData($v1736fd6e);
return $v9adcfedf;
}


 $ve88e64ff = $ve59aa5e2->getRegex('/^RFMsF\d+$/');
$v31fd695c = $ve59aa5e2->getRegex('/^RFMsV\d+$/');
if (count($ve88e64ff) > 0) {
foreach ($ve88e64ff as $v817793e5 => $v3a5f3cb9) {

 $va41e7616 = str_replace('RFMsF', 'RFMsV', $v817793e5);
if (isset($v31fd695c[$va41e7616])) {
$v2223bf33->addFindCriterion($v3a5f3cb9, $v31fd695c[$va41e7616]);
}
}
}


 if (isset($ve59aa5e2->RFMscript)) {
$v5049c6f5 = NULL;
if (isset($ve59aa5e2->RFMscriptParam)) {
$v5049c6f5 = $ve59aa5e2->RFMscriptParam;
}
$v2223bf33->setPostOpScript($ve59aa5e2->RFMscript, $v5049c6f5);
}
if (isset($ve59aa5e2->RFMpreScript)) {
$v5049c6f5 = NULL;
if (isset($ve59aa5e2->RFMpreScriptParam)) {
$v5049c6f5 = $ve59aa5e2->RFMpreScriptParam;
}
$v2223bf33->setPreOpScript($ve59aa5e2->RFMpreScript, $v5049c6f5);
}


 $v54fee726 = $ve59aa5e2->RFMskip;
$v3a311317 = $ve59aa5e2->RFMmax;
$v54fee726 = isset($v54fee726) ? $v54fee726 : 0;
$v54fee726 = ($v54fee726 === 'end') ? -1 : $v54fee726;
$v3a311317 = isset($v3a311317) ? $v3a311317 : 24;
$v2223bf33->setLimit($v54fee726, $v3a311317);


 $v1736fd6e = $v2223bf33->read();

$v59f8b86f = $v1736fd6e->getSectionData('info', 'foundSetCount');


 if ($v54fee726 == -1) {
$v54fee726 = $v59f8b86f - $v3a311317;
$v54fee726 = max(0, $v54fee726); 
 }


 if ($v54fee726 > $v59f8b86f) {
$v54fee726 = $v59f8b86f;
}


 $v1736fd6e->pushInfo('skip', $v54fee726);

$v9adcfedf = new RESTfmResponse($request);
$v20ae8ce5 = $v9adcfedf->format;
$v32a0cc19 = new RESTfmQueryString(TRUE);

$v7eaa4165 = RESTfmUrl::encode($vc1601e44);
$v3217b5a6 = RESTfmUrl::encode($v0df5ea79);


 
 $v1736fd6e->setIteratorSection('meta');
foreach($v1736fd6e as $v5ae87d2c => $v5969e3f1) {
$ved7b4d72 = $request->baseUri.'/'.
$v7eaa4165.'/layout/'.
$v3217b5a6.'/'.
RESTfmUrl::encode($v5969e3f1['recordID']).'.'.$v20ae8ce5;
$v1736fd6e->setSectionData2nd('meta', $v5ae87d2c, 'href', $ved7b4d72);
}


 


 $va3c28276 = max(0, $v54fee726 - $v3a311317);
$v83c59001 = $v1736fd6e->getSectionData('info', 'fetchCount');
$vcc1198c0 = $v54fee726 + $v83c59001;


 unset($v32a0cc19->RFMskip);
$v1736fd6e->pushNav('start',
$request->baseUri.'/'.
$v7eaa4165.'/layout/'.
$v3217b5a6.'.'.$v20ae8ce5.$v32a0cc19->build()
);


 if ($v54fee726 != 0) {
$v32a0cc19->RFMskip = $va3c28276;
$v1736fd6e->pushNav('prev',
$request->baseUri.'/'.
$v7eaa4165.'/layout/'.
$v3217b5a6.'.'.$v20ae8ce5.$v32a0cc19->build()
);
}


 if ($vcc1198c0 < $v59f8b86f) {
$v32a0cc19->RFMskip = $vcc1198c0;
$v1736fd6e->pushNav('next',
$request->baseUri.'/'.
$v7eaa4165.'/layout/'.
$v3217b5a6.'.'.$v20ae8ce5.$v32a0cc19->build()
);
}


 $v32a0cc19->RFMskip = 'end';
$v1736fd6e->pushNav('end',
$request->baseUri.'/'.
$v7eaa4165.'/layout/'.
$v3217b5a6.'.'.$v20ae8ce5.$v32a0cc19->build()
);


$v9adcfedf->setStatus(Response::OK);
$v9adcfedf->setData($v1736fd6e);
return $v9adcfedf;
}




















function post($request, $vc1601e44, $v0df5ea79) {
$vc1601e44 = RESTfmUrl::decode($vc1601e44);
$v0df5ea79 = RESTfmUrl::decode($v0df5ea79);

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

if (isset($ve59aa5e2->RFMsuppressData)) {
$v5fae05d8->setSuppressData(TRUE);
}

$v1736fd6e = $v5fae05d8->create($request->getRESTfmData());

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
$v9adcfedf->setStatus(Response::CREATED);
return $v9adcfedf;
}

}
