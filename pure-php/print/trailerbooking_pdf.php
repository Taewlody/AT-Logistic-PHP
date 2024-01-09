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
    date_format(j.documentDate,'%d/%m/%Y') as documentDate,
	j.bound, 
	j.freight, 
	j.port_of_landing, 
	j.port_of_discharge, 
	j.mbl, 
	j.hbl, 
	j.co, 
	j.paperless, 
	j.bill_of_landing, 
	j.import_entry, 
	DATE_FORMAT(j.etdDate,'%d/%m/%Y') AS etdDate, 
	DATE_FORMAT(j.etaDate,'%d/%m/%Y') AS etaDate, 
	j.closingDate, 
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
	j.vessel, 
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
  c.addressEN as cusAddress,
  c.zipCode as cusZipCode,
  c.tel as cusTel,
  c.fax as cusFax,
	ag.supNameTH AS agent, 
	fe.fName AS feeder, 
	tl.companyContact,
	sa.empName as salaManName,
  p14.pName as fob,
  pk.packaed_totalCBM,
  pr.portNameEN as port_of_landingName,
  prd.portNameEN as port_of_dischargeName,
	tg.supNameTH AS tocompany ,
	c.branchTH,
  c.branchEN,
  c.taxID as custaxID
  FROM joborder AS j
  INNER JOIN trailer_booking as tl on tl.comCode=j.comCode AND tl.ref_jobID=j.documentID
	INNER JOIN common_saleman AS s ON  j.comCode = s.comCode AND j.saleman = s.usercode
	INNER JOIN common_customer AS c ON  j.comCode = c.comCode AND j.cusCode = c.cusCode
	LEFT JOIN common_supplier AS ag ON  j.comCode = ag.comCode AND j.agentCode = ag.supCode
	LEFT JOIN common_feeder AS fe ON  j.comCode = fe.comCode AND j.feeder = fe.fCode
	INNER JOIN common_saleman AS sa ON  j.comCode = sa.comCode AND j.saleman = sa.usercode
  LEFT JOIN common_place AS p14 ON j.comCode = p14.comCode AND j.fob = p14.pCode
  LEFT JOIN joborder_packed AS pk ON j.comCode = pk.comCode AND j.documentID = pk.documentID   
  LEFT JOIN common_port AS pr ON j.comCode = pr.comCode AND j.port_of_landing = pr.portCode 
  LEFT JOIN common_port AS prd ON j.comCode = prd.comCode AND j.port_of_discharge = prd.portCode   
  LEFT JOIN common_supplier AS tg ON  tl.comCode = tg.comCode AND tl.tocompany = tg.supCode
    
WHERE j.comCode='$db->comCode' AND tl.ref_jobID='$documentID'  ";
echo "".$sql;
        $r=$db->fetch($sql);

$sqlContrainner= " SELECT 
GROUP_CONCAT(t.qty) as ct ,t.tyeName
from(
SELECT
concat(count(s.containersizeName),'x',(s.containersizeName))as qty ,c.containertypeName as tyeName
FROM
joborder_container AS j
INNER JOIN common_containertype AS c ON j.comCode = c.comCode AND j.containerType = c.containertypeCode
INNER JOIN common_containersize AS s ON j.comCode = s.comCode AND j.containerSize = s.containersizeCode
WHERE j.documentID='$documentID'
GROUP BY containersizeCode) as t


 ";

$rcon = $db->fetch($sqlContrainner);


class MYPDF extends TCPDF {
	//Page header
	public function Header() {
		// Logo
		//$image_file = K_PATH_IMAGES.'logo.jpg';
       
		//$image_file = './img/logo/'.$_SESSION['logo'];
      /*  $image_file = '../img/logoNew.jpg';
		$this->Image($image_file, 160, 5, 40, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        $this->Ln(5);
        $this->SetX(15);
        $this->SetFont('thsarabun', 'B', 18);
        $this->Cell(0, 15,$_SESSION['comname'], 0, false, 'L', 0, '', 0, false, 'M', 'M');  
	    $this->SetFont('thsarabun', '', 15);
        $this->Ln(6);
        $this->Cell(0, 15,$_SESSION['address_en'], 0, false, 'L', 0, '', 0, false, 'M', 'M');  
        $this->Ln(6);
        $this->Cell(0, 15,'Tax'.$_SESSION['cpTax'].' Telephone  '.$_SESSION['cpTel'], 0, false, 'L', 0, '', 0, false, 'M', 'M');          
       $this->Ln(3);
      
        $this->Cell(0, 15,'___________________________________________________________________________________________________', 0, false, 'C', 0, '', 0, false, 'M', 'M');  
        
        
        */
		// Set font
        
       // $style = array('width' => 0.5, 'cap' => 'butt', 'join' => 'miter', 'dash' => '10,20,5,10', 'phase' => 10, 'color' => array(255, 0, 0));
        //$this->Rect(75, 28, 60, 12, 'DF', $style, array(	70,130,180));
       
                  
         $image_form = 'trailerbooking.jpg';
$this->Image($image_form, 14, 5, 185, '', 'JPG', '', '', false, 300, '', false, false, 0, false, false, false);
        
        
        /*
		$this->Ln(13);
       // $this->SetTextColor(0, 139, 139);
		$this->SetFont('thsarabun', 'B', 18);
		$this->Cell(0, 15,'ใบจองหัวลากตู้คอนเทนเนอร์', 0, false, 'C', 0, '', 0, false, 'M', 'M');  
		$this->Ln(5);



     $this->Ln(10);
     $this->SetFont('thsarabun', 'B', 14);
     $this->Cell(0, 15, '  วันที่', 0, false, 'L', 0, '', 0, false, 'M', 'M');
     $this->Ln(5);
    $this->Cell(0, 15, '  ถึงบริษัท                              คุณ', 0, false, 'L', 0, '', 0, false, 'M', 'M');
    $this->Ln(10);


    $this->SetFont('thsarabun', 'B', 35);
    $this->Cell(0, 15, '  AT LOGISTICS AND SERVICES CO., LTD.', 0, false, 'C', 0, '', 0, false, 'M', 'M');
    $this->Ln(8);
    $this->SetFont('thsarabun', 'B', 18);
    $this->Cell(0, 15, '29/59 Soi Chan 43 Intersection 26-1-1, Bang Khlo , Bang Kho Laem District, Bangkok 10120', 0, false, 'C', 0, '', 0, false, 'M', 'M');
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
$pdf->SetTitle('trailerbooking');
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
$pdf->SetMargins(16, 5, 10, true);
$pdf->AddPage('P');



$pdf->Ln(13);
// $this->SetTextColor(0, 139, 139);
$pdf->SetFont('thsarabun', 'B', 18);
$pdf->Cell(0, 15, 'ใบจองหัวลากตู้คอนเทนเนอร์', 0, false, 'C', 0, '', 0, false, 'M', 'M');
$pdf->Ln(15);
$html = '<table width="100%" border="0" style="text-align:left;">
    <tr>
      <td width="75%" ><strong>วันที่ : </strong>' . $r['documentDate'] . '</td>
      <td width="25%"></td>
    </tr>
    
    <tr>
      <td width="50%"><strong>ถึงบริษัท : </strong>' . $r['tocompany'] . '</td>
      <td width="25%"><strong>คุณ : ' . $r['companyContact'] . '</strong></td>
      <td width="25%"></td>
    </tr>

    
    
</table>';
$pdf->SetFont('thsarabun', 'B', 15);
$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

$pdf->Ln(8);

$pdf->SetFont('thsarabun', 'B', 25);
$pdf->Cell(0, 15, $_SESSION['comname'], 0, false, 'C', 0, '', 0, false, 'M', 'M');
$pdf->Ln(8);
$pdf->SetFont('thsarabun', 'B', 18);
$pdf->Cell(0, 15, $_SESSION['address_en'], 0, false, 'C', 0, '', 0, false, 'M', 'M');


$pdf->Ln(7);

 $pdf->SetFont('thsarabun', '', 16, '', true);



      $html='<table width="100%" border="0" style="text-align:left;">
    

     <tr>
      <td width="50%"  colspan="2" scope="col"><strong>กรุณาจัดรถหัวลากไปรับตู้/คืนตู้ ตามรายละเอียด ดังนี้</strong></td>
      <td width="25%"></td>
    </tr>
    
     <tr>
      <td width="50%"  colspan="2" scope="col"><strong>บริษัท :</strong> '.$r['custNameEN']. '</td>
      <td width="50%"><strong>จำนวนตู้ :</strong> '.$r['deliveryType'].'    '. $rcon['ct'].'  '.$rcon['tyeName'].' </td>
    </tr>  
    
        <tr>
      <td width="50%"  colspan="2" scope="col"><strong>รับตู้วันที่ :</strong> '.$r['cy_date'].'</td>
      <td width="50%"><strong>สถานที่รับตู้ :</strong>  '.$r['cy_location'].' </td>
    </tr> 
    
        <tr>
      <td width="50%"  colspan="2" scope="col"><strong>ติดต่อคุณ :</strong> '.$r['cy_contact'].'</td>
      <td width="50%"><strong>โทรศัพท์ :</strong>  '.$r['cy_mobile'].' </td>
    </tr> 
    
         <tr>
      <td width="50%"  colspan="2" scope="col"><strong>คืนตู้วันที่ :</strong> '.$r['rtn_date'].'</td>
      <td width="50%"><strong>สถานที่คืนตู้ :</strong>  '.$r['rtn_location'].' </td>
    </tr> 
    
        <tr>
      <td width="50%"  colspan="2" scope="col"><strong>ติดต่อคุณ :</strong> '.$r['rtn_contact'].'</td>
      <td width="50%"><strong>โทรศัพท์ :</strong>  '.$r['rtn_mobile']. ' </td>
    </tr>  
    
            <tr>
      <td width="50%"  colspan="2" scope="col"><strong>ตู้บรรจุวันที่ :</strong>' . $r['stu_date'] . '</td>
      <td width="50%"><strong>สถานที่บรรจุ :</strong> ' . $r['stu_location'] . ' </td>
    </tr> 
    
        <tr>
      <td width="50%"  colspan="2" scope="col"><strong>ติดต่อคุณ :</strong> ' . $r['stu_contact'] . ' </td>
      <td width="50%"><strong>โทรศัพท์ :</strong>' . $r['stu_mobile'] . '  </td>
    </tr>  

       <tr>
      <td width="50%"  colspan="2" scope="col"><strong>Closing :</strong>  ' . $r['closingDate'] . '</td>
      <td width="50%"><strong>Time :</strong>  ' . $r['closingTime'] . ' </td>
    </tr>  

    <tr>
      <td width="50%"  colspan="2" scope="col"><strong>บรรจุสินค้าวันที่ :</strong> '. '</td>
      <td width="50%"><strong>สถานที่โหลด :</strong></td>
    </tr>  
    
       <tr>
      <td width="50%"  colspan="2" scope="col"><strong>ติดต่อคุณ :</strong> ' . '</td>
      <td width="50%"><strong>โทร :</strong></td>
    </tr>   
    
           <tr>
      <td width="50%"  colspan="2" scope="col"><strong>ชื่อเรือ :</strong> ' . $r['feeder'] .'&nbsp;&nbsp;'.$r['feederVOY'] . '</td>
      <td width="50%"><strong>ETD :</strong>' . $r['etdDate'] . '</td>
    </tr>   
    
      
           <tr>
      <td width="50%"  colspan="2" scope="col"><strong>Booking No. :</strong> ' . $r['bookingNo']. '</td>
      <td width="50%"><strong>Agent :</strong>' . $r['agent'] . '</td>
    </tr>   
    
           <tr>
      <td width="50%"  colspan="2" scope="col"><strong>Port:</strong> ' . $r['port_of_dischargeName'] . '</td>
      <td width="50%"></td>
    </tr>   

    
           <tr>
      <td width="100%"  colspan="4" scope="col"><strong>Remark:</strong> ' . $r['note'] . '</td>
      <!--<td width="50%"><br><br><br></td>-->
    </tr>   
 
      </tr>   

    <tr>
      <td width="50%"  colspan="2" scope="col"><strong>ผู้สั่งงาน:</strong></td>
      <td width="50%"></td>
    </tr> 
    
    
          <tr>
      <td width="100%"  colspan="2" scope="col">การวางบิลทุกครั้ง กรุณาแนบใบผ่านท่า พร้อมใบแจ้งลากตู้คอนเทนเนอร์ ฉบับนี้ด้วยทุครั้ง</td>
    
    </tr>   


      </tr>   
    <tr>
      <td width="50%"  colspan="2" scope="col"><strong>JOB REF: </strong>' . $r['documentID'] . '</td>
      <td width="50%"><strong>INVOICE CUSTOMER REF : </strong>' . $r['invNo'] . '</td>
    </tr> 



</table>';

$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
$pdf->Ln(7);
$pdf->SetFont('thsarabun', 'B', 16);
$pdf->Cell(0, 15, '*** อย่าลืมรับซีลเอเยนต์ ตอนรับตู้ทุกครั้ง และกรุณารีบวางบิลด้วยค่ะ***', 0, false, 'C', 0, '', 0, false, 'M', 'M');
$pdf->Ln(10);
$pdf->Cell(0, 15, 'ใบเสร็จค่าผ่านท่า คืนตู้ กรุณาออกตามที่อยู่ด้านล่างนี้', 0, false, 'C', 0, '', 0, false, 'M', 'M');
$pdf->SetFont('thsarabun', '', 14);
$pdf->Ln(7);
$pdf->Cell(0, 15,$r['custNameEN'].'  '.$r['branchEN'].' taxID : '.$r['custaxID'], 0, false, 'C', 0, '', 0, false, 'M', 'M');
$pdf->Ln(7);
$pdf->Cell(0, 15,'Address : '.$r['cusAddress'].' '.$r['cusZipCode'], 0, false, 'C', 0, '', 0, false, 'M', 'M');
$pdf->Ln(7);
$pdf->SetFont('thsarabun', 'B', 16);
$pdf->Cell(0, 15, 'ถ้าใบเสร็จรับตู้-คืนตู้เกินหนี่งพันบาท รบกวนทำภาษีหัก ณ ที่จ่ายด้วย', 0, false, 'C', 0, '', 0, false, 'M', 'M');

ob_end_clean();  
$pdf->Output('trailerbooking.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
