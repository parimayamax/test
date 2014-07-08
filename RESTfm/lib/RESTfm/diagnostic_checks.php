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


if (strpos($_SERVER['QUERY_STRING'], 'RFMversion') !== FALSE) {
throw new ResponseException(Version::getVersion(), Response::OK);
}



if (strpos($_SERVER['QUERY_STRING'], 'RFMcheckFMAPI') !== FALSE) {
require_once 'FileMaker.php';

$v2c0fa6e0 = new ReflectionClass('FileMaker');

$v5574bc24 = '';
$v5574bc24 .= 'FileMaker API found at path      : ' . $v2c0fa6e0->getFileName() . "\n";
$v5574bc24 .= 'Compatible with FileMaker Server : ';
if ($v2c0fa6e0->hasMethod('getContainerDataURL')) {
$v5574bc24 .= '12,13';
} else {
$v5574bc24 .= '11'; 
 }

throw new ResponseException($v5574bc24, Response::OK);
}
