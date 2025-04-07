<div class="row border-bottom mb-4">
	<h2 class="h3 mb-3">Pflegeperson</h3>
	<div class="col mb-3">
		<div class="row">
			<div class="col-md-6 mb-3">
				<div><?php echo $care_giver_person_salutation_name." ".$care_giver_person_first_name." ".$care_giver_person_last_name ?></div>
				<div><?php echo $care_giver_person_address_addition ?></div>
				<div><?php echo $care_giver_person_street ?></div>
				<div><?php echo $care_giver_person_zipcode." ".$care_giver_person_city ?></div>
			</div>
		</div>
		<div class="row">
			<h3 class="h5 mb-2">Kontakt</h3>
			<div class="col-md-6 mb-3">
				<h4 class="h6 mb-1">E-Mail-Adresse</h4>
				<div><?php echo $care_giver_person_email ?></div>
			</div>
			<div class="col-md-6 mb-3">
				<h4 class="h6 mb-1">Telefonnummer</h4>
				<div><?php echo $care_giver_person_phone ?></div>
			</div>
		</div>
		<?php if($current_page != "konto") { ?>
		<div class="row">
			<div class="col mb-3">
				<a class="custom-btn <?php echo BTN_OUTLINE_SECONDARY ?>" href="<?php echo BASEHREF ?>pflegeperson/<?php echo $admin_url_addition ?>">Ändern</a>
			</div>
		</div>
		<?php } ?>
	</div>
</div>