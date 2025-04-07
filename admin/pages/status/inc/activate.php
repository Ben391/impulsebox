<?php
include_once "../../../../inc/settings.php";
include_once "../../../../inc/dbconnect.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$id = $_POST["id"];
	$active = $_POST["active"];
	
	$sql = "UPDATE status_names SET active = ? WHERE id = ?";

    $stmt = $mysqli->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("ii", $active, $id);
        $result = $stmt->execute();

        if ($result) {
            echo "Produkt erfolgreich aktualisiert.";
        } else {
            echo "Fehler beim Aktualisieren: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Fehler beim Vorbereiten der SQL-Anfrage: " . $mysqli->error;
    }
}
$mysqli->close();