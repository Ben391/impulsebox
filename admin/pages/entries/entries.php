<div class="container py-4">
	<div class="row">
		<?php include_once "inc/filter.php"; ?>
		<div class="col py-3">
			<?php
			include_once "inc/filter-controller.php";
			$keyword = "";
			if(isset($_GET["keyword"]) AND !empty($_GET["keyword"])) {
				$keyword = trim($_GET["keyword"]);
			}
			# Gesamtanzahl von gefilterten Einträgen
			$entriesPerPage = $offset = 0; // diese Angaben sind unrelevant für Ermitteln von Gesamtanzahl
			if($totalEntries = getEntries($mysqli, $where, $entriesPerPage, $offset, $keyword, true)) {
				# Anzahl von Einträgen pro Seite
				$entriesPerPage = 20;
				# Gesamtanzahl von gefilterteten Seiten
				$totalPages = ceil($totalEntries / $entriesPerPage);
				# Pagination
				$p = isset($_GET['p']) ? (int)$_GET['p'] : 1;
				$offset = ($p - 1) * $entriesPerPage;
				# Bekommen von Einträgen
				$entries = getEntries($mysqli, $where, $entriesPerPage, $offset, $keyword);
				//echo "<pre>";print_r($entries);echo "</pre>";
				include "inc/pagination.php";
				include "inc/pagination-details.php";
				?>
				<table class="table table-hover table-bordered table-responsive ftsz-1">
					<thead>
						<tr>
							<th scope="col">ID</th>
							<th scope="col">AntragsNr.</th>
							<th scope="col">Angelegt</th>
							<th scope="col">Verlauf</th>
							<th scope="col">Antragsteller</th>
							<th scope="col">Krankenversicherung</th>
							<th scope="col">Produkte</th>
							<th scope="col">PDF</th>
						</tr>
					</thead>
					<?php 
					foreach($entries AS $e) { 
						include "pages/entries/inc/controller.php";
						//echo $entry_status. "<br>";
						//echo "<pre>";print_r($e);echo "</pre>";
						?>
						<tr>
							<td><?php echo $entry_id; ?></td>
							<td>
								<a href="<?php echo ADMIN_BASEHREF ?>entry/?id=<?php echo $entry_id ?>">
									<?php echo $entry_number; ?>
								</a>
							</td>
							<td>
								<?php if(isset($entry_import_id) AND !empty($entry_import_id)) { ?>
								<span class="d-block ftsz-0875">
									<i class="fa-solid fa-file-import text-muted me-1" title="importiert"></i>
									<?php echo $entry_import_id ?>
								</span>
								<?php } ?>
								<?php echo $entry_create_datetime_formatted ?>
							</td>
							<td class="ftsz-0875">
								<?php if(isset($entry_status_data) AND !empty($entry_status_data)) { ?>
								<?php foreach($entry_status_data AS $status_data) { ?>
									<span class="d-block border-bottom pb-1 mb-1" style="line-height: 1.5">
										<span class="d-block"><?php echo $status_data["status_datetime_formatted"] ?></span>
										<span>
											<?php echo $status_data["status_name"]; ?>
											<?php if(!empty($status_data["sending_on_name"])) echo ": ".$status_data["sending_on_name"]; ?>
										</span>
									</span>
								<?php } ?>
								<?php } ?>
							</td>
							<td>
								<?php 
								if($user_type == 2) { 
									echo "Pflegeperson: ".$care_giver_person_first_name." ".$care_giver_person_first_name."<br>";
								} 
								?>
								<?php echo "Versicherter: ".$insured_person_data_first_name." ".$insured_person_data_last_name; ?>
							</td>
							<td>
								<?php echo $insurance_type_short_name ?><br>
								<?php echo $insurance_company_name ?>
							</td>	
							<td>
								<?php echo $compilation_name ?><br>
								<?php if(!empty($bed_protectors_amount)) echo " + ".$bed_protectors_amount." wv. BSE" ?>
							</td>
							<td class="text-center">
								<?php
								$file_path = "../pdf/" . $entry_number . ".pdf";
								if(file_exists($file_path)) { 
								?>
								<a target="_blank" href="<?php echo BASEHREF ?>inc/show.php?file_id=<?php echo $entry_id ?>">
									<i class="fa-solid fa-file-pdf fa-lg"></i>
								</a>
								<?php } ?>
							</td>
						</tr>
					<?php } ?>	
				</table>
				<?php 
				include "inc/pagination-details.php";
				include "inc/pagination.php";
				?>
			<?php } else { ?>
			<div class="mb-3">Keine Einträge gefunden</div>
			<a class="custom-btn <?php echo BTN_OUTLINE_SECONDARY ?>" href="<?php echo ADMIN_BASEHREF ?>entries/">Zurück</a>
			<?php } ?>
		</div>
	</div>
</div>