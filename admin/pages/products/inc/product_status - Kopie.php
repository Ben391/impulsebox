<?php
include_once "../../../../inc/settings.php";
include_once "../../../../inc/dbconnect.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$product_id = $_POST["product_id"];
	$product_status = $_POST["product_status"];
	
	if ($product_status == 1 AND $product_id != 10) {
		// Query to count the active products excluding "Einmalhandschuhe"
		$check_sql = "SELECT COUNT(*) as active_count FROM products WHERE active = 1 AND id != 10";
		$check_result = $mysqli->query($check_sql);

		if ($check_result) {
			$row = $check_result->fetch_assoc();
			$active_count = $row['active_count'];

			// Check if the active count is greater than or equal to 9
			if ($active_count >= 9) {
				echo "Es können nicht mehr als 9 Produkte (exkl. Handschuhe) gleichzeitig aktiviert sein.";
				$mysqli->close();
				exit;
			}
		} else {
			echo "Fehler beim Überprüfen der aktiven Produkte: " . $mysqli->error;
			$mysqli->close();
			exit;
		}
	}
	
	
	$sql = "UPDATE products SET active = ? WHERE id = ?";

    $stmt = $mysqli->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("ii", $product_status, $product_id);
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