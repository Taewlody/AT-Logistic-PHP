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
$closingDate=formatDate_dash(post('closingDate'));
$stu_date=formatDate_dash(post('stu_date'));
$cy_date=formatDate_dash(post('cy_date'));
$rtn_date=formatDate_dash(post('rtn_date'));
if($action=='add'){
    if($documentID==''){
        $documentID=$db->genarate_docuemntID('joborder','documentID','JO-ym',4);
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
        'rtn_location'=>post("closingTime"), 
        'rtn_contact'=>post("closingTime"), 
        'rtn_mobile'=>post("closingTime"), 
        'rtn_date'=>$rtn_date, 
        'good_total_num_package'=>post('good_total_num_package'),
        'good_commodity'=>post('good_commodity'),
        'fob'=>post('fob'),
        'place_receive'=>post('place_receive'),
        'documentstatus'=>'P',
        'createID'=>$_SESSION['userID'],
        'createTime'=>date('Y-m-d H:i:s'),
        'editID'=>$_SESSION['userID'],
        'editTime'=>date('Y-m-d H:i:s'));

 
    if($db->insertData($table,$params)){

        $containerType=post('containerType');
        $containerSize=post('containerSize');
        $containerNo=post('containerNo');
        $containerSealNo=post('containerSealNo');
        $containerGW=post('containerGW');
        $containerGW_unit=post('containerGW_unit');
        $containerNW=post('containerNW');
        $containerNW_Unit=post('containerNW_Unit');
        $containerTareweight=post('containerTareweight');



        // Container
        $items1=0;
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


// Packeds
$packaed_width=post('packaed_width');
$packaed_length=post('packaed_length');
$packaed_height=post('packaed_height');
$packaed_qty=post('packaed_qty');
$packaed_weight=post('packaed_weight');
$packaed_unit=post('packaed_unit');


     
        $items2=0;
        foreach($packaed_width as $r){
            if($r!=""){  
                
                if($r>0 && 
                $packaed_length[$items2]>0 && 
                $packaed_height[$items2]>0 && 
                $packaed_qty[$items2]>0 &&
                $packaed_weight[$items2]
                ){
                    $packaed_totalCBM=(($r*$packaed_length[$items2]*$packaed_height[$items2])/1000000);
                    $packaed_totalWeight=($packaed_qty[$items2]*$packaed_weight[$items2]);
                    $params_packed=array(
                    'comCode'=>$db->comCode,
                    'documentID'=>$documentID,
                    'packaed_width'=>$r,
                    'packaed_length'=>$packaed_length[$items2],
                    'packaed_height'=>$packaed_height[$items2],
                    'packaed_qty'=>$packaed_qty[$items2],
                    'packaed_weight'=>$packaed_weight[$items2],                
                    'packaed_unit'=>$packaed_unit[$items2],
                    'packaed_totalCBM'=>$packaed_totalCBM,      
                    'packaed_totalWeight'=>$packaed_totalWeight        
                    );
                    $db->insertData('joborder_packed',$params_packed);
                }
            }

            $items2++;
        }

// Goods
$goodNo=post('goodNo');
$goodDec=post('goodDec');
$goodWeight=post('goodWeight');
$good_unit=post('good_unit');
$goodSize=post('goodSize');
$goodKind=post('goodKind');

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

$chargeitems=post('chargeitems');
$chargesDetail=post('chargesDetail');
$chargesCost=post('chargesCost');
$chargesPrice=post('chargesPrice');
$curency=post('curency');
$items4=0;
if($chargeitems){
foreach($chargeitems as $r){ 
        $cost=$chargesCost[$items4];
        $price=$chargesPrice[$items4]; 
        $var_curency=$curency[$items4];
        $info_rate=$db->fetch("SELECT c.exchange_rate FROM $db->dbname.common_currency AS c WHERE c.comCode='$db->comCode' AND c.currencyCode='$var_curency' AND c.isActive=1");
        $rateChange=$info_rate['exchange_rate'];  
        
        $costBaht=$cost*$rateChange;
        $priceBath=$price*$rateChange;
            $params_charges=array(
            'comCode'=>$db->comCode,
            'documentID'=>$documentID,
            'chargeCode'=>$r,
            'detail'=>$chargesDetail[$items4],
            'currencyCode'=>$var_curency,
            'creencyrate'=>$rateChange,
            'cost'=>$cost,                
            'costBaht'=>$costBaht,
            'price'=>$price,                
            'priceBath'=>$priceBath
            );
            $db->insertData('joborder_charge',$params_charges);
    $items4++;
}}

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
}elseif($action=='edit'){
        $params=array(
        'comCode'=>$db->comCode,
        'documentID'=>$documentID,
        'documentDate'=>$documentDate,
        'bound'=>post("bound"),  
        'freight'=>post("freight"), 
        'documentstatus'=>$documentstatus,
        'editID'=>$_SESSION['userID'],
        'editTime'=>date('Y-m-d H:i:s'));
        if($db->updateData($table,$params,"comCode='$db->comCode' AND documentID='$documentID'")){
            $array = array( 
                "documentID"=>$documentID,
                "result"=>'success');
                echo json_encode($array);
        }else{
            $array = array( 
                "documentID"=>$documentID,
                "result"=>'error');
                echo json_encode($array);
        }
}elseif($action=='del'){
	$sql="DELETE FROM $table WHERE comCode='$db->comCode' AND documentID='$documentID' ";
    if($db->deleteData($sql)){
		echo 'success';
	}else{
		echo $sql;
		 echo 'error';
		
	}
	
	
}


?>