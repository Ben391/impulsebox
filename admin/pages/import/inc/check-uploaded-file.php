<?php
require_once "inc/functions.php";
require_once "import-settings.php";
$uploadErr = 0;
if(file_exists($file)) {
	// BOM entfernen
	$csv = file_get_contents($file);
	$bom = pack('H*','EFBBBF'); // UTF-8 BOM
	if (substr($csv, 0, 3) === $bom) {
		$csv = substr($csv, 3);
	}
	$handle = fopen('php://memory', 'r+');
	fwrite($handle, $csv);
	rewind($handle);
    if($handle !== FALSE) {
        $header = fgetcsv($handle, 1500, ';');
        $errHeader = "";
        //echo "<pre>";var_dump($header);echo "</pre>";
        if (count($header) == count($expectedHeaders)) {
            foreach ($header as $index => $columnName) {
                $cleanedColumnName = strtolower(cleanData($columnName));
                $expectedKey = array_search($cleanedColumnName, array_map('strtolower', $expectedHeaders));
                if ($expectedKey === FALSE) {
                    $errHeader = "Unerwarteter Spaltenname '$cleanedColumnName' am Index $index.";
                    break;
                }
            }
            if(empty($errHeader)) {
                $rowChecks = array();
                $errRow = 0;
                $row = 0;
                $rowCorrect = 0;
                while(($data = fgetcsv($handle, 1500, ';')) !== FALSE) {
                    $row++;
                    if(count($data) == count($expectedHeaders)) {
                        $rowCorrect++;
                        foreach ($header as $index => $columnName) {
                            $cleanedColumnName = strtolower(cleanData($columnName));
                            $expectedKey = array_search($cleanedColumnName, array_map('strtolower', $expectedHeaders));
                            if ($expectedKey !== FALSE) {
                                ${$expectedKey} = cleanData($data[$index]);
                            }
                        }
                    } else {
                        $errRow++;
                        $rowChecks[] = array(
                            "row" => $row,
                            "status" => 0,
                            "note" => "wird nicht importiert: Anzahl der Spalten ist nicht " . count($expectedHeaders)
                        );
                    }
                }
            }
        } else {
            $errHeader = "Anzahl der Spalten ist nicht korrekt. Erwartete Spalten: " . count($expectedHeaders);
        }

        if(empty($errHeader)) {
            if($errRow == 0) { ?>
                <div class="alert alert-success d-inline-block mb-0">
                    Daten wurden erfolgreich hochgeladen und überprüft.<br>
					Es wird versucht <strong><?php echo $rowCorrect ?></strong> Datenzeilen zu importieren.<br>
                    Sie können mit dem Importvorgang starten.
                </div>
                <?php } else { ?>
                <div class="alert alert-warning d-inline-block mb-0">
                    Daten wurden erfolgreich hochgeladen und überprüft.<br>
                    Aber es gibt Zeilen, die nicht importiert werden würden. Korrigieren Sie entweder die betroffenen Zeilen oder importieren Sie sie so.<br>
                    Ein Versuch wird gemacht, <strong><?php echo $rowCorrect ?></strong> von insgesamt <strong><?php echo $row ?></strong> Zeilen zu importieren.<br>
                </div>
            <?php } ?>           
        <?php } else { $uploadErr = 1; ?>
            <div class="alert alert-danger d-inline-block mb-0">
                <p>CSV-Datei wurde hochgeladen, scheint aber falsch zu sein:</p>
                <p><strong><?php echo $errHeader ?></strong></p>
                Bitte überprüfen Sie die CSV-Datei, korrigieren Sie sie und laden Sie sie erneut hoch.
            </div>
        <?php }
    } else { ?>
        <div class="alert alert-danger d-inline-block mb-0">
            Fehler: Die Datei konnte nicht geöffnet werden.
        </div>
        <?php
    }
}