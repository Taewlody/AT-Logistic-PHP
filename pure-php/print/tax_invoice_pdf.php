<?php
ob_start(); 
/*
	error_reporting(0);
	error_reporting(E_ERROR | E_WARNING | E_PARSE);
	error_reporting(E_ALL);
	ini_set("error_reporting", E_ALL);
	error_reporting(E_ALL & ~E_NOTICE);
*/
require_once( '../class.php' );
require_once( '../function.php' );
require_once('../js/plugins/tcpdf/tcpdf.php');
$db = new cl;
$path_assets='assets';
$path_bootstrap='bootstrap';
$path_plugins='plugins';
$documentID=isset($_GET['documentID'])?$_GET['documentID']:'';

$sql_info_com="SELECT
cp.com_code,
cp.comname,
cp.comnameEN,
cp.taxID as cpTax,
cp.address,
cp.address_en,
cp.telephone as cpTel,
cp.fax as cpFax,
cp.logo
FROM company AS cp ";
$info1=$db->fetch($sql_info_com);	
$_SESSION['comname']= $info1['comname'];
$_SESSION['comnameEN']= $info1['comnameEN'];
$_SESSION['address']= $info1['address'];
$_SESSION['address_en']= $info1['address_en'];
$_SESSION['cpTel']= $info1['cpTel'];
$_SESSION['cpTax']= $info1['cpTax'];
$_SESSION['cpFax']= $info1['cpFax'];
$_SESSION['logo']= $info1['logo'];


$sql = "SELECT
t.comCode,
t.documentID,
date_format(t.documentDate,'%d/%m/%Y') as documentDate,
t.cusCode,
t.cus_address,
t.saleman,
t.creditterm,
t.note,
t.remark,
t.documentstatus,
t.createID,
t.createTime,
t.editID,
t.editTime,
t.total_amt,
t.total_vat,
t.tax3,
t.tax1,
t.cus_paid,
t.total_netamt,
t.payType,
t.payTypeOther,
t.branch,
t.chequeNo,
date_format(t.dueDate,'%d/%m/%Y') as dueDate,
t.dueTime,
c.custNameTH,
c.custNameEN,
c.branchTH,
c.branchEN,
c.taxID,
c.addressTH,
c.addressEN,
a.accountName,
(SELECT
 GROUP_CONCAT(DISTINCT(i.invNo)) as invNo
FROM
tax_invoice_items AS i
WHERE i.documentID=t.documentID
) AS GinvNo
FROM
tax_invoice AS t
INNER JOIN common_customer AS c ON t.comCode = c.comCode AND t.cusCode = c.cusCode
INNER JOIN common_account AS a ON t.comCode = a.comCode AND t.accountCode = a.accountCode
WHERE  t.comCode='$db->comCode' AND t.documentID='$documentID'  ";
$info=$db->fetch($sql);


$_SESSION['payType']=$info['payType'];
$_SESSION['payTypeOther']=$info['payTypeOther'];
$_SESSION['branch']=$info['branch'];
$_SESSION['chequeNo']=$info['chequeNo'];
$_SESSION['dueDate']=$info['dueDate'];
$_SESSION['dueTime']=$info['dueTime'];
$_SESSION['GinvNo']=$info['GinvNo'];	
	
	
$_SESSION['cus_address']=$info['cus_address'];
$_SESSION['refJobNo']=$info['ref_jobNo'];
$_SESSION['custNameTH']=$info['custNameTH'];
$_SESSION['custNameEN']=$info['custNameEN'];
$_SESSION['branchTH']=$info['branchTH'];


	
$_SESSION['taxID']=$info['taxID'];
$_SESSION['branchCode']=$info['branchCode'];

$_SESSION['documentID']=$info['documentID'];
$_SESSION['documentDate']=$info['documentDate'];
$_SESSION['creditName']=$info['creditName'];
$_SESSION['your_RefNo']=$info['your_RefNo'];
$_SESSION['empName']=$info['empName'];
$_SESSION['accountName']=$info['accountName'];






$sql = "SELECT
t.comCode,
t.documentID,
t.chargeCode,
c.chargeName as detail,
t.chargesCost,
sum(t.chargesReceive) as chargesReceive,
sum(t.chargesbillReceive) as chargesbillReceive,
i.total_amt,
i.total_vat,
i.tax3,
i.tax1,
i.cus_paid,
i.total_netamt,
ct.amount,
i.remark
FROM  $db->dbname.tax_invoice_items AS t
INNER JOIN  $db->dbname.tax_invoice AS i ON t.comCode = i.comCode AND t.documentID = i.documentID
INNER JOIN $db->dbname.common_charge AS c ON t.comCode = c.comCode AND t.chargeCode = c.chargeCode
INNER JOIN $db->dbname.common_chargestype AS ct ON c.comCode = ct.comCode AND c.typeCode = ct.typeCode
WHERE  t.comCode='$db->comCode' AND t.documentID='$documentID'  AND t.chargesReceive>0
group by t.chargeCode
order by t.chargeCode asc
";
$result_temp=$db->query($sql);
$i = 1;
$sumTotal = 0;
$sum_chargesbillReceive=0;
$sum_chargesReceive=0;
$total_vat=0;
$total_amt=0;
$tax3=0;
$tax1=0;
$cus_paid=0;
$total_netamt=0;

$sumfortax3=0;
$sumfortxt1=0;

while($r=mysqli_fetch_assoc($result_temp)){
$sum_chargesReceive += $r['chargesReceive'];
//$sum_chargesbillReceive += $r['chargesbillReceive'];
$total_vat=$r['total_vat'];
$total_amt=$r['total_amt'];
$tax3=$r['tax3'];
$tax1=$r['tax1'];
$cus_paid=$r['cus_paid'];
$total_netamt=$r['total_netamt'];  
$remark=$r['remark'];
 if($r['amount']==3){ $sumfortax3+=$r['chargesReceive']; }   
 if($r['amount']==1){ $sumfortxt1+=$r['chargesReceive'];  }  
    
}

$sql2 = "SELECT
t.comCode,
t.documentID,
t.chargeCode,
c.chargeName as detail,
t.chargesCost,
sum(t.chargesReceive) as chargesReceive,
sum(t.chargesbillReceive) as chargesbillReceive,
i.total_amt,
i.total_vat,
i.tax3,
i.tax1,
i.cus_paid,
i.total_netamt,
ct.amount,
i.remark
FROM  $db->dbname.tax_invoice_items AS t
INNER JOIN  $db->dbname.tax_invoice AS i ON t.comCode = i.comCode AND t.documentID = i.documentID
INNER JOIN $db->dbname.common_charge AS c ON t.comCode = c.comCode AND t.chargeCode = c.chargeCode
INNER JOIN $db->dbname.common_chargestype AS ct ON c.comCode = ct.comCode AND c.typeCode = ct.typeCode
WHERE  t.comCode='$db->comCode' AND t.documentID='$documentID'  AND t.chargesbillReceive>0
group by t.chargeCode
order by t.chargeCode asc
";
$result2=$db->query($sql2);
while($r=mysqli_fetch_assoc($result2)){

$sum_chargesbillReceive += $r['chargesbillReceive'];
  
}


$_SESSION['sum_chargesbillReceive']=$sum_chargesbillReceive;
$_SESSION['sum_chargesReceive']=$sum_chargesReceive;
$_SESSION['sumfortax3']=$sumfortax3;
$_SESSION['sumfortxt1']=$sumfortxt1;
$_SESSION['total_vat']=$total_vat;
$_SESSION['total_amt']=($sum_chargesReceive+$total_vat);
$_SESSION['tax3']=$tax3;
$_SESSION['tax1']=$tax1;
$_SESSION['cus_paid']=$cus_paid;
$_SESSION['total_netamt']=$total_netamt;
$_SESSION['remark']=$remark;

$_SESSION['text']=Convert($total_netamt);




class MYPDF extends TCPDF {
	//Page header
	public function Header() {
		// Logo
		//$image_file = K_PATH_IMAGES.'logo.jpg';
       
		//$image_file = './img/logo/'.$_SESSION['logo'];
        $image_file = '../img/logoNew.jpg';
		$this->Image($image_file, 160, 5, 40, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        $this->Ln(5);
        $this->SetX(8);
        $this->SetFont('thsarabun', 'B', 16);
        $this->Cell(0, 15,$_SESSION['comnameEN'], 0, false, 'L', 0, '', 0, false, 'M', 'M');  
	    $this->SetFont('thsarabun', '', 14);
        $this->Ln(5);
        $this->Cell(0, 15,$_SESSION['address_en'], 0, false, 'L', 0, '', 0, false, 'M', 'M');  
        $this->Ln(5);
        $this->SetFont('thsarabun', 'B', 16);
        $this->Cell(0, 15,$_SESSION['comname'], 0, false, 'L', 0, '', 0, false, 'M', 'M');  
         $this->SetFont('thsarabun', '', 14);
          $this->Ln(5);
        $this->Cell(0, 15,$_SESSION['address'], 0, false, 'L', 0, '', 0, false, 'M', 'M');  
        
        
              $this->SetFont('thsarabun', 'B', 14);
        $this->Ln(5);
        $this->Cell(0, 15,'หมายเลขประจำตัวผู้เสียภาษี   ', 0, false, 'L', 0, '', 0, false, 'M', 'M'); 
         $this->SetX(60);
         $this->SetFont('thsarabun', '', 14);
        $this->Cell(0, 15,$_SESSION['cpTax'], 0, false, 'L', 0, '', 0, false, 'M', 'M');  
        $this->Ln(5);
         $this->SetFont('thsarabun', 'B', 14);
        
        $this->Cell(0, 15,'Tel.                                              Fax.', 0, false, 'L', 0, '', 0, false, 'M', 'M'); 
        $this->SetX(15);
         $this->SetFont('thsarabun', '', 14);
          $this->Cell(0, 15,$_SESSION['cpTel'].'                        '.$_SESSION['cpFax'], 0, false, 'L', 0, '', 0, false, 'M', 'M'); 
		$this->SetFont('thsarabun', 'B', 18);
			$this->SetTextColor(255, 51, 51);
		$numberpage=$this->getPage();
        if($numberpage=='1'){
		$this->Cell(0, 15,'ORIGINAL / ต้นฉบับ      ', 0, false, 'R', 0, '', 0, false, 'M', 'M');
        }else if($numberpage=='4'){
		}else{
         $this->Cell(0, 15,'COPY / สำเนา        ', 0, false, 'R', 0, '', 0, false, 'M', 'M');	   
        }
		
			$this->SetTextColor(0, 0, 0);
          
        
        $this->SetFont('thsarabun', '', 14);
       $this->Ln(2);
      
        $this->Cell(0, 15,'___________________________________________________________________________________________________________', 0, false, 'C', 0, '', 0, false, 'M', 'M');  
		// Set font
           // $style = array('width' => 0.5, 'cap' => 'butt', 'join' => 'miter', 'dash' => '10,20,5,10', 'phase' => 10, 'color' => array(255, 0, 0));
        //$this->Rect(75, 28, 60, 12, 'DF', $style, array(	70,130,180));
        
		$this->Ln(8);
       // $this->SetTextColor(0, 139, 139);
		// Set font

       // $style = array('width' => 0.5, 'cap' => 'butt', 'join' => 'miter', 'dash' => '10,20,5,10', 'phase' => 10, 'color' => array(255, 0, 0));
        $this->Rect(8, 39, 196, 10, 'DF', $style, array(184, 204, 228));

		
		$this->SetFont('thsarabun', 'B', 20);
		if($numberpage=='4'){
			$this->Cell(0, 15,'Official Receipt (ใบรับเงิน)', 0, false, 'C', 0, '', 0, false, 'M', 'M'); 
		}else{
			$this->Cell(0, 15,'ใบเสร็จรับเงิน / ใบกำกับภาษี', 0, false, 'C', 0, '', 0, false, 'M', 'M');  
		}
	
		
		

        //$this->SetTextColor(0, 0, 0);
        $this->SetFont('thsarabun', '', 14);
		$this->Ln(5);
        
     
$html_header='<table width="100%"  border="0" style="text-align:left;">
<tr>
    <td width="2%" align="left"><strong></strong></td>
    <td width="80%" align="left"><strong>Received Form</strong> : '.$_SESSION['custNameTH'].' สาขา '.$_SESSION['branchTH'].'</td>
    <td width="20%" align="left"><strong>No.  &nbsp;&nbsp;: '.$_SESSION['documentID'].'</strong></td>
    <td width="20%" align="left"></td>	
</tr>

<tr>
    <td  align="left"><strong></strong></td>
    <td  align="left"><strong>ได้รับเงินจาก</strong></td>
    <td  align="left"><strong>เลขที่</strong></td>
    <td  align="left"></td>
</tr>

<tr>
    <td align="left"><strong></strong></td>
    <td align="left" rowspan="2"><strong>Address</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: '.$_SESSION['cus_address'].'</td>
    <td align="left"><strong>Date</strong> : '.$_SESSION['documentDate'].'</td>
    <td align="left"></td>
</tr>

<tr>
    <td  align="left"><strong></strong></td>
    <td  align="left"><strong>ที่อยู่</strong></td>
    <td  align="left"><strong>วันที่</strong></td>
    <td  align="left"></td>
</tr>
<tr>
    <td  align="left"><strong></strong></td>
    <td  align="left"><strong>เลขประจำตัวผู้เสียภาษี</strong> : '.$_SESSION['taxID'].'</td>
    <td  align="left"></td>
    <td  align="left"></td>
</tr>



</table> ';
		
  //$numberpage=$this->getPage();
if($numberpage=='4'){      
 	$image_form = 'formtax2.png';
}else{
 	$image_form = 'formtax.png';	
}
		
		
		
$html_header='<table width="100%" border="0">
  <tbody>
    <tr>
      <td width="15%" >&nbsp;<strong>Received Form :</strong></td>
      <td width="65%" rowspan="2">'.$_SESSION['custNameTH'].' สาขา '.$_SESSION['branchTH'].'</td>
      <td width="5%" ><strong>No.</strong></td>
      <td width="15%" ><strong>'.$_SESSION['documentID'].'</strong></td>
    </tr>
    <tr>
      <td><strong>&nbsp;ได้รับเงินจาก</strong></td>
      <td><strong>เลขที่</strong></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;<strong>Address&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:</strong></td>
      <td rowspan="2">'.$_SESSION['cus_address'].'</td>
      <td><strong>Date:</strong></td>
      <td>'.$_SESSION['documentDate'].'</td>
    </tr>
    <tr>
      <td>&nbsp;<strong>ที่อยู่</strong></td>
      <td><strong>วันที่</strong></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td colspan="4">&nbsp;<strong>เลขประจำตัวผู้เสียภาษี : </strong> '.$_SESSION['taxID'].'</td>
    </tr>
  </tbody>
</table>';		
$this->Image($image_form, 7, 50, 198, '', 'PNG', '', '', false, 300, '', false, false, 0, false, false, false);       
        

        
  $this->writeHTMLCell(0, 0, '', '', $html_header, 0, 1, 0, true, '', true); 
        /*
		$this->Cell(0, 15,'ลูกค้า', 0, false, 'L', 0, '', 0, false, 'M', 'M');
        $this->SetX(50);
        $this->SetFont('thsarabun', '', 15);
        $this->Cell(0, 15,$_SESSION['custNameTH'], 0, false, 'L', 0, '', 0, false, 'M', 'M');
        
       
        $this->SetX(145);
        $this->SetFont('thsarabun', 'B', 15);
        $this->Cell(0, 15,'เลขที่เอกสาร/No', 0, false, 'L', 0, '', 0, false, 'M', 'M');
        
        $this->SetX(175);
        $this->SetFont('thsarabun', '', 15);
        $this->Cell(0, 15,$_SESSION['documentID'], 0, false, 'L', 0, '', 0, false, 'M', 'M');      
        
        
        
 
        $this->Ln(6);
        $this->SetFont('thsarabun', 'B', 15);
		$this->Cell(0, 15,'ที่อยู่', 0, false, 'L', 0, '', 0, false, 'M', 'M');
        $this->SetX(30);
        $this->SetFont('thsarabun', '', 15);
        $this->Cell(0, 15,$_SESSION['cus_address'], 0, false, 'L', 0, '', 0, false, 'M', 'M');
        
        
        $this->SetX(145);
        $this->SetFont('thsarabun', 'B', 15);
        $this->Cell(0, 15,'วันที่/Date', 0, false, 'L', 0, '', 0, false, 'M', 'M');
          $this->SetX(175);
        $this->SetFont('thsarabun', '', 15);
        $this->Cell(0, 15,$_SESSION['documentDate'], 0, false, 'L', 0, '', 0, false, 'M', 'M');  
        
        
    
 

        */
            
        
        
	}

    
	// Page footer
	public function Footer() {
    
		$numberpage=$this->getPage();
        if($numberpage=='4'){
			
	
        if($_SESSION['sum_chargesbillReceive']<1){
            $show_sum_chargesbillReceive="";
        }else{
            $show_sum_chargesbillReceive=number($_SESSION['sum_chargesbillReceive'],2);
        }
       $this->SetY(-115); 
        $this->SetFont('thsarabun', '', 14, '', true);
        $html='<table width="100%" border="0">
  <tbody>
  
     <tr>
	  <td width="390" ></td>
      <td width="160" align="left" valign="top" scope="col"><strong>TOTAL/จำนวนเงิน</strong></td>
      <td width="140" align="right" valign="top" scope="col"><strong>'.number($_SESSION['sum_chargesbillReceive'],2).'</strong></td>
    </tr>
	
    
	
    <tr>
      <td align="center" width="550" valign="top">'.Convert($_SESSION['sum_chargesbillReceive']).'</td>
    </tr>
	
	
	
	
  </tbody>
';
$html.='</table>';
		
		
		
		
		
		
		
		
		
		
		
// Print text using writeHTMLCell()
$this->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
$chk1='';
if($_SESSION['payType']=='c'){
	$chk1='checked="checked"';
	$total_netamtCash=$_SESSION['total_netamt'];
	$total_netamtCheque='';
}else{
	$total_netamtCash='';
	$total_netamtCheque=$_SESSION['total_netamt'];
}
$this->Ln(2);	
$this->writeHTMLCell(0, 0, '', '', ' <input type="checkbox" name="box1" value="1"  '.$chk1.' />เงินสด/cash  จำนวน&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;', 0, 1, 0, true, '', true);		
$this->Ln(-5);	
$this->writeHTMLCell(0, 0, '', '', '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;......................................................................................................................................................................................................', 0, 1, 0, true, '', true);		
		
		
		
		
      $html2='<table width="100%" border="1">
  <tbody>


    <tr>
	 
	  <td width="25%" align="center" valign="top"><strong>เช็คธนาคาร / Bank Cheque</strong></td>
      <td width="25%" align="center" valign="top"><strong>เลขที่ / Cheque No.</strong></td>
      <td width="25%" align="center" valign="top"><strong>ลงวันที่ / Date Due</strong></td>
	   <td width="25%" align="center" ><strong>จำนวน / Amount</strong></td>
    </tr>
	
    <tr>
	  
	  <td align="center" valign="top"><strong>'.$_SESSION['branch'].'</strong></td>
      <td align="center" valign="top"><strong>'.$_SESSION['chequeNo'].'</strong></td>
      <td align="center" valign="top"><strong>'.$_SESSION['dueDate'].'</strong></td>
	   <td align="center" valign="top"><strong>'.number($_SESSION['dueTime'],2).'</strong></td>
    </tr>
	
	
  </tbody>
';
        
        
        
        
        
        
$html2.='</table>';  
$this->Ln(2);	
		
$this->writeHTMLCell(0, 0, '', '', $html2, 0, 1, 0, true, '', true);
		
$this->Ln(2);
		
$html3='<table width="100%" border="0">
<tr>
	  <td width="25%" align="center" valign="top"><strong>In payment Account No. / Invoice</strong></td>
      <td width="75%" align="left" valign="top">'.$_SESSION['GinvNo'].'</td>
</tr>
</table>'; 
		
$this->writeHTMLCell(0, 0, '', '', $html3, 0, 1, 0, true, '', true);		
//$this->Cell(0, 15,'In payment Account No. / Invoice    '.$_SESSION['GinvNo'], 0, false, 'L', 0, '', 0, false, 'M', 'M');
		
$this->Ln(12);
$this->Cell(0, 15,'                    ..........................................................                                                    ...........................................................', 0, false, 'L', 0, '', 0, false, 'M', 'M'); 
$this->Ln(6);
$this->Cell(0, 15,'                              Collector / ผู้รับเงิน                                                        Authorized Signature / ผู้มีอำนาจลงนาม   ', 0, false, 'L', 0, '', 0, false, 'M', 'M');   
        
  $this->Ln(8);
$this->Cell(0, 15,'หมายเหตุ   1. ใบเสร็จรับเงินฉบับนี้จะสมบูรณ์ต้องมีลายเซ็นต์ผู้มีอำนาจลงนาม และผู้รับเงินพร้อมตราประทับบริษัทฯ', 0, false, 'L', 0, '', 0, false, 'M', 'M');      
   $this->Ln(6);
$this->Cell(0, 15,'               2. ใบกรณีชำระเงินด้วยเงินด้วยเช็ค  ใบเสร็จรับเงินจะสมบูรณ์ก็ต่อเมื่อบริษัทฯ เก็บเงินตามเช็คได้เรียบร้อย', 0, false, 'L', 0, '', 0, false, 'M', 'M');        
   $this->Ln(6);
$this->Cell(0, 15,'               3. กรุณาตรวจสอบความถูกต้องของเอกสารที่ได้รับและแจ้งให้บริษัทฯ ทราบเพื่อแก้ไขภายใน 7 วัน นับจากวันที่ปรากฎใบใบกำกับภาษี ', 0, false, 'L', 0, '', 0, false, 'M', 'M'); 
		   $this->Ln(6);
$this->Cell(0, 15,'               มิฉะนั้นถือว่าถูกต้องสมบูรณ์แล้ว', 0, false, 'L', 0, '', 0, false, 'M', 'M');        
			
			
			
			
			
			
			
			
		}else{
			
        if($_SESSION['sum_chargesbillReceive']<1){
            $show_sum_chargesbillReceive="";
        }else{
            $show_sum_chargesbillReceive=number($_SESSION['sum_chargesbillReceive'],2);
        }
       $this->SetY(-128); 
        $this->SetFont('thsarabun', '', 14, '', true);
        $html='<table width="100%" border="0">
  <tbody>
  
     <tr>
	  <td width="390" ></td>
      <td width="160" align="left" valign="top" scope="col"><strong>TOTAL/จำนวนเงิน</strong></td>
      <td width="140" align="right" valign="top" scope="col"><strong>'.number($_SESSION['sum_chargesReceive'],2).'</strong></td>
    </tr>
	
    
    <tr>
	  <td width="390" ></td>
      <td width="160" align="left" valign="top" scope="col"><strong>VAT 7% / ภาษีมูลค่าเพิ่ม 7%</strong></td>
      <td width="140" align="right" valign="top" scope="col"><strong>'.number($_SESSION['total_vat'],2).'</strong></td>
    </tr>
	
    <tr>
	  <td width="390" ></td>
      <td width="160" align="left" valign="top" scope="col"><strong>GRANDTOTAL / รวมเงินทั้งสิ้น</strong></td>
      <td width="140" align="right" valign="top" scope="col"><strong>'.number($_SESSION['total_amt'],2).'</strong></td>
    </tr>
	   
	
    <tr>
      <td align="center" width="550" valign="top">'.Convert($_SESSION['total_amt']).'</td>
    </tr>
	
	
	
	
  </tbody>
';
$html.='</table>';
		
		
		
		
		
		
		
		
		
		
		
// Print text using writeHTMLCell()
$this->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
$chk1='';
if($_SESSION['payType']=='c'){
	$chk1='checked="checked"';
	$total_netamtCash=$_SESSION['total_netamt'];
	$total_netamtCheque='';
}else{
	$total_netamtCash='';
	$total_netamtCheque=$_SESSION['total_netamt'];
}
$this->Ln(2);	
$this->writeHTMLCell(0, 0, '', '', ' <input type="checkbox" name="box1" value="1"  '.$chk1.' />เงินสด/cash  จำนวน&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;', 0, 1, 0, true, '', true);		
$this->Ln(-5);	
$this->writeHTMLCell(0, 0, '', '', '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;......................................................................................................................................................................................................', 0, 1, 0, true, '', true);		
		
		
		
		
      $html2='<table width="100%" border="1">
  <tbody>


    <tr>
	 
	  <td width="25%" align="center" valign="top"><strong>เช็คธนาคาร / Bank Cheque</strong></td>
      <td width="25%" align="center" valign="top"><strong>เลขที่ / Cheque No.</strong></td>
      <td width="25%" align="center" valign="top"><strong>ลงวันที่ / Date Due</strong></td>
	   <td width="25%" align="center" ><strong>จำนวน / Amount</strong></td>
    </tr>
	
    <tr>
	  
	  <td align="center" valign="top"><strong>'.$_SESSION['branch'].'</strong></td>
      <td align="center" valign="top"><strong>'.$_SESSION['chequeNo'].'</strong></td>
      <td align="center" valign="top"><strong>'.$_SESSION['dueDate'].'</strong></td>
	   <td align="center" valign="top"><strong>'.number($_SESSION['dueTime'],2).'</strong></td>
    </tr>
	
	
  </tbody>
';
        
        
        
        
        
        
$html2.='</table>';  
$this->Ln(2);	
		
$this->writeHTMLCell(0, 0, '', '', $html2, 0, 1, 0, true, '', true);
		
$this->Ln(2);
		
$html3='<table width="100%" border="0">
<tr>
	  <td width="25%" align="center" valign="top"><strong>In payment Account No. / Invoice</strong></td>
      <td width="75%" align="left" valign="top">'.$_SESSION['GinvNo'].'</td>
</tr>
</table>'; 
		
$this->writeHTMLCell(0, 0, '', '', $html3, 0, 1, 0, true, '', true);		
//$this->Cell(0, 15,'In payment Account No. / Invoice    '.$_SESSION['GinvNo'], 0, false, 'L', 0, '', 0, false, 'M', 'M');
		
$this->Ln(12);
$this->Cell(0, 15,'                    ..........................................................                                                    ...........................................................', 0, false, 'L', 0, '', 0, false, 'M', 'M'); 
$this->Ln(6);
$this->Cell(0, 15,'                              Collector / ผู้รับเงิน                                                        Authorized Signature / ผู้มีอำนาจลงนาม   ', 0, false, 'L', 0, '', 0, false, 'M', 'M');   
        
  $this->Ln(8);
$this->Cell(0, 15,'หมายเหตุ   1. ใบเสร็จรับเงินฉบับนี้จะสมบูรณ์ต้องมีลายเซ็นต์ผู้มีอำนาจลงนาม และผู้รับเงินพร้อมตราประทับบริษัทฯ', 0, false, 'L', 0, '', 0, false, 'M', 'M');      
   $this->Ln(6);
$this->Cell(0, 15,'               2. ใบกรณีชำระเงินด้วยเงินด้วยเช็ค  ใบเสร็จรับเงินจะสมบูรณ์ก็ต่อเมื่อบริษัทฯ เก็บเงินตามเช็คได้เรียบร้อย', 0, false, 'L', 0, '', 0, false, 'M', 'M');        
   $this->Ln(6);
$this->Cell(0, 15,'               3. กรุณาตรวจสอบความถูกต้องของเอกสารที่ได้รับและแจ้งให้บริษัทฯ ทราบเพื่อแก้ไขภายใน 7 วัน นับจากวันที่ปรากฎใบใบกำกับภาษี ', 0, false, 'L', 0, '', 0, false, 'M', 'M'); 
		   $this->Ln(6);
$this->Cell(0, 15,'               มิฉะนั้นถือว่าถูกต้องสมบูรณ์แล้ว', 0, false, 'L', 0, '', 0, false, 'M', 'M');        
	
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	}
	
	
}

// create new PDF document
//$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Nicola Asuni');
$pdf->SetTitle('tax_invoice');
$pdf->SetSubject('TCPDF Tutorial');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');
// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
//$pdf->SetMargins(10,20,30,10 );
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, 0);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
	require_once(dirname(__FILE__).'/lang/eng.php');
	$pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// set default font subsetting mode
$pdf->setFontSubsetting(true);

// Set font
// dejavusans is a UTF-8 Unicode font, if you only need to
// print standard ASCII chars, you can use core fonts like
// helvetica or times to reduce file size.
$pdf->SetFont('thsarabun', '', 14, '', true);

// Add a page
// This method has several options, check the source code documentation for more information.
$pdf->SetMargins(8, 50, 5, true);
$pdf->AddPage('P');
$pdf->SetFont('thsarabun', '', 14, '', true);
$pdf->Ln(37);
$html='<table width="100%"  border="0" style="text-align:left;">
<tr>
 
    <td width="80%" align="center"><strong>Description / รายการ</strong></td>
    <td width="20%" align="center"><strong>Amount</strong></td>
		
</tr> ';
$sql = "SELECT
t.comCode,
t.documentID,
t.chargeCode,
c.chargeName as detail,
t.chargesCost,
sum(t.chargesReceive) as chargesReceive,
sum(t.chargesbillReceive) as chargesbillReceive,
i.total_amt,
i.total_vat,
i.tax3,
i.tax1,
i.cus_paid,
i.total_netamt,
ct.amount,
i.remark
FROM  $db->dbname.tax_invoice_items AS t
INNER JOIN  $db->dbname.tax_invoice AS i ON t.comCode = i.comCode AND t.documentID = i.documentID
INNER JOIN $db->dbname.common_charge AS c ON t.comCode = c.comCode AND t.chargeCode = c.chargeCode
INNER JOIN $db->dbname.common_chargestype AS ct ON c.comCode = ct.comCode AND c.typeCode = ct.typeCode
WHERE  t.comCode='$db->comCode' AND t.documentID='$documentID'  AND t.chargesReceive>0
group by t.chargeCode
order by t.chargeCode asc
";
$result_temp=$db->query($sql);
$i = 1;
$sumTotal = 0;
$sum_chargesbillReceive=0;
$sum_chargesReceive=0;
$total_vat=0;
$total_amt=0;
$tax3=0;
$tax1=0;
$cus_paid=0;
$total_netamt=0;

$sumfortax3=0;
$sumfortxt1=0;

while($r=mysqli_fetch_assoc($result_temp)){
$sum_chargesReceive += $r['chargesReceive'];
$sum_chargesbillReceive += $r['chargesbillReceive'];
$total_vat=$r['total_vat'];
$total_amt=$r['total_amt'];
$tax3=$r['tax3'];
$tax1=$r['tax1'];
$cus_paid=$r['cus_paid'];
$total_netamt=$r['total_netamt'];  
$remark=$r['remark'];
 if($r['amount']==3){ $sumfortax3+=$r['chargesReceive']; }   
 if($r['amount']==1){ $sumfortxt1+=$r['chargesReceive'];  }  
    
$chargesbillReceive= $r['chargesbillReceive'];  
if($chargesbillReceive<1){ $chargesbillReceive='';}else{ $chargesbillReceive= number($r['chargesbillReceive'],2);  }   
    
$chargesReceive= $r['chargesReceive'];  
if($chargesReceive<1){ $chargesReceive='';}else{ $chargesReceive= number($r['chargesReceive'],2);  }   
    
    
$html.='
<tr>
  
    <td>'.$r['detail'].'</td>
    <td align="right">'.$chargesReceive.'</td>

	
</tr> ';


$i++;
}
$html.='
</table> ';
// Print text using writeHTMLCell()
$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);


$pdf->SetMargins(8, 50, 5, true);
$pdf->AddPage('P');
$pdf->SetFont('thsarabun', '', 14, '', true);
$pdf->Ln(37);
$html='<table width="100%"  border="0" style="text-align:left;">
<tr>
 
    <td width="80%" align="center"><strong>Description / รายการ</strong></td>
    <td width="20%" align="center"><strong>Amount</strong></td>
		
</tr> ';
$sql = "SELECT
t.comCode,
t.documentID,
t.chargeCode,
c.chargeName as detail,
t.chargesCost,
sum(t.chargesReceive) as chargesReceive,
sum(t.chargesbillReceive) as chargesbillReceive,
i.total_amt,
i.total_vat,
i.tax3,
i.tax1,
i.cus_paid,
i.total_netamt,
ct.amount,
i.remark
FROM  $db->dbname.tax_invoice_items AS t
INNER JOIN  $db->dbname.tax_invoice AS i ON t.comCode = i.comCode AND t.documentID = i.documentID
INNER JOIN $db->dbname.common_charge AS c ON t.comCode = c.comCode AND t.chargeCode = c.chargeCode
INNER JOIN $db->dbname.common_chargestype AS ct ON c.comCode = ct.comCode AND c.typeCode = ct.typeCode
WHERE  t.comCode='$db->comCode' AND t.documentID='$documentID'  AND t.chargesReceive>0
group by t.chargeCode
order by t.chargeCode asc
";
$result_temp=$db->query($sql);
$i = 1;
$sumTotal = 0;
$sum_chargesbillReceive=0;
$sum_chargesReceive=0;
$total_vat=0;
$total_amt=0;
$tax3=0;
$tax1=0;
$cus_paid=0;
$total_netamt=0;

$sumfortax3=0;
$sumfortxt1=0;

while($r=mysqli_fetch_assoc($result_temp)){
$sum_chargesReceive += $r['chargesReceive'];
$sum_chargesbillReceive += $r['chargesbillReceive'];
$total_vat=$r['total_vat'];
$total_amt=$r['total_amt'];
$tax3=$r['tax3'];
$tax1=$r['tax1'];
$cus_paid=$r['cus_paid'];
$total_netamt=$r['total_netamt'];  
$remark=$r['remark'];
 if($r['amount']==3){ $sumfortax3+=$r['chargesReceive']; }   
 if($r['amount']==1){ $sumfortxt1+=$r['chargesReceive'];  }  
    
$chargesbillReceive= $r['chargesbillReceive'];  
if($chargesbillReceive<1){ $chargesbillReceive='';}else{ $chargesbillReceive= number($r['chargesbillReceive'],2);  }   
    
$chargesReceive= $r['chargesReceive'];  
if($chargesReceive<1){ $chargesReceive='';}else{ $chargesReceive= number($r['chargesReceive'],2);  }   
    
    
$html.='
<tr>
  
    <td>'.$r['detail'].'</td>
    <td align="right">'.$chargesReceive.'</td>

	
</tr> ';


$i++;
}
$html.='
</table> ';
// Print text using writeHTMLCell()
$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);



$pdf->SetMargins(8, 50, 5, true);
$pdf->AddPage('P');
$pdf->SetFont('thsarabun', '', 14, '', true);
$pdf->Ln(37);
$html='<table width="100%"  border="0" style="text-align:left;">
<tr>
 
    <td width="80%" align="center"><strong>Description / รายการ</strong></td>
    <td width="20%" align="center"><strong>Amount</strong></td>
		
</tr> ';
$sql = "SELECT
t.comCode,
t.documentID,
t.chargeCode,
c.chargeName as detail,
t.chargesCost,
sum(t.chargesReceive) as chargesReceive,
sum(t.chargesbillReceive) as chargesbillReceive,
i.total_amt,
i.total_vat,
i.tax3,
i.tax1,
i.cus_paid,
i.total_netamt,
ct.amount,
i.remark
FROM  $db->dbname.tax_invoice_items AS t
INNER JOIN  $db->dbname.tax_invoice AS i ON t.comCode = i.comCode AND t.documentID = i.documentID
INNER JOIN $db->dbname.common_charge AS c ON t.comCode = c.comCode AND t.chargeCode = c.chargeCode
INNER JOIN $db->dbname.common_chargestype AS ct ON c.comCode = ct.comCode AND c.typeCode = ct.typeCode
WHERE  t.comCode='$db->comCode' AND t.documentID='$documentID'  AND t.chargesReceive>0
group by t.chargeCode
order by t.chargeCode asc
";
$result_temp=$db->query($sql);
$i = 1;
$sumTotal = 0;
$sum_chargesbillReceive=0;
$sum_chargesReceive=0;
$total_vat=0;
$total_amt=0;
$tax3=0;
$tax1=0;
$cus_paid=0;
$total_netamt=0;

$sumfortax3=0;
$sumfortxt1=0;

while($r=mysqli_fetch_assoc($result_temp)){
$sum_chargesReceive += $r['chargesReceive'];
$sum_chargesbillReceive += $r['chargesbillReceive'];
$total_vat=$r['total_vat'];
$total_amt=$r['total_amt'];
$tax3=$r['tax3'];
$tax1=$r['tax1'];
$cus_paid=$r['cus_paid'];
$total_netamt=$r['total_netamt'];  
$remark=$r['remark'];
 if($r['amount']==3){ $sumfortax3+=$r['chargesReceive']; }   
 if($r['amount']==1){ $sumfortxt1+=$r['chargesReceive'];  }  
    
$chargesbillReceive= $r['chargesbillReceive'];  
if($chargesbillReceive<1){ $chargesbillReceive='';}else{ $chargesbillReceive= number($r['chargesbillReceive'],2);  }   
    
$chargesReceive= $r['chargesReceive'];  
if($chargesReceive<1){ $chargesReceive='';}else{ $chargesReceive= number($r['chargesReceive'],2);  }   
    
    
$html.='
<tr>
  
    <td>'.$r['detail'].'</td>
    <td align="right">'.$chargesReceive.'</td>

	
</tr> ';


$i++;
}
$html.='
</table> ';
$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);


// page4



$pdf->SetMargins(8, 50, 5, true);
$pdf->AddPage('P');
$pdf->SetFont('thsarabun', '', 14, '', true);
$pdf->Ln(37);
$html='<table width="100%"  border="0" style="text-align:left;">
<tr>
 
    <td width="80%" align="center"><strong>Description / รายการ</strong></td>
    <td width="20%" align="center"><strong>Amount</strong></td>
		
</tr> ';
$sql = "SELECT
t.comCode,
t.documentID,
t.chargeCode,
c.chargeName as detail,
t.chargesCost,
sum(t.chargesReceive) as chargesReceive,
sum(t.chargesbillReceive) as chargesbillReceive,
i.total_amt,
i.total_vat,
i.tax3,
i.tax1,
i.cus_paid,
i.total_netamt,
ct.amount,
i.remark
FROM  $db->dbname.tax_invoice_items AS t
INNER JOIN  $db->dbname.tax_invoice AS i ON t.comCode = i.comCode AND t.documentID = i.documentID
INNER JOIN $db->dbname.common_charge AS c ON t.comCode = c.comCode AND t.chargeCode = c.chargeCode
INNER JOIN $db->dbname.common_chargestype AS ct ON c.comCode = ct.comCode AND c.typeCode = ct.typeCode
WHERE  t.comCode='$db->comCode' AND t.documentID='$documentID'  AND t.chargesbillReceive>0
group by t.chargeCode
order by t.chargeCode asc
";
$result_temp=$db->query($sql);
$i = 1;
$sumTotal = 0;
$sum_chargesbillReceive=0;
$sum_chargesReceive=0;
$total_vat=0;
$total_amt=0;
$tax3=0;
$tax1=0;
$cus_paid=0;
$total_netamt=0;

$sumfortax3=0;
$sumfortxt1=0;

while($r=mysqli_fetch_assoc($result_temp)){
$sum_chargesReceive += $r['chargesReceive'];
$sum_chargesbillReceive += $r['chargesbillReceive'];
$total_vat=$r['total_vat'];
$total_amt=$r['total_amt'];
$tax3=$r['tax3'];
$tax1=$r['tax1'];
$cus_paid=$r['cus_paid'];
$total_netamt=$r['total_netamt'];  
$remark=$r['remark'];
 if($r['amount']==3){ $sumfortax3+=$r['chargesReceive']; }   
 if($r['amount']==1){ $sumfortxt1+=$r['chargesReceive'];  }  
    
$chargesbillReceive= $r['chargesbillReceive'];  
if($chargesbillReceive<1){ $chargesbillReceive='';}else{ $chargesbillReceive= number($r['chargesbillReceive'],2);  }   
    
$chargesReceive= $r['chargesReceive'];  
if($chargesReceive<1){ $chargesReceive='';}else{ $chargesReceive= number($r['chargesReceive'],2);  }   
    
    
$html.='
<tr>
  
    <td>'.$r['detail'].'</td>
    <td align="right">'.$chargesbillReceive.'</td>

	
</tr> ';


$i++;
}
$html.='
</table> ';
$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);



ob_end_clean();  
$pdf->Output($documentID.'.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
