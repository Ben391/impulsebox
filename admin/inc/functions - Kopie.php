<?php
function cleanData($data) {
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	$data = preg_replace('/[^\x20-\x7E]/','', $data);
	//$data = htmlspecialchars($articleName, ENT_QUOTES);
	return $data;
}
function getAdmins($mysqli) {
	$stmt = $mysqli->prepare("
		SELECT
			*
		FROM 
			admins
		WHERE 
			active = 1
	");
    $stmt->execute();
    $result = $stmt->get_result();
	
    if ($result->num_rows > 0) {
        $data = $result->fetch_all(MYSQLI_ASSOC);		
		$result->close();
		$stmt->close();
		return $data;
	}
	$stmt->close();
	return null;
}


function getAdmin($mysqli, $admin_id) {
	$stmt = $mysqli->prepare("
		SELECT
			*
		FROM 
			admins
		WHERE 
			id = ?
	");
    $stmt->bind_param('i', $admin_id);
    $stmt->execute();
    $result = $stmt->get_result();
	
    if ($result->num_rows > 0) {
        $data = $result->fetch_assoc();		
		$result->close();
		$stmt->close();
		return $data;
	}
	$stmt->close();
}

function getStatuses($mysqli) {
    $query = "
	SELECT 
		status_id, 
		short_name, 
		name 
	FROM 
		status_names
	WHERE 
		status_id NOT IN (10, 11, 20, 30, 40)
	";
    $stmt = $mysqli->prepare($query);
    if (!$stmt) {
        die("Statement konnte nicht vorbereitet werden: (" . $mysqli->errno . ") " . $mysqli->error);
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
			cgpd.salutation AS care_giver_person_salutation,
			CASE 
				WHEN cgpd.salutation = 1 THEN 'Herr'
				WHEN cgpd.salutation = 2 THEN 'Frau'
				WHEN cgpd.salutation = 3 THEN 'Divers'
				ELSE ''
			END AS care_giver_person_salutation_name,
			cgpd.first_name AS care_giver_person_first_name,
			cgpd.last_name AS care_giver_person_last_name,
			cgpa.street AS care_giver_person_street,
			cgpa.zipcode AS care_giver_person_zipcode,
			cgpa.city AS care_giver_person_city,
			cgpcd.email AS care_giver_person_email,
			cgpcd.phone AS care_giver_person_phone,
			cgsd.id AS care_giver_service_id,
			cgsd.company AS care_giver_service_company,
			cgsa.street AS care_giver_service_street,
			cgsa.zipcode AS care_giver_service_zipcode,
			cgsa.city AS care_giver_service_city,
			cgscd.email AS care_giver_service_email,
			cgscd.phone AS care_giver_service_phone
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
		WHERE 
			e.id = ?
	");
    $stmt->bind_param('i', $entry_id);
    $stmt->execute();
    $result = $stmt->get_result();
	
    if ($result->num_rows > 0) {
        $data = $result->fetch_assoc();
		
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

		
		$productIds = json_decode($data['products'], true);
        if ($productIds) {
            $placeholders = implode(',', array_fill(0, count($productIds), '?'));
			//echo "<pre>";print_r($productIds);echo "</pre>";
            // Zweite Abfrage: Holt die Produktinformationen basierend auf den extrahierten IDs
            $productQuery = "SELECT id, name, pack_quantity, price, img_id FROM products WHERE id IN ($placeholders)";
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
                    'name' => $productRow['name'],
					'pack_quantity' => $productRow['pack_quantity'],
					'price' => $productRow['price'],
					'quantity' => $productIds[$productRow['id']]['quantity'],  // Angepasst
					'size' => $productIds[$productRow['id']]['size'],            // Hinzugefügt
					'intolerance' => $productIds[$productRow['id']]['intolerance'], // Hinzugefügt
                ];
            }
			$data['product_full_data'] = $product_full_data;
            $productResult->close();
            $productStmt->close();
        }
		
		$result->close();
		$stmt->close();
		return $data;
	}
	$stmt->close();
}

function getEntries($mysqli, $limit, $offset, $keyword) {
    $sql_where = "";
    $param_types = "ii";
    $params = [$offset, $limit];

    if (!empty($keyword)) {
		$columns = [
			'e.id',
			'e.entry_number',
			'insured_person_data.first_name',
			'insured_person_data.last_name',
			"CONCAT(insured_person_data.first_name, ' ', insured_person_data.last_name)",
			"CONCAT(insured_person_data.last_name, ' ', insured_person_data.first_name)",
			'cgpd.first_name',
			'cgpd.last_name',
			"CONCAT(cgpd.first_name, ' ', cgpd.last_name)",
			"CONCAT(cgpd.last_name, ' ', cgpd.first_name)"
		];
		// SQL WHERE-Klausel erstellen
		$sql_where = 'WHERE ' . implode(' LIKE ? OR ', $columns) . ' LIKE ?';

		// Parameter-Typen und -Werte vorbereiten
		$param_types = str_repeat('s', count($columns)) . $param_types;
		$params_to_prepend = array_fill(0, count($columns), "%$keyword%");

		// Die neuen Parameter dem existierenden Parameter-Array voranstellen
		array_unshift($params, ...$params_to_prepend);
    }

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
        $sql_where
        ORDER BY 
            e.create_date DESC
        LIMIT ?, ?
    ";

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

function getTotalEntries($mysqli) {
    $query = "SELECT COUNT(*) as total FROM entries";
    $result = $mysqli->query($query);
    $row = $result->fetch_assoc();
    return $row['total'];
}