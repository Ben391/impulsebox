<div class="row">
	<h4 class="mb-3">CSV-Datei hochladen</h4>
	<div class="col-8">
		<form action="<?php echo ADMIN_BASEHREF ?>pages/import/inc/upload/upload-handling.php" method="post" enctype="multipart/form-data">
			<div class="mb-4">
				<input class="form-control form-control-lg mb-3" type="file" name="fileToUpload" id="fileToUpload" required>
			</div>
			<div class="mb-4">
				<div class="form-check mb-1">
					<input class="form-check-input" type="checkbox" value="1" required>
					<label class="form-check-label" for="flexCheckDefault">
					CSV-Datei ist im UTF-8 Format
					</label>
				</div>
				<p class="text-danger line-height-14">Bitte laden Sie die CSV-Datei nur im UTF-8 Format hoch, um Umlaute korrekt darzustellen.</p>
				<img class="img-fluid border" src="<?php echo BASEHREF ?>img/csv_file_utf8.png">
			</div>
			<input type="hidden" name="admin_id" value="<?php echo $admin["id"] ?>">
			<input type="submit" class="btn btn-lg btn-primary" value="Hochladen" name="submit">
		</form>
	</div>
</div>
