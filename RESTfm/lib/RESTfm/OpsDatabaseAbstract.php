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

require_once 'BackendAbstract.php';
require_once 'RESTfmResponseException.php';
require_once 'RESTfmDataAbstract.php';










abstract class OpsDatabaseAbstract {






protected $_backend = NULL;









abstract public function __construct (BackendAbstract $vc83160b8, $vc1601e44 = NULL);










abstract public function readDatabases ();










abstract public function readLayouts ();










abstract public function readScripts ();

};
