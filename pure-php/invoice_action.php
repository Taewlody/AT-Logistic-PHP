  <?php
session_start();
require_once( 'class.php' );
require_once( 'function.php' );
$db=new cl;
$db->connect();
$action=post('action');
$documentID=post('documentID');

$table=$db->dbname.'.invoice';
$ref_jobID=post("ref_jobID");
$documentDate=formatDate_dash(post('documentDate'));
$on_board=formatDate_dash(post('on_board'));

$chargeitems=post('chargeitems');
$chargesDetail=post('chargesDetail');
$paid=post('paid');
$receive=post('receive');
$chargesPrice=post('chargesPrice');
$total_wh1=0;
$total_wh3=0;


if($action=='add'){
    if($documentID==''){
        $documentID=$db->genarate_docuemntID('invoice','documentID','ATL-ym',4);
    }


         if($chargeitems){
        $i=0;
         foreach($chargeitems as $items){
             
            $params_items=array(
                    'comCode'=>$db->comCode,
                    'documentID'=>$documentID,
                    'chargeCode'=>$items,
                    'detail'=>$chargesDetail[$i],
                    'chargesCost'=>$paid[$i],
                    'chargesReceive'=>$receive[$i],
                    'chargesbillReceive'=>$chargesPrice[$i]       
                    );
                    $db->insertData('invoice_items',$params_items); 
             //$sum_amount+=$amount[$i];
             $i++;
         }
         }
  /*           
            
$sql="SELECT
i.chargesReceive,
sum(t.amount) as amount,
i.documentID
FROM
invoice_items AS i
INNER JOIN common_charge AS c ON i.comCode = c.comCode AND i.chargeCode = c.chargeCode
INNER JOIN common_chargestype AS t ON c.comCode = t.comCode AND c.typeCode = t.typeCode
WHERE  c.comCode='$db->comCode' AND c.documentID='$documentID' 
GROUP BY i.chargeCode ";


$r_items=$db->fetch($sql);   
$vatType=$r_items['amount']; 
$total_cost+=$cost[$i]; 
if($vatType=='1'){
      $total_wh1+=$r;
}
    
if($vatType=='3'){
      $tatal_wh3+=$r;
}
                   
         }  
    
  */  
    
$params=array(
'comCode'=>$db->comCode,
'documentID'=>$documentID,
'documentDate'=>$documentDate,
'cusCode'=>post("cusCode"),
'cus_address'=>post("cus_address"),
'carrier'=>post("carrier"),
'saleman'=>post("saleman"),
'creditterm'=>post("creditTerm"),
'your_RefNo'=>post("your_RefNo"),
'bound'=>post("bound"),
'commodity'=>post("commodity"),
'on_board'=>$on_board,
'freight'=>post("freight"),
'qty_measurement'=>post("qty_measurement"),
'bl_No'=>post("bl_No"),
'ref_jobNo'=>post("ref_jobID"),
'origin_desc'=>post("origin_desc"),
'note'=>post("note"),
'remark'=>post("remark"), 
'documentstatus'=>"P",
'createID'=>$_SESSION['userID'],
'createTime'=>date('Y-m-d H:i:s'),
'editID'=>$_SESSION['userID'],
'editTime'=>date('Y-m-d H:i:s'));
        

 if($db->insertData($table,$params)){
        $array = array( 
            "documentID"=>$documentID,
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
'documentID'=>$documentID,
'documentDate'=>$documentDate,
'cusCode'=>post("cusCode"),
'cus_address'=>post("cus_address"),
'carrier'=>post("carrier"),
'saleman'=>post("saleman"),
'creditterm'=>post("creditTerm"),
'your_RefNo'=>post("your_RefNo"),
'bound'=>post("bound"),
'commodity'=>post("commodity"),
'on_board'=>$on_board,
'freight'=>post("freight"),
'qty_measurement'=>post("qty_measurement"),
'bl_No'=>post("bl_No"),
'ref_jobNo'=>post("ref_jobID"),
'origin_desc'=>post("origin_desc"),
'note'=>post("note"),
'remark'=>post("remark"),
'documentstatus'=>"P",
'editID'=>$_SESSION['userID'],
'editTime'=>date('Y-m-d H:i:s'));
 if($db->updateData($table,$params,"comCode='$db->comCode' AND documentID='$documentID'")){
     
     
         $sqlitems="DELETE FROM invoice_items WHERE comCode='$db->comCode' AND documentID='$documentID' ";
        $db->deleteData($sqlitems); 
        if($chargeitems){
        $i=0;
         foreach($chargeitems as $items){
             
            $params_items=array(
                    'comCode'=>$db->comCode,
                    'documentID'=>$documentID,
                    'chargeCode'=>$items,
                    'detail'=>$chargesDetail[$i],
                    'chargesCost'=>$paid[$i],
                    'chargesReceive'=>$receive[$i],
                    'chargesbillReceive'=>$chargesPrice[$i]       
                    );
                    $db->insertData('invoice_items',$params_items); 
             //$sum_amount+=$amount[$i];
             $i++;
         }
         }
     
     
     
     
        $array = array( 
            "documentID"=>$documentID,
            "result"=>'success');
            echo json_encode($array);
    }else{
        $array = array( 
            "documentID"=>'',
            "result"=>'errot');
            echo json_encode($array);
    }  

}elseif($action=='approve'){  
    
$params=array(
'comCode'=>$db->comCode,
'documentID'=>$documentID,
'documentDate'=>$documentDate,
'cusCode'=>post("cusCode"),
'cus_address'=>post("cus_address"),
'carrier'=>post("carrier"),
'saleman'=>post("saleman"),
'creditterm'=>post("creditTerm"),
'your_RefNo'=>post("your_RefNo"),
'bound'=>post("bound"),
'commodity'=>post("commodity"),
'on_board'=>$on_board,
'freight'=>post("freight"),
'qty_measurement'=>post("qty_measurement"),
'bl_No'=>post("bl_No"),
'ref_jobNo'=>post("ref_jobID"),
'origin_desc'=>post("origin_desc"),
'note'=>post("note"),
'remark'=>post("remark"),      
'documentstatus'=>"A",
'editID'=>$_SESSION['userID'],
'editTime'=>date('Y-m-d H:i:s'));
        
 if($db->updateData($table,$params,"comCode='$db->comCode' AND documentID='$documentID'")){
     
     
     
         $sqlitems="DELETE FROM invoice_items WHERE comCode='$db->comCode' AND documentID='$documentID' ";
        $db->deleteData($sqlitems); 
   if($chargeitems){
        $i=0;
         foreach($chargeitems as $items){
             
            $params_items=array(
                    'comCode'=>$db->comCode,
                    'documentID'=>$documentID,
                    'chargeCode'=>$items,
                    'detail'=>$chargesDetail[$i],
                    'chargesCost'=>$paid[$i],
                    'chargesReceive'=>$receive[$i],
                    'chargesbillReceive'=>$chargesPrice[$i]       
                    );
                    $db->insertData('invoice_items',$params_items); 
             //$sum_amount+=$amount[$i];
             $i++;
         }
         }
     
     
     
     
     
     
     
            $paramsJO=array(
        'invoiceNo'=>$documentID);
        $db->updateData('joborder',$paramsJO,"comCode='$db->comCode' AND documentID='$ref_jobID'");  
     
     
     
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
    
    
    
    
}elseif($action=='del'){
	 $sql="DELETE FROM invoice WHERE comCode='$db->comCode' AND documentID='$documentID' ";
    if($db->deleteData($sql)){
        $sqlitems="DELETE FROM invoice_items WHERE comCode='$db->comCode' AND documentID='$documentID' ";
        $db->deleteData($sqlitems); 
        
        $params=array(
        'invoiceNo'=>'');
        $db->updateData('joborder',$params,"comCode='$db->comCode' AND invoiceNo='$documentID'");  
        
        
		    $array = array( 
            "documentID"=>$documentID,
            "result"=>'success');
            echo json_encode($array);
        
	}else{
		echo $sql;
		 echo 'error';
		
	}
	
	
}
