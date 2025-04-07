<?php
require_once "../../../../../inc/settings.php";
require_once "../../../../../inc/dbconnect.php";
require_once "../../../../../inc/functions.php";
require_once "../../../../inc/functions.php";
require_once "../import-settings.php";
if(isset($_POST["admin_id"]) AND !empty($_POST["admin_id"])) {
	if(isset($_POST["user_id"]) AND !empty($_POST["user_id"])) {
		if(isset($_POST["pdf_version"]) AND $_POST["pdf_version"] == 1) {
			$pdf_version = $_POST["pdf_version"];
		} else {
			$pdf_version = 0;
		}
		$user_id = $_POST["user_id"];
		$admin_id = $_POST["admin_id"];
		$care_giver_service_id = $_POST["care_giver_service_id"];
		$file = '../../files/' . $admin_id . '/import.csv';
		if(file_exists($file)) {
			// BOM entfernen
			$csv = file_get_contents($file);
			$bom = pack('H*','EFBBBF'); // UTF-8 BOM
			if (substr($csv, 0, 3) === $bom) {
				$csv = substr($csv, 3);
			}
			$handle = fopen('php://memory', 'r+');
			fwrite($handle, $csv);
			rewind($handle);
			if($handle !== FALSE) {
				fgetcsv($handle, 1500, ';');
				$create_date = time();
				$import_id = "IMP".$create_date;
				$skipReason = "";
				$row = 0;

				try {
					// create import main information
					if(!createImport($mysqli, $import_id, $admin_id)) {
						throw new Exception('Erstellen von Import Informationen fehlgeschlagen.');
					}
				} catch (Exception $e) {
					echo 'Fehler bei der Erstellung des Imports: ',  $e->getMessage(), "\n";
					exit;
				}

				while(($dataRow = fgetcsv($handle, 1500, ';')) !== FALSE) {
					$row++;
					$dataRow = array_map('cleanData', $dataRow);
					if(count($dataRow) == count($expectedHeaders)) {
						//echo "<pre>";print_r($dataRow);echo "</pre>";
						if(!array_filter($dataRow)) {
							continue;
						}
						$index = 0;
						$data = []; 
						foreach($expectedHeaders as $key => $header) {
							$data[$key] = "";
							if(!empty($dataRow[$index])) {
								if($key == 'insured_person_salutation') {
									switch($dataRow[$index]) {
										case "Frau":
											$dataRow[$index] = 2;
											break;
										case "Herr":
											$dataRow[$index] = 1;
											break;
										case "Divers":
											$dataRow[$index] = 3;
											break;
										default:
											$dataRow[$index] = 0;
									}
								}
								if($key == 'insurance_type') {
									switch($dataRow[$index]) {
										case "gesetzlich":
											$dataRow[$index] = 1;
											break;
										case "privat":
											$dataRow[$index] = 2;
											break;
										default:
											$dataRow[$index] = "";
									}
								}
								if($key == 'insurance_aid') {
									switch($dataRow[$index]) {
										case "ja":
											$dataRow[$index] = 1;
											break;
										default:
											$dataRow[$index] = 0;
									}
								}
								if($key == 'supplier_change') {
									switch($dataRow[$index]) {
										case "Y":
											$dataRow[$index] = 1;
											break;
										default:
											$dataRow[$index] = 0;
									}
								}
								$data[$key] = $dataRow[$index];
							}
							$index++;
						}
						if (isset($data['insured_person_street']) && isset($data['insured_person_house_number'])) {
							$data['insured_person_street'] = $data['insured_person_street'] . ' ' . $data['insured_person_house_number'];
							unset($data['insured_person_house_number']); 
						}

						$data["bed_protectors_amount"] = 4;
						$data["products"] = '{"1":{"quantity":"1","size":"","intolerance":""},"2":{"quantity":"1","size":"","intolerance":""},"3":{"quantity":"1","size":"","intolerance":""},"4":{"quantity":"1","size":"","intolerance":""},"5":{"quantity":"1","size":"","intolerance":""},"6":{"quantity":"1","size":"","intolerance":""},"7":{"quantity":"1","size":"","intolerance":""},"8":{"quantity":"1","size":"","intolerance":""},"9":{"quantity":"1","size":"","intolerance":""},"10":{"quantity":"1","size":"s","intolerance":""}}';
						$data['compilation_name'] = "Individuell";
						$data['insurance_company_id'] = 0;
						$data['care_level_since'] = "";
						$data['import_id'] = $import_id;
						$data['care_giver_service_id'] = $care_giver_service_id;
						$data['user_id'] = $user_id;
						//echo "<pre>";print_r($data);echo "</pre>";
						try {
							if($entry_id = executeImport($mysqli, $data)) {
								// PDF generieren
								$url = BASEHREF . 'inc/PDF/createPDF.php';
								$url .= '?file_name=test&entry_id=' . urlencode($entry_id) . '&signed_status=1&pdf_version='.$pdf_version;
								$pdfResult = file_get_contents($url);
								
							} else {
								echo 'Ein Fehler ist aufgetreten.';
							}
						} catch (Exception $e) {
							echo 'Fehler beim Import: ',  $e->getMessage(), "\n";
						}
						header("Location:".ADMIN_BASEHREF."import/?import_id=".$import_id);
					}
				}

				fclose($handle);
			} else {
				echo "err3";
			}
		} else {
			echo "err2";
		}
	} else {
	   echo "User ID ist nicht gesetzt";
	   exit;
	}
} else {
	echo "err1";
}