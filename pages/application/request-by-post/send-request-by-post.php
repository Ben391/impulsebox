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
    // Daten von POST Request validieren und bereinigen
    $entry_id = filter_input(INPUT_POST, 'entry_id', FILTER_SANITIZE_NUMBER_INT);
    $user_id = filter_input(INPUT_POST, 'user_id', FILTER_SANITIZE_NUMBER_INT);
    $user_email = filter_input(INPUT_POST, 'user_email', FILTER_SANITIZE_EMAIL);
	$sending_on = filter_input(INPUT_POST, 'delivery', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    // Überprüfen, ob die bereinigten Daten gültig sind
    if (!$entry_id || !$user_id || !$user_email || !$sending_on) {
        throw new Exception('Eingabedaten sind unvollständig oder ungültig.');
    }

    $data = [
        'entry_id' => $entry_id,
        'user_id'  => $user_id,
        'user_email'  => $user_email,
        'sending_on'  => $sending_on
    ];

    // Datenbankfunktion zur Verarbeitung der Daten
    requestByPost($mysqli, $data);

	$signed_status = 1;
	$pdf_version = 0;
	$pdf_number = "";
	$download_file = 2; // save file
	if(createPDF($entry_id, $signed_status, $pdf_version, $pdf_number, $download_file)) {
		// Erfolgsmeldung setzen
		$response['success'] = true;
		$response['message'] = 'Daten erfolgreich gespeichert und PDF generiert.';
	} else {
		// Erfolgsmeldung setzen
		$response['success'] = false;
		$response['message'] = 'Error.';
	}
	
} catch (Exception $e) {
    http_response_code(500);
    $response['message'] = 'Fehler beim Speichern der Daten.';
    $response['details'] = $e->getMessage();
}

// JSON-Antwort senden
echo json_encode($response);
