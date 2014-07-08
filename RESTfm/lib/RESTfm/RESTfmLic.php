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








class RESTfmLic {







private $v19df958f = array();





private $vbf70e84f = "";





private $vfa187ec5 = FALSE;




public function __construct () {
$vd0ba2b22 = 'alpha'; 
 $v94cd67c9 = '';
$this->vbf70e84f = @ file_get_contents('Licence.php');
$v5c4d51f6 = FALSE;
foreach (preg_split('/\r|\n|\r\n/', $this->vbf70e84f) as $v705f9587) {
if (strpos($v705f9587, '--- Goya Lic') === 0) {
if ($v5c4d51f6) { $v5c4d51f6 = FALSE; }
elseif (! $v5c4d51f6) { $v5c4d51f6 = TRUE; }
continue;
}
if (! $v5c4d51f6) { continue; }
$v3f96f489 = preg_split('/\s*:\s*/', $v705f9587);
if (isset($v3f96f489[0]) && !empty($v3f96f489[0]) && isset($v3f96f489[1]) && !empty($v3f96f489[1])) {
$this->v19df958f[$v3f96f489[0]] = $v3f96f489[1];
if ($v3f96f489[0] !== 'Request' && $v3f96f489[0] !== 'Key') {
$v94cd67c9 .= $v3f96f489[0] . $v3f96f489[1];
}
}
}

 
 if (isset($this->v19df958f['Request']) && md5($v94cd67c9 . $vd0ba2b22) == $this->v19df958f['Request']) {
$this->vfa187ec5 = TRUE;
}
}




public function exists () {
if (!empty($this->v19df958f)) { return TRUE; } else { return FALSE; }
}




public function integrity () {
return $this->vfa187ec5;
}




public function validate () {
return TRUE;

 }




public function __toString () {
if (empty($this->v19df958f)) {
return 'No licence found.';
}

 $v1a0b8227 = 0;
foreach ($this->v19df958f as $v5b476579 => $v6704d97a) {
$v8e2b2fe5 = strlen($v5b476579);
if ($v8e2b2fe5 > $v1a0b8227) { $v1a0b8227 = $v8e2b2fe5; }
}

 $v5574bc24 = '';
foreach ($this->v19df958f as $v5b476579 => $v6704d97a) {
$v8e2b2fe5 = strlen($v5b476579);
$v5ec9cbc3 = $v1a0b8227 - $v8e2b2fe5;
$v5574bc24 .= $v5b476579 . str_repeat(' ', $v5ec9cbc3) . ' : ' . $v6704d97a . "\n";
}
return $v5574bc24;
}

};
