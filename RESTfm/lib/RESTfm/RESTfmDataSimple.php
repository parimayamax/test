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

require_once 'RESTfmData.php';





class RESTfmDataSimple extends RESTfmData {


















public function pushDataRow($v658fd71b, $vc3539d81 = NULL, $ved7b4d72 = NULL) {
$v91d87c23 = array();

if (!isset($vc3539d81)) {
$vc3539d81 = 'auto.'.$this->_lastRecordID++;
}
$v91d87c23['recordID'] = $vc3539d81;

if ($ved7b4d72 != NULL) {
$v91d87c23['href'] = $ved7b4d72;
}

$this->setSectionData('meta', $vc3539d81, $v91d87c23);

if ($v658fd71b !== NULL) {
$this->setSectionData('data', $vc3539d81, $v658fd71b);
}
}










public function pushFieldMeta($v9d7ecd38, $v7697a95f) {
$this->setSectionData('metaField', $v9d7ecd38,
array( 'name' => $v9d7ecd38, ) + $v7697a95f
);
}
















public function getFieldMetaValue($v9d7ecd38, $va6a10e03) {
if ($this->sectionIndexExists('metaField', $v9d7ecd38)) {
$v7697a95f = $this->getSectionData('metaField', $v9d7ecd38);
if (isset($v7697a95f[$va6a10e03])) {
return $v7697a95f[$va6a10e03];
}
}

return FALSE;
}












public function pushInfo($v9d7ecd38, $vbef057db) {
$this->setSectionData('info', $v9d7ecd38, $vbef057db);
}









public function pushNav($vb81d8ef0, $ved7b4d72) {
$this->setSectionData('nav', NULL, array(
'name' => $vb81d8ef0,
'href' => $ved7b4d72,
)
);
}







protected $_lastRecordID = 1;

}
