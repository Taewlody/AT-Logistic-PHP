<?php
session_start();
require_once( 'class.php' );
require_once( 'function.php' );
$db=new cl;
$db->connect();
$action=post('action');
$accountCode=post('accountCode');
$table=$db->dbname.'.common_account';

if($action=='add'){

    $params=array(
        'comCode'=>$db->comCode,
        'accountCode'=>$accountCode,
        'accountName'=>post("accountName"),
        'accountNicname'=>post("accountNicname"), 
        'accountID'=>post("accountID"), 
        
        
        'isActive'=>post("isActive"),
        'createID'=>$_SESSION['userID'],
        'createTime'=>date('Y-m-d H:i:s'),
        'editID'=>$_SESSION['userID'],
        'editTime'=>date('Y-m-d H:i:s'));
    if($db->insertData($table,$params)){
        $array = array( 
            "documentID"=>$accountCode,
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
        'accountCode'=>$accountCode,
        'accountName'=>post("accountName"),
        'accountNicname'=>post("accountNicname"),  
              'accountID'=>post("accountID"), 
        'isActive'=>post("isActive"),
        'editID'=>$_SESSION['userID'],
        'editTime'=>date('Y-m-d H:i:s'));
        if($db->updateData($table,$params,"comCode='$db->comCode' AND accountCode='$accountCode'")){
            $array = array( 
                "documentID"=>$accountCode,
                "result"=>'success');
                echo json_encode($array);
        }else{
            $array = array( 
                "documentID"=>$accountCode,
                "result"=>'success');
                echo json_encode($array);
        }
}elseif($action=='del'){
	$sql="DELETE FROM $table WHERE comCode='$db->comCode' AND accountCode='$accountCode' ";
    if($db->deleteData($sql)){
		echo 'success';
	}else{
		echo $sql;
		 echo 'error';
		
	}
	
	
}
