<?php
header('Content-Type: application/json');
include_once "../../../inc/settings.php";
include_once "../../../inc/dbconnect.php";
include_once "../../../inc/functions.php";

$missingFields = [];
$data = [];
$requiredFields = [
	'entry_id',
	'consultation-status'
];
$optionalFields = [
	'consultation-form',
	'consultation-partner',
	'consultant',
	'consultant',
	'consultation_date'
];
if(checkFields($requiredFields, $optionalFields, $data, $missingFields)) {
	try {

		save_consultation($mysqli, $data);
		echo json_encode(['success' => true, 'message' => 'Daten wurden erfolgreich gespeichert']);

	} catch (Exception $e) {
		echo json_encode(['success' => false, 'message' => 'Fehler beim Speichern der Daten', 'details' => $e->getMessage()]);
	}
} else {
	echo json_encode(['success' => false, 'message' => 'Fehlende Daten', 'missingFields' => $missingFields]);
}