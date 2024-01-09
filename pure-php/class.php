<?php
date_default_timezone_set("Asia/Bangkok");
//--- Class manager DB --->
class cl{
	private $db_host = 'db';
	private $db_user = 'root';
	private $db_pass = 'password';
	public $dbname = 'ats';
	public $comCode='C01';
	
    private $result = array();     // Results that are returned from the query
	
	//--- connecter --->
	//--- return connection
	public function connect(){
		try{
			$con =  mysqli_connect($this->db_host,$this->db_user,$this->db_pass,$this->dbname);     // or die(mysqli_error());
			if($con){
			//	$seldb = mysqli_select_db($myconn,$this->db_name);
                $seldb = mysqli_query($con,"SET NAMES UTF8");
				if($seldb){
					return $con;
				}else{
					return false;
				}				
			}else{
				return false;
			}
		}catch(Exception $e){
			return $e;
		}
	}#


	//--- disconnect --->
	public function disconnect(){
		try{
			if($this->con){
				if(mysqli_close($this->connect())){
					$this->con = false;
					return true;
					//echo connection_status();
				}else{
					return false;
				}
			}
		}catch(Exception $e){
			return $e;
		}
	}#
	
	//--- check table --->
	private function tableExists($table){
		try{
			if (!$this->connect())
				exit('Error : Connection not found.');
			
			$tablesInDb = mysqli_query($this->connect(),"SHOW TABLES FROM ".$this->dbname." LIKE '".$table."'");
			if($tablesInDb){
				if(mysqli_num_rows($tablesInDb)==1){
					return true;
				}else{
					return false;
				}
			}else{
				return false;
			}
		}catch(Exception $e){
			return $e;
		}
	}#
	

	public function insertData($table,$params=array()){  	
          $sql='INSERT INTO '.$table.' (`'.implode('`, `',array_keys($params)).'`) VALUES (\'' . implode('\', \'', $params) . '\')';
		//$result = mysqli_query($conn, $sql) or trigger_error("Query Failed! SQL: $sql - Error: ".mysqli_error($conn), E_USER_ERROR);
		if($ins = mysqli_query($this->connect(),$sql)){
		 		//array_push($this->result,mysqli_insert_id());
                    return true;
			}else{
					//echo  $sql;
					return false; 
			}
	}
	
	
	public function deleteData($sql){  	
		if($ins = mysqli_query($this->connect(),$sql)){
				 return true;
			}else{
				echo  $sql;
				return false; 
			}
	}
	
	
	
	
	
	public function fetch($sql){
			$query = mysqli_query($this->connect(),$sql);
			$result=mysqli_fetch_assoc($query);
			return $result;	
	}
	public function numrow($sql){
		$query = mysqli_query($this->connect(),$sql);
		$result=mysqli_num_rows($query);
		return $result;	
}
	
	
	

    public function updateData($table,$params=array(),$where){
		$args=array();
		foreach($params as $field=>$value){
			$args[]=$field.'="'.$value.'"';
		}
		$sql='UPDATE '.$table.' SET '.implode(',',$args).' WHERE '.$where;
		
		if($query = mysqli_query($this->connect(),$sql)){
			//array_push($this->result,mysqli_affected_rows());
			return true;
		}else{
			//array_push($this->result,mysqli_error());
            echo $sql;
			return false;
		}
	}	


    public function genarate_docuemntID($table,$field,$prefixformat,$number){
			$documentID='';	
			$prefixDate='';	
			$result_prefix= explode("-", $prefixformat);
			$prefixCharector=$result_prefix[0];
			if(isset($result_prefix['1'])!=""){
				$prefixdate_format=$result_prefix['1'];
				switch($prefixdate_format){
					case 'Ym' :  $prefixDate=date('Ym');   break;
					case 'Y-m' :  $prefixDate=date('Y-m');   break;
					case 'ym' :  $prefixDate=date('ym');   break;
					case 'y-' :  $prefixDate=date('y-');   break;
					case 'y' :  $prefixDate=date('y');   break;
				}
			}
			$prefix=$prefixCharector.$prefixDate;
			$sql="SELECT right(concat('000000',max(right($field,$number))+1),$number) as documentID FROM $table";
			if($prefixDate!=""){
				$sql.=" WHERE $field like '$prefix%' ";
			}

			$result = mysqli_query($this->connect(),$sql);
			$r=mysqli_fetch_assoc($result);
			$runmber=$r['documentID'];
			if($runmber==''){$runmber=substr('000001',-$number);  }
			$documentID=$prefixCharector.$prefixDate.'-'.$runmber;
			return $documentID;

	}	

	//--- Select All --->
	//--- Return Array()
	
	public function query($sql){
		$query = mysqli_query($this->connect(),$sql);
		return $query;	
}

	public function  s_country($countryCode=NULL){
		$sql=mysqli_query($this->connect(),"SELECT g.countryCode,g.countryNameTH,g.countryNameEN FROM $this->dbname.common_country AS g order by  g.countryNameTH ");
	
	
		if($countryCode==''){
			echo "<option value='' selected='selected'>- select -</option>";
		}else{
			echo "<option value=''>- select -</option>";
		}
	while($row=mysqli_fetch_assoc($sql)){
		if($countryCode==$row['countryCode']){
			echo "<option value='$row[countryCode]' selected='selected'>$row[countryNameTH]</option>";
		}else{
			echo "<option value='$row[countryCode]'>$row[countryNameTH]</option>";
		}			 
	}   
	}
    
    
    
  	public function  s_userType($userTypecode=NULL){
		$sql=mysqli_query($this->connect(),"SELECT
t.userTypecode,
t.userTypeName
FROM $this->dbname.user_type AS t ");
	
	
		if($userTypecode==''){
			echo "<option value='' selected='selected'>- select -</option>";
		}else{
			echo "<option value=''>- select -</option>";
		}
	while($row=mysqli_fetch_assoc($sql)){
		if($userTypecode==$row['userTypecode']){
			echo "<option value='$row[userTypecode]' selected='selected'>$row[userTypeName]</option>";
		}else{
			echo "<option value='$row[userTypecode]'>$row[userTypeName]</option>";
		}			 
	}   
	}
    
    
	public function  s_containerType($containertypeCode=NULL){
		$sql=mysqli_query($this->connect(),"SELECT g.containertypeCode,g.containertypeName FROM $this->dbname.common_containertype AS g order by  g.containertypeName ");
		if($containertypeCode==''){
			echo "<option value='' selected='selected'>- select -</option>";
		}else{
			echo "<option value=''>- select -</option>";
		}
	
		while($row=mysqli_fetch_assoc($sql)){
			if($containertypeCode==$row['containertypeCode']){
				echo "<option value='$row[containertypeCode]' selected='selected'>$row[containertypeName]</option>";
			}else{
				echo "<option value='$row[containertypeCode]'>$row[containertypeName]</option>";
			}			 
		}   
	}

	public function  s_place($placeCode=NULL){
		$sql=mysqli_query($this->connect(),"SELECT g.pCode,g.pName FROM $this->dbname.common_place AS g order by  g.pName ");
		if($placeCode==''){
			echo "<option value='' selected='selected'>- select -</option>";
		}else{
			echo "<option value=''>- select -</option>";
		}
	
		while($row=mysqli_fetch_assoc($sql)){
			if($placeCode==$row['pCode']){
				echo "<option value='$row[pCode]' selected='selected'>$row[pName]</option>";
			}else{
				echo "<option value='$row[pCode]'>$row[pName]</option>";
			}			 
		}   
	}
    

	public function  s_feeder($fCode=NULL){
		$sql=mysqli_query($this->connect(),"SELECT g.fCode,g.fName FROM $this->dbname.common_feeder AS g order by  g.fName ");
		if($fCode==''){
			echo "<option value='' selected='selected'>- select -</option>";
		}else{
			echo "<option value=''>- select -</option>";
		}
	
		while($row=mysqli_fetch_assoc($sql)){
			if($fCode==$row['fCode']){
				echo "<option value='$row[fCode]' selected='selected'>$row[fName]</option>";
			}else{
				echo "<option value='$row[fCode]'>$row[fName]</option>";
			}			 
		}   
	}
    
    
    
    

	public function  s_unit($unitCode=NULL){
		$sql=mysqli_query($this->connect(),"SELECT g.unitCode,g.unitName FROM $this->dbname.common_unit AS g order by  g.unitName ");
		if($unitCode==''){
			echo "<option value='' selected='selected'>- select -</option>";
		}else{
			echo "<option value=''>- select -</option>";
		}
	
		while($row=mysqli_fetch_assoc($sql)){
			if($unitCode==$row['unitCode']){
				echo "<option value='$row[unitCode]' selected='selected'>$row[unitName]</option>";
			}else{
				echo "<option value='$row[unitCode]'>$row[unitName]</option>";
			}			 
		}   
	}
    
  	public function  s_unitContainer($unitCode=NULL){
        if($unitCode==''){$unitCode='U-02';}
		$sql=mysqli_query($this->connect(),"SELECT g.unitCode,g.unitName FROM $this->dbname.common_unit_containner AS g order by  g.unitName ");
		if($unitCode==''){
			echo "<option value='' selected='selected'>- select -</option>";
		}else{
			echo "<option value=''>- select -</option>";
		}
	
		while($row=mysqli_fetch_assoc($sql)){
			if($unitCode==$row['unitCode']){
				echo "<option value='$row[unitCode]' selected='selected'>$row[unitName]</option>";
			}else{
				echo "<option value='$row[unitCode]'>$row[unitName]</option>";
			}			 
		}   
	}  
    
    
	public function  s_unit_packed($cm=NULL){
		$sql=mysqli_query($this->connect(),"SELECT g.cm,g.unitName FROM $this->dbname.common_unit_packed AS g order by  g.unitName ");
		if($cm==''){
			echo "<option value='' selected='selected'>- select -</option>";
		}else{
			echo "<option value=''>- select -</option>";
		}
	
		while($row=mysqli_fetch_assoc($sql)){
			if($cm==$row['cm']){
				echo "<option value='$row[cm]' selected='selected'>$row[unitName]</option>";
			}else{
				echo "<option value='$row[cm]'>$row[unitName]</option>";
			}			 
		}   
	}




	public function  s_containerSize($containersizeCode=NULL){
		$sql=mysqli_query($this->connect(),"SELECT g.containersizeCode,g.containersizeName FROM $this->dbname.common_containersize AS g order by  g.containersizeName ");
		if($containersizeCode==''){
			echo "<option value='' selected='selected'>- select -</option>";
		}else{
			echo "<option value=''>- select -</option>";
		}
	
		while($row=mysqli_fetch_assoc($sql)){
			if($containersizeCode==$row['containersizeCode']){
				echo "<option value='$row[containersizeCode]' selected='selected'>$row[containersizeName]</option>";
			}else{
				echo "<option value='$row[containersizeCode]'>$row[containersizeName]</option>";
			}			 
		}   
	}

	public function  s_saleman($saleID=NULL){
		$sql=mysqli_query($this->connect(),"SELECT g.usercode,g.empName FROM $this->dbname.common_saleman AS g order by  g.empName ");
		if($saleID==''){
			echo "<option value='' selected='selected'>- select -</option>";
		}else{
			echo "<option value=''>- select -</option>";
		}
	
		while($row=mysqli_fetch_assoc($sql)){
			if($saleID==$row['usercode']){
				echo "<option value='$row[usercode]' selected='selected'>$row[empName]</option>";
			}else{
				echo "<option value='$row[usercode]'>$row[empName]</option>";
			}			 
		}   
	}
    
    
    
	public function  s_customer($cusCode=NULL){
		if($cusCode==''){
			echo "<option value='' selected='selected'>- select -</option>";
		}else{
			echo "<option value=''>- select -</option>";
		}	
		$sql=mysqli_query($this->connect(),"SELECT g.cusCode,g.custNameEN FROM $this->dbname.common_customer AS g order by  g.custNameEN ");
	while($row=mysqli_fetch_assoc($sql)){
			if($cusCode==$row['cusCode']){
				echo "<option value='$row[cusCode]' selected='selected'>$row[custNameEN]</option>";
			}else{
				echo "<option value='$row[cusCode]'>$row[custNameEN]</option>";
			}			 
		}   
	}
    
    
  	public function  s_customer_advance($cusCode=NULL,$userType=NULL){
		if($cusCode==''){
			echo "<option value='' selected='selected'>- select -</option>";
		}else{
			echo "<option value=''>- select -</option>";
		}	
        
        if($userType=='4'){
            
$sql=mysqli_query($this->connect(),"SELECT g.cusCode,g.custNameEN FROM $this->dbname.common_customer AS g WHERE g.cusCode='$cusCode' order by  g.custNameEN ");
            
        }else{
$sql=mysqli_query($this->connect(),"SELECT g.cusCode,g.custNameEN FROM $this->dbname.common_customer AS g order by  g.custNameEN ");    
        }
        
	while($row=mysqli_fetch_assoc($sql)){
			if($cusCode==$row['cusCode']){
				echo "<option value='$row[cusCode]' selected='selected'>$row[custNameEN]</option>";
			}else{
				echo "<option value='$row[cusCode]'>$row[custNameEN]</option>";
			}			 
		}   
	}  
	public function  s_jobref2($ref_jobID=NULL){
		if($ref_jobID==''){
			echo "<option value='' selected='selected'>- select -</option>";
		}else{
			echo "<option value=''>- select -</option>";
		}	

		$sql=mysqli_query($this->connect(),"SELECT g.documentID
		FROM $this->dbname.joborder AS g  
		LEFT JOIN invoice AS i ON g.comCode = i.comCode AND g.documentID = i.ref_jobNo
		LEFT JOIN tax_invoice_items AS t ON i.comCode = t.comCode AND i.documentID = t.invNo
		WHERE   t.documentID IS NULL  order by g.documentID   ");





	while($row=mysqli_fetch_assoc($sql)){
			if($ref_jobID==$row['documentID']){
				echo "<option value='$row[documentID]' selected='selected'>$row[documentID]</option>";
			}else{
				echo "<option value='$row[documentID]'>$row[documentID]</option>";
			}			 
		}   
	}
    
	public function  s_jobref_advance($ref_jobID,$cusCode){
		if($ref_jobID==''){
			echo "<option value='' selected='selected'>- select -</option>";
		}else{
			echo "<option value=''>- select -</option>";
		}	

		$sql=mysqli_query($this->connect(),"SELECT g.documentID,concat(g.documentID,' -INV NO. [',g.invNo,']') as documentName 
		FROM $this->dbname.joborder AS g  
		LEFT JOIN invoice AS i ON g.comCode = i.comCode AND g.documentID = i.ref_jobNo
		LEFT JOIN tax_invoice_items AS t ON i.comCode = t.comCode AND i.documentID = t.invNo
		WHERE  g.cusCode like'$cusCode%' AND t.documentID IS NULL  order by g.documentID   ");
	while($row=mysqli_fetch_assoc($sql)){
			if($ref_jobID==$row['documentID']){
				echo "<option value='$row[documentID]' selected='selected'>$row[documentName]</option>";
			}else{
				echo "<option value='$row[documentID]'>$row[documentName]</option>";
			}			 
		}  
	}
        
    
    
    
    
    public function  s_month($monthID=NULL){
		$sql=mysqli_query($this->connect(),"SELECT
m.monthID,
m.monthName
FROM
`month` AS m
");
		if($monthID==''){
			echo "<option value='' selected='selected'>- select -</option>";
		}else{
			echo "<option value=''>- select -</option>";
		}
	
		while($row=mysqli_fetch_assoc($sql)){
			if($monthID==$row['monthID']){
				echo "<option value='$row[monthID]' selected='selected'>$row[monthName]</option>";
			}else{
				echo "<option value='$row[monthID]'>$row[monthName]</option>";
			}			 
		}   
	}
    
    
	public function  s_port($portCode=NULL){
		if($portCode==''){
			echo "<option value='' selected='selected'>- select -</option>";
		}else{
			echo "<option value=''>- select -</option>";
		}	
		$sql=mysqli_query($this->connect(),"SELECT g.portCode,g.portNameEN FROM $this->dbname.common_port AS g order by  g.portNameEN ");
	while($row=mysqli_fetch_assoc($sql)){
			if($portCode==$row['portCode']){
				echo "<option value='$row[portCode]' selected='selected'>$row[portNameEN]</option>";
			}else{
				echo "<option value='$row[portCode]'>$row[portNameEN]</option>";
			}			 
		}   
	}

	public function  s_supplier($supCode=NULL){
		if($supCode==''){
			echo "<option value='' selected='selected'>- select -</option>";
		}else{
			echo "<option value=''>- select -</option>";
		}	
		$sql=mysqli_query($this->connect(),"SELECT g.supCode,g.supNameEN FROM $this->dbname.common_supplier AS g order by  g.supNameEN ");
	while($row=mysqli_fetch_assoc($sql)){
			if($supCode==$row['supCode']){
				echo "<option value='$row[supCode]' selected='selected'>$row[supNameEN]</option>";
			}else{
				echo "<option value='$row[supCode]'>$row[supNameEN]</option>";
			}			 
		}   
	}

	public function  s_vattype($typeCode=NULL){
		if($typeCode==''){
			echo "<option value='' selected='selected'>- select -</option>";
		}else{
			echo "<option value=''>- select -</option>";
		}	
		$sql=mysqli_query($this->connect(),"SELECT g.typeCode,g.typeName FROM $this->dbname.common_vattype AS g order by  g.typeName ");
	while($row=mysqli_fetch_assoc($sql)){
			if($typeCode==$row['typeCode']){
				echo "<option value='$row[typeCode]' selected='selected'>$row[typeName]</option>";
			}else{
				echo "<option value='$row[typeCode]'>$row[typeName]</option>";
			}			 
		}   
	}

	public function  s_freight($transportCode=NULL){
		if($transportCode==''){
			echo "<option value='' selected='selected'>- select -</option>";
		}else{
			echo "<option value=''>- select -</option>";
		}	
		$sql=mysqli_query($this->connect(),"SELECT g.transportCode,g.transportName FROM $this->dbname.common_transporttype AS g order by  g.transportName ");
	while($row=mysqli_fetch_assoc($sql)){
			if($transportCode==$row['transportCode']){
				echo "<option value='$row[transportCode]' selected='selected'>$row[transportName]</option>";
			}else{
				echo "<option value='$row[transportCode]'>$row[transportName]</option>";
			}			 
		}   
	}



	public function  s_charge($chargeCode=NULL){
		$sql=mysqli_query($this->connect(),"SELECT g.chargeCode,g.chargeName FROM $this->dbname.common_charge AS g order by  g.chargeName ");
	while($row=mysqli_fetch_assoc($sql)){
			if($chargeCode==$row['chargeCode']){
				echo "<option value='$row[chargeCode]' selected='selected'>$row[chargeName]</option>";
			}else{
				echo "<option value='$row[chargeCode]'>$row[chargeName]</option>";
			}			 
		}   
	}	

    
    
  	public function  s_invoiceref($customer=NULL){
		if($ref_jobID==''){
			echo "<option value='' selected='selected'>- select -</option>";
		}else{
			echo "<option value=''>- select -</option>";
		}	

		$sql=mysqli_query($this->connect(),"SELECT
        i.documentID
        FROM $this->dbname.invoice AS i
        WHERE  i.cusCode='$customer' AND i.taxivRef =''  ");
	   while($row=mysqli_fetch_assoc($sql)){
				echo "<option value='$row[documentID]'>$row[documentID]</option>";
		}   
	}
    
    
	public function  s_jobref($ref_jobID=NULL){
		if($ref_jobID==''){
			echo "<option value='' selected='selected'>- select -</option>";
		}else{
			echo "<option value=''>- select -</option>";
		}	


		$sql=mysqli_query($this->connect(),"SELECT g.documentID
		FROM $this->dbname.joborder AS g  
		LEFT JOIN invoice AS i ON g.comCode = i.comCode AND g.documentID = i.ref_jobNo
		LEFT JOIN tax_invoice_items AS t ON i.comCode = t.comCode AND i.documentID = t.invNo
		WHERE   t.documentID IS NULL  order by g.documentID   ");


	while($row=mysqli_fetch_assoc($sql)){
			if($ref_jobID==$row['documentID']){
				echo "<option value='$row[documentID]' selected='selected'>$row[documentID]</option>";
			}else{
				echo "<option value='$row[documentID]'>$row[documentID]</option>";
			}			 
		}   
	}
    
    
    

	public function  s_charge_type($typeCode=NULL){
		$sql=mysqli_query($this->connect(),"SELECT g.typeCode,g.typeName FROM $this->dbname.common_chargestype AS g order by  g.typeName ");
	while($row=mysqli_fetch_assoc($sql)){
			if($typeCode==$row['typeCode']){
				echo "<option value='$row[typeCode]' selected='selected'>$row[typeName]</option>";
			}else{
				echo "<option value='$row[typeCode]'>$row[typeName]</option>";
			}			 
		}   
	}	
	public function  s_curency($currencyCode=null){
		$sql=mysqli_query($this->connect(),"SELECT g.currencyCode,g.currencyName FROM $this->dbname.common_currency AS g order by  g.currencyCode desc ");
	while($row=mysqli_fetch_assoc($sql)){
			if($currencyCode==$row['$currencyCode']){
				echo "<option value='$row[currencyCode]' selected='selected'>$row[currencyName]</option>";
			}else{
				echo "<option value='$row[currencyCode]'>$row[currencyName]</option>";
			}			 
		}   
	}	
	public function  s_account($accountCode=null){
		$sql=mysqli_query($this->connect(),"SELECT g.accountCode,accountID,g.accountNicname,g.accountID FROM $this->dbname.common_account AS g order by  g.accountCode desc ");
	while($row=mysqli_fetch_assoc($sql)){
			if($accountCode==$row['accountCode']){
				echo "<option value='$row[accountCode]' selected='selected'>$row[accountNicname] [$row[accountID]]</option>";
			}else{
				echo "<option value='$row[accountCode]'>$row[accountNicname] [$row[accountID]]</option>";
			}			 
		}   
	}	
    
    
	public function  s_user($usercode=NULL){
			
		if($usercode==''){
			echo "<option value='' selected='selected'>- select -</option>";
		}else{
			echo "<option value=''>- select -</option>";
		}
		$sql=mysqli_query($this->connect(),"SELECT g.usercode,g.username FROM $this->dbname.user AS g order by  g.username ");
	while($row=mysqli_fetch_assoc($sql)){
			if($usercode==$row['usercode']){
				echo "<option value='$row[usercode]' selected='selected'>$row[username]</option>";
			}else{
				echo "<option value='$row[usercode]'>$row[username]</option>";
			}			 
		}   
	}	

	public function  s_credit_term($creditCode=NULL){
			
		if($creditCode==''){
			echo "<option value='' selected='selected'>- select -</option>";
		}else{
			echo "<option value=''>- select -</option>";
		}
		$sql=mysqli_query($this->connect(),"SELECT g.creditCode,g.creditName FROM $this->dbname.common_creditterm AS g order by  g.creditCode asc ");
	while($row=mysqli_fetch_assoc($sql)){
			if($creditCode==$row['creditCode']){
				echo "<option value='$row[creditCode]' selected='selected'>$row[creditName]</option>";
			}else{
				echo "<option value='$row[creditCode]'>$row[creditName]</option>";
			}			 
		}   
	}	

	

}










/*
//--- Test method ตัวอย่างการใช้งาน --->
$db = new DatabaseManage;
$db->connect();

$field = 'word';
$data = "'yyyy'";
$res = $db->insertData('reserv_word',$field,$data);
print_r($res);
if($res)
	echo 'Insert success...';
else
	echo 'No insert.';
echo '<br/>';

$f = 'wordsss';
$d = "'ok...'";

$res = $db->updateData('user',$f,$d,'word_id=11');

$res = $db->selectAllData('reserv_word','*',$condition=null);
foreach ($res as $eachResult){
	echo $eachResult['word_id'].' ';
	echo $eachResult['word'].'<br>';
}
echo '<br/>';

$res = $db->selectOneData('reserv_word', '*', 'word_id=4');
echo $res['word_id'].' '.$res['word'];
echo '<br/>';

$res = $db->deleteData('reserv_word','word_id=8');
if($res)
	echo 'ok...';
else
	echo 'Can not delete.';
*/

// End class DatabaseManage #
