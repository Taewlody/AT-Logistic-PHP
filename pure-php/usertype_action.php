<?php
session_start();
require_once( 'class.php' );
require_once( 'function.php' );
$db=new cl;
$db->connect();
$action=post('action');
$userTypecode=post('userTypecode');
$table=$db->dbname.'.user_type';

if($action=='add'){

    if ( $userTypecode == '' ) {
        $r = $db->fetch("SELECT max(u.userTypecode)+1 as Code FROM user_type AS u");
		$userTypecode=$r['Code'];
      }

    $params=array(
        'comCode'=>$db->comCode,
        'userTypecode'=>$userTypecode,
        'userTypeName'=>post("userTypeName"), 
        'isActive'=>post("isActive"),
        'createID'=>$_SESSION['userID'],
        'createTime'=>date('Y-m-d H:i:s'),
        'editID'=>$_SESSION['userID'],
        'editTime'=>date('Y-m-d H:i:s'));
    if($db->insertData($table,$params)){
        $array = array( 
            "documentID"=>$userTypecode,
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
        'userTypecode'=>$userTypecode,
        'userTypeName'=>post("userTypeName"),
        'isActive'=>post("isActive"),
        'editID'=>$_SESSION['userID'],
        'editTime'=>date('Y-m-d H:i:s'));
        if($db->updateData($table,$params,"comCode='$db->comCode' AND userTypecode='$userTypecode'")){
            $array = array( 
                "documentID"=>$userTypecode,
                "result"=>'success');
                echo json_encode($array);
        }else{
            $array = array( 
                "documentID"=>$userTypecode,
                "result"=>'success');
                echo json_encode($array);
        }
}elseif($action=='del'){
	$sql="DELETE FROM $table WHERE comCode='$db->comCode' AND userTypecode='$userTypecode' ";
    if($db->deleteData($sql)){
		echo 'success';
	}else{
		echo $sql;
		 echo 'error';
		
	}
	
	
}
