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






class uriDatabaseScript extends RESTfmResource {

const URI = '/{database}/script';










function get(Request $request, $vc1601e44) {
$vc1601e44 = RESTfmUrl::decode($vc1601e44);

$vc83160b8 = BackendFactory::make($request, $vc1601e44);
$v85e2c809 = $vc83160b8->makeOpsDatabase($vc1601e44);
$v1736fd6e = $v85e2c809->readScripts();

$v9adcfedf = new RESTfmResponse($request);

$v9adcfedf->setStatus(Response::OK);
$v9adcfedf->setData($v1736fd6e);
return $v9adcfedf;
}

};
