<?php
if(isset($_GET["download_version"]) AND !empty($_GET["download_version"])) {
	$download_version = $_GET["download_version"];
	if (is_numeric($download_version)) {
        $download_version = intval($download_version);
	} else {
		$download_version = 1;
	}
	
} else {
    $download_version = 1;
}

// Variablen auf 0 gesetzt, da sie ohne Entry ID 
// nicht definiert werden und um Fehler zu vermeiden

$entry_id = 0;
$insured_person_salutation = 1;
$care_level = 0;
$insured_person_first_name = 0;
$insured_person_last_name = 0;
$insured_person_street = 0;
$insured_person_phone = 0;
$insured_person_city = 0;
$care_giver_person_street = 0;
$insured_person_address_addition = 0;
$insured_person_zipcode = 0;
$care_giver_person_first_name = 0;
$care_giver_person_last_name = 0;
$care_giver_person_address_addition = 0;
$care_giver_person_phone = 0;
$care_giver_person_zipcode = 0;
$care_service_street = 0;
$care_service_name = 0;
$care_service_address_addition = 0;
$care_service_zipcode = 0;
$care_service_city = 0;
$bed_protectors_amount = 0;
$insured_person_birth_date = 0;
$insured_person_email = 0;
$insurance_company_name = 0;
$insurance_number = 0;


require('../../tcpdf/tcpdf.php');
require('../../fpdf/src/autoload.php');
require('../settings.php');
require('../dbconnect.php');
require('../functions.php');
require('PDFCoordinates.php');
require('PDFArrays.php');

$product_data = getProducts($mysqli, 1);


// INFO FILE NAME

if(isset($_GET['file_name'])) {
	$file_name = $_GET['file_name'];
}

// INITIERUNG FPDI PLUGIN / PDF
$pdf = new \setasign\Fpdi\Tcpdf\Fpdi();

// SOURCE FILE + SIGNATUR BILD DEFINIEREN || KONFIGURATION PDF
$pdf->setSourceFile(__DIR__ . '/../../pdf-forms/ImpulseBoxPDF-Full.pdf');
$path = __DIR__ . '/../../pdf/';

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


switch($download_version) {
	case 1:
		
		// Antrag auf Kostenübernahme, Download von Seite 3 und 5
		
		$pageId3 = $pdf->importPage(3);
		$size3 = $pdf->getTemplateSize($pageId3);
		$pdf->AddPage('P', array($size3['width'], $size3['height']));
		$pdf->useTemplate($pageId3, 0, 0, $size3['width']);


		switchFont($pdf, "products_klein");
		$pos = 1;
		foreach ($product_data as $product) {
		$recent_name = $product['short_name']." (".$product['pack_quantity'].") ";
		$pos_number = $product['positionsnumber'];
		if ($product['id'] == 1) {
			continue;
		}
		$pdf->SetXY($generally_needed_text[$pos]['x'], $generally_needed_text[$pos]['y']);
		$pdf->Write(0, $recent_name);
		$pdf->SetXY($generally_needed_position_number[$pos]['x'], $generally_needed_position_number[$pos]['y']);
		$pdf->Write(0, $pos_number);
		$pos++;
		}
		$pageId5 = $pdf->importPage(5);
		$size5 = $pdf->getTemplateSize($pageId5);
		$pdf->AddPage('P', array($size5['width'], $size5['height']));
		$pdf->useTemplate($pageId5, 0, 0, $size5['width']);
		
		
		break;
	case 2:
		
		// Antrag auf Kostenübernahme, Download von Seite 2 und 4
		
		$pageId2 = $pdf->importPage(2);
		$size2 = $pdf->getTemplateSize($pageId2);
		$pdf->AddPage('P', array($size2['width'], $size2['height']));
		$pdf->useTemplate($pageId2, 0, 0, $size2['width']);
		
		
		foreach ($compilation_data as $compilation_entry) {
			// Individuelle Box wird nicht aufs PDF geschrieben, da bereits vorhanden
			if ($compilation_entry['name'] !== "Individuell") {
				$filtered_compilations[] = $compilation_entry['name'];
			}
		}

		$index = 1;
		foreach($filtered_compilations as $filtered_compilation) {
			// Boxzusammenstellungsname wird aufgeteilt, falls bestehend aus 2 Wörtern
			$compilation_name_split = splitCompilations($filtered_compilation);
			// Entfernt "PflegeVitalBox" falls im Namen vorhanden
			if ($compilation_name_split[0] == "PflegeVitalBox") {
					unset($compilation_name_split[0]);
					$compilation_name_split = array_values($compilation_name_split);
				}
			$compilation_name_wordcount = count($compilation_name_split);
			// Verschiedene Koordinaten basierend auf der Anzahl der Wörter
			switch ($compilation_name_wordcount) {
				case 0:
					break;
				case 1:
					switchFont($pdf, "start");
					$pdf->SetXY($product_compilation_titles_one_word[$index]['x'], $product_compilation_titles_one_word[$index]['y']);
					$pdf->Write(0, $compilation_name_split[0]);
					break;
				case 2: 
					switchFont($pdf, "klein");
					$pdf->SetXY($product_compilation_titles_two_words[$index]['x1'], $product_compilation_titles_two_words[$index]['y1']);
					$pdf->Write(0, $compilation_name_split[0]);
					$pdf->SetXY($product_compilation_titles_two_words[$index]['x2'], $product_compilation_titles_two_words[$index]['y2']);
					$pdf->Write(0, $compilation_name_split[1]);
					break;
			}
			$index++;
		}
		$index = 1;
		foreach ($product_data as $product) {
			$product_name = $product['name']." (".$product['pack_quantity'].") ";
			if ($product['id'] == 1) {
				continue;
			}
			switchFont($pdf, "products");
			$pdf->SetXY($product_names[$index]['x'], $product_names[$index]['y']);
			$pdf->Write(0, $product_name);
			$index++;


		}
		$pageId4 = $pdf->importPage(4);
		$size4 = $pdf->getTemplateSize($pageId4);
		$pdf->AddPage('P', array($size4['width'], $size4['height']));
		$pdf->useTemplate($pageId4, 0, 0, $size4['width']);
		break;
		
	case 3:
		$pageId8 = $pdf->importPage(8);
		$size8 = $pdf->getTemplateSize($pageId8);
		$pdf->AddPage('P', array($size8['width'], $size8['height']));
		$pdf->useTemplate($pageId8, 0, 0, $size8['width']);
		break;
}
ob_start();
// i - preview
$pdf->Output('Antrag.pdf', 'I');
