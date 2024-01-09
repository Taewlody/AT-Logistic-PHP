  <?php
session_start();
require_once( 'class.php' );
require_once( 'function.php' );
$db=new cl;
$db->connect();
$action=post('action');
$documentID=post('documentIDx');
$table=$db->dbname.'.tax_invoice';
$ref_jobID=post("ref_jobID");
$documentDate=formatDate_dash(post('documentDate'));
$dueDate=formatDate_dash(post('dueDate'));
$cus_paid=post('cus_paid2');
$on_board=formatDate_dash(post('on_board'));
$accountCode=post('accountCode');
$chargeitems=post('chargeitems');
$chargesDetail=post('chargesDetail');
$paid=post('paid');
$receive=post('receive');
$invNo=post('invNo');
$chargesPrice=post('chargesPrice');
$total_wh1=0;
$total_wh3=0;


 


$total_chargesCost=0;
$total_chargesReceive=0;
$total_chargesbillReceive=0;
$vat_total_chargesCost=0;
$vat_total_chargesReceive=0;
$vat_total_chargesbillReceive=0;

$total_tax1=0;
$total_tax3=0;
    
$total_amt=0;
$tax3=0; 
$tax1=0;
if($cus_paid==''){$cus_paid=0;  }

$total_netamt=0;
if($action=='add'){
  if($documentID==''){
   	$documentID=$db->genarate_docuemntID('tax_invoice','documentID','A-ym',5);
    }
if($chargeitems){
        $i=0;
         foreach($chargeitems as $items){
             
            $params_items=array(
                    'comCode'=>$db->comCode,
                    'documentID'=>$documentID,
                    'invNo'=>$invNo[$i],
                    'chargeCode'=>$items,
                    'detail'=>$chargesDetail[$i],
                    'chargesCost'=>$paid[$i],
                    'chargesReceive'=>$receive[$i],
                    'chargesbillReceive'=>$chargesPrice[$i]       
                    );
                    $db->insertData('tax_invoice_items',$params_items); 
             
            
                   $paramsIV=array('taxivRef'=>$documentID);
                   $db->updateData('invoice',$paramsIV,"comCode='$db->comCode' AND documentID='$invNo[$i]'");  
             
             
            
             
             
             //$sum_amount+=$amount[$i];
             $i++;
         }
     
 /*   
$sql_cudpaid="SELECT sum(t.cus_paid) as cus_paid from (
SELECT
t.documentID,
i.cus_paid
FROM
tax_invoice_items AS t
INNER JOIN invoice AS i ON t.comCode = i.comCode AND t.invNo = i.documentID
WHERE t.documentID='$documentID'
GROUP BY  i.documentID) as t 
GROUP BY  t.documentID ";
$r_cus = $db->fetch($sql_cudpaid ); 
$cus_paid=$r_cus['cus_paid'];        
             
   */ 
    
    
    

 $sql="SELECT
i.comCode,
i.documentID,
i.chargeCode,
i.detail,
sum(i.chargesCost) as  chargesCost ,
sum(i.chargesReceive) as  chargesReceive,
sum(i.chargesbillReceive) as chargesbillReceive,
t.amount
FROM
tax_invoice_items AS i
INNER JOIN  common_charge AS c   ON  i.comCode = c.comCode AND  i.chargeCode = c.chargeCode
INNER JOIN  common_chargestype AS t  ON  c.comCode = t.comCode AND c.typeCode = t.typeCode
WHERE i.documentID ='$documentID'
GROUP BY i.chargeCode
";
$result=$db->query($sql);
$i=1;
$isActiveStype="";
while($r=mysqli_fetch_array($result)){
$total_chargesCost+=$r['chargesCost'];
$total_chargesReceive+=$r['chargesReceive'];
$total_chargesbillReceive+=$r['chargesbillReceive'];
$vatType=$r['amount']; 
if($vatType=='1'){
      $total_tax1+=$r['chargesReceive'];
}   
if($vatType=='3'){
      $total_tax3+=$r['chargesReceive'];
}
    
    
}
             
$vat_total_chargesCost=($total_chargesCost*7/100);
$vat_total_chargesReceive=($total_chargesReceive*7/100);
$vat_total_chargesbillReceive=($total_chargesbillReceive*7/100);

$total_amt=($total_chargesReceive+$total_chargesbillReceive+$vat_total_chargesReceive);
//$total_amt=($total_chargesReceive+$vat_total_chargesReceive);	
$tax3=($total_tax3*3/100);   
$tax1=($total_tax1*1/100);
$grand_total=$total_amt-$tax1-$tax3;
$total_netamt=$grand_total-$cus_paid;	

        
                   
}  
    

    
$params=array(
'comCode'=>$db->comCode,
'documentID'=>$documentID,
'documentDate'=>$documentDate,
'cusCode'=>post("cusCode"),
'cus_address'=>post("cus_address"),
'creditterm'=>post("creditTerm"),
'note'=>post("note"),
'remark'=>post("remark"),
'documentstatus'=>"P",
'createID'=>$_SESSION['userID'],
'createTime'=>date('Y-m-d H:i:s'),
'editID'=>$_SESSION['userID'],
'editTime'=>date('Y-m-d H:i:s'),
'total_amt'=>$total_amt, 
'total_vat'=>$vat_total_chargesReceive, 
'tax3'=>$tax3, 
'tax1'=>$tax1, 
'cus_paid'=>$cus_paid, 
'total_netamt'=>$total_netamt,
'accountCode'=>$accountCode,	
'payType'=>post("payType"),
'payTypeOther'=>post("payTypeOther"),
'branch'=>post("branch"),
'chequeNo'=>post("chequeNo"),
'dueDate'=>$dueDate,
'dueTime'=>post("dueTime")


);      

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
    
    $sql="DELETE FROM tax_invoice_items  WHERE comCode='$db->comCode' AND documentID='$documentID' ";   
$db->deleteData($sql);  
               

     $i=0;
         foreach($chargeitems as $items){
                    $params_items=array(
                    'comCode'=>$db->comCode,
                    'documentID'=>$documentID,
                    'invNo'=>$invNo[$i],
                    'chargeCode'=>$items,
                    'detail'=>$chargesDetail[$i],
                    'chargesCost'=>$paid[$i],
                    'chargesReceive'=>$receive[$i],
                    'chargesbillReceive'=>$chargesPrice[$i]       
                    );
                    $db->insertData('tax_invoice_items',$params_items); 
			 $i++;
		 }
	
 $sql="SELECT
i.comCode,
i.documentID,
i.chargeCode,
i.detail,
sum(i.chargesCost) as  chargesCost ,
sum(i.chargesReceive) as  chargesReceive,
sum(i.chargesbillReceive) as chargesbillReceive,
t.amount
FROM
tax_invoice_items AS i
INNER JOIN  common_charge AS c   ON  i.comCode = c.comCode AND  i.chargeCode = c.chargeCode
INNER JOIN  common_chargestype AS t  ON  c.comCode = t.comCode AND c.typeCode = t.typeCode
WHERE i.documentID ='$documentID'
GROUP BY i.chargeCode
";
$result=$db->query($sql);
$i=1;
$isActiveStype="";
while($r=mysqli_fetch_array($result)){
$total_chargesCost+=$r['chargesCost'];
$total_chargesReceive+=$r['chargesReceive'];
$total_chargesbillReceive+=$r['chargesbillReceive'];
$vatType=$r['amount']; 
if($vatType=='1'){
      $total_tax1+=$r['chargesReceive'];
}   
if($vatType=='3'){
      $total_tax3+=$r['chargesReceive'];
}
    
    
}
             
$vat_total_chargesCost=($total_chargesCost*7/100);
$vat_total_chargesReceive=($total_chargesReceive*7/100);
$vat_total_chargesbillReceive=($total_chargesbillReceive*7/100);

$total_amt=($total_chargesReceive+$total_chargesbillReceive+$vat_total_chargesReceive);
//$total_amt=($total_chargesReceive+$vat_total_chargesReceive);	
$tax3=($total_tax3*3/100);   
$tax1=($total_tax1*1/100);
$grand_total=$total_amt-$tax1-$tax3;
$total_netamt=$grand_total-$cus_paid;	
	
    
    
$params=array(
'comCode'=>$db->comCode,
'documentID'=>$documentID,
'documentDate'=>$documentDate,
'cusCode'=>post("cusCode"),
'cus_address'=>post("cus_address"),
'creditterm'=>post("creditTerm"),
'note'=>post("note"),
'remark'=>post("remark"),
'documentstatus'=>"P",
'createID'=>$_SESSION['userID'],
'createTime'=>date('Y-m-d H:i:s'),
'editID'=>$_SESSION['userID'],
'editTime'=>date('Y-m-d H:i:s'),
'accountCode'=>$accountCode,
'payType'=>post("payType"),
'payTypeOther'=>post("payTypeOther"),
'branch'=>post("branch"),
'chequeNo'=>post("chequeNo"),
'dueDate'=>$dueDate,
'dueTime'=>post("dueTime"),	
'total_amt'=>$total_amt, 
'total_vat'=>$vat_total_chargesReceive, 
'tax3'=>$tax3, 
'tax1'=>$tax1, 
'cus_paid'=>$cus_paid, 
'total_netamt'=>$total_netamt);      
        
 if($db->updateData($table,$params,"comCode='$db->comCode' AND documentID='$documentID'")){
     
  /*
        $paramsIV=array(
        'tax_invoiceNo'=>$documentID);
        $db->updateData('tax_invoice',$paramsJO,"comCode='$db->comCode' AND documentID='$ref_jobID'");  
     */
     
     
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
    
    
    
}elseif($action=='approve'){  
    

	
  
    
    $sql="DELETE FROM tax_invoice_items  WHERE comCode='$db->comCode' AND documentID='$documentID' ";   
$db->deleteData($sql);  
               

     $i=0;
         foreach($chargeitems as $items){
                    $params_items=array(
                    'comCode'=>$db->comCode,
                    'documentID'=>$documentID,
                    'invNo'=>$invNo[$i],
                    'chargeCode'=>$items,
                    'detail'=>$chargesDetail[$i],
                    'chargesCost'=>$paid[$i],
                    'chargesReceive'=>$receive[$i],
                    'chargesbillReceive'=>$chargesPrice[$i]       
                    );
                    $db->insertData('tax_invoice_items',$params_items); 
			 $i++;
		 }
	
 $sql="SELECT
i.comCode,
i.documentID,
i.chargeCode,
i.detail,
sum(i.chargesCost) as  chargesCost ,
sum(i.chargesReceive) as  chargesReceive,
sum(i.chargesbillReceive) as chargesbillReceive,
t.amount
FROM
tax_invoice_items AS i
INNER JOIN  common_charge AS c   ON  i.comCode = c.comCode AND  i.chargeCode = c.chargeCode
INNER JOIN  common_chargestype AS t  ON  c.comCode = t.comCode AND c.typeCode = t.typeCode
WHERE i.documentID ='$documentID'
GROUP BY i.chargeCode
";
$result=$db->query($sql);
$i=1;
$isActiveStype="";
while($r=mysqli_fetch_array($result)){
$total_chargesCost+=$r['chargesCost'];
$total_chargesReceive+=$r['chargesReceive'];
$total_chargesbillReceive+=$r['chargesbillReceive'];
$vatType=$r['amount']; 
if($vatType=='1'){
      $total_tax1+=$r['chargesReceive'];
}   
if($vatType=='3'){
      $total_tax3+=$r['chargesReceive'];
}
    
    
}
             
$vat_total_chargesCost=($total_chargesCost*7/100);
$vat_total_chargesReceive=($total_chargesReceive*7/100);
$vat_total_chargesbillReceive=($total_chargesbillReceive*7/100);

$total_amt=($total_chargesReceive+$total_chargesbillReceive+$vat_total_chargesReceive);
$tax3=($total_tax3*3/100);   
$tax1=($total_tax1*1/100);
$grand_total=$total_amt-$tax1-$tax3;
$total_netamt=$grand_total-$cus_paid;	
	
    
    
$params=array(
'comCode'=>$db->comCode,
'documentID'=>$documentID,
'documentDate'=>$documentDate,
'cusCode'=>post("cusCode"),
'cus_address'=>post("cus_address"),
'creditterm'=>post("creditTerm"),
'note'=>post("note"),
'remark'=>post("remark"),
'documentstatus'=>"A",
'createID'=>$_SESSION['userID'],
'createTime'=>date('Y-m-d H:i:s'),
'editID'=>$_SESSION['userID'],
'editTime'=>date('Y-m-d H:i:s'),
'accountCode'=>$accountCode,	
'payType'=>post("payType"),
'payTypeOther'=>post("payTypeOther"),
'branch'=>post("branch"),
'chequeNo'=>post("chequeNo"),
'dueDate'=>$dueDate,
'dueTime'=>post("dueTime"),	
'total_amt'=>$total_amt, 
'total_vat'=>$vat_total_chargesReceive, 
'tax3'=>$tax3, 
'tax1'=>$tax1, 
'cus_paid'=>$cus_paid, 
'total_netamt'=>$total_netamt);      
        
 if($db->updateData($table,$params,"comCode='$db->comCode' AND documentID='$documentID'")){
     
  /*
        $paramsIV=array(
        'tax_invoiceNo'=>$documentID);
        $db->updateData('tax_invoice',$paramsJO,"comCode='$db->comCode' AND documentID='$ref_jobID'");  
     */
     
     
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
	 $sql="DELETE FROM tax_invoice WHERE comCode='$db->comCode' AND documentID='$documentID' ";
    if($db->deleteData($sql)){
        $sqlitems="DELETE FROM tax_invoice_items WHERE comCode='$db->comCode' AND documentID='$documentID' ";
        $db->deleteData($sqlitems); 
        
        $params=array(
        'taxivRef'=>'');
        $db->updateData('invoice',$params,"comCode='$db->comCode' AND taxivRef='$documentID'");  
		
		
		 $array = array( 
            "documentID"=>'',
            "result"=>'success');
            echo json_encode($array);
		
		
		//echo 'success';
	}else{
		echo $sql;
		 echo 'error';
		
	}
	
	
}
