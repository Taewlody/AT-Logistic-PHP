<?php
session_start();
require_once( 'class.php' );
require_once( 'function.php' );
$db=new cl;
$db->connect();
$action=post('action');
$pCode=post('pCode');
$table=$db->dbname.'.common_place';

if($action=='add'){

    if ( $pCode == '' ) {
        $pCode = $db->genarate_docuemntID( 'common_place', 'pCode', 'P', 3 );
      }

    $params=array(
        'comCode'=>$db->comCode,
        'pCode'=>$pCode,
        'pName'=>post("pName"), 
        'isActive'=>post("isActive"),
        'createID'=>$_SESSION['userID'],
        'createTime'=>date('Y-m-d H:i:s'),
        'editID'=>$_SESSION['userID'],
        'editTime'=>date('Y-m-d H:i:s'));
    if($db->insertData($table,$params)){
        $array = array( 
            "documentID"=>$pCode,
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
        'pCode'=>$pCode,
        'pName'=>post("pName"),
        'isActive'=>post("isActive"),
        'editID'=>$_SESSION['userID'],
        'editTime'=>date('Y-m-d H:i:s'));
        if($db->updateData($table,$params,"comCode='$db->comCode' AND pCode='$pCode'")){
            $array = array( 
                "documentID"=>$pCode,
                "result"=>'success');
                echo json_encode($array);
        }else{
            $array = array( 
                "documentID"=>$pCode,
                "result"=>'success');
                echo json_encode($array);
        }
}elseif($action=='del'){
	$sql="DELETE FROM $table WHERE comCode='$db->comCode' AND pCode='$pCode' ";
    if($db->deleteData($sql)){
		echo 'success';
	}else{
		echo $sql;
		 echo 'error';
		
	}
	
	
}
