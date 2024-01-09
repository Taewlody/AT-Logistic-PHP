<?php
session_start();
require_once( 'class.php' );
require_once( 'function.php' );
$db=new cl;
$db->connect();
$action=post('action');
$documentID=post('documentID');
$table=$db->dbname.'.trailer_booking';
$ref_jobID=post("ref_jobID");
if($action=='add'){
    if($documentID==''){
        $documentID=$db->genarate_docuemntID('trailer_booking','documentID','T-ym',4);
    }
$params=array(
'comCode'=>$db->comCode,
'documentID'=>$documentID,
'documentDate'=>formatDate_dash(post('documentDate')),
'ref_jobID'=>$ref_jobID,
'cusCode'=>post("cusCode"),
'feeder'=>post("feeder"),
'agent'=>post("agentCode"),
'tocompany'=>post("tocompany"),
'companyContact'=>post("companyContact"),
'work_order'=>post("work_order"),
'description'=>post("description"),
'loadplace'=>post("loadplace"),
'packagingDate'=>post("packagingDate"),
'contact'=>post("contact"),
'documentstatus'=>'P',
'createID'=>$_SESSION['userID'],
'createTime'=>date('Y-m-d H:i:s'),
'editID'=>$_SESSION['userID'],
'editTime'=>date('Y-m-d H:i:s'));





    if($db->insertData($table,$params)){
        
        $params_jo=array('documentID'=>$ref_jobID,'trailer_bookingNO'=>$documentID);
        $db->updateData('joborder',$params_jo,"comCode='$db->comCode' AND documentID='$ref_jobID'");

        $array = array( 
            "documentID"=>$documentID,
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
        'documentID'=>$documentID,
        'documentDate'=>formatDate_dash(post('documentDate')),
        'ref_jobID'=>$ref_jobID,
        'cusCode'=>post("cusCode"),
        'feeder'=>post("feeder"),
        'agent'=>post("agentCode"),
        'tocompany'=>post("tocompany"),
        'companyContact'=>post("companyContact"),
        'work_order'=>post("work_order"),
        'description'=>post("description"),
        'loadplace'=>post("loadplace"),
        'packagingDate'=>post("packagingDate"),
        'contact'=>post("contact"),
        'documentstatus'=>'P',
        'editID'=>$_SESSION['userID'],
        'editTime'=>date('Y-m-d H:i:s'));
        
        



        if($db->updateData($table,$params,"comCode='$db->comCode' AND documentID='$documentID'")){
            $array = array( 
                "documentID"=>$documentID,
                "result"=>'success');
                echo json_encode($array);
        }else{
            $array = array( 
                "documentID"=>$documentID,
                "result"=>'error');
                echo json_encode($array);
        }
}elseif($action=='approve'){  
    $params=array(
        'comCode'=>$db->comCode,
        'documentID'=>$documentID,
        'documentDate'=>formatDate_dash(post('documentDate')),
        'ref_jobID'=>$ref_jobID,
        'cusCode'=>post("cusCode"),
        'feeder'=>post("feeder"),
        'agent'=>post("agentCode"),
        'tocompany'=>post("tocompany"),
        'companyContact'=>post("companyContact"),
        'work_order'=>post("work_order"),
        'description'=>post("description"),
        'loadplace'=>post("loadplace"),
        'packagingDate'=>post("packagingDate"),
        'contact'=>post("contact"),
        'documentstatus'=>'A',
        'editID'=>$_SESSION['userID'],
        'editTime'=>date('Y-m-d H:i:s'));
        
        

        if($db->updateData($table,$params,"comCode='$db->comCode' AND documentID='$documentID'")){
            $array = array( 
                "documentID"=>$documentID,
                "result"=>'success');
                echo json_encode($array);
        }else{
            $array = array( 
                "documentID"=>$documentID,
                "result"=>'error');
                echo json_encode($array);
        }
   
}elseif($action=='del'){

	 $sql="DELETE FROM $table WHERE comCode='$db->comCode' AND documentID='$documentID' ";
    if($db->deleteData($sql)){
		echo 'success';
	}else{
		echo $sql;
		 echo 'error';
	}
	
	
}


?>