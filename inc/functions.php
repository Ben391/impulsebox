<?php
require __DIR__ . '/../PHPMailer/Exception.php';
require __DIR__ . '/../PHPMailer/PHPMailer.php';
require __DIR__ . '/../PHPMailer/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function sendMailToUser($mysqli, $data) {
	// $user_email, $subject, $message
	// $data["entry_id"], $data["user_email"], $data["subject"], $data["message"]
    $mail = new PHPMailer(true);
	$mail->CharSet = 'UTF-8';
	
    $footer_template_file = __DIR__ . '/../email-templates/user/user_footer.html';
    if (!file_exists($footer_template_file)) {
        throw new Exception("E-Mail Template footer fehlt.");
    }
    $footer = file_get_contents($footer_template_file);

    $message = $data["message"] . $footer;
	
	// get entry data
	if(isset($data["entry_id"])) {
		$entry = getEntryData($mysqli, $data["entry_id"]);		
		// entry data
		$data["entry_number"] = $entry["entry_data"]["entry_number"];
		// insured person data
		$data["insured_person_first_name"] = $entry["insured_person_data"]["insured_person_first_name"];
		$data["insured_person_last_name"] = $entry["insured_person_data"]["insured_person_last_name"];
		$data["insured_person_salutation_name"] = $entry["insured_person_data"]["insured_person_salutation_name"];
		$data["insured_person_salutation_full_salutation"] = $entry["insured_person_data"]["insured_person_full_salutation"];

		$message = str_replace(
			[
				'{entry_id}',
				'{entry_number}',
				'{insured_person_first_name}',
				'{insured_person_last_name}',
				'{insured_person_salutation_full_salutation}',
				'{user}', 
				'{account_url}',
			],
			[
				$data["entry_id"],
				$data["entry_number"],
				$data["insured_person_first_name"],
				$data["insured_person_last_name"],
				$data["insured_person_salutation_full_salutation"],
				$data["user_email"], 
				BASEHREF . 'konto/'
			],
			$message
		);
		$data["subject"] = str_replace(
			[
				'{entry_id}',
				'{entry_number}',
				'{insured_person_first_name}',
				'{insured_person_last_name}',
				'{insured_person_salutation_full_salutation}',
				'{user}',
			],
			[
				$data["entry_id"],
				$data["entry_number"],
				$data["insured_person_first_name"],
				$data["insured_person_last_name"],
				$data["insured_person_salutation_full_salutation"],
				$data["user_email"], 
			],
			$data["subject"]
		);
	}

    try {
        // SMTP-Servereinstellungen
        $mail->isSMTP();
        $mail->Host       = SMTP_HOST;
        $mail->SMTPAuth   = true;
        $mail->Username   = SMTP_USERNAME;
        $mail->Password   = SMTP_PASSWORD;
        $mail->SMTPSecure = 'tls';
        $mail->Port       = SMTP_PORT;

        // Empfänger & Absender
        $mail->setFrom(ADMIN_EMAIL); // optionaler 'Absendername'
        $mail->addAddress($data["user_email"]);
        $mail->addBCC(TECH_ADMIN_EMAIL);

        // Inhalt
        $mail->isHTML(true);
        $mail->Subject = $data["subject"];
        $mail->Body    = $message;

        $mail->send();
    } catch (Exception $e) {
        throw new Exception("E-Mail konnte nicht gesendet werden: {$mail->ErrorInfo}");
    }
}

function sendMailToAdmin($mysqli, $data) {
	// $subject, $message
	// $data["subject"], $data["message"], $data["entry_id"]
    $mail = new PHPMailer(true);
	$mail->CharSet = 'UTF-8';

    // E-Mail Templates laden
    $greeting_template_file = __DIR__ . '/../email-templates/admin/admin_greeting.html';
    if (!file_exists($greeting_template_file)) {
        throw new Exception("E-Mail Template greeting fehlt.");
    }
    $greeting = file_get_contents($greeting_template_file);
	
    $footer_template_file = __DIR__ . '/../email-templates/admin/admin_footer.html';
    if (!file_exists($footer_template_file)) {
        throw new Exception("E-Mail Template footer fehlt.");
    }
    $footer = file_get_contents($footer_template_file);

    $data["message"] = $greeting . $data["message"] . $footer;
	
	// get entry data
	if(isset($data["entry_id"])) {
		$entry = getEntryData($mysqli, $data["entry_id"]);		
		// entry data
		$data["entry_number"] = $entry["entry_data"]["entry_number"];
		// insured person data
		$data["insured_person_first_name"] = $entry["insured_person_data"]["insured_person_first_name"];
		$data["insured_person_last_name"] = $entry["insured_person_data"]["insured_person_last_name"];
		$data["insured_person_salutation_name"] = $entry["insured_person_data"]["insured_person_salutation_name"];
		$data["insured_person_salutation_full_salutation"] = $entry["insured_person_data"]["insured_person_full_salutation"];

		$data["message"] = str_replace(
			[
				'{entry_id}',
				'{entry_number}',
				'{insured_person_first_name}',
				'{insured_person_last_name}',
				'{insured_person_salutation_full_salutation}',
				'{user}', 
				'{account_url}',
			],
			[
				$data["entry_id"],
				$data["entry_number"],
				$data["insured_person_first_name"],
				$data["insured_person_last_name"],
				$data["insured_person_salutation_full_salutation"],
				$data["user_email"], 
				BASEHREF . 'konto/'
			],
			$data["message"]
		);
		$data["subject"] = str_replace(
			[
				'{entry_id}',
				'{entry_number}',
				'{insured_person_first_name}',
				'{insured_person_last_name}',
				'{insured_person_salutation_full_salutation}',
				'{user}',
			],
			[
				$data["entry_id"],
				$data["entry_number"],
				$data["insured_person_first_name"],
				$data["insured_person_last_name"],
				$data["insured_person_salutation_full_salutation"],
				$data["user_email"], 
			],
			$data["subject"]
		);
	}

    try {
        // SMTP-Servereinstellungen
        $mail->isSMTP();
        $mail->Host       = SMTP_HOST;
        $mail->SMTPAuth   = true;
        $mail->Username   = SMTP_USERNAME;
        $mail->Password   = SMTP_PASSWORD;
        $mail->SMTPSecure = 'tls';
        $mail->Port       = SMTP_PORT;
		
        // Empfänger & Absender
        //$mail->setFrom(TECH_ADMIN_EMAIL, 'Technischer Admin');
		$mail->setFrom(ADMIN_EMAIL, 'Technischer Admin');
        $mail->addAddress(ADMIN_EMAIL);

        // Inhalt
        $mail->isHTML(true);
        $mail->Subject = $data["subject"];
        $mail->Body    = $data["message"];

        $mail->send();
    } catch (Exception $e) {
		if (defined('DEV') && DEV == 0) {
			throw new Exception("E-Mail konnte nicht gesendet werden");
		} else {
			throw new Exception("E-Mail konnte nicht gesendet werden: {$mail->ErrorInfo}");
		}
    }
}

function mailResetPassword($mysqli, $user_email, $admin_area, $token) {
	
	$subject_template_file = __DIR__ . '/../email-templates/user/user_reset_password_subject.html';
	if (!file_exists($subject_template_file)) {
		throw new Exception("E-Mail Subject Template fehlt.");
	}
	$subject = file_get_contents($subject_template_file);

	$reset_password_template_file = '../../email-templates/user/user_reset_password.html';
	if (!file_exists($reset_password_template_file)) {
		throw new Exception("E-Mail Template reset_password fehlt.");
	}
	$reset_password = file_get_contents($reset_password_template_file);
		
	$template = $reset_password;
	
	if(isset($admin_area) AND $admin_area == 1) {
		$link = ADMIN_BASEHREF;
	} else {
		$link = BASEHREF;
	}
	$link .= 'passwort-zuruecksetzen/?token=' . $token;

	$message = str_replace(
		[
			'{reset_password_url}',
		],
		[
			$link],
		$template
	);
	
	$data["user_email"] = $user_email;
	$data["subject"] = $subject;
	$data["message"] = $message;
	sendMailToUser($mysqli, $data);
}

function mailResetPasswordNotice($mysqli, $email) {
	$subject = "Achtung - Ihr Passwort wurde geändert!";
	$reset_password_template_file = '../../email-templates/reset_password_notice.html';
	if (!file_exists($reset_password_template_file)) {
		throw new Exception("E-Mail Template reset_password fehlt.");
	}
	
	$message = file_get_contents($reset_password_template_file);
	
	$data["user_email"] = $email;
	$data["subject"] = $subject;
	$data["message"] = $message;
	sendMailToUser($mysqli, $data);
	 
}

function getUser($mysqli, $data) {
	# falls user id bekannt
	if(isset($data["user_id"]) AND !empty($data["user_id"]) AND $data["user_id"] != NULL) {
		$query = "SELECT * FROM users WHERE id = ?";
		$param = $data["user_id"];
		$param_type = "i";  // Integer
	} elseif(isset($data["token"]) AND !empty($data["token"])) {
		$query = "SELECT * FROM users WHERE reset_token = ?";
		$param = $data["token"];
		$param_type = "s";  // String
	} else {
		return false;
	}

	# Prepare statement
	if ($stmt = $mysqli->prepare($query)) {
		$stmt->bind_param($param_type, $param);
		$stmt->execute();
		$result = $stmt->get_result();
		$user = $result->fetch_assoc();
		$stmt->close();

		return $user ? $user : false;
	} else {
		return false;
	}
}

function getAdminData ($mysqli, $data) {
	# falls admin id bekannt
	if(isset($data["admin_id"]) AND !empty($data["admin_id"]) AND $data["admin_id"] != NULL) {
		$query = "SELECT * FROM admins WHERE id = ?";
		$param = $data["admin_id"];
		$param_type = "i";
	} elseif(isset($data["token"]) AND !empty($data["token"])) {
		$query = "SELECT * FROM admins WHERE reset_token = ?";
		$param = $data["token"];
		$param_type = "s";  
	} else {
		return false;
	}

	# Prepare statement
	if ($stmt = $mysqli->prepare($query)) {
		$stmt->bind_param($param_type, $param);
		$stmt->execute();
		$result = $stmt->get_result();
		$admin = $result->fetch_assoc();
		$stmt->close();

		return $admin ? $admin : false;
	} else {
		return false;
	}
}

function getImports($mysqli) {
	$query = "
	SELECT
		i.import_id AS import_id,
		DATE_FORMAT(FROM_UNIXTIME(i.import_date), '%d.%m.%Y %H:%i') AS import_date_formatted,
		a.first_name AS first_name,
		a.last_name AS last_name
	FROM 
		imports i
		LEFT JOIN admins a
			ON i.admin_id = a.id
	ORDER BY 
		import_date DESC
	";
	$stmt = $mysqli->prepare($query);
	$stmt->execute();
	$result = $stmt->get_result();
	return $result;
}


function getCareGiverServices($mysqli, $where) {
	if(!empty($where)) {
		$sql_where = "AND ".$where;
	} else {
		$sql_where = "";
	}
	$query = "
	SELECT 
		cgd.id AS id,
		cgd.company AS company,
		cgd.user_id AS user_id,
		a.street AS street,
		a.address_addition AS address_addition,
		a.zipcode AS zipcode,
		a.city AS city,
		cd.phone AS phone,
		cd.email AS email,
		cgd.active AS active,
		cgd.address_id AS address_id
	FROM 
		care_giver_data cgd
			LEFT JOIN addresses a 
				ON cgd.address_id = a.id
			LEFT JOIN contact_data cd 
				ON cgd.address_id = cd.id
	WHERE 
		cgd.type = 3 $sql_where
	ORDER BY 
		cgd.id DESC
	";
	$stmt = $mysqli->prepare($query);
	$stmt->execute();
	$result = $stmt->get_result();
	return $result;
}

function checkImageExtension($basePath) {
    
	$jpgPath = "/../".$basePath . '.jpg';
	$jpegPath = $basePath . '.jpeg';
	$pngPath = $basePath . '.png';
	
    if (file_exists($jpgPath)) {
        return 'jpg';
    }
    
    // Überprüfen, ob die Datei mit .jpeg existiert
    if (file_exists($jpegPath)) {
        return 'jpeg';
    }
    
    // Überprüfen, ob die Datei mit .png existiert
    if (file_exists($pngPath)) {
        return 'png';
    }
    
    // Wenn keine der Dateien existiert, false zurückgeben
    return false;
}

function addSpacesBetweenLetters($string) {
	return implode('  ', str_split(str_replace('.', '', $string)));
}

function addSpacesBetweenLettersBirthDate($string) {
	return implode('  ', str_split(str_replace('.', ' ', $string)));
}

function setGloveProperties(
	$pdf, 
	$intolerance, 
	$size, 
	$bsipnx, 
	$bsipny, 
	$bsipvx, 
	$bsipvy, 
	$bsipnix, 
	$bsipniy, 
	$bsiplx, 
	$bsiply, 
	$bsspsx, 
	$bsspsy, 
	$bsspmx, 
	$bsspmy, 
	$bssplx, 
	$bssply, 
	$bsspex, 
	$bsspey
) {
	$intolerances = [
		'none' => [
			'x' => $bsipnx,
			'y' => $bsipny,
		],
		'v' => [
			'x' => $bsipvx,
			'y' => $bsipvy,
		],
		'n' => [
			'x' => $bsipnix,
			'y' => $bsipniy,
		],
		'l' => [
			'x' => $bsiplx,
			'y' => $bsiply,
		],
	];

	if (!empty($size)) {
		switchFont($pdf, "anhaken_klein");
		switch($size) {
			case 's':
				//$pdf->Ellipse($input_seven_size_property_small_x, $input_seven_size_property_small_y, 3, 'F');
				$pdf->SetXY($bsspsx, $bsspsy);
				$pdf->Write(0, "x");
				break;
			case 'm':
				//$pdf->Ellipse($input_seven_size_property_medium_x, $input_seven_size_property_medium_y, 3, 'F');
				$pdf->SetXY($bsspmx, $bsspmy);
				$pdf->Write(0, "x");
				break;
			case 'l':
				//$pdf->Circle($input_seven_size_property_large_x, $input_seven_size_property_large_y, 3, 'F');
				$pdf->SetXY($bssplx, $bssply);
				$pdf->Write(0, "x");
				break;
			case 'xl':
				//$pdf->Circle($input_seven_size_property_extralarge_x, $input_seven_size_property_extralarge_y, 3, 'F');
				$pdf->SetXY($bsspex, $bsspey);
				$pdf->Write(0, "x");
				break;

		}
		switchFont($pdf, "standard");
		}
		switchFont($pdf, "anhaken");
		if (strpos($intolerance, 'v') !== false) {
			$pdf->SetXY($intolerances['v']['x'], $intolerances['v']['y']);
			$pdf->Write("0", "x");

		}
		if (strpos($intolerance, 'l') !== false) {
			$pdf->SetXY($intolerances['l']['x'], $intolerances['l']['y']);
			$pdf->Write("0", "x");
		}
		if (strpos($intolerance, 'n') !== false) {
			$pdf->SetXY($intolerances['n']['x'], $intolerances['n']['y']);
			$pdf->Write("0", "x");
		}
		if (empty($intolerance)) {
			$pdf->setXY($intolerances['none']['x'], $intolerances['none']['y']);
			$pdf->Write("0", "x");
		}
		switchFont($pdf, "standard");
}
function splitCompilations($compilation) {
    $compilation = trim($compilation);
    $words = explode(' ', $compilation);
    $words = array_filter($words);

    return array_values($words); 
}


function switchFont($pdf, $type) {
	$open_sans = TCPDF_FONTS::addTTFfont('../../fonts/OpenSans-Light.ttf', 'TrueTypeUnicode', '', 96);
	switch($type) {
		case "products_page3":
			$pdf->SetFont($open_sans,'',15);
			break;
		case "space_letters":
			$pdf->SetFont($open_sans,'',14);
			break;
		case "standard":
			$pdf->SetFont($open_sans,'',12);
			break;
		case "long_words":
			$pdf->SetFont($open_sans,'',11);
			break;
		case "products":
			$pdf->SetFont($open_sans,'',10);
			break;
		case "start":
			$pdf->SetFont($open_sans,'',9);
			break;
		case "klein":
			$pdf->SetFont($open_sans,'',7);
			break;
		case "anhaken":
			$pdf->SetFont($open_sans, '', 20);
			break;
		case "anhaken_klein":
			$pdf->SetFont($open_sans, '', 16);
			break;
		case "products_klein":
			$pdf->SetFont($open_sans, '', 8);
			break;
		default:
			$pdf->SetFont($open_sans,'',12);
			break;
	}
}
function getEntryIdByUserId($mysqli, $user_id) {
    $query = "
    SELECT
        e.id
    FROM 
        users u 
        LEFT JOIN entries e 
            ON u.id = e.user_id
    WHERE 
        e.user_id = ?
    ";
    // Prepared Statement vorbereiten
    if ($stmt = $mysqli->prepare($query)) {
        // Parameter binden
        $stmt->bind_param("i", $user_id);
        
        // Query ausführen
        $stmt->execute();
        
        // Ergebnis binden
        $stmt->bind_result($entry_id);
        
        // Ergebnis fetchen
        if ($stmt->fetch()) {
            // Ergebnis zurückgeben
            return $entry_id;
        } else {
            return null; // Kein Ergebnis gefunden
        }
        
        // Statement schließen
        $stmt->close();
    } else {
        return null; // Statement konnte nicht vorbereitet werden
    }
}

function getTotalEntries($mysqli, $where) {
	$sql_where = "";
	if(isset($where) AND !empty($where)) {
		$sql_where = ' WHERE ' . $where;
	}
    $query = "
	SELECT 
		COUNT(DISTINCT e.id) as total 
	FROM 
		entries e
			LEFT JOIN users u 
				ON e.user_id = u.id 
            LEFT JOIN insured_person_data 
                ON e.insured_person_id = insured_person_data.id
            LEFT JOIN insurance_data 
                ON e.insured_person_id = insurance_data.insured_person_id
            LEFT JOIN insurance_companies 
                ON insurance_data.insurance_company_id = insurance_companies.id
			LEFT JOIN care_giver_data cgpd 
				ON insured_person_data.care_giver_person_id = cgpd.id AND cgpd.type = 2
			LEFT JOIN care_giver_data cgsd 
				ON insured_person_data.care_giver_service_id = cgsd.id AND cgsd.type = 3
			LEFT JOIN application_status aps
				ON e.id = aps.entry_id
	$sql_where
	";
    $result = $mysqli->query($query);
    $row = $result->fetch_assoc();
    return $row['total'];
}

function getEntries_bak($mysqli, $where, $limit, $offset, $keyword, $countOnly = false) {
    $sql_where = "";
    $param_types = "ii";
    $params = [$offset, $limit];
	
	if(isset($where) AND !empty($where)) {
		$sql_where = 'WHERE ' . $where;
	}

    if (!empty($keyword)) {
		$columns = [
			'e.id',
			'e.entry_number',
			'e.import_id',
			'insured_person_data.first_name',
			'insured_person_data.last_name',
			"CONCAT(insured_person_data.first_name, ' ', insured_person_data.last_name)",
			"CONCAT(insured_person_data.last_name, ' ', insured_person_data.first_name)",
			'insurance_data.insurance_number',
			'cgpd.first_name',
			'cgpd.last_name',
			"CONCAT(cgpd.first_name, ' ', cgpd.last_name)",
			"CONCAT(cgpd.last_name, ' ', cgpd.first_name)"
		];
		if(isset($where) AND !empty($where)) {
			$sql_where = 'WHERE '. $where .' AND '. implode(' LIKE ? OR ', $columns) . ' LIKE ?';
		} else {
			$sql_where = 'WHERE ' . implode(' LIKE ? OR ', $columns) . ' LIKE ?';
		}
		// Parameter-Typen und -Werte vorbereiten
		$param_types = str_repeat('s', count($columns)) . $param_types;
		$params_to_prepend = array_fill(0, count($columns), "%$keyword%");

		// Die neuen Parameter dem existierenden Parameter-Array voranstellen
		array_unshift($params, ...$params_to_prepend);
    }

    // SQL-Query vorbereiten
    $select_entries_query = "
        SELECT 
            DISTINCT e.id AS entry_id,
			e.user_id AS user_id,
            e.entry_number AS entry_number,
            e.status AS entry_status,
            CASE 
				WHEN e.status = 1 AND insurance_data.insurance_type = 2 THEN 'kostenpflichtig bestellt'
                WHEN e.status = 0 THEN 'ausstehend'
                WHEN e.status = 1 THEN 'abgeschlossen'
                ELSE ''
            END AS entry_status_name,
            e.create_date AS entry_create_date,
			e.import_id AS entry_import_id,
            e.complete_date AS entry_complete_date,
			e.compilation_name AS compilation_name,
			e.bed_protectors_amount AS bed_protectors_amount,
			u.type AS user_type,
			CASE 
				WHEN u.type = 1 THEN 'Versicherter'
				WHEN u.type = 2 THEN 'Pflegeperson'
				ELSE ''
			END AS user_type_name,
            insured_person_data.first_name AS insured_person_data_first_name,
            insured_person_data.last_name AS insured_person_data_last_name,
            insurance_data.insurance_type AS insurance_type,
            insurance_data.custom_insurance_company_name AS custom_insurance_company_name,
            CASE 
                WHEN insurance_type = 1 THEN 'Gesetzlich'
                WHEN insurance_type = 2 THEN 'Privat'
                ELSE ''
            END AS insurance_type_short_name,
            insurance_companies.name AS insurance_company_name,
			cgpd.first_name AS care_giver_person_first_name,
			cgpd.last_name AS care_giver_person_last_name
        FROM 
            entries e
			LEFT JOIN users u 
				ON e.user_id = u.id 
            LEFT JOIN insured_person_data 
                ON e.insured_person_id = insured_person_data.id
            LEFT JOIN insurance_data 
                ON e.insured_person_id = insurance_data.insured_person_id
            LEFT JOIN insurance_companies 
                ON insurance_data.insurance_company_id = insurance_companies.id
			LEFT JOIN care_giver_data cgpd 
				ON insured_person_data.care_giver_person_id = cgpd.id AND cgpd.type = 2
			LEFT JOIN care_giver_data cgsd 
				ON insured_person_data.care_giver_service_id = cgsd.id AND cgsd.type = 3
			LEFT JOIN application_status aps
				ON e.id = aps.entry_id
        $sql_where
        ORDER BY 
            e.create_date DESC
        LIMIT ?, ?
    ";
	//echo $select_entries_query;

    $stmt = $mysqli->prepare($select_entries_query);
    if (!$stmt) {
        die("Statement konnte nicht vorbereitet werden: (" . $mysqli->errno . ") " . $mysqli->error);
    }

    $stmt->bind_param($param_types, ...$params);

    if (!$stmt->execute()) {
        die("Execute failed: (" . $stmt->errno . ") " . $stmt->error);
    }
    $result = $stmt->get_result();
	
    $entries = [];
    while ($row = $result->fetch_assoc()) {

        // Jetzt fügen wir den neuen Teil für das Sammeln der entry_status Daten hinzu
        $entry_id = $row["entry_id"];
        
        $entry_status = [];
        $entry_status_query = "
        SELECT 
            application_status.status AS status, 
			application_status.sending_on AS sending_on, 
			CASE 
				WHEN application_status.status = 20 THEN
					CASE application_status.sending_on
						WHEN 1 THEN 'an Versicherten'
						WHEN 2 THEN 'an Pflegeperson'
						WHEN 3 THEN 'an Pflegedienst'
					END
				ELSE ''
			END AS sending_on_name,
            application_status.status_date AS status_date,
            status_names.name AS status_name
        FROM application_status 
            LEFT JOIN status_names 
                ON application_status.status = status_names.status_id
        WHERE 
            entry_id = ?
        ORDER BY 
            application_status.status_date DESC
        ";
        $entry_status_stmt = $mysqli->prepare($entry_status_query);
        $entry_status_stmt->bind_param("i", $entry_id);

        $entry_status_stmt->execute();
        $entry_status_result = $entry_status_stmt->get_result();

		while ($entry_status_row = $entry_status_result->fetch_assoc()) {
			$entry_status_datetime_formatted = date("d.m.Y H:i", $entry_status_row["status_date"]);
			$entry_status[] = [
				'status_id' => $entry_status_row['status'],
				'sending_on_name' => $entry_status_row['sending_on_name'],
				'status_date' => $entry_status_row['status_date'],
				'status_datetime_formatted' => $entry_status_datetime_formatted,
				'status_name' => $entry_status_row['status_name'],
			];
		}
		
		$row['entry_status_data'] = $entry_status;
		$entries[] = $row;
		
        $entry_status_result->close();
        $entry_status_stmt->close();
    }
    $stmt->close();
    return $entries;
}

function getEntries($mysqli, $where, $limit, $offset, $keyword, $countOnly = false) {
    $sql_where = "";
    $param_types = "";
    $params = [];

    if(isset($where) AND !empty($where)) {
        $sql_where = 'WHERE ' . $where;
    }

    if (!empty($keyword)) {
        $columns = [
            'e.id',
            'e.entry_number',
            'e.import_id',
            'insured_person_data.first_name',
            'insured_person_data.last_name',
            "CONCAT(insured_person_data.first_name, ' ', insured_person_data.last_name)",
            "CONCAT(insured_person_data.last_name, ' ', insured_person_data.first_name)",
            'insurance_data.insurance_number',
            'cgpd.first_name',
            'cgpd.last_name',
            "CONCAT(cgpd.first_name, ' ', cgpd.last_name)",
            "CONCAT(cgpd.last_name, ' ', cgpd.first_name)"
        ];
        if(isset($where) AND !empty($where)) {
            $sql_where = 'WHERE '. $where .' AND ('. implode(' LIKE ? OR ', $columns) . ' LIKE ?)';
        } else {
            $sql_where = 'WHERE (' . implode(' LIKE ? OR ', $columns) . ' LIKE ?)';
        }
        $param_types = str_repeat('s', count($columns));
        $params = array_fill(0, count($columns), "%$keyword%");
    }

    if ($countOnly) {
        // Gesamtanzahl der Einträge zählen
        $count_query = "
            SELECT COUNT(DISTINCT e.id) AS total_entries
            FROM entries e
            LEFT JOIN users u ON e.user_id = u.id
            LEFT JOIN insured_person_data ON e.insured_person_id = insured_person_data.id
            LEFT JOIN insurance_data ON e.insured_person_id = insurance_data.insured_person_id
            LEFT JOIN insurance_companies ON insurance_data.insurance_company_id = insurance_companies.id
            LEFT JOIN care_giver_data cgpd ON insured_person_data.care_giver_person_id = cgpd.id AND cgpd.type = 2
            LEFT JOIN care_giver_data cgsd ON insured_person_data.care_giver_service_id = cgsd.id AND cgsd.type = 3
            LEFT JOIN application_status aps ON e.id = aps.entry_id
            $sql_where
        ";

        $stmt = $mysqli->prepare($count_query);
        if (!$stmt) {
            die("Statement konnte nicht vorbereitet werden: (" . $mysqli->errno . ") " . $mysqli->error);
        }

        if (!empty($params)) {
            $stmt->bind_param($param_types, ...$params);
        }

        if (!$stmt->execute()) {
            die("Execute failed: (" . $stmt->errno . ") " . $stmt->error);
        }
        $result = $stmt->get_result();
        $total_entries = $result->fetch_assoc()['total_entries'];
        $stmt->close();

        return $total_entries;
    } else {
        // Eigentliche Einträge abrufen
        $param_types .= "ii";
        $params = array_merge($params, [$offset, $limit]);

        $select_entries_query = "
            SELECT 
                DISTINCT e.id AS entry_id,
                e.user_id AS user_id,
                e.entry_number AS entry_number,
                e.status AS entry_status,
                CASE 
                    WHEN e.status = 1 AND insurance_data.insurance_type = 2 THEN 'kostenpflichtig bestellt'
                    WHEN e.status = 0 THEN 'ausstehend'
                    WHEN e.status = 1 THEN 'abgeschlossen'
                    ELSE ''
                END AS entry_status_name,
                e.create_date AS entry_create_date,
                e.import_id AS entry_import_id,
                e.complete_date AS entry_complete_date,
                e.compilation_name AS compilation_name,
                e.bed_protectors_amount AS bed_protectors_amount,
                u.type AS user_type,
                CASE 
                    WHEN u.type = 1 THEN 'Versicherter'
                    WHEN u.type = 2 THEN 'Pflegeperson'
                    ELSE ''
                END AS user_type_name,
                insured_person_data.first_name AS insured_person_data_first_name,
                insured_person_data.last_name AS insured_person_data_last_name,
                insurance_data.insurance_type AS insurance_type,
                insurance_data.custom_insurance_company_name AS custom_insurance_company_name,
                CASE 
                    WHEN insurance_type = 1 THEN 'Gesetzlich'
                    WHEN insurance_type = 2 THEN 'Privat'
                    ELSE ''
                END AS insurance_type_short_name,
                insurance_companies.name AS insurance_company_name,
                cgpd.first_name AS care_giver_person_first_name,
                cgpd.last_name AS care_giver_person_last_name
            FROM 
                entries e
                LEFT JOIN users u ON e.user_id = u.id 
                LEFT JOIN insured_person_data ON e.insured_person_id = insured_person_data.id
                LEFT JOIN insurance_data ON e.insured_person_id = insurance_data.insured_person_id
                LEFT JOIN insurance_companies ON insurance_data.insurance_company_id = insurance_companies.id
                LEFT JOIN care_giver_data cgpd ON insured_person_data.care_giver_person_id = cgpd.id AND cgpd.type = 2
                LEFT JOIN care_giver_data cgsd ON insured_person_data.care_giver_service_id = cgsd.id AND cgsd.type = 3
                LEFT JOIN application_status aps ON e.id = aps.entry_id
            $sql_where
            ORDER BY 
                e.create_date DESC
            LIMIT ?, ?
        ";
		//echo $select_entries_query;

        $stmt = $mysqli->prepare($select_entries_query);
        if (!$stmt) {
            die("Statement konnte nicht vorbereitet werden: (" . $mysqli->errno . ") " . $mysqli->error);
        }

        $stmt->bind_param($param_types, ...$params);

        if (!$stmt->execute()) {
            die("Execute failed: (" . $stmt->errno . ") " . $stmt->error);
        }
        $result = $stmt->get_result();

        $entries = [];
        while ($row = $result->fetch_assoc()) {
            // Jetzt fügen wir den neuen Teil für das Sammeln der entry_status Daten hinzu
            $entry_id = $row["entry_id"];
            
            $entry_status = [];
            $entry_status_query = "
            SELECT 
                application_status.status AS status, 
                application_status.sending_on AS sending_on, 
                CASE 
                    WHEN application_status.status = 20 THEN
                        CASE application_status.sending_on
                            WHEN 1 THEN 'an Versicherten'
                            WHEN 2 THEN 'an Pflegeperson'
                            WHEN 3 THEN 'an Pflegedienst'
                        END
                    ELSE ''
                END AS sending_on_name,
                application_status.status_date AS status_date,
                status_names.name AS status_name
            FROM application_status 
                LEFT JOIN status_names ON application_status.status = status_names.status_id
            WHERE 
                entry_id = ?
            ORDER BY 
                application_status.status_date DESC
            ";
            $entry_status_stmt = $mysqli->prepare($entry_status_query);
            $entry_status_stmt->bind_param("i", $entry_id);

            $entry_status_stmt->execute();
            $entry_status_result = $entry_status_stmt->get_result();

            while ($entry_status_row = $entry_status_result->fetch_assoc()) {
                $entry_status_datetime_formatted = date("d.m.Y H:i", $entry_status_row["status_date"]);
                $entry_status[] = [
                    'status_id' => $entry_status_row['status'],
                    'sending_on_name' => $entry_status_row['sending_on_name'],
                    'status_date' => $entry_status_row['status_date'],
                    'status_datetime_formatted' => $entry_status_datetime_formatted,
                    'status_name' => $entry_status_row['status_name'],
                ];
            }
            
            $row['entry_status_data'] = $entry_status;
            $entries[] = $row;
            
            $entry_status_result->close();
            $entry_status_stmt->close();
        }
        $stmt->close();
        return $entries;
    }
}


function getEntries3($mysqli, $where) {


    // SQL-Query vorbereiten
    $select_entries_query = "
        SELECT 
            e.id AS entry_id,
			e.user_id AS user_id,
            e.entry_number AS entry_number,
            e.status AS entry_status,
            CASE 
				WHEN e.status = 1 AND insurance_data.insurance_type = 2 THEN 'kostenpflichtig bestellt'
                WHEN e.status = 0 THEN 'ausstehend'
                WHEN e.status = 1 THEN 'abgeschlossen'
                ELSE ''
            END AS entry_status_name,
            e.create_date AS entry_create_date,
			e.import_id AS entry_import_id,
            e.complete_date AS entry_complete_date,
			e.compilation_name AS compilation_name,
			e.bed_protectors_amount AS bed_protectors_amount,
			u.type AS user_type,
			CASE 
				WHEN u.type = 1 THEN 'Versicherter'
				WHEN u.type = 2 THEN 'Pflegeperson'
				ELSE ''
			END AS user_type_name,
            insured_person_data.first_name AS insured_person_data_first_name,
            insured_person_data.last_name AS insured_person_data_last_name,
            insurance_data.insurance_type AS insurance_type,
            insurance_data.custom_insurance_company_name AS custom_insurance_company_name,
            CASE 
                WHEN insurance_type = 1 THEN 'Gesetzlich'
                WHEN insurance_type = 2 THEN 'Privat'
                ELSE ''
            END AS insurance_type_short_name,
            insurance_companies.name AS insurance_company_name,
			cgpd.first_name AS care_giver_person_first_name,
			cgpd.last_name AS care_giver_person_last_name
        FROM 
            entries e
			-- USER
			LEFT JOIN users u 
				ON e.user_id = u.id 
            LEFT JOIN insured_person_data 
                ON e.insured_person_id = insured_person_data.id
            LEFT JOIN insurance_data 
                ON e.insured_person_id = insurance_data.insured_person_id
            LEFT JOIN insurance_companies 
                ON insurance_data.insurance_company_id = insurance_companies.id
			-- PFLEGEPERSON
			LEFT JOIN care_giver_data cgpd 
				ON insured_person_data.care_giver_person_id = cgpd.id AND cgpd.type = 2
			-- PFLEGEDIENST
			LEFT JOIN care_giver_data cgsd 
				ON insured_person_data.care_giver_service_id = cgsd.id AND cgsd.type = 3
        $where
        ORDER BY 
            e.create_date DESC
    ";
	//echo $select_entries_query;

    $stmt = $mysqli->prepare($select_entries_query);
    if (!$stmt) {
        die("Statement konnte nicht vorbereitet werden: (" . $mysqli->errno . ") " . $mysqli->error);
    }


    if (!$stmt->execute()) {
        die("Execute failed: (" . $stmt->errno . ") " . $stmt->error);
    }
    $result = $stmt->get_result();
	//print_r($result);
    $entries = [];
    while ($row = $result->fetch_assoc()) {

        // Jetzt fügen wir den neuen Teil für das Sammeln der entry_status Daten hinzu
        $entry_id = $row["entry_id"];
        
        $entry_status = [];
        $entry_status_query = "
        SELECT 
            application_status.status AS status, 
			application_status.sending_on AS sending_on, 
			CASE 
				WHEN application_status.status = 20 THEN
					CASE application_status.sending_on
						WHEN 1 THEN 'an Versicherten'
						WHEN 2 THEN 'an Pflegeperson'
						WHEN 3 THEN 'an Pflegedienst'
					END
				ELSE ''
			END AS sending_on_name,
            application_status.status_date AS status_date,
            status_names.name AS status_name
        FROM application_status 
            LEFT JOIN status_names 
                ON application_status.status = status_names.status_id
        WHERE 
            entry_id = ?
        ORDER BY 
            application_status.status_date DESC
        ";
        $entry_status_stmt = $mysqli->prepare($entry_status_query);
        $entry_status_stmt->bind_param("i", $entry_id);

        $entry_status_stmt->execute();
        $entry_status_result = $entry_status_stmt->get_result();

		while ($entry_status_row = $entry_status_result->fetch_assoc()) {
			$entry_status_datetime_formatted = date("d.m.Y H:i", $entry_status_row["status_date"]);
			$entry_status[] = [
				'status_id' => $entry_status_row['status'],
				'sending_on_name' => $entry_status_row['sending_on_name'],
				'status_date' => $entry_status_row['status_date'],
				'status_datetime_formatted' => $entry_status_datetime_formatted,
				'status_name' => $entry_status_row['status_name'],
			];
		}
		
		$row['entry_status_data'] = $entry_status;
		$entries[] = $row;
		
        $entry_status_result->close();
        $entry_status_stmt->close();
    }

    $stmt->close();
    return $entries;
}
function createImport($mysqli, $import_id, $admin_id) {
	$query = "INSERT INTO imports (import_id, admin_id, import_date) VALUES (?, ?, ?)";
	$create_date = time();
	try {
		$stmt_insert = $mysqli->prepare($query);
		$stmt_insert->bind_param("sii", $import_id, $admin_id, $create_date);
		$result = $stmt_insert->execute();
		return $result;
	} catch (Exception $e) {
		$mysqli->rollback();
		throw $e;
	}
}

function processSignature($base64String, $folderPath, $entry_id) {
    error_log("Received signature data: $base64String");
    $data = explode(";base64,", $base64String);
    if (count($data) != 2) {
        error_log("Invalid signature data format");
        return ['success' => false, 'message' => 'Invalid signature data'];
    }
    list($type, $encodedData) = $data;
    $imageType = str_replace('data:image/', '', $type);
    $decodedImage = base64_decode($encodedData);
    if (!$decodedImage) {
        error_log("Decoding the image failed");
        return ['success' => false, 'message' => 'Decoding the image failed'];
    }
    // Ensure directory exists
    if (!is_dir($folderPath)) {
        mkdir($folderPath, 0755, true);
    }
    $filename = $entry_id . '.' . $imageType;
    $filepath = $folderPath . $filename;
    if (file_put_contents($filepath, $decodedImage)) {
        error_log("Image saved as $filename");
        return ['success' => true, 'filename' => $filename];
    } else {
        error_log("Failed to save the image");
        return ['success' => false, 'message' => 'Failed to save the image'];
    }

}

function getCompanyData($mysqli) {
	$sql = "SELECT * FROM company";
    $result = $mysqli->query($sql);
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row;
    }
}

function getCompilationPrices() {
    global $mysqli;
    
    // Daten abrufen
    $sql = "SELECT compilation_max_total_price, compilation_min_total_price FROM settings";
    $result = $mysqli->query($sql);
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row;
    } else {
        return ["error" => "Keine Daten gefunden"];
    }
}

function getCompilations($only_active = false) {
    global $mysqli;
	$where = "";
	if($only_active) {
		$where = "WHERE active = 1";
	}
    $sql = "
	SELECT 
		* 
	FROM 
		compilations 
	$where 
	ORDER BY 
		active DESC,
		sorting ASC
	";
    $result = $mysqli->query($sql);

    if ($result->num_rows > 0) {
        $compilations = $result->fetch_all(MYSQLI_ASSOC);
        foreach ($compilations as &$compilation) {
            $content = json_decode($compilation['products'], true);
            $compilation['products_readable'] = getContentReadable($content);
			// product details
			$compilation['products_details'] = [];
            // Berechnung des Gesamtpreises
            $totalPrice = 0;
            foreach ($content as $product_id => $details) {
				$product = getProductById($product_id);
				$compilation['products_details'][$product_id] = $product;
				$compilation['products_details'][$product_id]['quantity'] = $details['quantity'];
				// price
				$product_price = $product["price"];
				$totalPrice += $product_price * $details['quantity'];
            }
            $compilation['total_price'] = $totalPrice;
        }
        return $compilations;
    } else {
        return false;
    }
}

function getProductById($product_id) {
    global $mysqli;
    $sql = "SELECT * FROM products WHERE id = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param('i', $product_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $product = $result->fetch_assoc();
        return $product;
    }
    $stmt->close();
    return 0;
}

function getProductPriceById($product_id) {
    global $mysqli;
    $sql = "SELECT price FROM products WHERE id = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param('i', $product_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $product = $result->fetch_assoc();
        return $product['price'];
    }
    $stmt->close();
    return 0; // Falls das Produkt nicht gefunden wurde, geben wir 0 zurück
}

function getContentReadable($content) {
    global $mysqli;
    $readable = [];
    foreach ($content as $product_id => $details) {
        $sql = "SELECT name FROM products WHERE id = ?";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param('i', $product_id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $product = $result->fetch_assoc();
            $readable[] = $details['quantity']." x ".$product['name'];
        }
        $stmt->close();
    }
    return $readable; // gibt jetzt ein Array zurück
}

function getProductQuantityInCompilation($content) {
    global $mysqli;
    $readable = [];
    foreach ($content as $product_id => $details) {
        $sql = "SELECT name FROM products WHERE id = ?";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param('i', $product_id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $product = $result->fetch_assoc();
            $readable[] = $details['quantity']." x ".$product['name'];
        }
        $stmt->close();
    }
    return $readable; // gibt jetzt ein Array zurück
}

function mailYourAccountCreated($mysqli, $data) {
	// $data["user_email"]
	$create_account_template_file_subject = __DIR__ . '/../email-templates/user/user_create_account_subject.html';
	if (!file_exists($create_account_template_file_subject)) {
		throw new Exception("E-Mail Template create_account fehlt.");
	}
	$subject = file_get_contents($create_account_template_file_subject);

	$create_account_template_file = __DIR__ . '/../email-templates/user/user_create_account.html';
	if (!file_exists($create_account_template_file)) {
		throw new Exception("E-Mail Template create_account fehlt.");
	}
	$create_account = file_get_contents($create_account_template_file);

	$message = $create_account;
	
	$message = str_replace(
		[
			'{password}',
		],
		[
			$data["user_password"],
		],
		$message
	);
	$data["subject"] = $subject;
	$data["message"] = $message;
	sendMailToUser($mysqli, $data);
}

function mailYourApllicationReceived($mysqli, $data) {
	//$data["user_email"];
	//$data["insurance_type"];
	if($data["insurance_type"] == 1) {
		
		$order_gesetzlich_template_file_subject = __DIR__ . '/../email-templates/user/user_order_gesetzlich_subject.html';
		if (!file_exists($order_gesetzlich_template_file_subject)) {
			throw new Exception("E-Mail Template order_gesetzlich fehlt.");
		}
		$subject = file_get_contents($order_gesetzlich_template_file_subject);
		
		$order_gesetzlich_template_file = __DIR__ . '/../email-templates/user/user_order_gesetzlich.html';
		if (!file_exists($order_gesetzlich_template_file)) {
			throw new Exception("E-Mail Template order_gesetzlich fehlt.");
		}
		$order = file_get_contents($order_gesetzlich_template_file);
	} elseif($data["insurance_type"] == 2) {
		
		$order_privat_template_file_subject = __DIR__ . '/../email-templates/user/user_order_privat_subject.html';
		if (!file_exists($order_privat_template_file_subject)) {
			throw new Exception("E-Mail Template order_privat fehlt.");
		}
		$subject = file_get_contents($order_privat_template_file_subject);
		
		$order_privat_template_file = __DIR__ . '/../email-templates/user/user_order_privat.html';
		if (!file_exists($order_privat_template_file)) {
			throw new Exception("E-Mail Template order_privat fehlt.");
		}
		$order = file_get_contents($order_privat_template_file);
	}

	$message = $order;

	//$data["user_email"];
	$data["subject"] = $subject;
	$data["message"] = $message;
	sendMailToUser($mysqli, $data);
}

function send_mail_to_admin_request_by_post($mysqli, $data) {
	// $data["entry_id"]
	$subject_template_file = __DIR__ . '/../email-templates/admin/admin_request_by_post_subject.html';
	if(!file_exists($subject_template_file)) { 
		throw new Exception("Template fehlt.");
	}
	
	$data["subject"] = file_get_contents($subject_template_file);

	$request_by_post_template_file = __DIR__ . '/../email-templates/admin/admin_request_by_post.html';
	if (!file_exists($request_by_post_template_file)) {
		throw new Exception("Template fehlt.");
	}
	$data["message"] = file_get_contents($request_by_post_template_file);
	
	sendMailToAdmin($mysqli, $data);
}

function insertApplicationStatus($mysqli, $data) {
		
	$insert_status = "INSERT INTO application_status (entry_id, status, status_date) VALUES (?, ?, ?)";
	
	try {
		
		$stmt_insert_status = $mysqli->prepare($insert_status);
		$stmt_insert_status->bind_param("iii", $data["entry_id"], $data["status_id"], $data["status_date"]);
		$stmt_insert_status->execute();
		
		// eingegangen: entry.status auf 1 setzen -> Antrag abschließen, um Zugriff auf "Mein Konto" zu gewährleisten
		if($data["status_id"] == 50) {
			$complete_entry = "UPDATE entries SET status = 1, complete_date = ? WHERE id = ?";
			$stmt_complete_entry = $mysqli->prepare($complete_entry);
			$stmt_complete_entry->bind_param("ii", $data["status_date"], $data["entry_id"]);
			$stmt_complete_entry->execute();
		}
		// falls e-mail verschickt werden soll: E-Mail-Versand wurde bestätigt
		// post_verschickt, eingang, genehmigt, nicht_genehmigt
		if($data["send_mail"] AND in_array($data["status_id"], [21, 50, 60, 70])) {
            $select_email = "SELECT users.email FROM users INNER JOIN entries ON users.id = entries.user_id WHERE entries.id = ?";
            $stmt_select_email = $mysqli->prepare($select_email);
            $stmt_select_email->bind_param("i", $data["entry_id"]);
            $stmt_select_email->execute();
            $result = $stmt_select_email->get_result();
            $row = $result->fetch_assoc();
            $data["user_email"] = $row['email'];
			
			switch($data["status_id"]) {
				// per Post verschickt
				case 21:
					send_mail_to_user_application_form_has_been_sent($mysqli, $data["user_email"]);
					break;
				// eingegangen
				case 50:
					send_mail_to_user_application_received($mysqli, $data);
					break;
				// genehmigt
				case 60:
					send_mail_to_user_application_approved($mysqli, $data["user_email"]);
					break;
				// nicht genehmigt
				case 70:
					send_mail_to_user_application_not_approved($mysqli, $data["user_email"]);
					break;
			}
		}
		
	} catch (Exception $e) {
		
		$mysqli->rollback();
		throw $e;
		
	}
}

function send_mail_to_user_application_received($mysqli, $data) {
	
	$subject_template_file = __DIR__ . '/../email-templates/user/user_application_received_subject.html';
	if (!file_exists($subject_template_file)) {
		throw new Exception("E-Mail Template fehlt.");
	}
	$subject = file_get_contents($subject_template_file);

	$user_application_received_template_file = __DIR__ . '/../email-templates/user/user_application_received.html';
	if (!file_exists($user_application_received_template_file)) {
		throw new Exception("E-Mail Template fehlt.");
	}
	$user_application_received = file_get_contents($user_application_received_template_file);

	$message = $user_application_received;
	
	$data["subject"] = $subject;
	$data["message"] = $message;
	// $data["entry_id"]
	sendMailToUser($mysqli, $data);
}

function send_mail_to_user_application_not_approved($mysqli, $user_email) {
	
	$subject_template_file = __DIR__ . '/../email-templates/user/user_application_not_approved_subject.html';
	if (!file_exists($subject_template_file)) {
		throw new Exception("E-Mail Template fehlt.");
	}
	$subject = file_get_contents($subject_template_file);

	$user_application_not_approved_template_file = __DIR__ . '/../email-templates/user/user_application_not_approved.html';
	if (!file_exists($user_application_not_approved_template_file)) {
		throw new Exception("E-Mail Template fehlt.");
	}
	$user_application_not_approved = file_get_contents($user_application_not_approved_template_file);

	$message = $user_application_not_approved;
	
	$data["user_email"] = $user_email;
	$data["subject"] = $subject;
	$data["message"] = $message;
	sendMailToUser($mysqli, $data);
}

function send_mail_to_user_application_approved($mysqli, $user_email) {
	
	$subject_template_file = __DIR__ . '/../email-templates/user/user_application_approved_subject.html';
	if (!file_exists($subject_template_file)) {
		throw new Exception("E-Mail Template fehlt.");
	}
	$subject = file_get_contents($subject_template_file);

	$user_application_approved_template_file = __DIR__ . '/../email-templates/user/user_application_approved.html';
	if (!file_exists($user_application_approved_template_file)) {
		throw new Exception("E-Mail Template fehlt.");
	}
	$user_application_approved = file_get_contents($user_application_approved_template_file);

	$message = $user_application_approved;
	
	$data["user_email"] = $user_email;
	$data["subject"] = $subject;
	$data["message"] = $message;
	sendMailToUser($mysqli, $data);
}

function send_mail_to_user_application_form_has_been_sent($mysqli, $user_email) {
	
	$subject_template_file = __DIR__ . '/../email-templates/user/user_application_form_has_been_sent_subject.html';
	if (!file_exists($subject_template_file)) {
		throw new Exception("E-Mail Template fehlt.");
	}
	$subject = file_get_contents($subject_template_file);

	$user_application_form_has_been_sent_template_file = __DIR__ . '/../email-templates/user/user_application_form_has_been_sent.html';
	if (!file_exists($user_application_form_has_been_sent_template_file)) {
		throw new Exception("E-Mail Template fehlt.");
	}
	$user_application_form_has_been_sent = file_get_contents($user_application_form_has_been_sent_template_file);

	$message = $user_application_form_has_been_sent;
	
	$data["user_email"] = $user_email;
	$data["subject"] = $subject;
	$data["message"] = $message;
	sendMailToUser($mysqli, $data);
}

function send_mail_to_user_request_by_post($mysqli, $user_email) {
	
	$subject_template_file = __DIR__ . '/../email-templates/user/user_request_by_post_subject.html';
	if (!file_exists($subject_template_file)) {
		throw new Exception("E-Mail Template fehlt.");
	}
	$subject = file_get_contents($subject_template_file);

	$new_application_received_template_file = __DIR__ . '/../email-templates/user/user_request_by_post.html';
	if (!file_exists($new_application_received_template_file)) {
		throw new Exception("E-Mail Template fehlt.");
	}
	$new_application_received = file_get_contents($new_application_received_template_file);

	$message = $new_application_received;
	
	$data["user_email"] = $user_email;
	$data["subject"] = $subject;
	$data["message"] = $message;
	sendMailToUser($mysqli, $data);
}

function mailNewApplicationReceived($mysqli, $data) {
	$subject_template_file = __DIR__ . '/../email-templates/admin/admin_new_application_received_subject.html';
	if (!file_exists($subject_template_file)) {
		throw new Exception("E-Mail Template fehlt.");
	}
	$data["subject"] = file_get_contents($subject_template_file);
	$new_application_received_template_file = __DIR__ . '/../email-templates/admin/admin_new_application_received.html';
	if (!file_exists($new_application_received_template_file)) {
		throw new Exception("E-Mail Template fehlt.");
	}
	$data["message"] = file_get_contents($new_application_received_template_file);
	sendMailToAdmin($mysqli, $data);
}

function getEntryStatus($mysqli, $entry_id) {
    $query = "
	SELECT 
		application_status.status AS status, 
		application_status.status_date AS status_date,
		status_names.name AS status_name
	FROM application_status 
		LEFT JOIN status_names 
			ON application_status.status = status_names.status_id
	WHERE 
		entry_id = ?
	ORDER BY 
		application_status.status_date DESC
	";
    $stmt = $mysqli->prepare($query);
    if (!$stmt) {
        die("Statement konnte nicht vorbereitet werden: (" . $mysqli->errno . ") " . $mysqli->error);
    }

    // Binden Sie die entry_id an das Statement
    if (!$stmt->bind_param("i", $entry_id)) {
        die("Binden der Parameter fehlgeschlagen: (" . $stmt->errno . ") " . $stmt->error);
    }

    if (!$stmt->execute()) {
        die("Ausführung fehlgeschlagen: (" . $stmt->errno . ") " . $stmt->error);
    }
    
    $result = $stmt->get_result();
    // Array für die gesammelten Einträge
    $entries = [];
    // Durch die Ergebnisse gehen und sie im Array speichern
    while ($row = $result->fetch_assoc()) {
        $entries[] = $row;
    }
    // Ressourcen freigeben
    $stmt->close();
    // Gesammelten Einträge zurückgeben
    return $entries;
}

// prüft ob man sich im backend befindet
function is_admin_area() {
    if (defined("IS_ADMIN") AND IS_ADMIN === true) {
        return true;
    }
    return false;
}
function findMatchingCompilation($mysqli, $inputJson) {

    // Abfrage aus der Tabelle "compilations"
    $query = "SELECT * FROM compilations";
    $result = $mysqli->query($query);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $dbJson = $row['products'];
            $compilationName = $row['name'];

            if (areProductsEqual($dbJson, $inputJson)) {
                //$mysqli->close();
                return $compilationName;
            }
        }
    } else {
       // $mysqli->close();
        return false;
    }

    //$mysqli->close();
    return false;
}

function areProductsEqual($json1, $json2) {
/*    var_dump($json1);
    var_dump($json2);*/
    
    // Überprüfung, ob die Variablen bereits Arrays sind
    $array1 = is_array($json1) ? $json1 : json_decode($json1, true);
    $array2 = is_array($json2) ? $json2 : json_decode($json2, true);

    // Nur die Produkt-IDs und Mengen behalten
    $filteredArray1 = [];
    foreach ($array1 as $productID => $details) {
        $filteredArray1[$productID] = $details['quantity'];
    }
    $filteredArray2 = [];
    foreach ($array2 as $productID => $details) {
        $filteredArray2[$productID] = $details['quantity'];
    }

    // Arrays sortieren
    ksort($filteredArray1);
    ksort($filteredArray2);

    // Vergleich für exakte Übereinstimmung
    return $filteredArray1 === $filteredArray2;
}

function checkFields($requiredFields, $optionalFields, &$data, &$missingFields) {
    $allFieldsSet = true;

    foreach ($requiredFields as $field) {
        if (!array_key_exists($field, $_POST) || $_POST[$field] === '' || $_POST[$field] === null) {
            $allFieldsSet = false;
            $missingFields[] = $field;
        } else {
            $data[$field] = $_POST[$field];
        }
    }
    
    foreach ($optionalFields as $field) {
        if (array_key_exists($field, $_POST) && $_POST[$field] !== '') {
            $data[$field] = $_POST[$field];
        } elseif (array_key_exists($field, $_POST) && $_POST[$field] === null) {
            $data[$field] = null;
        }
    }

    return $allFieldsSet;
}

function handleMaterial($materialString) {
    // Entfernen von Leerzeichen und Aufspaltung der Zeichenkette an den Kommata
    $materials = explode(',', str_replace(' ', '', $materialString));

    $result = [];

    // Überprüfung jedes Elements im Array
    foreach ($materials as $material) {
        switch ($material) {
            case 'v':
                $result[] = 'Vinyl';
                break;
            case 'n':
                $result[] = 'Nitril';
                break;
            case 'l':
                $result[] = 'Latex';
                break;
        }
    }

    return implode(', ', $result);
}
function getInsuranceCompanies($mysqli, $type) {
	$select_insurance_companies_query = "SELECT id, name, type FROM insurance_companies WHERE type = $type ORDER BY name ASC";
	$stmt = $mysqli->prepare($select_insurance_companies_query);
	$stmt->execute();
	$result = $stmt->get_result();
	$insurance_companies = array();
	while ($row = $result->fetch_assoc()) {
		$insurance_companies[] = $row;
	}
	return $insurance_companies;
}

function prepareAndBind($mysqli, $query, $types, ...$params) {
    $stmt = $mysqli->prepare($query);
    if (!$stmt) {
		if (defined('DEV') && DEV == 0) {
			throw new Exception("Fehler beim Vorbereiten des SQL-Statements");
		} else {
			throw new Exception("Fehler beim Vorbereiten des SQL-Statements: " . $mysqli->error . ". Query: " . $query);
		}
    }
    if (!$stmt->bind_param($types, ...$params)) {
		if (defined('DEV') && DEV == 0) {
			throw new Exception("Fehler beim Binden der Parameter");
		} else {
			throw new Exception("Fehler beim Binden der Parameter: " . $stmt->error . ". Query: " . $query);
		} 
    }
    return $stmt;
}

function executeStatement($stmt, $query) {
    if (!$stmt->execute()) {
		if (defined('DEV') && DEV == 0) {
			throw new Exception("Fehler beim Ausführen des SQL-Statements");
		} else {
			throw new Exception("Fehler beim Ausführen des SQL-Statements: " . $stmt->error . ". Query: " . $query);
		} 
    }
}

function requestByPost($mysqli, $data) {
	$current_date = time();
	$entry_id = $data["entry_id"];
	$user_id = $data["user_id"];
	$user_email = $data["user_email"];
	$sending_on = $data["sending_on"];
	// per Post angefordert
	$application_status = 20;
	// abgeschlossen
	$entry_status = 1;
	$mysqli->begin_transaction();
	try {
		
		$query_insert = "INSERT INTO application_status (entry_id, status, sending_on, status_date) VALUES (?, ?, ?, ?)";
		
		$stmt_query_insert = $mysqli->prepare($query_insert);
		$stmt_query_insert->bind_param("iiii", $entry_id, $application_status, $sending_on, $current_date);
		$stmt_query_insert->execute();
		
		$query_update = "UPDATE entries SET status = ?, complete_date = ? WHERE id = ? AND user_id = ?";
		
		$stmt_query_update = $mysqli->prepare($query_update);
		$stmt_query_update->bind_param("iiii", $entry_status, $current_date, $entry_id, $user_id);
		$stmt_query_update->execute();
		
		$mysqli->commit();
		
		// if not localhost, send emails ...
		if(DEV != 1) {
			// send email to user
			send_mail_to_user_request_by_post($mysqli, $user_email);
			// send email to admin
			send_mail_to_admin_request_by_post($mysqli, $data);
		}
		
	} catch (Exception $e) {
		$mysqli->rollback();
		throw $e;
	}
}

function completeApplicationDigital($mysqli, $data) {
	$entry_id = $data["entry_id"];
	$user_id = $data["user_id"];
	//$data["user_email"];
	//$data["insurance_type"];
	$status = 1;
	// digital abgeschlossen
	if($data["insurance_type"] == 1) {
		$application_status = 10;
	// kostenpflichtig bestellt
	} elseif($data["insurance_type"] == 2) {
		$application_status = 11;
	}
	$current_date = time();
	$insert_status = "INSERT INTO application_status (entry_id, status, status_date) VALUES (?, ?, ?)";
	$stmt_complete_application_query = "UPDATE entries SET status = ?, complete_date = ? WHERE id = ? AND user_id = ?";
	$mysqli->begin_transaction();
	try {
		
		$stmt_insert_status = $mysqli->prepare($insert_status);
		$stmt_insert_status->bind_param("iii", $entry_id, $application_status, $current_date);
		$stmt_insert_status->execute();
		
		$stmt_complete_application = $mysqli->prepare($stmt_complete_application_query);
		$stmt_complete_application->bind_param("iiii", $status, $current_date, $entry_id, $user_id);
		$stmt_complete_application->execute();
		$mysqli->commit();

		// $data["user_email"], $data["insurance_type"];
		// send email to user
		mailYourApllicationReceived($mysqli, $data);
		// send email to admin
		mailNewApplicationReceived($mysqli, $data);
	} catch (Exception $e) {
		$mysqli->rollback();
		throw $e;
	}
}

function updateInsuredPersonData($mysqli, $data) {
	$mysqli->begin_transaction();
    $salutation = filter_var($data["insured_person_salutation"], FILTER_VALIDATE_INT);
    $first_name = htmlspecialchars($data["insured_person_first_name"], ENT_QUOTES, 'UTF-8');
    $last_name = htmlspecialchars($data["insured_person_last_name"], ENT_QUOTES, 'UTF-8');
    $birth_date = htmlspecialchars($data["insured_person_birth_date"], ENT_QUOTES, 'UTF-8');
    $email = filter_var($data["insured_person_email"], FILTER_VALIDATE_EMAIL);
    $phone = htmlspecialchars($data["insured_person_phone"], ENT_QUOTES, 'UTF-8');
    $street = htmlspecialchars($data["insured_person_street"], ENT_QUOTES, 'UTF-8');
    $address_addition = isset($data["insured_person_address_addition"]) ? htmlspecialchars($data["insured_person_address_addition"], ENT_QUOTES, 'UTF-8') : NULL;
    $zipcode = htmlspecialchars($data["insured_person_zipcode"], ENT_QUOTES, 'UTF-8');
    $city = htmlspecialchars($data["insured_person_city"], ENT_QUOTES, 'UTF-8');
    $insured_person_id = filter_var($data["insured_person_id"], FILTER_VALIDATE_INT);
    $insured_person_address_id = filter_var($data["insured_person_address_id"], FILTER_VALIDATE_INT);
    $insurance_type = htmlspecialchars($data["insurance_type"], ENT_QUOTES, 'UTF-8');
    $insurance_number = htmlspecialchars($data["insurance_number"], ENT_QUOTES, 'UTF-8');
    $insurance_company_id = isset($data["insurance_company_id"]) && !empty($data["insurance_company_id"]) ? filter_var($data["insurance_company_id"], FILTER_VALIDATE_INT) : NULL;
    $custom_insurance_company_name = isset($data["custom_insurance_company_name"]) && !empty($data["custom_insurance_company_name"]) ? htmlspecialchars($data["custom_insurance_company_name"], ENT_QUOTES, 'UTF-8') : NULL;
    $insurance_aid = isset($data["insurance_aid"]) ? filter_var($data["insurance_aid"], FILTER_VALIDATE_BOOLEAN) : 0;
    $care_level = filter_var($data["care_level"], FILTER_VALIDATE_INT);
    $care_level_since = isset($data["care_level_since"]) && !empty($data["care_level_since"]) ? htmlspecialchars($data["care_level_since"], ENT_QUOTES, 'UTF-8') : NULL;
    $current_date = time();
	
    $update_insured_person_data_query = "UPDATE insured_person_data SET salutation = ?, first_name = ?, last_name = ?, birth_date = ?, update_date = ? WHERE id = ?";
    $update_insurance_data_query = "UPDATE insurance_data SET insurance_type = ?, insurance_number = ?, insurance_company_id = ?, custom_insurance_company_name = ?, insurance_aid = ?, care_level = ?, care_level_since = ?, update_date = ? WHERE insured_person_id = ?";
    $update_insured_person_address_query = "UPDATE addresses SET street = ?, address_addition = ?, zipcode = ?, city = ?, update_date = ? WHERE id = ?";

	try {
		$update_insured_person_data = prepareAndBind($mysqli, $update_insured_person_data_query, "isssii", $salutation, $first_name, $last_name, $birth_date, $current_date, $insured_person_id);
		$update_insured_person_data->execute();
		
		$update_insured_person_address = prepareAndBind($mysqli, $update_insured_person_address_query, "ssisii", $street, $address_addition, $zipcode, $city, $current_date, $insured_person_address_id);
		$update_insured_person_address->execute();
		
		$update_insurance_data = prepareAndBind($mysqli, $update_insurance_data_query, "isisiisii", $insurance_type, $insurance_number, $insurance_company_id, $custom_insurance_company_name, $insurance_aid, $care_level, $care_level_since, $current_date, $insured_person_id);
		$update_insurance_data->execute();	
		
		updateContactData($mysqli, 1, $phone, $email, $insured_person_id);
		
        $mysqli->commit();
    } catch (Exception $e) {
        $mysqli->rollback();
		if (defined('DEV') && DEV == 0) {
			throw new Exception('Fehler beim Update');
		} else {
			throw new Exception('Fehler beim Update: ' . $e->getMessage());
		}
    }
}

function updateContactData($mysqli, $owner_type, $phone, $email, $owner_id) {
	
	try {
		
		$update_contact_data_query = "UPDATE contact_data SET owner_type = ?, phone = ?, email = ? WHERE owner_id = ?";
        $update_contact_data = prepareAndBind($mysqli, $update_contact_data_query, "issi", $owner_type, $phone, $email, $owner_id);
        $update_contact_data->execute();
		$affected_rows = $update_contact_data->affected_rows;
        $update_contact_data->close();
		return $affected_rows > 0;
		
    } catch (Exception $e) {
		if (defined('DEV') && DEV == 0) {
			throw new Exception('Fehler beim Update');
		} else {
			throw new Exception('Fehler beim Update: ' . $e->getMessage());
		}
    }
}

function updateAccount($mysqli, $data) {
	$user_id = filter_var($data["user_id"], FILTER_VALIDATE_INT);
	$user_type = filter_var($data["user_type"], FILTER_VALIDATE_INT);
	$update_user_account_query = "UPDATE users SET type = ?, update_date = ? WHERE id = ?";
	$current_date = time();
	try {
		$create_care_giver_person = prepareAndBind($mysqli, $update_user_account_query, "iii", $user_type, $current_date, $user_id);
		$create_care_giver_person->execute();
		$care_giver_person_id = $mysqli->insert_id;
		$create_care_giver_person->close();
		return $care_giver_person_id;
	} catch (Exception $e) {
		if (defined('DEV') && DEV == 0) {
			throw new Exception('Fehler beim Update');
		} else {
			throw new Exception('Fehler beim Update: ' . $e->getMessage());
		}
	}
}

function executeImport($mysqli, $data) {
	
	try {
        $mysqli->begin_transaction();
		
		if (!isset($data["care_giver_service_id"]) OR empty($data["care_giver_service_id"])) {
			throw new Exception('care_giver_service_id empty');
		}
		
		$care_giver_service_id = $data["care_giver_service_id"];
		
		$current_date = time();
		$user_id = $data['user_id'];
		$bed_protectors_amount = $data["bed_protectors_amount"];
		$products = $data['products'];
		$compilation_name = $data['compilation_name'];
		
		// insert address
		$street = $data["insured_person_street"];
		if(isset($data["insured_person_address_addition"]) AND !empty($data["insured_person_address_addition"])) {
			$address_addition = $data["insured_person_address_addition"];
		} else {
			$address_addition = NULL;
		}
		$zipcode = $data["insured_person_zipcode"];
		$city = $data["insured_person_city"];
		$address_id = insertAddress($mysqli, $street, $address_addition, $zipcode, $city, $current_date);

		// insert insured person
		if(isset($data["insured_person_salutation"]) AND !empty($data["insured_person_salutation"])) {
			$salutation = $data["insured_person_salutation"];
		} else {
			$salutation = NULL;
		}
		$first_name = $data["insured_person_first_name"];
		$last_name = $data["insured_person_last_name"];
		$birth_date = $data["insured_person_birth_date"];
		if(isset($data["care_giver_person_id"]) AND !empty($data["care_giver_person_id"])) {
			$care_giver_person_id = $data["care_giver_person_id"];
		} else {
			$care_giver_person_id = NULL;
		}

		if(!$insured_person_id = insertInsuredPerson(
			$mysqli, 
			$salutation, 
			$first_name, 
			$last_name, 
			$birth_date,
			$care_giver_person_id,
			$care_giver_service_id,
			$address_id, 
			$current_date
		)) {
			return false;
		}

		// insert contact data of insured person
		if(isset($data["insured_person_phone"]) OR isset($data["insured_person_email"])) {
			$owner_type = 1; /* Versicherter */
			if(isset($data["insured_person_phone"]) AND !empty($data["insured_person_phone"])) {
				$insured_person_phone = $data["insured_person_phone"];
			} else {
				$insured_person_phone = NULL;
			}
			if(isset($data["insured_person_email"]) AND !empty($data["insured_person_email"])) {
				$insured_person_email = $data["insured_person_email"];
			} else {
				$insured_person_email = NULL;
			}
			insertContactData($mysqli, $owner_type, $insured_person_id, $insured_person_phone, $insured_person_email);
		}
		
		// insert entry
		if(isset($data['import_id']) AND !empty($data['import_id'])) {
			$import_id = $data['import_id'];
			
			if(isset($data['supplier_change']) AND !empty($data['supplier_change'])) {
				$supplier_change = $data['supplier_change'];
			} else {
				$supplier_change = NULL;
			}
			if(isset($data['supplier_change_delivery_start']) AND !empty($data['supplier_change_delivery_start'])) {
				$supplier_change_delivery_start = $data['supplier_change_delivery_start'];
			} else {
				$supplier_change_delivery_start = NULL;
			}
			$entry_id = insertEntry(
				$mysqli,
				$user_id,
				$products,
				$compilation_name,
				$bed_protectors_amount,
				$insured_person_id,
				$supplier_change,
				$supplier_change_delivery_start,
				$current_date,
				$import_id
			);
		} else {
			return false;
		}
		
		// insert insurance data
		$insurance_type = $data['insurance_type'];
		$insurance_number = $data['insurance_number'];
		if(isset($data['insurance_company_id']) AND !empty($data['insurance_company_id'])) {
			$insurance_company_id = $data['insurance_company_id'];
		} else {
			$insurance_company_id = NULL;
		}
		if(isset($data['custom_insurance_company_name']) AND !empty($data['custom_insurance_company_name'])) {
			$custom_insurance_company_name = $data['custom_insurance_company_name'];
		} else {
			$custom_insurance_company_name = NULL;
		}
		$care_level = $data['care_level'];
		if(isset($data['care_level_since']) AND !empty($data['care_level_since'])) {
			$care_level_since = $data['care_level_since'];
		} else {
			$care_level_since = NULL;
		}
		insertInsuranceData(
			$mysqli,
			$insured_person_id,
			$insurance_type,
			$insurance_number,
			$insurance_company_id,
			$custom_insurance_company_name,
			$care_level,
			$care_level_since,
			$current_date
		);

		$mysqli->commit();
		
    } catch (Exception $e) {
        $mysqli->rollback();
        throw $e;
    }
	return $entry_id;
}

function createAccount($mysqli, $data) {
	try {
        $mysqli->begin_transaction();
		$current_date = time();
		// TODO: more data to check
		validateInputData($data);
		$bed_protectors_amount = $data["bed_protectors_amount"];

		// create user
    	$user_type = filter_var($data["user_type"], FILTER_VALIDATE_INT);
		$user_email = filter_var($data["user_email"], FILTER_VALIDATE_EMAIL);
		$result = createUser($mysqli, $user_type, $user_email, $current_date);
		$user_id = $result['user_id'];
		$data["user_email"] = $user_email;
		$data["user_password"] = $result['password'];
		
		// insert address
		$street = $data["insured_person_street"];
		if(isset($data["insured_person_address_addition"]) AND !empty($data["insured_person_address_addition"])) {
			$address_addition = $data["insured_person_address_addition"];
		} else {
			$address_addition = NULL;
		}
		$zipcode = $data["insured_person_zipcode"];
		$city = $data["insured_person_city"];
		$address_id = insertAddress($mysqli, $street, $address_addition, $zipcode, $city, $current_date);

		// insert insured person
		if(isset($data["insured_person_salutation"]) AND !empty($data["insured_person_salutation"])) {
			$salutation = $data["insured_person_salutation"];
		} else {
			$salutation = NULL;
		}
		$first_name = $data["insured_person_first_name"];
		$last_name = $data["insured_person_last_name"];
		$birth_date = $data["insured_person_birth_date"];
		$care_giver_person_id = NULL; 
		$care_giver_service_id = NULL;
		$insured_person_id = insertInsuredPerson($mysqli, $salutation, $first_name, $last_name, $birth_date, $care_giver_person_id, $care_giver_service_id, $address_id, $current_date);

		// insert contact data of insured person
		$owner_type = 1; /* Versicherter */
		if(isset($data["insured_person_phone"]) AND !empty($data["insured_person_phone"])) {
			$insured_person_phone = $data["insured_person_phone"];
		} else {
			$insured_person_phone = NULL;
		}
		if(isset($data["insured_person_email"]) AND !empty($data["insured_person_email"])) {
			$insured_person_email = $data["insured_person_email"];
		} else {
			$insured_person_email = NULL;
		}
		insertContactData($mysqli, $owner_type, $insured_person_id, $insured_person_phone, $insured_person_email);

		// insert entry
		$import_id = NULL;
		$supplier_change = NULL;
		$supplier_change_delivery_start = NULL;
		$entry_id = insertEntry(
			$mysqli, 
			$user_id, 
			$data['products'], 
			$data['compilation_name'], 
			$bed_protectors_amount, 
			$insured_person_id, 
			$supplier_change, 
			$supplier_change_delivery_start,
			$current_date,
			$import_id
		);
		
		$data["entry_id"] = $entry_id;
		mailYourAccountCreated($mysqli, $data);

		// insert agreements
		if(isset($data["agreement_marketing"]) AND !empty($data["agreement_marketing"])) {
			$agreement_marketing = $data["agreement_marketing"];
		} else {
			$agreement_marketing = NULL;
		}
		insertAgreements($mysqli, NULL, $entry_id, $agreement_marketing);

		// insert insurance data
		$insurance_type = $data['insurance_type'];
		$insurance_number = $data['insurance_number'];
		if(isset($data['insurance_company_id']) AND !empty($data['insurance_company_id'])) {
			$insurance_company_id = $data['insurance_company_id'];
		} else {
			$insurance_company_id = NULL;
		}
		if(isset($data['custom_insurance_company_name']) AND !empty($data['custom_insurance_company_name'])) {
			$custom_insurance_company_name = $data['custom_insurance_company_name'];
		} else {
			$custom_insurance_company_name = NULL;
		}
		$care_level = $data['care_level'];
		if(isset($data['care_level_since']) AND !empty($data['care_level_since'])) {
			$care_level_since = $data['care_level_since'];
		} else {
			$care_level_since = NULL;
		}
		insertInsuranceData($mysqli, $insured_person_id, $insurance_type, $insurance_number, $insurance_company_id, $custom_insurance_company_name, $care_level, $care_level_since, $current_date);

		setSessionVariables($user_id, $user_email, $user_type);
		
		$mysqli->commit();
		
    } catch (Exception $e) {
        $mysqli->rollback();
        throw $e;
    }
}

function createEmptyCareGiverPerson($mysqli, $user_type, $insured_person_id) {
	$create_care_giver_person_query = "INSERT INTO care_giver_data (type, insured_person_id, create_date) VALUES (?,?,?)";
	$create_date = time();
	try {
		$create_care_giver_person = prepareAndBind($mysqli, $create_care_giver_person_query, "iii", $user_type, $insured_person_id, $create_date);
		$create_care_giver_person->execute();
		$care_giver_person_id = $mysqli->insert_id;
		$create_care_giver_person->close();
		return $care_giver_person_id;
	} catch (Exception $e) {
		if (defined('DEV') && DEV == 0) {
			throw new Exception('Fehler beim Update');
		} else {
			throw new Exception('Fehler beim Update: ' . $e->getMessage());
		}
	}
}

function insertContactData($mysqli, $owner_type, $owner_id, $phone, $email) {
	$insert_contact_data_query = "INSERT INTO contact_data (owner_type, owner_id, phone, email, create_date) VALUES (?, ?, ?, ?, ?)";
	$create_date = time();
	try {
		$insert_contact_data = prepareAndBind($mysqli, $insert_contact_data_query, "iissi", $owner_type, $owner_id, $phone, $email, $create_date);
		$insert_contact_data->execute();
		$contact_data_owner_id = $mysqli->insert_id;
		$insert_contact_data->close();
		return $contact_data_owner_id;
	} catch (Exception $e) {
		if (defined('DEV') && DEV == 0) {
			throw new Exception('Fehler beim Update');
		} else {
			throw new Exception('Fehler beim Update: ' . $e->getMessage());
		}
	}
}

function validateInputData($data) {
    if (!isset($data['products']) || empty($data['products'])) {
        throw new Exception('Produkte sind erforderlich.');
    }
}

function createUser($mysqli, $user_type, $user_email, $current_date) {
    $check_email_query = "SELECT id FROM users WHERE email = ?";
    $create_user_query = "INSERT INTO users (type, email, password, password_not_hashed) VALUES (?, ?, ?, ?)";
    
    // Überprüfen, ob die E-Mail-Adresse bereits existiert
    $stmt_check_email = prepareAndBind($mysqli, $check_email_query, "s", $user_email);
    $stmt_check_email->execute();
    $stmt_check_email->store_result();
    if ($stmt_check_email->num_rows > 0) {
        throw new Exception('Die angegebene E-Mail-Adresse existiert bereits. Bitte verwenden Sie eine andere E-Mail-Adresse oder melden Sie sich an, wenn Sie bereits ein Konto haben.');
    }
    $stmt_check_email->close();

    // Generieren eines neuen Passworts
    $password = generatePassword();
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Einfügen des neuen Benutzers
    try {
        $stmt_create_user = prepareAndBind($mysqli, $create_user_query, "isss", $user_type, $user_email, $hashedPassword, $password);
        $stmt_create_user->execute();
        $user_id = $mysqli->insert_id;
        $stmt_create_user->close();
        
        //return $user_id;  // Rückgabe der User-ID für weitere Aktionen
		return ['user_id' => $user_id, 'password' => $password];

    } catch (Exception $e) {
		if (defined('DEV') && DEV == 0) {
			throw new Exception('Fehler beim Einfügen des Benutzers');
		} else {
			throw new Exception('Fehler beim Einfügen des Benutzers: ' . $e->getMessage());
		}
    }
}

function insertAddress($mysqli, $street, $address_addition, $zipcode, $city, $current_date) {
    $create_address_query = "INSERT INTO addresses (street,address_addition,zipcode,city,create_date) VALUES (?,?,?,?,?)";
    
    try {
        $stmt_create_address = prepareAndBind($mysqli, $create_address_query, 'ssisi', $street, $address_addition, $zipcode, $city, $current_date);
        $stmt_create_address->execute();
        $address_id = $mysqli->insert_id;
        $stmt_create_address->close();
        return $address_id;
    } catch (Exception $e) {
		if (defined('DEV') && DEV == 0) {
			throw new Exception('Fehler beim Einfügen der Adresse');
		} else {
			throw new Exception('Fehler beim Einfügen der Adresse: ' . $e->getMessage());
		}
    }
}

function insertInsuredPerson($mysqli, $salutation, $first_name, $last_name, $birth_date, $care_giver_person_id, $care_giver_service_id, $address_id, $current_date) {
    $create_insured_person_query = "INSERT INTO insured_person_data (salutation, first_name, last_name, birth_date, care_giver_person_id, care_giver_service_id, address_id, create_date) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
	
	if(empty($care_giver_person_id)) {
		$care_giver_person_id = NULL;
	}
	if(empty($care_giver_service_id)) {
		$care_giver_service_id = NULL;
	}
    
    try {
        $stmt_create_insured_person = prepareAndBind($mysqli, $create_insured_person_query, "isssiiii", $salutation, $first_name, $last_name, $birth_date, $care_giver_person_id, $care_giver_service_id, $address_id, $current_date);
        $stmt_create_insured_person->execute();
        $insured_person_id = $mysqli->insert_id;
        $stmt_create_insured_person->close();
        return $insured_person_id;
    } catch (Exception $e) {
		if (defined('DEV') && DEV == 0) {
			throw new Exception('Fehler beim Einfügen der versicherten Person');
		} else {
			throw new Exception('Fehler beim Einfügen der versicherten Person: ' . $e->getMessage());
		}
    }
}

function updateChoose($mysqli, $data) {
	try {
		$products = json_encode($data["products"]);
		if(isset($data["compilation_name"])) {
			$compilation_name = $data["compilation_name"];
		} else {
			$compilation_name = "";
		}
		$bed_protectors_amount = $data["bed_protectors_amount"];
		$entry_id = $data["entry_id"];
		$user_id = $data["user_id"];
		$update_entry_products_query = "UPDATE entries SET products = ?, compilation_name = ?, bed_protectors_amount = ? WHERE id = ? AND user_id = ?";
        $update_entry_products = prepareAndBind($mysqli, $update_entry_products_query, 'ssiii', $products, $compilation_name, $bed_protectors_amount, $entry_id, $user_id);
        $update_entry_products->execute();
		if ($update_entry_products->error) {
			throw new Exception('Fehler bei der Datenbankaktualisierung: ' . $update_entry_products->error);
		}
		$affected_rows = $update_entry_products->affected_rows;
        $update_entry_products->close();
		return $affected_rows > 0;

    } catch (Exception $e) {
		if (defined('DEV') && DEV == 0) {
			throw new Exception('Fehler beim Update des Eintrags mit Produkten');
		} else {
			throw new Exception('Fehler beim Update des Eintrags mit Produkten: ' . $e->getMessage());
		}
    }
}

function generateEntryNumber($autoIncrementID) {
    $today = new DateTime(); // Aktuelles Datum und Uhrzeit
    $year = substr($today->format('Y'), -2); // Jahr als 2-stellige Zahl (letzte beiden Ziffern)
    $month = $today->format('m'); // Monat als 2-stellige Zahl
    $day = $today->format('d'); // Tag als 2-stellige Zahl
    
    $idStr = str_pad($autoIncrementID, 4, '0', STR_PAD_LEFT);
    
    return "BX{$year}{$month}{$day}{$idStr}";
}

function insertAgreements($mysqli, $agreement_id, $entry_id, $marketing) {
	$query = "
	INSERT INTO agreements (id, entry_id, marketing) 
	VALUES (?, ?, ?)
	ON DUPLICATE KEY UPDATE 
		marketing = ?
	";
	try {
		$stmt = $mysqli->prepare($query);
		$stmt->bind_param("iiii", $agreement_id, $entry_id, $marketing, $marketing);
		$stmt->execute();
		$affectedRows = $stmt->affected_rows;
		$stmt->close();
		return $affectedRows;
		
	} catch (Exception $e) {
		if (defined('DEV') && DEV == 0) {
			throw new Exception('Es ist ein Fehler aufgetreten. Versuche es später erneut.');
		} else {
			throw new Exception('Fehler beim Einfügen des Eintrags: ' . $e->getMessage());
		}
	}
}

function insertEntry(
	$mysqli,
	$user_id,
	$products,
	$compilation_name,
	$bed_protectors_amount,
	$insured_person_id,
	$supplier_change,
	$supplier_change_delivery_start,
	$current_date,
	$import_id
) {
    $create_entry_query = "
	INSERT INTO entries (
		entry_number, 
		user_id, 
		products, 
		compilation_name, 
		bed_protectors_amount, 
		insured_person_id, 
		supplier_change, 
		supplier_change_delivery_start, 
		create_date, 
		import_id
		) 
	VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
	$products = html_entity_decode($products, ENT_QUOTES);
	
	if(!isset($import_id) OR empty($import_id)) {
		$import_id = NULL;
	}
	if(!isset($supplier_change) OR empty($supplier_change)) {
		$supplier_change = NULL;
	}
	if(!isset($supplier_change_delivery_start) OR empty($supplier_change_delivery_start)) {
		$supplier_change_delivery_start = NULL;
	}
	
    try {
        // Erstelle einen Eintrag mit einer temporären entry_number
        $temp_entry_number = "TEMP";
		$stmt_create_entry = prepareAndBind($mysqli, $create_entry_query, 'sissiiisis', $temp_entry_number, $user_id, $products, $compilation_name, $bed_protectors_amount, $insured_person_id, $supplier_change, $supplier_change_delivery_start, $current_date, $import_id);
        $stmt_create_entry->execute();
		if ($stmt_create_entry->errno) {
			throw new Exception("Fehler bei der Datenbankoperation (create_entry): " . $stmt_create_entry->error);
		}
        $entry_id = $mysqli->insert_id; // AUTO_INCREMENT ID erhalten
        $stmt_create_entry->close();

        // Generiere die tatsächliche entry_number basierend auf der AUTO_INCREMENT ID
        $entry_number = generateEntryNumber($entry_id);

        // Aktualisiere den Eintrag mit der generierten entry_number
        $update_entry_query = "UPDATE entries SET entry_number = ? WHERE id = ?";
        $stmt_update_entry = prepareAndBind($mysqli, $update_entry_query, 'si', $entry_number, $entry_id);
        $stmt_update_entry->execute();
		if ($stmt_update_entry->errno) {
			throw new Exception("Fehler bei der Datenbankoperation: " . $stmt_update_entry->error);
		}
        $stmt_update_entry->close();

        return $entry_id;
        
    } catch (Exception $e) {
		if (defined('DEV') && DEV == 0) {
			throw new Exception('Es ist ein Fehler aufgetreten. Versuche es später erneut.');
		} else {
			throw new Exception('Fehler beim Einfügen des Eintrags: ' . $e->getMessage());
		}
    }
}

function insertInsuranceData($mysqli, $insured_person_id, $insurance_type, $insurance_number, $insurance_company_id, $custom_insurance_company_name, $care_level, $care_level_since, $current_date) {
    $create_insurance_data_query = "INSERT INTO insurance_data (insured_person_id, insurance_type, insurance_number, insurance_company_id, custom_insurance_company_name, care_level, care_level_since, create_date) VALUES (?,?,?,?,?,?,?,?)";
	if(!isset($insurance_company_id) OR empty($insurance_company_id)) {
		$insurance_company_id = NULL;
	}
	if(!isset($insurance_company_id) OR empty($insurance_company_id)) {
		$insurance_company_id = NULL;
	}
	if(!isset($custom_insurance_company_name) OR empty($custom_insurance_company_name)) {
		$custom_insurance_company_name = NULL;
	}
	if(!isset($care_level_since) OR empty($care_level_since)) {
		$care_level_since = NULL;
	}
    try {
        $stmt_create_insurance_data = prepareAndBind($mysqli, $create_insurance_data_query, 'iisisisi', $insured_person_id, $insurance_type, $insurance_number, $insurance_company_id, $custom_insurance_company_name, $care_level, $care_level_since, $current_date);
        $stmt_create_insurance_data->execute();
        $insurance_data_id = $mysqli->insert_id;
        $stmt_create_insurance_data->close();
        return $insurance_data_id;
    } catch (Exception $e) {
		if (defined('DEV') && DEV == 0) {
			throw new Exception('Es ist ein Fehler aufgetreten. Versuche es später erneut.');
		} else {
			throw new Exception('Fehler beim Einfügen des Eintrags: ' . $e->getMessage());
		}
    }
}

function setSessionVariables($user_id, $user_email, $user_type) {
    $_SESSION['loggedin'] = true;
    $_SESSION['user_id'] = $user_id;
    $_SESSION['email'] = $user_email;
	$_SESSION['user_type'] = $user_type;
}

function updateAddress($mysqli, $address) {
	if(!isset($address['id'])) {
		return false;
	}
	$address_id = $address['id'];
	$current_date = time();
	$company = $street = $address_addition = $zipcode = $city = NULL;

	if(isset($address['company'])) {
		$company = $address['company'];
	}
	if(isset($address['street'])) {
		$street = $address['street'];
	}
	if(isset($address['address_addition'])) {
		$address_addition = $address['address_addition'];
	}
	if(isset($address['zipcode'])) {
		$zipcode = $address['zipcode'];
	}
	if(isset($address['city'])) {
		$city = $address['city'];
	}
	// update care giver address
	$update_query = "UPDATE addresses SET company = ?, street = ?, address_addition = ?, zipcode = ?, city = ?, update_date = ? WHERE id = ?";
	$update = $mysqli->prepare($update_query);
	$update->bind_param("sssisii", $company, $street, $address_addition, $zipcode, $city, $current_date, $address_id);
	$result = $update->execute();
	$update->close();
	return $result;
}

function updateCareGiverMainData($mysqli, $care_giver_main_data) {
	if(!isset($care_giver_main_data['care_giver_id'])) {
		return false;
	}
	if(!isset($care_giver_main_data['care_giver_type'])) {
		return false;
	}
	$care_giver_id = filter_var($care_giver_main_data['care_giver_id'], FILTER_VALIDATE_INT);
	$care_giver_type = filter_var($care_giver_main_data['care_giver_type'], FILTER_VALIDATE_INT);
	$current_date = time();
	$care_giver_company = $care_giver_salutation = $care_giver_first_name = $care_giver_last_name = NULL;

	if(isset($care_giver_main_data['care_giver_company'])) {
		$care_giver_company = htmlspecialchars($care_giver_main_data['care_giver_company'], ENT_QUOTES, 'UTF-8');
	}
	if(isset($care_giver_main_data['care_giver_salutation'])) {
		$care_giver_salutation = htmlspecialchars($care_giver_main_data['care_giver_salutation'], ENT_QUOTES, 'UTF-8');
	}
	if(isset($care_giver_main_data['care_giver_first_name'])) {
		$care_giver_first_name = htmlspecialchars($care_giver_main_data['care_giver_first_name'], ENT_QUOTES, 'UTF-8');
	}
	if(isset($care_giver_main_data['care_giver_last_name'])) {
		$care_giver_last_name = htmlspecialchars($care_giver_main_data['care_giver_last_name'], ENT_QUOTES, 'UTF-8');
	}
	// update care giver main data
	$update_query = "UPDATE care_giver_data SET company = ?, salutation = ?, first_name = ?, last_name = ?, update_date = ? WHERE id = ? AND type = ?";
	$update = $mysqli->prepare($update_query);
	$update->bind_param("sissiii", $care_giver_company, $care_giver_salutation, $care_giver_first_name, $care_giver_last_name, $current_date, $care_giver_id, $care_giver_type);
	$result = $update->execute();
	$update->close();
	return $result;
}

function updateCareGiverAllData($mysqli, $data) {
	
	$current_date = time();
	$care_giver_address_id = $data["care_giver_address_id"];
	$care_giver_id = $data["care_giver_id"];
	$care_giver_type = 0;
	$care_giver_type = $data["care_giver_type"];

	if(isset($data["care_giver_company"]) AND !empty($data["care_giver_company"])) {
		$care_giver_company = htmlspecialchars($data["care_giver_company"], ENT_QUOTES, 'UTF-8');
	} else {
		$care_giver_company = NULL;
	}
	if(isset($data["care_giver_salutation"]) AND !empty($data["care_giver_salutation"])) {
		$care_giver_salutation = filter_var($data["care_giver_salutation"], FILTER_VALIDATE_INT);
	} else {
		$care_giver_salutation = NULL;
	}
	if(isset($data["care_giver_first_name"]) AND !empty($data["care_giver_first_name"])) {
		$care_giver_first_name = htmlspecialchars($data["care_giver_first_name"], ENT_QUOTES, 'UTF-8');
	} else {
		$care_giver_first_name = NULL;
	}
	if(isset($data["care_giver_last_name"]) AND !empty($data["care_giver_last_name"])) {
		$care_giver_last_name = htmlspecialchars($data["care_giver_last_name"], ENT_QUOTES, 'UTF-8');
	} else {
		$care_giver_last_name = NULL;
	}
	$care_giver_street = $data["care_giver_street"];
	if(isset($data["care_giver_address_addition"]) AND !empty($data["care_giver_address_addition"])) {
		$care_giver_address_addition = htmlspecialchars($data["care_giver_address_addition"], ENT_QUOTES, 'UTF-8');
	} else {
		$care_giver_address_addition = NULL;
	}
	$care_giver_zipcode = htmlspecialchars($data["care_giver_zipcode"], ENT_QUOTES, 'UTF-8');
	$care_giver_city = htmlspecialchars($data["care_giver_city"], ENT_QUOTES, 'UTF-8');
	if(isset($data["care_giver_phone"]) AND !empty($data["care_giver_phone"])) {
		$care_giver_phone = htmlspecialchars($data["care_giver_phone"], ENT_QUOTES, 'UTF-8');
	} else {
		$care_giver_phone = NULL;
	}
	if(isset($data["care_giver_email"]) AND !empty($data["care_giver_email"])) {
		$care_giver_email = filter_var($data["care_giver_email"], FILTER_VALIDATE_EMAIL);
	} else {
		$care_giver_email = NULL;
	}
	
	$mysqli->begin_transaction();
	try {
		
		// update care giver address
		$address['id'] = $care_giver_address_id;
		$address['company'] = $care_giver_company;
		$address['street'] = $care_giver_street;
		$address['address_addition'] = $care_giver_address_addition;
		$address['zipcode'] = $care_giver_zipcode;
		$address['city'] = $care_giver_city;
		updateAddress($mysqli, $address);
		
		// update care giver main data
		$care_giver_main_data['care_giver_id'] = $care_giver_id;
		$care_giver_main_data['care_giver_type'] = $care_giver_type;
		$care_giver_main_data['care_giver_company'] = $care_giver_company;
		$care_giver_main_data['care_giver_salutation'] = $care_giver_salutation;
		$care_giver_main_data['care_giver_first_name'] = $care_giver_first_name;
		$care_giver_main_data['care_giver_last_name'] = $care_giver_last_name;
		updateCareGiverMainData($mysqli, $care_giver_main_data);
		
		// update care giver contact data
		updateContactData($mysqli, $care_giver_type, $care_giver_phone, $care_giver_email, $care_giver_id);

		$mysqli->commit();
		
    } catch (Exception $e) {
        $mysqli->rollback();
        throw $e;
    }
}

function saveCareGiverData($mysqli, $data) {
    
	$current_date = time();
	$care_giver_type = 0;
	$care_giver_type = filter_var($data["care_giver_type"], FILTER_VALIDATE_INT);
	if(isset($data["care_giver_company"]) AND !empty($data["care_giver_company"])) {
		$care_giver_company = htmlspecialchars($data["care_giver_company"], ENT_QUOTES, 'UTF-8');
	} else {
		$care_giver_company = NULL;
	}
	if(isset($data["care_giver_salutation"]) AND !empty($data["care_giver_salutation"])) {
		$care_giver_salutation = filter_var($data["care_giver_salutation"], FILTER_VALIDATE_INT);
	} else {
		$care_giver_salutation = NULL;
	}
	if(isset($data["care_giver_first_name"]) AND !empty($data["care_giver_first_name"])) {
		$care_giver_first_name = htmlspecialchars($data["care_giver_first_name"], ENT_QUOTES, 'UTF-8');
	} else {
		$care_giver_first_name = NULL;
	}
	if(isset($data["care_giver_last_name"]) AND !empty($data["care_giver_last_name"])) {
		$care_giver_last_name = htmlspecialchars($data["care_giver_last_name"], ENT_QUOTES, 'UTF-8');
	} else {
		$care_giver_last_name = NULL;
	}
	$care_giver_street = $data["care_giver_street"];
	if(isset($data["care_giver_address_addition"]) AND !empty($data["care_giver_address_addition"])) {
		$care_giver_address_addition = htmlspecialchars($data["care_giver_address_addition"], ENT_QUOTES, 'UTF-8');
	} else {
		$care_giver_address_addition = NULL;
	}
	$care_giver_zipcode = htmlspecialchars($data["care_giver_zipcode"], ENT_QUOTES, 'UTF-8');
	$care_giver_city = htmlspecialchars($data["care_giver_city"], ENT_QUOTES, 'UTF-8');
	if(isset($data["care_giver_phone"]) AND !empty($data["care_giver_phone"])) {
		$care_giver_phone = htmlspecialchars($data["care_giver_phone"], ENT_QUOTES, 'UTF-8');
	} else {
		$care_giver_phone = NULL;
	}
	if(isset($data["care_giver_email"]) AND !empty($data["care_giver_email"])) {
		$care_giver_email = filter_var($data["care_giver_email"], FILTER_VALIDATE_EMAIL);
	} else {
		$care_giver_email = NULL;
	}	
	$mysqli->begin_transaction();
	try {
		// create address
		$stmt_create_care_giver_address_query = "INSERT INTO addresses (street, address_addition, zipcode, city, create_date) VALUES (?, ?, ?, ?, ?)";
		$stmt_create_care_giver_address = prepareAndBind($mysqli, $stmt_create_care_giver_address_query, "ssisi", $care_giver_street, $care_giver_address_addition, $care_giver_zipcode, $care_giver_city, $current_date);
		$stmt_create_care_giver_address->execute();
		$care_giver_address_id = $mysqli->insert_id;
		$stmt_create_care_giver_address->close();
		
		// create care giver
		$stmt_create_care_giver_query = "INSERT INTO care_giver_data (company, salutation, first_name, last_name, type, address_id, create_date) VALUES (?, ?, ?, ?, ?, ?, ?)";
		$stmt_create_care_giver = prepareAndBind($mysqli, $stmt_create_care_giver_query, "sissiii", $care_giver_company, $care_giver_salutation, $care_giver_first_name, $care_giver_last_name, $care_giver_type, $care_giver_address_id, $current_date);
		$stmt_create_care_giver->execute();
		$care_giver_id = $mysqli->insert_id;
		$stmt_create_care_giver->close();

		// insert contact data of care giver
		insertContactData($mysqli, $care_giver_type, $care_giver_id, $care_giver_phone, $care_giver_email);
		
		// update insured person with care giver id
		if(isset($data["insured_person_id"]) AND !empty($data["insured_person_id"])) {
			$insured_person_id = $data["insured_person_id"];
			if($care_giver_type == 2) {
				$update_insured_person_query = "UPDATE insured_person_data SET care_giver_person_id = ? WHERE id = ?";
			} elseif($care_giver_type == 3) {
				$update_insured_person_query = "UPDATE insured_person_data SET care_giver_service_id = ? WHERE id = ?";
			} else {
				//throw new Exception("care_giver_type falsch: care_giver_type: $care_giver_type");
				if (defined('DEV') && DEV == 0) {
					throw new Exception('Es ist ein Fehler aufgetreten. Versuche es später erneut.');
				} else {
					throw new Exception('Fehler beim Einfügen des Eintrags: ' . $e->getMessage());
				}
			}
			$update_insured_person = $mysqli->prepare($update_insured_person_query);
			$update_insured_person->bind_param("ii", $care_giver_id, $insured_person_id);
			$update_insured_person->execute();
		}

		$mysqli->commit();
		
		return $care_giver_id;
		
    } catch (Exception $e) {
        $mysqli->rollback();
        throw $e;
    }
}

function saveDelivery($mysqli, $data) {
    $mysqli->begin_transaction();
    try {
		$entry_id = $data['entry_id'];
		$user_id = $data['user_id'];
		$delivery = $data['delivery'];
		$delivery_frequency = $data['delivery_frequency'];
		$supplier_change = $data['supplier_change'];
		$supplier_change_delivery_start = $data['supplier_change_delivery_start'];
		$insured_person_id = $data['insured_person_id'];
        $stmt_update_delivery = $mysqli->prepare("UPDATE entries SET delivery = ?, delivery_frequency = ?, supplier_change = ?, supplier_change_delivery_start = ? WHERE id = ? AND user_id = ? AND insured_person_id = ?");
        $stmt_update_delivery->bind_param("iiisiii", $delivery, $delivery_frequency, $supplier_change, $supplier_change_delivery_start, $entry_id, $user_id, $insured_person_id);
        $stmt_update_delivery->execute();
/*		if ($mysqli->affected_rows == 0) {
			throw new Exception("Kein Eintrag wurde aktualisiert");
		}*/
        $mysqli->commit();
		$stmt_update_delivery->close();
    } catch (Exception $e) {
        $mysqli->rollback();
        throw $e;
    }
}

function saveCareServiceData($entry_id, $data) {
    global $mysqli;
    $mysqli->begin_transaction();
    try {
        $create_date = time();
        $company = $data['company'];
        $street = $data['street'];
		$address_addition = $data['address_addition'];
        $zipcode = $data['zipcode'];
        $city = $data['city'];
        
        // Hole insured_person_id basierend auf $entry_id
        $stmt_get_insured_person = $mysqli->prepare("SELECT insured_person_id FROM entries WHERE id = ?");
        $stmt_get_insured_person->bind_param('i', $entry_id);
        $stmt_get_insured_person->execute();
        $result = $stmt_get_insured_person->get_result();
        $row = $result->fetch_assoc();
        
        if (!$row) {
            throw new Exception("Kein Eintrag gefunden mit der ID: $entry_id");
        }
        
        $insured_person_id = $row['insured_person_id'];
        $stmt_get_insured_person->close();
		
		// Prüfen on insured_person_id in der care_giver_service bereits exsitiert
		$stmt_get_insured_person_id_check = $mysqli->prepare("SELECT id FROM care_giver_service_data WHERE insured_person_id = ?");
        $stmt_get_insured_person_id_check->bind_param('i', $insured_person_id);
        $stmt_get_insured_person_id_check->execute();
		$result = $stmt_get_insured_person_id_check->get_result();
		if($result->num_rows > 0) {
			throw new Exception("Doppelter Eintrag!");
		}
        
        // Erstelle Adresse
        $stmt_create_care_giver_service_address = $mysqli->prepare("INSERT INTO addresses (street, address_addition, zipcode, city, create_date) VALUES (?, ?, ?, ?, ?)");
        $stmt_create_care_giver_service_address->bind_param('ssssi', $street, $address_addition, $zipcode, $city, $create_date);
        $stmt_create_care_giver_service_address->execute();
        
        // Hole die ID des gerade erstellten Adressdatensatzes
        $address_id = $mysqli->insert_id;
        
        // Erstelle care_giver_service_data mit insured_person_id
        $stmt_create_care_giver_service_data = $mysqli->prepare("INSERT INTO care_giver_service_data (company, address_id, insured_person_id, create_date) VALUES (?, ?, ?, ?)");
        $stmt_create_care_giver_service_data->bind_param('siis', $company, $address_id, $insured_person_id, $create_date);
        $stmt_create_care_giver_service_data->execute();

        // Führe die Transaktion aus
        $mysqli->commit();

        // Schließe die vorbereiteten Anweisungen
        $stmt_create_care_giver_service_address->close();
        $stmt_create_care_giver_service_data->close();
        
    } catch(Exception $e) {
        // Im Fehlerfall: Rolle die Transaktion zurück.
        $mysqli->rollback();

        // Werfe die Ausnahme erneut, um sie im Hauptskript zu verarbeiten
        throw $e;
    }
}


function isLoggedIn() {
    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
        return true;
    }
    return false;
}

function isLoggedInAsAdmin() {
    if (isset($_SESSION['loggedin_as_admin']) && $_SESSION['loggedin_as_admin'] === true) {
        return true;
    }
    return false;
}

function generatePassword($length = 12) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomPassword = '';
    for ($i = 0; $i < $length; $i++) {
        $randomPassword .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomPassword;
}


function completeApplication($entryId) {
	global $mysqli;
	$status = 1;
	$completeDate = time();
    $stmt = $mysqli->prepare("UPDATE entries SET status = ?, complete_date = ? WHERE id = ?");
    $stmt->bind_param("iii", $status, $completeDate, $entryId);
	
	if($stmt->execute()) {
		
		$stmt->close();
		$mysqli->close();
		header("Location:../final/?entry-id=".$entryId);
		exit();
	} else {
		return false;
	}
}


function getChoosedCompilation($entryId) {
    global $mysqli;
    
    $query = "
	SELECT 
		products.id AS product_id,
		products.name AS product_name,
		JSON_EXTRACT(entries.products, CONCAT('$.', products.id)) AS quantity
	FROM
		entries
	JOIN
		products ON JSON_EXTRACT(entries.products, CONCAT('$.', products.id)) IS NOT NULL
	WHERE
		entries.id = ?
    ";
    
    $stmt = $mysqli->prepare($query);
    if (!$stmt) {
        die("Vorbereitung fehlgeschlagen: (" . $mysqli->errno . ") " . $mysqli->error);
    }

    $stmt->bind_param("i", $entryId);  // "i" bedeutet, dass es sich um eine INTEGER-Variable handelt

    if (!$stmt->execute()) {
        die("Ausführung fehlgeschlagen: (" . $stmt->errno . ") " . $stmt->error);
    }

    $result = $stmt->get_result();

    $products = [];
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }

    $stmt->close();

    return $products;
}

function is_home($home_url) {
    $requestUri = $_SERVER['REQUEST_URI'];
    if ($requestUri == $home_url) {
        return true;
    }
}
/*
used: configurator.php
*/
function getProducts($mysqli, $active = 1) {
	if($active == 1) {
		$sql_active = "WHERE active = " . $active;
	} else {
		$sql_active = "";
	}
    $query = "SELECT * FROM products $sql_active ORDER BY active DESC, sorting ASC";
    $result = $mysqli->query($query);

    if ($result->num_rows > 0) {
        $products = array();
        while ($row = $result->fetch_assoc()) {
            $products[] = $row;
        }
        return $products;
    }
}

function getEntryData($mysqli, $entry_id) {
	$stmt = $mysqli->prepare("
		SELECT
			e.entry_number AS entry_number,
			e.status AS entry_status,
			CASE 
				WHEN e.status = 1 AND insurance_type = 2 THEN 'kostenpflichtig bestellt'
				WHEN e.status = 0 THEN 'ausstehend'
				WHEN e.status = 1 THEN 'digital unterschrieben' 
				ELSE ''
			END AS entry_status_name,
			e.compilation_name AS compilation_name,
			e.products AS products,
			e.bed_protectors_amount AS bed_protectors_amount,
			e.compilation_name AS compilation_name,
			e.delivery AS delivery,
			e.delivery_frequency AS delivery_frequency,
			CASE 
				WHEN e.delivery_frequency = 0 THEN 'monatlich'
				WHEN e.delivery_frequency = 1 THEN 'jeden 2. Monat'
				WHEN e.delivery_frequency = 2 THEN 'jeden 3. Monat'
				ELSE ''
			END AS delivery_frequency_name,
			e.supplier_change AS supplier_change,
			e.supplier_change_delivery_start AS supplier_change_delivery_start,
			e.create_date AS entry_create_date,
			e.import_id AS entry_import_id,
			e.complete_date AS entry_complete_date,
			u.id AS user_id,
			u.type AS user_type,
			CASE 
				WHEN u.type = 1 THEN 'Versicherter'
				WHEN u.type = 2 THEN 'Pflegeperson'
				WHEN u.type = 3 THEN 'Pflegedienst'
				ELSE ''
			END AS user_type_name,
			u.email AS user_email,
			ipd.salutation AS insured_person_salutation,
			CASE 
				WHEN ipd.salutation = 1 THEN 'Herr'
				WHEN ipd.salutation = 2 THEN 'Frau'
				WHEN ipd.salutation = 3 THEN 'Divers'
				ELSE ''
			END AS insured_person_salutation_name,
			ipd.id AS insured_person_id,
			ipd.first_name AS insured_person_first_name,
			ipd.last_name AS insured_person_last_name,
			ipd.birth_date AS insured_person_birth_date,
			ipd.address_id AS insured_person_address_id,
			ipcd.phone AS insured_person_phone,
			ipcd.email AS insured_person_email,
			a.street AS insured_person_street,
			a.address_addition AS insured_person_address_addition,
			a.zipcode AS insured_person_zipcode,
			a.city AS insured_person_city,
			ind.insurance_type AS insurance_type,
			CASE 
				WHEN ind.insurance_type = 1 THEN 'Gesetzlich Versicherter (Kostenübernahme durch die Pflegekasse)'
				WHEN ind.insurance_type = 2 THEN 'Privatversicherter'
				ELSE ''
			END AS insurance_type_name,
			ind.insurance_number AS insurance_number,
			ind.insurance_company_id AS insurance_company_id,
			ind.custom_insurance_company_name AS custom_insurance_company_name,
			ind.insurance_aid AS insurance_aid,
			ind.care_level AS care_level,
			ind.care_level_since AS care_level_since,
			ic.name AS insurance_company_name,
			cgpd.id AS care_giver_person_id,
			cgpd.address_id AS care_giver_person_address_id,
			cgpd.salutation AS care_giver_person_salutation,
			CASE 
				WHEN cgpd.salutation = 1 THEN 'Herr'
				WHEN cgpd.salutation = 2 THEN 'Frau'
				WHEN cgpd.salutation = 3 THEN 'Divers'
				ELSE ''
			END AS care_giver_person_salutation_name,
			cgpd.type AS care_giver_person_type,
			cgpd.first_name AS care_giver_person_first_name,
			cgpd.last_name AS care_giver_person_last_name,
			cgpa.street AS care_giver_person_street,
			cgpa.address_addition AS care_giver_person_address_addition,
			cgpa.zipcode AS care_giver_person_zipcode,
			cgpa.city AS care_giver_person_city,
			cgpcd.email AS care_giver_person_email,
			cgpcd.phone AS care_giver_person_phone,
			cgsd.id AS care_giver_service_id,
			cgsd.type AS care_giver_service_type,
			cgsd.address_id AS care_giver_service_address_id,
			cgsd.company AS care_giver_service_company,
			cgsa.street AS care_giver_service_street,
			cgsa.address_addition AS care_giver_service_address_addition,
			cgsa.zipcode AS care_giver_service_zipcode,
			cgsa.city AS care_giver_service_city,
			cgscd.email AS care_giver_service_email,
			cgscd.phone AS care_giver_service_phone,
			agreements.id AS agreement_id,
			agreements.marketing AS agreement_marketing,
			cons.status AS consultation_status,
			cons.form AS consultation_form,
			cons.partner AS consultation_partner,
			cons.consultant AS consultant,
			cons.date AS consultation_date
		FROM 
			entries e
			-- USER
			LEFT JOIN users u 
				ON e.user_id = u.id 
			-- VERSICHERTER
			LEFT JOIN insured_person_data ipd 
				ON e.insured_person_id = ipd.id
			-- KONTAKTDATEN DES VERSICHERTEN
			LEFT JOIN contact_data ipcd
				ON ipd.id = ipcd.owner_id AND ipcd.owner_type = 1
			-- ADRESSE DES VERSICHERTEN
			LEFT JOIN addresses a 
				ON ipd.address_id = a.id
			-- DATEN DES VERSICHERTEN
			LEFT JOIN insurance_data ind
				ON e.insured_person_id = ind.insured_person_id
			LEFT JOIN insurance_companies ic
				ON ind.insurance_company_id = ic.id AND ic.type = ind.insurance_type
			-- PFLEGEPERSON
			LEFT JOIN care_giver_data cgpd 
				ON ipd.care_giver_person_id = cgpd.id AND cgpd.type = 2
			-- ADRESSE DER PFLEGEPERSON
			LEFT JOIN addresses cgpa 
				ON cgpd.address_id = cgpa.id
			-- KONTAKTDATEN DER PFLEGEPERSON
			LEFT JOIN contact_data cgpcd
				ON cgpd.id = cgpcd.owner_id AND cgpcd.owner_type = 2
			-- PFLEGEDIENST	
			LEFT JOIN care_giver_data cgsd 
				ON ipd.care_giver_service_id = cgsd.id AND cgsd.type = 3
			-- ADRESSE DES PFLEGEDIENSTES
			LEFT JOIN addresses cgsa 
				ON cgsd.address_id = cgsa.id
			-- KONTAKTDATEN DES PFLEGEDIENSTES
			LEFT JOIN contact_data cgscd
				ON cgsd.id = cgscd.owner_id AND cgscd.owner_type = 3
			LEFT JOIN agreements
				ON e.id = agreements.entry_id
			-- BERATUNG
			LEFT JOIN consultation cons
				ON e.id = cons.entry_id
		WHERE 
			e.id = ?
	");
    $stmt->bind_param('i', $entry_id);
    $stmt->execute();
    $result = $stmt->get_result();
	
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
		//$result->close();
		//$stmt->close();
		
        $data = $result->fetch_assoc();
		
		$user_data = [];
		$user_data = [
			'user_id' => $row['user_id'],
			'user_type' => $row['user_type'],
			'user_type_name' => $row['user_type_name'],
			'user_email' => $row['user_email'],
		];
		$data['user_data'] = $user_data;
		
		$entry_data = [];
		$entry_data = [
			'entry_id' => $entry_id,
			'entry_number' => $row['entry_number'],
			'entry_status' => $row['entry_status'],
			'entry_create_date' => $row['entry_create_date'],
			'entry_complete_date' => $row['entry_complete_date'],
			'bed_protectors_amount' => $row['bed_protectors_amount'],
			'entry_import_id' => $row['entry_import_id'],
			'agreement_id' => $row['agreement_id'],
			'agreement_marketing' => $row['agreement_marketing'],
			
		];
		$data['entry_data'] = $entry_data;
		
    	$insured_person_data = [];
		if($row['insured_person_salutation'] == 1) {
			$row['insured_person_full_salutation'] = "Sehr geehrter Herr " . $row['insured_person_first_name'] . " " . $row['insured_person_last_name'];
		} elseif($row['insured_person_salutation'] == 2) {
			$row['insured_person_full_salutation'] = "Sehr geehrte Frau " . $row['insured_person_first_name'] . " " . $row['insured_person_last_name'];
		} else {
			$row['insured_person_full_salutation'] = " Hallo " . $row['insured_person_first_name'] . " " . $row['insured_person_last_name'];
		}
		
		$insured_person_data = [
			'insured_person_id' => $row['insured_person_id'],
			'insured_person_salutation' => $row['insured_person_salutation'],
			'insured_person_salutation_name' => $row['insured_person_salutation_name'],
			'insured_person_first_name' => $row['insured_person_first_name'],
			'insured_person_last_name' => $row['insured_person_last_name'],
			'insured_person_full_salutation' => $row['insured_person_full_salutation'],
			'insured_person_birth_date' => $row['insured_person_birth_date'],
			'insured_person_phone' => $row['insured_person_phone'],
			'insured_person_email' => $row['insured_person_email'],
			'insured_person_address_id' => $row['insured_person_address_id'],
			'insured_person_street' => $row['insured_person_street'],
			'insured_person_address_addition' => $row['insured_person_address_addition'],
			'insured_person_zipcode' => $row['insured_person_zipcode'],
			'insured_person_city' => $row['insured_person_city'],
			'insurance_type' => $row['insurance_type'],
			'insurance_type_name' => $row['insurance_type_name'],
			'insurance_number' => $row['insurance_number'],
			'insurance_company_id' => $row['insurance_company_id'],
			'insurance_company_name' => $row['insurance_company_name'],
			'custom_insurance_company_name' => $row['custom_insurance_company_name'],
			'insurance_aid' => $row['insurance_aid'],
			'care_level' => $row['care_level'],
			'care_level_since' => $row['care_level_since']
		];
		$data['insured_person_data'] = $insured_person_data;
		
    	$care_giver_person_data = [];
		$care_giver_person_data = [
			'care_giver_person_id' => $row['care_giver_person_id'],
			'care_giver_person_address_id' => $row['care_giver_person_address_id'],
			'care_giver_person_salutation' => $row['care_giver_person_salutation'],
			'care_giver_person_salutation_name' => $row['care_giver_person_salutation_name'],
			'care_giver_person_first_name' => $row['care_giver_person_first_name'],
			'care_giver_person_last_name' => $row['care_giver_person_last_name'],
			'care_giver_person_street' => $row['care_giver_person_street'],
			'care_giver_person_address_addition' => $row['care_giver_person_address_addition'],
			'care_giver_person_zipcode' => $row['care_giver_person_zipcode'],
			'care_giver_person_city' => $row['care_giver_person_city'],
			'care_giver_person_phone' => $row['care_giver_person_phone'],
			'care_giver_person_email' => $row['care_giver_person_email'],
			'care_giver_person_type' => $row['care_giver_person_type'],
		];
		$data['care_giver_person_data'] = $care_giver_person_data;
		
    	$care_giver_service_data = [];
		$care_giver_service_data = [
			'care_giver_service_id' => $row['care_giver_service_id'],
			'care_giver_service_address_id' => $row['care_giver_service_address_id'],
			'care_giver_service_company' => $row['care_giver_service_company'],
			'care_giver_service_street' => $row['care_giver_service_street'],
			'care_giver_service_address_addition' => $row['care_giver_service_address_addition'],
			'care_giver_service_zipcode' => $row['care_giver_service_zipcode'],
			'care_giver_service_city' => $row['care_giver_service_city'],
			'care_giver_service_phone' => $row['care_giver_service_phone'],
			'care_giver_service_email' => $row['care_giver_service_email'],
			'care_giver_service_type' => $row['care_giver_service_type'],
		];
		$data['care_giver_service_data'] = $care_giver_service_data;
				
		$consultation_data = [];
		$consultation_data = [
			'status' => $row['consultation_status'],
			'form' => $row['consultation_form'],
			'partner' => $row['consultation_partner'],
			'consultant' => $row['consultant'],
			'date' => $row['consultation_date'],	
		];
		$data['consultation_data'] = $consultation_data;
		
		$delivery_data = [];
		$delivery_data = [
			'delivery' => $row['delivery'],
			'delivery_frequency' => $row['delivery_frequency'],
			'delivery_frequency_name' => $row['delivery_frequency_name'],
			'supplier_change' => $row['supplier_change'],
			'supplier_change_delivery_start' => $row['supplier_change_delivery_start'],	
			
		];
		$data['delivery_data'] = $delivery_data;
		
		
		$entry_status = [];
		$entry_status_query = "
		SELECT 
			application_status.status AS status, 
			application_status.sending_on AS sending_on, 
			CASE 
				WHEN application_status.status = 20 THEN
					CASE application_status.sending_on
						WHEN 1 THEN 'an Versicherten'
						WHEN 2 THEN 'an Pflegeperson'
						WHEN 3 THEN 'an Pflegedienst'
					END
				ELSE ''
			END AS sending_on_name,
			application_status.status_date AS status_date,
			status_names.name AS status_name
		FROM application_status 
			LEFT JOIN status_names 
				ON application_status.status = status_names.status_id
		WHERE 
			entry_id = $entry_id
		ORDER BY 
			application_status.status_date DESC
		";
		$entry_status_stmt = $mysqli->prepare($entry_status_query);
		$entry_status_stmt->execute();
		$entry_status_result = $entry_status_stmt->get_result();
		
		while ($entry_status_row = $entry_status_result->fetch_assoc()) {
			$entry_status[] = [
				'status_id' => $entry_status_row['status'],
				'sending_on_name' => $entry_status_row['sending_on_name'],
				'status_date' => $entry_status_row['status_date'],
				'status_name' => $entry_status_row['status_name'],
			];
		}
		$data['entry_status_data'] = $entry_status;
		$entry_status_result->close();
		$entry_status_stmt->close();
		
		$productIds = json_decode($row['products'], true);
        if ($productIds) {
            $placeholders = implode(',', array_fill(0, count($productIds), '?'));
			//echo "<pre>";print_r($productIds);echo "</pre>";
            // Zweite Abfrage: Holt die Produktinformationen basierend auf den extrahierten IDs
            $productQuery = "SELECT id, name, short_name, pack_quantity, positionsnumber, price, img_id, pdf_id FROM products WHERE id IN ($placeholders)";
            $productStmt = $mysqli->prepare($productQuery);
            
            $ids = array_keys($productIds);
            $types = str_repeat('i', count($ids));
            $productStmt->bind_param($types, ...$ids);

            $productStmt->execute();
            $productResult = $productStmt->get_result();

            $product_full_data = [];
            while ($productRow = $productResult->fetch_assoc()) {
                $product_full_data[] = [
					'id' => $productRow['id'],
					'img_id' => $productRow['img_id'],
					'pdf_id' => $productRow['pdf_id'],
                    'name' => ucfirst($productRow['name']),
					'short_name' => $productRow['short_name'],
					'pack_quantity' => $productRow['pack_quantity'],
					'price' => $productRow['price'],
					'quantity' => $productIds[$productRow['id']]['quantity'],  // Angepasst
					'size' => $productIds[$productRow['id']]['size'],            // Hinzugefügt
					'intolerance' => $productIds[$productRow['id']]['intolerance'], // Hinzugefügt
					'positionsnumber' => $productRow['positionsnumber'],
                ];
            }
			
			$data['product_data'] = [
				'products_json' => $row["products"],
				'compilation_name' =>  $row["compilation_name"],
				'product_full_data' => $product_full_data,
			];
			
            $productResult->close();
            $productStmt->close();
        }
		
		$result->close();
		$stmt->close();
		return $data;
	}
	$stmt->close();
}

function getNestedValue($array, $keys, $default = null) {
    foreach ($keys as $key) {
        if (is_array($array) && isset($array[$key])) {
            $array = $array[$key];
        } else {
            return $default;
        }
    }
    return $array;
}

function get_footer_links($mysqli) {
    // SQL-Abfrage, um aktive Footer-Links auszuwählen
    $query = "SELECT * FROM footer_links WHERE active = 1";

    // Ergebnis der Abfrage ausführen
    if ($result = $mysqli->query($query)) {
        $footer_links = array();

        // Alle Zeilen des Ergebnisses durchlaufen und in das Array einfügen
        while ($row = $result->fetch_assoc()) {
            $footer_links[] = $row;
        }

        // Speicher freigeben
        $result->free();
        
        // Array der Footer-Links zurückgeben
        return $footer_links;
    } else {
        // Im Fehlerfall eine leere Liste zurückgeben
        return array();
    }
}

function getRechtliches($mysqli) {
	$query = "SELECT * FROM rechtliches";
    if ($result = $mysqli->query($query)) {

        // Alle Zeilen des Ergebnisses durchlaufen und in das Array einfügen
        $row = $result->fetch_assoc();

        // Speicher freigeben
        $result->free();
        
        // Array der Footer-Links zurückgeben
        return $row;
    } else {
        // Im Fehlerfall eine leere Liste zurückgeben
        return array();
    }
}

function createPDF($entry_id, $signed_status, $pdf_version, $pdf_number, $download_file = 2) {
	/*
	$pdf_number - wird aktuell nicht verwendet
	Versionsnummer von PDF Dokument, z. B. wenn Datenänderungen vorgenommen wurden und es ein neues PDF Dokument erstellt werden soll
	0 - preview
	1 - download
	2 - save
	*/
    $url = BASEHREF . 'inc/PDF/createPDF.php';
    $params = [
        'file_name' => 'test',
        'entry_id' => $entry_id,
        'signed_status' => $signed_status,
        'pdf_version' => $pdf_version,
		'pdf_number' => $pdf_number,
		'download_file' => $download_file,
    ];
    $url .= '?' . http_build_query($params);

    $pdfResult = file_get_contents($url);
    if ($pdfResult === FALSE) {
        return false;
    }
    return true;
}

function save_consultation($mysqli, $data) {
    
    $required_fields = ['entry_id', 'consultation-status'];
    foreach ($required_fields as $field) {
        if (!isset($data[$field])) {
            return false;
        }
    }
    
    try {
        $entry_id = $data['entry_id'];
        $status = $data['consultation-status'];
        $form = isset($data['consultation-form']) ? implode(',', $data['consultation-form']) : null;
		$partner = isset($data['consultation-partner']) ? implode(',', $data['consultation-partner']) : null;
        $consultant = $data['consultant'] ?? null;
		$consultation_date = $data['consultation_date'] ?? null;
		
        // INSERT ... ON DUPLICATE KEY UPDATE-Abfrage
        $query = "
            INSERT INTO consultation (entry_id, status, form, partner, consultant, date)
            VALUES (?, ?, ?, ?, ?, ?)
            ON DUPLICATE KEY UPDATE
            status = VALUES(status),
            form = VALUES(form),
            partner = VALUES(partner),
            consultant = VALUES(consultant),
			date = VALUES(date)
        ";
        $stmt = $mysqli->prepare($query);
        $stmt->bind_param('iissss', $entry_id, $status, $form, $partner, $consultant, $consultation_date);
        $stmt->execute();
        $stmt->close();

    } catch (Exception $e) {
        throw $e;
    }
}