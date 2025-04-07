<div class="row border-bottom mb-3">
	<div class="col">
		<div class="row mb-3">
			<h2 class="h3 mb-3">Antrag</h2>
			<div class="col-md-6 mb-3">
				<h3 class="h5">Antragsnummer</h3>
				<div><?php echo $entry_number ?></div>
			</div>
			<?php if($insurance_type == 1) { ?>			
				<div class="col-md-6 mb-3">
				<?php
				$file_path = $_SERVER['DOCUMENT_ROOT'] . "/pdf/" . $entry_number . ".pdf";
				if(file_exists($file_path)) {
					$show_pdf_url = BASEHREF . "inc/show.php?file_id=" . $entry_id; ?>
					<a class="custom-btn custom-btn-md <?php echo BTN_OUTLINE_PRIMARY ?> mb-3" target="_blank" href="<?php echo $show_pdf_url ?>">
						<i class="fa-regular fa-file-pdf fa-lg me-3"></i>
						Formular aufrufen
					</a>
				<?php } else { ?>
					<button class="custom-btn custom-btn-md <?php echo BTN_OUTLINE_PRIMARY ?> new-pdf-form-generate" data-entry-id="<?php echo $entry_id ?>" data-entry-number="<?php echo $entry_number ?>">PDF generieren</button>
				<?php } ?>
				</div>
			<?php } ?>
			<script>
			$(document).ready(function () {
				$('.new-pdf-form-generate').click(function () {
					var entry_id = $(this).data('entry-id');
					var entry_number = $(this).data('entry-number');
					$.ajax({
						url:"../views/ajax/new-pdf-form-generate.php",
						type: 'POST',
						data: { 
							entry_id: entry_id,
							entry_number: entry_number,
						},
						success: function (data) {

							alert(data);
							setTimeout(function() {
								window.location.reload();
								}, 1000);
						},
						error: function (jqXHR, textStatus, errorThrown) {
							alert('Fehler beim Senden der Daten: ' + textStatus);
						}
					})
				});
			});
			</script>
		</div>
	</div>
</div>