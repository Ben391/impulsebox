<?php
header('Content-Type: application/json');
include_once "../../../inc/settings.php";
include_once "../../../inc/dbconnect.php";
include_once "../../../inc/functions.php";

$response = [
    'success' => false,
    'message' => 'Unbekannter Fehler'
];

try {
	// falls eingeloggt
	if(!empty($_POST["insured_person_id"])) {
		$requiredFields = [
			'user_type',
			'user_id',
			'entry_id',
			'agreement_id',
		];
		$optionalFields = [
			'agreement_marketing',
		];
		$missingFields = [];
		$data = [];
		if (checkFields($requiredFields, $optionalFields, $data, $missingFields)) {
			updateAccount($mysqli, $data);
				
			$agreement_id = isset($data['agreement_id']) ? $data['agreement_id'] : NULL;
			$marketing = isset($data['agreement_marketing']) ? $data['agreement_marketing'] : NULL;
			$entry_id = $data['entry_id'];
			insertAgreements($mysqli, $agreement_id, $entry_id, $marketing);
				
			echo json_encode(['success' => true, 'message' => 'Daten wurden erfolgreich gespeichert']);
			exit;
		} else {
			echo json_encode(['success' => false, 'message' => 'Fehlende Daten', 'missingFields' => $missingFields]);
			exit;
		}
	// falls nicht eingeloggt
	} else {		
		$requiredFields = [
			'user_type',
			'user_email',
			'insured_person_email',
			'insured_person_phone',
			'products',
			'compilation_name',
			'bed_protectors_amount',
			'insured_person_salutation',
			'insured_person_first_name',
			'insured_person_last_name',
			'insured_person_birth_date',
			'insurance_type',
			'insurance_number',
			'care_level',
			'insured_person_street',
			'insured_person_zipcode',
			'insured_person_city',
		];
		$optionalFields = [
			'insurance_company_id',
			'agreement_marketing',
			'care_level_since',
			'insured_person_address_addition',
			'custom_insurance_company',
			'custom_insurance_company_name',
		];
		$missingFields = [];
		$data = [];
		
		if (checkFields($requiredFields, $optionalFields, $data, $missingFields)) {
			createAccount($mysqli, $data);
			echo json_encode(['success' => true, 'message' => 'Daten wurden erfolgreich gespeichert']);
			exit;
		} else {
			echo json_encode(['success' => false, 'message' => 'Fehlende Daten', 'missingFields' => $missingFields]);
			exit;
		}
	} 
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => '', 'details' => $e->getMessage()]);
    exit;
}