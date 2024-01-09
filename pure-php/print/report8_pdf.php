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


$s_year=get('s_year');
$s_month=get('s_month');

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

$rm=$db->fetch("SELECT m.monthID,m.monthName FROM `month` AS m WHERE m.monthID='$s_month'");
$_SESSION['showmonth']=$rm['monthName'].' '.$s_year;
class MYPDF extends TCPDF {
	//Page header
	public function Header() {
		// Logo
		//$image_file = K_PATH_IMAGES.'logo.jpg';

		$this->SetFont('thsarabun', 'B', 20);
		$this->Cell(0, 15,'รายงานภาษีขาย', 0, false, 'C', 0, '', 0, false, 'M', 'M');  
		
        $this->Ln(5);
        $this->SetFont('thsarabun', '', 14);
		$this->Cell(0, 15,'เดือน        '.$_SESSION['showmonth'], 0, false, 'L', 0, '', 0, false, 'M', 'M');  
		$this->Ln(5);

        
	}

    
	// Page footer
	public function Footer() {
/*
       $this->SetY(-82); 
        $this->SetFont('thsarabun', '', 14, '', true);
        $html='<table width="100%" border="0">
  <tbody>
    <tr>
      <th width="300" rowspan="7" align="left" valign="top" scope="col">Remark'.nl2br($_SESSION['remark']).'</th>
      <th width="135" align="right" valign="top" scope="col">รวม/Total</th>
      <th width="105" align="right" valign="top" scope="col"><strong>'.$show_sum_chargesbillReceive.'</strong></th>
      <th width="108" align="right" valign="top" scope="col"><strong>'.number($_SESSION['sum_chargesReceive'],2).'</strong></th>
    </tr>
    <tr>
      <td align="right" valign="top">VAT 7 %</td>
<td align="right" valign="top">&nbsp;</td>
      <td align="right" valign="top">'.number($_SESSION['total_vat'],2).'</td>
    </tr>
    <tr>
      <td align="right" valign="top">GRAND TOTAL</td>
   <td align="right" valign="top">&nbsp;</td>
      <td align="right" valign="top">'.number($_SESSION['total_amt'],2).'</td>
    </tr>
    <tr>

      <td align="right" valign="top">WH TAX 3 % ( จากยอด )</td>
      <td align="right" valign="top">'.number($_SESSION['sumfortax3'],2).'</td>
       <td align="right" valign="top">'.number($_SESSION['tax3'],2).'</td>
    </tr>
    <tr>
  
      <td align="right" valign="top">WH TAX 1 %  ( จากยอด ) </td>
      <td align="right" valign="top">'.number($_SESSION['sumfortxt1'],2).'</td>
       <td align="right" valign="top">'.number($_SESSION['tax1'],2).'</td>
    </tr>
    <tr>
      
      <td align="right" valign="top">ลูกค้าสำรองจ่าย </td>
    
      <td align="right" valign="top"></td>
        <td align="right" valign="top">'.number($_SESSION['cus_paid'],2).'</td>
    </tr>
    <tr>
   
      <td align="right" valign="top">NET PAID</td>
      <td align="right" valign="top"></td>
      <td align="right" valign="top">'.number($_SESSION['total_netamt'],2).'</td>
    </tr>
    <tr>
      <th  align="center" colspan="3" scope="row">( '.$_SESSION['text'].' )</th>
  
      <td>&nbsp;</td>
    </tr>
  </tbody>
';
        
        
        
        
        
        
$html.='</table>';
// Print text using writeHTMLCell()
$this->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
        
  */
	
	}
}

// create new PDF document
//$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Nicola Asuni');
$pdf->SetTitle('Report8');
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
$pdf->SetAutoPageBreak(TRUE,15);

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
$pdf->SetMargins(15, 15, 15, true);
$pdf->AddPage('P');
$pdf->SetFont('thsarabun', '', 14, '', true);

// Print text using writeHTMLCell()
$html='<table width="100%" border="1"  cellpadding="1" >
  
	<thead>
    <tr>
      <td colspan="4" align="left" width="74%" >'.$_SESSION['comname'].'</td>
      <td colspan="2" align="center" width="26%">เลขประจำตัวผู้เสียภาษีอากร</td>
    </tr>
    <tr>
      <td colspan="4" align="left">'.$_SESSION['address'].'</td>
      <td colspan="2" align="center">'.$_SESSION['cpTax'].'</td>
    </tr>
    <tr>
      <td width="7%" rowspan="2" align="center" >ลำดับ</td>
      <td colspan="2" align="center" width="30%">ใบกำกับภาษี</td>
      <td width="33%" rowspan="2" align="center" width="37%">ชื่อผู้ซื้อสินค้า/ผู้รับบริการ</td>
      <td width="5%" rowspan="2" align="center" width="13%">ยอดก่อน<br>ภาษีมูลค่าเพิ่ม</td>
      <td width="6%" rowspan="2" align="center" width="13%">ภาษี<br>มูลค่าเพิ่ม</td>
    </tr>
    <tr>
      <td width="23%" align="center" width="15%">ว/ด/ป</td>
      <td width="26%" align="center" width="15%">เลขที่/เล่มที่</td>
    </tr>
	</thead>    
	  
	<tbody>';  
	
$sql="SELECT
j.documentID,
date_format(j.documentDate,'%d/%m/%Y') as documentDate,
j.documentstatus,
c.custNameTH,
sum(i.chargesReceive) as priceBeforevat,
j.total_vat,
j.tax3,
j.tax1,
j.cus_paid,
j.total_netamt

FROM $db->dbname.tax_invoice AS j
INNER JOIN $db->dbname.common_customer AS c ON j.comCode = c.comCode AND j.cusCode = c.cusCode
INNER JOIN $db->dbname.tax_invoice_items AS i ON j.comCode = i.comCode AND j.documentID = i.documentID
WHERE year(j.documentDate)='$s_year' AND month(j.documentDate)='$s_month' 
group by j.documentID

order by j.documentDate,j.documentID 
 ";
$result=$db->query($sql);
$i=1;
$total_amt=0;
$total_vat=0;
$tax3=0;
$tax1=0;
 $cus_paid=0;
$total_netamt=0;
                                           
                  
                  
while($r=mysqli_fetch_array($result)){
    
    $total_amt+=$r['priceBeforevat'];
    $total_vat+=$r['total_vat'];
$html.='<tr>
      <td width="7%" align="center">'.$i.'</td>
      <td width="15%" align="center">'.$r['documentDate'].'</td>
      <td width="15%" align="center">'.$r['documentID'].'</td>
      <td width="37%" align="left">'.$r['custNameTH'].'</td>
      <td width="13%" align="right">'.n2($r['priceBeforevat']).'</td>
      <td width="13%" align="right" >'.n2($r['total_vat']).'</td>
    </tr>';
$i++;
}	
	
$html.='</tbody>
	
	<tfoot>
    <tr>
      <td>&nbsp;</td>
 <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="right"><strong>รวม</strong></td>
      <td align="right"><strong>'.n2($total_amt).'</strong></td>
      <td align="right"><strong>'.n2($total_vat).'</strong></td>
    </tr>
  </tfoot>	
	
	
	
</table>';
$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);


ob_end_clean();  
$pdf->Output('report8.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
