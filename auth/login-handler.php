<?php
header('Content-Type: application/json');
session_start();

include_once "../inc/settings.php";
include_once "../inc/dbconnect.php";

$data = json_decode(file_get_contents("php://input"), true);
$email = trim($data['email']);
$password = trim($data['password']);
$role = $data['role'];
$recaptcha_response = $data['g-recaptcha-response'];

$response = [];

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['success' => false, 'message' => 'Ungültige E-Mail-Adresse!']);
    exit();
}

if (strlen($password) < 8) {
    echo json_encode(['success' => false, 'message' => 'Das Passwort muss mindestens 8 Zeichen lang sein!']);
    exit();
}

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

if ($user) {
    $current_time = new DateTime('now', new DateTimeZone('Europe/Berlin'));
    if (!empty($user['lock_until'])) {
    	$lock_until = new DateTime($user['lock_until'], new DateTimeZone('Europe/Berlin'));
	} else {
    // Handle den Fall, wenn $user['lock_until'] leer oder null ist
    	$lock_until = null; // oder setze ein Standarddatum/-zeit
	}	
    
    // Überprüfen, ob der Benutzer gesperrt ist
    if ($user['lock_until'] !== null && $current_time < $lock_until) {
        echo json_encode(['success' => false, 'message' => 'Dein Account ist gesperrt. Bitte versuche es später erneut oder kontaktieren Sie unseren Support.']);
        exit();
    }

    if (password_verify($password, $user['password'])) {
        // Erfolgreicher Login
        session_regenerate_id(); // Secure the session by regenerating ID
        if ($role == 2) {
            $_SESSION['loggedin_as_admin'] = true;
            $_SESSION['admin_id'] = $user['id'];
            $_SESSION['admin_role'] = $user['role'];
            $_SESSION['admin_email'] = $user['email'];
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

        // Zurücksetzen der fehlgeschlagenen Versuche und Sperrzeit
        $stmt = $mysqli->prepare("UPDATE {$table} SET failed_attempts = 0, lock_until = NULL WHERE id = ?");
        $stmt->bind_param("i", $user['id']);
        $stmt->execute();
        
        $response = ['success' => true, 'message' => 'Sie werden eingeloggt'];
    } else {
        // Fehlgeschlagener Login
        $failed_attempts = $user['failed_attempts'] + 1;
        if ($failed_attempts >= 8) {
            // Benutzer sperren
            $lock_until = $current_time->modify('+1 hour')->format('Y-m-d H:i:s');
            $stmt = $mysqli->prepare("UPDATE {$table} SET failed_attempts = ?, lock_until = ? WHERE id = ?");
            $stmt->bind_param("isi", $failed_attempts, $lock_until, $user['id']);
        } else {
            // Fehlgeschlagene Versuche aktualisieren
            $stmt = $mysqli->prepare("UPDATE {$table} SET failed_attempts = ? WHERE id = ?");
            $stmt->bind_param("ii", $failed_attempts, $user['id']);
        }
        $stmt->execute();
        $response = ['success' => false, 'message' => 'Ungültige E-Mail-Adresse oder Passwort!'];
    }
} else {
    $response = ['success' => false, 'message' => 'Ungültige E-Mail-Adresse oder Passwort!'];
}

echo json_encode($response);

$stmt->close();
$mysqli->close();
?>
