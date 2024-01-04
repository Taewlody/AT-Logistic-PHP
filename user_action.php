<?php
session_start();
require_once( 'class.php' );
require_once( 'function.php' );
$db=new cl;
$db->connect();
$action=post('action');
$usercode=post('usercode');
$table=$db->dbname.'.user';
if($action=='add'){
        $params=array(
        'comCode'=>$db->comCode,
        'usercode'=>$usercode,
        'userpass'=>md5(post("userpass")),  
        'username'=>post("username"), 
        'surname'=>post("surname"),         
        'userTypecode'=>post("userTypecode"),     
        'isActive'=>post("isActive"),
        'createID'=>$_SESSION['userID'],
        'createTime'=>date('Y-m-d H:i:s'),
        'editID'=>$_SESSION['userID'],
        'editTime'=>date('Y-m-d H:i:s'));
    if($db->insertData($table,$params)){

            $array = array( 
            "documentID"=>post("usercode"),
            "result"=>'success');
            echo json_encode($array);
    }else{
        $array = array( 
            "documentID"=>'',
            "result"=>'error');
            echo json_encode($array);
    }
}elseif($action=='edit'){
    
    if(post("checkPass")==post("userpass")){
        $params=array(
        'comCode'=>$db->comCode,
        'username'=>post("username"), 
        'surname'=>post("surname"),         
        'userTypecode'=>post("userTypecode"),     
        'isActive'=>post("isActive"),
        'editID'=>$_SESSION['userID'],
        'editTime'=>date('Y-m-d H:i:s')); 
    }else{
        $params=array(
        'comCode'=>$db->comCode,
        'userpass'=>md5(post("userpass")), 
        'username'=>post("username"), 
        'surname'=>post("surname"),         
        'userTypecode'=>post("userTypecode"),     
        'isActive'=>post("isActive"),
        'editID'=>$_SESSION['userID'],
        'editTime'=>date('Y-m-d H:i:s'));   
    }
    

    
    
    
    
        if($db->updateData($table,$params,"comCode='$db->comCode' AND usercode='$usercode'")){
            $array = array( 
                "documentID"=>$usercode,
                "result"=>'success');
                echo json_encode($array);
        }else{
            $array = array( 
                "documentID"=>post("usercode"),
                "result"=>'error');
                echo json_encode($array);
        }
}elseif($action=='del'){
	$sql="DELETE FROM $table WHERE comCode='$db->comCode' AND usercode='$usercode' ";
    if($db->deleteData($sql)){
		echo 'success';
	}else{
		echo $sql;
		 echo 'error';
		
	}
	
	
}


?>