<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Type: application/json');
    include_once "../../inc/settings.php";
    include_once "../../inc/dbconnect.php";
	include_once "../../inc/functions.php";

    $new_password = $_POST['new_password'];
    $data["token"] = $token = $_POST['token'] ?? null;
    $data["user_id"] = $userId = $_POST['user_id'] ?? null;
	$data["admin_id"] = $adminId = $_POST['admin_id'] ?? null;
    $admin_area = filter_var($_POST['admin_area'] ?? null, FILTER_VALIDATE_BOOLEAN);

    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
    $stmt = null;
    $response = [];
	
    try {
		
		if($user = getUser($mysqli, $data)) {
			$email = $user["email"];
		} else {
			$response = [
				'success' => false,
				'message' => 'Ein Fehler ist aufgetreten: getUser.',
			];
		}
		
		if($admin = getAdminData($mysqli, $data)) {
			$email = $admin["email"];
		} else {
			$response = [
				'success' => false,
				'message' => 'Ein Fehler ist auftreten: getAdmin.',
			];
		}
		
		// falls als user eingeloggt ist
        if ($userId) {
            $stmt = $mysqli->prepare("UPDATE users SET password = ?, password_not_hashed = ? WHERE id = ?");
			mailResetPasswordNotice($mysqli, $email);
            if (!$stmt) {
                throw new Exception("Prepare failed: " . $mysqli->error);
            }
            $stmt->bind_param("ssi", $hashed_password, $new_password, $userId);
		// falls als admin eingeloggt ist
        } elseif ($adminId) {
            $stmt = $mysqli->prepare("UPDATE admins SET password = ? WHERE id = ?");
			mailResetPasswordNotice($mysqli, $email);
            if (!$stmt) {
                throw new Exception("Prepare failed: " . $mysqli->error);
            }
            $stmt->bind_param("si", $hashed_password, $adminId);
		// falls nicht eingeloggt ist
        } elseif ($token) {
			// falls admin
            if ($admin_area) {
                $stmt = $mysqli->prepare("UPDATE admins SET password = ?, reset_token = NULL, token_expiry = NULL WHERE reset_token = ?");
				mailResetPasswordNotice($mysqli, $email);
			// falls user
            } else {
                $stmt = $mysqli->prepare("UPDATE users SET password = ?, reset_token = NULL, token_expiry = NULL WHERE reset_token = ?");
				mailResetPasswordNotice($mysqli, $email);
            }
            if (!$stmt) {
                throw new Exception("Prepare failed: " . $mysqli->error);
            }
            $stmt->bind_param("ss", $hashed_password, $token);
        } else {
            throw new Exception("Invalid request.");
        }

        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            $response = ['success' => true, 'message' => 'Das Passwort wurde geändert.'];
        } else {
            $response = [
                'success' => false,
                'message' => 'Das Passwort konnte nicht zurückgesetzt werden.',
                'error' => 'No rows affected or incorrect token/userId/adminId provided.',
                'user_id' => $userId,
                'admin_id' => $adminId,
            ];
        }
    } catch (Exception $e) {
        $response = [
            'success' => false,
            'message' => 'Ein Fehler ist aufgetreten.',
            'error' => $e->getMessage(),
			'user_id' => $userId,
			'admin_id' => $adminId,
        ];
    } finally {
        if ($stmt) {
            $stmt->close();
        }
    }

    echo json_encode($response);
}