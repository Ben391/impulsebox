<?php
include_once "../../../../inc/settings.php";
include_once "../../../../inc/dbconnect.php";

// Datenbankverbindung ...
$compilationId = $_POST['id'];
$newActive = $_POST['active'];

$sql = "UPDATE compilations SET active = ? WHERE id = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param('ii', $newActive, $compilationId);
if ($stmt->execute()) {
    echo "Status erfolgreich geändert.";
} else {
    echo "Fehler beim Ändern des Status.";
}
$stmt->close();
?>
