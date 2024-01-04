<?php
session_start();
require_once( 'class.php' );
require_once( 'function.php' );
$db = new cl;
$db->connect();
$action = post( 'action' );
$empCode = post( 'empCode' );
$table = $db->dbname . '.common_saleman';

if ( $action == 'add' ) {
  $params = array(
    'comCode' => $db->comCode,
    'empCode' => $empCode,
    'empName' => post( 'empName' ),
    'empSurname' => post( 'empSurname' ), 
    'usercode' => post( 'usercode' ),
    'mobile' => post( 'mobile' ),
    'phone' => post('phone'),
    'email' => post('email'),
    'isActive'=>post('isActive'),
    'createID' => $_SESSION[ 'userID' ],
    'createTime' => date( 'Y-m-d H:i:s' ),
    'editID' => $_SESSION[ 'userID' ],
    'editTime' => date( 'Y-m-d H:i:s' ) );

  if ( $db->insertData( $table, $params ) ) {
    $array = array( 
      "documentID"=>$empCode,
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
        'empCode' => $empCode,
        'empName' => post( 'empName' ),
        'empSurname' => post( 'empSurname' ), 
        'usercode' => post( 'usercode' ),
        'mobile' => post( 'mobile' ),
        'isActive'=>post('isActive'),
        'phone' => post('phone'),
        'email' => post('email'),
        'editID' => $_SESSION[ 'userID' ],
        'editTime' => date( 'Y-m-d H:i:s' ) );
  if ( $db->updateData( $table, $params, "comCode='$db->comCode' AND empCode='$empCode'" ) ) {
    $array = array( 
      "documentID"=>$empCode,
      "result"=>'success');
      echo json_encode($array);
  } else {
    $array = array( 
      "documentID"=>$empCode,
      "result"=>'error');
      echo json_encode($array);
  }
} elseif ( $action == 'del' ) {
  $sql = "DELETE FROM $table WHERE comCode='$db->comCode' AND empCode='$empCode' ";
  if ( $db->deleteData( $sql ) ) {
    echo 'success';
  } else {
    echo $sql;
    echo 'error';

  }


}


?>