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

$sql_info_com = "SELECT
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
$info1 = $db->fetch($sql_info_com);
$_SESSION['comname'] = $info1['comname'];
$_SESSION['comnameEN'] = $info1['comnameEN'];
$_SESSION['address'] = $info1['address'];
$_SESSION['address_en'] = $info1['address_en'];
$_SESSION['cpTel'] = $info1['cpTel'];
$_SESSION['cpTax'] = $info1['cpTax'];
$_SESSION['cpFax'] = $info1['cpFax'];
$_SESSION['logo'] = $info1['logo'];

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


$sql = "SELECT
	j.comCode, 
	j.documentID, 
    date_format(j.documentDate,'%d/%m/%Y') as documentDate,
	j.bound, 
	j.freight, 

    pl.portNameEN AS port_of_landing,
    pd.portNameEN AS port_of_discharge,
	j.mbl, 
	j.hbl, 
	j.co, 
	j.paperless, 
	j.bill_of_landing, 
	j.import_entry, 
	DATE_FORMAT(j.etdDate,'%d/%m/%Y') AS etdDate, 
	DATE_FORMAT(j.etaDate,'%d/%m/%Y') AS etaDate, 
   
	DATE_FORMAT(j.closingDate,'%d/%m/%Y') AS closingDate, 
	TIME_FORMAT(j.closingTime,'%H:%I') as  closingTime, 



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
	 
 	DATE_FORMAT(j.stu_date,'%d/%m/%Y') AS stu_date,

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
c.contactMobile,
c.fax,

    pr.pName as place_receive,
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
	ag.supNameEN AS agent, 
	fe.fName AS feeder, 
	sa.empName as salaManName,
    p14.pName as fob
FROM joborder AS j
	INNER JOIN common_saleman AS s ON  j.comCode = s.comCode AND j.saleman = s.usercode
	INNER JOIN common_customer AS c ON  j.comCode = c.comCode AND j.cusCode = c.cusCode
	LEFT JOIN common_supplier AS ag ON  j.comCode = ag.comCode AND j.agentCode = ag.supCode
	LEFT JOIN common_feeder AS fe ON  j.comCode = fe.comCode AND j.feeder = fe.fCode
    LEFT JOIN common_feeder AS vs ON  j.comCode = vs.comCode AND j.vessel = vs.fCode
    
    
	INNER JOIN common_saleman AS sa ON  j.comCode = sa.comCode AND j.saleman = sa.usercode
    LEFT JOIN common_place AS p14 ON j.comCode = p14.comCode AND j.fob = p14.pCode
    LEFT JOIN common_place AS pr ON j.comCode = pr.comCode AND j.place_receive = pr.pCode
    LEFT JOIN common_port AS pl ON j.comCode = pl.comCode AND j.port_of_landing = pl.portCode
    LEFT JOIN common_port AS pd ON j.comCode = pd.comCode AND j.port_of_discharge = pd.portCode
    
    
    
WHERE j.comCode='$db->comCode' AND j.documentID='$documentID'  ";
        $r=$db->fetch($sql);

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
    $this->Cell(0, 15, $_SESSION['comnameEN'], 0, false, 'L', 0, '', 0, false, 'M', 'M');
    $this->SetFont('thsarabun', '', 14);
    $this->Ln(5);
    $this->Cell(0, 15, $_SESSION['address_en'], 0, false, 'L', 0, '', 0, false, 'M', 'M');
    $this->Ln(5);
    $this->SetFont('thsarabun', 'B', 16);
    $this->Cell(0, 15, $_SESSION['comname'], 0, false, 'L', 0, '', 0, false, 'M', 'M');
    $this->SetFont('thsarabun', '', 14);
    $this->Ln(5);
    $this->Cell(0, 15, $_SESSION['address'], 0, false, 'L', 0, '', 0, false, 'M', 'M');


    $this->SetFont('thsarabun', 'B', 14);
    $this->Ln(5);
    $this->Cell(0, 15, 'หมายเลขประจำตัวผู้เสียภาษี   ', 0, false, 'L', 0, '', 0, false, 'M', 'M');
    $this->SetX(60);
    $this->SetFont('thsarabun', '', 14);
    $this->Cell(0, 15, $_SESSION['cpTax'], 0, false, 'L', 0, '', 0, false, 'M', 'M');
    $this->Ln(5);
    $this->SetFont('thsarabun', 'B', 14);

    $this->Cell(0, 15, 'Tel.                                  Fax.', 0, false, 'L', 0, '', 0, false, 'M', 'M');
    $this->SetX(25);
    $this->SetFont('thsarabun', '', 14);
    $this->Cell(0, 15, $_SESSION['cpTel'] . '         ' . $_SESSION['cpFax'], 0, false, 'L', 0, '', 0, false, 'M', 'M');



    $this->Ln(2);
      
        $this->Cell(0, 15,'___________________________________________________________________________________________________', 0, false, 'C', 0, '', 0, false, 'M', 'M');  
		// Set font
        
       // $style = array('width' => 0.5, 'cap' => 'butt', 'join' => 'miter', 'dash' => '10,20,5,10', 'phase' => 10, 'color' => array(255, 0, 0));
        //$this->Rect(75, 28, 60, 12, 'DF', $style, array(	70,130,180));
       
		$this->Ln(6);
       // $this->SetTextColor(0, 139, 139);
		$this->SetFont('thsarabun', 'B', 18);
		$this->Cell(0, 15,'BOOKING CONFIRMATION', 0, false, 'C', 0, '', 0, false, 'M', 'M');  
		$this->Ln(5);
    
		//$this->Cell(0, 15,'ใบแจ้งชื่อเรือ', 0, false, 'C', 0, '', 0, false, 'M', 'M');  
        //$this->Ln(5);
        
          
        
        
        
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
$pdf->SetTitle('BOOKING CONFIRMATION');
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
$pdf->SetMargins(15, 35, 10, true);
$pdf->AddPage('P');
$pdf->SetFont('thsarabun', '', 14, '', true);
$pdf->Ln(15);

 $pdf->SetFont('thsarabun', '', 14, '', true);
      $html='<table width="100%" border="0" style="text-align:left;">
    <tr>
      <td width="75%" ><strong>REF : </strong>'.$r['documentID'].'</td>
      <td width="25%"><strong>Date : </strong>'.$r['documentDate'].'</td>
    </tr>
    
    <tr>
      <td width="50%"><strong>TO : </strong>'.$r['custNameEN'].'</td>
      <td width="25%"><strong>TEL : </strong>'.$r['contactMobile'].'</td>
      <td width="25%"></td>
    </tr>
    
     <tr>
      <td width="50%"  colspan="2" scope="col"><strong>ATTN : </strong>'.$r['cusContact'].'</td>
      <td width="25%"><strong>FAX : </strong>'.$r['fax'].'</td>
      <td width="25%"></td>
    </tr>
     
    
      <tr>
      <td width="100%"  colspan="2" scope="col"><br><br><strong><u>COMMODITY INFORMATION (DIRECT-FCL)</u></strong></td>
    </tr>   
    
      <tr>
      <td width="50%"  colspan="2" scope="col"><strong>Commodity : </strong>'.$r['good_commodity'].'</td>
      <td width="50%"  colspan="2" scope="col"><strong>Volum : </strong>'.$showCBM.'</td>
    </tr> 
    
    <tr>
      <td width="100%"  colspan="2" scope="col"><br><br><strong><u>VESSEL INFORMATION </u></strong></td>
    </tr>
    
    <tr>
      <td width="100%"  colspan="2" scope="col"><strong>BOOKING NO.</strong> '.$r['bookingNo'].'</td>
    </tr>    
    
      <tr>
      <td width="100%"  colspan="2" scope="col"><strong>Carrier : </strong> '.$r['agent'].'</td>
    </tr>    

      
      <tr>
       <td width="50%"  colspan="2" scope="col"><strong>Feeder :</strong> '.$r['feeder'].'  '.$r['feederVOY'].'</td>
       <td width="50%"  colspan="2" scope="col"><strong>Vessel :</strong> '.$r['vessel'].'  '.$r['vesselVOY'].'</td>
    </tr>    
       <tr>
       <td width="50%"  colspan="2" scope="col"><strong>FOB AT :</strong> '.$r['fob'].'</td>
       <td width="50%"  colspan="2" scope="col"><strong>Paperless Code :</strong> '.$r['paperless'].'</td>
    </tr>  
    
    <tr>
       <td width="100%"  colspan="2" scope="col"><strong>Place of Receive :</strong> '.$r['place_receive'].'</td>
    </tr> 
    
    <tr>
    <td width="50%"  colspan="2" scope="col"><strong>Port of Loading :</strong> '.$r['port_of_landing'].'</td>
    <td width="50%"  colspan="2" scope="col"><strong>ETD :</strong> '.$r['etdDate'].'</td>
    </tr>     
 
     <tr>
     <td width="50%"  colspan="2" scope="col"><strong>Final Destination :</strong> '.$r['port_of_discharge'].'</td>
    <td width="50%"  colspan="2" scope="col"><strong>ETA :</strong> '.$r['etaDate']. '</td>
    </tr>    
   
     <tr>
      <td width="100%"  colspan="2" scope="col"><br><br><strong><u>STUFFING INFORMATION </u></strong></td>
    </tr>  


    <tr>
      <td width="50%"  colspan="2" scope="col"><strong>Stuffing AT : </strong> '.$r['stu_location']. '</td>
      <td width="50%"  colspan="2" scope="col"><strong>Stuffing DATE : </strong> '.$r['stu_date']. '</td>
    </tr> 
	
	
        <tr>
      <td width="50%"  colspan="2" scope="col"><strong>CONTACT : </strong>' . $r['stu_contact'] . '</td>
    <td width="50%"  colspan="2" scope="col"><strong>TEL : </strong>' . $r['stu_mobile'] . '</td>
    </tr>
	
	
	
     <tr>
      <td width="100%"  colspan="2" scope="col"><br><br><strong><u>CYAND RTN INFORMATION</u></strong></td>
    </tr>  

    <tr>
      <td width="50%"  colspan="2" scope="col"><strong>CY AT : </strong> ' . $r['cy_location'] . '</td>
      <td width="50%"  colspan="2" scope="col"><strong>DATE : </strong> ' . $r['cy_date'] . '</td>
    </tr> 
     <tr>
      <td width="50%"  colspan="2" scope="col"><strong>CONTACT : </strong>' . $r['cy_contact'] . '</td>
    <td width="50%"  colspan="2" scope="col"><strong>TEL : </strong>' . $r['cy_mobile'] . '</td>
    </tr>  
   
 
    
        <tr>
      <td width="50%"  colspan="2" scope="col"><strong>RTN AT : </strong> ' . $r['rtn_location'] . '</td>
      <td width="50%"  colspan="2" scope="col"><strong>DATE : </strong> ' . $r['rtn_date'] . '</td>
    </tr> 

     <tr>
      <td width="50%"  colspan="2" scope="col"><strong>CONTACT : </strong>' . $r['rtn_contact'] . '</td>
      <td width="50%"  colspan="2" scope="col"><strong>TEL : </strong>' . $r['rtn_mobile'] . '</td>
    </tr>  
     <tr>
      <td width="100%"  colspan="2" scope="col"><strong>CLOSTING TIME : </strong>'.$r['closingDate'].' '. $r['closingTime'] . '</td>
    </tr>
   <tr>
      <td width="100%"  colspan="2" scope="col"><strong>REMARK : </strong> ' . $r['note'] . '</td>
    </tr>
</table>';

$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true); 
ob_end_clean(); 
$pdf->Output('booking_confirm.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
