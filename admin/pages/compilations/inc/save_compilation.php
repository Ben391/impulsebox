<?php
include_once "../../../../inc/settings.php";
include_once "../../../../inc/dbconnect.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $compilation = $_POST["compilation"];
    $name = $_POST["name"];

    $sql = "INSERT INTO compilations (name, products) VALUES (?, ?)";
    $stmt = $mysqli->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("ss", $name, $compilation);
        $result = $stmt->execute();

        if ($result) {
            echo "Zusammenstellung erfolgreich gespeichert.";
        } else {
            echo "Fehler beim Speichern der Zusammenstellung: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Fehler beim Vorbereiten der SQL-Anfrage: " . $mysqli->error;
    }
}
$mysqli->close();