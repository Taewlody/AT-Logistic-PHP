<?php
require_once( 'class.php' );
require_once('function.php');
$db=new cl;
$supCode=post('supCode');

$sql="SELECT
c.contactName,
c.contactMobile,
c.contactEmail
FROM
common_supplier AS c
WHERE c.supCode='$supCode'
";
$info=$db->fetch($sql);
$array = array( 
"contactName"=>$info['contactName'],
"result"=>'success');
echo json_encode($array);
?>


