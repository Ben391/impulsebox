<?php
function cleanData($data) {
	$data = trim($data);
	//$data = stripslashes($data);
	//$data = htmlspecialchars($data);
	return $data;
}
function getAdmins($mysqli) {
	$stmt = $mysqli->prepare("
		SELECT
			*
		FROM 
			admins
		ORDER BY 
			active DESC
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

function getStatuses($mysqli, $sql_where) {
    $query = "
	SELECT 
	*
	FROM 
		status_names
	$sql_where
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
