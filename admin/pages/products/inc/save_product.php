<?php
include_once "../../../../inc/settings.php";
include_once "../../../../inc/dbconnect.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$price = $_POST["price"];
    $pack_quantity = $_POST["pack_quantity"];
    $name = $_POST["name"];
	$short_name = $_POST["short_name"];
    $description = $_POST["description"];
    $positionsnumber = $_POST["positionsnumber"];

    $sql = "INSERT INTO products (name, short_name, pack_quantity, description, positionsnumber, price) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $mysqli->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("ssssss", $name, $short_name, $pack_quantity, $description, $positionsnumber, $price);
        $result = $stmt->execute();

        if ($result) {
            echo "Produkt erfolgreich gespeichert.";
        } else {
            echo "Fehler beim Speichern: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Fehler beim Vorbereiten der SQL-Anfrage: " . $mysqli->error;
    }
}
$mysqli->close();
