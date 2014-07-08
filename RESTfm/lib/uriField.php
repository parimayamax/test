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
require_once 'RESTfm/RESTfmRecordID.php';
require_once 'RESTfm/RESTfmQueryString.php';






class uriField extends RESTfmResource {

const URI = '/{database}/layout/{layout}/{rawRecordID}/{field}';
















function get($request, $vc1601e44, $v0df5ea79, $vd5b4f949, $v893b5205) {

$v9adcfedf = new RESTfmResponse($request);
$vc3539d81 = new RESTfmRecordID($vd5b4f949);

$v63de6b20 = $vc3539d81->getRecord(urldecode($vc1601e44), urldecode($v0df5ea79));

if (FileMaker::isError($v63de6b20)) {
throw new FileMakerResponseException($v63de6b20);
}

$v20ae8ce5 = $v9adcfedf->format;

$v4b57e907 = new ResourceData();

$vd5f7c761 = urldecode($v893b5205);


 
 $v95589e8e = $v63de6b20->getLayout();
$v7697a95f = array();
$vabf90e33 = $v95589e8e->getField($vd5f7c761);
if (FileMaker::isError($vabf90e33)) {
throw new FileMakerResponseException($vabf90e33);
}
$v7697a95f['autoEntered'] = $vabf90e33->isAutoEntered() ? 1 : 0;
$v7697a95f['global'] = $vabf90e33->isGlobal() ? 1 : 0;
$v7697a95f['maxRepeat'] = $vabf90e33->getRepetitionCount();
$v7697a95f['resultType'] = $vabf90e33->getResult();


$v03c6026b = $v7697a95f['resultType'];

$v4b57e907->pushFieldMeta($vd5f7c761, $v7697a95f);



 $v14e7addd = array();
$ved7b4d72 = $request->baseUri.'/'.$vc1601e44.'/layout/'.$v0df5ea79.'/'.$vc3539d81.'/'.$v893b5205.'.'.$v20ae8ce5;
if ($v03c6026b == 'container' && method_exists($v223acdfb, 'getContainerDataURL')) {

 $v14e7addd[$vd5f7c761] = $v223acdfb->getContainerDataURL($v63de6b20->getField($vd5f7c761));
} else {
$v14e7addd[$vd5f7c761] = $v63de6b20->getFieldUnencoded($vd5f7c761);
}
$v4b57e907->pushData($v14e7addd, $ved7b4d72, urldecode($vc3539d81));

$v9adcfedf->setStatus(Response::OK);
$v9adcfedf->setResourceData($v4b57e907);
return $v9adcfedf;
}




























function put($request, $vc1601e44, $v0df5ea79, $vd5b4f949, $v893b5205) {


 
 
 return uriRecord::put($request, $vc1601e44, $v0df5ea79, $vd5b4f949);
}


























function delete($request, $vc1601e44, $v0df5ea79, $vd5b4f949, $v893b5205) {


 


 $request->parsedData = array( 'data' => array() );
$request->parsedData['data'][] = array( urldecode($v893b5205) => NULL );

return $this->put($request, $vc1601e44, $v0df5ea79, $vd5b4f949, $v893b5205);
}

}
