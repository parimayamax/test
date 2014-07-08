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

class FormatXml extends FormatAbstract {










public function parse (RESTfmDataAbstract $v1736fd6e, $v65e79da0) {
libxml_use_internal_errors(TRUE);
$vac91f34f = simplexml_load_string($v65e79da0);
if (!$vac91f34f) {
$v3e3b9ac1 = '';
foreach(libxml_get_errors() as $vd18090d2) {
$v3e3b9ac1 .= $vd18090d2->message."\n";
}
throw new ResponseException($v3e3b9ac1, Response::BADREQUEST);
}


 
 
 foreach ($vac91f34f as $v7ce33e4a) {
foreach ($v7ce33e4a as $vdfb32af4) {
if (strtolower($vdfb32af4->getName()) == 'row') {

 $vacaaba9e = array();
foreach ($vdfb32af4 as $v893b5205) {
$vacaaba9e[(string) $v893b5205['name']] = (string) $v893b5205;
}
$v1736fd6e->setSectionData($v7ce33e4a->getName(),
(string) $vdfb32af4['name'],
$vacaaba9e);
} elseif (strtolower($vdfb32af4->getName()) == 'field') {

 $v1736fd6e->setSectionData($v7ce33e4a->getName(),
(string) $vdfb32af4['name'],
(string) $vdfb32af4);
}
}
}
}








public function write (RESTfmDataAbstract $v1736fd6e) {
$v18b707ee = new XmlWriter();
$v18b707ee->openMemory();
if (RESTfmConfig::getVar('settings', 'formatNicely')) {
$v18b707ee->setIndent(TRUE);
}
$v18b707ee->startDocument('1.0', 'UTF-8');

$v18b707ee->startElement('resource');
$v18b707ee->writeAttribute('xmlns', 'http://www.restfm.com');

 
 

foreach ($v1736fd6e->getSectionNames() as $vdb552e9b) {
$v18b707ee->startElement($vdb552e9b);
$this->_writeSection($v18b707ee, $v1736fd6e, $vdb552e9b);
$v18b707ee->endElement();
}

$v18b707ee->endElement();

return $v18b707ee->outputMemory(TRUE);
}













protected function _writeSection(XMLWriter $v18b707ee, RESTfmDataAbstract $v1736fd6e, $vdb552e9b) {
if ($v1736fd6e->getSectionDimensions($vdb552e9b) == 2) {
$v1736fd6e->setIteratorSection($vdb552e9b);
foreach ($v1736fd6e as $v5969e3f1) {

 
 
 $v18b707ee->startElement('row');
self::_row2xml($v18b707ee, $v5969e3f1);
$v18b707ee->endElement();
}
} else {
self::_row2xml($v18b707ee, $v1736fd6e->getSection($vdb552e9b));
}
}










protected function _row2xml(XMLWriter $v18b707ee, array $v658fd71b) {
foreach($v658fd71b as $v5b476579 => $v6704d97a) {
$v18b707ee->startElement('field');
$v18b707ee->writeAttribute('name', $v5b476579);
if (is_array($v6704d97a)) {
self::_array2xml($v18b707ee, $v6704d97a);
} else {
$v18b707ee->text($v6704d97a);
}
$v18b707ee->endElement();
}
}









protected function _array2xml(XMLWriter $v18b707ee, array $v3f96f489) {
foreach($v3f96f489 as $v6704d97a) {
$v18b707ee->startElement('field');
$v18b707ee->writeAttribute('name', $v6704d97a);
if (is_array($v6704d97a)) {
self::_array2xml($v18b707ee, $v6704d97a);
}
$v18b707ee->endElement();
}
}

}
