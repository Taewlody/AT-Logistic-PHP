<?php
session_start();
require_once( 'class.php' );
require_once( 'function.php' );
$db=new cl;
$db->connect();
//$attach_file=post('attach_file');
$cusCode=post('cusCode');
$uploaddir = 'customer_path/'.$cusCode.'/';

      if (file_exists("customer_path/$cusCode")) {
      }else{
        mkdir("customer_path/$cusCode", 0700);
      }


//$fileName=$_FILES['attach_file']['name'];
$temp = explode(".", $_FILES["attach_file"]["name"]);
$fileName = $cusCode.'-'.date('ymd').round(microtime(true)) . '.' . end($temp);
$uploadfile = $uploaddir . basename($_FILES['attach_file']['name']);
        $params = array(
        'comCode' => $db->comCode,
        'cusCode'=>$cusCode,
        'fileName' => $fileName,
        'fileDetail' =>post('attach_name'));

if(move_uploaded_file($_FILES["attach_file"]["tmp_name"], $uploaddir.$fileName)){
        $db->insertData('deposit_attach', $params);
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
