<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/inc/settings.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/inc/dbconnect.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/inc/functions.php";
/*require_once $_SERVER['DOCUMENT_ROOT'] . "/tcpdf/tcpdf.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/fpdf/src/autoload.php";*/

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$entry_id = $_POST["entry_id"];
	$entry_number = $_POST["entry_number"];
	
	//$filename = $_SERVER['DOCUMENT_ROOT'] . "/pdf/" . $entry_number . ".pdf";
	$filename = $_SERVER['DOCUMENT_ROOT'] . "/pdf/" . $entry_number . ".pdf";
	
	if (file_exists($filename)) {
		$pdf_number = 2;
		$signed_status = 0;
		$pdf_version = 0;
		if(createPDF($entry_id, $signed_status, $pdf_version, $pdf_number)) {
			echo "new pdf created";
		} else {
			echo "error";
		}
	} else {
		$pdf_number = 2;
		$signed_status = 1;
		$pdf_version = 0;
		if(createPDF($entry_id, $signed_status, $pdf_version, $pdf_number)) {
			echo "new pdf created";
		} else {
			echo "error";
		}
	}	
}
