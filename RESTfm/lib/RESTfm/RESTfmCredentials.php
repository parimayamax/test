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

require_once 'RESTfmConfig.php' ;





class RESTfmCredentials {




private $v6c65ee75 = '';




private $va0ee9dae = '';







public function __construct (RESTfmParameters $vcc4bee18) {

$vcbe927fb = '';
$v8a11bc53 = '';


 if (RESTfmConfig::getVar('database', 'useDefaultAuthentication') === TRUE) {
$vcbe927fb = RESTfmConfig::getVar('database', 'defaultUsername');
$v8a11bc53 = RESTfmConfig::getVar('database', 'defaultPassword');
}


 $config = RESTfmConfig::getConfig();


 $v05dd8340 = $vcc4bee18->RFMkey;
if (isset($v05dd8340) && isset($config['keys'][$v05dd8340])) {
$vcbe927fb = $config['keys'][$v05dd8340][0];
$v8a11bc53 = $config['keys'][$v05dd8340][1];
}


 if (isset($_SERVER['HTTP_AUTHORIZATION']) && preg_match('/Basic\s+(.*)$/i', $_SERVER['HTTP_AUTHORIZATION'], $v03219630)) {
list($vdb3094a2, $v7463b1d4) = explode(':', base64_decode($v03219630[1]));
$_SERVER['PHP_AUTH_USER'] = strip_tags($vdb3094a2);
$_SERVER['PHP_AUTH_PW'] = strip_tags($v7463b1d4);
} elseif (isset($_SERVER['REDIRECT_HTTP_AUTHORIZATION']) && preg_match('/Basic\s+(.*)$/i', $_SERVER['REDIRECT_HTTP_AUTHORIZATION'], $v03219630)) {
list($vdb3094a2, $v7463b1d4) = explode(':', base64_decode($v03219630[1]));
$_SERVER['PHP_AUTH_USER'] = strip_tags($vdb3094a2);
$_SERVER['PHP_AUTH_PW'] = strip_tags($v7463b1d4);
}


 if (isset($_SERVER['PHP_AUTH_USER'])) {
$v05dd8340 = $_SERVER['PHP_AUTH_USER'];
if (isset($v05dd8340) && isset($config['keys'][$v05dd8340])) {
$vcbe927fb = $config['keys'][$v05dd8340][0];
$v8a11bc53 = $config['keys'][$v05dd8340][1];
} else {
$vcbe927fb = $_SERVER['PHP_AUTH_USER'];
if (isset($_SERVER['PHP_AUTH_PW'])) {
$v8a11bc53 = $_SERVER['PHP_AUTH_PW'];
}
}
}


 if (!empty($vcbe927fb)) {
$this->v6c65ee75 = $vcbe927fb;
}
if (!empty($v8a11bc53)) {
$this->va0ee9dae = $v8a11bc53;
}
}






public function getUsername () {
return $this->v6c65ee75;
}






public function getPassword () {
return $this->va0ee9dae;
}

};
