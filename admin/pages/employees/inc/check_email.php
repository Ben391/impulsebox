<?php
include_once "../../../../inc/settings.php";
include_once "../../../../inc/dbconnect.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Die E-Mail-Adresse aus der AJAX-Anfrage holen
    $employer_email = $_POST['email'];

    // SQL-Anfrage vorbereiten, um zu prüfen, ob die E-Mail bereits existiert
    $sql = "SELECT email FROM admins WHERE email = ?";
    $stmt = $mysqli->prepare($sql);

    if ($stmt) {
        // Die E-Mail-Adresse an die Anfrage binden
        $stmt->bind_param("s", $employer_email);
        $stmt->execute();
        $stmt->store_result();

        // Überprüfen, ob die E-Mail-Adresse gefunden wurde
        if ($stmt->num_rows > 0) {
            echo 'exists'; // Antwort an AJAX, wenn die E-Mail existiert
        } else {
            echo 'not_exists'; // Antwort an AJAX, wenn die E-Mail nicht existiert
        }
        $stmt->close();
    } else {
        echo 'error'; // Antwort an AJAX im Fehlerfall
    }
    $mysqli->close();
}