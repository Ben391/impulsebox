<?php

// Wird unten eine PDF definiert, kann eine PDF-Seite importiert werden
// $SEITE = $pdf->importPage(ID) - ID ist die jeweilige Seitennummer, startend bei 1

// Danach muss noch die größe angepasst werden, ohne Werte anzugeben, so werden die exakten Dimensionen übernommen
// $GROESSE = $pdf->getTemplateSize($SEITE)
// $pdf->AddPage('P', array($GROESSE['width'], $GROESSE['height']))
// $pdf->useTemplate($SEITE, 0, 0, $GROESSE['width'])

// Die Farbe passt du so an
// $pdf->SetTextColor(0, 0, 0) - basierend auf dem RGB Modell

// Text wird so generiert, Die Koordinaten werden in der PDFCoordinates.php festgelegt
// Wenn mehrere Wörter generiert werden, werden die Koordinaten als Array in der PDFArrays.php festgelegt
// $pdf->SetXY($X-KOORDINATE, $Y-KOORDINATE);
// $pdf->Write(0, $INHALT);

// Die Schriftgröße passt du mit der Funktion switchFont() an
// switchFont($pdf, "Schriftgröße")
// Mögliche Schriftgrößen sind: 
// "standard" (12), "long_words" (11), "products" (10), "start" (9), "klein" (7), "anhaken" (20), "anhaken_klein" (16)


if(isset($_GET["entry_id"]) AND !empty($_GET["entry_id"])) {
	$entry_id = htmlspecialchars($_GET["entry_id"], ENT_QUOTES, 'UTF-8');
	$base_path = $_SERVER["DOCUMENT_ROOT"]; #!!
    require($base_path . '/tcpdf/tcpdf.php');
    require($base_path . '/fpdf/src/autoload.php');
    require($base_path . '/inc/settings.php');
    require($base_path . '/inc/dbconnect.php');
    require($base_path . '/inc/functions.php');
    require($base_path . '/inc/PDF/PDFCoordinates.php');
    require($base_path . '/inc/PDF/PDFArrays.php');

	// PDF INFO
	
	if(isset($_GET['page_nr'])) {
		$page = $_GET['page_nr'];
	}
	$signed = 0;
	$download = 0;
	$pdf_version = 0;
	$file_name = "Preview";

	// INITIERUNG FPDI PLUGIN / PDF
	$pdf = new \setasign\Fpdi\Tcpdf\Fpdi();

	// SOURCE FILE + SIGNATUR BILD DEFINIEREN || KONFIGURATION PDF
	$pdf->setSourceFile(__DIR__ . '/../../pdf-forms/ImpulseBoxPDF-Full.pdf');
	$path = __DIR__ . '/../../pdf/';
	
	$checkmark = __DIR__ . '/../../img/icons/draw-check-mark.png';

	$pdf->SetTopMargin(0);
	$pdf->setHeaderMargin(0);
	$pdf->SetAutoPageBreak(true, 0);
	$pdf->SetMargins(0, 0, 0);
	$pdf->SetFooterMargin(0);
	$pdf->setPrintHeader(false);
	$pdf->setPrintFooter(false);
	$pdf->SetCellPaddings(0, 0, 0, 0);

	// QUADRAT GRößE
	$square_size_x = 4;
	$square_size_y = 4;

	if ($page == 1) {
		include __DIR__ . "/pages/page2.php";
	} else if ($page == 2) {
		include __DIR__ . "/pages/page3.php";
	} else if ($page == 3) {
		include __DIR__ . "/pages/page4.php";
	} else if ($page == 4) {
		include __DIR__ . "/pages/page6.php";
	} else if ($page == 5) {
		include __DIR__ . "/pages/page5.php";
	}
	$pdf_file_name = $entry_number . ".pdf";
	$pdf->Output($pdf_file_name, 'I');

} else {
echo "empty entry id";
}