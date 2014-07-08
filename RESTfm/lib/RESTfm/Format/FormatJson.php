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

class FormatJson extends FormatAbstract {



public function parse (RESTfmDataAbstract $v1736fd6e, $v65e79da0) {
$v3f96f489 = json_decode($v65e79da0, TRUE);
foreach ($v3f96f489 as $vdb552e9b => $v0313426b) {

if ($this->_is_assoc($v0313426b)) { 
 $v1736fd6e->addSection($vdb552e9b, 1); 
 foreach ($v0313426b as $v5b476579 => $v6704d97a) {
$v1736fd6e->setSectionData($vdb552e9b, $v5b476579, $v6704d97a);
}
} else { 
 $v1736fd6e->addSection($vdb552e9b, 2); 
 foreach ($v0313426b as $v6704d97a) {
$v1736fd6e->setSectionData($vdb552e9b, NULL, $v6704d97a);
}
}

}
}

public function write (RESTfmDataAbstract $v1736fd6e) {
$v8d65273a = $this->_collate($v1736fd6e);
if (RESTfmConfig::getVar('settings', 'formatNicely')) {
return $this->_json_encode_pretty($v8d65273a);
} else {
return json_encode($v8d65273a);
}
}















protected function _json_encode_pretty($v07c32dc0) {

if (version_compare(phpversion(), '5.4.0', '>=')) {

 return(json_encode($v07c32dc0, JSON_PRETTY_PRINT));
}




 $v8f9d7f80 = json_encode($v07c32dc0);
if ($v8f9d7f80 === FALSE) {
return FALSE;
}


 $v4fc6121e = 0;
$vf995c567 = '    ';
$v729a246b = FALSE;
$v338d7146 = FALSE;
$v9159e740 = '';

for($v6c442e5c = 0; $v6c442e5c < strlen($v8f9d7f80); $v6c442e5c++) {
$v16ffbe62 = $v8f9d7f80[$v6c442e5c];

if ($v338d7146) {
$v9159e740 .= $v16ffbe62;
$v338d7146 = FALSE;
} else {
switch($v16ffbe62) {
case ':':
$v9159e740 .= $v16ffbe62 . (!$v729a246b ? ' ' : '');
break;

case '{':
if (!$v729a246b) {
$v4fc6121e++;
$v9159e740 .= $v16ffbe62 . "\n" . str_repeat($vf995c567, $v4fc6121e);
} else {
$v9159e740 .= $v16ffbe62;
}
break;

case '}':
if (!$v729a246b) {
$v4fc6121e--;
$v9159e740 .= "\n" . str_repeat($vf995c567, $v4fc6121e) . $v16ffbe62;
} else {
$v9159e740 .= $v16ffbe62;
}
break;

case '[':
if (!$v729a246b) {
$v4fc6121e++;
$v9159e740 .= $v16ffbe62 . "\n" . str_repeat($vf995c567, $v4fc6121e);
} else {
$v9159e740 .= $v16ffbe62;
}
break;

case ']':
if (!$v729a246b) {
$v4fc6121e--;
$v9159e740 .= "\n" . str_repeat($vf995c567, $v4fc6121e) . $v16ffbe62;
} else {
$v9159e740 .= $v16ffbe62;
}
break;

case ',':
if (!$v729a246b) {
$v9159e740 .= $v16ffbe62 . "\n" . str_repeat($vf995c567, $v4fc6121e);
} else {
$v9159e740 .= $v16ffbe62;
}
break;

case '"':
$v729a246b = !$v729a246b;
$v9159e740 .= $v16ffbe62;
break;

case '\\':
if ($v729a246b) {
$v338d7146 = TRUE;
}
$v9159e740 .= $v16ffbe62;
break;

default:
$v9159e740 .= $v16ffbe62;
}
}
}

return $v9159e740;
}
}
