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

require_once 'FileMakerResponseException.php';






class FileMakerOpsLayout extends OpsLayoutAbstract {












public function __construct (BackendAbstract $vc83160b8, $vc1601e44, $v0df5ea79) {
$this->_backend = $vc83160b8;
$this->_database = $vc1601e44;
$this->_layout = $v0df5ea79;
}










public function read () {
$v223acdfb = $this->_backend->getFileMaker();
$v223acdfb->setProperty('database', $this->_database);


 if (count($this->_findCriteria) > 0) {

 $ve1bf4f2b = $v223acdfb->newFindCommand($this->_layout);
foreach ($this->_findCriteria as $v9d7ecd38 => $v2c53f8a5) {
$ve1bf4f2b->addFindCriterion($v9d7ecd38, $v2c53f8a5);
}
} else {

 $ve1bf4f2b = $v223acdfb->newFindAllCommand($this->_layout);
}


 if ($this->_postOpScript !== NULL) {
$ve1bf4f2b->setScript($this->_postOpScript, $this->_postOpScriptParameter);
}
if ($this->_preOpScript != NULL) {
$ve1bf4f2b->setPreCommandScript($this->_preOpScript, $this->_preOpScriptParameter);
}

$v54fee726 = $this->_readOffset;
$v3a311317 = $this->_readCount;


 
 if ($v54fee726 == -1) {
$ve1bf4f2b->setRange(0, 1);

 $v9159e740 = $ve1bf4f2b->execute();
if (FileMaker::isError($v9159e740)) {
throw new FileMakerResponseException($v9159e740);
}
$v54fee726 = $v9159e740->getFoundSetCount() - $v3a311317;
$v54fee726 = max(0, $v54fee726); 
 }


 $ve1bf4f2b->setRange($v54fee726, $v3a311317);


 $v9159e740 = $ve1bf4f2b->execute();

if (FileMaker::isError($v9159e740)) {
throw new FileMakerResponseException($v9159e740);
}

$v1736fd6e = new RESTfmDataSimple();

$this->_parseMetaField($v1736fd6e, $v9159e740);


 $vdefdeb5f = $v9159e740->getFields();
foreach ($v9159e740->getRecords() as $v63de6b20) {

 
 $v14e7addd = array();
$vc3539d81 = $v63de6b20->getRecordId();
foreach ($vdefdeb5f as $v9d7ecd38) {

 
 $v4214be63 = $v1736fd6e->getFieldMetaValue($v9d7ecd38, 'maxRepeat');

for ($v35fdae2f = 0; $v35fdae2f < $v4214be63; $v35fdae2f++) {
$v8a96cef7 = $v9d7ecd38;


 if ($v4214be63 > 1) {
$v8a96cef7 .= '[' . $v35fdae2f . ']';
}


 $vbef057db = $v63de6b20->getFieldUnencoded($v9d7ecd38, $v35fdae2f);


 if ($v1736fd6e->getFieldMetaValue($v9d7ecd38, 'resultType') == 'container' && method_exists($v223acdfb, 'getContainerDataURL')) {

 $vbef057db = $v223acdfb->getContainerDataURL($v63de6b20->getField($v9d7ecd38, $v35fdae2f));
}


 $v14e7addd[$v8a96cef7] = $vbef057db;
}
}
$v1736fd6e->pushDataRow($v14e7addd, $vc3539d81, NULL);
}


 $v1736fd6e->pushInfo('tableRecordCount', $v9159e740->getTableRecordCount());
$v1736fd6e->pushInfo('foundSetCount', $v9159e740->getFoundSetCount());
$v1736fd6e->pushInfo('fetchCount', $v9159e740->getFetchCount());

return $v1736fd6e;
}










public function readMetaField () {
$v223acdfb = $this->_backend->getFileMaker();
$v223acdfb->setProperty('database', $this->_database);

$v95589e8e = $v223acdfb->getLayout($this->_layout);
if (FileMaker::isError($v95589e8e)) {
throw new FileMakerResponseException($v95589e8e);
}

$v1736fd6e = new RESTfmDataSimple();

$this->_parseMetaField($v1736fd6e, $v95589e8e);

return $v1736fd6e;
}







protected $_database;





protected $_layout;











protected function _parseMetaField(RESTfmDataSimple $v1736fd6e, $v9159e740) {

if (is_a($v9159e740, 'FileMaker_Result')) {
$v95589e8e = $v9159e740->getLayout();
} elseif (is_a($v9159e740, 'FileMaker_Layout')) {
$v95589e8e = $v9159e740;
} else {
return;
}


 
 $vdefdeb5f = $v95589e8e->listFields();
foreach ($vdefdeb5f as $v9d7ecd38) {
$v7697a95f = array();
$vabf90e33 = $v95589e8e->getField($v9d7ecd38);

$v7697a95f['autoEntered'] = $vabf90e33->isAutoEntered() ? 1 : 0;
$v7697a95f['global'] = $vabf90e33->isGlobal() ? 1 : 0;
$v7697a95f['maxRepeat'] = $vabf90e33->getRepetitionCount();
$v7697a95f['resultType'] = $vabf90e33->getResult();


$v1736fd6e->pushFieldMeta($v9d7ecd38, $v7697a95f);
}
}

};
