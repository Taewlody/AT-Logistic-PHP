<?php
function get($input){
	$varible_get=isset($_GET[$input])?$_GET[$input]:'';
	return $varible_get;
}

function post($input){
	$varible_post=isset($_POST[$input])?$_POST[$input]:'';

    return $varible_post;
}

function number($number=null,$priceScale){
    
    
	return  number_format((float)$number,$priceScale, '.', ',');
    
				
}
function n2($number=0){
	return  number_format($number,2, '.', ',');				
}


function formatDate_dash_min($date=NULL){
	if($date!=''){
	$var_date = explode("-", $date);
	$var_date[0]; 	$var_date[1];	$var_date[2];
	return $new_date=$var_date[2].'/'.$var_date[1].'/'.substr($var_date[0],-2);
	}
}

function formatDate_dash($date=NULL){
	if($date!=''){
	$var_date = explode("/", $date);
	$var_date[0]; 	$var_date[1];	$var_date[2];
	return $new_date=$var_date[2].'-'.$var_date[1].'-'.$var_date[0];
	}
}

function date_slash($date=NULL){
	if($date!=''){
	$var_date = explode("-", $date);
	$var_date[0]; 	$var_date[1];	$var_date[2];
	return $new_date=$var_date[2].'/'.$var_date[1].'/'.$var_date[0];
	}
}

function varDate($date=NULL){
	if($date!=''){
	$var_date = explode("/", $date);
	$var_date[0]; 	$var_date[1];	$var_date[2];
	return $new_date=$var_date[2].'-'.$var_date[1].'-'.$var_date[0];
	}
}

function line_notify($Token, $message)
{
    $lineapi = $Token; // ใส่ token key ที่ได้มา
	$mms =  trim($message); // ข้อความที่ต้องการส่ง
	date_default_timezone_set("Asia/Bangkok");
	$chOne = curl_init(); 
	curl_setopt( $chOne, CURLOPT_URL, "https://notify-api.line.me/api/notify"); 
	// SSL USE 
	curl_setopt( $chOne, CURLOPT_SSL_VERIFYHOST, 0); 
	curl_setopt( $chOne, CURLOPT_SSL_VERIFYPEER, 0); 
	//POST 
	curl_setopt( $chOne, CURLOPT_POST, 1); 
	curl_setopt( $chOne, CURLOPT_POSTFIELDS, "message=$mms"); 
	curl_setopt( $chOne, CURLOPT_FOLLOWLOCATION, 1); 
	$headers = array( 'Content-type: application/x-www-form-urlencoded', 'Authorization: Bearer '.$lineapi.'', );
        curl_setopt($chOne, CURLOPT_HTTPHEADER, $headers); 
	curl_setopt( $chOne, CURLOPT_RETURNTRANSFER, 1); 
	$result = curl_exec( $chOne ); 
	//Check error 
	if(curl_error($chOne)) 
	{ 
      //     echo 'error:' . curl_error($chOne); 
	} 
	else { 
	$result_ = json_decode($result, true); 
	//   echo "status : ".$result_['status']; echo "message : ". $result_['message'];
        } 
	curl_close( $chOne );   
}



function Convert($amount_number)
{
    $amount_number = number_format($amount_number, 2, ".","");
    $pt = strpos($amount_number , ".");
    $number = $fraction = "";
    if ($pt === false) 
        $number = $amount_number;
    else
    {
        $number = substr($amount_number, 0, $pt);
        $fraction = substr($amount_number, $pt + 1);
    }
    
    $ret = "";
    $baht = ReadNumber ($number);
    if ($baht != "")
        $ret .= $baht . "บาท";
    
    $satang = ReadNumber($fraction);
    if ($satang != "")
        $ret .=  $satang . "สตางค์";
    else 
        $ret .= "ถ้วน";
    return $ret;
}
 
 
function ReadNumber($number)
{
    $position_call = array("แสน", "หมื่น", "พัน", "ร้อย", "สิบ", "");
    $number_call = array("", "หนึ่ง", "สอง", "สาม", "สี่", "ห้า", "หก", "เจ็ด", "แปด", "เก้า");
    $number = $number + 0;
    $ret = "";
    if ($number == 0) return $ret;
    if ($number > 1000000)
    {
        $ret .= ReadNumber(intval($number / 1000000)) . "ล้าน";
        $number = intval(fmod($number, 1000000));
    }
    
    $divider = 100000;
    $pos = 0;
    while($number > 0)
    {
        $d = intval($number / $divider);
        $ret .= (($divider == 10) && ($d == 2)) ? "ยี่" : 
            ((($divider == 10) && ($d == 1)) ? "" :
            ((($divider == 1) && ($d == 1) && ($ret != "")) ? "เอ็ด" : $number_call[$d]));
        $ret .= ($d ? $position_call[$pos] : "");
        $number = $number % $divider;
        $divider = $divider / 10;
        $pos++;
    }
    return $ret;
}
 
?>