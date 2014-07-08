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

require_once 'RESTfm/RESTfmResource.php' ;








class uriDatabaseEcho extends RESTfmResource {

const URI = '/{database}/echo';










function get($request, $vc1601e44) {
return $this->_echo($request, $vc1601e44);
}










function post($request, $vc1601e44) {
return $this->_echo($request, $vc1601e44);
}










function put($request, $vc1601e44) {
return $this->_echo($request, $vc1601e44);
}










function delete($request, $vc1601e44) {
return $this->_echo($request, $vc1601e44);
}













function _echo($request, $vc1601e44) {
$vc1601e44 = RESTfmUrl::decode($vc1601e44);

if (RESTfmConfig::getVar('settings', 'diagnostics') !== TRUE) {
header('HTTP/1.1 200 OK');
header('Content-Type: text/plain; charset=utf-8');
echo "Diagnostics disabled.\n";
exit();
}


 $vc83160b8 = BackendFactory::make($request, $vc1601e44);
$v85e2c809 = $vc83160b8->makeOpsDatabase($vc1601e44);
$va6ce5557 = $v85e2c809->readLayouts();


 $v9adcfedf = new RESTfmResponse($request);

$ve59aa5e2 = $request->getRESTfmParameters();


 header('HTTP/1.1 200 OK');
header('Content-Type: text/plain; charset=utf-8');

echo '        RESTfm ' . Version::getVersion() . ' Echo Service' . "\n";
echo '=========================================================' . "\n";

echo "\n" . '------------ Parameters -------------' . "\n";
echo $ve59aa5e2;

echo "\n" . '------------ Data -------------------' . "\n";
echo $request->getRESTfmData();

echo "\n" . '------------ RESTfm -----------------' . "\n";
echo 'request method=' . $request->method . "\n";
echo 'response format=' . $v9adcfedf->format . "\n";


 if (isset($ve59aa5e2->RFMechoServer)) {
echo "\n" . '------------ $_SERVER ---------------' . "\n";
foreach ($_SERVER as $v5b476579 => $v6704d97a) {
echo $v5b476579 . '="' . addslashes($v6704d97a) . '"' . "\n";
}
}

exit();
}

};
