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
require_once 'RESTfmData.php';
require_once 'RESTfmParameters.php';
require_once 'RESTfmQueryString.php';
require_once 'RESTfmUrl.php';
require_once 'RESTfmCredentials.php';
require_once 'RFMfixFM02.php';






class RESTfmRequest extends Request {





protected $_RESTfmData = NULL;





protected $_RESTfmParameters = NULL;





protected $_RESTfmCredentials = NULL;





protected $_format;





protected $_parametersQueryString = array();





protected $_parametersPost = array();





protected $_parametersData = array();





protected $_genericMethodNames = array (
'CREATE' => 'POST',
'READ' => 'GET',
'UPDATE' => 'PUT',
'DELETE' => 'DELETE',
);












public function loadResource () {

 try {
return(parent::loadResource());
} catch (ResponseException $vd18090d2) {
throw new RESTfmResponseException($vd18090d2->getMessage(), $vd18090d2->getCode(), $vd18090d2);
}
}










































public function parse () {

$this->_RESTfmData = new RESTfmData();

$this->_RESTfmParameters = new RESTfmParameters();

$this->_handleGetData();

$this->_handlePostData();


 
 if (isset($this->_parametersPost['RFMformat'])) {
$this->_format = $this->_parametersPost['RFMformat'];
}
if (isset($this->_parametersQueryString['RFMformat'])) {
$this->_format = $this->_parametersQueryString['RFMformat'];
}

$this->_parseFormattedData();

$this->_setParameters();


 if (isset($this->_RESTfmParameters->RFMfixFM01)) {
RESTfmUrl::setEncoding(RESTfmUrl::RFMfixFM01);
}
if (isset($this->_RESTfmParameters->RFMfixFM02)) {
RESTfmUrl::setEncoding(RESTfmUrl::RFMfixFM02);
}


 if (isset($this->_RESTfmParameters->RFMmethod)) {
$this->method = strtoupper($this->_RESTfmParameters->RFMmethod);
if (isset($this->_genericMethodNames[$this->method])) {
$this->method = $this->_genericMethodNames[$this->method];
}
}

$this->_RESTfmCredentials = new RESTfmCredentials($this->_RESTfmParameters);
}






public function getRESTfmData () {
return $this->_RESTfmData;
}






public function getRESTfmParameters () {
return $this->_RESTfmParameters;
}






public function getRESTfmCredentials () {
return $this->_RESTfmCredentials;
}






public function getFormat () {
return $this->_format;
}










protected function _handleGetData () {
$v32a0cc19 = new RESTfmQueryString(TRUE);


 $this->_parametersQueryString = $v32a0cc19->getRegex('/^RFM.*/');


 if (strtoupper($this->method != 'GET')) {
return;
}


 if (isset($v32a0cc19->RFMdata)) {

 
 $this->data = $v32a0cc19->RFMdata;
unset($this->_parametersQueryString['RFMdata']);
} else {

 
 $v16347951 = $v32a0cc19->getRegex('/^(?!RFM).+/'); 
 if (count($v16347951) > 0) {
$this->_RESTfmData->addSection('data', 2);
$this->_RESTfmData->setSectionData('data', NULL, $v16347951);
}
}
}








protected function _handlePostData () {


 if (strtoupper($this->method) != 'POST') {
return;
}


 $v6a6fb768 = array();
if (isset($this->_parametersQueryString['RFMformat'])) {

 
 return;
} elseif (stripos($_SERVER['CONTENT_TYPE'], 'application/x-www-form-urlencoded') !== FALSE) {

 $va9d66074 = new RESTfmQueryString();
$va9d66074->parse_str($this->data, $v6a6fb768);
} elseif (stripos($_SERVER['CONTENT_TYPE'], 'multipart/form-data') !== FALSE ) {

 
 
 
 $v6a6fb768 = $_POST;
} else {

 return;
}


 
 
 if (isset($v6a6fb768['RFMfixFM02']) ||
isset($this->_parametersQueryString['RFMfixFM02'])) {
$vf7e4dbe6 = array();
foreach ($v6a6fb768 as $v5b476579 => $v07c32dc0) {
$vf7e4dbe6[RFMfixFM02::postDecode($v5b476579)] =
RFMfixFM02::postDecode($v07c32dc0);
}
$v6a6fb768 = $vf7e4dbe6;
}


 $vfb0def0a = array();
foreach ($v6a6fb768 as $v5b476579 => $v07c32dc0) {
if (preg_match('/^RFM*/', $v5b476579)) {
if ('RFMdata' == $v5b476579) {
continue;
}
$this->_parametersPost[$v5b476579] = $v07c32dc0;
$vfb0def0a[] = $v5b476579;
}
}
foreach ($vfb0def0a as $v5b476579) {
unset($v6a6fb768[$v5b476579]);
}


 if (isset($v6a6fb768['RFMdata'])) {

 
 $this->data = $v6a6fb768['RFMdata'];
} else {

 
 $this->_RESTfmData->addSection('data', 2);
$this->_RESTfmData->setSectionData('data', NULL, $v6a6fb768);
unset($this->data);
}
}






protected function _parseFormattedData () {


 if (empty($this->data)) {
return;
}


 if (! isset($this->_format)) {
if (isset($v32a0cc19->RFMurlencoded)) {

 $this->_format = 'application/x-www-form-urlencoded';
} else {

 $this->_format = $this->mostAcceptable(RESTfmConfig::getFormats());
}
}


 if ($this->_format == '') {

 throw new RESTfmResponseException(
'Unable to determine format for resource ' . $this->uri,
RESPONSE::BADREQUEST);
}


 if (file_exists('lib/xslt/'.$this->_format.'_import.xslt')) {
$vb05d140f = 'lib/xslt/'.$this->_format.'_import.xslt';
$vb559a0d4 = file_get_contents($vb05d140f);
$v9f883776 = new XSLTProcessor();
$v9f883776->importStyleSheet(new SimpleXMLElement($vb559a0d4));
$this->data = $v9f883776->transformToXml(new SimpleXMLElement($this->data));

$this->_format = 'xml';
}


 $v42ea6b19 = FormatFactory::makeFormatter($this->_format);
$v42ea6b19->parse($this->_RESTfmData, $this->data);


 
 $this->_RESTfmData->setIteratorSection('info');
$vfb0def0a = array();
foreach ($this->_RESTfmData as $v5b476579 => $v6704d97a) {
if (preg_match('/^RFM/', $v5b476579)) {
$this->_parametersData[$v5b476579] = $v6704d97a;
$vfb0def0a[] = $v5b476579;
}
}
foreach ($vfb0def0a as $v5b476579) {
$this->_RESTfmData->deleteSectionData('info', $v5b476579);
}
}





protected function _setParameters () {

 
 $this->_RESTfmParameters->merge($this->_parametersData);
$this->_RESTfmParameters->merge($this->_parametersPost);
$this->_RESTfmParameters->merge($this->_parametersQueryString);
}

};
