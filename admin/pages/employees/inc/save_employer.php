<?php
include_once "../../../../inc/settings.php";
include_once "../../../../inc/dbconnect.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = $_POST["first_name"];
    $last_name = $_POST["last_name"];
    $employer_email = $_POST["employer_email"];

    // Überprüfen, ob die E-Mail-Adresse bereits existiert
    $sql = "SELECT email FROM admins WHERE email = ?";
    $stmt = $mysqli->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("s", $employer_email);
        $stmt->execute();
        $stmt->store_result();
        
        if ($stmt->num_rows > 0) {
            echo "E-Mail-Adresse existiert bereits.";
        } else {
            // Führen Sie das Einfügen aus, wenn die E-Mail nicht existiert
            $sql_insert = "INSERT INTO admins (active, first_name, last_name, email) VALUES (1, ?, ?, ?)";
            $stmt_insert = $mysqli->prepare($sql_insert);
            if ($stmt_insert) {
                $stmt_insert->bind_param("sss", $first_name, $last_name, $employer_email);
                $result = $stmt_insert->execute();

                if ($result) {
                    echo "Mitarbeiter erfolgreich gespeichert.";
                } else {
                    echo "Fehler beim Speichern: " . $stmt_insert->error;
                }
                $stmt_insert->close();
            } else {
                echo "Fehler beim Vorbereiten der SQL-Anfrage: " . $mysqli->error;
            }
        }
        $stmt->close();
    } else {
        echo "Fehler beim Vorbereiten der SQL-Anfrage: " . $mysqli->error;
    }
}
$mysqli->close();