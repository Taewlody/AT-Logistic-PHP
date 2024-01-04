<?php
session_start();
require_once( 'class.php' );
require_once( 'function.php' );
$db=new cl;
$db->connect();
//$attach_file=post('attach_file');
$cusCode=post('cusCode');

$sql="SELECT
c.addressTH,
c.addressEN,
c.taxID,
c.zipCode
FROM $db->dbname.common_customer AS c
WHERE c.comCode='$db->comCode' AND c.cusCode='$cusCode'";
$result=$db->fetch($sql);

//echo $result['addressTH'].' '.$result['zipCode'];


        $array = array( 
            "address"=>$result['addressTH'].' '.$result['zipCode'],
            "taxID"=>$result['taxID']
            );
            echo json_encode($array);
//*/

?>

   


