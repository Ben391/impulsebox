<?php
echo "test";
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (isset($_POST['image'])) {
    $data = $_POST['image'];
    $id = $_POST['id'];
    
    // Zerlegen Sie die Data-URL in ihre Komponenten
    $image_array_1 = explode(";", $data);
    $image_array_2 = explode(",", $image_array_1[1]);
	
	echo $id;
	

    // Dekodieren Sie die Base64-Daten
    $data = base64_decode($image_array_2[1]);

    // Erstellen Sie einen eindeutigen Dateinamen
    $image_name = $id . '.png';
    $image_directory = '/../../../../img/compilations/';
    $large_image_path = $image_directory . $image_name;

    // Speichern Sie die Originaldatei
     // Speichern Sie die Datei und geben Sie den Pfad zurück
    if (file_put_contents(__DIR__.$large_image_path, $data) !== false) {
        echo $large_image_path;
    } else {
        http_response_code(500);
        echo "Fehler beim Speichern des Bildes";
    }
}

?>