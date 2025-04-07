<?php
$target_dir = "pages/import/files/".$admin["id"]."/";
$file = $target_dir . 'import.csv';
if(isset($_GET["action"]) AND $_GET["action"] == "delete-csv") {
	if(file_exists($file)) {
		unlink($file);
	}
}
include_once "inc/table-header.php";
?>
<div class="container py-4">
	<div class="row">
		<h1 class="h2 mb-3">Import</h1>
		<div class="col-md-7">
			<?php // if file doesnt exists
			if(!file_exists($file)) { ?>
			<div class="mb-2">
				<?php include_once "inc/upload/upload.php" ?>
			</div>
			<?php } 
			// if file exists
			else { ?>
				<?php include_once "pages/import/inc/check-uploaded-file.php" ?>
				<div>
					<a class="btn btn-outline-danger mt-3 mb-4" href="?page=import&action=delete-csv">Hochgeladene Datei löschen</a>
				</div>
			<?php } ?>
			<?php if(empty($uploadErr)) { ?>
			<div class="mb-3">
				<?php include_once "inc/import/import.php" ?>
			</div>
			<?php } ?>
		</div>
		<?php include "pages/import/inc/last-imports.php" ?>
	</div>
</div>