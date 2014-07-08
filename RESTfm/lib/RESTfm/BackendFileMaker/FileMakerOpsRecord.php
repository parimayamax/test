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






class FileMakerOpsRecord extends OpsRecordAbstract {










public function __construct (BackendAbstract $vc83160b8, $vc1601e44, $v0df5ea79) {
$this->_backend = $vc83160b8;
$this->_database = $vc1601e44;
$this->_layout = $v0df5ea79;
}














public function create (RESTfmDataAbstract $va5f7e8c5) {
if (! $va5f7e8c5->sectionExists('data')) {
throw new RESTfmResponseException('No data section found.', RESTfmResponseException::BADREQUEST);
}

$v9159e740 = new RESTfmDataSimple();


 if ($this->_preOpScript !== NULL) {
$this->_preOpScriptTrigger = TRUE;
}


 if ($this->_postOpScript != NULL) {
$v9580a4c4 = $va5f7e8c5->getSectionCount('data');
} else {
$v9580a4c4 = -1;
}

$va5f7e8c5->setIteratorSection('data');
$v6c442e5c = 0;
foreach($va5f7e8c5 as $v5ae87d2c => $v5969e3f1) {
$v6c442e5c++;
if ($v6c442e5c == $v9580a4c4) {
$this->_postOpScriptTrigger = TRUE;
}
$this->_createRecord($v9159e740, $v5ae87d2c, $v5969e3f1);
}

return $v9159e740;
}














public function read (RESTfmDataAbstract $va5f7e8c5) {
if (! $va5f7e8c5->sectionExists('meta')) {
throw new RESTfmResponseException('No meta section found.', RESTfmResponseException::BADREQUEST);
}

$v9159e740 = new RESTfmDataSimple();

$va5f7e8c5->setIteratorSection('meta');
foreach($va5f7e8c5 as $v5969e3f1) {
if (isset($v5969e3f1['recordID'])) {
$this->_readRecord($v9159e740, $v5969e3f1['recordID']);
}
}

return $v9159e740;
}














public function update (RESTfmDataAbstract $va5f7e8c5) {
if (! $va5f7e8c5->sectionExists('meta') ||
! $va5f7e8c5->sectionExists('data')) {
throw new RESTfmResponseException('No data or no meta section found.', RESTfmResponseException::BADREQUEST);
}

$v9159e740 = new RESTfmDataSimple();


 if ($this->_preOpScript !== NULL) {
$this->_preOpScriptTrigger = TRUE;
}


 if ($this->_postOpScript != NULL) {
$v9580a4c4 = $va5f7e8c5->getSectionCount('data');
} else {
$v9580a4c4 = -1;
}

$va5f7e8c5->setIteratorSection('meta');
$v6c442e5c = 0;
foreach($va5f7e8c5 as $v5ae87d2c => $v5969e3f1) {
$v6c442e5c++;
if ($v6c442e5c == $v9580a4c4) {
$this->_postOpScriptTrigger = TRUE;
}
if (isset($v5969e3f1['recordID'])) {
$this->_updateRecord(
$v9159e740,
$v5969e3f1['recordID'],
$v5ae87d2c,
$va5f7e8c5->getSectionData('data', $v5ae87d2c)
);
}
}

return $v9159e740;
}













public function delete (RESTfmDataAbstract $va5f7e8c5) {
if (! $va5f7e8c5->sectionExists('meta')) {
throw new RESTfmResponseException('No meta section found.', RESTfmResponseException::BADREQUEST);
}

$v9159e740 = new RESTfmDataSimple();


 if ($this->_preOpScript !== NULL) {
$this->_preOpScriptTrigger = TRUE;
}


 if ($this->_postOpScript != NULL) {
$v9580a4c4 = $va5f7e8c5->getSectionCount('data');
} else {
$v9580a4c4 = -1;
}

$va5f7e8c5->setIteratorSection('meta');
$v6c442e5c = 0;
foreach($va5f7e8c5 as $v5ae87d2c => $v5969e3f1) {
$v6c442e5c++;
if ($v6c442e5c == $v9580a4c4) {
$this->_postOpScriptTrigger = TRUE;
}
if (isset($v5969e3f1['recordID'])) {
$this->_deleteRecord($v9159e740, $v5969e3f1['recordID']);
}
}

return $v9159e740;
}















public function callScript ($v1914c5df, $v55701314 = NULL) {
$v223acdfb = $this->_backend->getFileMaker();
$v223acdfb->setProperty('database', $this->_database);

$v1736fd6e = new RESTfmDataSimple();


 
 
 $v3f340857 = $v223acdfb->newPerformScriptCommand($this->_layout, $v1914c5df, $v55701314);


 
 
 @ $v9159e740 = $v3f340857->execute();

if (FileMaker::isError($v9159e740)) {
throw new FileMakerResponseException($v9159e740);
}


 
 
 


 if (! $this->_suppressData) {
foreach ($v9159e740->getRecords() as $v63de6b20) {
$this->_parseRecord($v1736fd6e, $v63de6b20);
}
}

return $v1736fd6e;
}







protected $_database;





protected $_layout;





protected $_preOpScriptTrigger = FALSE;





protected $_postOpScriptTrigger = FALSE;




















protected function _createRecord (RESTfmDataSimple $v1736fd6e, $v5ae87d2c, $v5969e3f1) {
$v223acdfb = $this->_backend->getFileMaker();
$v223acdfb->setProperty('database', $this->_database);

$v4d405766 = $this->_convertValuesToRepetitions($v5969e3f1);

$v45990e8d = $v223acdfb->newAddCommand($this->_layout, $v4d405766);


 if ($this->_postOpScriptTrigger) {
$v45990e8d->setScript($this->_postOpScript, $this->_postOpScriptParameter);
$this->_postOpScriptTrigger = FALSE;
}
if ($this->_preOpScriptTrigger) {
$v45990e8d->setPreCommandScript($this->_preOpScript, $this->_preOpScriptParameter);
$this->_preOpScriptTrigger = FALSE;
}


 
 
 
 $v9159e740 = @ $v45990e8d->execute();

if (FileMaker::isError($v9159e740)) {
if ($this->_isSingle) {
throw new FileMakerResponseException($v9159e740);
}
$v1736fd6e->setSectionData('multistatus', NULL, array(
'index' => $v5ae87d2c,
'Status' => $v9159e740->getCode(),
'Reason' => $v9159e740->getMessage(),
));
return; 
 }


 foreach ($v9159e740->getRecords() as $v63de6b20) {
if ($this->_suppressData) {

 $vc3539d81 = $v63de6b20->getRecordId();
$v1736fd6e->pushDataRow(NULL, $vc3539d81);
} else {

 $this->_parseRecord($v1736fd6e, $v63de6b20);
}
}
}




















protected function _readRecord (RESTfmDataSimple $v1736fd6e, $vc3539d81) {
$v223acdfb = $this->_backend->getFileMaker();
$v223acdfb->setProperty('database', $this->_database);


 $v63de6b20 = NULL;
if (strpos($vc3539d81, '=')) {
list($v3a5f3cb9, $v2e3de587) = split('=', $vc3539d81, 2);
$ve1bf4f2b = $v223acdfb->newFindCommand($this->_layout);
$ve1bf4f2b->addFindCriterion($v3a5f3cb9, $v2e3de587);
$v9159e740 = $ve1bf4f2b->execute();

if (FileMaker::isError($v9159e740)) {
if ($v9159e740->getCode() == 401 && $this->_isSingle) {

 
 
 throw new RESTfmResponseException(NULL, RESTfmResponseException::NOTFOUND);
}
$v1736fd6e->setSectionData('multistatus', NULL, array(
'recordID' => $vc3539d81,
'Status' => $v9159e740->getCode(),
'Reason' => $v9159e740->getMessage(),
));
return; 
 }

if ($v9159e740->getFetchCount() > 1) {

 if ($this->_isSingle) {
throw new RESTfmResponseException($v9159e740->getFetchCount() .
' conflicting records found', RESTfmResponseException::CONFLICT);
}
$v1736fd6e->setSectionData('multistatus', NULL, array(
'recordID' => $vc3539d81,
'Status' => 42409, 
 
 
 'Reason' => $v9159e740->getFetchCount() .
' conflicting records found',
));
return; 
 }

$v63de6b20 = $v9159e740->getFirstRecord();
} else {
$v63de6b20 = $v223acdfb->getRecordById($this->_layout, $vc3539d81);

if (FileMaker::isError($v63de6b20)) {
if ($this->_isSingle) {
throw new FileMakerResponseException($v63de6b20);
}

 $v1736fd6e->setSectionData('multistatus', NULL, array(
'recordID' => $vc3539d81,
'Status' => $v63de6b20->getCode(),
'Reason' => $v63de6b20->getMessage(),
));
return; 
 }
}

$this->_parseRecord($v1736fd6e, $v63de6b20);
}





























protected function _updateRecord (RESTfmDataSimple $v1736fd6e, $vc3539d81, $v5ae87d2c, $v5969e3f1) {
$vb2f043b7 = $vc3539d81;

$v53215b55 = NULL;
if (strpos($vc3539d81, '=')) { 
 $v53215b55 = new RESTfmDataSimple();


 try {
$this->_readRecord($v53215b55, $vc3539d81);
} catch (RESTfmResponseException $vd18090d2) {

 if ($vd18090d2->getCode() == RESTfmResponseException::NOTFOUND && $this->_updateElseCreate) {

 
 return $this->_createRecord($v1736fd6e, $v5ae87d2c, $v5969e3f1);
}


 throw $vd18090d2;
}


 if ($v53215b55->sectionExists('multistatus')) {
$v6bf5190c = $v53215b55->getSectionData('multistatus', 0);


 if ($v6bf5190c['Status'] == 401 && $this->_updateElseCreate) {

 
 return $this->_createRecord($v1736fd6e, $v5ae87d2c, $v5969e3f1);
}


 $v1736fd6e->setSectionData('multistatus', NULL, array(
'recordID' => $vc3539d81,
'Status' => $v6bf5190c['Status'],
'Reason' => $v6bf5190c['Reason'],
));
return; 
 }


 
 $v53215b55->setIteratorSection('meta');
$v53215b55->rewind();
$vb2f043b7 = $v53215b55->key();
}

$v223acdfb = $this->_backend->getFileMaker();
$v223acdfb->setProperty('database', $this->_database);


 if ($this->_updateAppend) {
if ($v53215b55 == NULL) {
$v53215b55 = new RESTfmDataSimple();
$this->_readRecord($v53215b55, $vc3539d81);


 if ($v53215b55->sectionExists('multistatus')) {
$v6bf5190c = $v53215b55->getSectionData('multistatus', 0);

 $v1736fd6e->setSectionData('multistatus', NULL, array(
'recordID' => $vc3539d81,
'Status' => $v6bf5190c['Status'],
'Reason' => $v6bf5190c['Reason'],
));
return; 
 }
}


 $v53215b55->setIteratorSection('data');
$v53215b55->rewind();
$v68bc84a2 = $v53215b55->current();

foreach ($v5969e3f1 as $v9d7ecd38 => $v07c32dc0) {
$v5969e3f1[$v9d7ecd38] = $v68bc84a2[$v9d7ecd38] . $v07c32dc0;
}
}

$v703ea416 = $this->_convertValuesToRepetitions($v5969e3f1);


 $vcdb421cb = $v223acdfb->newEditCommand($this->_layout, $vb2f043b7, $v703ea416);


 if ($this->_postOpScriptTrigger) {
$vcdb421cb->setScript($this->_postOpScript, $this->_postOpScriptParameter);
$this->_postOpScriptTrigger = FALSE;
}
if ($this->_preOpScriptTrigger) {
$vcdb421cb->setPreCommandScript($this->_preOpScript, $this->_preOpScriptParameter);
$this->_preOpScriptTrigger = FALSE;
}


 
 
 
 $v9159e740 = @ $vcdb421cb->execute();
if (FileMaker::isError($v9159e740)) {

 if ($v9159e740->getCode() == 401 && $this->_updateElseCreate) {

 return $this->_createRecord($v1736fd6e, $v5ae87d2c, $v5969e3f1);
}

if ($this->_isSingle) {
throw new FileMakerResponseException($v9159e740);
}

 $v1736fd6e->setSectionData('multistatus', NULL, array(
'recordID' => $vc3539d81,
'Status' => $v9159e740->getCode(),
'Reason' => $v9159e740->getMessage(),
));
return; 
 }
}















protected function _deleteRecord (RESTfmDataSimple $v1736fd6e, $vc3539d81) {
$vb2f043b7 = $vc3539d81;

$v53215b55 = NULL;
if (strpos($vc3539d81, '=')) { 
 $v53215b55 = new RESTfmDataSimple();
$this->_readRecord($v53215b55, $vc3539d81);


 if ($v53215b55->sectionExists('multistatus')) {
$v6bf5190c = $v53215b55->getSectionData('multistatus', 0);

 $v1736fd6e->setSectionData('multistatus', NULL, array(
'recordID' => $vc3539d81,
'Status' => $v6bf5190c['Status'],
'Reason' => $v6bf5190c['Reason'],
));
return; 
 }


 
 $v53215b55->setIteratorSection('meta');
$v53215b55->rewind();
$vb2f043b7 = $v53215b55->key();
}

$v223acdfb = $this->_backend->getFileMaker();
$v223acdfb->setProperty('database', $this->_database);

$v99b63d4f = $v223acdfb->newDeleteCommand($this->_layout, $vb2f043b7);


 if ($this->_postOpScriptTrigger) {
$v99b63d4f->setScript($this->_postOpScript, $this->_postOpScriptParameter);
$this->_postOpScriptTrigger = FALSE;
}
if ($this->_preOpScriptTrigger) {
$v99b63d4f->setPreCommandScript($this->_preOpScript, $this->_preOpScriptParameter);
$this->_preOpScriptTrigger = FALSE;
}

$v9159e740 = $v99b63d4f->execute();

if (FileMaker::isError($v9159e740)) {
if ($this->_isSingle) {
throw new FileMakerResponseException($v9159e740);
}

 $v1736fd6e->setSectionData('multistatus', NULL, array(
'recordID' => $vc3539d81,
'Status' => $v9159e740->getCode(),
'Reason' => $v9159e740->getMessage(),
));
return; 
 }
}







protected function _parseRecord (RESTfmDataSimple $v1736fd6e, FileMaker_Record $v63de6b20) {
$vdefdeb5f = $v63de6b20->getFields();


 if ($v1736fd6e->sectionExists('metaField') !== TRUE) {

 
 $v95589e8e = $v63de6b20->getLayout();
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

$v223acdfb = $this->_backend->getFileMaker();
$v223acdfb->setProperty('database', $this->_database);


 $v14e7addd = array();
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
$v1736fd6e->pushDataRow($v14e7addd, $v63de6b20->getRecordId());
}















protected function _convertValuesToRepetitions ($ve2e1cd17) {

 
 
 
 
 
 
 
 
 
 
 $v4d405766 = array();
foreach ($ve2e1cd17 as $v9d7ecd38 => $v07c32dc0) {
$v03219630 = array();
if (preg_match('/^(.+)\[(\d+)\]$/', $v9d7ecd38, $v03219630)) {
$v9d7ecd38 = $v03219630[1]; 
 $v35fdae2f = intval($v03219630[2]);


 if ( isset($v4d405766[$v9d7ecd38]) &&
is_array($v4d405766[$v9d7ecd38]) ) {
$vd44270c6 = $v4d405766[$v9d7ecd38];
} else {
$vd44270c6 = array();
}

$vd44270c6[$v35fdae2f] = $v07c32dc0;
$v4d405766[$v9d7ecd38] = $vd44270c6;
} else {
$v4d405766[$v9d7ecd38] = $v07c32dc0;
}
}

return $v4d405766;
}

};
