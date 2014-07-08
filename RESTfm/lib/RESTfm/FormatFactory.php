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

require_once 'FormatAbstract.php';




class FormatFactory {













public static function makeFormatter ($v5c4be057 = 'html') {

 if (isset(self::$vee75bb71[$v5c4be057])) {
$v5c4be057 = self::$vee75bb71[$v5c4be057];
}


 $ve3b2d951 = 'lib/RESTfm/Format/';
$v2ddbb88c = 'Format' . ucfirst(strtolower($v5c4be057));
if (!file_exists($ve3b2d951 . $v2ddbb88c . '.php')) {
throw new RESTfmResponseException('Unknown format: ' . $v5c4be057, 500);
}
require_once($ve3b2d951 . $v2ddbb88c . '.php');
return new $v2ddbb88c();
}





protected static $vee75bb71 = array(
'application/x-www-form-urlencoded' => 'html',
);

}
