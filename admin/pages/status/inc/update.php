<?php
include_once "../../../../inc/settings.php";
include_once "../../../../inc/dbconnect.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$id = $_POST["id"];
	$status_id = $_POST["status_id"];
	$shortname = $_POST["shortname"];
	$fullname = $_POST["fullname"];
	
	$sql = "UPDATE status_names SET status_id = ?, short_name = ?, name = ? WHERE id = ?";

    $stmt = $mysqli->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("issi", $status_id, $shortname, $fullname, $id);
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