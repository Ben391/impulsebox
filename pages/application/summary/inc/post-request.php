<?php
header('Content-Type: application/json');
include_once "../../../../inc/settings.php";
include_once "../../../../inc/dbconnect.php";
include_once "../../../../inc/functions.php";

$response = [
    'success' => false,
    'message' => 'Unbekannter Fehler'
];

try {
	
	$data = [
		'entry_id' => $_POST['entry_id'],
		'user_id'  => $_POST["user_id"],
		'user_email'  => $_POST["user_email"],
		'insurance_type' => $_POST["insurance_type"]
	];

    requestByPost($mysqli, $data);

    $response['success'] = true;
    $response['message'] = "";
    
} catch (Exception $e) {
    $response['message'] = "Fehler beim Speichern der Daten.";
    $response['details'] = $e->getMessage();
}
echo json_encode($response);