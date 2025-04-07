<?php
header('Content-Type: application/json');
//session_start(); // Don't forget to start the session if you plan to use it

include_once "../inc/settings.php";
include_once "../inc/dbconnect.php";

$data = json_decode(file_get_contents("php://input"), true);
$email = $data['email'];
$password = $data['password'];
$role = $data['role'];
$recaptcha_response = $data['g-recaptcha-response'];

$response = [];

$verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . RECAPTCHA_SECRET . '&response=' . $recaptcha_response);
$responseKeys = json_decode($verifyResponse, true);

if (intval($responseKeys["success"]) !== 1) {
    echo json_encode(['success' => false, 'message' => 'reCAPTCHA-Überprüfung fehlgeschlagen.']);
    exit();
}

$table = ($role == 2) ? 'admins' : (($role == 1) ? 'users' : null);

if ($table === null) {
    // Fehlerbehandlung, falls $role keinen der erwarteten Werte hat
    echo json_encode(['success' => false, 'message' => 'Ungültige Rolle']);
    exit();
}

$stmt = $mysqli->prepare("SELECT * FROM {$table} WHERE email = ?");
if ($stmt === false) {
    echo json_encode(['success' => false, 'message' => 'Datenbankfehler']);
    exit();
}

$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if ($user && password_verify($password, $user['password'])) {
    session_regenerate_id(); // Secure the session by regenerating ID
    if ($role == 2) {
        $_SESSION['loggedin_as_admin'] = true;
        $_SESSION['admin_id'] = $user['id']; // Notice that I changed $admin to $user
		$_SESSION['admin_role'] = $user['role']; // Notice that I changed $admin to $user
        $_SESSION['admin_email'] = $user['email']; // Notice that I changed $admin to $user
		unset($_SESSION['loggedin']);
		unset($_SESSION['user_id']);
		unset($_SESSION['email']);
		unset($_SESSION['product_data']);
		unset($_SESSION['products']);
		unset($_SESSION['compilation_name']);
		unset($_SESSION['bed_protectors_amount']);
		unset($_SESSION['insured_person_data']);
    } elseif($role == 1) {
		$_SESSION['loggedin'] = true;
		$_SESSION['user_id'] = $user['id'];
		$_SESSION['email'] = $user['email'];
		$_SESSION['user_type'] = $user['type'];
	}
    $response = ['success' => true, 'message' => 'Sie werden eingeloggt'];
} else {
	// fehlgeschlagene versuche speichern
    $response = ['success' => false, 'message' => 'Ungültige E-Mail-Adresse oder Passwort!'];
}

echo json_encode($response);

$stmt->close();
$mysqli->close();