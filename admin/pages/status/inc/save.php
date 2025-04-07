<?php
include_once "../../../../inc/settings.php";
include_once "../../../../inc/dbconnect.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$status_id = $_POST["status_id"];
	$shortname = $_POST["short_name"];
	$fullname = $_POST["fullname"];
	
	$sql = "INSERT INTO status_names (short_name, name, status_id) VALUES (?, ?, ?)";

    $stmt = $mysqli->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("ssi", $shortname, $fullname, $status_id);
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
