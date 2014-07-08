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

require_once 'BackendAbstract.php';
require_once 'RESTfmResponseException.php';
require_once 'RESTfmDataAbstract.php';








abstract class OpsRecordAbstract {






protected $_backend = NULL;










abstract public function __construct (BackendAbstract $vc83160b8, $vc1601e44, $v0df5ea79);














abstract public function create (RESTfmDataAbstract $va5f7e8c5);














abstract public function read (RESTfmDataAbstract $va5f7e8c5);














abstract public function update (RESTfmDataAbstract $va5f7e8c5);













abstract public function delete (RESTfmDataAbstract $va5f7e8c5);















abstract public function callScript ($v1914c5df, $v55701314 = NULL);


























public function setSingle ($v506620be = TRUE) {
$this->_isSingle = $v506620be;
}










public function setSuppressData ($v439846f3 = TRUE) {
$this->_suppressData = $v439846f3;
}








public function setUpdateAppend ($vc3453ed7 = TRUE) {
$this->_updateAppend = $vc3453ed7;
}








public function setUpdateElseCreate ($vf92ee14b = TRUE) {
$this->_updateElseCreate = $vf92ee14b;
}









public function setPreOpScript ($v1914c5df, $vdea47c91 = NULL) {
$this->_preOpScript = $v1914c5df;
$this->_preOpScriptParameter = $vdea47c91;
}









public function setPostOpScript ($v1914c5df, $vdea47c91 = NULL) {
$this->_postOpScript = $v1914c5df;
$this->_postOpScriptParameter = $vdea47c91;
}







protected $_isSingle = FALSE;





protected $_suppressData = FALSE;





protected $_updateAppend = FALSE;





protected $_updateElseCreate = FALSE;







protected $_findCriteria = array();




protected $_preOpScript = NULL;




protected $_preOpScriptParameter = NULL;




protected $_postOpScript = NULL;




protected $_postOpScriptParameter = NULL;

};
