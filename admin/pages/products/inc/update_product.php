<?php
include_once "../../../../inc/settings.php";
include_once "../../../../inc/dbconnect.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$product_id = $_POST["product_id"];
	$product_name = $_POST["product_name"];
	$product_short_name = $_POST["product_short_name"];
	$product_description = $_POST["product_description"];
	$product_pack_quantity = $_POST["product_pack_quantity"];
	$price = $_POST["price"];
	$product_positionsnumber = $_POST["product_positionsnumber"];
	
	$sql = "UPDATE products SET name = ?, short_name = ?, pack_quantity = ?, description = ?, positionsnumber = ?, price = ? WHERE id = ?";

    $stmt = $mysqli->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("ssssssi", $product_name, $product_short_name, $product_pack_quantity, $product_description, $product_positionsnumber, $price, $product_id);
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