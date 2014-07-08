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

require_once 'RESTfmRequest.php';













class RESTfmParameters implements Iterator {





protected $_parameters = array();










public function getRegex($vc2ba79cb) {
$v4a33f3a9 = array();
foreach ($this->_parameters as $v5b476579 => $v07c32dc0) {
if (preg_match($vc2ba79cb, $v5b476579)) {
$v4a33f3a9[$v5b476579] = $v07c32dc0;
}
}
return $v4a33f3a9;
}










public function merge ($va46db7c8) {
$this->_parameters = array_merge($this->_parameters, $va46db7c8);
}












public function __get ($v5b476579) {
if (isset($this->_parameters[$v5b476579])) {
return $this->_parameters[$v5b476579];
}
return NULL;
}







public function __isset ($v5b476579) {
return isset($this->_parameters[$v5b476579]);
}









public function __set ($v5b476579, $v07c32dc0) {
$this->_parameters[$v5b476579] = $v07c32dc0;
}







public function __unset ($v5b476579) {
unset($this->_parameters[$v5b476579]);
}




public function __toString () {
$v5574bc24 = '';
foreach ($this->_parameters as $v5b476579 => $v07c32dc0) {
$v5574bc24 .= $v5b476579 . '="' . addslashes($v07c32dc0) . '"' . "\n";
}
return $v5574bc24;
}



public function current() {
return current($this->_parameters);
}

public function key() {
return key($this->_parameters);
}

public function next() {
return next($this->_parameters);
}

public function rewind() {
return reset($this->_parameters);
}

public function valid() {
return key($this->_parameters) !== NULL;
}

};
