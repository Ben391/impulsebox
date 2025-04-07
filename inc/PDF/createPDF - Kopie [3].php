<?php
if(isset($_GET["entry_id"]) AND !empty($_GET["entry_id"])) {
	$entry_id = $_GET["entry_id"];
	
	require('../../tcpdf/tcpdf.php');
	require('../../fpdf/src/autoload.php');
	require('../settings.php');
	require('../dbconnect.php');
	require('../functions.php');
	require('PDFCoordinates.php');
	require('PDFArrays.php');

	// INFO FILE NAME

	if(isset($_GET['file_name'])) {
		$file_name = $_GET['file_name'];
	}

	// INFO DOKUMENT IST UNTERSCHRIEBEN - JA ODER NEIN	

	if(isset($_GET['signed_status']) AND $_GET['signed_status'] == 1) {
		$signed = $_GET['signed_status'];
	} else {
		$signed = 0;
	}

	// INFO PDF SOLL GEDOWNLOADET WERDEN ODER PDF GEOEFFNET WERDEN	

	if(isset($_GET['download_file']) AND $_GET['download_file'] == 1) {
		$download = $_GET['download_file'];
	} else {
		$download = 0;
	}

	// INFO PDF SOLL VOLLSTAENDIG SEIN ODER NUR EINEN KLEINEN TEIL

	if(isset($_GET['pdf_version']) AND $_GET['pdf_version'] == 1) {
		$pdf_version = 1;
	} else {
		$pdf_version = 0;
	}

	// INFO SMARTPHONE ODER NICHT

	if(isset($_GET['deviceType']) AND $_GET['deviceType'] == "mobile") {
		$device = 1;
	} else {
		$device = 0;
	}

		// INITIERUNG FPDI PLUGIN / PDF
		$pdf = new \setasign\Fpdi\Tcpdf\Fpdi();

		// SOURCE FILE + SIGNATUR BILD DEFINIEREN || KONFIGURATION PDF
		$pdf->setSourceFile(__DIR__ . '/../../pdf-forms/ImpulseBoxPDF-Full.pdf');
		$path = __DIR__ . '/../../pdf/';
	
		if ($signed == 1) {
			$signature = __DIR__ . '/../../img/signatures/' . $file_name;
		}
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
		
		if ($pdf_version == 0) {
			include __DIR__ . "/pages/page1.php";
			include __DIR__ . "/pages/page2.php";
        }
		include __DIR__ . "/pages/page3.php";
        if ($pdf_version == 0) {
			include __DIR__ . "/pages/page4-6.php";
		}
		include __DIR__ . "/pages/page7.php";
		if ($signed == 1) {
			// UNTERSCHRIFT
			if ($device == 0) {
                $pdf->Image($signature, $signature_seventh_page_x, $signature_seventh_page_y, 40, 0, 'PNG');
            } else {
                $pdf->Image($signature, $signature_seventh_page_x, $signature_seventh_page_y-4, 40, 0, 'PNG');
            }
		}
		if ($supplier_change == 1) {
			include __DIR__ . "/pages/page8.php";
		}
		if($pdf_version == 0) {
			include __DIR__ . "/pages/page9.php";
		}
		// PDF wird generiert und geöffnet	
		if(isset($_GET['pdf_number']) AND !empty($_GET['pdf_number'])) {
			$pdf_number = $_GET['pdf_number'];
			$pdf_number = "_" . $pdf_number;
		} else {
			$pdf_number = "";
		}
		$pdf_file_name = $entry_number . $pdf_number . ".pdf";
		switch ($signed) {
			case 0:
				if ($download == 0) {
					ob_start();
					// i - preview
					$pdf->Output($pdf_file_name, 'I');
				} elseif($download == 1) {
					ob_start();
					// d- download
					$pdf->Output($pdf_file_name, 'D');
				} else {
					ob_start();
					// f - save
					$pdf->Output($pdf_file_name, 'F');
				}
				break;
			case 1: 
				$pdf->Output($path . $pdf_file_name, 'F');
				header("Location: ".BASEHREF."abschluss/");
				break;
		}
} else {
	echo "empty entry id";
}