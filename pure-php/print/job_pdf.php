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
cp.comnameEN,
cp.taxID as cpTax,
cp.address,
cp.address_en,
cp.telephone as cpTel,
cp.fax,
cp.logo
FROM company AS cp ";
$info1=$db->fetch($sql_info_com);	
$_SESSION['comname']= $info1['comnameEN'];
$_SESSION['address']= $info1['address'];
$_SESSION['address_en']= $info1['address_en'];
$_SESSION['cpTel']= $info1['cpTel'];
$_SESSION['cpTax']= $info1['cpTax'];
$_SESSION['logo']= $info1['logo'];


 $sql = "SELECT
	j.comCode, 
	j.documentID, 
	j.documentDate, 

	if(j.bound='1','IN BOUND','OUT BOUND') as bound,
	j.freight, 
	j.port_of_landing, 
	pd.portNameEN as port_of_discharge, 
	j.mbl, 
	j.hbl, 
	j.co, 
	j.paperless, 
	j.bill_of_landing, 
	j.import_entry, 
	DATE_FORMAT(j.etdDate,'%d/%m/%Y') AS etdDate, 
	DATE_FORMAT(j.etaDate,'%d/%m/%Y') AS etaDate, 
	j.closingDate, 
	j.closingTime, 
	j.invNo, 
	j.bill, 
	j.bookingNo, 
	j.deliveryType, 
	j.saleman, 
	j.cusCode, 
	j.cusContact, 
	j.agentCode, 
	j.agentContact, 
	    vs.fName AS vessel, 
	j.note, 
	j.stu_location, 
	j.stu_contact, 
	j.stu_mobile, 
	j.stu_date, 
	j.cy_location, 
	j.cy_contact, 
	j.cy_mobile, 
	DATE_FORMAT(j.cy_date,'%d/%m/%Y') AS cy_date, 
	j.rtn_location, 
	j.rtn_contact, 
	j.rtn_mobile, 
	DATE_FORMAT(j.rtn_date,'%d/%m/%Y') AS rtn_date,
	j.good_total_num_package, 
	j.good_commodity, 
	j.billOfladingNo, 
	j.trailer_bookingNO, 
	j.fob, 
	j.place_receive, 
	j.documentstatus, 
	j.createID, 
	j.createTime, 
	j.editID, 
	j.editTime, 
	j.total_amt, 
	j.total_vat, 
	j.tax3, 
	j.tax1, 
	j.cus_paid, 
	j.total_netamt, 
    j.feederVOY,
    j.vesselVOY,
	s.empName AS saleman, 
	c.custNameTH, 
	c.custNameEN, 
	ag.supNameTH AS agent, 
	fe.fName AS feeder, 
	sa.empName as salaManName,
    iv.documentID as invdocumentID
    FROM joborder AS j
	INNER JOIN common_saleman AS s ON j.comCode = s.comCode AND j.saleman = s.usercode
	INNER JOIN common_customer AS c ON  j.comCode = c.comCode AND j.cusCode = c.cusCode
	LEFT JOIN common_supplier AS ag ON  j.comCode = ag.comCode AND j.agentCode = ag.supCode
	LEFT JOIN common_feeder AS fe ON  j.comCode = fe.comCode AND j.feeder = fe.fCode
	INNER JOIN common_saleman AS sa ON  j.comCode = sa.comCode AND j.saleman = sa.usercode
    LEFT JOIN invoice as iv on iv.comCode=j.comCode AND iv.ref_jobNo=j.documentID
    LEFT JOIN common_feeder AS vs ON  j.comCode = vs.comCode AND j.vessel = vs.fCode
	LEFT JOIN common_port as pd on pd.comCode=j.comCode AND pd.portCode=j.port_of_discharge
WHERE j.comCode='$db->comCode' AND j.documentID='$documentID'  ";
$r=$db->fetch($sql);

$_SESSION['bound']=$r['bound'];
$_SESSION['port_of_discharge']=$r['port_of_discharge'];


$sqlContrainner= " SELECT 
GROUP_CONCAT(t.qty) as ct
from(
SELECT
concat(count(s.containersizeName),'x',(s.containersizeName))as qty
FROM
joborder_container AS j
INNER JOIN common_containertype AS c ON j.comCode = c.comCode AND j.containerType = c.containertypeCode
INNER JOIN common_containersize AS s ON j.comCode = s.comCode AND j.containerSize = s.containersizeCode
WHERE j.documentID='$documentID'
GROUP BY containersizeCode) as t ";
$rcon = $db->fetch($sqlContrainner);
$sqlpacked= " 
SELECT
concat(round(sum(j.packaed_totalCBM),2),' CBM') as qtyCBM
FROM
joborder_packed AS j
WHERE j.documentID='$documentID' ";
$rpacked = $db->fetch($sqlpacked);

if($rcon['ct']!=""){
    $showCBM=$rcon['ct'];
}else{
    
    $showCBM=$rpacked['qtyCBM'];
}


/*
$_SESSION['documentID']=$info['documentID'];
$_SESSION['hbl']=$info['hbl'];
$_SESSION['invNo']=$info['invNo'];
$_SESSION['saleman']=$info['saleman'];
$_SESSION['bill']=$info['bill'];
$_SESSION['custNameTH']=$info['custNameTH'];
$_SESSION['custNameEN']=$info['custNameEN'];
$_SESSION['co']=$info['co'];
$_SESSION['cusContact']=$info['cusContact'];
$_SESSION['agent']=$info['agent'];
$_SESSION['agentContact']=$info['agentContact'];
$_SESSION['feeder']=$info['feeder'];
$_SESSION['vessel']=$info['vessel'];
*/

/*
$_SESSION['refJobNo']=$info['refJobNo'];
$_SESSION['supNameTH']=$info['supNameTH'];
$_SESSION['documentID']=$info['documentID'];
$_SESSION['documentDate']=$info['documentDate'];
$_SESSION['accountNicname']=$info['accountNicname'];
*/
class MYPDF extends TCPDF {
	//Page header
	public function Header() {
		// Logo
		//$image_file = K_PATH_IMAGES.'logo.jpg';
       
		//$image_file = './img/logo/'.$_SESSION['logo'];
        $image_file = '../img/logoNew.jpg';
		$this->Image($image_file, 160, 5, 40, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        $this->Ln(5);
        $this->SetX(15);
        $this->SetFont('thsarabun', 'B', 16);
        $this->Cell(0, 15,$_SESSION['comname'], 0, false, 'L', 0, '', 0, false, 'M', 'M');  
	    $this->SetFont('thsarabun', '', 15);
        $this->Ln(6);
        $this->Cell(0, 15,$_SESSION['address_en'], 0, false, 'L', 0, '', 0, false, 'M', 'M');  
        $this->Ln(6);
        $this->Cell(0, 15,'Tax ID '.$_SESSION['cpTax'].'   Telephone  '.$_SESSION['cpTel'], 0, false, 'L', 0, '', 0, false, 'M', 'M');          
       $this->Ln(3);
      
        $this->Cell(0, 15,'___________________________________________________________________________________________________', 0, false, 'C', 0, '', 0, false, 'M', 'M');  
		// Set font
        
       // $style = array('width' => 0.5, 'cap' => 'butt', 'join' => 'miter', 'dash' => '10,20,5,10', 'phase' => 10, 'color' => array(255, 0, 0));
        //$this->Rect(75, 28, 60, 12, 'DF', $style, array(	70,130,180));
       
		$this->Ln(6);
        
		$this->SetFont('thsarabun', 'B', 16);
		$this->SetX(90);
		$this->Cell(0, 15,'ใบสั่งงาน', 0, false, 'L', 0, '', 0, false, 'M', 'M');  
		$this->Ln(5);
				$this->SetX(90);
		$this->Cell(0, 15,'Joborder', 0, false, 'L', 0, '', 0, false, 'M', 'M');  $this->SetTextColor(	0,0,255);
		$this->SetX(16);
   		$this->Cell(0, 15,'Bound : '.$_SESSION['bound'], 0, false, 'L', 0, '', 0, false, 'M', 'M'); 

		$this->SetX(140);
		$this->Cell(0, 15,'Port of Discharge : '.$_SESSION['port_of_discharge'], 0, false, 'R', 0, '', 0, false, 'M', 'M');
		
		
        $this->Ln(5);
		
		
		
        
        /*    <tr>
      <td width="10%" ><strong>Bound</strong></td>
      <td width="25%">:  '.$r['bound'].'</td>
      <td width="20%" align="right"><strong>Port of Discharge</strong></td>
      <td width="15%">:  '.$r['port_of_discharge'].'</td>
      <td width="15%"align="right" ></td>
      <td width="15%"></td>
    </tr>
		  */
        
        
        
        /*
        
        
        
        
        
        
        $this->SetTextColor(0, 0, 0);
        $this->SetFont('thsarabun', 'B', 15);
		$this->Ln(10);
		$this->Cell(0, 15,'จ่ายให้/Paid To', 0, false, 'L', 0, '', 0, false, 'M', 'M');
        $this->SetX(50);
        $this->SetFont('thsarabun', '', 15);
        $this->Cell(0, 15,$_SESSION['supNameTH'], 0, false, 'L', 0, '', 0, false, 'M', 'M');
        
       
        $this->SetX(145);
        $this->SetFont('thsarabun', 'B', 15);
        $this->Cell(0, 15,'เลขที่เอกสาร/No', 0, false, 'L', 0, '', 0, false, 'M', 'M');
        
        $this->SetX(175);
        $this->SetFont('thsarabun', '', 15);
        $this->Cell(0, 15,$_SESSION['documentID'], 0, false, 'L', 0, '', 0, false, 'M', 'M');      
        
        
        
 
        $this->Ln(6);
        $this->SetFont('thsarabun', 'B', 15);
		$this->Cell(0, 15,'เพื่อชำระ/Paid For', 0, false, 'L', 0, '', 0, false, 'M', 'M');
        $this->SetX(50);
        $this->SetFont('thsarabun', '', 15);
        $this->Cell(0, 15,$_SESSION['refJobNo'].', INV NO.123456', 0, false, 'L', 0, '', 0, false, 'M', 'M');
        
        
        $this->SetX(145);
        $this->SetFont('thsarabun', 'B', 15);
        $this->Cell(0, 15,'วันที่/Date', 0, false, 'L', 0, '', 0, false, 'M', 'M');
          $this->SetX(175);
        $this->SetFont('thsarabun', '', 15);
        $this->Cell(0, 15,$_SESSION['documentDate'], 0, false, 'L', 0, '', 0, false, 'M', 'M');  
        
        
        
        
        $this->Ln(6);
        $this->SetX(50);
        $this->Cell(0, 15,'แอดคอร์ด ไพลอด โลจิสติคส์(ประเทศไทย) จำกัด', 0, false, 'L', 0, '', 0, false, 'M', 'M');
             
        
 */

        
            
        
        
	}

	// Page footer
	public function Footer() {
	
	}
}

// create new PDF document
//$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Nicola Asuni');
$pdf->SetTitle('Job Order');
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
$pdf->SetAutoPageBreak(TRUE, 34);

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
$pdf->SetMargins(15, 40, 10, true);
$pdf->AddPage('P');
$pdf->SetFont('thsarabun', '', 14, '', true);


 $pdf->SetFont('thsarabun', '', 14, '', true);
      $html='<table width="100%"  border="0" style="text-align:left;">
           <tbody>

      <td width="10%" ><strong>Saleman</strong></td>
      <td width="25%">:  '.$r['saleman'].'</td>
      <td width="20%" align="right"><strong>เลขที่ IV ที่ลูกค้าวาง</strong></td>
      <td width="15%">:  '.$r['invdocumentID'].'</td>
      <td width="15%"align="right" ><strong>Job No.</strong></td>
      <td width="15%">:  '.$r['documentID'].'</td>
    </tr>
    <tr>
      <td><strong>Customer</strong></td>
       <td colspan="3">:  '.$r['custNameTH'].'</td>
   
      <td align="right"><strong>LOAD</strong></td>
      <td></td>
    </tr>
    
    <tr>
      <td><strong>C/O</strong></td>
      <td>:  '.$r['co'].'</td>
      <td colspan="2"><strong>CY/RTN  :  '.$r['cy_date'].' , '.$r['rtn_date'].'</strong></td>
      
      <td align="right"><strong>INV. No.</strong></td>
      <td>: '.$r['invNo'].'</td>
    </tr>
    
    <tr>
      <td><strong>Contact</strong></td>
      <td>:  '.$r['cusContact'].'</td>
      <td><strong>Tel.</strong></td>
      <td>  </td>
      <td align="right"><strong>Fax.</strong></td>
      <td></td>
    </tr>
    
     <tr>
      <td><strong>Agent</strong></td>
      <td colspan="3">:  '.$r['agent'].'</td>
   
      <td align="right"><strong>CTC.</strong></td>
      <td></td>
    </tr>   
    
    <tr>
      <td><strong>Tel.</strong></td>
      <td></td>
      <td><strong>Fax.</strong></td>
      <td></td>
      <td align="right"><strong></strong></td>
      <td></td>
    </tr>
    
    <tr>
      <td><strong>Feeder</strong></td>
     <td colspan="3">:  '.$r['feeder'].' ('.$r['feederVOY'].')</td>
      <td align="right"><strong>ETD</strong></td>
      <td>'.$r['etdDate'].'</td>
    </tr>
    
    <tr>
      <td><strong>Vessel</strong></td>
     <td colspan="3">:  '.$r['vessel'].'    '.$r['vesselVOY'].'</td>
      <td align="right"><strong>ETA</strong></td>
      <td>'.$r['etaDate'].'</td>
    </tr>    
    
    <tr>
      <td><strong>FCL</strong></td>
     <td colspan="3">'.$showCBM.'</td>
      <td align="right"><strong></strong></td>
      <td></td>
    </tr>
    
    
  </tbody>
        </table><br><br>';
        
 $html.='<table width="100%"  border="1" style="text-align:left;">
           <tbody>
    <tr>
      <td width="33%"><strong>ตู้บรรจุ  : </strong>'.$r['stu_location'].'</td>
      <td width="33%"><strong>ลากตู้ที่  : </strong>'.$r['cy_location'].'</td>
      <td width="33%"><strong>คืนตู้ที่  : </strong>'.$r['rtn_location'].'</td>
    </tr>
    <tr>
      <td ><strong>ติดต่อ : </strong>'.$r['stu_contact'].'   <br><strong>โทร : </strong>'.$r['stu_mobile'].' </td>
        <td ><strong>ติดต่อ : </strong>'.$r['cy_contact'].'   <br><strong>โทร : </strong>'.$r['cy_mobile'].' </td>
       <td ><strong>ติดต่อ : </strong>'.$r['rtn_contact'].'   <br><strong>โทร : </strong>'.$r['rtn_mobile'].' </td>
    </tr>
   
  </tbody>
   </table><br><br>';

 $html.='<table width="100%"  border="1" style="text-align:left;">
   <thead>       
    <tr>
      <td width="54%" align="center"><strong>CHARGES</strong></td>
      <td width="15%" align="center"><strong>PAID</strong></td>
      <td width="15%" align="center"><strong>RECEIVE</strong></td>
      <td width="15%" align="center"><strong>BILL OF RECEIPT</strong></td>
    </tr> 
	</thead>
	
	<tbody>';
 

$sql="
SELECT
j.comCode,
j.ref_paymentCode,
j.chargeCode,
j.detail as chartDetail,
sum(j.chargesCost) as chargesCost,
sum(j.chargesReceive) as chargesReceive,
sum(j.chargesbillReceive) as chargesbillReceive
FROM
joborder_charge AS j
WHERE j.comCode='$db->comCode' AND j.documentID='$documentID' 
GROUP BY j.comCode,j.detail
ORDER BY j.chargeCode asc";
$result=$db->query($sql);
$i=1;
$rowIdx=99;
$sum_chargesCost=0;
$sum_chargesReceive=0;
$sum_chargesbillReceive=0;
$total_sum_chargesReceive=0;
while($r2=mysqli_fetch_array($result)){
    $sum_chargesCost+=$r2['chargesCost'];
    $sum_chargesReceive+=$r2['chargesReceive'];
    $sum_chargesbillReceive+=$r2['chargesbillReceive'];
    
   $html.='
   <tr>
      <td  width="54%">'.$r2['chartDetail'].'</td>
       <td align="right" width="15%">'.n2($r2['chargesCost']).'</td>
       <td align="right" width="15%">'.n2($r2['chargesReceive']).'</td>
       <td align="right" width="15%">'.n2($r2['chargesbillReceive']).'</td>
    </tr>';
   
}
$vat_receive=($sum_chargesReceive*7/100);
$total_sum_chargesReceive=$sum_chargesReceive+$vat_receive;
   $html.='
  </tbody> 
   <tfooter>
   <tr>
      <td align="center">Vat 7%</td>
       <td align="right"></td>
       <td align="right">'.n2($vat_receive).'</td>
       <td align="right"></td>
    </tr>
    <tr>
      <td align="center">รวม</td>
       <td align="right">'.n2($sum_chargesCost).'</td>
       <td align="right">'.n2($total_sum_chargesReceive).'</td>
       <td align="right">'.n2($sum_chargesbillReceive).'</td>
    </tr>   
     <tr>
      <td align="center" colspan="2" ></td>
      <td align="right"><strong>
      รวม<br>
      ค่าบริการ 3%<br>ค่าขนส่ง 1%<br>ลูกค้าสำรองจ่าย<br>คงเหลือจ่ายจริง</strong>
        
      </td>
       <td align="right"><strong>'.n2($r['total_amt']).'<br>'.n2($r['tax3']).'<br>'.n2($r['tax1']).'<br>'.n2($r['cus_paid']).'<br>'.n2($r['total_netamt']).'</strong></td>
    </tr>  </tfooter>  
    ';   
   $html.='
   </table><br><br>';
 
 $html.='<table width="100%"  border="0" style="text-align:left;">
   <tbody>
    <tr>
      <td width="50%" align="left"><strong>RECEVING BY : </strong> <br><strong>หมายเหตุ :</strong> '.nl2br($r['note']).'</td>
       <td width="50%" align="left"><strong>SALE BY : </strong> '.$r['salaManName'].' <br><strong>APPROVED BY :</strong></td>
    </tr>
    
    </tbody>
   </table>';





    $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
/*
$html='<table width="100%"  border="1" style="text-align:left;">
<tr>
    <td width="8%" align="center"><strong>ลำดับ<br> No.</strong></td>
    <td width="13%" align="center"><strong>เลขที่บิล<br>Bill No.</strong></td>
    <td width="65%" align="center"><strong>รายการ<br>Particulars</strong></td>
    <td width="13%" align="center"><strong>จำนวนเงิน<br>Amount</strong></td>
		
</tr> ';
$sql = "SELECT
t.comCode,
t.documentID,
t.invNo,
t.chargeCode,
t.chartDetail,
t.amount
FROM  $db->dbname.receipt_voucher_items AS t
WHERE  t.comCode='$db->comCode' AND t.documentID='$documentID'  order by t.chargeCode asc
";
$result_temp=$db->query($sql);
$i = 1;
$sumTotal = 0;


while($r=mysqli_fetch_assoc($result_temp)){
$sumTotal += $r['amount'];
$html.='
<tr>
    <td  align="center">'.$i.'</td>
    <td>'.$r['invNo'].'</td>
    <td align="left">'.$r['chartDetail'].'</td>
    <td  align="right">'.number($r['amount'],2).'</td>	
	
</tr> ';


$i++;
}
$html.='
<tr>

	<td align="center" colspan="3">รวม/Total</td>
    <td  align="right">'.number($sumTotal,2).'</td>		
</tr> ';
$html.='</table>';
// Print text using writeHTMLCell()
$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);



$chk1='';
$chk2='';
$chk3='';
if($payType=='c'){
	$chk1='checked="checked"';
}elseif($payType=='b'){
	$chk2='checked="checked"';
}elseif($payType=='o'){
	$chk3='checked="checked"';
}
$pdf->Ln(5);
$html_footer='<table width="100%"  border="1" style="text-align:left;">
<tr>
    <td width="25%" align="left"><strong> โดย/By </strong><br>
    <input type="checkbox" name="box1" value="1" readonly="true" '.$chk1.' />เงินสด/cash <br>
    <input type="checkbox" name="box1" value="1" readonly="true" '.$chk2.' />เช็คธนาคาร/Bank<br>
    <input type="checkbox" name="box1" value="1" readonly="true" '.$chk3.' />อื่นๆ '.$payTypeOther.'
    </td>
    <td width="25%" align="left"><strong>สาขา/Branch</strong><br>'.$branch.'</td>
    <td width="25%" align="left"><strong>เลขที่เช็ค/Cheque</strong><br>'.$chequeNo.'</td>
    <td width="25%" align="left"><strong>ลงวันที่/DueDate</strong><br>'.$dueDate.'</td>	
   
		
</tr> ';

$pdf->writeHTMLCell(0, 0, '', '', $html_footer, 0, 1, 0, true, '', true);
$pdf->Ln(6);
$pdf->Cell(0, 15,'...................................               ...................................                  ...................................                    ...................................', 0, false, 'L', 0, '', 0, false, 'M', 'M'); 
$pdf->Ln(6);
$pdf->Cell(0, 15,'ผู้รับเงิน/Received By              ผู้จัดทำ/Prepared By                 ผู้อนุมัติ/Authorized By               สมุห์บัญชี/Accountant', 0, false, 'L', 0, '', 0, false, 'M', 'M'); 


*/
    
    
ob_end_clean();  
$pdf->Output('JOB.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
