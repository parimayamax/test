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

require_once 'QueryString.php';
require_once 'RFMfixFM01.php';
require_once 'RFMfixFM02.php';









class RESTfmUrl {




const none = 0,
RFMfixFM01 = 1,
RFMfixFM02 = 2;




protected static $_encoding = self::none;










public static function encode ($v8e9f3b97) {
switch (self::$_encoding) {
case self::RFMfixFM01:
return rawurlencode(RFMfixFM01::preEncode($v8e9f3b97));
case self::RFMfixFM02:
return rawurlencode(RFMfixFM02::preEncode($v8e9f3b97));
default:
return rawurlencode($v8e9f3b97);
}
}








public static function decode ($v8e9f3b97) {
switch (self::$_encoding) {
case self::RFMfixFM01:
return RFMfixFM01::postDecode(urldecode($v8e9f3b97));
case self::RFMfixFM02:
return RFMfixFM02::postDecode(urldecode($v8e9f3b97));
default:
return urldecode($v8e9f3b97);
}
}







public function setEncoding ($vb2d73cf6) {
self::$_encoding = $vb2d73cf6;
}




public function getEncoding () {
return self::$_encoding;
}

};
