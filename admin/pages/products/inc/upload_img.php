<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (isset($_POST['image'])) {
    $data = $_POST['image'];
    $id = $_POST['id'];
    
    // Zerlegen Sie die Data-URL in ihre Komponenten
    $image_array_1 = explode(";", $data);
    $image_array_2 = explode(",", $image_array_1[1]);

    // Dekodieren Sie die Base64-Daten
    $data = base64_decode($image_array_2[1]);

    // Erstellen Sie einen eindeutigen Dateinamen
    $image_name = $id . '.png';
    $image_directory = '/../../../../img/products/large/';
    $large_image_path = $image_directory . $image_name;

    // Speichern Sie die Originaldatei
    if (file_put_contents(__DIR__.$large_image_path, $data) !== false) {
        // Erstellen und speichern Sie das verkleinerte Bild
        $small_image_directory = '/../../../../img/products/';
        $small_image_path = $small_image_directory . $image_name;

        if (resizeImage(__DIR__.$large_image_path, __DIR__.$small_image_path, 200, 200)) {
            echo $large_image_path;
        } else {
            http_response_code(500);
            echo "Fehler beim Speichern des verkleinerten Bildes";
        }
    } else {
        http_response_code(500);
        echo "Fehler beim Speichern des Bildes";
    }
}


/**
 * Funktion zum Skalieren eines Bildes mit der GD-Bibliothek
 */
function resizeImage($source, $destination, $width, $height) {
    list($source_width, $source_height) = getimagesize($source);
    $source_image = imagecreatefrompng($source);

    $destination_image = imagecreatetruecolor($width, $height);

    // Behandle Transparenz
    imagealphablending($destination_image, false);
    imagesavealpha($destination_image, true);
    $transparent = imagecolorallocatealpha($destination_image, 255, 255, 255, 127);
    imagefilledrectangle($destination_image, 0, 0, $width, $height, $transparent);

    imagecopyresampled($destination_image, $source_image, 0, 0, 0, 0, $width, $height, $source_width, $source_height);

    if (imagepng($destination_image, $destination)) {
        imagedestroy($source_image);
        imagedestroy($destination_image);
        return true;
    } else {
        imagedestroy($source_image);
        imagedestroy($destination_image);
        return false;
    }
}
?>