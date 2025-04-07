<?php
include_once "../../../../inc/settings.php";
include_once "../../../../inc/dbconnect.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $servicename = isset($_POST['servicename']) ? $_POST['servicename'] : '';
    $company = isset($_POST['company']) ? $_POST['company'] : '';
    $street = isset($_POST['street']) ? $_POST['street'] : '';
    $zipcode = isset($_POST['zipcode']) ? $_POST['zipcode'] : '';
    $city = isset($_POST['city']) ? $_POST['city'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
	$phone = isset($_POST['phone']) ? $_POST['phone'] : '';

    // Überprüfen, ob ein Datensatz existiert
    $sql_check = "SELECT COUNT(*) FROM company";
    $result = $mysqli->query($sql_check);
    $row = $result->fetch_row();
    
    if ($row[0] > 0) {
        $sql = "
		UPDATE company 
		SET 
			servicename = ?, 
			company = ?, 
			street = ?,
			zipcode = ?,
			city = ?,
			email = ?,
			phone = ?
		WHERE 
			id = 1
		";
    } else {
        $sql = "
		INSERT INTO 
			company (
				servicename, 
				company, 
				street = ?,
				zipcode = ?,
				city = ?,
				email = ?,
				phone = ?
			) VALUES (?, ?, ?, ?, ?, ?, ?)
		";
    }

    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("sssssss", $servicename, $company, $street, $zipcode, $city, $email, $phone);
    $stmt->execute();
    $stmt->close();

    echo 'Daten erfolgreich gespeichert.';
} else {
    echo 'Ungültige Anfrage.';
}