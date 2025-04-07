<div class="row border-bottom mb-4">
	<div class="col">
		<div class="row">
			<h2 class="h3 mb-3">Lieferung</h2>
			<div class="col-md-6 mb-3">
				<?php if($delivery == 1) { ?>
				<h3 class="h5 mb-1">An den Versicherten</h3>
				<div class="mb-3">
					<div><?php echo $insured_person_street ?></div>
					<div><?php echo $insured_person_zipcode." ".$insured_person_city ?></div>
				</div>
				<?php } elseif($delivery == 2) { ?>
				<h3 class="h5 mb-1">An Pflegeperson</h3>
				<div class="mb-3">
					<div><?php echo $care_giver_person_street ?></div>
					<div><?php echo $care_giver_person_zipcode." ".$care_giver_person_city ?></div>
				</div>
				<?php } elseif($delivery == 3) { ?>
				<h3 class="h5 mb-1">An Pflegedienst</h3>
				<div class="mb-3">
					<div><?php echo $care_giver_service_company ?></div>
					<div><?php echo $care_giver_service_street ?></div>
					<div><?php echo $care_giver_service_zipcode." ".$care_giver_service_city ?></div>
				</div>
				<?php } ?>
			</div>
			<div class="col-md-6 mb-3">
				<h3 class="h5 mb-1">Häufigkeit</h5>
				<?php echo $delivery_frequency_name ?>
			</div>
		</div>
		<?php if(isset($supplier_change) AND $supplier_change == 1) { ?>
		<div class="row mb-3">
			<h5 class="mb-3">Versorgerwechsel</h5>
			<div class="col-md-6 mb-3">
				<h5 class="h6 mb-1">ja</h5>
			</div>
			<div class="col-md-6 mb-3">
				<h5 class="h6 mb-1">gewünschter Start der Lieferung</h5>
				<?php echo $supplier_change_delivery_start ?>
			</div>
		</div>
		<?php } ?>
		<?php if($current_page != "konto") { ?>
		<div class="row mb-3">
			<div class="col mb-3">
				<a class="custom-btn <?php echo BTN_OUTLINE_SECONDARY ?>" href="<?php echo BASEHREF ?>lieferung/<?php echo $admin_url_addition ?>">Ändern</a>
			</div>
		</div>
		<?php } ?>
	</div>
</div>