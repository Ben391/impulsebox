<div class="row border-bottom mb-4">
	<h2 class="h3 mb-3">Pflegedienst</h3>
	<div class="col mb-3">
		<div class="row">
			<div class="col-md-6 mb-3">
				<div><?php echo $care_giver_service_company ?></div>
				<div><?php echo $care_giver_service_address_addition ?></div>
				<div><?php echo $care_giver_service_street ?></div>
				<div><?php echo $care_giver_service_zipcode." ".$care_giver_service_city ?></div>
			</div>
		</div>
		<div class="row">
			<h3 class="h5 mb-2">Kontakt</h3>
			<div class="col-md-6 mb-3">
				<h4 class="h6 mb-1">E-Mail-Adresse</h4>
				<div><?php echo $care_giver_service_email ?></div>
			</div>
			<div class="col-md-6 mb-3">
				<h4 class="h6 mb-1">Telefonnummer</h4>
				<div><?php echo $care_giver_service_phone ?></div>
			</div>
		</div>
		<?php if($current_page != "konto") { ?>
		<div class="row">
			<div class="col mb-3">
				<a class="custom-btn <?php echo BTN_OUTLINE_SECONDARY ?>" href="<?php echo BASEHREF ?>pflegedienst/<?php echo $admin_url_addition ?>">Ändern</a>
			</div>
		</div>
		<?php } ?>
	</div>
</div>