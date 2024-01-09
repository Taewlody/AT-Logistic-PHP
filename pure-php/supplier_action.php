<?php
session_start();
require_once( 'class.php' );
require_once( 'function.php' );
$db = new cl;
$db->connect();
$action = post( 'action' );
$supCode = post( 'supCode' );
$table = $db->dbname . '.common_supplier';

if ( $action == 'add' ) {
  if ( $supCode == '' ) {
    $supCode = $db->genarate_docuemntID( 'common_supplier', 'supCode', 'S', 4 );
  }
  $params = array(

    'comCode' => $db->comCode,
    'supCode' => $supCode,
    'businessType' => post( 'businessType' ),
    'supNameTH' => post( 'custNameTH' ),
    'supNameEN' => post( 'custNameEN' ),
    'branchCode' => post( 'branchCode' ),
    'branchTH' => post('branchTH'),
    'branchEN' => post('branchEN'),
    'taxID' => post( 'taxID' ),
    'addressTH' => post( 'addressTH' ),
    'addressEN' => post( 'addressEN' ),
    'zipCode' => post( 'zipCode' ),
    'countryCode' => post( 'countryCode' ),
    'tel' => post( 'tel' ),
    'fax' => post( 'fax' ),
    'mobile' => post( 'mobile' ),
    'isActive' => post( 'isActive' ),
    'contactName' => post( 'contactName' ),
    'contactMobile' => post( 'contactMobile' ),
    'contactEmail' => post( 'contactEmail' ),
    'createID' => $_SESSION[ 'userID' ],
    'createTime' => date( 'Y-m-d H:i:s' ),
    'editID' => $_SESSION[ 'userID' ],
    'editTime' => date( 'Y-m-d H:i:s' ) );

  if ( $db->insertData( $table, $params ) ) {
    $array = array( 
      "documentID"=>$supCode,
      "result"=>'success');
      echo json_encode($array);
  } else {
    $array = array( 
      "documentID"=>'',
      "result"=>'error');
      echo json_encode($array);
  }
} elseif ( $action == 'edit' ) {
  $params = array(
    'comCode' => $db->comCode,
    'businessType' => post( 'businessType' ),
    'supNameTH' => post( 'custNameTH' ),
    'supNameEN' => post( 'custNameEN' ),
    'branchCode' => post( 'branchCode' ),
    'branchTH' => post('branchTH'),
    'branchEN' => post('branchEN'),
    'taxID' => post( 'taxID' ),
    'addressTH' => post( 'addressTH' ),
    'addressEN' => post( 'addressEN' ),
    'zipCode' => post( 'zipCode' ),
    'countryCode' => post( 'countryCode' ),
    'tel' => post( 'tel' ),
    'fax' => post( 'fax' ),
    'mobile' => post( 'mobile' ),
    'isActive' => post( 'isActive' ),
    'contactName' => post( 'contactName' ),
    'contactMobile' => post( 'contactMobile' ),
    'contactEmail' => post( 'contactEmail' ),
    'editID' => $_SESSION[ 'userID' ],
    'editTime' => date( 'Y-m-d H:i:s' ) );
  if ( $db->updateData( $table, $params, "comCode='$db->comCode' AND supCode='$supCode'" ) ) {
    $array = array( 
      "documentID"=>$supCode,
      "result"=>'success');
      echo json_encode($array);
  } else {
    $array = array( 
      "documentID"=>$supCode,
      "result"=>'error');
      echo json_encode($array);
  }
} elseif ( $action == 'del' ) {
  $sql = "DELETE FROM $table WHERE comCode='$db->comCode' AND supCode='$supCode' ";
  if ( $db->deleteData( $sql ) ) {
    echo 'success';
  } else {
    echo $sql;
    echo 'error';

  }


}


?>