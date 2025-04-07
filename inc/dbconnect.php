<?php
$mysqli = new mysqli(HOST, USER, PASSWORD, DB);
if($mysqli->connect_error) {
    throw new Exception("Verbindung zur Datenbank fehlgeschlagen: " . $mysqli->connect_error);
}
$mysqli->set_charset("utf8mb4");