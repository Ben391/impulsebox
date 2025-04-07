<?php
include_once "settings.php";
include_once "dbconnect.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $max_price = $_POST['max_price'];
    $min_price = $_POST['min_price'];
    
    // Daten aktualisieren
    $sql = "UPDATE settings SET compilation_max_total_price='$max_price', compilation_min_total_price='$min_price'";
    $mysqli->query($sql);
} else {
    // Daten abrufen
    $sql = "SELECT compilation_max_total_price, compilation_min_total_price FROM settings";
    $result = $mysqli->query($sql);
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        echo json_encode($row);
    } else {
        echo json_encode(["error" => "Keine Daten gefunden"]);
    }
}

$mysqli->close();
