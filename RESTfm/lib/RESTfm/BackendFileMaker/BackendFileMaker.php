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

require_once 'FileMaker.php';
require_once 'FileMakerOpsRecord.php';
require_once 'FileMakerOpsDatabase.php';
require_once 'FileMakerOpsLayout.php';




class BackendFileMaker extends BackendAbstract {







private $vd582ab96 = NULL;















public function __construct ($v4033d659, $vcbe927fb, $v8a11bc53) {
$this->vd582ab96 = new FileMaker();

$this->vd582ab96->setProperty('hostspec', $v4033d659);
$this->vd582ab96->setProperty('curlOptions', array(CURLOPT_SSL_VERIFYPEER => false));
$this->vd582ab96->setProperty('username', $vcbe927fb);
$this->vd582ab96->setProperty('password', $v8a11bc53);
}








public function makeOpsDatabase ($vc1601e44 = NULL) {
return new FileMakerOpsDatabase($this, $vc1601e44);
}









public function makeOpsLayout ($vc1601e44, $v0df5ea79) {
return new FileMakerOpsLayout($this, $vc1601e44, $v0df5ea79);
}









public function makeOpsRecord ($vc1601e44, $v0df5ea79) {
return new FileMakerOpsRecord($this, $vc1601e44, $v0df5ea79);
}








public function getFileMaker () {
return $this->vd582ab96;
}

};
