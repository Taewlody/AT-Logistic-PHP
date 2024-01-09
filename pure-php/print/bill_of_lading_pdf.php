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
cp.taxID as cpTax,
cp.address,
cp.address_en,
cp.telephone as cpTel,
cp.fax,
cp.logo
FROM company AS cp ";
$info1=$db->fetch($sql_info_com);	
$_SESSION['comname']= $info1['comname'];
$_SESSION['address']= $info1['address'];
$_SESSION['address_en']= $info1['address_en'];
$_SESSION['cpTel']= $info1['cpTel'];
$_SESSION['cpTax']= $info1['cpTax'];
$_SESSION['logo']= $info1['logo'];


$sql = "SELECT
b.comCode,
b.documentID,
date_format(b.documentDate,'%d/%m/%Y') AS documentDate,
b.ref_jobID,
b.cusCode,
b.shipperCode,
b.consigneeCode,
b.notify_party,
b.cargo_deliverry,
b.marks_number,
b.freight_detail,
b.prepaid,
b.collerct,
b.documentstatus,
b.createID,
b.createTime,
b.editID,
b.editTime,
cs.businessType,
cs.custNameTH,
cs.custNameEN,
cs.branchCode,
cs.branchTH,
cs.branchEN,
cs.creditDay,
cs.taxID,
cs.salemanID,
cs.addressTH,
cs.addressEN,
cs.zipCode,
cs.countryCode,
cs.tel,
cs.fax,
cs.mobile,
cs.editID,
cs.editTime
FROM
bill_of_lading AS b
INNER JOIN joborder ON b.comCode = joborder.comCode AND b.ref_jobID = joborder.documentID
INNER JOIN common_customer AS cs ON joborder.comCode = cs.comCode AND joborder.cusCode = cs.cusCode
WHERE
b.comCode = 'C01' AND
b.documentID = 'L2201-0001'

";
$info=$db->fetch($sql);

$payType='';
$payTypeOther='';
$branch='';
$chequeNo='';
$dueDate='';

$_SESSION['cus_address']=$info['addressTH'];
$_SESSION['refJobNo']=$info['ref_jobID'];
$_SESSION['custNameEN']=$info['custNameEN'];
$_SESSION['taxID']=$info['taxID'];
$_SESSION['branchCode']=$info['branchCode'];

$_SESSION['documentID']=$info['documentID'];
$_SESSION['documentDate']=$info['documentDate'];
$_SESSION['creditName']='';
$_SESSION['your_RefNo']=$info['documentDate'];
$_SESSION['empName']='';

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
        $this->SetFont('thsarabun', 'B', 18);
        $this->Cell(0, 15,$_SESSION['comname'], 0, false, 'L', 0, '', 0, false, 'M', 'M');  
	    $this->SetFont('thsarabun', '', 15);
        $this->Ln(6);
        $this->Cell(0, 15,$_SESSION['address'], 0, false, 'L', 0, '', 0, false, 'M', 'M');  
        $this->Ln(6);
        $this->Cell(0, 15,'เลขประจำตัวผู้เสียภาษี  '.$_SESSION['cpTax'].' โทรศัพท์  '.$_SESSION['cpTel'], 0, false, 'L', 0, '', 0, false, 'M', 'M');          
       $this->Ln(3);
      
        $this->Cell(0, 15,'___________________________________________________________________________________________________', 0, false, 'C', 0, '', 0, false, 'M', 'M');  
		// Set font
          /*  $style = array('width' => 0.5, 'cap' => 'butt', 'join' => 'miter', 'dash' => '10,20,5,10', 'phase' => 10, 'color' => array(255, 0, 0));
        $this->Rect(75, 28, 60, 12, 'DF', $style, array(	70,130,180));
        */
		$this->Ln(6);
       // $this->SetTextColor(0, 139, 139);
		$this->SetFont('thsarabun', 'B', 18);
		$this->Cell(0, 15,'BILL OF LADING', 0, false, 'C', 0, '', 0, false, 'M', 'M');  
	
        //$this->SetTextColor(0, 0, 0);
        $this->SetFont('thsarabun', '', 15);
		$this->Ln(10);
        

        
$html_header='<table width="100%"  border="0" style="text-align:left;">
<tr>
    <td width="8%" align="center"><strong></strong></td>
    <td width="60%" align="left">'.$_SESSION['custNameEN'].'<br>'.($_SESSION['cus_address']).'<br><strong>เลขประจำตัวผู้เสียภาษี :</strong> '.$_SESSION['taxID'].'<br><strong>สาขาที่ :</strong> '.$_SESSION['branchCode'].' </td>
    <td width="15%" align="right"><strong>Date : <br>Credit Term : <br>Your Ref. No : <br> Sales Contact : </strong></td>
    <td width="20%" align="left"> '.$_SESSION['documentDate'].'<br> '.$_SESSION['creditName'].'<br> '.$_SESSION['your_RefNo'].'<br> '.$_SESSION['empName'].'</td>	
</tr>

</table> ';
        
 $image_form = 'formIV.jpg';
$this->Image($image_form, 14, 45, 185, '', 'JPG', '', '', false, 300, '', false, false, 0, false, false, false);       
        

        
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
	
	}
}

// create new PDF document
//$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Nicola Asuni');
$pdf->SetTitle('BILL OF LADING');
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
$pdf->SetMargins(15, 50, 10, true);
$pdf->AddPage('P');
$pdf->SetFont('thsarabun', '', 14, '', true);
$pdf->Ln(25);
$html1='<table width="100%"  border="0" style="text-align:left;">
<tr>
    <td width="10%" align="right"><strong>Bound : <br> Freight : <br> JOB NO : </strong></td>
    <td width="15%" align="left">'.$info['documentID'].'<br>'.$info['documentID'].'<br>'.$info['ref_jobID'].'</td>
    <td width="21%" align="right"><strong>Commodity : <br> Qty. / Measurement : <br> Origin / Destination : </strong></td>
    <td width="15%" align="left"></td>
    <td width="13%" align="right"><strong>Carrier :  <br> B/L No. : <br> On Board : </strong></td>
    <td width="15%" align="left"></td>
</tr>


</table>';
$pdf->writeHTMLCell(0, 0, '', '', $html1, 0, 1, 0, true, '', true);
/*
$pdf->Ln(2);
$html='<table width="100%"  border="1" style="text-align:left;">
<tr>
    <td width="8%" align="center"><strong>No.</strong></td>
    <td width="60%" align="center"><strong>Particulars</strong></td>
    <td width="15%" align="center"><strong>Your Behalf</strong></td>
    <td width="15%" align="center"><strong>Amount<br>(Baht)</strong></td>
		
</tr> ';
$sql = "SELECT
t.comCode,
t.documentID,
t.chargeCode,
t.detail,
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
FROM  $db->dbname.invoice_items AS t
INNER JOIN  $db->dbname.invoice AS i ON t.comCode = i.comCode AND t.documentID = i.documentID
INNER JOIN $db->dbname.common_charge AS c ON t.comCode = c.comCode AND t.chargeCode = c.chargeCode
INNER JOIN $db->dbname.common_chargestype AS ct ON c.comCode = ct.comCode AND c.typeCode = ct.typeCode
WHERE  t.comCode='$db->comCode' AND t.documentID='$documentID'  
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
$remark='';
 if($r['amount']==3){ $sumfortax3+=$r['chargesReceive']; }   
 if($r['amount']==1){ $sumfortxt1+=$r['chargesReceive'];  }  
    
    
$html.='
<tr>
    <td  align="center">'.$i.'</td>
    <td>'.$r['detail'].'</td>
    <td align="right">'.$r['chargesbillReceive'].'</td>
    <td  align="right">'.number($r['chargesReceive'],2).'</td>	
	
</tr> ';


$i++;
}
$html.='
<tr>
	<td align="right" colspan="2" rowspan="2"><strong>รวม/Total<br>VAT 7 %<br>GRAND TOTAL<br>WH TAX 3 % ( จากยอด )<br>WH TAX 1 %  ( จากยอด ) <br> ลูกค้าสำรองจ่าย <br>NET PAID</strong></td>
    <td  align="right"><strong>'.number($sum_chargesbillReceive,2).'</strong></td>	
    <td  align="right"><strong>'.number($sum_chargesReceive,2).'</strong></td>		
</tr> 

<tr>
	<td align="right"><br><br><br>'.number($sumfortax3,2).'<br>'.number($sumfortxt1,2).'</td>
    <td  align="right">'.number($total_vat,2).'<br>'.number($total_amt,2).'<br>'.number($tax3,2).'<br>'.number($tax1,2).'<br>'.number($cus_paid,2).'<br>'.number($total_netamt,2).'</td>	
   	
</tr> ';
$html.='</table><br>Remark : '.$remark;

// Print text using writeHTMLCell()
$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
*/

/*

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
*/
//$pdf->writeHTMLCell(0, 0, '', '', $html_footer, 0, 1, 0, true, '', true);
/*
$pdf->Ln(6);
$pdf->Cell(0, 15,'..........................................................               ..........................................................                  ..........................................................        .', 0, false, 'L', 0, '', 0, false, 'M', 'M'); 
$pdf->Ln(6);
$pdf->Cell(0, 15,'        Authorized Signature                      Customer Authorized Signatured                                Due Date ', 0, false, 'L', 0, '', 0, false, 'M', 'M'); 

*/

//ob_end_clean();  
$pdf->Output($documentID.'.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
