<?php
session_start();
require_once( 'class.php' );
require_once( 'function.php' );
$db=new cl;
$db->connect();
$action=post('action');
$containertypeCode=post('containertypeCode');
$table=$db->dbname.'.common_containertype';

if($action=='add'){

    if ( $containertypeCode == '' ) {
        $containertypeCode = $db->genarate_docuemntID( 'common_containertype', 'containertypeCode', 'T', 2 );
      }

    $params=array(
        'comCode'=>$db->comCode,
        'containertypeCode'=>$containertypeCode,
        'containertypeName'=>post("containertypeName"), 
        'isActive'=>post("isActive"),
        'createID'=>$_SESSION['userID'],
        'createTime'=>date('Y-m-d H:i:s'),
        'editID'=>$_SESSION['userID'],
        'editTime'=>date('Y-m-d H:i:s'));
    if($db->insertData($table,$params)){
        $array = array( 
            "documentID"=>$containertypeCode,
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
        'containertypeCode'=>$containertypeCode,
        'containertypeName'=>post("containertypeName"),
        'isActive'=>post("isActive"),
        'editID'=>$_SESSION['userID'],
        'editTime'=>date('Y-m-d H:i:s'));
        if($db->updateData($table,$params,"comCode='$db->comCode' AND containertypeCode='$containertypeCode'")){
            $array = array( 
                "documentID"=>$containertypeCode,
                "result"=>'success');
                echo json_encode($array);
        }else{
            $array = array( 
                "documentID"=>$containertypeCode,
                "result"=>'success');
                echo json_encode($array);
        }
}elseif($action=='del'){
	$sql="DELETE FROM $table WHERE comCode='$db->comCode' AND containertypeCode='$containertypeCode' ";
    if($db->deleteData($sql)){
		echo 'success';
	}else{
		echo $sql;
		 echo 'error';
		
	}
	
	
}
