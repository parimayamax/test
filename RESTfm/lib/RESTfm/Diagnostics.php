<?php
/**
 * @package
 *  RESTfm3
 *
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

require_once 'RESTfmConfig.php';
require_once 'RESTfmLic.php';




class Diagnostics {







private $v8be75122 = array (
'version',
'phpVersion',
'webServerVersion',
'hostServerVersion',
'hostSystemDate',
'documentRoot',

 'baseURI',
'webserverRedirect',
'filemakerAPI',
'filemakerConnect',
'sslEnforced',
'sslServer',
'sslWebserverRedirect',
'xslExtension',
);






private $vf46aba84 = 'lib/RESTfm/Diagnostics.php';





private $v98f52dac = NULL;





private $vb0497af8 = NULL;

private $vb2922744 = NULL;


 



public $hasWarnings = FALSE;





public $hasErrors = FALSE;




public function run() {
$this->vb2922744 = new Report();

foreach ($this->v8be75122 as $vf9cabda8) {
$v0f58fe2a = new ReportItem();
call_user_func(array($this, 'test_'.$vf9cabda8), $v0f58fe2a);
$this->vb2922744->$vf9cabda8 = $v0f58fe2a;

if ($v0f58fe2a->status == ReportItem::WARN) {
$this->hasWarnings = TRUE;
} elseif ($v0f58fe2a->status == ReportItem::ERROR) {
$this->hasErrors = TRUE;
}
}
}




public function setDocumentRoot($v7a021c2a) {
$this->v98f52dac = $v7a021c2a;
}









public function setCallingFilename($v032e0b86) {
$this->vb0497af8 = $v032e0b86;
}




public function getReport() {
return $this->vb2922744;
}



public function test_version($v0f58fe2a) {
$v0f58fe2a->name = 'RESTfm version';
require_once 'Version.php';
$v0f58fe2a->details = Version::getVersion();
}

public function test_phpVersion($v0f58fe2a) {
$v0f58fe2a->name = 'PHP version';
$v0f58fe2a->details = phpversion() . "\n";
if (PHP_VERSION_ID < 50300) {
$v0f58fe2a->status = ReportItem::ERROR;
$v0f58fe2a->details .= "Minimum supported PHP version is: 5.3\n";
}
}

public function test_webServerVersion($v0f58fe2a) {
$v0f58fe2a->name = 'Web Server version';
$v0f58fe2a->details = $_SERVER['SERVER_SOFTWARE'] . "\n";


 if ($this->vb37742467() && $this->vb37742467() < 7.0) {
$v0f58fe2a->status = ReportItem::ERROR;
$v0f58fe2a->details .= 'Microsoft IIS less than version 7.0 is not supported.' . "\n";
}
}

public function test_hostServerVersion($v0f58fe2a) {
$v0f58fe2a->name = 'Host Server version';
$v0f58fe2a->details = "Operating System Name : " . php_uname('s') . "\n" .
"Host Name             : " . php_uname('n') . "\n" .
"Release Name          : " . php_uname('r') . "\n" .
"Version Information   : " . php_uname('v') . "\n" .
"Machine Type          : " . php_uname('m') . "\n";
}

public function test_hostSystemDate($v0f58fe2a) {
$v0f58fe2a->name = 'Host Server date';

 
 $v0f58fe2a->details = @date('Y-m-d H:i:s P (T - e)', time());
}

public function test_documentRoot($v0f58fe2a) {
$v0f58fe2a->name = 'Install location';
$v0f58fe2a->details = $this->v98f52dac . "\n";
}

public function test_licence($v0f58fe2a) {
$v0f58fe2a->name = 'Licence';
$va082737f = new RESTfmLic();

if ($va082737f->exists() == TRUE) {
$v0f58fe2a->details = $va082737f;
} else {
$v0f58fe2a->details .= 'No "Licence.php" file found in: ' . $this->v98f52dac . "\n";
$v0f58fe2a->status = ReportItem::ERROR;
return;
}

if ($va082737f->integrity() === TRUE) {
$v0f58fe2a->details .= "\n" . 'Integrity OK';
} else {
$v0f58fe2a->details .= "\n" . 'Integrity BAD';
$v0f58fe2a->status = ReportItem::ERROR;
return;
}

$v262b5c64 = $va082737f->validate();
if ($v262b5c64 === TRUE) {
$v0f58fe2a->details .= "\n" . 'Validation OK';
} else {
$v0f58fe2a->details .= "\n" . 'Validation BAD:' . "\n" . $v262b5c64;
$v0f58fe2a->status = ReportItem::ERROR;
}
}

public function test_baseURI($v0f58fe2a) {
$config = RESTfmConfig::getConfig();
$v0f58fe2a->name = 'baseURI (' . RESTfmConfig::CONFIG_INI . ')';

$v2e263c92 = $this->v838be094d();

if ($v2e263c92 != $config['settings']['baseURI']) {
$v0f58fe2a->status = ReportItem::ERROR;
$v0f58fe2a->details .= "\n* Does not match URI determined from web server: $v2e263c92\n\n";
$v0f58fe2a->details .= "Instructions:\n\n";
$v0f58fe2a->details .= "- Edit " . RESTfmConfig::CONFIG_INI . " and update 'baseURI' to: $v2e263c92\n\n";
}

if ($this->vfc1e9d499()) {
$v35561155 = @ file_get_contents('.htaccess');
$v03219630 = array();
if ($v35561155 === FALSE) {
$v0f58fe2a->status = ReportItem::ERROR;
$v0f58fe2a->details .= "\n* Unable to read .htaccess to check RewriteBase.\n\n";
$v0f58fe2a->details .= "Instructions:\n\n";
$v0f58fe2a->details .= "- Check that the .htaccess file from the RESTfm archive has been copied to: " . $this->v98f52dac . "\n";
$v0f58fe2a->details .= "  Note: the .htaccess file may be considered a \"hidden file\" by your file browser.\n\n";
$v0f58fe2a->details .= "- Reload this page immediately after this one change to see a reduction in further instructions.\n\n";
} elseif (preg_match('/^\s*RewriteBase\s+(.+?)\s*$/m', $v35561155, $v03219630)) {
if ($v03219630[1] != $config['settings']['baseURI']) {
$v0f58fe2a->status = ReportItem::ERROR;
$v0f58fe2a->details .= "\n* Does not match RewriteBase specified in .htaccess: " . $v03219630[1] . "\n\n";
$v0f58fe2a->details .= "Instructions:\n\n";
$v0f58fe2a->details .= "- Edit .htaccess and update 'RewriteBase' to: $v2e263c92.\n\n";
}
} else {
$v0f58fe2a->status = ReportItem::ERROR;
$v0f58fe2a->details .= "\n* Unable to locate RewriteBase in .htaccess. Please contact Goya support: http://www.restfm.com/help\n\n";
}
}

if ($v0f58fe2a->status == ReportItem::ERROR) {
$ve73d79ba = '';
if ( $v2e263c92 != $config['settings']['baseURI'] &&
strcasecmp($v2e263c92, $config['settings']['baseURI']) == 0) {
$ve73d79ba = "\n* Case sensitivity fault, accessed through URI: $v2e263c92\n\n";
$ve73d79ba .= "Instructions:\n\n";
$ve73d79ba .= "- RESTfm is case sensitive, where Apple's HFS and Windows' NTFS filesystems are not.\n";
$ve73d79ba .= "  Please correct the URL in your browser, and try again.\n\n";
$ve73d79ba .= "- Reload this page immediately after this one change to see a reduction in further instructions.\n\n";
} elseif ($v2e263c92 != '/RESTfm') {

 $ve73d79ba = "\n* For ease of installation, URI should be: /RESTfm but was accessed as: $v2e263c92\n\n";
$ve73d79ba .= "Instructions:\n\n";
$ve73d79ba .= "- To considerably simplify installation, it is *strongly* suggested the RESTfm install folder: $v2e263c92\n";
$ve73d79ba .= "  be changed to: /RESTfm\n\n";
$ve73d79ba .= "- Reload this page immediately after this one change to see a reduction in further instructions.\n\n";
}
$v0f58fe2a->details = $ve73d79ba . $v0f58fe2a->details;
}


 $v0f58fe2a->details = $config['settings']['baseURI'] . "\n" . $v0f58fe2a->details;
}

public function test_webserverRedirect($v0f58fe2a) {
$v0f58fe2a->name = 'Web server redirect to RESTfm.php';

$config = RESTfmConfig::getConfig();

$v868d7dce = $this->v3108d766d() . '/?RFMversion';
if ($config['settings']['SSLOnly'] && ! $this->v83e8f8ade()) {
$v868d7dce = preg_replace('/^http:/', 'https:', $v868d7dce);
}

$v0f58fe2a->details .= '<a href="'. $v868d7dce . '">' . $v868d7dce . '</a>' . "\n";

$v7397a763 = curl_init($v868d7dce);
curl_setopt($v7397a763, CURLOPT_HEADER, 0);
curl_setopt($v7397a763, CURLOPT_CONNECTTIMEOUT, 2);
curl_setopt($v7397a763, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($v7397a763, CURLOPT_SSL_VERIFYPEER, FALSE);
curl_setopt($v7397a763, CURLOPT_FRESH_CONNECT, TRUE);
curl_setopt($v7397a763, CURLOPT_FORBID_REUSE, TRUE);
curl_setopt($v7397a763, CURLOPT_USERAGENT, 'RESTfm Diagnostics');
$v9159e740 = curl_exec($v7397a763);

if (curl_errno($v7397a763)) {
$v0f58fe2a->status = ReportItem::ERROR;
$v0f58fe2a->details .= 'cURL failed with error: ' . curl_error($v7397a763) . "\n";
} elseif ( strpos($v9159e740, 'RESTfm is not configured') ) {
$v0f58fe2a->status = ReportItem::ERROR;
$v0f58fe2a->details .= 'Redirection not working, index.html was returned instead.' . "\n";
if ($this->vfc1e9d499()) {
if ($this->v6ca97deaf()) {
$v0f58fe2a->details .= htmlspecialchars($this->v82b9683eb());
} else {
$v0f58fe2a->details .= 'Check the Apache httpd configuration has \'AllowOverride All\' for the RESTfm directory.' . "\n";
}
}
} elseif ( $v9159e740 != Version::getVersion() ) {
$v0f58fe2a->status = ReportItem::ERROR;
$v0f58fe2a->details .= 'RESTfm failed to respond correctly: ' . $v9159e740 . "\n";
} else {
$v0f58fe2a->details .= 'OK';
}

curl_close($v7397a763);
}

public function test_filemakerAPI($v0f58fe2a) {
$v0f58fe2a->name = 'FileMaker PHP API';

$config = RESTfmConfig::getConfig();

$v868d7dce = $this->v3108d766d() . '/RESTfm.php?RFMcheckFMAPI';
if ($config['settings']['SSLOnly'] && ! $this->v83e8f8ade()) {
$v868d7dce = preg_replace('/^http:/', 'https:', $v868d7dce);
}

$v0f58fe2a->details .= '<a href="'. $v868d7dce . '">' . $v868d7dce . '</a>' . "\n";

$v7397a763 = curl_init($v868d7dce);
curl_setopt($v7397a763, CURLOPT_HEADER, 0);
curl_setopt($v7397a763, CURLOPT_CONNECTTIMEOUT, 2);
curl_setopt($v7397a763, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($v7397a763, CURLOPT_SSL_VERIFYPEER, FALSE);
curl_setopt($v7397a763, CURLOPT_FRESH_CONNECT, TRUE);
curl_setopt($v7397a763, CURLOPT_FORBID_REUSE, TRUE);
curl_setopt($v7397a763, CURLOPT_USERAGENT, 'RESTfm Diagnostics');
$v9159e740 = curl_exec($v7397a763);

if (curl_errno($v7397a763)) {
$v0f58fe2a->status = ReportItem::ERROR;
$v0f58fe2a->details .= 'cURL failed with error: ' . curl_error($v7397a763) . "\n";
} elseif (strpos($v9159e740, 'FileMaker API found') === FALSE) {
$v0f58fe2a->status = ReportItem::ERROR;
$v0f58fe2a->details .= 'FileMaker PHP API not found in PHP include path.' . "\n";
} else {
$v0f58fe2a->details .= $v9159e740;
}

curl_close($v7397a763);
}

public function test_filemakerConnect($v0f58fe2a) {

 
 
 


 

$v0f58fe2a->name = 'FileMaker Server connection test';

if ($this->vb2922744->filemakerAPI->status != ReportItem::OK) {
$v0f58fe2a->status = ReportItem::ERROR;
$v0f58fe2a->details = 'Cannot test, FileMaker PHP API not found.' . "\n";
return;
}

require_once 'init_paths.php';
require_once 'FileMaker.php';

$config = RESTfmConfig::getConfig();
$v0f58fe2a->details .= $config['database']['hostspec'] . "\n";
$v223acdfb = new FileMaker();
$v223acdfb->setProperty('hostspec', $config['database']['hostspec']);
$v223acdfb->setProperty('curlOptions', array(CURLOPT_SSL_VERIFYPEER => false, CURLOPT_PORT => $_SERVER['SERVER_PORT']));

$v147d00c9 = $v223acdfb->listDatabases();
$vf0e8c048 = FALSE;
if (FileMaker::isError($v147d00c9)) {

 
 $vb6511d64 = $v147d00c9->getCode();
$v6696b3f0 = $v147d00c9->getMessage();
if ($vb6511d64 == 22 && stripos($v6696b3f0, 'password') !== FALSE) {
$vf0e8c048 = TRUE;
} elseif ($vb6511d64 == 18 && stripos($v6696b3f0, 'account') !== FALSE) {
$vf0e8c048 = TRUE;
} elseif ($vb6511d64 == 9 && stripos($v6696b3f0, 'privileges') !== FALSE) {
$vf0e8c048 = TRUE;
} else {
$v0f58fe2a->status = ReportItem::ERROR;
$v0f58fe2a->details .= 'FileMaker API returned error: ' . $vb6511d64 . ': ' . $v6696b3f0 . "\n";
return;
}
}

if ($vf0e8c048 == TRUE) {
$v0f58fe2a->details .= 'OK' . "\n";
} else {
$v0f58fe2a->status = ReportItem::WARN;
$v0f58fe2a->details .= 'Connection is OK, but a warning applies:' . "\n";
$v0f58fe2a->details .= 'FileMaker Server allowed the Guest Account to list databases.' . "\n";
$v0f58fe2a->details .= 'The FileMaker Server Admin Console should be used to set Database Server -> Security to: ' . "\n";
$v0f58fe2a->details .= "  'List only the databases each user is authorized to access'" . "\n";
}
}

public function test_sslEnforced($v0f58fe2a) {
$v0f58fe2a->name = 'SSL enforced (' . RESTfmConfig::CONFIG_INI . ')';

$config = RESTfmConfig::getConfig();
if ($config['settings']['SSLOnly'] != TRUE) {
$v0f58fe2a->status = ReportItem::WARN;
$v0f58fe2a->details .= "SSLOnly not TRUE in " . RESTfmConfig::CONFIG_INI . ' configuration file.' . "\n";
$v0f58fe2a->details .= 'SSL is highly recommended to protect data, usernames and passwords from eavesdropping.' . "\n";
} else {
$v0f58fe2a->details .= 'OK' . "\n";
}
}

public function test_sslServer($v0f58fe2a) {
$v0f58fe2a->name = 'SSL enabled on web server';


 $v1d239d5d = ReportItem::WARN;
if ($this->vb2922744->sslEnforced->status == ReportItem::OK) {
$v1d239d5d = ReportItem::ERROR;
}

if ($this->v83e8f8ade() && $this->vb2922744->webserverRedirect->status == ReportItem::OK) {

 $v0f58fe2a->details = "OK";
$v0f58fe2a->status = ReportItem::NA;
return;
}

$v868d7dce = 'https://' . $_SERVER['SERVER_NAME'];
$v0f58fe2a->details .= '<a href="'. $v868d7dce . '">' . $v868d7dce . '</a>' . "\n";

$v7397a763 = curl_init($v868d7dce);
curl_setopt($v7397a763, CURLOPT_HEADER, 0);
curl_setopt($v7397a763, CURLOPT_CONNECTTIMEOUT, 2);
curl_setopt($v7397a763, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($v7397a763, CURLOPT_SSL_VERIFYPEER, FALSE);
curl_setopt($v7397a763, CURLOPT_FRESH_CONNECT, TRUE);
curl_setopt($v7397a763, CURLOPT_FORBID_REUSE, TRUE);
curl_setopt($v7397a763, CURLOPT_USERAGENT, 'RESTfm Diagnostics');
$v9159e740 = curl_exec($v7397a763);

if (curl_errno($v7397a763)) {
$v0f58fe2a->status = $v1d239d5d;
$v0f58fe2a->details .= 'cURL failed with error: ' . curl_errno($v7397a763) . ': ' . curl_error($v7397a763) . "\n";
} else {
$v0f58fe2a->details .= "OK" . "\n";
}
curl_close($v7397a763);
}

public function test_sslWebserverRedirect($v0f58fe2a) {
$v0f58fe2a->name = 'SSL redirect to RESTfm';


 $v1d239d5d = ReportItem::WARN;
if ($this->vb2922744->sslEnforced->status == ReportItem::OK) {
$v1d239d5d = ReportItem::ERROR;
}

if ($this->v83e8f8ade() && $this->vb2922744->webserverRedirect->status == ReportItem::OK) {

 $v0f58fe2a->details = "OK";
$v0f58fe2a->status = ReportItem::NA;
return;
} elseif ($this->vb2922744->sslServer->status != ReportItem::OK) {

 $v0f58fe2a->details = "Not tested, SSL not enabled on web server.";
$v0f58fe2a->status = $v1d239d5d;
return;
}

$v868d7dce = $this->v3108d766d() . '/?RFMversion';
$v868d7dce = preg_replace('/^http:/', 'https:', $v868d7dce);

 $v868d7dce = preg_replace('/:.[0-9]\//', '/', $v868d7dce);

$v0f58fe2a->details .= '<a href="'. $v868d7dce . '">' . $v868d7dce . '</a>' . "\n";

$v7397a763 = curl_init($v868d7dce);
curl_setopt($v7397a763, CURLOPT_HEADER, 0);
curl_setopt($v7397a763, CURLOPT_CONNECTTIMEOUT, 2);
curl_setopt($v7397a763, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($v7397a763, CURLOPT_SSL_VERIFYPEER, FALSE);
curl_setopt($v7397a763, CURLOPT_FRESH_CONNECT, TRUE);
curl_setopt($v7397a763, CURLOPT_FORBID_REUSE, TRUE);
curl_setopt($v7397a763, CURLOPT_USERAGENT, 'RESTfm Diagnostics');
$v9159e740 = curl_exec($v7397a763);

if (curl_errno($v7397a763)) {
$v0f58fe2a->status = ReportItem::WARN;
$v0f58fe2a->details .= 'cURL failed with error: ' . curl_error($v7397a763) . "\n";
} elseif ( strpos($v9159e740, 'RESTfm is not configured') ) {
$v0f58fe2a->status = $v1d239d5d;
$v0f58fe2a->details .= 'Redirection not working, index.html was returned instead.' . "\n";
if ($this->vfc1e9d499()) {
$v0f58fe2a->details .= 'Check the Apache httpd configuration has \'AllowOverride All\' for the RESTfm Directory,' . "\n";
$v0f58fe2a->details .= 'may also be needed in the VirtualHost section for port 443.' . "\n";
}
} elseif (curl_getinfo($v7397a763, CURLINFO_HTTP_CODE) == 404 && $this->v6bc9eecc3()) {
$v0f58fe2a->status = $v1d239d5d;
$v0f58fe2a->details .= htmlspecialchars($this->vc179ba3c2());
} elseif ( $v9159e740 != Version::getVersion() ) {
$v0f58fe2a->status = ReportItem::ERROR;
$v0f58fe2a->details .= 'RESTfm failed to respond correctly: ' . $v9159e740 . "\n";
} else {
$v0f58fe2a->details .= 'OK';
}

curl_close($v7397a763);
}

public function test_xslExtension ($v0f58fe2a) {
$v0f58fe2a->name = 'PHP XSL extension';
if (extension_loaded('xsl')) {
$v0f58fe2a->status = ReportItem::OK;
$v0f58fe2a->details .= 'OK' . "\n";
return;
}

$v0f58fe2a->status = ReportItem::ERROR;
$v0f58fe2a->details .= 'Not Loaded. XSLT will not function.' . "\n";
$v0f58fe2a->details .= 'Only RESTfm .simple, .xml, .json and .html formats are available.' . "\n\n";
if ($this->vb37742467()) {
$v0f58fe2a->details .= "Instructions:\n\n";
$v0f58fe2a->details .= '- Edit the php.ini file: ' . php_ini_loaded_file() . "\n";
$v0f58fe2a->details .= '- Uncomment (remove leading semicolon) from the line that reads: ;extension=php_xsl.dll' . "\n";
$v0f58fe2a->details .= '- Save changes to php.ini file.' . "\n";
$v0f58fe2a->details .= '- Restart IIS to apply the changes.' . "\n";
$v0f58fe2a->details .= '- Reload this page.' . "\n";
} else {
$v0f58fe2a->details .= 'Check that your Operating System has PHP XSL/XML packages installed.' . "\n";
}

}






private function v838be094d() {
$v2e263c92 = $_SERVER['REQUEST_URI'];

 if ($this->vb0497af8 !== NULL) {
$v1bf99420 = strpos($v2e263c92, $this->vb0497af8);
if ($v1bf99420 !== FALSE) {
$v2e263c92 = substr($v2e263c92, 0, $v1bf99420);
}

 $v2e263c92 = rtrim($v2e263c92, '/');
} else {

 $v755dbb07 = strpos($v2e263c92, '?');
if ($v755dbb07 !== FALSE) {
$v2e263c92 = substr($v2e263c92, 0, $v755dbb07);
}
}
return($v2e263c92);
}




private function vfc1e9d499() {
return preg_match('/apache/i', $_SERVER['SERVER_SOFTWARE']);
}





private function vb37742467() {
$v03219630 = array();
if (preg_match('/IIS\/(\d+(\.\d+)?)/', $_SERVER['SERVER_SOFTWARE'], $v03219630)) {
return $v03219630[1];
}
return FALSE;
}




private function v83e8f8ade() {
if (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' ||
$_SERVER['SERVER_PORT'] == 443) {
return TRUE;
}
return FALSE;
}





private function v6ca97deaf() {
if (preg_match('/Darwin/i', php_uname('s'))) {
return php_uname('r');
}
return FALSE;
}




private function v6cc9b276a() {
if ($this->v6ca97deaf === FALSE) { return FALSE; }

$vb76afba7 = @ file_get_contents('/System/Library/LaunchDaemons/org.apache.httpd.plist');
if ($vb76afba7 !== FALSE &&
strstr($vb76afba7, 'MACOSXSERVER') !== FALSE) {
return TRUE;
}
return FALSE;
}





private function vbfcf393aa() {
if ($this->v6ca97deaf === FALSE) { return FALSE; }

$vb76afba7 = @ file_get_contents('/System/Library/LaunchDaemons/org.apache.httpd.plist');
if ($vb76afba7 !== FALSE &&
strstr($vb76afba7, '/Library/Server/Web/Config/apache2') !== FALSE) {
return TRUE;
}
return FALSE;
}




private function v6bc9eecc3() {
if ($this->v6ca97deaf === FALSE) { return FALSE; }


 if (getenv('HTTP_ROOT') === '/Library/FileMaker Server/HTTPServer') {
return TRUE;
}
return FALSE;
}




private function v3108d766d() {
$v868d7dce = 'http://';
if ($this->v83e8f8ade()) {
$v868d7dce = 'https://';
}
$v868d7dce .= $_SERVER['SERVER_NAME'] . ':' . $_SERVER['SERVER_PORT'] . $this->v838be094d();
return($v868d7dce);
}








private function vc2da3b6d4() {

$v7d2f5fcf = "/Library/FileMaker Server/HTTPServer/conf";

$v5574bc24 = "\nFileMaker Server 13 on Apple OSX instructions:\n\n";
$v5574bc24 .= '- Install the httpd config file from the RESTfm package by typing the following in a terminal:' . "\n";
$v5574bc24 .= '    sudo cp "'.$this->v98f52dac.'/contrib/httpd-RESTfm.FMS13.OSX.conf" "'.$v7d2f5fcf.'/extra"' . "\n";

if ($this->v98f52dac !== '/Library/FileMaker Server/HTTPServer/htdocs/RESTfm'
&& $this->v98f52dac !== '/Library/FileMaker Server/HTTPServer/htdocs/httpsRoot/RESTfm') {
$v5574bc24 .= "\n";
$v5574bc24 .= '- Edit "'.$v7d2f5fcf.'/extra/httpd-RESTfm.FMS13.OSX.conf" and replace:' . "\n";
$v5574bc24 .= '    /Library/FileMaker Server/HTTPServer/htdocs/RESTfm' . "\n";
$v5574bc24 .= '  with:' . "\n";
$v5574bc24 .= '    ' . $this->v98f52dac . "\n";
}

$v5574bc24 .= "\n";
$v5574bc24 .= '- Edit "'.$v7d2f5fcf.'/httpd.conf" and append the following line to the end of the file:' . "\n";
$v5574bc24 .= '    Include conf/extra/httpd-RESTfm.FMS13.OSX.conf' . "\n";
$v5574bc24 .= "\n";
$v5574bc24 .= '- Stop the FileMaker service by typing the following in a terminal:' . "\n";
$v5574bc24 .= '    sudo launchctl stop com.filemaker.fms' . "\n";
$v5574bc24 .= "\n";
$v5574bc24 .= '- Wait until the FileMaker service has completely stopped, by checking for output from the following command in a terminal:    ' . "\n";
$v5574bc24 .= '  (No output means that the FileMaker service has stopped.)' . "\n";
$v5574bc24 .= '    ps ax | grep -i filemaker | grep -v grep' . "\n";
$v5574bc24 .= "\n";
$v5574bc24 .= '- Start the FileMaker service by typing the following in a terminal:' . "\n";
$v5574bc24 .= '    sudo launchctl start com.filemaker.fms' . "\n";
$v5574bc24 .= "\n";
$v5574bc24 .= '- Reload this page.' . "\n";

$v5574bc24 .= "\n";

return $v5574bc24;
}











private function vc179ba3c2() {

$v7d2f5fcf = "/Library/FileMaker Server/HTTPServer/conf";

$v5574bc24 = "\nFileMaker Server 13 on Apple OSX instructions:\n\n";

if ($this->v98f52dac == '/Library/FileMaker Server/HTTPServer/htdocs/RESTfm') {

 $v5574bc24 .= 'Create a symbolic link by typing the following in a terminal:' . "\n";
$v5574bc24 .= '    sudo ln -s "/Library/FileMaker Server/HTTPServer/htdocs/RESTfm" "/Library/FileMaker Server/HTTPServer/htdocs/httpsRoot"' . "\n";
$v5574bc24 .= "\n";
$v5574bc24 .= '- Reload this page.' . "\n";
} elseif (strcasecmp(dirname($this->v98f52dac), '/Library/FileMaker Server/HTTPServer/htdocs') == 0) {

 $v03219630 = array();
preg_match('/HTTPserver\/htdocs\/(.+)/i', $this->v98f52dac, $v03219630);
$v3fe23c59 = $v03219630[1];
$v5574bc24 .= '- Create a symbolic link by typing the following in a terminal:' . "\n";
$v5574bc24 .= '    sudo ln -s "/Library/FileMaker Server/HTTPServer/htdocs/' . $v3fe23c59 . '" "/Library/FileMaker Server/HTTPServer/htdocs/httpsRoot/' . $v3fe23c59 . '"' . "\n";
$v5574bc24 .= "\n";
$v5574bc24 .= '- Edit "'.$v7d2f5fcf.'/extra/httpd-RESTfm.FMS13.OSX.conf" and replace:' . "\n";
$v5574bc24 .= '    /Library/FileMaker Server/HTTPServer/htdocs/httpsRoot/RESTfm' . "\n";
$v5574bc24 .= '  with:' . "\n";
$v5574bc24 .= '    /Library/FileMaker Server/HTTPServer/htdocs/httpsRoot/' . $v3fe23c59 . "\n";
$v5574bc24 .= "\n";
$v5574bc24 .= '- Stop the FileMaker service by typing the following in a terminal:' . "\n";
$v5574bc24 .= '    sudo launchctl stop com.filemaker.fms' . "\n";
$v5574bc24 .= "\n";
$v5574bc24 .= '- Wait until the FileMaker service has completely stopped, by checking for output from the following command in a terminal:    ' . "\n";
$v5574bc24 .= '  (No output means that the FileMaker service has stopped.)' . "\n";
$v5574bc24 .= '    ps ax | grep -i filemaker | grep -v grep' . "\n";
$v5574bc24 .= "\n";
$v5574bc24 .= '- Start the FileMaker service by typing the following in a terminal:' . "\n";
$v5574bc24 .= '    sudo launchctl start com.filemaker.fms' . "\n";
$v5574bc24 .= "\n";
$v5574bc24 .= '- Reload this page.' . "\n";
} else {

 $v5574bc24 .= '* Custom document root outside of FMS13 detected. Please contact Goya support: http://www.restfm.com/help' . "\n";
}

return $v5574bc24;
}





private function v82b9683eb() {


 
 if ($this->v6bc9eecc3()) {
return $this->vc2da3b6d4();
}


 $v237ff715 = $this->v6ca97deaf();
$v6aa8d34c = '/etc/apache2/other'; 
 $v2b99d7c8 = 'Default';
if (version_compare($v237ff715, '10', '>=') && version_compare($v237ff715, '11', '<')) {

 $v2b99d7c8 = '10.6 Snow Leopard';
$v6aa8d34c = '/etc/apache2/sites';
} elseif (version_compare($v237ff715, '11', '>=') && version_compare($v237ff715, '12', '<')) {

 $v2b99d7c8 = '10.7 Lion';
$v6aa8d34c = '/etc/apache2/other';


 if ($this->v6cc9b276a()) {
$v2b99d7c8 = '10.7 Lion Server';
$v6aa8d34c = '/etc/apache2/sites';
}
} elseif (version_compare($v237ff715, '12', '>=') && version_compare($v237ff715, '13', '<')) {



 
 
 
 
 

$v2b99d7c8 = '10.8 Mountain Lion';
$v6aa8d34c = '/etc/apache2/other';


 if ($this->vbfcf393aa()) {
$v2b99d7c8 = '10.8 Mountain Lion Server';
$v6aa8d34c = '/Library/Server/Web/Config/apache2/sites';
}
} elseif (version_compare($v237ff715, '13', '>=') && version_compare($v237ff715, '14', '<')) {



 

$v2b99d7c8 = '10.9 Mavericks';
$v6aa8d34c = '/etc/apache2/other';


 if ($this->vbfcf393aa()) {
$v2b99d7c8 = '10.9 Mavericks Server';
$v6aa8d34c = '/Library/Server/Web/Config/apache2/sites';
}
} else {
return ("\nUnknown Apple OSX release (Darwin ". $v237ff715 . '), please contact Goya for support: http://www.restfm.com/help');
}

$v5574bc24 = "\nApple OSX (Darwin " . $v237ff715 . " - " . $v2b99d7c8 . ") instructions:\n\n";

if (! is_dir($v6aa8d34c)) {
$v5574bc24 .= 'Cannot find '. $v6aa8d34c . ', please contact Goya for support: http://www.restfm.com/help';
return ($v5574bc24);
}

$v5574bc24 .= '- Install the httpd config file from the RESTfm package by typing the following in a terminal:' . "\n";
$v5574bc24 .= '    sudo cp "'.$this->v98f52dac.'/contrib/httpd-RESTfm.conf" "'.$v6aa8d34c.'"' . "\n";


 
 
 
 if ($this->v98f52dac != '/Library/WebServer/Documents/RESTfm') {
$v5574bc24 .= "\n";
$v5574bc24 .= '- Edit '.$v6aa8d34c.'/httpd-RESTfm.conf and replace:' . "\n";
$v5574bc24 .= '    /Library/WebServer/Documents/RESTfm' . "\n";
$v5574bc24 .= '  with:' . "\n";
$v5574bc24 .= '    ' . $this->v98f52dac . "\n";
}

$v5574bc24 .= "\n";
$v5574bc24 .= '- Restart the Apache web server by typing the following in a terminal:' . "\n";
$v5574bc24 .= '    sudo /usr/sbin/apachectl restart' . "\n";

$v5574bc24 .= "\n";
$v5574bc24 .= '- Reload this page.' . "\n";

$v5574bc24 .= "\n";
return($v5574bc24);
}
}




class Report implements Iterator {

private $va98bf0bd;
private $v4b58c8ec = 'html';

public function __construct() {
$this->va98bf0bd = array();
}

function rewind() {
return reset($this->va98bf0bd);
}

function current() {
return current($this->va98bf0bd);
}

function key() {
return key($this->va98bf0bd);
}

function next() {
return next($this->va98bf0bd);
}

function valid() {
return key($this->va98bf0bd) !== NULL;
}






function setFormat($v20ae8ce5) {
$this->v4b58c8ec = $v20ae8ce5;
}

function __set($v5b476579, ReportItem $vda58ead5) {
$this->va98bf0bd[$v5b476579] = $vda58ead5;
}

function __get($v5b476579) {
return $this->va98bf0bd[$v5b476579];
}

function __toString() {
$v5574bc24 = ""; 

if ($this->v4b58c8ec == 'html') {
$v5574bc24 .= "\n";

$v5574bc24 .= '<div id="RESTfm_Diagnostic_Report">' . "\n";
$v5574bc24 .= '<table>' . "\n";
foreach ($this->va98bf0bd as $v5b476579 => $vda58ead5) {
if ($vda58ead5->status == ReportItem::NA) {
continue;
}
$v5574bc24 .= '<tr class="' . $vda58ead5->status . '">' . "\n";
$v5574bc24 .= '<td>' . $vda58ead5->name . '</td>' . "\n";
$v5574bc24 .= '<td><pre>' . $vda58ead5->details . '</pre></td>' . "\n";
$v5574bc24 .= "</tr>\n";
}
$v5574bc24 .= '</table>' . "\n";
$v5574bc24 .= <<<EOLEGEND
<br>
Report legend:
<table>
<tr class="OK"><td>Green</td><td>OK.</td></tr>
<tr class="WARN"><td>Yellow</td><td>Warning, but not enough to stop RESTfm from working.</td></tr>
<tr class="ERROR"><td>Red</td><td>Critical error preventing RESTfm from working.</td></tr>
</table>
EOLEGEND;



$v5574bc24 .= '</div>' . "\n";

$v5574bc24 .= "\n";
} else { 
 foreach ($this->va98bf0bd as $v5b476579 => $vda58ead5) {
if ($vda58ead5->status == ReportItem::NA) {
continue;
}
$v5574bc24 .= $vda58ead5->status . ': ' . $vda58ead5->name . "\n";

 foreach(split("\n", rtrim($vda58ead5->details)) as $vce814064) {
$v5574bc24 .= '  ' . $vce814064 . "\n";
}
}
}

return($v5574bc24);
}
}




class ReportItem {


 const NA = 'NA'; 
 const OK = 'OK';
const INFO = 'INFO';
const WARN = 'WARN';
const ERROR = 'ERROR';




public $name;





public $status = self::OK;





public $details;
}
