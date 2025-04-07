<?php
header('Content-Type: application/json');
include_once "../../../inc/settings.php";
include_once "../../../inc/dbconnect.php";
include_once "../../../inc/functions.php";

$response = [
    'success' => false,
    'message' => 'Unbekannter Fehler'
];

if(isset($_POST["supplier_change"])) {
	$supplier_change = $_POST["supplier_change"];
} else {
	$supplier_change = 0;
}

try {
   	
	$data = [
		'entry_id' => $_POST['entry_id'],
		'user_id' => $_POST['user_id'],
		'insured_person_id' => $_POST["insured_person_id"],
		'delivery' => $_POST["delivery"],
		'delivery_frequency' => $_POST["delivery_frequency"],
		'supplier_change' => $supplier_change,
		'supplier_change_delivery_start' => $_POST["supplier_change_delivery_start"],
	];

    saveDelivery($mysqli, $data);

    $response['success'] = true;
    $response['message'] = "Daten wurden erfolgreich gespeichert!";
    
} catch (Exception $e) {
    $response['message'] = "Fehler beim Speichern der Daten.";
    $response['details'] = $e->getMessage();
}
echo json_encode($response);