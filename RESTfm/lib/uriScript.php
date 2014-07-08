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






class uriScript extends RESTfmResource {

const URI = '/{database}/script/{script}/{layout}';























function get($request, $vc1601e44, $vc9d36bfe, $v0df5ea79) {
$vc1601e44 = RESTfmUrl::decode($vc1601e44);
$vc9d36bfe = RESTfmUrl::decode($vc9d36bfe);
$v0df5ea79 = RESTfmUrl::decode($v0df5ea79);

$vc83160b8 = BackendFactory::make($request, $vc1601e44);
$v5fae05d8 = $vc83160b8->makeOpsRecord($vc1601e44, $v0df5ea79);
$ve59aa5e2 = $request->getRESTfmParameters();

$v55701314 = NULL;
if (isset($ve59aa5e2->RFMscriptParam)) {
$v55701314 = $ve59aa5e2->RFMscriptParam;
}

if (isset($ve59aa5e2->RFMsuppressData)) {
$v5fae05d8->setSuppressData(TRUE);
}

$v1736fd6e = $v5fae05d8->callScript($vc9d36bfe, $v55701314);

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

};
