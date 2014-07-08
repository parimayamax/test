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






class FileMakerOpsDatabase extends OpsDatabaseAbstract {



public function __construct (BackendAbstract $vc83160b8, $vc1601e44 = NULL) {
$this->_backend = $vc83160b8;
if ($vc1601e44 != NULL) {
$this->_backend->getFileMaker()->setProperty('database', $vc1601e44);
}
$this->_database = $vc1601e44;
}










public function readDatabases () {
$v223acdfb = $this->_backend->getFileMaker();
$v9159e740 = $v223acdfb->listDatabases();
if (FileMaker::isError($v9159e740)) {
throw new FileMakerResponseException($v9159e740);
}
natsort($v9159e740);

$v1736fd6e = new RESTfmDataSimple();
foreach($v9159e740 as $vc1601e44) {
$v1736fd6e->pushDataRow( array('database' => $vc1601e44), NULL, NULL );
}

return $v1736fd6e;
}










public function readLayouts () {
$v223acdfb = $this->_backend->getFileMaker();
$v9159e740 = $v223acdfb->listLayouts();
if (FileMaker::isError($v9159e740)) {
throw new FileMakerResponseException($v9159e740);
}
natsort($v9159e740);

$v1736fd6e = new RESTfmDataSimple();
foreach($v9159e740 as $v0df5ea79) {
if (empty($v0df5ea79)) continue;
$v1736fd6e->pushDataRow( array('layout' => $v0df5ea79), NULL, NULL );
}

return $v1736fd6e;
}










public function readScripts () {
$v223acdfb = $this->_backend->getFileMaker();
$v9159e740 = $v223acdfb->listScripts();
if (FileMaker::isError($v9159e740)) {
throw new FileMakerResponseException($v9159e740);
}
natsort($v9159e740);

$v1736fd6e = new RESTfmDataSimple();
foreach($v9159e740 as $vc9d36bfe) {
$v1736fd6e->pushDataRow( array('script' => $vc9d36bfe), NULL, NULL );
}

return $v1736fd6e;
}



};
