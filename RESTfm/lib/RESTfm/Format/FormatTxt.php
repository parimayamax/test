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

class FormatTxt extends FormatAbstract {



public function parse (RESTfmDataAbstract $v1736fd6e, $v65e79da0) {
throw RESTfmResponseException('No input parser available for txt format.', 500);
}

public function write (RESTfmDataAbstract $v1736fd6e) {
$v8d65273a = $this->_collate($v1736fd6e);


 
 $v1f754264 = ini_get('html_errors');
if ($v1f754264 == TRUE) {
ini_set('html_errors', FALSE);
}


 ob_start();
var_dump($v8d65273a);
$v8e9f3b97 = ob_get_contents();
ob_end_clean();


 ini_set('html_errors', $v1f754264);

return $v8e9f3b97;
}

}
