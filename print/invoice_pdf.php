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
i.comCode,
i.documentID,
date_format(i.documentDate,'%d/%m/%Y') AS documentDate,
c.cusCode,
c.addressTH AS cus_address,
i.carrier,
j.saleman,
i.creditterm,
j.invNo AS your_RefNo,
if(i.bound=1,'IN BOUND','OUT BOUND') AS bound,
j.good_commodity,
i.on_board,
j.freight,
i.qty_measurement,
i.bl_No,
i.ref_jobNo,
i.origin_desc,
i.note,
i.remark,
i.documentstatus,
i.createID,
i.createTime,
i.editID,
i.editTime,
i.total_amt,
i.total_vat,
i.tax3,
i.tax1,
i.cus_paid,
i.total_netamt,
c.custNameTH,
c.custNameEN,
c.taxID,
c.branchCode,
cr.creditName,
s.empName,
f.transportName,
pl.portNameTH as port_of_landing,
pd.portNameTH as port_of_discharge,
j.agentCode,
ag.supNameTH as agent,
j.bill_of_landing,
if(j.bound='1',date_format(j.etaDate,'%d/%m/%Y'),date_format(j.etdDate,'%d/%m/%Y')) as Onboard
FROM
invoice AS i
INNER JOIN common_customer AS c ON i.comCode = c.comCode AND i.cusCode = c.cusCode
INNER JOIN joborder AS j ON i.comCode = j.comCode AND i.ref_jobNo = j.documentID
LEFT JOIN common_creditterm AS cr ON c.comCode = cr.comCode AND c.creditDay = cr.creditCode
LEFT JOIN common_saleman AS s ON j.comCode = s.comCode AND j.saleman = s.usercode
LEFT JOIN common_transporttype AS f ON i.comCode = f.comCode AND j.freight = f.transportCode
LEFT JOIN common_port AS pl ON j.comCode = pl.comCode AND j.port_of_landing = pl.portCode
LEFT JOIN common_port AS pd ON j.comCode = pd.comCode AND j.port_of_discharge = pd.portCode
LEFT JOIN common_supplier AS ag ON j.comCode = ag.comCode AND j.agentCode = ag.supCode
WHERE  i.comCode='$db->comCode' AND i.documentID='$documentID'  ";
$info=$db->fetch($sql);

$payType='';
$payTypeOther='';
$branch='';
$chequeNo='';
$dueDate='';

$_SESSION['cus_address']=$info['cus_address'];
$_SESSION['refJobNo']=$info['ref_jobNo'];
$_SESSION['custNameTH']=$info['custNameTH'];
$_SESSION['custNameEN']=$info['custNameEN'];
$_SESSION['taxID']=$info['taxID'];
$_SESSION['branchCode']=$info['branchCode'];

$_SESSION['documentID']=$info['documentID'];
$_SESSION['documentDate']=$info['documentDate'];
$_SESSION['creditName']=$info['creditName'];
$_SESSION['your_RefNo']=$info['your_RefNo'];
$_SESSION['empName']=$info['empName'];



$sqlContrainner= " SELECT 
GROUP_CONCAT(t.qty) as ct
from(
SELECT
concat(count(s.containersizeName),'x',(s.containersizeName))as qty
FROM
joborder_container AS j
INNER JOIN common_containertype AS c ON j.comCode = c.comCode AND j.containerType = c.containertypeCode
INNER JOIN common_containersize AS s ON j.comCode = s.comCode AND j.containerSize = s.containersizeCode
WHERE j.documentID='$info[ref_jobNo]'
GROUP BY containersizeCode) as t ";
$rcon = $db->fetch($sqlContrainner);

$sqlpacked= " 
SELECT
concat(round(sum(j.packaed_totalCBM),2),' CBM') as qtyCBM
FROM
joborder_packed AS j
WHERE j.documentID='$info[ref_jobNo]' ";
$rpacked = $db->fetch($sqlpacked);

if($rcon['ct']!=""){
    $showCBM=$rcon['ct'];
}else{
    
    $showCBM=$rpacked['qtyCBM'];
}





$sql = "SELECT
t.comCode,
t.documentID,
t.chargeCode,
t.detail,
t.chargesCost,
(t.chargesReceive) as chargesReceive,
(t.chargesbillReceive) as chargesbillReceive,
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
    
}

$_SESSION['sum_chargesbillReceive']=$sum_chargesbillReceive;
$_SESSION['sum_chargesReceive']=$sum_chargesReceive;
$_SESSION['sumfortax3']=$sumfortax3;
$_SESSION['sumfortxt1']=$sumfortxt1;
$_SESSION['total_vat']=$total_vat;
$_SESSION['total_amt']=$total_amt;
$_SESSION['tax3']=$tax3;
$_SESSION['tax1']=$tax1;
$_SESSION['cus_paid']=$cus_paid;
$_SESSION['total_netamt']=$total_netamt;
$_SESSION['remark']=$remark;

$_SESSION['text']=Convert($total_netamt);

$_SESSION['text4']=Convert($sum_chargesbillReceive);


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
        
        $this->Cell(0, 15,'Tel.                                  Fax.', 0, false, 'L', 0, '', 0, false, 'M', 'M'); 
        $this->SetX(25);
         $this->SetFont('thsarabun', '', 14);
          $this->Cell(0, 15,$_SESSION['cpTel'].'         '.$_SESSION['cpFax'], 0, false, 'L', 0, '', 0, false, 'M', 'M'); 
        
		
        $this->SetFont('thsarabun', 'B', 18);
		$numberpage=$this->getPage();
		$this->SetTextColor(255, 51, 51);
        if($numberpage=='1'){
			$this->Cell(0, 15,'ORIGINAL / ต้นฉบับ      ', 0, false, 'R', 0, '', 0, false, 'M', 'M');
		}else if($numberpage=='4'){
		}else{
         	$this->Cell(0, 15,'COPY / สำเนา        ', 0, false, 'R', 0, '', 0, false, 'M', 'M');	   
        }
         $this->SetFont('thsarabun', '', 14);
		
		$this->SetTextColor(0, 0, 0);
		
       $this->Ln(2);
      
        $this->Cell(0, 15,'___________________________________________________________________________________________________________', 0, false, 'C', 0, '', 0, false, 'M', 'M');  
		// Set font
           // $style = array('width' => 0.5, 'cap' => 'butt', 'join' => 'miter', 'dash' => '10,20,5,10', 'phase' => 10, 'color' => array(255, 0, 0));
        //$this->Rect(75, 28, 60, 12, 'DF', $style, array(	70,130,180));
        
		$this->Ln(8);
       // $this->SetTextColor(0, 139, 139);
		$this->SetFont('thsarabun', 'B', 20);
		if($numberpage=='4'){
			  
			$this->Cell(0, 15,'Official Receipt (ใบรับเงิน)', 0, false, 'C', 0, '', 0, false, 'M', 'M');  	
		}else{
			$this->Cell(0, 15,'ใบแจ้งหนี้ / INVOICE', 0, false, 'C', 0, '', 0, false, 'M', 'M');	
		}

	
	
	
        //$this->SetTextColor(0, 0, 0);
        $this->SetFont('thsarabun', '', 14);
		$this->Ln(5);
        
     
$html_header='<table width="100%"  border="0" style="text-align:left;">
<tr>
    <td width="2%" align="left"><strong></strong></td>
    <td width="66%" align="left"><br><strong>TO</strong> : '.$_SESSION['custNameTH'].'<br>'.($_SESSION['cus_address']).'<br><strong>เลขประจำตัวผู้เสียภาษี :</strong> '.$_SESSION['taxID'].'<br><strong>สาขาที่ :</strong> '.$_SESSION['branchCode'].' </td>
    <td width="15%" align="left"><strong> Date <br> Invoice No.   <br> Credit Term  <br> Your Ref. No<br> Sales Contact  </strong></td>
    <td width="20%" align="left">'.$_SESSION['documentDate'].'<br>'.$_SESSION['documentID'].'<br>'.$_SESSION['creditName'].'<br> '.$_SESSION['your_RefNo'].'<br> '.$_SESSION['empName'].'</td>	
</tr>

</table> ';
         if($numberpage=='4'){
 			$image_form = 'formIVp4.jpg';
		 }else{
			$image_form = 'formIV2.jpg';	 
		 }
		
		$this->Image($image_form, 14, 50, 185, '', 'JPG', '', '', false, 300, '', false, false, 0, false, false, false);       
        

        
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
    
        if($_SESSION['sum_chargesbillReceive']<1){
            $show_sum_chargesbillReceive="";
        }else{
            $show_sum_chargesbillReceive=number($_SESSION['sum_chargesbillReceive'],2);
        }
  $numberpage=$this->getPage();	
	if($numberpage=='4'){
		
	   $this->SetY(-45); 
        $this->SetFont('thsarabun', '', 14, '', true);
 $html='<table width="100%" border="0">
    <tr>

		  <td width="82%" align="right">รวม/Total</td>
		  <td width="15%" align="right"><strong>'.$show_sum_chargesbillReceive.'</strong></td>
    </tr>
	 <tr>

		  
		  <td align="center"><strong>( '.$_SESSION['text4'].' )</strong></td>
		  <td align="center"></td>
    </tr>';  
$html.='</table>';		
		
	}else{
		
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
  </tbody>';  
$html.='</table>';
		
		
		
		
	}
// Print text using writeHTMLCell()
	
$this->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);


//$this->Ln(1);
//$this->Cell(0, 15,'( '.$_SESSION['text'].' )', 0, false, 'C', 0, '', 0, false, 'M', 'M');
        $this->Ln(12);
$this->Cell(0, 15,'..........................................................               ..........................................................                  ..........................................................        .', 0, false, 'L', 0, '', 0, false, 'M', 'M'); 
$this->Ln(6);
$this->Cell(0, 15,'        Authorized Signature                      Customer Authorized Signatured                                Due Date ', 0, false, 'L', 0, '', 0, false, 'M', 'M');   
        
  $this->Ln(6);
$this->Cell(0, 15,'Please Issue crssed cheque to order "AT LOGISTICS AND SERVICES CO., LTD." settlement to this invoice.', 0, false, 'C', 0, '', 0, false, 'M', 'M');      
        
        
        
	
	}
}

// create new PDF document
//$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Nicola Asuni');
$pdf->SetTitle('invoice');
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
$pdf->Ln(30);
$html1='<table width="100%"  border="0" style="text-align:left;">
<tr>
    <td width="28%" align="left"><strong>Bound &nbsp;: </strong>'.$info['bound'].'<br><strong>Freight &nbsp;:</strong> '.$info['transportName'].'<br><strong>JOB NO : </strong>'.$info['ref_jobNo'].'</td>
    <td width="45%" align="left"><strong>Commodity :</strong> '.$info['good_commodity'].' <br><strong>Qty. / Measurement :</strong>  '.$showCBM.'<br><strong>Origin / Destination&nbsp;&nbsp;:</strong> '.$info['port_of_landing'].' / '.$info['port_of_discharge'].'</td>
    <td width="40%" align="left"><strong>Carrier&nbsp;&nbsp;&nbsp;&nbsp; : </strong>&nbsp;'.$info['agent'].' <br><strong>B/L No. &nbsp;&nbsp;&nbsp;:</strong> '.$info['bill_of_landing'].' <br><strong>On Board : &nbsp;</strong>'.$info['Onboard'].' </td>

</tr>


</table>';
$pdf->writeHTMLCell(0, 0, '', '', $html1, 0, 1, 0, true, '', true);
$pdf->Ln(2);
$html='<table width="100%"  border="0" style="text-align:left;">
<tr>
    <td width="8%" align="center"><strong>No.</strong></td>
    <td width="60%" align="center"><strong>Particulars</strong></td>
    <td width="15%" align="center"><strong>Your Behalf</strong></td>
    <td width="15%" align="center"><strong>Amount (Baht)<br></strong></td>
		
</tr> ';
$sql = "SELECT
t.comCode,
t.documentID,
t.chargeCode,
t.detail,
t.chargesCost,
(t.chargesReceive) as chargesReceive,
(t.chargesbillReceive) as chargesbillReceive,
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
    <td  align="center">'.$i.'</td>
    <td>'.$r['detail'].'</td>
    <td align="right">'.$chargesbillReceive.'</td>
    <td  align="right">'.$chargesReceive.'</td>	
	
</tr> ';


$i++;
}
$html.='
</table> ';
// Print text using writeHTMLCell()
$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

$pdf->SetMargins(15, 50, 10, true);
$pdf->AddPage('P');
$pdf->SetFont('thsarabun', '', 14, '', true);
$pdf->Ln(30);
$html1='<table width="100%"  border="0" style="text-align:left;">
<tr>
    <td width="28%" align="left"><strong>Bound &nbsp;: </strong>'.$info['bound'].'<br><strong>Freight &nbsp;:</strong> '.$info['transportName'].'<br><strong>JOB NO : </strong>'.$info['ref_jobNo'].'</td>
    <td width="45%" align="left"><strong>Commodity :</strong> '.$info['good_commodity'].' <br><strong>Qty. / Measurement :</strong>  '.$showCBM.'<br><strong>Origin / Destination&nbsp;&nbsp;:</strong> '.$info['port_of_landing'].' / '.$info['port_of_discharge'].'</td>
    <td width="40%" align="left"><strong>Carrier&nbsp;&nbsp;&nbsp;&nbsp; : </strong>&nbsp;'.$info['agent'].' <br><strong>B/L No. &nbsp;&nbsp;&nbsp;:</strong> '.$info['bill_of_landing'].' <br><strong>On Board : &nbsp;</strong>'.$info['Onboard'].' </td>

</tr>


</table>';
$pdf->writeHTMLCell(0, 0, '', '', $html1, 0, 1, 0, true, '', true);
$pdf->Ln(2);
$html='<table width="100%"  border="0" style="text-align:left;">
<tr>
    <td width="8%" align="center"><strong>No.</strong></td>
    <td width="60%" align="center"><strong>Particulars</strong></td>
    <td width="15%" align="center"><strong>Your Behalf</strong></td>
    <td width="15%" align="center"><strong>Amount (Baht)<br></strong></td>
		
</tr> ';
$sql = "SELECT
t.comCode,
t.documentID,
t.chargeCode,
t.detail,
t.chargesCost,
(t.chargesReceive) as chargesReceive,
(t.chargesbillReceive) as chargesbillReceive,
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
    <td  align="center">'.$i.'</td>
    <td>'.$r['detail'].'</td>
    <td align="right">'.$chargesbillReceive.'</td>
    <td  align="right">'.$chargesReceive.'</td>	
	
</tr> ';


$i++;
}
$html.='
</table> ';
// Print text using writeHTMLCell()
$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);



$pdf->SetMargins(15, 50, 10, true);
$pdf->AddPage('P');
$pdf->SetFont('thsarabun', '', 14, '', true);
$pdf->Ln(30);
$html1='<table width="100%"  border="0" style="text-align:left;">
<tr>
    <td width="28%" align="left"><strong>Bound &nbsp;: </strong>'.$info['bound'].'<br><strong>Freight &nbsp;:</strong> '.$info['transportName'].'<br><strong>JOB NO : </strong>'.$info['ref_jobNo'].'</td>
    <td width="45%" align="left"><strong>Commodity :</strong> '.$info['good_commodity'].' <br><strong>Qty. / Measurement :</strong>  '.$showCBM.'<br><strong>Origin / Destination&nbsp;&nbsp;:</strong> '.$info['port_of_landing'].' / '.$info['port_of_discharge'].'</td>
    <td width="40%" align="left"><strong>Carrier&nbsp;&nbsp;&nbsp;&nbsp; : </strong>&nbsp;'.$info['agent'].' <br><strong>B/L No. &nbsp;&nbsp;&nbsp;:</strong> '.$info['bill_of_landing'].' <br><strong>On Board : &nbsp;</strong>'.$info['Onboard'].' </td>

</tr>


</table>';
$pdf->writeHTMLCell(0, 0, '', '', $html1, 0, 1, 0, true, '', true);
$pdf->Ln(2);
$html='<table width="100%"  border="0" style="text-align:left;">
<tr>
    <td width="8%" align="center"><strong>No.</strong></td>
    <td width="60%" align="center"><strong>Particulars</strong></td>
    <td width="15%" align="center"><strong>Your Behalf</strong></td>
    <td width="15%" align="center"><strong>Amount (Baht)<br></strong></td>
		
</tr> ';
$sql = "SELECT
t.comCode,
t.documentID,
t.chargeCode,
t.detail,
t.chargesCost,
(t.chargesReceive) as chargesReceive,
(t.chargesbillReceive) as chargesbillReceive,
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
    <td  align="center">'.$i.'</td>
    <td>'.$r['detail'].'</td>
    <td align="right">'.$chargesbillReceive.'</td>
    <td  align="right">'.$chargesReceive.'</td>	
	
</tr> ';


$i++;
}
$html.='
</table> ';
// Print text using writeHTMLCell()
$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

/*
$pdf->SetMargins(15, 50, 10, true);
$pdf->AddPage('P');
$pdf->SetFont('thsarabun', '', 14, '', true);
$pdf->Ln(30);
$html1='<table width="100%"  border="0" style="text-align:left;">
<tr>
    <td width="28%" align="left"><strong>Bound &nbsp;: </strong>'.$info['bound'].'<br><strong>Freight &nbsp;:</strong> '.$info['transportName'].'<br><strong>JOB NO : </strong>'.$info['ref_jobNo'].'</td>
    <td width="45%" align="left"><strong>Commodity :</strong> '.$info['good_commodity'].' <br><strong>Qty. / Measurement :</strong>  '.$showCBM.'<br><strong>Origin / Destination&nbsp;&nbsp;:</strong> '.$info['port_of_landing'].' / '.$info['port_of_discharge'].'</td>
    <td width="40%" align="left"><strong>Carrier&nbsp;&nbsp;&nbsp;&nbsp; : </strong>&nbsp;'.$info['agent'].' <br><strong>B/L No. &nbsp;&nbsp;&nbsp;:</strong> '.$info['bill_of_landing'].' <br><strong>On Board : &nbsp;</strong>'.$info['Onboard'].' </td>

</tr>


</table>';
$pdf->writeHTMLCell(0, 0, '', '', $html1, 0, 1, 0, true, '', true);
$pdf->Ln(2);
$html='<table width="100%"  border="0" style="text-align:left;">
<tr>
    <td width="8%" align="center"><strong>No.</strong></td>
    <td width="75%" align="center"><strong>Particulars</strong></td>
    <td width="15%" align="center"><strong>Amount (Baht)<br></strong></td>
		
</tr> ';
$sql = "SELECT
t.comCode,
t.documentID,
t.chargeCode,
t.detail,
t.chargesCost,
(t.chargesReceive) as chargesReceive,
(t.chargesbillReceive) as chargesbillReceive,
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
WHERE  t.comCode='$db->comCode' AND t.documentID='$documentID' AND t.chargesbillReceive>0  

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
    <td  align="center">'.$i.'</td>
    <td>'.$r['detail'].'</td>
    <td align="right">'.$chargesbillReceive.'</td>

	
</tr> ';


$i++;
}
$html.='
</table> ';
// Print text using writeHTMLCell()
$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
*/
ob_end_clean();  
$pdf->Output($documentID.'.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
