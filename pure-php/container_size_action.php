<?php
session_start();
require_once( 'class.php' );
require_once( 'function.php' );
$db=new cl;
$db->connect();
$action=post('action');
$containersizeCode=post('containersizeCode');
$table=$db->dbname.'.common_containersize';

if($action=='add'){

    if ( $containersizeCode == '' ) {
        $containersizeCode = $db->genarate_docuemntID( 'common_containersize', 'containersizeCode', 'T', 2 );
      }

    $params=array(
        'comCode'=>$db->comCode,
        'containersizeCode'=>$containersizeCode,
        'containersizeName'=>post("containersizeName"), 
        'isActive'=>post("isActive"),
        'createID'=>$_SESSION['userID'],
        'createTime'=>date('Y-m-d H:i:s'),
        'editID'=>$_SESSION['userID'],
        'editTime'=>date('Y-m-d H:i:s'));
    if($db->insertData($table,$params)){
        $array = array( 
            "documentID"=>$containersizeCode,
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
        'containersizeCode'=>$containersizeCode,
        'containersizeName'=>post("containersizeName"),
        'isActive'=>post("isActive"),
        'editID'=>$_SESSION['userID'],
        'editTime'=>date('Y-m-d H:i:s'));
        if($db->updateData($table,$params,"comCode='$db->comCode' AND containersizeCode='$containersizeCode'")){
            $array = array( 
                "documentID"=>$containersizeCode,
                "result"=>'success');
                echo json_encode($array);
        }else{
            $array = array( 
                "documentID"=>$containersizeCode,
                "result"=>'success');
                echo json_encode($array);
        }
}elseif($action=='del'){
	$sql="DELETE FROM $table WHERE comCode='$db->comCode' AND containersizeCode='$containersizeCode' ";
    if($db->deleteData($sql)){
		echo 'success';
	}else{
		echo $sql;
		 echo 'error';
		
	}
	
	
}
