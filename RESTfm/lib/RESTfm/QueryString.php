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




class QueryString {




protected $_data = array();








public function __construct($v63bb8f65 = FALSE) {
if ($v63bb8f65) {
$this->fromServer();
}
}




public function fromServer() {
$this->parse_str($_SERVER['QUERY_STRING'], $this->_data);
}




public function toServer() {
$_SERVER['QUERY_STRING'] = $this->build(FALSE);
}










public function parse_str($v8e9f3b97, &$v67c4ec2e) {
if (empty($v8e9f3b97)) {
return;
}
$v724c9eae = explode('&', $v8e9f3b97);
foreach ($v724c9eae as $vd7ebe724) {
if (empty($vd7ebe724)) {
continue;
}
$v0f8c181d = explode('=', $vd7ebe724);
$v0f6a519e = $this->_urldecode($v0f8c181d[0]);
if (isset($v0f8c181d[1])) {
$v67c4ec2e[$v0f6a519e] = $this->_urldecode($v0f8c181d[1]);
} else {
$v67c4ec2e[$v0f6a519e] = '';
}
}
}




protected function _urldecode ($v8e9f3b97) {
return urldecode($v8e9f3b97);
}












public function build($va2ed5cd0 = TRUE) {
$v7c49e007 = http_build_query($this->_data);
if ($va2ed5cd0 && !empty($v7c49e007)) {
$v7c49e007 = '?'.$v7c49e007;
}
return $v7c49e007;
}










public function __get($v5b476579) {
if (isset($this->_data[$v5b476579])) {
return $this->_data[$v5b476579];
}
return NULL;
}







public function __isset($v5b476579) {
return isset($this->_data[$v5b476579]);
}









public function __set($v5b476579, $v07c32dc0) {
if ($v07c32dc0 == NULL) {
unset($this->_data[$v5b476579]);
} else {
$this->_data[$v5b476579] = $v07c32dc0;
}
}







public function __unset($v5b476579) {
unset($this->_data[$v5b476579]);
}










public function getRegex($vc2ba79cb) {
$v4a33f3a9 = array();
foreach ($this->_data as $v5b476579 => $v07c32dc0) {
if (preg_match($vc2ba79cb, $v5b476579)) {
$v4a33f3a9[$v5b476579] = $v07c32dc0;
}
}
return $v4a33f3a9;
}







public function setAll($va46db7c8) {
$this->_data = $va46db7c8;
}







public function unsetRegex($vc2ba79cb) {
foreach (array_keys($this->_data) as $v5b476579) {
if (preg_match($vc2ba79cb, $v5b476579)) {
unset($this->_data[$v5b476579]);
}
}
}

};
