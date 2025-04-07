<div class="modal fade" id="contact" tabindex="-1" aria-labelledby="contactLabel" aria-hidden="true">
	<div class="modal-dialog modal-xl modal-fullscreen-sm-down">
		<div class="modal-content bg-light-grey">
			<div class="modal-header">
				<h2 class="modal-title fs-5" id="contactModalLabel">Haben Sie Fragen?</h1>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body p-xxl-5 p-3 row">
				<?php if(!empty($company["google_maps_embed_url"])) { ?>
				<div class="col order-last order-md-first">
					<iframe 
							src="<?php echo $company["google_maps_embed_url"] ?>" 
							style="width:100%; height: 100%" 
							class="border" 
							allowfullscreen="" 
							loading="lazy" 
							referrerpolicy="no-referrer-when-downgrade">
					</iframe>
				</div>
				<?php } ?>
				<div class="col-md-4">
					<div class="mb-3">
						<h5 class="h6 mb-1 text-muted">Telefon</h5>
						 <a class="text-decoration-none" target="_blank" href="tel:<?php echo $company["phone"] ?>"><?php echo $company["phone"] ?></a>
					</div>
					<div class="mb-3">
						<h5 class="h6 mb-1 text-muted">E-Mail</h5>
						<a class="text-decoration-none" target="_blank" href="mailto:<?php echo $company["email"] ?>"><?php echo $company["email"] ?></a>
					</div>
					<div class="mb-3">
						<h5 class="h6 mb-1 text-muted"><?php echo $company["company"] ?></h5>
						<?php echo $company["street"] ?><br>
						<?php echo $company["zipcode"] . " " . $company["city"] ?><br>
					</div>
					<?php if(!empty($company["working_hours"])) { ?>
					<div>
						<h5 class="h6 mb-1 text-muted">Arbeitszeiten</h5>
						<?php echo $company["working_hours"] ?>
					</div>
					<?php } ?>
				</div>
			</div>
		</div>
	</div>
</div>