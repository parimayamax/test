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

require_once 'RESTfm/RESTfmResource.php';
require_once 'RESTfm/RESTfmResponse.php';
require_once 'RESTfm/FileMakerResponseException.php';
require_once 'RESTfm/RESTfmQueryString.php';






class uriTest extends RESTfmResource {

const URI = '/test';










function get($request, $vc1601e44) {
$v8dbb4c62 = RESTfmUrl::decode($vc1601e44);

$v9adcfedf = new RESTfmResponse($request);

$v2afb5758 = new RESTfmQueryString(TRUE);
$vb6561a11 = '';
foreach ($v2afb5758->getRegex('/./') as $v5b476579 => $v6704d97a) {
$vb6561a11 .= $v5b476579 . ' = ' . $v6704d97a . "\n";
}

$v35901568 = new RESTfmQueryString(FALSE);
$v35901568->RFMfixFM01 = 1;
$v35901568->data1 = 'Some AMP&AMP & % / = ? chars';
$vfab76c65 = '';
foreach ($v35901568->getRegex('/./') as $v5b476579 => $v6704d97a) {
$vfab76c65 .= $v5b476579 . ' = ' . $v6704d97a . "\n";
}

$v20ae8ce5 = $v9adcfedf->format;


 $v4b57e907 = new ResourceData();

$v4b57e907->pushData(
array(
'Title' => 'Received RFMfixFM01',
'Data' => $vb6561a11,
),
$request->baseUri.'/test.'.$v20ae8ce5.$v2afb5758->build() );

$v4b57e907->pushData(
array(
'Title' => 'Generated RFMfixFM01',
'Data' => $vfab76c65,
),
$request->baseUri.'/test.'.$v20ae8ce5.$v35901568->buildRFMfixFM01() );

$v9adcfedf->setStatus(Response::OK);
$v9adcfedf->setResourceData($v4b57e907);
return $v9adcfedf;
}
}
