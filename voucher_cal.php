
<?php
/*
session_start();
require_once( 'class.php' );
require_once( 'function.php' );
$db=new cl;
$db->connect();
//$attach_file=post('attach_file');
$amount=post('amount');
$taxPercen=post('taxPercen');
$vatPercen=post('vatPercen');
$taxAmount=post('taxAmount');

$tax1=0;
$tax3=0;
$tax7=0;

$sumTax1=0;
$sumTax3=0;
$sumVat=0;
$sumTax7=0;
$sumTotal=0;
$grandTotal=0;

$i=0;
foreach ($amount as $r){
	$sumTotal+=$r;
	$var_Percen=$taxPercen[$i];
	
	if($vatPercen[$i]==7){
		$sumTax7+=(($r*7)/100);
	}

	if($var_Percen==1){
		$sumTax1+=($r*1/100);
	}elseif($var_Percen==3){
		$sumTax3+=($r*3/100);
	}

   $i++;
}
$grandTotal=$sumTotal-$sumTax1-$sumTax3+$sumTax7;


        $array = array( 
            "sumTotal"=>$sumTotal,
			"sumTax1"=>$sumTax1,
			"sumTax3"=>$sumTax3,
			"sumTax7"=>$sumTax7,
            "grandTotal"=>$grandTotal
            );
        echo json_encode($array);





*/
?>


<?php
session_start();
require_once( 'class.php' );
require_once( 'function.php' );
$db=new cl;
$db->connect();
//$attach_file=post('attach_file');
$amount=post('amount');
$total=0;
foreach ($amount as $r){
    $total+=$r;
   
}
        $array = array( 
            "total"=>$total
            
            );
            echo json_encode($array);

?>

   


   


