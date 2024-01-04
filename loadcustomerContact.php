<?php
require_once( 'class.php' );
require_once('function.php');
$db=new cl;
$cusCode=post('cusCode');

$sql="SELECT
c.contactName,
c.contactMobile,
c.contactEmail,
c.salemanID,
s.empName,
s.usercode,
u.username
FROM
common_customer AS c
INNER JOIN common_saleman AS s ON c.comCode = s.comCode AND c.salemanID = s.usercode
INNER JOIN `user` AS u ON s.comCode = u.comCode AND s.usercode = u.usercode
WHERE c.cusCode='$cusCode'
";
$info=$db->fetch($sql);
$array = array( 
"cusContact"=>$info['contactName'],
"salemanID"=>$info['salemanID'],
"result"=>'success');
echo json_encode($array);
?>


