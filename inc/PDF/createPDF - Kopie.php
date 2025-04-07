<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once('../../tcpdf/tcpdf.php');
require_once('../../fpdf/src/autoload.php');
require_once('../settings.php');
require_once('../dbconnect.php');
require_once('../functions.php');
require_once('PDFCoordinates.php');
require_once('PDFArrays.php');

if(isset($_GET["entry_id"]) AND !empty($_GET["entry_id"])) {
	$entry_id = $_GET["entry_id"];
	
	if(isset($_GET['file_name'])) {
		$file_name = $_GET['file_name'];
	}
	// INFO DOKUMENT IST UNTERSCHRIEBEN - JA ODER NEIN
    $signed = isset($_GET['signed_status']) && $_GET['signed_status'] == 1 ? 1 : 0;
    $download = isset($_GET['download_file']) && $_GET['download_file'] == 1 ? 1 : 0;
	// INFO PDF SOLL VOLLSTAENDIG SEIN ODER NUR EINEN KLEINEN TEIL
    $pdf_version = isset($_GET['pdf_version']) && $_GET['pdf_version'] == 1 ? 1 : 0;
    $device = isset($_GET['deviceType']) && $_GET['deviceType'] == "mobile" ? 1 : 0;

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
            $pdf->Write(0, $insured_person_salutation_text." ".$insured_person_last_name.",");
			
			


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

            // DATEN AUF DIE RICHTIGEN KOORDINATEN ÜBERTRAGEN
            foreach ($fields1 as $field) {
                $pdf->SetXY($field['x'], $field['y']);
                $pdf->Write(0, $field['value']);
            }

			if ($care_giver_person_city_longer == true) {
				switchFont($pdf, "long_words");
				$pdf->SetXY($care_giver_person_city_second_page_x, $care_giver_person_city_second_page_y+1);
            	$pdf->Write(0, $care_giver_person_city);
			} else {
				switchFont($pdf, "standard");
				$pdf->SetXY($care_giver_person_city_second_page_x, $care_giver_person_city_second_page_y);
            	$pdf->Write(0, $care_giver_person_city);
			}
			

			if ($care_giver_person_mail_longer == true) {
				switchFont($pdf, "long_words");
				$pdf->SetXY($care_giver_person_mail_second_page_x, $care_giver_person_mail_second_page_y+1);
           	 	$pdf->Write(0, $care_giver_person_mail);
			} else {
				switchFont($pdf, "standard");
				$pdf->SetXY($care_giver_person_mail_second_page_x, $care_giver_person_mail_second_page_y);
            	$pdf->Write(0, $care_giver_person_mail);
			}

			switchFont($pdf, "standard");
            // BOX ZUSAMMENSTELLUNG WIRD AUF PDF ÜBERTRAGEN
            switch($compilation_name) {
                case 'Individuell':
                    switchFont($pdf, "anhaken");
                    $pdf->SetXY($box_mybox_x, $box_mybox_y);
                    $pdf->Write(0, "x");
                    switchFont($pdf, "products");
					$pos = 1;
                    foreach ($product_full_data as $product_array) {
                        $recent_id = $product_array['id'];
						$recent_name = $product_array['name']." (".$product_array['pack_quantity'].") ";
                        $quantity = $product_array['quantity'];
                        $size = $product_array['size'];
                        $intolerance = $product_array['intolerance'];
						if ($recent_id == 10) { 
                            setGloveProperties($pdf, $intolerance, $size, $bsipnx, $bsipny, $bsipvx, $bsipvy, $bsipnix, $bsipniy, $bsiplx, $bsiply, $bsspsx, $bsspsy, $bsspmx, $bsspmy, $bssplx, $bssply, $bsspex, $bsspey);
							switchFont($pdf, "standard");
                        	$pdf->SetXY($product_values_mybox['10']['x'], $product_values_mybox['10']['y']);
                        	$pdf->Write(0, $quantity);
							continue;
                        }
						switchFont($pdf, "products");
						$pdf->SetXY($product_names[$pos]['x'], $product_names[$pos]['y']);
						$pdf->Write(0, $recent_name);
						switchFont($pdf, "standard");
                        $pdf->SetXY($product_values_mybox[$pos]['x'], $product_values_mybox[$pos]['y']);
                        $pdf->Write(0, $quantity);
						$pos++;
                        }
                break;
                case 'Desinfektion':
                    switchFont($pdf, "anhaken");
                    $pdf->SetXY($box_desinfection_x, $box_desinfection_y);
                    $pdf->Write(0, "x");
                    switchFont($pdf, "products");
					$pos = 1;
                    foreach ($product_full_data as $product_array) {
                        $recent_id = $product_array['id'];
						$recent_name = $product_array['name']." (".$product_array['pack_quantity'].") ";
                        $quantity = $product_array['quantity'];
                        $size = $product_array['size'];
                        $intolerance = $product_array['intolerance'];
						if ($recent_id == 10) {
                            setGloveProperties($pdf, $intolerance, $size, $bsipnx, $bsipny, $bsipvx, $bsipvy, $bsipnix, $bsipniy, $bsiplx, $bsiply, $bsspsx, $bsspsy, $bsspmx, $bsspmy, $bssplx, $bssply, $bsspex, $bsspey);
							switchFont($pdf, "standard");
                        	$pdf->SetXY($product_values_desinfection['10']['x'], $product_values_desinfection['10']['y']);
                        	$pdf->Write(0, $quantity);
							continue;
                        }
						switchFont($pdf, "products");
						$pdf->SetXY($product_names[$pos]['x'], $product_names[$pos]['y']);
						$pdf->Write(0, $recent_name);
						switchFont($pdf, "standard");
                        $pdf->SetXY($product_values_desinfection[$pos]['x'], $product_values_desinfection[$pos]['y']);
                        $pdf->Write(0, $quantity);
						$pos++;
                        }
                break;
                case 'Hygiene':
                    switchFont($pdf, "anhaken");
                    $pdf->SetXY($box_hygiene_x, $box_hygiene_y);
                    $pdf->Write(0, "x");
                    switchFont($pdf, "products");
					$pos = 1;
                    foreach ($product_full_data as $product_array) {
                        $recent_id = $product_array['id'];
						$recent_name = $product_array['name']." (".$product_array['pack_quantity'].") ";
                        $quantity = $product_array['quantity'];
                        $size = $product_array['size'];
                        $intolerance = $product_array['intolerance'];
						if ($recent_id == 10) {
                            setGloveProperties($pdf, $intolerance, $size, $bsipnx, $bsipny, $bsipvx, $bsipvy, $bsipnix, $bsipniy, $bsiplx, $bsiply, $bsspsx, $bsspsy, $bsspmx, $bsspmy, $bssplx, $bssply, $bsspex, $bsspey);
							switchFont($pdf, "standard");
                        	$pdf->SetXY($product_values_hygiene['10']['x'], $product_values_hygiene['10']['y']);
                        	$pdf->Write(0, $quantity);
							continue;
                        }
						switchFont($pdf, "products");
						$pdf->SetXY($product_names[$pos]['x'], $product_names[$pos]['y']);
						$pdf->Write(0, $recent_name);
						switchFont($pdf, "standard");
                        $pdf->SetXY($product_values_hygiene[$pos]['x'], $product_values_hygiene[$pos]['y']);
                        $pdf->Write(0, $quantity);
						$pos++;
                        }
                break;
                case 'Schutz':
                    switchFont($pdf, "anhaken");
                    $pdf->SetXY($box_protection_x, $box_protection_y);
                    $pdf->Write(0, "x");
                    switchFont($pdf, "products");
					$pos = 1;
                    foreach ($product_full_data as $product_array) {
                        $recent_id = $product_array['id'];
						$recent_name = $product_array['name']." (".$product_array['pack_quantity'].") ";
                        $quantity = $product_array['quantity'];
                        $size = $product_array['size'];
                        $intolerance = $product_array['intolerance'];
						if ($recent_id == 10) {
                            setGloveProperties($pdf, $intolerance, $size, $bsipnx, $bsipny, $bsipvx, $bsipvy, $bsipnix, $bsipniy, $bsiplx, $bsiply, $bsspsx, $bsspsy, $bsspmx, $bsspmy, $bssplx, $bssply, $bsspex, $bsspey);
							switchFont($pdf, "standard");
                        	$pdf->SetXY($product_values_protection['10']['x'], $product_values_protection['10']['y']);
                        	$pdf->Write(0, $quantity);
							continue;
                        }
						switchFont($pdf, "products");
						$pdf->SetXY($product_names[$pos]['x'], $product_names[$pos]['y']);
						$pdf->Write(0, $recent_name);
						switchFont($pdf, "standard");
                        $pdf->SetXY($product_values_protection[$pos]['x'], $product_values_protection[$pos]['y']);
                        $pdf->Write(0, $quantity);
						$pos++;                        
                        }
                break;
            }

            foreach ($squares1 as $square) {
                $pdf->Rect($square['x'], $square['y'], $square_size_x, $square_size_y, 'F');
            }
            if ($signed == 1) {
                // UNTERSCHRIFT
                if ($device == 0) {
					$pdf->Image($signature, $signature_second_page_x, $signature_second_page_y, 40, 0, 'PNG');
				} else {
					$pdf->Image($signature, $signature_second_page_x, $signature_second_page_y-4, 40, 0, 'PNG');
				}

            }

        }

		// ################################################################
		// ####################### SEITE 3 ################################
		// ################################################################

		$pageId3 = $pdf->importPage(3);

		$size3 = $pdf->getTemplateSize($pageId3);
	
		$pdf->AddPage('P', array($size3['width'], $size3['height']));
		$pdf->useTemplate($pageId3, 0, 0, $size3['width']);

		switchFont($pdf, "standard");
		$pos = 1;
		foreach ($product_full_data as $product_array) {
			switchFont($pdf, "anhaken_klein");
			$recent_id = $product_array['id'];
			$recent_name = $product_array['name']." (".$product_array['pack_quantity'].") ";
			$pos_number = $product_array['positionsnumber'];
			if ($recent_id == 10) {
    			$pdf->SetXY($generally_needed['10']['x'], $generally_needed['10']['y']);
				$pdf->Write(0, "X");
				continue;
               }
			
			$pdf->SetXY($generally_needed[$pos]['x'], $generally_needed[$pos]['y']);
			$pdf->Write(0, "X");
			switchFont($pdf, "products");
			$pdf->SetXY($generally_needed_text[$pos]['x'], $generally_needed_text[$pos]['y']);
			$pdf->Write(0, $recent_name);
			$pdf->SetXY($generally_needed_position_number[$pos]['x'], $generally_needed_position_number[$pos]['y']);
			$pdf->Write(0, $pos_number);
			$pos++;
		}
		switchFont($pdf, "standard");
		
		if ($bed_protectors_amount > 0) {
			$pdf->Rect($assumption_of_costs_bed_protection_x, $assumption_of_costs_bed_protection_y, $square_size_x, $square_size_y, 'F');
		}

		// SCHLEIFEN FÜR TEXT SCHREIBEN
		foreach ($fields2 as $field) {
			$pdf->SetXY($field['x'], $field['y']);
			$pdf->Write(0, $field['value']);
		}
	
		switchFont($pdf, "products");
		
		$pdf->SetXY($insured_person_phone_third_page_x, $insured_person_phone_third_page_y);
		$pdf->Write(0, $insured_person_phone);
	
		switchFont($pdf, "standard");

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
			if ($device == 0) {
					$pdf->Image($signature, $signature_third_page_x, $signature_third_page_y, 40, 0, 'PNG');
				} else {
					$pdf->Image($signature, $signature_third_page_x, $signature_third_page_y-4, 40, 0, 'PNG');
				}
		}

        if ($pdf_version == 0) {

			// ##################################################################
			// ####################### SEITE 4-6 ################################
			// ##################################################################

			$pageId4 = $pdf->importPage(4);
			$pageId5 = $pdf->importPage(5);
			$pageId6 = $pdf->importPage(6);

			$size4 = $pdf->getTemplateSize($pageId4);
			$size5 = $pdf->getTemplateSize($pageId5);
			$size6 = $pdf->getTemplateSize($pageId6);

			$pdf->AddPage('P', array($size4['width'], $size4['height']));
			$pdf->useTemplate($pageId4, 0, 0, $size4['width']);
			$pdf->AddPage('P', array($size5['width'], $size5['height']));
			$pdf->useTemplate($pageId5, 0, 0, $size5['width']);
			$pdf->AddPage('P', array($size6['width'], $size6['height']));
			$pdf->useTemplate($pageId6, 0, 0, $size6['width']);
		
		}


		// ################################################################
		// ####################### SEITE 7 ################################
		// ################################################################


		$pageId7 = $pdf->importPage(7);
		
		$size7 = $pdf->getTemplateSize($pageId7);
		
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
			if ($device == 0) {
                $pdf->Image($signature, $signature_seventh_page_x, $signature_seventh_page_y, 40, 0, 'PNG');
            } else {
                $pdf->Image($signature, $signature_seventh_page_x, $signature_seventh_page_y-4, 40, 0, 'PNG');
            }
		}


		if ($supplier_change == 1) {

			// ################################################################
			// ####################### SEITE 8 ################################
			// ################################################################

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
			switchFont($pdf, 'start');
			$pdf->SetXY($supplier_change_delivery_start_x, $supplier_change_delivery_start_y);

			if (!empty($supplier_change_delivery_start)) {
				$pdf->Write(0, $supplier_change_delivery_start);
			} else {
				$pdf->Write(0, "schnellstmöglich");
			}
			switchFont($pdf, 'standard');
			if ($signed == 1) {
				// UNTERSCHRIFT
				if ($device == 0) {
                    $pdf->Image($signature, $signature_eight_page_x, $signature_eight_page_y, 40, 0, 'PNG');
                } else {
                    $pdf->Image($signature, $signature_eight_page_x, $signature_eight_page_y-4, 40, 0, 'PNG');
                }
			}


		}
		if ($pdf_version == 0) {

			// ################################################################
			// ####################### SEITE 9 ################################
			// ################################################################

			$pageId9 = $pdf->importPage(9);

			$size9 = $pdf->getTemplateSize($pageId9);

			$pdf->AddPage('P', array($size9['width'], $size9['height']));
			$pdf->useTemplate($pageId9, 0, 0, $size9['width']);
		
		}

		// PDF wird generiert und geöffnet
		$prefix = 'impulsebox';
		$pdf_file_name = $prefix."_".$entry_number.".pdf";
		switch ($signed) {
			case 0:
				if ($download == 0) {
					ob_start();
					$pdf->Output($pdf_file_name, 'I');
				}
				if ($download == 1) {
					ob_start();
					$pdf->Output($pdf_file_name, 'D');
				}
				break;
			case 1: 
				$pdf->Output($path.$pdf_file_name, 'F');
				header("Location: ".BASEHREF."abschluss/");
				break;
		}
} else {
	echo "empty entry id";
}