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

require_once 'RESTfmDataAbstract.php';

abstract class FormatAbstract {










abstract public function parse (RESTfmDataAbstract $v1736fd6e, $v65e79da0);








abstract public function write (RESTfmDataAbstract $v1736fd6e);







protected static $_commonDimensions = array (
'info' => 1,
);












protected function _getCommonDimension ($vdb552e9b) {
return isset(self::$_commonDimensions[$vdb552e9b]) ? self::$_commonDimensions[$vdb552e9b] : 2;
}












protected function _collate (RESTfmDataAbstract $v1736fd6e) {
$v3f96f489 = array();

foreach ($v1736fd6e->getSectionNames() as $vdb552e9b) {
$vcb630f3c = $v1736fd6e->getSection($vdb552e9b);
if ($v1736fd6e->getSectionDimensions($vdb552e9b) == 2) {
$v3f96f489[$vdb552e9b] = array_values($vcb630f3c);
} else {
$v3f96f489[$vdb552e9b] = $vcb630f3c;
}
}

return $v3f96f489;
}










protected function _is_assoc ($v67c4ec2e) {
return (is_array($v67c4ec2e) && (!count($v67c4ec2e) || count(array_filter(array_keys($v67c4ec2e),'is_string')) == count($v67c4ec2e)));
}

};
