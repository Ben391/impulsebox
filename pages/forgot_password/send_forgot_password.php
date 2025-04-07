<?php
header('Content-Type: application/json');
include_once "../../inc/settings.php";
include_once "../../inc/dbconnect.php";
include_once "../../inc/functions.php";

try {
    $data = json_decode(file_get_contents("php://input"), true);
    $email = $data['email'];
	if(isset($data['admin_area'])) {
		$admin_area = $data['admin_area'];
	} else {
		$admin_area = 0;
	}
    $ip_address = $_SERVER['REMOTE_ADDR'];
	$recaptchaToken = $data['recaptcha_token'];  // reCAPTCHA token vom Client
    $response = [];
	
	// Überprüfe das reCAPTCHA-Token
    $recaptchaResponse = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".RECAPTCHA_SECRET."&response=$recaptchaToken");
    $recaptchaKeys = json_decode($recaptchaResponse, true);
	
    if (intval($recaptchaKeys["success"]) !== 1 || $recaptchaKeys["score"] < 0.5) {
        throw new Exception('reCAPTCHA-Überprüfung fehlgeschlagen.');
    }
	
    $stmt = $mysqli->prepare("SELECT COUNT(*) FROM password_reset_requests WHERE email = ? AND request_time > NOW() - INTERVAL 1 HOUR");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close(); // Schließt das Statement
	
    if ($count >= 5) {
        throw new Exception('Zu viele Anfragen. Bitte später versuchen.');
    }
	
    // Anzahl der Anfragen in der letzten Stunde für diese IP-Adresse überprüfen
    $stmt = $mysqli->prepare("SELECT COUNT(*) FROM password_reset_requests WHERE ip_address = ? AND request_time > NOW() - INTERVAL 1 HOUR");
    $stmt->bind_param("s", $ip_address);
    $stmt->execute();
    $stmt->bind_result($count_ip);
    $stmt->fetch();
    $stmt->close(); // Schließt das Statement
	
    if ($count_ip >= 5) {
        throw new Exception('Zu viele Anfragen von dieser IP-Adresse. Bitte später versuchen.');
    }
	if($admin_area == 1) {
		$stmt = $mysqli->prepare("SELECT * FROM admins WHERE email = ?");
	} else {
		$stmt = $mysqli->prepare("SELECT * FROM users WHERE email = ?");
	}
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $stmt->close();
	
	$stmt = $mysqli->prepare("INSERT INTO password_reset_requests (email, ip_address) VALUES (?, ?)");
	$stmt->bind_param("ss", $email, $ip_address);
	$stmt->execute();
	$stmt->close();

    if ($user) {
        $token = bin2hex(random_bytes(50));
		
		if($admin_area == 1) {
			$stmt = $mysqli->prepare("UPDATE admins SET reset_token = ?, token_expiry = DATE_ADD(NOW(), INTERVAL 1 HOUR) WHERE email = ?");
		} else {
			$stmt = $mysqli->prepare("UPDATE users SET reset_token = ?, token_expiry = DATE_ADD(NOW(), INTERVAL 1 HOUR) WHERE email = ?");
		}
        $stmt->bind_param("ss", $token, $email);
        $stmt->execute();
        $stmt->close(); // Schließt das Statement

		mailResetPassword($mysqli, $email, $admin_area, $token);

        $response = ['success' => true, 'message' => 'Falls diese E-Mail-Adresse registriert ist, bekommen Sie gleich eine E-Mail-Nachricht.'];
    } else {
        $response = ['success' => false, 'message' => 'Falls diese E-Mail-Adresse registriert ist, bekommen Sie gleich eine E-Mail-Nachricht.'];
    }

    echo json_encode($response);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
} finally {
    $mysqli->close();
}