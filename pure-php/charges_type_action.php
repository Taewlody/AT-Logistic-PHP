<?php
session_start();
require_once( 'class.php' );
require_once( 'function.php' );
$db=new cl;
$db->connect();
$action=post('action');
$typeCode=post('typeCode');
$table=$db->dbname.'.common_chargestype';

if($action=='add'){
    if($typeCode==''){
        $typeCode=$db->genarate_docuemntID('common_chargestype','typeCode','V-',2);    
    }
    $params=array(
        'comCode'=>$db->comCode,
        'typeCode'=>$typeCode,
        'typeName'=>post("typeName"),
        'vatType'=>post("vatType"),  
        'amount'=>post("amount"), 
        'isActive'=>post("isActive"),
        'createID'=>$_SESSION['userID'],
        'createTime'=>date('Y-m-d H:i:s'),
        'editID'=>$_SESSION['userID'],
        'editTime'=>date('Y-m-d H:i:s'));
    if($db->insertData($table,$params)){
        $array = array( 
            "documentID"=>$typeCode,
            "result"=>'success');
            echo json_encode($array);
    }else{
        $array = array( 
            "documentID"=>'',
            "result"=>'error');
            echo json_encode($array);
    }
}elseif($action=='edit'){
        $params=array(
            'comCode'=>$db->comCode,
            'typeCode'=>$typeCode,
            'typeName'=>post("typeName"),
            'vatType'=>post("vatType"),  
            'amount'=>post("amount"), 
            'isActive'=>post("isActive"),
            'editID'=>$_SESSION['userID'],
            'editTime'=>date('Y-m-d H:i:s'));
        if($db->updateData($table,$params,"comCode='$db->comCode' AND typeCode='$typeCode'")){
            $array = array( 
                "documentID"=>$typeCode,
                "result"=>'success');
                echo json_encode($array);
        }else{
            $array = array( 
                "documentID"=>$typeCode,
                "result"=>'error');
                echo json_encode($array);
        }
}elseif($action=='del'){
	$sql="DELETE FROM $table WHERE comCode='$db->comCode' AND typeCode='$typeCode' ";
    if($db->deleteData($sql)){
		echo 'success';
	}else{
		echo $sql;
		 echo 'error';
		
	}
	
	
}


?>