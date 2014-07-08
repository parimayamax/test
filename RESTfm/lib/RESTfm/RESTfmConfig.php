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




class RESTfmConfig {




private static $vb3b7161d;

const CONFIG_INI = 'RESTfm.ini.php';






public static function getConfig() {
if (!self::$vb3b7161d) {
include_once self::CONFIG_INI;
self::$vb3b7161d = $config;
}

return self::$vb3b7161d;
}





















public static function getVar() {

 if (func_num_args() < 1) {
return NULL;
}


 $v9159e740 = RESTfmConfig::getConfig();


 foreach(func_get_args() as $v2ce3afdf) {
if (! isset($v9159e740[$v2ce3afdf])) {
return NULL;
}
$v9159e740 = $v9159e740[$v2ce3afdf];
}

return $v9159e740;
}






public static function getFormats() {
if (!self::$vb3b7161d) {
self::getConfig();
}
return self::$vb3b7161d['settings']['formats'];
}

}
