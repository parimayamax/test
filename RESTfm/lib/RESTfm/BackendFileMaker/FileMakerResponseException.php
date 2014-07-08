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




class FileMakerResponseException extends RESTfmResponseException {







function __construct(FileMaker_Error $v324b12a4) {
require_once 'FileMaker.php' ;

$v045cbb4d = 500; 
 $v5ba3a1f2 = '';

$vb6511d64 = $v324b12a4->getCode();
$v6696b3f0 = $v324b12a4->getMessage();
if ($vb6511d64 == 101 || $vb6511d64 == 104 || $vb6511d64 == 105) {

 
 
 $v045cbb4d = RESTfmResponseException::NOTFOUND;
} elseif ($vb6511d64 == 22 && stripos($v6696b3f0, 'password') !== FALSE) {

 
 
 
 $v045cbb4d = RESTfmResponseException::UNAUTHORIZED;
} elseif ($vb6511d64 == 18 && stripos($v6696b3f0, 'account') !== FALSE) {

 
 $v045cbb4d = RESTfmResponseException::UNAUTHORIZED;
} elseif ($vb6511d64 == 9 && stripos($v6696b3f0, 'privileges') !== FALSE) {

 
 
 
 $v045cbb4d = RESTfmResponseException::UNAUTHORIZED;
}


 $this->addHeader('X-RESTfm-FM-Status', $vb6511d64);
$this->addHeader('X-RESTfm-FM-Reason', $v6696b3f0);


 if ($v045cbb4d == 500 && empty($v5ba3a1f2)) {
$v5ba3a1f2 = 'FileMaker Error';
}


 parent::__construct($v5ba3a1f2, $v045cbb4d);
}

}
