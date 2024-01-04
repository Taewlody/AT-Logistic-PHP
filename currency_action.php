<?php
session_start();
require_once( 'class.php' );
require_once( 'function.php' );
$db=new cl;
$db->connect();
$action=post('action');
$currencyCode=post('currencyCode');
$table=$db->dbname.'.common_currency';

if($action=='add'){

    if ( $currencyCode == '' ) {
        $currencyCode = $db->genarate_docuemntID( 'common_currency', 'currencyCode', 'C', 2 );
      }

    $params=array(
        'comCode'=>$db->comCode,
        'currencyCode'=>$currencyCode,
        'currencyName'=>post("currencyName"), 
        'exchange_rate'=>post("exchange_rate"), 
        'isActive'=>post("isActive"),
        'createID'=>$_SESSION['userID'],
        'createTime'=>date('Y-m-d H:i:s'),
        'editID'=>$_SESSION['userID'],
        'editTime'=>date('Y-m-d H:i:s'));
    if($db->insertData($table,$params)){
        $array = array( 
            "documentID"=>$currencyCode,
            "result"=>'success');
            echo json_encode($array);
    }else{
        $array = array( 
            "documentID"=>'',
            "result"=>'errot');
            echo json_encode($array);
    }
}elseif($action=='edit'){
        $params=array(
        'comCode'=>$db->comCode,
        'currencyCode'=>$currencyCode,
        'currencyName'=>post("currencyName"),
        'exchange_rate'=>post("exchange_rate"), 
        'isActive'=>post("isActive"),
        'editID'=>$_SESSION['userID'],
        'editTime'=>date('Y-m-d H:i:s'));
        if($db->updateData($table,$params,"comCode='$db->comCode' AND currencyCode='$currencyCode'")){
            $array = array( 
                "documentID"=>$currencyCode,
                "result"=>'success');
                echo json_encode($array);
        }else{
            $array = array( 
                "documentID"=>$currencyCode,
                "result"=>'success');
                echo json_encode($array);
        }
}elseif($action=='del'){
	$sql="DELETE FROM $table WHERE comCode='$db->comCode' AND currencyCode='$currencyCode' ";
    if($db->deleteData($sql)){
		echo 'success';
	}else{
		echo $sql;
		 echo 'error';
		
	}
	
	
}
