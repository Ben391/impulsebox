<?php
include_once "../../../../inc/settings.php";
include_once "../../../../inc/dbconnect.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $impressum = isset($_POST['impressum']) ? $_POST['impressum'] : '';
    $agb = isset($_POST['agb']) ? $_POST['agb'] : '';
    $datenschutz = isset($_POST['datenschutz']) ? $_POST['datenschutz'] : '';
	$widerrufsrecht = isset($_POST['widerrufsrecht']) ? $_POST['widerrufsrecht'] : '';

    $impressum = htmlspecialchars($impressum, ENT_QUOTES, 'UTF-8');
    $agb = htmlspecialchars($agb, ENT_QUOTES, 'UTF-8');
    $datenschutz = htmlspecialchars($datenschutz, ENT_QUOTES, 'UTF-8');

    $sql_check = "SELECT COUNT(*) FROM rechtliches";
    $result = $mysqli->query($sql_check);
    $row = $result->fetch_row();
    
    if ($row[0] > 0) {
        $sql = "UPDATE rechtliches SET impressum = ?, agb = ?, datenschutz = ?, widerrufsrecht = ? WHERE id = 1";
    } else {
        $sql = "INSERT INTO rechtliches (impressum, agb, datenschutz, widerrufsrecht) VALUES (?, ?, ?, ?)";
    }

    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("ssss", $impressum, $agb, $datenschutz, $widerrufsrecht);
    $stmt->execute();
    $stmt->close();

    echo 'Daten erfolgreich gespeichert.';
} else {
    echo 'Ungültige Anfrage.';
}