<?php
require $_SERVER['DOCUMENT_ROOT'] . "/inc/settings.php";
require $_SERVER['DOCUMENT_ROOT'] . "/inc/dbconnect.php";
require $_SERVER['DOCUMENT_ROOT'] . "/inc/functions.php";
/*require_once $_SERVER['DOCUMENT_ROOT'] . "/tcpdf/tcpdf.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/fpdf/src/autoload.php";*/

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$entry_id = $_POST["entry_id"];
	$entry_number = $_POST["entry_number"];
	
	$filename = $_SERVER['DOCUMENT_ROOT'] . "/pdf/" . $entry_number . ".pdf";
	
	if (file_exists($filename)) {
		echo "Die PDF-Datei existiert bereits";
	} else {
		$pdf_number = "";
		$signed_status = 0;
		$pdf_version = 0;
		$download_file = 2;
		$url = BASEHREF . 'inc/PDF/createPDF.php';
		$params = [
			'file_name' => 'test',
			'entry_id' => $entry_id,
			'signed_status' => $signed_status,
			'pdf_version' => $pdf_version,
			'pdf_number' => $pdf_number,
			'download_file' => $download_file,
		];
		$url .= '?' . http_build_query($params);

		$pdfResult = file_get_contents($url);
        echo $pdfResult;
	
		if(createPDF($entry_id, $signed_status, $pdf_version, $pdf_number, $download_file)) {
			echo "PDF-Dokument wurde erstellt.";
		} else {
			echo "Fehler beim Erstellen von PDF.";
		}
	}	
}
