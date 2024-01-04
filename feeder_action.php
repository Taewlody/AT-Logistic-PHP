<?php
session_start();
require_once( 'class.php' );
require_once( 'function.php' );
$db=new cl;
$db->connect();
$action=post('action');
$fCode=post('fCode');
$table=$db->dbname.'.common_feeder';

if($action=='add'){

    if ( $fCode == '' ) {
         //$fCode = $db->genarate_docuemntID( 'common_feeder', 'fCode', 'F', 5 );
		 $gen= $db->fetch("SELECT concat('Z-',right(concat('00000',right(max(fCode),5)+1),5)) as documentID FROM $db->dbname.common_feeder");
		 $fCode=$gen['documentID'];
      }
    $params=array(
        'comCode'=>$db->comCode,
        'fCode'=>$fCode,
        'fName'=>post("fName"), 
        'isActive'=>post("isActive"),
        'createID'=>$_SESSION['userID'],
        'createTime'=>date('Y-m-d H:i:s'),
        'editID'=>$_SESSION['userID'],
        'editTime'=>date('Y-m-d H:i:s'));
    if($db->insertData($table,$params)){
        $array = array( 
            "documentID"=>$fCode,
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
        'fCode'=>$fCode,
        'fName'=>post("fName"),
        'isActive'=>post("isActive"),
        'editID'=>$_SESSION['userID'],
        'editTime'=>date('Y-m-d H:i:s'));
        if($db->updateData($table,$params,"comCode='$db->comCode' AND fCode='$fCode'")){
            $array = array( 
                "documentID"=>$fCode,
                "result"=>'success');
                echo json_encode($array);
        }else{
            $array = array( 
                "documentID"=>$fCode,
                "result"=>'success');
                echo json_encode($array);
        }
}elseif($action=='del'){
	$sql="DELETE FROM $table WHERE comCode='$db->comCode' AND fCode='$fCode' ";
    if($db->deleteData($sql)){
		echo 'success';
	}else{
		echo $sql;
		 echo 'error';
		
	}
	
	
}
