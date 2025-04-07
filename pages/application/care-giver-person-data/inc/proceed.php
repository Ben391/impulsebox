<div class="row">
	<div class="col-auto order-1">
		<a class="custom-btn custom-btn-md <?php echo BTN_OUTLINE_SECONDARY ?>" href="<?php echo $back_page_url ?>">
			<span class="btn-text">Zurück</span>
		</a>
	</div>
	<?php if($user_type != 2) { ?>
	<div class="col-md-auto col-12 order-md-2 order-last mt-4 mt-md-0">
		<a href="<?php echo $next_page_url ?>" class="custom-btn custom-btn-md <?php echo BTN_OUTLINE_SECONDARY ?> w-md-100-custom">
			Überspringen
			<i class="fa-solid fa-angles-right fa-lg opacity-75 ms-2"></i>
		</a>
	</div>
	<?php } ?>
	<div class="col order-3 text-end">
		<input type="hidden" id="care_giver_id" name="care_giver_id" value="<?php echo $care_giver_person_id ?>">
		<input type="hidden" id="care_giver_type" name="care_giver_type" value="2">
		<input type="hidden" id="care_giver_address_id" name="care_giver_address_id" value="<?php echo $care_giver_person_address_id ?>">
		<input type="hidden" id="insured_person_id" name="insured_person_id" value="<?php echo $insured_person_id ?>">
		<input type="hidden" id="insured_person_address_id" name="insured_person_address_id" value="<?php echo $insured_person_address_id ?>">
		<button name="proceed" class="custom-btn custom-btn-md <?php echo BTN_PRIMARY ?> w-100">
			<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true" style="display: none;"></span>
			<span class="btn-text">
				<i class="fa-regular fa-circle-check fa-lg me-2"></i>
				<span class="d-md-inline-block d-none">Speichern und weiter</span>
				<span class="d-md-none d-inline-block">Speichern</span>
			</span>
		</button>
	</div>
	<div class="col-12 order-4 text-center font-weight-400">
		<div id="message" class="mt-md-4 mt-3" style="display: none"></div>
	</div>
</div>