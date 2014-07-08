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






class uriDatabaseLayout extends RESTfmResource {

const URI = '/{database}/layout';










function get($request, $vc1601e44) {
$vc1601e44 = RESTfmUrl::decode($vc1601e44);

$vc83160b8 = BackendFactory::make($request, $vc1601e44);
$v85e2c809 = $vc83160b8->makeOpsDatabase($vc1601e44);
$v1736fd6e = $v85e2c809->readLayouts();

$v32a0cc19 = new QueryString(TRUE);

$v9adcfedf = new RESTfmResponse($request);
$v20ae8ce5 = $v9adcfedf->format;


 
 $v1736fd6e->setIteratorSection('data');
foreach($v1736fd6e as $v5ae87d2c => $v5969e3f1) {
$ved7b4d72 = $request->baseUri.'/'.
RESTfmUrl::encode($vc1601e44).
'/layout/'.RESTfmUrl::encode($v5969e3f1['layout']).'.'.$v20ae8ce5.
$v32a0cc19->build();

$v1736fd6e->setSectionData2nd('meta', $v5ae87d2c, 'href', $ved7b4d72);
}

$v9adcfedf->setStatus(Response::OK);
$v9adcfedf->setData($v1736fd6e);
return $v9adcfedf;
}
}
