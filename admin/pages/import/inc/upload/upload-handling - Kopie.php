<?php
require_once "../../../../../inc/settings.php";
$target_dir = "../../files/".$_POST["admin_id"]."/";
$target_file = $target_dir . 'import.csv';
$uploadOk = 1;
$fileType = strtolower(pathinfo($_FILES["fileToUpload"]["name"], PATHINFO_EXTENSION));

// Überprüfen, ob der Dateityp CSV ist
if($fileType != "csv") {
    echo "You have either not selected a file or the wrong format. Only CSV files are allowed.";
    $uploadOk = 0;
}

// Überprüfen, ob die Dateigröße die maximale Größe überschreitet
if ($_FILES["fileToUpload"]["size"] > 1048576) {
    echo "The file size exceeds the maximum limit of 1 MB.";
    $uploadOk = 0;
}

// Überprüfen, ob $uploadOk aufgrund eines Fehlers auf 0 gesetzt wurde
if ($uploadOk == 0) {
    echo "Your file was not uploaded.";
// Wenn alles in Ordnung ist, versuchen Sie, die Datei hochzuladen
} else {
    // Überprüfen, ob der Ordner existiert. Wenn nicht, erstellen Sie ihn
    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true);
    }
    
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
		header("Location:".ADMIN_BASEHREF."import/");
		exit();	
    } else {
        echo "There was an error uploading your file.";
    }
}