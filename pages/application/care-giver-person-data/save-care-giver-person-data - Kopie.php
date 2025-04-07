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
	$data = [
		'insured_person_id' 	=> $_POST["insured_person_id"],
		'care_giver_type' 		=> 2,
		'care_giver_company' 	=> "",
		'care_giver_salutation' => $_POST["care_giver_salutation"],
		'care_giver_first_name' => $_POST["care_giver_first_name"],
		'care_giver_last_name' 	=> $_POST["care_giver_last_name"],
		'care_giver_street' 	=> $_POST["care_giver_street"],
		'care_giver_address_addition' 	=> $_POST["care_giver_address_addition"],
		'care_giver_zipcode' 	=> $_POST["care_giver_zipcode"],
		'care_giver_city' 		=> $_POST["care_giver_city"],
		'care_giver_phone' 		=> $_POST["care_giver_phone"],
		'care_giver_email' 		=> $_POST["care_giver_email"],	
	];

    saveCareGiverData($mysqli, $data);

    $response['success'] = true;
    $response['message'] = "Daten wurden erfolgreich gespeichert!";
    
} catch (Exception $e) {
    $response['message'] = "Fehler beim Speichern der Daten.";
    $response['details'] = $e->getMessage();
}
echo json_encode($response);