<?php
session_start();
require_once( 'class.php' );
require_once( 'function.php' );
$db=new cl;
$db->connect();
$action=post('action');
$documentID=post('documentID');
$table=$db->dbname.'.joborder';

$documentDate=formatDate_dash(post('documentDate'));
$etdDate=formatDate_dash(post('etdDate'));
$etaDate=formatDate_dash(post('etaDate'));

$freetimeEXP=formatDate_dash(post('freetimeEXP'));
$freetime=post('freetime');
$closingDate=formatDate_dash(post('closingDate'));
$stu_date=formatDate_dash(post('stu_date'));
$cy_date=formatDate_dash(post('cy_date'));
$rtn_date=formatDate_dash(post('rtn_date'));
$invoiceNo=post('invoiceNo');




$chargeitems=post('chargeitems');
$chargesDetail=post('chargesDetail');
$chargesCost=post('chargesCost');
$chargesReceive=post('chargesReceive');
$chargesbillReceive=post('chargesbillReceive');
$ref_paymentCode=post('ref_paymentCode');


//$total_amt=str_replace(",","",post('h_total'));
$total_vat=str_replace(",","",post('vat_total_chargesReceive'));
//$tax3=str_replace(",","",post('h_tax3'));
//$tax1=str_replace(",","",post('h_tax1'));
$cus_paid=str_replace(",","",post('h_cus_paid'));
//$total_netamt=str_replace(",","",post('h_net_pad'));



/// container 

       $containerType=post('containerType');
        $containerSize=post('containerSize');
        $containerNo=post('containerNo');
        $containerSealNo=post('containerSealNo');
        $containerGW=post('containerGW');
        $containerGW_unit=post('containerGW_unit');
        $containerNW=post('containerNW');
        $containerNW_Unit=post('containerNW_Unit');
        $containerTareweight=post('containerTareweight');

/// end container 

//------------packed

$packaed_width=post('packaed_width');
$packaed_length=post('packaed_length');
$packaed_height=post('packaed_height');
$packaed_qty=post('packaed_qty');
$packaed_weight=post('packaed_weight');
$packaed_unit=post('packaed_unit');
$packaed_totalCBM=post('packaed_totalCBM');
$packaed_totalWeight=post('packaed_totalWeight');
//------------end packed


//------------good
$goodNo=post('goodNo');
$goodDec=post('goodDec');
$goodWeight=post('goodWeight');
$good_unit=post('good_unit');
$goodSize=post('goodSize');
$goodKind=post('goodKind');
//------------end good

$invNo=post('invNo');
$bookingNo=post('bookingNo');
$var_invNo=0;
$var_bookingNo=0;

if($invNo!=''){
	$sql_check_iv_dup="SELECT count(j.documentID) as qty  
	FROM joborder AS j  WHERE  j.invNo='$invNo' AND j.invNo<>'' and j.invNo<>'n/a' AND j.documentID<>'$documentID'";
	$result_invNo=$db->fetch($sql_check_iv_dup);
	$var_invNo=$result_invNo['qty'];
}

if($bookingNo!=''){
	$sql_check_booking_dup="SELECT count(j.documentID) as qty  
	FROM joborder AS j  WHERE  j.bookingNo='$bookingNo' AND j.bookingNo<>'' and j.bookingNo<>'n/a' AND j.documentID<>'$documentID'";
	$result_booking=$db->fetch($sql_check_booking_dup);
	$var_bookingNo=$result_booking['qty'];
}


if($var_invNo>0 || $var_bookingNo>0){
	   $array = array( 
            "documentID"=>"",
            "result"=>'error_duplicateIV');
            echo json_encode($array);
	
}else{

if($action=='add' || $action=='copy'){
    if($documentID==''){
        $documentID=$db->genarate_docuemntID('joborder','documentID','REF-ym',5);
    }
    
    
 
// cal price
$net_pad=0;
$total=0;
$i=0;
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
//$cus_paid=0; 
$total_netamt=0;
    
    
if($chargeitems){
foreach ($chargeitems as $r){
$total_chargesCost+=$chargesCost[$i];
$total_chargesReceive+=$chargesReceive[$i];
$total_chargesbillReceive+=$chargesbillReceive[$i];

$sql="SELECT
t.amount
FROM
common_charge AS c
INNER JOIN common_chargestype AS t ON c.comCode = t.comCode AND c.typeCode = t.typeCode
WHERE c.chargeCode='$r'   "  ; 
$r_items=$db->fetch($sql);  
$r_items=$db->fetch($sql); 
$vatType=$r_items['amount']; 
if($vatType=='1'){
      $total_tax1+=$chargesReceive[$i];
}   
if($vatType=='3'){
      $total_tax3+=$chargesReceive[$i];
}
  $i++;    
}
$vat_total_chargesCost=($total_chargesCost*7/100);
$vat_total_chargesReceive=($total_chargesReceive*7/100);
$vat_total_chargesbillReceive=($total_chargesbillReceive*7/100);

$total_amt=($total_chargesReceive+$total_chargesbillReceive+$vat_total_chargesReceive);
$tax3=($total_tax3*3/100);   
$tax1=($total_tax1*1/100);
$grand_total=$total_amt-$tax1-$tax3;
$total_netamt=$grand_total-$cus_paid;
}

//end cal price   
    
    
    
    
    
    
    $params=array(
        'comCode'=>$db->comCode,
        'documentID'=>$documentID,
        'documentDate'=>$documentDate,
        'bound'=>post("bound"),  
        'freight'=>post("freight"), 
        'port_of_landing'=>post("port_of_landing"),
        'port_of_discharge'=>post("port_of_discharge"),
        'mbl'=>post("mbl"), 
        'hbl'=>post("hbl"), 
        'co'=>post("co"), 
        'paperless'=>post("paperless"), 
        'bill_of_landing'=>post("bill_of_landing"), 
        'import_entry'=>post("import_entry"), 
        'etdDate'=>$etdDate,
        'etaDate'=>$etaDate,
        'freetime'=>post("freetime"),
        'freetimeEXP'=>$freetimeEXP,
        'closingDate'=>$closingDate,
        'closingTime'=>post("closingTime"), 
        'invNo'=>post("invNo"), 
        'bill'=>post("bill"), 
        'bookingNo'=>post("bookingNo"), 
        'deliveryType'=>post("deliveryType"), 
        'saleman'=>post("saleman"), 
        'cusCode'=>post("cusCode"), 
        'cusContact'=>post("cusContact"), 
        'agentCode'=>post("agentCode"), 
        'agentContact'=>post("agentContact"), 
        'feeder'=>post("feeder"), 
        'vessel'=>post("vessel"), 
        'note'=>post("note"), 
        'stu_location'=>post("stu_location"), 
        'stu_contact'=>post("stu_contact"), 
        'stu_mobile'=>post("stu_mobile"), 
        'stu_date'=>$stu_date, 
        'cy_location'=>post("cy_location"), 
        'cy_contact'=>post("cy_contact"), 
        'cy_mobile'=>post("cy_mobile"), 
        'cy_date'=>$cy_date, 
        'rtn_location'=>post("rtn_location"), 
        'rtn_contact'=>post("rtn_contact"), 
        'rtn_mobile'=>post("rtn_mobile"), 
        'rtn_date'=>$rtn_date, 
        'good_total_num_package'=>post('good_total_num_package'),
        'good_commodity'=>post('good_commodity'),
        'fob'=>post('fob'),
        'place_receive'=>post('place_receive'),
        'total_amt'=>$total_amt, 
        'total_vat'=>$vat_total_chargesReceive, 
        'tax3'=>$tax3, 
        'tax1'=>$tax1, 
        'cus_paid'=>$cus_paid, 
        'total_netamt'=>$total_netamt, 
        'documentstatus'=>'P',
        'feederVOY'=>post('feederVOY'),
        'vesselVOY'=>post('vesselVOY'),
        'createID'=>$_SESSION['userID'],
        'createTime'=>date('Y-m-d H:i:s'),
        'editID'=>$_SESSION['userID'],
        'editTime'=>date('Y-m-d H:i:s'));

 
    if($db->insertData($table,$params)){

  
        
        // Container
        $items1=0;
        if($containerType){    
        foreach($containerType as $r){
            if($r!=""){    
                $params_containner=array(
                'comCode'=>$db->comCode,
                'documentID'=>$documentID,
                'containerType'=>$r,
                'containerSize'=>$containerSize[$items1],
                'containerNo'=>$containerNo[$items1],
                'containerSealNo'=>$containerSealNo[$items1],
                'containerGW'=>$containerGW[$items1],                
                'containerGW_unit'=>$containerGW_unit[$items1],
                'containerNW'=>$containerNW[$items1],      
                'containerNW_Unit'=>$containerNW_Unit[$items1],
                'containerTareweight'=>$containerTareweight[$items1]        
                );
                $db->insertData('joborder_container',$params_containner);
            }

            $items1++;
        }
        }

// Packeds



     
        $items2=0;
        foreach($packaed_totalCBM as $r){
            if($r!=""){  
                
                if($r>0 
				   /*
				   && 
                $packaed_length[$items2]>0 && 
                $packaed_height[$items2]>0 && 
                $packaed_qty[$items2]>0 &&
                $packaed_weight[$items2]
				   */
                ){
                    //$packaed_totalCBM=(($r*$packaed_length[$items2]*$packaed_height[$items2])/1000000);
                    //$packaed_totalWeight=($packaed_qty[$items2]*$packaed_weight[$items2]);
                    $params_packed=array(
                    'comCode'=>$db->comCode,
                    'documentID'=>$documentID,
                    'packaed_width'=>$packaed_width[$items2],
                    'packaed_length'=>$packaed_length[$items2],
                    'packaed_height'=>$packaed_height[$items2],
                    'packaed_qty'=>$packaed_qty[$items2],
                    'packaed_weight'=>$packaed_weight[$items2],                
                    'packaed_unit'=>$packaed_unit[$items2],
                    'packaed_totalCBM'=>$r,      
                    'packaed_totalWeight'=>$packaed_totalWeight[$items2]       
                    );
                    $db->insertData('joborder_packed',$params_packed);
                }
            }

            $items2++;
        }

// Goods


        $items3=0;
        foreach($goodNo as $r){
            if($r!=""){  
                    $params_goods=array(
                    'comCode'=>$db->comCode,
                    'documentID'=>$documentID,
                    'goodNo'=>$r,
                    'goodDec'=>$goodDec[$items3],
                    'goodWeight'=>$goodWeight[$items3],
                    'good_unit'=>$good_unit[$items3],
                    'goodSize'=>$goodSize[$items3],                
                    'goodKind'=>$goodKind[$items3]       
                    );
                    $db->insertData('joborder_goods',$params_goods);
            }

            $items3++;
        }
        
        
        
        
        
        
//  charge     


$i=0;
if($chargeitems){
foreach($chargeitems as $r){ 

        $var_chargesCost=$chargesCost[$i];
        $var_chargesReceive=$chargesReceive[$i]; 
        $var_chargesbillReceive=$chargesbillReceive[$i];
        $params_charges=array(
            'comCode'=>$db->comCode,
            'documentID'=>$documentID,
            'chargeCode'=>$r,
            'ref_paymentCode'=>$ref_paymentCode[$i],
            'detail'=>$chargesDetail[$i],
            'chargesCost'=>$var_chargesCost,
            'chargesReceive'=>$var_chargesReceive,
            'chargesbillReceive'=>$var_chargesbillReceive
            );
            $db->insertData('joborder_charge',$params_charges);

$i++;
    
}





}

// update file attach
$imgKey=post('imgKey');
if($imgKey){
foreach($imgKey as $r){
    $params=array(
        'comCode'=>$db->comCode,
        'documentID'=>$documentID);
        $db->updateData('joborder_attach',$params,"comCode='$db->comCode' AND fileName='$r'");

}
}
        
        
        


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


}elseif($action=='edit')
{
    
    
 //  charge      
   $i=0;
if($chargeitems){
$sql="DELETE FROM joborder_charge  WHERE comCode='$db->comCode' AND documentID='$documentID' ";   
$db->deleteData($sql);    
foreach($chargeitems as $r){ 

        $var_chargesCost=$chargesCost[$i];
        $var_chargesReceive=$chargesReceive[$i]; 
        $var_chargesbillReceive=$chargesbillReceive[$i];
        $params_charges=array(
            'comCode'=>$db->comCode,
            'documentID'=>$documentID,
            'chargeCode'=>$r,
            'ref_paymentCode'=>$ref_paymentCode[$i],
            'detail'=>$chargesDetail[$i],
            'chargesCost'=>$var_chargesCost,
            'chargesReceive'=>$var_chargesReceive,
            'chargesbillReceive'=>$var_chargesbillReceive
            );
            $db->insertData('joborder_charge',$params_charges);
$i++; 
}
}

// cal price
$net_pad=0;
$total=0;
$i=0;
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
//$cus_paid=0; 
$total_netamt=0;
    
 if($chargesCost){   
foreach ($chargesCost as $r){
$total_chargesCost+=$r;
$total_chargesReceive+=$chargesReceive[$i];
$total_chargesbillReceive+=$chargesbillReceive[$i];
    
    
$sql="SELECT
	j.comCode, 
	j.ref_paymentCode, 
	j.chargeCode, 
	j.detail AS chartDetail, 
	j.chargesCost, 
	j.chargesReceive, 
	j.chargesbillReceive, 
	t.amount
    FROM joborder_charge AS j
	INNER JOIN  common_charge AS c   ON  j.comCode = c.comCode AND  j.chargeCode = c.chargeCode
	INNER JOIN  common_chargestype AS t  ON  c.comCode = t.comCode AND c.typeCode = t.typeCode
    WHERE c.comCode='$db->comCode' AND c.chargeCode='$chargeitems[$i]' ";
$r_items=$db->fetch($sql); 
$vatType=$r_items['amount']; 
if($vatType=='1'){
      $total_tax1+=$chargesReceive[$i];
}   
if($vatType=='3'){
      $total_tax3+=$chargesReceive[$i];
}
  $i++;    
}
$vat_total_chargesCost=($total_chargesCost*7/100);
$vat_total_chargesReceive=($total_chargesReceive*7/100);
$vat_total_chargesbillReceive=($total_chargesbillReceive*7/100);

$total_amt=($total_chargesReceive+$total_chargesbillReceive+$vat_total_chargesReceive);
$tax3=($total_tax3*3/100);   
$tax1=($total_tax1*1/100);
$grand_total=$total_amt-$tax1-$tax3;
$total_netamt=$grand_total-$cus_paid;

//end cal price
 }

 
    
    
    
         
        // Container
        $items1=0;
    $sql="DELETE FROM joborder_container  WHERE comCode='$db->comCode' AND documentID='$documentID' ";   
    $db->deleteData($sql); 
   if($containerType){
    
        foreach($containerType as $r){
            if($r!=""){    
                $params_containner=array(
                'comCode'=>$db->comCode,
                'documentID'=>$documentID,
                'containerType'=>$r,
                'containerSize'=>$containerSize[$items1],
                'containerNo'=>$containerNo[$items1],
                'containerSealNo'=>$containerSealNo[$items1],
                'containerGW'=>$containerGW[$items1],                
                'containerGW_unit'=>$containerGW_unit[$items1],
                'containerNW'=>$containerNW[$items1],      
                'containerNW_Unit'=>$containerNW_Unit[$items1],
                'containerTareweight'=>$containerTareweight[$items1]        
                );
                $db->insertData('joborder_container',$params_containner);
            }

            $items1++;
        }  
    
   }
    
    
    
 //------------------Packeds
        $items2=0;
    $sql="DELETE FROM joborder_packed  WHERE comCode='$db->comCode' AND documentID='$documentID' ";   
    $db->deleteData($sql);     
        foreach($packaed_totalCBM as $r){
            if($r!=""){  
                
                if($r>0 /*&& 
                $packaed_length[$items2]>0 && 
                $packaed_height[$items2]>0 && 
                $packaed_qty[$items2]>0 &&
                $packaed_weight[$items2]
				   */
                ){
                   // $packaed_totalCBM=(($r*$packaed_length[$items2]*$packaed_height[$items2])/1000000);
                    //$packaed_totalWeight=($packaed_qty[$items2]*$packaed_weight[$items2]);
                    $params_packed=array(
                    'comCode'=>$db->comCode,
                    'documentID'=>$documentID,
                    'packaed_width'=>$packaed_width[$items2],
                    'packaed_length'=>$packaed_length[$items2],
                    'packaed_height'=>$packaed_height[$items2],
                    'packaed_qty'=>$packaed_qty[$items2],
                    'packaed_weight'=>$packaed_weight[$items2],                
                    'packaed_unit'=>$packaed_unit[$items2],
                    'packaed_totalCBM'=>$r,      
                    'packaed_totalWeight'=>$packaed_totalWeight[$items2]       
                    );
                    $db->insertData('joborder_packed',$params_packed);
                }
            }

            $items2++;
        }
    
  //------------------end Packeds   
    
  
  //------------------edit Goods
        $items3=0;
     $sql="DELETE FROM joborder_goods  WHERE comCode='$db->comCode' AND documentID='$documentID' ";   
    $db->deleteData($sql);   
        foreach($goodNo as $r){
            if($r!=""){  
                    $params_goods=array(
                    'comCode'=>$db->comCode,
                    'documentID'=>$documentID,
                    'goodNo'=>$r,
                    'goodDec'=>$goodDec[$items3],
                    'goodWeight'=>$goodWeight[$items3],
                    'good_unit'=>$good_unit[$items3],
                    'goodSize'=>$goodSize[$items3],                
                    'goodKind'=>$goodKind[$items3]       
                    );
                    $db->insertData('joborder_goods',$params_goods);
            }

            $items3++;
        }
  //------------------end edit Goods        
          
    
    
 // update file attach
$imgKey=post('imgKey');
if($imgKey){
foreach($imgKey as $r){
    $params=array(
        'comCode'=>$db->comCode,
        'documentID'=>$documentID);
        $db->updateData('joborder_attach',$params,"comCode='$db->comCode' AND fileName='$r'");

}
}else{
    $sql="DELETE FROM joborder_attach  WHERE comCode='$db->comCode' AND documentID='$documentID' ";   
    $db->deleteData($sql);          
    }
    
    
    
    
    
    
        $params=array(
        'comCode'=>$db->comCode,
        'documentID'=>$documentID,
        'documentDate'=>$documentDate,
        'bound'=>post("bound"),  
        'freight'=>post("freight"), 
        'port_of_landing'=>post("port_of_landing"),
        'port_of_discharge'=>post("port_of_discharge"),
        'mbl'=>post("mbl"), 
        'hbl'=>post("hbl"), 
        'co'=>post("co"), 
        'paperless'=>post("paperless"), 
        'bill_of_landing'=>post("bill_of_landing"), 
        'import_entry'=>post("import_entry"), 
        'etdDate'=>$etdDate,
        'etaDate'=>$etaDate,
        'closingDate'=>$closingDate,
        'closingTime'=>post("closingTime"), 
        'invNo'=>post("invNo"), 
        'bill'=>post("bill"), 
        'bookingNo'=>post("bookingNo"), 
        'deliveryType'=>post("deliveryType"), 
        'saleman'=>post("saleman"), 
        'cusCode'=>post("cusCode"), 
        'cusContact'=>post("cusContact"), 
        'agentCode'=>post("agentCode"), 
        'agentContact'=>post("agentContact"), 
        'feeder'=>post("feeder"), 
        'vessel'=>post("vessel"), 
        'note'=>post("note"), 
        'stu_location'=>post("stu_location"), 
        'stu_contact'=>post("stu_contact"), 
        'stu_mobile'=>post("stu_mobile"), 
        'stu_date'=>$stu_date, 
        'cy_location'=>post("cy_location"), 
        'cy_contact'=>post("cy_contact"), 
        'cy_mobile'=>post("cy_mobile"), 
        'cy_date'=>$cy_date, 
        'rtn_location'=>post("rtn_location"), 
        'rtn_contact'=>post("rtn_contact"), 
        'rtn_mobile'=>post("rtn_mobile"),
        'rtn_date'=>$rtn_date, 
        'good_total_num_package'=>post('good_total_num_package'),
        'good_commodity'=>post('good_commodity'),
        'fob'=>post('fob'),
        'place_receive'=>post('place_receive'),
                'freetime'=>post("freetime"),
        'freetimeEXP'=>$freetimeEXP,  
            
        'total_amt'=>$total_amt, 
        'total_vat'=>$vat_total_chargesReceive, 
        'tax3'=>$tax3, 
        'tax1'=>$tax1, 
        'cus_paid'=>$cus_paid, 
        'total_netamt'=>$total_netamt,
            
                   'feederVOY'=>post('feederVOY'),
        'vesselVOY'=>post('vesselVOY'), 
            
        'documentstatus'=>'P',
        'createID'=>$_SESSION['userID'],
       // 'createTime'=>date('Y-m-d H:i:s'),
        'editID'=>$_SESSION['userID'],
        'editTime'=>date('Y-m-d H:i:s'));
        if($db->updateData($table,$params,"comCode='$db->comCode' AND documentID='$documentID'")){
            $array = array( 
                "documentID"=>$documentID,
                "total_amt"=>$total_amt,
                "result"=>'success');
                echo json_encode($array);
        }else{
            $array = array( 
                "documentID"=>$documentID,
                "result"=>'error');
                echo json_encode($array);
        }
    


}elseif($action=='approve')
{   
 //  charge      
   $i=0;
if($chargeitems){
$sql="DELETE FROM joborder_charge  WHERE comCode='$db->comCode' AND documentID='$documentID' ";   
$db->deleteData($sql);    
foreach($chargeitems as $r){ 

        $var_chargesCost=$chargesCost[$i];
        $var_chargesReceive=$chargesReceive[$i]; 
        $var_chargesbillReceive=$chargesbillReceive[$i];
        $params_charges=array(
            'comCode'=>$db->comCode,
            'documentID'=>$documentID,
            'chargeCode'=>$r,
            'ref_paymentCode'=>$ref_paymentCode[$i],
            'detail'=>$chargesDetail[$i],
            'chargesCost'=>$var_chargesCost,
            'chargesReceive'=>$var_chargesReceive,
            'chargesbillReceive'=>$var_chargesbillReceive
            );
            $db->insertData('joborder_charge',$params_charges);
$i++; 
}


// cal price
$net_pad=0;
$total=0;
$i=0;
$total_chargesCost=0;
$total_chargesReceive=0;
$total_chargesbillReceive=0;
$vat_total_chargesCost=0;
$vat_total_chargesReceive=0;
$vat_total_chargesbillReceive=0;

$total_tax1=0;
$total_tax3=0;

foreach ($chargesCost as $r){
$total_chargesCost+=$r;
$total_chargesReceive+=$chargesReceive[$i];
$total_chargesbillReceive+=$chargesbillReceive[$i];
    
    
$sql="SELECT
	j.comCode, 
	j.ref_paymentCode, 
	j.chargeCode, 
	j.detail AS chartDetail, 
	j.chargesCost, 
	j.chargesReceive, 
	j.chargesbillReceive, 
	t.amount
    FROM joborder_charge AS j
	INNER JOIN  common_charge AS c   ON  j.comCode = c.comCode AND  j.chargeCode = c.chargeCode
	INNER JOIN  common_chargestype AS t  ON  c.comCode = t.comCode AND c.typeCode = t.typeCode
    WHERE c.comCode='$db->comCode' AND c.chargeCode='$chargeitems[$i]' ";
$r_items=$db->fetch($sql); 
$vatType=$r_items['amount']; 
if($vatType=='1'){
      $total_tax1+=$chargesReceive[$i];
}   
if($vatType=='3'){
      $total_tax3+=$chargesReceive[$i];
}
  $i++;    
}
$vat_total_chargesCost=round(($total_chargesCost*7/100),2);
$vat_total_chargesReceive=round(($total_chargesReceive*7/100),2);
$vat_total_chargesbillReceive=round(($total_chargesbillReceive*7/100),2);

$total_amt=round(($total_chargesReceive+$total_chargesbillReceive+$vat_total_chargesReceive),2);
$tax3=round(($total_tax3*3/100),2);   
$tax1=round(($total_tax1*1/100),2);
$grand_total=$total_amt-$tax1-$tax3;
$total_netamt=$grand_total-$cus_paid;

//end cal price


} 
    
    
    
         
        // Container
        $items1=0;
    $sql="DELETE FROM joborder_container  WHERE comCode='$db->comCode' AND documentID='$documentID' ";   
    $db->deleteData($sql); 
    if($containerType){
        foreach($containerType as $r){
            if($r!=""){    
                $params_containner=array(
                'comCode'=>$db->comCode,
                'documentID'=>$documentID,
                'containerType'=>$r,
                'containerSize'=>$containerSize[$items1],
                'containerNo'=>$containerNo[$items1],
                'containerSealNo'=>$containerSealNo[$items1],
                'containerGW'=>$containerGW[$items1],                
                'containerGW_unit'=>$containerGW_unit[$items1],
                'containerNW'=>$containerNW[$items1],      
                'containerNW_Unit'=>$containerNW_Unit[$items1],
                'containerTareweight'=>$containerTareweight[$items1]        
                );
                $db->insertData('joborder_container',$params_containner);
            }

            $items1++;
        }   
    }
 //------------------Packeds
    $items2=0;
    $sql="DELETE FROM joborder_packed  WHERE comCode='$db->comCode' AND documentID='$documentID' ";   
    $db->deleteData($sql);     
        foreach($packaed_totalCBM as $r){
            if($r!=""){  
                
                if($r>0 /*&& 
                $packaed_length[$items2]>0 && 
                $packaed_height[$items2]>0 && 
                $packaed_qty[$items2]>0 &&
                $packaed_weight[$items2]
				   */
                ){
                   // $packaed_totalCBM=(($r*$packaed_length[$items2]*$packaed_height[$items2])/1000000);
                //    $packaed_totalWeight=($packaed_qty[$items2]*$packaed_weight[$items2]);
                    $params_packed=array(
                    'comCode'=>$db->comCode,
                    'documentID'=>$documentID,
                    'packaed_width'=>$packaed_width[$items2],
                    'packaed_length'=>$packaed_length[$items2],
                    'packaed_height'=>$packaed_height[$items2],
                    'packaed_qty'=>$packaed_qty[$items2],
                    'packaed_weight'=>$packaed_weight[$items2],                
                    'packaed_unit'=>$packaed_unit[$items2],
                     'packaed_totalCBM'=>$r,      
                    'packaed_totalWeight'=>$packaed_totalWeight[$items2]     
                    );
                    $db->insertData('joborder_packed',$params_packed);
                }
            }

            $items2++;
        }
    
  //------------------end Packeds   
    
  
  //------------------edit Goods
    $items3=0;
    $sql="DELETE FROM joborder_goods  WHERE comCode='$db->comCode' AND documentID='$documentID' ";   
    $db->deleteData($sql);   
        foreach($goodNo as $r){
            if($r!=""){  
                    $params_goods=array(
                    'comCode'=>$db->comCode,
                    'documentID'=>$documentID,
                    'goodNo'=>$r,
                    'goodDec'=>$goodDec[$items3],
                    'goodWeight'=>$goodWeight[$items3],
                    'good_unit'=>$good_unit[$items3],
                    'goodSize'=>$goodSize[$items3],                
                    'goodKind'=>$goodKind[$items3]       
                    );
                    $db->insertData('joborder_goods',$params_goods);
            }

            $items3++;
        }
  //------------------end edit Goods        
          
    
    
 // update file attach
$imgKey=post('imgKey');
if($imgKey){
foreach($imgKey as $r){
    $params=array(
        'comCode'=>$db->comCode,
        'documentID'=>$documentID);
        $db->updateData('joborder_attach',$params,"comCode='$db->comCode' AND fileName='$r'");

}
}
        $params=array(
        'comCode'=>$db->comCode,
        'documentID'=>$documentID,
        'documentDate'=>$documentDate,
        'bound'=>post("bound"),  
        'freight'=>post("freight"), 
        'port_of_landing'=>post("port_of_landing"),
        'port_of_discharge'=>post("port_of_discharge"),
        'mbl'=>post("mbl"), 
        'hbl'=>post("hbl"), 
        'co'=>post("co"), 
        'paperless'=>post("paperless"), 
        'bill_of_landing'=>post("bill_of_landing"), 
        'import_entry'=>post("import_entry"), 
        'etdDate'=>$etdDate,
        'etaDate'=>$etaDate,
        'freetime'=>post("freetime"),
        'freetimeEXP'=>$freetimeEXP,
        'closingDate'=>$closingDate,
        'closingTime'=>post("closingTime"), 
        'invNo'=>post("invNo"), 
        'bill'=>post("bill"), 
        'bookingNo'=>post("bookingNo"), 
        'deliveryType'=>post("deliveryType"), 
        'saleman'=>post("saleman"), 
        'cusCode'=>post("cusCode"), 
        'cusContact'=>post("cusContact"), 
        'agentCode'=>post("agentCode"), 
        'agentContact'=>post("agentContact"), 
        'feeder'=>post("feeder"), 
        'vessel'=>post("vessel"), 
        'note'=>post("note"), 
        'stu_location'=>post("stu_location"), 
        'stu_contact'=>post("stu_contact"), 
        'stu_mobile'=>post("stu_mobile"), 
        'stu_date'=>$stu_date, 
        'cy_location'=>post("cy_location"), 
        'cy_contact'=>post("cy_contact"), 
        'cy_mobile'=>post("cy_mobile"), 
        'cy_date'=>$cy_date, 
        'rtn_location'=>post("rtn_location"), 
        'rtn_contact'=>post("rtn_contact"), 
        'rtn_mobile'=>post("rtn_mobile"),
        'rtn_date'=>$rtn_date, 
        'good_total_num_package'=>post('good_total_num_package'),
        'good_commodity'=>post('good_commodity'),
        'fob'=>post('fob'),
        'place_receive'=>post('place_receive'),
        'total_amt'=>$total_amt, 
        'total_vat'=>$vat_total_chargesReceive, 
        'tax3'=>$tax3, 
        'tax1'=>$tax1, 
        'cus_paid'=>$cus_paid, 
        'total_netamt'=>$total_netamt,
        'documentstatus'=>'A',
        'feederVOY'=>post('feederVOY'),
        'vesselVOY'=>post('vesselVOY'),
        'createID'=>$_SESSION['userID'],
        'createTime'=>date('Y-m-d H:i:s'),
        'editID'=>$_SESSION['userID'],
        'editTime'=>date('Y-m-d H:i:s'));
        if($db->updateData($table,$params,"comCode='$db->comCode' AND documentID='$documentID'")){

		
if($invoiceNo==""){			
	$documentIV=$db->genarate_docuemntID('invoice','documentID','ATL-ym',4);
    $invDate = date('Y-m-d');
}else{
	$documentIV=$invoiceNo;
    $sql_docDate = "select documentDate from invoice where documentID='$documentIV' limit 1 ";
    //echo "sql invDate = ".$sql_docDate;
    $r_inv=$db->fetch($sql_docDate);
    $invDate = $r_inv['documentDate'];

	 $sqliv1="DELETE FROM invoice_items WHERE comCode='$db->comCode' AND documentID='$invoiceNo' ";
    $db->deleteData($sqliv1);
        
    $sqliv2="DELETE FROM invoice  WHERE comCode='$db->comCode' AND documentID='$invoiceNo' ";   
    $db->deleteData($sqliv2);

}
         
	
$sqliV="INSERT INTO invoice
SELECT
j.comCode,
'".$documentIV."' AS documentID,
'".$invDate."' AS documentDate,
j.cusCode,
c.addressTH,
'' as carrier,
j.saleman,
0 as creditterm,
'' as your_RefNo,
j.bound,
j.good_commodity as commodity,
'' as on_board,
j.freight,
0 as qty_measurement,
j.bill,
j.documentID as ref_jobNo,
'' as origin_desc,
'' as note,
'' as remark,
'A' as documentstatus,
'".$_SESSION['userID']."' as createID,
DATE(NOW()) as createTime,
'".$_SESSION['userID']."' as editID,
DATE(NOW()) as editTime,
$total_amt, 
$vat_total_chargesReceive, 
$tax3, 
$tax1, 
$cus_paid, 
$total_netamt,
'' as taxivRef
FROM joborder AS j
INNER JOIN common_customer AS c ON j.comCode = c.comCode AND j.cusCode = c.cusCode
WHERE j.comCode='$db->comCode' AND  j.documentID='$documentID'; ";
//echo "sqliV => ".$sqliV;
if($db->query($sqliV)){
    $params=array(
        'comCode'=>$db->comCode,
        'documentID'=>$documentID,
        'invoiceNo'=>$documentIV);
    $db->updateData($table,$params,"comCode='$db->comCode' AND documentID='$documentID' ");
    
    
 $sqlItemIV="
INSERT INTO invoice_items
SELECT
'' as items,
j.comCode,
'".$documentIV."' as documentID,
j.chargeCode,
j.detail,
j.chargesCost,
j.chargesReceive,
j.chargesbillReceive
FROM
joborder_charge AS j
WHERE j.comCode='$db->comCode' AND j.documentID='$documentID' ; ";
$db->query($sqlItemIV);   
    
    
    
    
    
    
    
    
}
            


            
            
            $array = array( 
                "documentID"=>$documentID,
                "total_amt"=>$total_amt,
				"invoiceNo"=>$documentIV,
                "result"=>'success');
                echo json_encode($array);
        }else{
            $array = array( 
                "documentID"=>$documentID,
                "result"=>'error');
                echo json_encode($array);
        }
    
    
    
    
}elseif($action=='del')
{
  // $documentID=post('documentID'); 
    
	 $sql="DELETE FROM $table WHERE comCode='$db->comCode' AND documentID='$documentID' ";
    if($db->deleteData($sql)){
        
    $sql="DELETE FROM joborder_charge  WHERE comCode='$db->comCode' AND documentID='$documentID' ";   
    $db->deleteData($sql); 
    
      $sql="DELETE FROM joborder_attach  WHERE comCode='$db->comCode' AND documentID='$documentID' ";   
    $db->deleteData($sql); 
    
    
    $sql="DELETE FROM joborder_charge  WHERE comCode='$db->comCode' AND documentID='$documentID' ";   
    $db->deleteData($sql); 
    
     $sql="DELETE FROM joborder_container  WHERE comCode='$db->comCode' AND documentID='$documentID' ";   
    $db->deleteData($sql); 
    
     $sql="DELETE FROM joborder_goods  WHERE comCode='$db->comCode' AND documentID='$documentID' ";   
    $db->deleteData($sql);     
    
      $sql="DELETE FROM joborder_packed  WHERE comCode='$db->comCode' AND documentID='$documentID' ";   
    $db->deleteData($sql);      

		echo 'success';
	}else{
		echo $sql;
		 echo 'error';
		
	}
	
	
}

}





?>