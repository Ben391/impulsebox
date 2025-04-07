<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['templateContent']) && isset($_POST['userType']) && isset($_POST['templateType'])) {
    $newTemplateContent = $_POST['templateContent'];
    $userType = $_POST['userType'];
    $templateType = $_POST['templateType'];

    // Template-Dateien speichern
    $template_file = "../../../email-templates/{$userType}/{$userType}_{$templateType}.html";

    // Überprüfen Sie, ob die Datei existiert, bevor Sie versuchen, in sie zu schreiben.
    if (!file_exists($template_file)) {
        die("Die Datei existiert nicht.");
    }

    $bytesWrittenContent = file_put_contents($template_file, $newTemplateContent);

    if ($bytesWrittenContent === false || $bytesWrittenContent == 0) {
        // Wenn keine Bytes geschrieben wurden oder ein Fehler aufgetreten ist.
        echo 'Fehler beim Speichern des Templates!';
    } else {
        echo 'Template erfolgreich gespeichert!';
    }

    // Wenn templateSubject gesetzt ist
    if (isset($_POST['templateSubject'])) {
        $newTemplateSubject = $_POST['templateSubject'];
        $subject_file = "../../../email-templates/{$userType}/{$userType}_{$templateType}_subject.html";

        // Überprüfen Sie, ob die Datei existiert, bevor Sie versuchen, in sie zu schreiben.
        if (!file_exists($subject_file)) {
            die("Die Datei für den Betreff existiert nicht.");
        }

        $bytesWrittenSubject = file_put_contents($subject_file, $newTemplateSubject);

        if ($bytesWrittenSubject === false || $bytesWrittenSubject == 0) {
            // Wenn keine Bytes geschrieben wurden oder ein Fehler aufgetreten ist.
            echo 'Fehler beim Speichern des Betreffs!';
        } else {
            echo 'Betreff erfolgreich gespeichert!';
        }
    }
}
