<?php
session_start();
require_once( 'class.php' );
require_once( 'function.php' );
$db=new cl;
$db->connect();
//$attach_file=post('attach_file');
$supCode=post('supCode');
$uploaddir = 'customer_path/'.$supCode.'/';

      if (file_exists("customer_path/$supCode")) {
      }else{
        mkdir("customer_path/$supCode", 0700);
      }


//$fileName=$_FILES['attach_file']['name'];
$temp = explode(".", $_FILES["attach_file"]["name"]);
$fileName = $supCode.'-'.date('ymd').round(microtime(true)) . '.' . end($temp);
$uploadfile = $uploaddir . basename($_FILES['attach_file']['name']);
        $params = array(
        'comCode' => $db->comCode,
        'cusCode'=>$supCode,
        'fileName' => $fileName,
        'fileDetail' =>post('attach_name'));

if(move_uploaded_file($_FILES["attach_file"]["tmp_name"], $uploaddir.$fileName)){
        $db->insertData('receipt_voucher_attach', $params);
        $array = array( 
        "fileName"=>$fileName,
        "result"=>'success');
        echo json_encode($array);
}else{
        $array = array( 
        "fileName"=>$fileName,
        "result"=>'error');
        echo json_encode($array);
}

   

?>
