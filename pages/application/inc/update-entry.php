<?php
include_once '../../../inc/dbconnect.php';

if(isset($_POST['entryId']) && isset($_POST['products'])) {
    $entryId = $_POST['entryId'];
	$selected_products = json_decode($_POST['products'], true);
	$json_data = json_encode($selected_products);

    $stmt = $mysqli->prepare("UPDATE entries SET products = ? WHERE id = ?");
    $stmt->bind_param('si', $json_data, $entryId);

    if ($stmt->execute()) {
        echo "Erfolgreich aktualisiert!";
    } else {
        echo "Fehler: " . $stmt->error;
    }

    $stmt->close();
}

$mysqli->close();