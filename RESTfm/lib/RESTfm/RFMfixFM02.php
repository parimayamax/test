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





class RFMfixFM02 {













public static function postDecode ($v5574bc24) {

$v5574bc24 = str_replace('%3D', '=', $v5574bc24);
$v5574bc24 = str_replace('%26', '&', $v5574bc24);


 $v5574bc24 = str_replace('%25', '%', $v5574bc24);

return ($v5574bc24);
}















public static function preEncode ($v5574bc24) {


 $v5574bc24 = str_replace('%', '%25', $v5574bc24);

$v5574bc24 = str_replace('=', '%3D', $v5574bc24);
$v5574bc24 = str_replace('&', '%26', $v5574bc24);

return ($v5574bc24);
}

};
