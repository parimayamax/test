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

require_once 'RESTfmConfig.php';
require_once 'RESTfmQueryString.php';
require_once 'FormatFactory.php';
require_once 'RESTfmDataSimple.php';




class RESTfmResponse extends Response {





public $format = 'html';





public $contentTypes = array (
'json' => 'application/json',
'html' => 'text/html',
'text' => 'text/plain',
'txt' => 'text/plain',
'xml' => 'text/xml; charset=UTF-8',
);





public $codeReason = array (
Response::OK => 'OK',
Response::CREATED => 'Created',
Response::NOCONTENT => 'No Content',
Response::MOVEDPERMANENTLY => 'Moved Permanently',
Response::FOUND => 'Found',
Response::SEEOTHER => 'See Other',
Response::NOTMODIFIED => 'Not Modified',
Response::TEMPORARYREDIRECT => 'Temporary Redirect',
Response::BADREQUEST => 'Bad Request',
Response::UNAUTHORIZED => 'Unauthorized',
Response::FORBIDDEN => 'Forbidden',
Response::NOTFOUND => 'Not Found',
Response::METHODNOTALLOWED => 'Method Not Allowed',
Response::NOTACCEPTABLE => 'Not Acceptable',
Response::CONFLICT => 'Conflict',
Response::GONE => 'Gone',
Response::LENGTHREQUIRED => 'Length Required',
Response::PRECONDITIONFAILED => 'Precondition Failed',
Response::UNSUPPORTEDMEDIATYPE => 'Unsupported Media Type',
Response::INTERNALSERVERERROR => 'Internal Server Error',
);









public function __construct($request, $v199e1319 = NULL) {
parent::__construct($request, $v199e1319);
$this->format = $request->mostAcceptable(RESTfmConfig::getFormats());


 
 
 $v32a0cc19 = new RESTfmQueryString(TRUE);
if(isset($v32a0cc19->RFMreauth)) {
$v0dd00068 = $request->getRESTfmCredentials()->getUsername();

 
 
 
 
 
 if ($v0dd00068 == urldecode($v32a0cc19->RFMreauth)) {
throw new ResponseException("User requested re-authorisation.", Response::UNAUTHORIZED);
}


 unset($v32a0cc19->RFMreauth);
$v32a0cc19->toServer();
}
}






public function contentType($format) {
if (isset($this->contentTypes[$format])) {
return $this->contentTypes[$format];
}


 return $this->contentTypes['text'];
}






public function output() {
$this->addHeader('X-RESTfm-Version', Version::getVersion());
$this->addHeader('X-RESTfm-Protocol', Version::getProtocol());
$this->addHeader('X-RESTfm-Status', $this->code);
$this->addHeader('X-RESTfm-Reason', $this->reason);
$this->addHeader('X-RESTfm-Method', $this->request->method);


 $ve98d4810 = RESTfmConfig::getVar('allowed_origins');
if (isset($_SERVER["HTTP_ORIGIN"]) && is_array($ve98d4810)) {
$v7bbfa6fd = $_SERVER['HTTP_ORIGIN'];
$v0e474482 = null;
if (in_array('*', $ve98d4810)) {
$v0e474482 = '*';
} else {

 foreach ($ve98d4810 as $v9fd7f9c9) {
if (strtolower($v7bbfa6fd) == strtolower($v9fd7f9c9)) {
$v0e474482 = $v7bbfa6fd;
}
}
}
if ($v0e474482 != null) {
$this->addHeader('Access-Control-Allow-Origin', $v0e474482);
}
}


 if ($this->_restfmData == NULL) {
$this->_restfmData = new RESTfmData();
}


 foreach ($this->headers as $veb10a0ab => $v07c32dc0) {
if (preg_match('/^X-RESTfm-/i', $veb10a0ab)) {
$this->_restfmData->setSectionData('info', $veb10a0ab, $v07c32dc0);
}
}


 foreach ($this->_info as $vb81d8ef0 => $v07c32dc0) {
$this->_restfmData->setSectionData('info', $vb81d8ef0, $v07c32dc0);
}


 $this->_buildMessage();


 if (php_sapi_name() != 'cli' && !headers_sent()) {

if ($this->reason != '') {
header('HTTP/1.1 ' . $this->code . ' ' . $this->reason);
} else {
header('HTTP/1.1 ' . $this->code);
}
foreach ($this->headers as $veb10a0ab => $v07c32dc0) {
header($veb10a0ab.': '.$v07c32dc0);
}
}

if (strtoupper($this->request->method) !== 'HEAD') {
echo $this->body;
}
}






public function setData(RESTfmDataAbstract $v1736fd6e) {
$this->_restfmData = $v1736fd6e;
}







public function setStatus($v31737a71 = 0, $v88458d3f = '') {
$this->code = $v31737a71;

if ($v88458d3f == '') {
if (isset($this->codeReason[$v31737a71])) {
$this->reason = $this->codeReason[$v31737a71];
}
} else {
$this->reason = $v88458d3f;
}
}







public function addInfo ($vb81d8ef0, $v07c32dc0) {
$this->_info[$vb81d8ef0] = $v07c32dc0;
}







protected $reason = '';





protected $_restfmData = NULL;





protected $_info = array();





protected function _buildMessage() {

$vff7780b0 = $this->format;


 $vb05d140f = NULL;
if (file_exists('lib/xslt/'.$this->format.'_export.xslt')) {
$vb05d140f = 'lib/xslt/'.$this->format.'_export.xslt';
$vff7780b0 = 'xml';
}


 
 try {
$v1c75f8d4 = FormatFactory::makeFormatter($vff7780b0);
} catch (Exception $vd18090d2) {

 $vff7780b0 = 'txt';
try {
$v1c75f8d4 = FormatFactory::makeFormatter($vff7780b0);
} catch (Exception $vd18090d2) {

 $this->code = $vd18090d2->getCode();
$this->reason = $vd18090d2->getMessage();
$this->body = 'Error ' . $this->code . ': ' . $this->reason;
return;
}
}


 
 if ($vff7780b0 == 'html') {
$v1c75f8d4->setUsername(
$this->request->getRESTfmCredentials()->getUsername() );
}

$this->addHeader('Content-type', $this->contentType($vff7780b0));
$this->body = $v1c75f8d4->write($this->_restfmData);


 if (isset($vb05d140f)) {
$vb559a0d4 = file_get_contents($vb05d140f);
$v9f883776 = new XSLTProcessor();
$ved9fa805 = new SimpleXMLElement($vb559a0d4);
$ve4cec37e = $ved9fa805->xpath('xsl:output/@method');
$this->addHeader('Content-type', $this->contentType((string)$ve4cec37e[0]));
$v9f883776->importStyleSheet($ved9fa805);
$this->body = $v9f883776->transformToXml(new SimpleXMLElement($this->body));
}
}

}
