<div class="row border-bottom mb-3">
	<div class="col">
		<div class="row mb-3">
			<h2 class="h3 mb-3">Antrag</h2>
			<div class="col-md-6 mb-3">
				<h3 class="h5">Antragsnummer</h3>
				<div><?php echo $entry_number ?></div>
			</div>
			<?php 
			$file_path = realpath(__DIR__ . "../pdf/" . $entry_id . ".pdf");
			if(file_exists($file_path)) { ?>
			<div class="col-md-6 mb-3">
				<div>
					<a class="custom-btn custom-btn-md <?php echo BTN_OUTLINE_PRIMARY ?>" target="_blank" href="<?php echo BASEHREF ?>inc/show.php?file_id=<?php echo $entry_id ?>">
						<i class="fa-regular fa-file-pdf fa-lg me-3"></i>
						Formular aufrufen
					</a>
				</div>
			</div>
			<?php } ?>
		</div>
	</div>
</div>