
<?php
session_start();
require_once( 'class.php' );
require_once( 'function.php' );
$db=new cl;
$db->connect();
//$attach_file=post('attach_file');
$chargeitems=post('chargeitems');
$documentID=post('documentID');
$chargesCost=post('chargesCost');
$chargesReceive=post('chargesReceive');
$chargesbillReceive=post('chargesbillReceive');
$grand_total=0;

                        
$cus_paid=0;
$sql="SELECT sum(m.sumTotal) as sumTotal
FROM  $db->dbname.receipt_voucher AS m
WHERE m.comCode='$db->comCode' AND m.refJobNo='$documentID' ";
$result=$db->fetch($sql);
$cus_paid=$result['sumTotal'];   
if($cus_paid==''){$cus_paid=0;}



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
$vat_total_chargesCost=($total_chargesCost*7/100);
$vat_total_chargesReceive=($total_chargesReceive*7/100);
$vat_total_chargesbillReceive=($total_chargesbillReceive*7/100);

$total=($total_chargesReceive+$total_chargesbillReceive+$vat_total_chargesReceive);
$tax3=($total_tax3*3/100);   
$tax1=($total_tax1*1/100);
$grand_total=$total-$tax1-$tax3;
$net_pad=$grand_total-$cus_paid;

        $array2 = array( 
            "total_chargesCost"=>n2($total_chargesCost),
            "total_chargesReceive"=>n2($total_chargesReceive+$vat_total_chargesReceive),
            "total_chargesReceive_beforevat"=>n2($total_chargesReceive),
            "total_chargesbillReceive"=>n2($total_chargesbillReceive),
            "total_tax1"=>n2($tax1),
            "total_tax3"=>n2($tax3),
            "vat_total_chargesCost"=>n2($vat_total_chargesCost),
            "vat_total_chargesReceive"=>n2($vat_total_chargesReceive),
            "vat_total_chargesbillReceive"=>n2($vat_total_chargesbillReceive), 
            "total"=>n2($total),
            "grand_total"=>n2($grand_total),
            "net_pad"=>n2($net_pad)
            );
            echo json_encode($array2);

?>

   


