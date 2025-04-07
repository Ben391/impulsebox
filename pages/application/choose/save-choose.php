<?php
include_once "../../../inc/settings.php";
include_once "../../../inc/dbconnect.php";
include_once "../../../inc/functions.php";
$response = [
	'success' => false,
	'message' => 'Unbekannter Fehler'
];
header('Content-Type: application/json');
if(isLoggedIn() OR isLoggedInAsAdmin()) {
	if(!$compilation_name = findMatchingCompilation($mysqli, $_POST["product_data_json"])) {
		$compilation_name = "Individuell";
	}
	try {
		$data = [
			'products' => $_POST["product_data_json"],
			'compilation_name' => $compilation_name,
			'bed_protectors_amount' => $_POST["bed_protectors_amount"],
			'entry_id' => $_POST["entry_id"],
			'user_id' => $_POST["user_id"],
		];
		updateChoose($mysqli, $data);
		$response['success'] = true;
		$response['message'] = "Daten wurden erfolgreich gespeichert!";
	} catch (Exception $e) {
		$response['message'] = "Fehler beim Speichern der Daten.";
		$response['details'] = $e->getMessage();
	}
} else {
	if(isset($_POST['product_data']) && is_array($_POST['product_data'])) {
		$_SESSION['product_data'] = $_POST['product_data'];
	}
	if(isset($_POST['product_data_json']) && is_array($_POST['product_data_json'])) {
		$_SESSION['products'] = json_encode($_POST['product_data_json']);
		if(!$_SESSION['compilation_name'] = findMatchingCompilation($mysqli, $_SESSION['products'])) {
			$_SESSION['compilation_name'] = "Individuell";
		}
	}
	if(isset($_POST["bed_protectors_amount"])) {
		$_SESSION["bed_protectors_amount"] = $_POST["bed_protectors_amount"];
	}
	$response['success'] = true;
	$response['message'] = "Daten wurden erfolgreich gespeichert!";
}
echo json_encode($response);