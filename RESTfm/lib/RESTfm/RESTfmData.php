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

require_once 'RESTfmDataAbstract.php';

class RESTfmData extends RESTfmDataAbstract {







private $v076ff424 = array();





private $v2d529f39 = array();





private $v7c27273c;




















public function addSection ($vb81d8ef0, $v190c7e41 = 2) {
if (isset($this->v076ff424[$vb81d8ef0])) {
return; 
 }
$this->v2d529f39[$vb81d8ef0] = $v190c7e41;
$this->v076ff424[$vb81d8ef0] = array();
}







public function sectionExists ($vb81d8ef0) {
return isset($this->v076ff424[$vb81d8ef0]);
}







public function sectionIndexExists ($vb81d8ef0, $v5ae87d2c) {
return isset($this->v076ff424[$vb81d8ef0]) && isset($this->v076ff424[$vb81d8ef0][$v5ae87d2c]);
}







public function getSectionNames () {
if (RESTfmConfig::getVar('settings', 'formatNicely')) {

 $vaf2a1818 = function ($v3f96f489, $va76f61c8) {

 if ($v3f96f489 == 'meta' ) { return -1; }
if ($va76f61c8 == 'meta' ) { return 1; }
if ($v3f96f489 == 'data') { return -1; }
if ($va76f61c8 == 'data') { return 1; }
if ($v3f96f489 == 'info') { return -1; }
if ($va76f61c8 == 'info') { return 1; }
return 0;
};
$v93a239f7 = array_keys($this->v2d529f39);
usort($v93a239f7, $vaf2a1818);
return $v93a239f7;
}

return array_keys($this->v2d529f39);
}









public function getSection ($vb81d8ef0) {
return $this->v076ff424[$vb81d8ef0];
}








public function getSectionDimensions ($vb81d8ef0) {
return $this->v2d529f39[$vb81d8ef0];
}








public function getSectionCount ($vb81d8ef0) {
return count($this->v076ff424[$vb81d8ef0]);
}











public function getSectionCount2nd ($vb81d8ef0, $v5ae87d2c) {
if ($this->v2d529f39[$vb81d8ef0] < 2) {
return -1;
}
if (!isset($this->v076ff424[$vb81d8ef0][$v5ae87d2c])) {
return -2;
}
return count($this->v076ff424[$vb81d8ef0][$v5ae87d2c]);
}












public function setSectionData ($vb81d8ef0, $v5ae87d2c, $v65e79da0) {
if (!isset($this->v076ff424[$vb81d8ef0])) { 
 if (is_array($v65e79da0)) {
$this->addSection($vb81d8ef0, 2);
} else {
$this->addSection($vb81d8ef0, 1);
}
}
if ($v5ae87d2c == NULL) { 
 array_push($this->v076ff424[$vb81d8ef0], $v65e79da0);
} else {
$this->v076ff424[$vb81d8ef0][$v5ae87d2c] = $v65e79da0;
}
}













public function setSectionData2nd ($vb81d8ef0, $v9f7dabb9, $v372f61c4, $v07c32dc0) {
if (!isset($this->v076ff424[$vb81d8ef0])) { 
 $this->addSection($vb81d8ef0, 2);
}
if ($this->v2d529f39[$vb81d8ef0] < 2) { 
 return FALSE;
}
if (!isset($this->v076ff424[$vb81d8ef0][$v9f7dabb9])) { 
 $this->v076ff424[$vb81d8ef0][$v9f7dabb9] = array();
}
$this->v076ff424[$vb81d8ef0][$v9f7dabb9][$v372f61c4] = $v07c32dc0;
}











public function getSectionData ($vb81d8ef0, $v5ae87d2c) {
return $this->v076ff424[$vb81d8ef0][$v5ae87d2c];
}











public function getSectionData2nd ($vb81d8ef0, $v9f7dabb9, $v372f61c4) {
return $this->v076ff424[$vb81d8ef0][$v9f7dabb9][$v372f61c4];
}







public function deleteSectionData ($vb81d8ef0, $v5ae87d2c) {
unset($this->v076ff424[$vb81d8ef0][$v5ae87d2c]);
}






public function setIteratorSection ($vb81d8ef0) {
if (isset($this->v076ff424[$vb81d8ef0])) {
$this->v7c27273c = $vb81d8ef0;
} else {
$this->v7c27273c = NULL;
}
}






public function __toString () {
$v5574bc24 = '';
foreach($this->v2d529f39 as $vdb552e9b => $v7f733fb9) {
$v5574bc24 .= $vdb552e9b . ":\n";
if ($v7f733fb9 == 1) {
foreach ($this->v076ff424[$vdb552e9b] as $v5b476579 => $v07c32dc0) {
$v5574bc24 .= '  ' . $v5b476579 . '="' . addslashes($v07c32dc0) . '"' . "\n";
}
} elseif ($v7f733fb9== 2) {
foreach ($this->v076ff424[$vdb552e9b] as $v5ae87d2c => $v5969e3f1) {
$v5574bc24 .= '  ' . $v5ae87d2c . ":\n";
foreach ($v5969e3f1 as $v5b476579 => $v07c32dc0) {
$v5574bc24 .= '    ' . $v5b476579 . '="' . addslashes($v07c32dc0) . '"' . "\n";
}
}
} else {
$v5574bc24 .= '  ** Unknown format **.' . "\n";
}
$v5574bc24 .= "\n";
}
return $v5574bc24;
}



public function current() {
if (isset($this->v076ff424[$this->v7c27273c])) {
return current($this->v076ff424[$this->v7c27273c]);
}
}

public function key() {
if (isset($this->v076ff424[$this->v7c27273c])) {
return key($this->v076ff424[$this->v7c27273c]);
}
}

public function next() {
if (isset($this->v076ff424[$this->v7c27273c])) {
return next($this->v076ff424[$this->v7c27273c]);
}
}

public function rewind() {
if (isset($this->v076ff424[$this->v7c27273c])) {
return reset($this->v076ff424[$this->v7c27273c]);
}
}

public function valid() {
if (isset($this->v076ff424[$this->v7c27273c])) {
return key($this->v076ff424[$this->v7c27273c]) !== NULL;
}
}

};
