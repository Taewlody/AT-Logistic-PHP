
<?php
session_start();
require_once( 'class.php' );
require_once( 'function.php' );
$db=new cl;
$db->connect();
//$attach_file=post('attach_file');


$invNo=post('invNo');
$chargeitems=post('chargeitems');
$Bill_of_receipt=post('chargesPrice');
$receive=post('receive');
$cost=post('paid');
$total=0;
$total_Bill_of_receipt=0;
$sumTotal=0;
$total_paid=0;
$total_receive=0;
$i=0;
$total_tax=0;
$total_wh1=0;
$tatal_wh3=0;
$total_cost=0;
$row_cuspaid=0;
$check_inv='';
$total_cus_paid=0;
foreach ($receive as $r){
    $total_receive+=$r;
    $total_Bill_of_receipt+=$Bill_of_receipt[$i];
    $total=$total_receive+$total_Bill_of_receipt;
	//$total=$total_receive;
$sql="SELECT
v.amount,
v.vatType
FROM
common_charge AS c
INNER JOIN common_chargestype AS v ON c.comCode = v.comCode AND c.typeCode = v.typeCode
WHERE c.comCode='$db->comCode' AND c.chargeCode='$chargeitems[$i]' ";
$r_items=$db->fetch($sql);   
$vatType=$r_items['amount']; 
$total_cost+=$cost[$i]; 
if($vatType=='1'){
      $total_wh1+=$r;
}
    
if($vatType=='3'){
      $tatal_wh3+=$r;
}
    
    
 //--------------------------get cuspaid
    
$sql_cuspaid="SELECT
i.cus_paid
FROM
invoice AS i
WHERE i.documentID='$invNo[$i]' ";
$r_cuspaid=$db->fetch($sql_cuspaid);   
$row_cuspaid=$r_cuspaid['cus_paid'];

if($check_inv==$invNo[$i]){
    
}else{
    $total_cus_paid+=$row_cuspaid;
    $check_inv=$invNo[$i];
}

    
    
    
    
//---------------------------end cuspaid    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
  $i++;            
}


$vat7=($total_receive*7/100);

$grand_total=$total+$vat7;
$wh_tax3=($tatal_wh3*3/100);   
$wh_tax1=($total_wh1*1/100);

$total_wh=($wh_tax1+$wh_tax3);
$net_pad=$grand_total-$total_wh-$total_cus_paid;

        $array = array( 
            "total"=>n2($total),
            "vat7"=>n2($vat7),
            "total_cost"=>n2($total_cost),
            "total_receive"=>n2($total_receive),
            "total_Bill_of_receipt"=>n2($total_Bill_of_receipt),
            "wh_tax3"=>n2($wh_tax3),
            "wh_tax1"=>n2($wh_tax1),
            "grand_total"=>n2($grand_total),
            "net_pad"=>n2($net_pad),
            "total_cus_paid"=>($total_cus_paid)
            );
            echo json_encode($array);

?>

   


