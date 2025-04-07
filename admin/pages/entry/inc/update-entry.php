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

	$status_date = time();
	$send_mail = isset($_POST['send_mail']) && filter_var($_POST['send_mail'], FILTER_VALIDATE_BOOLEAN);
	//insertApplicationStatus($mysqli, $_POST["entry_id"], $_POST["status_id"], $status_date, $send_mail);
	
	$data = [];
	$data["entry_id"] = $_POST["entry_id"];
	$data["status_id"] = $_POST["status_id"];
	$data["status_date"] = $status_date;
	$data["send_mail"] = $send_mail;
	
	insertApplicationStatus($mysqli, $data);
    $response['success'] = true;
    $response['message'] = "Daten wurden erfolgreich gespeichert!";
    
} catch (Exception $e) {
    $response['message'] = "Fehler beim Speichern der Daten.";
    $response['details'] = $e->getMessage();
}
echo json_encode($response);
