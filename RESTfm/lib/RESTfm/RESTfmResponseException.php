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

require_once 'RESTfmResponse.php';
require_once 'RESTfmConfig.php';




class RESTfmResponseException extends ResponseException {




const OK = 200,
CREATED = 201,
NOCONTENT = 204,
MOVEDPERMANENTLY = 301,
FOUND = 302,
SEEOTHER = 303,
NOTMODIFIED = 304,
TEMPORARYREDIRECT = 307,
BADREQUEST = 400,
UNAUTHORIZED = 401,
FORBIDDEN = 403,
NOTFOUND = 404,
METHODNOTALLOWED = 405,
NOTACCEPTABLE = 406,
CONFLICT = 409,
GONE = 410,
LENGTHREQUIRED = 411,
PRECONDITIONFAILED = 412,
UNSUPPORTEDMEDIATYPE = 415,
INTERNALSERVERERROR = 500;









public function __construct ($vd231b921, $vb2bb6b87 = 0, Exception $v4409e253 = null) {

if (RESTfmConfig::getVar('settings', 'diagnostics') === TRUE) {
$this->addInfo('X-RESTfm-Trace', $this->__toSTring());
}


 if (version_compare(phpversion(), '5.3.0', '>=')) {
parent::__construct($vd231b921, $vb2bb6b87, $v4409e253);
} else {
parent::__construct($vd231b921, $vb2bb6b87);
}
}








public function response($request) {

$v9adcfedf = new RESTfmResponse($request);

foreach ($this->_addHeader as $vb81d8ef0 => $v07c32dc0) {
$v9adcfedf->addHeader($vb81d8ef0, $v07c32dc0);
}

foreach ($this->_addInfo as $vb81d8ef0 => $v07c32dc0) {
$v9adcfedf->addInfo($vb81d8ef0, $v07c32dc0);
}

$v9adcfedf->setStatus($this->code, $this->message);

return $v9adcfedf;
}







protected $_addHeader = array();






protected $_addInfo = array();











protected function addHeader($veb10a0ab, $v07c32dc0) {
$this->_addHeader[$veb10a0ab] = $v07c32dc0;
}







protected function addInfo($vb81d8ef0, $v07c32dc0) {
$this->_addInfo[$vb81d8ef0] = $v07c32dc0;
}

};
