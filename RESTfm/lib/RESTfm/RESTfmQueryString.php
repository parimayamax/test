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




class RESTfmQueryString extends QueryString {




const none = 0,
RFMfixFM01 = 1,
RFMfixFM02 = 2;





protected $_encoding = NULL;











public function fromServer() {

 if ($this->_encoding === NULL) {

 if (strpos($_SERVER['QUERY_STRING'], 'RFMfixFM01') !== FALSE) {
$this->_encoding = self::RFMfixFM01;
}


 if (strpos($_SERVER['QUERY_STRING'], 'RFMfixFM02') !== FALSE) {
$this->_encoding = self::RFMfixFM02;
}
}

$this->parse_str($_SERVER['QUERY_STRING'], $this->_data);
}







public function setEncoding ($vb2d73cf6) {
$this->_encoding = $vb2d73cf6;
}




public function getEncoding () {
return $this->_encoding;
}






protected function _urldecode($v8e9f3b97) {
switch ($this->_encoding) {
case self::RFMfixFM01:
return RFMfixFM01::postDecode(urldecode($v8e9f3b97));
case self::RFMfixFM02:
return RFMfixFM02::postDecode(urldecode($v8e9f3b97));
default:
return urldecode($v8e9f3b97);
}
}


















public function buildEncoded($va2ed5cd0 = TRUE) {
$v39e38486 = array();
foreach ($this->_data as $v5b476579 => $v6704d97a) {
switch ($this->_encoding) {
case self::RFMfixFM01:
$v5b476579 = rawurlencode(RFMfixFM01::preEncode($v5b476579));
$v6704d97a = rawurlencode(RFMfixFM01::preEncode($v6704d97a));
break;
case self::RFMfixFM02:
$v5b476579 = rawurlencode(RFMfixFM02::preEncode($v5b476579));
$v6704d97a = rawurlencode(RFMfixFM02::preEncode($v6704d97a));
break;
}
$v39e38486[] = $v5b476579 . '=' . $v6704d97a;
}

$v7c49e007 = implode('&', $v39e38486);
if ($va2ed5cd0 && !empty($v7c49e007)) {
$v7c49e007 = '?'.$v7c49e007;
}
return $v7c49e007;
}

};
