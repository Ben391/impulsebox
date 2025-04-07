<?php
include_once "../../../../inc/settings.php";
include_once "../../../../inc/dbconnect.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $product_id = $_POST["product_id"];
    $product_status = $_POST["product_status"];

    // Wenn das Produkt deaktiviert werden soll, überprüfen, ob es Teil einer aktiven Zusammenstellung ist
    if ($product_status == 0) {
        $check_compilation_sql = "SELECT id, name FROM compilations WHERE active = 1 AND JSON_UNQUOTE(JSON_EXTRACT(products, '$.\"$product_id\"')) IS NOT NULL";
        $compilation_result = $mysqli->query($check_compilation_sql);

        if ($compilation_result === false) {
            echo "Fehler beim Überprüfen der Zusammenstellungen: " . $mysqli->error;
            $mysqli->close();
            exit;
        }

        if ($compilation_result->num_rows > 0) {
			$compilation = $compilation_result->fetch_assoc();
            echo "Artikel kann nicht deaktiviert werden, da er in der aktiven Zusammenstellung \"" . $compilation['name'] . "\" ist.";
            $mysqli->close();
            exit;
        }
    }

    // If product is to be activated, perform the active products check
    if ($product_status == 1 && $product_id != 14) {
        $check_sql = "SELECT COUNT(*) as active_count FROM products WHERE active = 1 AND id != 14";
        $check_result = $mysqli->query($check_sql);

        if ($check_result) {
            $row = $check_result->fetch_assoc();
            $active_count = $row['active_count'];

            if ($active_count >= 13) {
                echo "Es können nicht mehr als 13 Produkte (inkl. Handschuhe) gleichzeitig aktiviert sein.";
                $mysqli->close();
                exit;
            }
        } else {
            echo "Fehler beim Überprüfen der aktiven Produkte: " . $mysqli->error;
            $mysqli->close();
            exit;
        }
    }

    // Update product status
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
