<?php
include_once "../../../../inc/settings.php";
include_once "../../../../inc/dbconnect.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $pack_quantity = $_POST["pack_quantity"];
    $price = $_POST["price"];

    $sql = "INSERT INTO products (name, pack_quantity, price) VALUES (?, ?, ?)";
    $stmt = $mysqli->prepare($sql);
    
    if ($stmt) {
        $stmt->bind_param("sss", $name, $pack_quantity, $price);
        $result = $stmt->execute();
        
        if ($result) {
            echo "Produkt erfolgreich gespeichert.";
        } else {
            echo "Fehler beim Speichern des Produkts" . $stmt->error;
        }
        
        $stmt->close();
    } else {
        echo "Fehler beim Vorbereiten der SQL-Anfrage" . $stmt->error;
    }
}

// Schließen der Datenbankverbindung
$mysqli->close();
?>
