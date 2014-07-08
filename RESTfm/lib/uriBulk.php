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
require_once 'RESTfm/RESTfmParameters.php';
require_once 'RESTfm/RESTfmData.php';
require_once 'RESTfm/BackendFactory.php';









class uriBulk extends RESTfmResource {

const URI = '/{database}/bulk/{layout}';
























function post($request, $vc1601e44, $v0df5ea79) {
$vc1601e44 = RESTfmUrl::decode($vc1601e44);
$v0df5ea79 = RESTfmUrl::decode($v0df5ea79);

$vc83160b8 = BackendFactory::make($request, $vc1601e44);

$v5fae05d8 = $vc83160b8->makeOpsRecord($vc1601e44, $v0df5ea79);

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

$v9adcfedf->setData($v1736fd6e);

if ($v1736fd6e->sectionExists('multistatus')) {
$v9adcfedf->setStatus(207, 'Multi-status');
} else {
$v9adcfedf->setStatus(Response::OK);
}

return $v9adcfedf;
}













function get($request, $vc1601e44, $v0df5ea79) {
$vc1601e44 = RESTfmUrl::decode($vc1601e44);
$v0df5ea79 = RESTfmUrl::decode($v0df5ea79);

$vc83160b8 = BackendFactory::make($request, $vc1601e44);

$v5fae05d8 = $vc83160b8->makeOpsRecord($vc1601e44, $v0df5ea79);

$v1736fd6e = $v5fae05d8->read($request->getRESTfmData());

$v9adcfedf = new RESTfmResponse($request);

$v9adcfedf->setData($v1736fd6e);

if ($v1736fd6e->sectionExists('multistatus')) {
$v9adcfedf->setStatus(207, 'Multi-status');
} else {
$v9adcfedf->setStatus(Response::OK);
}

return $v9adcfedf;
}

























function put($request, $vc1601e44, $v0df5ea79) {
$vc1601e44 = RESTfmUrl::decode($vc1601e44);
$v0df5ea79 = RESTfmUrl::decode($v0df5ea79);

$vc83160b8 = BackendFactory::make($request, $vc1601e44);

$v5fae05d8 = $vc83160b8->makeOpsRecord($vc1601e44, $v0df5ea79);

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
if (isset($ve59aa5e2->RFMelsePOST)) {
$v5fae05d8->setUpdateElseCreate();
}

$v1736fd6e = $v5fae05d8->update($request->getRESTfmData());

$v9adcfedf = new RESTfmResponse($request);

$v9adcfedf->setData($v1736fd6e);

if ($v1736fd6e->sectionExists('multistatus')) {
$v9adcfedf->setStatus(207, 'Multi-status');
} else {
$v9adcfedf->setStatus(Response::OK);
}

return $v9adcfedf;
}













function delete($request, $vc1601e44, $v0df5ea79) {
$vc1601e44 = RESTfmUrl::decode($vc1601e44);
$v0df5ea79 = RESTfmUrl::decode($v0df5ea79);

$vc83160b8 = BackendFactory::make($request, $vc1601e44);

$v5fae05d8 = $vc83160b8->makeOpsRecord($vc1601e44, $v0df5ea79);

$v1736fd6e = $v5fae05d8->delete($request->getRESTfmData());

$v9adcfedf = new RESTfmResponse($request);

$v9adcfedf->setData($v1736fd6e);

if ($v1736fd6e->sectionExists('multistatus')) {
$v9adcfedf->setStatus(207, 'Multi-status');
} else {
$v9adcfedf->setStatus(Response::OK);
}

return $v9adcfedf;
}
};
