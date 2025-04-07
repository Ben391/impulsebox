<?php
header('Content-Type: application/json');
include_once "../../../inc/settings.php";
include_once "../../../inc/dbconnect.php";
include_once "../../../inc/functions.php";

$requiredFields = [
	'insured_person_salutation',
	'insured_person_first_name',
	'insured_person_last_name',
	'insured_person_birth_date',
	'insured_person_phone',
	'insurance_type',
	'insurance_number',
	'care_level',
	'insured_person_street',
	'insured_person_zipcode',
	'insured_person_city',
	'insurance_company_id',
];

if(
	isset($_POST["custom_insurance_company"]) AND 
	$_POST["custom_insurance_company"] == 1 AND 
	isset($_POST["custom_insurance_company_name"]) AND 
	!empty($_POST["custom_insurance_company_name"])
) {
	$_POST["insurance_company_id"] = 0;
} else {
	$requiredFields[] = 'insurance_company_id';
	$_POST["custom_insurance_company_name"] = "";
}

$optionalFields = [
	'insured_person_email',
	'insured_person_address_addition',
	'insurance_aid',
	'care_level_since',
	'custom_insurance_company_name',
];

$missingFields = [];
$data = [];

if(isLoggedIn() OR isLoggedInAsAdmin()) {
	
	$requiredFields[] = 'insured_person_id';
	$requiredFields[] = 'insured_person_address_id';
	
    if (checkFields($requiredFields, $optionalFields, $data, $missingFields)) {
        try {
            updateInsuredPersonData($mysqli, $data);
            echo json_encode(['success' => true, 'message' => 'Daten wurden erfolgreich gespeichert']);
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => 'Fehler beim Speichern der Daten', 'details' => $e->getMessage()]);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Fehlende Daten', 'missingFields' => $missingFields]);
    }
} else {
	
    if (checkFields($requiredFields, $optionalFields, $data, $missingFields)) {
        $_SESSION['insured_person_data'] = $data;
        echo json_encode(['success' => true, 'message' => 'Daten wurden erfolgreich gespeichert']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Fehlende Daten', 'missingFields' => $missingFields]);
    }
}