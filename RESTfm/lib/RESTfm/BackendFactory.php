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

require_once 'RESTfmConfig.php';
require_once 'RESTfmRequest.php';
require_once 'RESTfmCredentials.php';
require_once 'BackendAbstract.php';




class BackendFactory {






















public static function make (RESTfmRequest $request, $vc1601e44 = NULL) {

 
 $v5c4be057 = 'FileMaker';


 $v61bb5a2c = 'Backend' . $v5c4be057;
$vddae1a49 = dirname(__FILE__) . DIRECTORY_SEPARATOR .
$v61bb5a2c . DIRECTORY_SEPARATOR .
$v61bb5a2c . '.php';
if (!file_exists($vddae1a49)) {
throw new RESTfmResponseException('Unknown backend: ' . $v5c4be057, 500);
}
require_once($vddae1a49);

$v098ef203 = $request->getRESTfmCredentials();

$v68601d21 = new $v61bb5a2c(
RESTfmConfig::getVar('database', 'hostspec'),
$v098ef203->getUsername(),
$v098ef203->getPassword()
);

return $v68601d21;
}

};
