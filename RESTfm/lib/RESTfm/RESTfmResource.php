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

require_once 'RESTfmResponse.php' ;
require_once 'RESTfmConfig.php';






class RESTfmResource extends Resource {




function __construct($vcc4bee18) {

 parent::__construct($vcc4bee18);
}














function exec($request) {

if (strtoupper($request->method) != 'OPTIONS') {

 return parent::exec($request);
}


 
 
 

$v9adcfedf = new RESTfmResponse($request);

if (! isset($_SERVER["HTTP_ORIGIN"])) {
throw new RESTfmResponseException('Invalid request for OPTIONS method.', Response::BADREQUEST);
}


 $v7bbfa6fd = $_SERVER['HTTP_ORIGIN'];
$v0e474482 = null;
$ve98d4810 = RESTfmConfig::getVar('allowed_origins');
if (is_array($ve98d4810)) {
if (in_array('*', $ve98d4810)) {
$v0e474482 = '*';
} else {

 foreach ($ve98d4810 as $v9fd7f9c9) {
if (strtolower($v7bbfa6fd) == strtolower($v9fd7f9c9)) {
$v0e474482 = $v7bbfa6fd;
}
}
}
}
if ($v0e474482 == null) {
throw new RESTfmResponseException('Origin forbidden: ' . $v7bbfa6fd, Response::FORBIDDEN);
}
$v9adcfedf->addHeader('Access-Control-Allow-Origin', $v0e474482);

$v3bb789e3 = $request->allowedMethods;
$v3bb789e3[] = 'OPTIONS';
$v9adcfedf->addHeader('Access-Control-Allow-Methods', join(', ', $v3bb789e3));

if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS'])) {
$v9adcfedf->addHeader('Access-Control-Allow-Headers', $_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']);
}

$v9adcfedf->addHeader('Access-Control-Max-Age', 3600);

$v9adcfedf->code = Response::OK;

return $v9adcfedf;
}















protected function _convertValuesToRepetitions ($ve2e1cd17) {

 
 
 
 
 
 
 
 
 
 
 $v4d405766 = array();
foreach ($ve2e1cd17 as $v9d7ecd38 => $v07c32dc0) {
$v03219630 = array();
if (preg_match('/^(.+)\[(\d+)\]$/', $v9d7ecd38, $v03219630)) {
$v9d7ecd38 = $v03219630[1]; 
 $v35fdae2f = intval($v03219630[2]);


 if ( isset($v4d405766[$v9d7ecd38]) &&
is_array($v4d405766[$v9d7ecd38]) ) {
$vd44270c6 = $v4d405766[$v9d7ecd38];
} else {
$vd44270c6 = array();
}

$vd44270c6[$v35fdae2f] = $v07c32dc0;
$v4d405766[$v9d7ecd38] = $vd44270c6;
} else {
$v4d405766[$v9d7ecd38] = $v07c32dc0;
}
}

return $v4d405766;
}

}
