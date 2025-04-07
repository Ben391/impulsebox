<?php
// Fehlerberichterstattung aktivieren
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include_once '../../../inc/dbconnect.php';

$response = [];

if (isset($_POST['data'], $_POST['entryId']) && !empty($_POST['data']) && !empty($_POST['entryId'])) {
    
    $data = json_decode($_POST['data'], true);
    $entryId = $_POST['entryId'];

    // Transaktion starten
    $mysqli->begin_transaction();

    try {
        $stmt = $mysqli->prepare("UPDATE entries SET products = ? WHERE id = ?");
        if ($stmt) {
            $jsonData = json_encode($data);
            $stmt->bind_param('ss', $jsonData, $entryId);
            
            if (!$stmt->execute()) {
                throw new Exception("Statement konnte nicht ausgeführt werden: " . $stmt->error);
            }
            
            $stmt->close();

            // Transaktion commiten
            $mysqli->commit();

            $response['success'] = true;
        } else {
            throw new Exception("Statement konnte nicht vorbereitet werden: " . $mysqli->error);
        }
    } catch (Exception $e) {
        // Transaktion zurückrollen
        $mysqli->rollback();

        $response['error'] = $e->getMessage();
    }
} else {
    $response['error'] = "Ungültige oder fehlende Daten im POST-Request.";
}

echo json_encode($response);

$mysqli->close();

