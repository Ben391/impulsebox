<?php
include_once "../../../../inc/settings.php";
include_once "../../../../inc/dbconnect.php";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$id = $_POST["id"];
	$name = $_POST["name"];
	$street = $_POST["street"];
	$address_addition = $_POST["address_addition"];
	$zipcode = $_POST["zipcode"];
	$city = $_POST["city"];
	$phone = $_POST["phone"];
	$email = $_POST["email"];
	$address_id = $_POST["address_id"];

	$mysqli->begin_transaction();

	try {
		// Update care_giver_data
		$sql1 = "UPDATE care_giver_data SET company = ? WHERE id = ?";
		$stmt1 = $mysqli->prepare($sql1);
		if ($stmt1) {
			$stmt1->bind_param("si", $name, $id);
			$result1 = $stmt1->execute();
			$stmt1->close();
		} else {
			throw new Exception("Aktualisierung des Namens fehlgeschlagen: " . $mysqli->error);
		}

		// Update addresses
		$sql2 = "UPDATE addresses SET street = ?, address_addition = ?, zipcode = ?, city = ? WHERE id = ?";
		$stmt2 = $mysqli->prepare($sql2);
		if ($stmt2) {
			$stmt2->bind_param("ssisi", $street, $address_addition, $zipcode, $city, $address_id);
			$result2 = $stmt2->execute();
			$stmt2->close();
		} else {
			throw new Exception("Aktualisierung der Straße, Straßenzusatz, PLZ oder der Stadt fehlgeschlagen: " . $mysqli->error);
		}

		// Update contact_data
		$sql3 = "UPDATE contact_data SET phone = ?, email = ? WHERE id = ?";
		$stmt3 = $mysqli->prepare($sql3);
		if ($stmt3) {
			$stmt3->bind_param("ssi", $phone, $email, $address_id);
			$result3 = $stmt3->execute();
			$stmt3->close();
		} else {
			throw new Exception("Aktualisierung der Nummer oder der Mail-Adresse fehlgeschlagen: " . $mysqli->error);
		}

         // Check all results
        if ($result1 && $result2 && $result3) {
            // Commit the transaction
            $mysqli->commit();
            echo "Erfolgreich aktualisiert.";
        } else {
            throw new Exception("Fehler beim Aktualisieren: " . $mysqli->error);
        }
    } catch (Exception $e) {
        // Rollback the transaction on error
        $mysqli->rollback();
        echo "Fehler beim SQL Statement: " . $e->getMessage();
    }
	$mysqli->close();
}