<?php
session_start();
require_once( 'class.php' );
require_once( 'function.php' );
$db=new cl;
$db->connect();
$action=post('action');
$portCode=post('portCode');
$table=$db->dbname.'.common_port';

if($action=='add'){
    if($portCode==''){
        $portCode=$db->genarate_docuemntID('common_port','portCode','P',3);
    }
        $params=array(
        'comCode'=>$db->comCode,
        'portCode'=>$portCode,
        'portNameTH'=>post("portNameTH"),
        'portNameEN'=>post("portNameEN"),  
        'countryCode'=>post("countryCode"), 
        'isActive'=>post("isActive"),
        'createID'=>$_SESSION['userID'],
        'createTime'=>date('Y-m-d H:i:s'),
        'editID'=>$_SESSION['userID'],
        'editTime'=>date('Y-m-d H:i:s'));
    if($db->insertData($table,$params)){
        $array = array( 
            "documentID"=>$portCode,
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
        'portCode'=>$portCode,
        'portNameTH'=>post("portNameTH"),
        'portNameEN'=>post("portNameEN"),  
        'countryCode'=>post("countryCode"), 
        'isActive'=>post("isActive"),
        'editID'=>$_SESSION['userID'],
        'editTime'=>date('Y-m-d H:i:s'));
        if($db->updateData($table,$params,"comCode='$db->comCode' AND portCode='$portCode'")){
            $array = array( 
                "documentID"=>$portCode,
                "result"=>'success');
                echo json_encode($array);
        }else{
            $array = array( 
                "documentID"=>$portCode,
                "result"=>'error');
                echo json_encode($array);
        }
}elseif($action=='del'){
	$sql="DELETE FROM $table WHERE comCode='$db->comCode' AND portCode='$portCode' ";
    if($db->deleteData($sql)){
		echo 'success';
	}else{
		echo $sql;
		 echo 'error';
		
	}
	
	
}


?>