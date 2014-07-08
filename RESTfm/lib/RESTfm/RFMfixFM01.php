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





class RFMfixFM01 {







protected static $_badChars = array (
0x00, 0x21, 0x23, 0x24, 0x26, 0x27, 0x28, 0x29, 0x2A, 0x2B, 0x2C, 0x2F,
0x3A, 0x3B, 0x3D, 0x3F, 0x40, 0x5B, 0x5D,
);











public static function postDecode ($v5574bc24) {


 foreach (self::$_badChars as $v6c442e5c) {
$v5574bc24 = str_replace(sprintf('%%%02X', $v6c442e5c), chr($v6c442e5c), $v5574bc24);
}


 $v5574bc24 = str_replace('%25', '%', $v5574bc24);

return($v5574bc24);
}












public static function preEncode ($v5574bc24) {


 $v5574bc24 = str_replace('%', '%25', $v5574bc24);


 foreach (self::$_badChars as $v6c442e5c) {
$v5574bc24 = str_replace(chr($v6c442e5c), sprintf('%%%02X', $v6c442e5c), $v5574bc24);
}

return ($v5574bc24);
}

};
