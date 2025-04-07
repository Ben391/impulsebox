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
    $sending_on = filter_input(INPUT_POST, 'delivery', FILTER_SANITIZE_STRING);

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

    // PDF-Generation URL zusammenstellen
    $url = BASEHREF . 'inc/PDF/createPDF.php';
    $url .= '?file_name=test&entry_id=' . urlencode($entry_id) . '&signed_status=1&pdf_version=0';

    // Prüfung, ob die PDF-URL erreichbar ist
    $headers = get_headers($url);
    if (!strpos($headers[0], "200")) {
        throw new Exception('PDF-Service nicht erreichbar oder Fehler in der Antwort: ' . $headers[0]);
    }

    // Sicherer Abruf der generierten PDF-Datei
    $pdfResult = file_get_contents($url);
    if ($pdfResult === false || strlen($pdfResult) < 100) { // Prüfen, ob die PDF-Antwort zu kurz ist
        throw new Exception('PDF konnte nicht generiert werden. Antwort zu kurz oder fehlerhaft.');
    }

    // Erfolgsmeldung setzen
    $response['success'] = true;
    $response['message'] = 'Daten erfolgreich gespeichert und PDF generiert.';

} catch (Exception $e) {
    http_response_code(500);
    $response['message'] = 'Fehler beim Speichern der Daten.';
    $response['details'] = $e->getMessage();
}

// JSON-Antwort senden
echo json_encode($response);
