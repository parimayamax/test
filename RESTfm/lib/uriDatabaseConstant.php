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









class uriDatabaseConstant extends RESTfmResource {

const URI = '/{database}';










function get($request, $vc1601e44) {
$vc1601e44 = RESTfmUrl::decode($vc1601e44);


 
 $vc83160b8 = BackendFactory::make($request, $vc1601e44);
$v85e2c809 = $vc83160b8->makeOpsDatabase($vc1601e44);
$va6ce5557 = $v85e2c809->readLayouts();

$v32a0cc19 = new RESTfmQueryString(TRUE);

$v9adcfedf = new RESTfmResponse($request);
$v20ae8ce5 = $v9adcfedf->format;


 $v1736fd6e = new RESTfmDataSimple();
$v1736fd6e->pushDataRow( array('resource' => 'layout'), NULL,
$request->baseUri.'/'.RESTfmUrl::encode($vc1601e44).'/layout.'.$v20ae8ce5.$v32a0cc19->build() );
if (RESTfmConfig::getVar('settings', 'diagnostics') === TRUE) {
$v1736fd6e->pushDataRow( array('resource' => 'echo'), NULL,
$request->baseUri.'/'.RESTfmUrl::encode($vc1601e44).'/echo.'.$v20ae8ce5.$v32a0cc19->build() );
}
$v1736fd6e->pushDataRow( array('resource' => 'script'), NULL,
$request->baseUri.'/'.RESTfmUrl::encode($vc1601e44).'/script.'.$v20ae8ce5.$v32a0cc19->build() );

$v9adcfedf->setStatus(Response::OK);
$v9adcfedf->setData($v1736fd6e);
return $v9adcfedf;
}

};
