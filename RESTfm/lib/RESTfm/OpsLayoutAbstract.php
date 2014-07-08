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








abstract class OpsLayoutAbstract {






protected $_backend = NULL;










abstract public function __construct (BackendAbstract $vc83160b8, $vc1601e44, $v0df5ea79);










abstract public function read ();










abstract public function readMetaField ();














public function setLimit ($v23854453 = 0, $v66e3aadf = 24) {
$this->_readOffset = $v23854453;
$this->_readCount = $v66e3aadf;
}











public function addFindCriterion ($v9d7ecd38, $v2c53f8a5) {
$this->_findCriteria[$v9d7ecd38] = $v2c53f8a5;
}




public function clearCriteria () {
$this->_findCriteria = array();
}









public function setPreOpScript ($v1914c5df, $vdea47c91 = NULL) {
$this->_preOpScript = $v1914c5df;
$this->_preOpScriptParameter = $vdea47c91;
}









public function setPostOpScript ($v1914c5df, $vdea47c91 = NULL) {
$this->_postOpScript = $v1914c5df;
$this->_postOpScriptParameter = $vdea47c91;
}







protected $_readOffset = 0;





protected $_readCount = 24;







protected $_findCriteria = array();




protected $_preOpScript = NULL;




protected $_preOpScriptParameter = NULL;




protected $_postOpScript = NULL;




protected $_postOpScriptParameter = NULL;

};
