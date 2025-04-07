<div class="col-12">
	<form class="row d-flex align-items-end" method="GET">
		<div class="col mb-1" title="Durchsuchbare Inhalte: Antrags ID, Antragsnummer, Import ID, Vorname, Nachname der Versicherten Persono der Pflegeperson, Versichertennummer">
			<label class="ftsz-0875">Suche</label>
			<input type="text" class="form-control form-control-lg w-100" name="keyword" placeholder="Suchbegriff eingeben" value="<?php if(isset($_GET["keyword"])) echo $_GET["keyword"]; ?>">
		</div>
		<?php 
		$sql_where = "WHERE active = 1";
		if($statuses = getStatuses($mysqli, $sql_where)) { ?>
		<div class="col-auto mb-1">
			<label class="ftsz-0875">Berabeitungsstatus</label>
			<select class="form-select form-select-lg" name="status">
				<option value="0" selected>Alle</option>
				<?php foreach($statuses AS $status) { ?>
				<option value="<?php echo $status["status_id"] ?>" <?php if(isset($_GET["status"]) AND $_GET["status"] == $status["status_id"]) echo "selected"; ?>><?php echo $status["short_name"] ?></option>
				<?php } ?>
			</select>
		</div>
		<?php } ?>
		<div class="col-auto mb-1">
			<label class="ftsz-0875">Versicherungsart</label>
			<select class="form-select form-select-lg" name="insurance_type">
				<option value="0" selected>Alle</option>
				<option value="1" <?php if(isset($_GET["insurance_type"]) AND $_GET["insurance_type"] == 1) echo "selected"; ?>>gesetzlich</option>
				<option value="2" <?php if(isset($_GET["insurance_type"]) AND $_GET["insurance_type"] == 2) echo "selected"; ?>>privat</option>
			</select>
		</div>
		<?php include "date-filter.php" ?>
		<div class="col-auto mb-1">
			<button type="submit" class="custom-btn <?php echo BTN_PRIMARY ?>">Suchen</button>
		</div>
	</form>
</div>