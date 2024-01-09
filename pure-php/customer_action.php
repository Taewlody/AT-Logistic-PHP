<?php
session_start();
require_once( 'class.php' );
require_once( 'function.php' );
$db = new cl;
$db->connect();
$action = post( 'action' );
$cusCode = post( 'cusCode' );
$table = $db->dbname . '.common_customer';

if ( $action == 'add' ) {
  if ( $cusCode == '' ) {
    $cusCode = $db->genarate_docuemntID( 'common_customer', 'cusCode', 'C', 4 );
  }
  $params = array(

    'comCode' => $db->comCode,
    'cusCode' => $cusCode,
    'businessType' => post( 'businessType' ),
    'custNameTH' => post( 'custNameTH' ),
    'custNameEN' => post( 'custNameEN' ),
    'branchCode' => post( 'branchCode' ),
    'branchTH' => post('branchTH'),
    'branchEN' => post('branchEN'),
    'creditDay' => post( 'creditDay' ),
    'taxID' => post( 'taxID' ),
    'salemanID' => post( 'salemanID' ),
    'addressTH' => post( 'addressTH' ),
    'addressEN' => post( 'addressEN' ),
    'zipCode' => post( 'zipCode' ),
    'countryCode' => post( 'countryCode' ),
    'tel' => post( 'tel' ),
    'fax' => post( 'fax' ),
    'mobile' => post( 'mobile' ),
    'salemanID' => post( 'salemanID' ),
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
      "documentID"=>$cusCode,
      "result"=>'success');
     
      if (file_exists("customer_path/$cusCode")) {
      }else{
        mkdir("customer_path/$cusCode", 0700);
      }
    
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
    'custNameTH' => post( 'custNameTH' ),
    'custNameEN' => post( 'custNameEN' ),
    'branchCode' => post( 'branchCode' ),
    'branchTH' => post('branchTH'),
    'branchEN' => post('branchEN'),
    'creditDay' => post( 'creditDay' ),
    'taxID' => post( 'taxID' ),
    'salemanID' => post( 'salemanID' ),
    'addressTH' => post( 'addressTH' ),
    'addressEN' => post( 'addressEN' ),
    'zipCode' => post( 'zipCode' ),
    'countryCode' => post( 'countryCode' ),
    'tel' => post( 'tel' ),
    'fax' => post( 'fax' ),
    'mobile' => post( 'mobile' ),
    'salemanID' => post( 'salemanID' ),
    'isActive' => post( 'isActive' ),
    'contactName' => post( 'contactName' ),
    'contactMobile' => post( 'contactMobile' ),
    'contactEmail' => post( 'contactEmail' ),
    'editID' => $_SESSION[ 'userID' ],
    'editTime' => date( 'Y-m-d H:i:s' ) );
  if ( $db->updateData( $table, $params, "comCode='$db->comCode' AND cusCode='$cusCode'" ) ) {
    $array = array( 
      "documentID"=>$cusCode,
      "result"=>'success');
      echo json_encode($array);
  } else {
    $array = array( 
      "documentID"=>$cusCode,
      "result"=>'error');
      echo json_encode($array);
  }
} elseif ( $action == 'del' ) {
  $sql = "DELETE FROM $table WHERE comCode='$db->comCode' AND cusCode='$cusCode' ";
  if ( $db->deleteData( $sql ) ) {
    echo 'success';
  } else {
    echo $sql;
    echo 'error';

  }


}


?>