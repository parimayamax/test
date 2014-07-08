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







ini_set('html_errors', FALSE);

require_once 'lib/RESTfm/init_paths.php';

require_once 'lib/tonic/lib/tonic.php';

require_once 'lib/RESTfm/Version.php';
require_once 'lib/RESTfm/RESTfmConfig.php';
require_once 'lib/RESTfm/RESTfmRequest.php';

require_once 'lib/uriRoot.php';
require_once 'lib/uriDatabaseConstant.php';
require_once 'lib/uriDatabaseLayout.php';
require_once 'lib/uriDatabaseEcho.php';
require_once 'lib/uriDatabaseScript.php';
require_once 'lib/uriLayout.php';
require_once 'lib/uriScript.php';
require_once 'lib/uriRecord.php';

require_once 'lib/uriBulk.php';




$config = RESTfmConfig::getConfig();


if ($config['settings']['SSLOnly']) {
if (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' ||
$_SERVER['SERVER_PORT'] == 443) {

 } else {
$vd5cd8bc9 = $_SERVER['REQUEST_URI'];

 if (isset($_SERVER['HTTP_X_ORIGINAL_URL'])) {
$vd5cd8bc9 = $_SERVER['HTTP_X_ORIGINAL_URL'];
}

header("HTTP/1.1 301 Moved Permanently");
header("Location: https://".$_SERVER['HTTP_HOST'].$vd5cd8bc9);
exit();
}
}


$v828b1971 = array(
'baseUri' => $config['settings']['baseURI'],
'acceptFormats' => $config['settings']['formats'],
);

if (isset($_SERVER['HTTP_X_ORIGINAL_URL'])) {
$v828b1971['uri'] = $_SERVER['HTTP_X_ORIGINAL_URL'];
}


$request = new RESTfmRequest($v828b1971);
try {
if (RESTfmConfig::getVar('settings', 'diagnostics') === TRUE) {
require_once 'lib/RESTfm/diagnostic_checks.php';
}
$request->parse();
$v2a46cd82 = $request->loadResource();
$v9adcfedf = $v2a46cd82->exec($request);
} catch (ResponseException $vd18090d2) {
switch ($vd18090d2->getCode()) {
case Response::UNAUTHORIZED:

 

$v9adcfedf = $vd18090d2->response($request);
$v20ae8ce5 = $request->mostAcceptable(RESTfmConfig::getFormats());
if ($v20ae8ce5 != 'html' && $v20ae8ce5 != 'txt' &&
$config['settings']['forbiddenOnUnauthorized']) {
$v9adcfedf->code = Response::FORBIDDEN;
break;
}

$v9adcfedf->addHeader('WWW-Authenticate', 'Basic realm="RESTfm"');
break;

default:
$v9adcfedf = $vd18090d2->response($request);
}
}
$v9adcfedf->output();
