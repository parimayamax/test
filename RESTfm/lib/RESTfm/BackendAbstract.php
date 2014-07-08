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

require 'OpsDatabaseAbstract.php';
require 'OpsLayoutAbstract.php';
require 'OpsRecordAbstract.php';





abstract class BackendAbstract {









abstract public function __construct ($v994d36ab, $vcbe927fb, $v8a11bc53);









abstract public function makeOpsDatabase ($vc1601e44 = NULL);










abstract public function makeOpsLayout ($vc1601e44, $v0df5ea79);










abstract public function makeOpsRecord ($vc1601e44, $v0df5ea79);

}
