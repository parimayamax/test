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
















class FormatSimple extends FormatAbstract {









public function parse (RESTfmDataAbstract $v1736fd6e, $v65e79da0) {


 $vf50a9085 = preg_split('/\n\n|\r\n\r\n|\r\r/', $v65e79da0, -1, PREG_SPLIT_NO_EMPTY);
foreach($vf50a9085 as $vcb630f3c) {
$this->_parseSection($v1736fd6e, $vcb630f3c);
}


 
 
 
 }








public function write (RESTfmDataAbstract $v1736fd6e){
$v5574bc24 = ''; 

foreach ($v1736fd6e->getSectionNames() as $vdb552e9b) {
$v5574bc24 .= $vdb552e9b."\n";
if ($v1736fd6e->getSectionDimensions($vdb552e9b) == 2) {
$v5574bc24 .= $this->_encodeRows($v1736fd6e->getSection($vdb552e9b));
} else {
$v5574bc24 .= $this->_encodeSingle($v1736fd6e->getSection($vdb552e9b)) . "\n";
}
$v5574bc24 .= "\n";
}

return $v5574bc24;
}






protected static $_lineEndings = array();





protected static $_initialised = FALSE;


public function __construct() {


if (self::$_initialised === TRUE) {
return;
}


 
 $vd8903c47 = array('\u0085', '\u2028', '\u2029');
foreach ($vd8903c47 as $v83fed7fa) {
self::$_lineEndings[] = json_decode('"'.$v83fed7fa.'"');
}
self::$_lineEndings[] = "\n"; 

self::$_initialised = TRUE;
}









protected function _parseSection (RESTfmDataAbstract $v1736fd6e, $vcb630f3c) {

 $vcd45bcf8 = preg_split('/\n|\r\n|\r/', $vcb630f3c, -1, PREG_SPLIT_NO_EMPTY);

$vdb552e9b = array_shift($vcd45bcf8); 


 
 $v7f733fb9 = $this->_getCommonDimension($vdb552e9b);

$v1736fd6e->addSection($vdb552e9b, $v7f733fb9);

foreach ($vcd45bcf8 as $v5969e3f1) {
$v3f96f489 = $this->_parseRow($v5969e3f1);
if ($v7f733fb9 == 2) {
$v1736fd6e->setSectionData($vdb552e9b, NULL, $v3f96f489);
} else {

 foreach ($v3f96f489 as $v9d7ecd38 => $v07c32dc0) {
$v1736fd6e->setSectionData($vdb552e9b, $v9d7ecd38, $v07c32dc0);
}
}
}
}










protected function _parseRow ($v5969e3f1) {
$v3f96f489 = array();


 $v9b52d41a = preg_split('/(?<!^)(?!$)/u', $v5969e3f1);


 
 
 
 
 
 
 
 
 
 
 
 $v393bff32 = 0;
$v9d7ecd38 = '';
$v231e4e35 = '';
$vb67ef371 = FALSE;
foreach ($v9b52d41a as $v7397a763) {
switch($v393bff32) {
case 0: 
 if ($v7397a763 == '=') {
$v393bff32 = 1;
} else {
$v9d7ecd38 .= $v7397a763;
}
break;
case 1: 
 if ($v7397a763 == '"') {
$v393bff32 = 2;
}
break;
case 2: 
 if ($vb67ef371 === TRUE) { 
 $v231e4e35 .= $v7397a763;
$vb67ef371 = FALSE;
} elseif ($v7397a763 == '\\') { 
 $vb67ef371 = TRUE;
} elseif ($v7397a763 == '¶') { 
 $v231e4e35 .= "\n";
} elseif ($v7397a763 == '"') { 
 $v393bff32 = 3;
} else {
$v231e4e35 .= $v7397a763;
}
break;
case 3:
if ($v7397a763 == '&') { 
 $v3f96f489[$v9d7ecd38] = $v231e4e35; 
 $v393bff32 = 0; 
 $v9d7ecd38 = ''; 
 $v231e4e35 = '';
}
break;
default:
}
}
if ($v9d7ecd38 != '') { 
 $v3f96f489[$v9d7ecd38] = $v231e4e35;
}

return($v3f96f489);
}









protected function _encodeRows ($v65e79da0) {
$v5574bc24 = '';
foreach ($v65e79da0 as $v5969e3f1) {
$v5574bc24 .= $this->_encodeSingle($v5969e3f1) . "\n";
}

return $v5574bc24;
}









protected function _encodeSingle ($v65e79da0) {
$vc4c3bc07 = array();
foreach ($v65e79da0 as $v9d7ecd38 => $v07c32dc0) {
$vc4c3bc07[] = $v9d7ecd38 . '="' . $this->_encodeSpecialChars($v07c32dc0) . '"';
}

return join('&', $vc4c3bc07);
}







protected function _encodeSpecialChars ($v5574bc24) {

 $v5574bc24 = preg_replace('/(\\\|"|¶)/', '\\\${1}', $v5574bc24);


 $v5574bc24 = preg_replace('/' . join('|', self::$_lineEndings) . '/', '¶', $v5574bc24);

return $v5574bc24;
}

}
