<?php
session_start();
require_once( 'class.php' );
require_once( 'function.php' );
$db=new cl;
$db->connect();
$action=post('action');
$countryCode=post('countryCode');
$table=$db->dbname.'.common_country';

if($action=='add'){

    $params=array(
        'comCode'=>$db->comCode,
        'countryCode'=>$countryCode,
        'countryNameTH'=>post("countryNameTH"),
        'countryNameEN'=>post("countryNameEN"),  
        'isActive'=>post("isActive"),
        'createID'=>$_SESSION['userID'],
        'createTime'=>date('Y-m-d H:i:s'),
        'editID'=>$_SESSION['userID'],
        'editTime'=>date('Y-m-d H:i:s'));
    if($db->insertData($table,$params)){
        $array = array( 
            "documentID"=>$countryCode,
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
        'countryCode'=>$countryCode,
        'countryNameTH'=>post("countryNameTH"),
        'countryNameEN'=>post("countryNameEN"),  
        'isActive'=>post("isActive"),
        'editID'=>$_SESSION['userID'],
        'editTime'=>date('Y-m-d H:i:s'));
        if($db->updateData($table,$params,"comCode='$db->comCode' AND countryCode='$countryCode'")){
            $array = array( 
                "documentID"=>$countryCode,
                "result"=>'success');
                echo json_encode($array);
        }else{
            $array = array( 
                "documentID"=>$countryCode,
                "result"=>'success');
                echo json_encode($array);
        }
}elseif($action=='del'){
	$sql="DELETE FROM $table WHERE comCode='$db->comCode' AND countryCode='$countryCode' ";
    if($db->deleteData($sql)){
		echo 'success';
	}else{
		echo $sql;
		 echo 'error';
		
	}
	
	
}
