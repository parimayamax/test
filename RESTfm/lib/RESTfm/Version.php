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




class Version {
private static $v4ae20e97 = '3.0.3beta';
private static $v33f1bdb4 = '461';
private static $vc18602a2 = '5'; 

public static function getRelease() {
return self::$v4ae20e97;
}

public static function getRevision() {
return self::$v33f1bdb4;
}

public static function getVersion() {
$vd2074ffd = 'r'.self::$v33f1bdb4;
if (strpos($vd2074ffd, 'REVISION') !== FALSE) {
$vd2074ffd = 'UNKNOWN';
}

return self::$v4ae20e97 . '/' . $vd2074ffd;
}

public static function getProtocol() {
return self::$vc18602a2;
}
}



if (php_sapi_name() == "cli") {
global $argv;

if (count($argv) > 1) {
switch($argv[1]) {
case '-r':
echo Version::getRelease();
return;

case '-p':
echo Version::getProtocol();
return;
}
}

echo Version::getVersion();
}
