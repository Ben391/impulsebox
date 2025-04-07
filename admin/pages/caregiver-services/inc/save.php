<?php
include_once "../../../../inc/settings.php";
include_once "../../../../inc/dbconnect.php";

if($_SERVER["REQUEST_METHOD"] == "POST") {
    // Start der Transaktion
    $mysqli->begin_transaction();

    try {
        // Kontakt
		if(!empty($_POST['phone']) OR !empty($_POST['email'])) {
			$phone = $_POST['phone'];
			$email = $_POST['email'];

			$query_contact = "INSERT INTO contact_data (owner_type, phone, email, create_date) VALUES (3, ?, ?, UNIX_TIMESTAMP())";
			$stmt_contact = $mysqli->prepare($query_contact);
			$stmt_contact->bind_param("ss", $phone, $email);
			$stmt_contact->execute();
			$stmt_contact->close();

			// Erhalten der zuletzt eingefügten ID für die Adresse
			$last_contact_id = $mysqli->insert_id;
			
			$query_contact_update_owner_id = "UPDATE contact_data SET owner_id = ? WHERE id = ?";
		}
		
        // Daten für die Adressentabelle
        $street = $_POST['street'];
        $address_addition = $_POST['address_addition'];
        $zipcode = $_POST['zipcode'];
        $city = $_POST['city'];

        // Einfügen in die Adressentabelle
        $query_address = "INSERT INTO addresses (street, address_addition, zipcode, city, create_date) VALUES (?, ?, ?, ?, UNIX_TIMESTAMP())";
        $stmt_address = $mysqli->prepare($query_address);
        $stmt_address->bind_param("ssss", $street, $address_addition, $zipcode, $city);
        $stmt_address->execute();
        $stmt_address->close();

        // Erhalten der zuletzt eingefügten ID für die Adresse
        $last_address_id = $mysqli->insert_id;

        // Daten für die care_giver_data Tabelle
        $company = $_POST['company'];
		// standard user
		$user_id = 1;

        // Einfügen in die care_giver_data Tabelle
        $sql = "INSERT INTO care_giver_data (company, type, user_id, address_id, contact_id, create_date) VALUES (?, 3, ?, ?, ?, UNIX_TIMESTAMP())";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("siii", $company, $user_id, $last_address_id, $last_contact_id);
        $stmt->execute();
        $stmt->close();
		
		if(!empty($_POST['phone']) OR !empty($_POST['email'])) {
			$last_care_giver_data_id = $mysqli->insert_id;
			$stmt_contact_update = $mysqli->prepare($query_contact_update_owner_id);
			$stmt_contact_update->bind_param("ii", $last_care_giver_data_id, $last_contact_id);
			$stmt_contact_update->execute();
			$stmt_contact_update->close();
		}

        // Wenn alles gut geht, commit der Transaktion
        $mysqli->commit();
        echo "Pflegedienst erfolgreich gespeichert.";

    } catch (Exception $e) {
        // Bei einem Fehler rollback der Transaktion
        $mysqli->rollback();
        echo "Fehler beim Speichern: " . $e->getMessage();
    }

    $mysqli->close();
}