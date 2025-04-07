<?php
include_once "../../../../inc/settings.php";
include_once "../../../../inc/dbconnect.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id"];
    $newPrice = $_POST["price"];

    $sql = "UPDATE products SET price = ? WHERE id = ?";
    $stmt = $mysqli->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("si", $newPrice, $id);
        $result = $stmt->execute();

        if ($result) {
            echo "Preis erfolgreich aktualisiert.";
        } else {
            echo "Fehler beim Aktualisieren des Preises: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Fehler beim Vorbereiten der SQL-Anfrage: " . $mysqli->error;
    }
}

// Schließen der Datenbankverbindung
$mysqli->close();
?>
