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

class FormatHtml extends FormatAbstract {



public function parse (RESTfmDataAbstract $v1736fd6e, $v65e79da0) {

 
 $v3f96f489 = array();
$this->_parse_str($v65e79da0, $v3f96f489);

$v1736fd6e->addSection('data', 2);
$v1736fd6e->setSectionData('data', NULL, $v3f96f489);
}

public function write (RESTfmDataAbstract $v1736fd6e) {
$vf50a9085 = $this->_collate($v1736fd6e);

$v8e9f3b97 = '<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">' . "\n";
$v8e9f3b97 .= '<html><head>' . "\n";
$v8e9f3b97 .= '<meta http-equiv="Content-type" content="text/html; charset=utf-8">' . "\n";
$v8e9f3b97 .= "<title>Response</title>\n";
$v8e9f3b97 .= '<link type="text/css" rel="stylesheet" href="' . RESTfmConfig::getVar('settings', 'baseURI') . '/css/RESTfm.css">'."\n";
$v8e9f3b97 .= "</head><body>\n";
$v8e9f3b97 .= '<div id="logo">' .
'<a target="_blank" href="http://www.restfm.com"><img width="106" height="36" src="' . RESTfmConfig::getVar('settings', 'baseURI') . '/css/RESTfm.logo.png" alt="RESTfm logo"></a>' .
'<span>' . Version::getRelease() . '</span>' .
'</div>' . "\n";


 if ($this->_username == null) {
$v6058ea21 = '"" (Guest)';
} else {
$v6058ea21 = $this->_username;
}
$v8e9f3b97 .= '<div id="credentials">Username: ' . $v6058ea21 . '<br>'.
'[ <a href="' . RESTfmConfig::getVar('settings', 'baseURI') . '?RFMreauth=' . rawurlencode($this->_username) . '">change user</a> ]'.
'</div>';

$v93a239f7 = array_keys($vf50a9085);


 $vaf2a1818 = function ($v3f96f489, $va76f61c8) {

 if ($v3f96f489 == 'nav' ) { return -1; }
if ($va76f61c8 == 'nav' ) { return 1; }
if ($v3f96f489 == 'data') { return -1; }
if ($va76f61c8 == 'data') { return 1; }
if ($v3f96f489 == 'info') { return -1; }
if ($va76f61c8 == 'info') { return 1; }
return 0;
};
usort($v93a239f7, $vaf2a1818);

foreach($v93a239f7 as $vdb552e9b) {
$v8e9f3b97 .= '<h3>'.$vdb552e9b.'</h3>'."\n";
$v8e9f3b97 .= '<div id="'.$vdb552e9b.'">'."\n";
if (count($vf50a9085[$vdb552e9b]) <= 0) {
$v8e9f3b97 .= '<div class="warn">Warning: no records found.</div>'."\n";
}
$v8e9f3b97 .= "<table>\n";
if ($this->_is_assoc($vf50a9085[$vdb552e9b])) {

 $v8e9f3b97 .= $this->_record2htmlFieldRow($vf50a9085[$vdb552e9b]);
} else {

 
 $v8e9f3b97 .= '<tr>';
if ($vdb552e9b == 'data' || $vdb552e9b == 'nav') {
$v8e9f3b97 .= '<th></th>'; 
 } else {

 }

 foreach($vf50a9085[$vdb552e9b][0] as $v9d7ecd38 => $v6704d97a) {
$v8e9f3b97 .= '<th>'.htmlspecialchars($v9d7ecd38).'</th>';
}
$v8e9f3b97 .= "</tr>\n";
$vde242769 = 0;
foreach($vf50a9085[$vdb552e9b] as $v5969e3f1) {
if ($vde242769 %2 == 0) {
$v8e9f3b97 .= '<tr class="alt-colour">'."\n";
} else {
$v8e9f3b97 .= "<tr>\n";
}
if ($vdb552e9b == 'data' && isset($vf50a9085['meta'][$vde242769]['href'])) {

 $v8e9f3b97 .= '<td>[ <a id="'.$vf50a9085['meta'][$vde242769]['recordID'].'" href="'.$vf50a9085['meta'][$vde242769]['href'].'">link</a> ]</td>'."\n";
} elseif ($vdb552e9b == 'data') {

 $v8e9f3b97 .= '<td></td>'."\n";
} elseif ($vdb552e9b == 'nav') {

 $v8e9f3b97 .= '<td>[ <a href="'.$v5969e3f1['href'].'">link</a> ]</td>'."\n";
} else {

 }
foreach($v5969e3f1 as $v9d7ecd38 => $v6704d97a) {
$v8e9f3b97 .= '<td><pre>'.htmlspecialchars($v6704d97a)."</pre></td>\n";
}
$v8e9f3b97 .= "</tr>\n";
$vde242769++;
}
}
$v8e9f3b97 .= "</table>\n";
$v8e9f3b97 .= "</div>\n";
}

$v8e9f3b97 .= "</body></html>\n";
return $v8e9f3b97;
}







public function setUsername ($vcbe927fb) {
$this->_username = $vcbe927fb;
}








protected $_username = NULL;










protected function _parse_str($v8e9f3b97, &$v67c4ec2e) {
if (empty($v8e9f3b97)) {
return;
}
$v724c9eae = explode('&', $v8e9f3b97);
foreach ($v724c9eae as $vd7ebe724) {
if (empty($vd7ebe724)) {
continue;
}
$v0f8c181d = explode('=', $vd7ebe724);
$v0f6a519e = urldecode($v0f8c181d[0]);
if (isset($v0f8c181d[1])) {
$v67c4ec2e[$v0f6a519e] = urldecode($v0f8c181d[1]);
} else {
$v67c4ec2e[$v0f6a519e] = '';
}
}
}








protected function _record2htmlFieldRow(array $v658fd71b) {
$v8e9f3b97 = '';
$vde242769 = 0;
foreach($v658fd71b as $v9d7ecd38 => $v6704d97a) {
$v8e9f3b97 .= '<tr><th>'.htmlspecialchars($v9d7ecd38).'</th>';
$va850b22f = '';
if ($vde242769 %2 == 0) {
$va850b22f = ' class="alt-colour"';
}
if (is_array($v6704d97a)) {
$v8e9f3b97 .= '<td>';
$v8e9f3b97 .= "\n".'<table>';
$v8e9f3b97 .= self::_array2htmlItemRow($v6704d97a);
$v8e9f3b97 .= '</table>'."\n";
} else {
$v8e9f3b97 .= '<td'.$va850b22f.'>';
$v8e9f3b97 .= htmlspecialchars($v6704d97a);

 






}
$v8e9f3b97 .= '</td></tr>'."\n";
$vde242769++;
}

return $v8e9f3b97;
}








protected function _array2htmlItemRow(array $v3f96f489) {
$v8e9f3b97 = '';
$vde242769 = 0;
foreach($v3f96f489 as $v6704d97a) {
$v8e9f3b97 .= '<tr>';
$va850b22f = '';
if ($vde242769 %2 == 0) {
$va850b22f = ' class="alt-colour"';
}
if (is_array($v6704d97a)) {
$v8e9f3b97 .= '<td>';
$v8e9f3b97 .= '<table>';
$v8e9f3b97 .= self::_array2htmlItemRow($v6704d97a);
$v8e9f3b97 .= '</table>';
} else {
$v8e9f3b97 .= '<td'.$va850b22f.'>';
$v8e9f3b97 .= htmlspecialchars($v6704d97a);

 






}
$v8e9f3b97 .= '</td></tr>'."\n";
$vde242769++;
}

return $v8e9f3b97;
}
}
