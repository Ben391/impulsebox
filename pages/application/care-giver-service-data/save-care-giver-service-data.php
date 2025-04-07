<?php
header('Content-Type: application/json');
include_once "../../../inc/settings.php";
include_once "../../../inc/dbconnect.php";
include_once "../../../inc/functions.php";

$missingFields = [];
$data = [];

if(isset($_POST["care_giver_id"]) AND !empty($_POST["care_giver_id"])) {
	
	$requiredFields = [
		'care_giver_type',
		'care_giver_id',
		'care_giver_address_id',
		'care_giver_street',
		'care_giver_zipcode',
		'care_giver_city',
		'care_giver_phone',
		'care_giver_email',
	];

	$optionalFields = [
		'insured_person_id',
		'care_giver_company',
		'care_giver_salutation',
		'care_giver_first_name',
		'care_giver_last_name',
		'care_giver_address_addition',
	];
	
	if(checkFields($requiredFields, $optionalFields, $data, $missingFields)) {
		try {
			
			updateCareGiverAllData($mysqli, $data);
			echo json_encode(['success' => true, 'message' => 'Daten wurden erfolgreich gespeichert']);

		} catch (Exception $e) {
			echo json_encode(['success' => false, 'message' => 'Fehler beim Speichern der Daten', 'details' => $e->getMessage()]);
		}
	} else {
		echo json_encode(['success' => false, 'message' => 'Fehlende Daten', 'missingFields' => $missingFields]);
	}
} else {
	
	$requiredFields = [
		'insured_person_id',
		'care_giver_street',
		'care_giver_zipcode',
		'care_giver_city',
		'care_giver_phone',
		'care_giver_email',
	];

	$optionalFields = [
		'care_giver_type',
		'care_giver_id',
		'care_giver_address_id',
		'care_giver_company',
		'care_giver_salutation',
		'care_giver_first_name',
		'care_giver_last_name',
		'care_giver_address_addition',
	];
	
	if(checkFields($requiredFields, $optionalFields, $data, $missingFields)) {
		try {
			
			saveCareGiverData($mysqli, $data);
			echo json_encode(['success' => true, 'message' => 'Daten wurden erfolgreich gespeichert']);

		} catch (Exception $e) {
			echo json_encode(['success' => false, 'message' => 'Fehler beim Speichern der Daten', 'details' => $e->getMessage()]);
		}
	} else {
		echo json_encode(['success' => false, 'message' => 'Fehlende Daten', 'missingFields' => $missingFields]);
	}
	
}