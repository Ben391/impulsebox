<div class="container">
	<div class="row">
		<div class="col-12">
			suche
		</div>
		<div class="col py-3">
			<?php 
			$totalEntries = getTotalEntries($mysqli);
			$entriesPerPage = 1;
			$totalPages = ceil($totalEntries / $entriesPerPage);

			$p = isset($_GET['p']) ? (int)$_GET['p'] : 1;
			$offset = ($p - 1) * $entriesPerPage;

			if($entries = getEntries($mysqli, $entriesPerPage, $offset)) {
			//echo "<pre>";print_r($entries);echo "</pre>";
			?>
			<table class="table table-hover table-bordered table-responsive">
				<thead>
					<tr>
						<th scope="col">ID</th>
						<th scope="col">Nummer</th>
						<th scope="col">Erstellt am</th>
						<th scope="col">Status</th>
						<th scope="col">Versicherter</th>
						<th scope="col">Krankenversicherung</th>
					</tr>
				</thead>
				<?php 
				foreach($entries AS $e) { 
					include "pages/home/inc/controller.php";
					?>
					<tr class="<?php if($entry_status > 0) echo "table-success "; ?>">
						<td><?php echo $entry_id; ?></td>
						<td>
							<a href="<?php echo ADMIN_BASEHREF ?>entry/?id=<?php echo $entry_id ?>">
								<?php echo $entry_number; ?>
							</a>
						</td>
						<td>
							<?php echo $entry_create_date_formatted; ?>
						</td>
						<td>
							<?php echo $entry_status_name ?>
							<?php if(!empty($entry_complete_date)) { echo " am ".$entry_complete_date_formatted; } ?>
						</td>
						<td>
							<?php echo $insured_person_data_first_name." ".$insured_person_data_last_name ?>
						</td>
						<td>
							<?php echo $insurance_type_short_name ?>
							<span class="text-muted"> | <?php echo $insurance_company_name ?></span>
						</td>					
					</tr>
				<?php } ?>	
			</table>
			<div>
				<?php for ($i = 1; $i <= $totalPages; $i++): ?>
					<a class="custom-btn <?php echo BTN_OUTLINE_SECONDARY ?>" href="?p=<?php echo $i; ?>"><?php echo $i; ?></a>
				<?php endfor; ?>
			</div>
			<?php } else { echo "no"; } ?>
		</div>
	</div>
</div>