<?php
session_start();
require_once( 'class.php' );
require_once( 'function.php' );
$db=new cl;
$db->connect();
$action=post('action');
$chargeCode=post('chargeCode');
$table=$db->dbname.'.common_charge';




if($action=='add'){

        if($chargeCode==''){
            $chargeCode=$db->genarate_docuemntID('common_charge','chargeCode','C-',3);    
        }

    $params=array(
        'comCode'=>$db->comCode,
        'chargeCode'=>$chargeCode,
        'chargeName'=>post("chargeName"),
        'typeCode'=>post("typeCode"),  
        'isActive'=>post("isActive"),
		'purchaseVat'=>post('purchaseVat'),
        'createID'=>$_SESSION['userID'],
        'createTime'=>date('Y-m-d H:i:s'),
        'editID'=>$_SESSION['userID'],
        'editTime'=>date('Y-m-d H:i:s'));
    if($db->insertData($table,$params)){
        $array = array( 
            "documentID"=>$chargeCode,
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
            'chargeCode'=>$chargeCode,
            'chargeName'=>post("chargeName"),
            'typeCode'=>post("typeCode"),  
            'isActive'=>post("isActive"),
			'purchaseVat'=>post('purchaseVat'),
            'editID'=>$_SESSION['userID'],
            'editTime'=>date('Y-m-d H:i:s'));
        if($db->updateData($table,$params,"comCode='$db->comCode' AND chargeCode='$chargeCode'")){
            $array = array( 
                "documentID"=>$chargeCode,
                "result"=>'success');
                echo json_encode($array);
        }else{
            $array = array( 
                "documentID"=>'',
                "result"=>'error');
                echo json_encode($array);
        }
}elseif($action=='del'){
	$sql="DELETE FROM $table WHERE comCode='$db->comCode' AND chargeCode='$chargeCode' ";
    if($db->deleteData($sql)){
		echo 'success';
	}else{
		echo $sql;
		 echo 'error';
		
	}
	
	
}


?>