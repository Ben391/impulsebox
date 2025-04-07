<?php
if(isset($_GET['file_name'])) {
	$file_name = $_GET['file_name'];
}
if(isset($_GET['signed_status']) AND $_GET['signed_status'] == 1) {
	$signed = 1;
} else {
	$signed = 0;
}

if(isset($_GET['download_file']) AND $_GET['download_file'] == 1) {
	$download = 1;
} else {
	$download = 0;
}

require_once('../../tcpdf/tcpdf.php');
require_once('../../fpdf/src/autoload.php');
require_once('../settings.php');
require_once('../dbconnect.php');
require_once('../functions.php');
require_once('PDFCoordinates.php');
require_once('PDFArrays.php');

if(isset($_GET["entry_id"]) AND !empty($_GET["entry_id"])) {
	$entry_id = $_GET["entry_id"];
	if($entry_data = getEntryData($mysqli, $entry_id)) {
		$insured_person_first_name = getNestedValue($entry_data, ["insured_person_data", "insured_person_first_name"]);
		$insured_person_last_name = getNestedValue($entry_data, ["insured_person_data", "insured_person_last_name"]);
		$insured_person_street = getNestedValue($entry_data, ["insured_person_data", "insured_person_street"]);
		$insured_person_phone = getNestedValue($entry_data, ["insured_person_data", "insured_person_phone"]);
		$insured_person_salutation = getNestedValue($entry_data, ["insured_person_data", "insured_person_salutation"]);
		$insured_person_zipcode = getNestedValue($entry_data, ["insured_person_data", "insured_person_zipcode"]);
		$insured_person_city = getNestedValue($entry_data, ["insured_person_data", "insured_person_city"]);
		$insured_person_birth_date = getNestedValue($entry_data, ["insured_person_data", "insured_person_birth_date"]);
		$insured_person_email = getNestedValue($entry_data, ["insured_person_data", "insured_person_email"]);
		$care_level = getNestedValue($entry_data, ["insured_person_data", 'care_level']);
		$insurance_company_name = getNestedValue($entry_data, ["insured_person_data", 'insurance_company_name']);
		$custom_insurance_company_name = getNestedValue($entry_data, ["insured_person_data", 'custom_insurance_company_name']);
		$insurance_number = getNestedValue($entry_data, ["insured_person_data", 'insurance_number']);
		$insurance_aid = getNestedValue($entry_data, ["insured_person_data", 'insurance_aid']);

		$care_giver_person_first_name = getNestedValue($entry_data, ["care_giver_person_data", "care_giver_person_first_name"]);
		$care_giver_person_last_name = getNestedValue($entry_data, ["care_giver_person_data", "care_giver_person_last_name"]);
		$care_giver_person_street = getNestedValue($entry_data, ["care_giver_person_data", "care_giver_person_street"]);
		$care_giver_person_zipcode = getNestedValue($entry_data, ["care_giver_person_data", "care_giver_person_zipcode"]);
		$care_giver_person_city = getNestedValue($entry_data, ["care_giver_person_data", "care_giver_person_city"]);
		$care_giver_person_phone = getNestedValue($entry_data, ["care_giver_person_data", "care_giver_person_phone"]);
		$care_giver_person_mail = getNestedValue($entry_data, ["care_giver_person_data", "care_giver_person_email"]);

		$care_service_name  = getNestedValue($entry_data, ["care_giver_service_data", "care_giver_service_company"]);
		$care_service_street = getNestedValue($entry_data, ["care_giver_service_data", "care_giver_service_street"]);
		$care_service_zipcode = getNestedValue($entry_data, ["care_giver_service_data", "care_giver_service_zipcode"]);
		$care_service_city = getNestedValue($entry_data, ["care_giver_service_data", "care_giver_service_city"]);

		$delivery_destination = getNestedValue($entry_data, ["delivery_data", "delivery"]);

		$supplier_change = getNestedValue($entry_data, ["delivery_data", "supplier_change"]);

		$product_full_data = getNestedValue($entry_data, ["product_data", "product_full_data"]);
		$compilation_name = getNestedValue($entry_data, ["product_data", "compilation_name"]);

		$bed_protectors_amount = getNestedValue($entry_data, ["entry_data", "bed_protectors_amount"]);

	}

}

if (empty($custom_insurance_company_name)) {
	$insurance_company_name = $custom_insurance_company_name;
}

// INITIERUNG FPDI PLUGIN / PDF
$pdf = new \setasign\Fpdi\Tcpdf\Fpdi();



// SOURCE FILE + SIGNATUR BILD DEFINIEREN || KONFIGURATION PDF
$pdf->setSourceFile(__DIR__ . '/../../pdf-forms/ImpulseBoxPDF-Full.pdf');
if ($signed == 1) {
	$path = __DIR__ . '/../../pdf/';
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

// ################################################################
// ####################### SEITE 1 ################################
// ################################################################

$pageId = $pdf->importPage(1);

$size = $pdf->getTemplateSize($pageId);
$pdf->AddPage('P', array($size['width'], $size['height']));
$pdf->useTemplate($pageId, 0, 0, $size['width']);

// FARBE
$pdf->SetFillColor(0, 0, 0);

// SCHRIFTART + SCHRIFTFARBE
switchFont($pdf, "start");
$pdf->SetTextColor(0, 0, 0);

$pdf->SetXY($insured_person_last_name_first_page_x, $insured_person_last_name_first_page_y);
$pdf->Write(0, "Herr ".$insured_person_last_name.",");


// ################################################################
// ####################### SEITE 2 ################################
// ################################################################

$pageId2 = $pdf->importPage(2);

// GRÖßE ANPASSEN
$size2 = $pdf->getTemplateSize($pageId2);
$pdf->AddPage('P', array($size2['width'], $size2['height']));
$pdf->useTemplate($pageId2, 0, 0, $size2['width']);

// SCHRIFTART + SCHRIFTFARBE
switchFont($pdf, "standard");
$pdf->SetTextColor(0, 0, 0);

// QUADRAT GRößE
$square_size_x = 4;
$square_size_y = 4;

// DATEN AUF DIE RICHTIGEN KOORDINATEN ÜBERTRAGEN
foreach ($fields1 as $field) {
	$pdf->SetXY($field['x'], $field['y']);
	$pdf->Write(0, $field['value']);
}

// BOX ZUSAMMENSTELLUNG WIRD AUF PDF ÜBERTRAGEN
switch($compilation_name) {
	case 'Individuell':
		switchFont($pdf, "anhaken");
		$pdf->SetXY($box_mybox_x, $box_mybox_y);
		$pdf->Write(0, "x");
		switchFont($pdf, "standard");
		foreach ($product_full_data as $product_array) {
			$recent_id = $product_array['id'];
			$quantity = $product_array['quantity'];
			$size = $product_array['size'];
			$intolerance = $product_array['intolerance'];
			$pdf->SetXY($product_values_mybox[$recent_id]['x'], $product_values_mybox[$recent_id]['y']);
			$pdf->Write(0, $quantity);

			if ($recent_id == 8) {
				setGloveProperties($pdf, $intolerance, $size, $bsipnx, $bsipny, $bsipvx, $bsipvy, $bsipnix, $bsipniy, $bsiplx, $bsiply, $bsspsx, $bsspsy, $bsspmx, $bsspmy, $bssplx, $bssply, $bsspex, $bsspey);
			}

			}
		break;
		case 'Desinfektion':
			switchFont($pdf, "anhaken");
			$pdf->SetXY($box_desinfection_x, $box_desinfection_y);
			$pdf->Write(0, "x");
			switchFont($pdf, "standard");
				foreach ($product_full_data as $product_array) {
					$recent_id = $product_array['id'];
					$quantity = $product_array['quantity'];
					$size = $product_array['size'];
					$intolerance = $product_array['intolerance'];

					$pdf->SetXY($product_values_desinfection[$recent_id]['x'], $product_values_desinfection[$recent_id]['y']);
					$pdf->Write(0, $quantity);
					if ($recent_id == 8) {
						setGloveProperties($pdf, $intolerance, $size, $bsipnx, $bsipny, $bsipvx, $bsipvy, $bsipnix, $bsipniy, $bsiplx, $bsiply, $bsspsx, $bsspsy, $bsspmx, $bsspmy, $bssplx, $bssply, $bsspex, $bsspey);
					}
				}
			break;
		case 'Hygiene':
			switchFont($pdf, "anhaken");
			$pdf->SetXY($box_hygiene_x, $box_hygiene_y);
			$pdf->Write(0, "x");
			switchFont($pdf, "standard");
				foreach ($product_full_data as $product_array) {
					$recent_id = $product_array['id'];
					$quantity = $product_array['quantity'];
					$size = $product_array['size'];
					$intolerance = $product_array['intolerance'];

					$pdf->SetXY($product_values_hygiene[$recent_id]['x'], $product_values_hygiene[$recent_id]['y']);
					$pdf->Write(0, $quantity);

					if ($recent_id == 8) {
						setGloveProperties($pdf, $intolerance, $size, $bsipnx, $bsipny, $bsipvx, $bsipvy, $bsipnix, $bsipniy, $bsiplx, $bsiply, $bsspsx, $bsspsy, $bsspmx, $bsspmy, $bssplx, $bssply, $bsspex, $bsspey);
					}
				}
			break;
		case 'Schutz':
			switchFont($pdf, "anhaken");
			$pdf->SetXY($box_protection_x, $box_protection_y);
			$pdf->Write(0, "x");
			switchFont($pdf, "standard");
				foreach ($product_full_data as $product_array) {
					$recent_id = $product_array['id'];
					$quantity = $product_array['quantity'];
					$size = $product_array['size'];
					$intolerance = $product_array['intolerance'];

					$pdf->SetXY($product_values_protection[$recent_id]['x'], $product_values_protection[$recent_id]['y']);
					$pdf->Write(0, $quantity);

					if ($recent_id == 8) {
						setGloveProperties($pdf, $intolerance, $size, $bsipnx, $bsipny, $bsipvx, $bsipvy, $bsipnix, $bsipniy, $bsiplx, $bsiply, $bsspsx, $bsspsy, $bsspmx, $bsspmy, $bssplx, $bssply, $bsspex, $bsspey);
					}
				}
			break;

}

foreach ($squares1 as $square) {
	$pdf->Rect($square['x'], $square['y'], $square_size_x, $square_size_y, 'F');
}
if ($signed == 1) {
	// UNTERSCHRIFT
	$pdf->Image($signature, $signature_second_page_x, $signature_second_page_y, 40, 0, 'PNG');
}


// ################################################################
// ####################### SEITE 3 ################################
// ################################################################

$pageId3 = $pdf->importPage(3);

$size3 = $pdf->getTemplateSize($pageId3);


$pdf->AddPage('P', array($size3['width'], $size3['height']));
$pdf->useTemplate($pageId3, 0, 0, $size3['width']);

switchFont($pdf, "standard");

foreach ($product_full_data as $product_array) {
	switchFont($pdf, "anhaken");
	$recent_id = $product_array['id'];
	$pdf->SetXY($generally_needed[$recent_id]['x'], $generally_needed[$recent_id]['y']);
	$pdf->Write(0, "X");

	switchFont($pdf, "standard");
}

if ($bed_protectors_amount > 0) {
	$pdf->Rect($assumption_of_costs_bed_protection_x, $assumption_of_costs_bed_protection_y, $square_size_x, $square_size_y, 'F');
}

// SCHLEIFEN FÜR TEXT SCHREIBEN
foreach ($fields2 as $field) {
	$pdf->SetXY($field['x'], $field['y']);
	$pdf->Write(0, $field['value']);
}

foreach ($squares2 as $square) {
	$pdf->Rect($square['x'], $square['y'], $square_size_x, $square_size_y, 'F');
}

if ($care_level > 0) {
	$pdf->Rect($care_level_x, $care_level_y, $square_size_x, $square_size_y, 'F');
}

if ($insurance_aid == 1) {
	$pdf->Rect($insurance_aid_x, $insurance_aid_y, $square_size_x, $square_size_y, 'F');
}

if ($signed == 1) {
	// UNTERSCHRIFT
	$pdf->Image($signature, $signature_third_page_x, $signature_third_page_y, 40, 0, 'PNG');
}


// ################################################################
// ####################### SEITE 4-7 ################################
// ################################################################

$pageId4 = $pdf->importPage(4);
$pageId5 = $pdf->importPage(5);
$pageId6 = $pdf->importPage(6);
$pageId7 = $pdf->importPage(7);

$size4 = $pdf->getTemplateSize($pageId4);
$size5 = $pdf->getTemplateSize($pageId5);
$size6 = $pdf->getTemplateSize($pageId6);
$size7 = $pdf->getTemplateSize($pageId7);

$pdf->AddPage('P', array($size4['width'], $size4['height']));
$pdf->useTemplate($pageId4, 0, 0, $size4['width']);
$pdf->AddPage('P', array($size5['width'], $size5['height']));
$pdf->useTemplate($pageId5, 0, 0, $size5['width']);
$pdf->AddPage('P', array($size6['width'], $size6['height']));
$pdf->useTemplate($pageId6, 0, 0, $size6['width']);
$pdf->AddPage('P', array($size7['width'], $size7['height']));
$pdf->useTemplate($pageId7, 0, 0, $size7['width']);

foreach ($fields3 as $field) {
	$pdf->SetXY($field['x'], $field['y']);
	$pdf->Write(0, $field['value']);
}

foreach ($squares3 as $square) {
	$pdf->Rect($square['x'], $square['y'], $square_size_x, $square_size_y, 'F');
}

if ($signed == 1) {
	// UNTERSCHRIFT
	$pdf->Image($signature, $signature_seventh_page_x, $signature_seventh_page_y, 40, 0, 'PNG');
}

// ################################################################
// ####################### SEITE 8 ################################
// ################################################################

if ($supplier_change == 1) {

	$pageId8 = $pdf->importPage(8);

	$size8 = $pdf->getTemplateSize($pageId8);

	$pdf->AddPage('P', array($size8['width'], $size8['height']));
	$pdf->useTemplate($pageId8, 0, 0, $size8['width']);

	foreach ($squares4 as $square) {
		$pdf->Rect($square['x'], $square['y'], $square_size_x, $square_size_y, 'F');
	}

	foreach ($fields4 as $field) {
		$pdf->SetXY($field['x'], $field['y']);
		$pdf->Write(0, $field['value']);
	}

	if ($signed == 1) {
		// UNTERSCHRIFT
		$pdf->Image($signature, $signature_eight_page_x, $signature_eight_page_y, 40, 0, 'PNG');
	}


}
// ################################################################
// ####################### SEITE 9 ################################
// ################################################################

$pageId9 = $pdf->importPage(9);

$size9 = $pdf->getTemplateSize($pageId9);

$pdf->AddPage('P', array($size9['width'], $size9['height']));
$pdf->useTemplate($pageId9, 0, 0, $size9['width']);



// PDF wird generiert und geöffnet
$prefix = 'impulsebox_antrag';
$pdf_file_name = $prefix."_".$entry_id.".pdf";
switch ($signed) {
	case 0:
		if ($download == 0) {
			$pdf->Output($pdf_file_name, 'I');
		}
		if ($download == 1) {
			$pdf->Output($pdf_file_name, 'D');
		}
		break;
	case 1: 
		$pdf->Output($path.$pdf_file_name, 'F');
		header("Location: ".BASEHREF."abschluss/");
		break;
}

function switchFont($pdf, $type) {
	$open_sans = TCPDF_FONTS::addTTFfont('../../fonts/OpenSans-Light.ttf', 'TrueTypeUnicode', '', 96);
	switch($type) {
		case "standard":
			$pdf->SetFont($open_sans,'',12);
			break;
		case "start":
			$pdf->SetFont($open_sans,'',9);
			break;
		case "anhaken":
			$pdf->SetFont($open_sans, '', 20);
			break;
		// ... andere Fälle ...
		default:
			$pdf->SetFont($open_sans,'',12);
			break;
	}
}

function setGloveProperties($pdf, $intolerance, $size, $bsipnx, $bsipny, $bsipvx, $bsipvy, $bsipnix, $bsipniy, $bsiplx, $bsiply, $bsspsx, $bsspsy, $bsspmx, $bsspmy, $bssplx, $bssply, $bsspex, $bsspey) {


	$intolerances = [
		'none' => [
			'x' => $bsipnx,
			'y' => $bsipny,
		],
		'v' => [
			'x' => $bsipvx,
			'y' => $bsipvy,
		],
		'n' => [
			'x' => $bsipnix,
			'y' => $bsipniy,
		],
		'l' => [
			'x' => $bsiplx,
			'y' => $bsiply,
		],
	];

		if (!empty($size)) {
			switchFont($pdf, "anhaken");
			switch($size) {
				case 's':
					//$pdf->Ellipse($input_seven_size_property_small_x, $input_seven_size_property_small_y, 3, 'F');
					$pdf->SetXY($bsspsx, $bsspsy);
					$pdf->Write(0, "x");
					break;
				case 'm':
					//$pdf->Ellipse($input_seven_size_property_medium_x, $input_seven_size_property_medium_y, 3, 'F');
					$pdf->SetXY($bsspmx, $bsspmy);
					$pdf->Write(0, "x");
					break;
				case 'l':
					//$pdf->Circle($input_seven_size_property_large_x, $input_seven_size_property_large_y, 3, 'F');
					$pdf->SetXY($bssplx, $bssply);
					$pdf->Write(0, "x");
					break;
				case 'xl':
					//$pdf->Circle($input_seven_size_property_extralarge_x, $input_seven_size_property_extralarge_y, 3, 'F');
					$pdf->SetXY($bsspex, $bsspey);
					$pdf->Write(0, "x");
					break;

			}
			switchFont($pdf, "standard");
			}
			switchFont($pdf, "anhaken");
			if (strpos($intolerance, 'v') !== false) {
				$pdf->SetXY($intolerances['v']['x'], $intolerances['v']['y']);
				$pdf->Write("0", "x");

			}
			if (strpos($intolerance, 'l') !== false) {
				$pdf->SetXY($intolerances['l']['x'], $intolerances['l']['y']);
				$pdf->Write("0", "x");
			}
			if (strpos($intolerance, 'n') !== false) {
				$pdf->SetXY($intolerances['n']['x'], $intolerances['n']['y']);
				$pdf->Write("0", "x");
			}
			if (empty($intolerance)) {
				$pdf->setXY($intolerances['none']['x'], $intolerances['none']['y']);
				$pdf->Write("0", "x");
			}
			switchFont($pdf, "standard");
	}