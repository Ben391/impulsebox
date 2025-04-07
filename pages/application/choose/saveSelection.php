<?php
session_start();
include_once '../../../inc/dbconnect.php';
include_once '../../../functions.php';

// Ihre SQL-Statements
$create_insured_person = "INSERT INTO insured_person_data (salutation, firstname, lastname, address_id, create_date) VALUES (?, ?, ?, ?, ?)";
$check_email_query = "SELECT id FROM users WHERE email = ?";
$create_user_query = "INSERT INTO users (email, password, password_not_hashed) VALUES (?, ?, ?)";
$create_entry_query = "INSERT INTO entries (user_id, products, insured_person_id, create_date) VALUES (?, ?, ?, ?)";
$create_insurance_data = "INSERT INTO insurance_data (insured_person_id, insurance_type, insurance_number, insurance_company, care_level, care_level_since, create_date) VALUES (?,?,?,?,?,?,?)";
$create_address = "INSERT INTO addresses (street,zipcode,city,create_date) VALUES (?,?,?,?)";

if (isset($_POST['products']) && !empty($_POST['products'])) {
    $current_date = time();
    $accountEmail = $_POST['accountEmail'];
    $password = generatePassword();
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
	// insured person data
	$insured_person_salutation = $_POST['insured_person_salutation'];
    $insured_person_first_name = $_POST['insured_person_first_name'];
    $insured_person_last_name = $_POST['insured_person_last_name'];
	// insurance data
	$insurance_type = $_POST['insurance_type'];
	$insurance_number = $_POST['insurance_number'];
	$insurance_company = $_POST['insurance_company'];
    $care_level = $_POST['care_level'];
	$care_level_since = $_POST['care_level_since'];
	// address
	$insured_person_street = $_POST['insured_person_street'];
	$insured_person_zipcode = $_POST['insured_person_zipcode'];
	$insured_person_city = $_POST['insured_person_city'];
    // Starten der Transaktion
    $mysqli->begin_transaction();

    try {
		// E-Mail-Adresse prüfen
        $stmt_check_email = prepareAndBind($mysqli, $check_email_query, "s", $accountEmail);
        $stmt_check_email->execute();
        $stmt_check_email->store_result();

        if ($stmt_check_email->num_rows > 0) {
            throw new Exception('Die E-Mail-Adresse existiert bereits.');
        }
        $stmt_check_email->close();
		
		// Einfügen von Adresse
		$stmt_create_address = prepareAndBind($mysqli, $create_address, 'sisi', $insured_person_street, $insured_person_zipcode, $insured_person_city, $current_date);
		$stmt_create_address->execute();
		$address_id = $mysqli->insert_id;
		$stmt_create_address->close();
		
        $stmt = prepareAndBind($mysqli, $create_insured_person, "issii", $insured_person_salutation, $insured_person_first_name, $insured_person_last_name, $address_id, $current_date);
        executeStatement($stmt, $create_insured_person);
        $insured_person_id = $mysqli->insert_id;
        $stmt->close();
        
		
        $stmt_create_user_query = prepareAndBind($mysqli, $create_user_query, "sss", $accountEmail, $hashedPassword, $password);
        $stmt_create_user_query->execute();
        $user_id = $mysqli->insert_id;
        $stmt_create_user_query->close();

        $selected_products = json_decode($_POST['products'], true);
        $json_data = json_encode($selected_products);

        $stmt_create_entry = prepareAndBind($mysqli, $create_entry_query, 'isii', $user_id, $json_data, $insured_person_id, $current_date);
        $stmt_create_entry->execute();
        $entry_id = $mysqli->insert_id;
        $stmt_create_entry->close();
		
		// Einfügen von Versicherungsdaten des Versicherten
		$stmt_create_insurance_data = prepareAndBind($mysqli, $create_insurance_data, 'iissiii', $insured_person_id, $insurance_type, $insurance_number, $insurance_company, $care_level, $care_level_since, $current_date);
		$stmt_create_insurance_data->execute();
		$stmt_create_insurance_data->close();

        // Commit the transaction
        $mysqli->commit();

        $_SESSION['loggedin'] = true;
		$_SESSION['user_id'] = $user_id;
        $_SESSION['email'] = $accountEmail;
        // TODO: Send email to the user with the password

        echo json_encode(['success' => true, 'entry_id' => $entry_id, 'message' => 'Daten erfolgreich gespeichert!']);

    } catch (Exception $e) {
        $mysqli->rollback();
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    } finally {
        $mysqli->close();
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Keine Produkte oder E-Mail erhalten.']);
}