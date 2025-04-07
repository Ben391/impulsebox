<div class="row border-bottom mb-4">
	<div class="col">
		<div class="row mb-3">
			<h2 class="h3 mb-3">Versicherter</h2>
			<div class="col-md-6 mb-3">
				<h3 class="h5">Persönliche Daten</h3>
				<div><?php echo $insured_person_salutation_name." ".$insured_person_first_name." ".$insured_person_last_name ?></div>
				<div>Geburtsdatum: <?php echo $insured_person_birth_date ?></div>
			</div>
			<div class="col-md-6 mb-3">
				<h3 class="h5">Adresse</h3>
				<div><?php echo $insured_person_first_name." ".$insured_person_last_name ?></div>
				<div><?php echo $insured_person_address_addition ?></div>
				<div><?php echo $insured_person_street ?></div>
				<div><?php echo $insured_person_zipcode." ".$insured_person_city ?></div>
			</div>
		</div>
		<div class="row mb-3">
			<h3 class="h5 mb-3">Kontakt</h3>
			<div class="col-md-6 mb-3">
				<h4 class="h6 mb-1">E-Mail-Adresse</h4>
				<div><?php echo $insured_person_email ?></div>
			</div>
			<div class="col-md-6 mb-3">
				<h4 class="h6 mb-1">Telefonnummer</h4>
				<div><?php echo $insured_person_phone ?></div>
			</div>
			<?php if($current_page != "konto") { ?>
			<div class="col mb-3">
				<a class="custom-btn <?php echo BTN_OUTLINE_SECONDARY ?>" href="<?php echo BASEHREF ?>versichertendaten/<?php echo $admin_url_addition ?>">Ändern</a>
			</div>
			<?php } ?>
		</div>
		<div class="row mb-3">
			<div class="col-md-6 mb-3">
				<h3 class="h5 mb-3">Angaben zur Krankenkasse</h3>
				<div class="mb-2">
					<?php echo $insurance_type_name ?>
				</div>
				<div class="mb-2">
					<h4 class="h6 mb-1">Krankenkasse</h4>
					<div><?php echo $insurance_company_name ?></div>
				</div>
				<div>
					<h4 class="h6 mb-1">Versichertennummer</h4>
					<?php echo $insurance_number ?>
				</div>
			</div>
			<div class="col-md-6 mb-3">
				<h3 class="h5 mb-3">Angaben zum Pflegegrad</h3>
				<div class="mb-2">
					<h4 class="h6 mb-1">Pflegegrad</h4>
					<?php 
					if(!empty($care_level)) {
						echo $care_level;
					} else {
						echo "kein";
					}
					?>
				</div>				
				<div>
				<?php 
				if(!empty($care_level_since)) { ?>
					<h4 class="h6 mb-1">Pflegegrad seit</h4>
					<?php echo $care_level_since;
				} ?>
				</div>
			</div>
			<?php if(!empty($insurance_aid)) { ?>
			<div class="col-12 mb-3">
				<h3 class="h5 mb-1">Beihilfeberechtigung</h4>
				Die versicherte Person ist beihilfeberechtigt
			</div>
			<?php } ?>
			<?php if($current_page != "konto") { ?>
			<div class="col mb-3">
				<a class="custom-btn <?php echo BTN_OUTLINE_SECONDARY ?>" href="<?php echo BASEHREF ?>versichertendaten/<?php echo $admin_url_addition ?>">Ändern</a>
			</div>
			<?php } ?>
		</div>
	</div>
</div>