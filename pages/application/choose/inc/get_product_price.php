<?php
include_once '../../../../inc/settings.php';
include_once '../../../../inc/dbconnect.php';

// Überprüfung, ob die 'product_id'-Variable im GET-Request gesetzt ist
if (isset($_GET['product_id'])) {
    $product_id = intval($_GET['product_id']);

    // Vorbereitung des SQL-Statements, um SQL-Injections zu verhindern
    $stmt = $mysqli->prepare("SELECT price FROM products WHERE id = ?");

    // Überprüfung, ob die Vorbereitung des SQL-Statements erfolgreich war
    if (!$stmt) {
        echo "SQL Vorbereitungsfehler: " . $mysqli->error;
        exit;
    }

    // Binden der Parameter
    $stmt->bind_param('i', $product_id);

    // Ausführen des SQL-Statements und Überprüfung auf Fehler
    if ($stmt->execute()) {
        $result = $stmt->get_result();
          
        // Überprüfen, ob Datensätze gefunden wurden
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            echo $row['price'];
        } else {
            echo "Kein Produkt mit dieser ID gefunden.";
        }
    } else {
        echo "Fehler bei der Ausführung: " . $stmt->error;
    }

    // Schließen des Statements
    $stmt->close();
} else {
    echo "invalid_request";
}

// Schließen der Datenbankverbindung
$mysqli->close();
?>
