<?php
require_once('tcpdf_include.php');


class MYPDF extends TCPDF {

	//Page header
	public function Header() {
		// Logo
		//$image_file = K_PATH_IMAGES.'logo_example.jpg';
	//	$this->Image($image_file, 10, 10, 15, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
		// Set font
		$this->Ln(10);
		$this->SetFont('thsarabun', 'B', 20);
		$this->Cell(0, 15, 'บริษัท พีระพงษ์การแพทย์ แอนด์ เซฟตี้ จำกัด', 0, false, 'C', 0, '', 0, false, 'M', 'M');
		$this->Ln(6);
		$this->SetFont('thsarabun', '', 14);
		$this->Cell(0, 15, '99/22 หมู่ที่ 12 ซอยวัดหลวงพ่อโต ถนนบางนา-ตราด บางพลีใหญ่ บางพลี สมุทรปราการ 10540', 0, false, 'C', 0, '', 0, false, 'M', 'M');
		$this->Ln(6);
		$this->writeHTML("<hr>", true, false, false, false, '');
	}

	// Page footer
	public function Footer() {
		// Position at 15 mm from bottom
		$this->SetY(-15);
		// Set font
		$this->SetFont('helvetica', 'I', 8);
		// Page number
		$this->Cell(0, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
	}
}

// create new PDF document
//$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Nicola Asuni');
$pdf->SetTitle('บัญชีเงินเดือน');
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
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

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
$pdf->AddPage('P'); // $pdf->AddPage('L');
$pdf->SetFont('thsarabun', '', 16, '', true);
$pdf->Ln(5);
$pdf->Cell(0, 10, 'บัญชีเงินเดือนffffิษัท พีระพงษ์การแพทย์ แอนด์ เซฟตี้ จำกัด ช่วงวันที่  1/5/2016 ถึง  31/5/2016 ', 0, false, 'L', 0, '', 0, false, 'T', 'M');
$pdf->SetFont('thsarabun', '', 14, '', true);
$pdf->Ln(12);
$html='<table width="100%" border="1" style="text-align:center;">
  <tr>
    <td width="8%">ลำดับ</td>
    <td width="12%">รหัสพนักงาน</td>
    <td width="25%">ชื่อพนักงาน</td>
    <td width="15%">ประเภท</td>
    <td width="10%">จำนวนเงิน</td>
    <td width="10%">OT</td>
    <td width="10%">หักเบิก</td>
    <td width="10%">เงินเดือนสุทธิ</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>';
// Print text using writeHTMLCell()
$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

// ---------------------------------------------------------

// Close and output PDF document
// This method has several options, check the source code documentation for more information.
$pdf->Output('บัญชีเงินเดือน.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
