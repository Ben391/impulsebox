<div class="h6 text-center d-md-none d-block">Befüllen Sie Ihre <?php echo $company["servicename"] ?>:</div>
<div class="row bg-main-gradient rounded-4 shadow-sm px-md-4 px-2 pt-md-4 pt-2 pb-md-3 pb-0">
	<div class="col px-1">
		<div class="h5 text-white mb-md-3">Ihre <?php echo $company["servicename"] ?></div>
	</div>
	<?php if(isset($compilation_max_total_price) AND !empty($compilation_max_total_price)) { ?>
	<div class="col-auto px-1 compilation-summary-element-to-hide">
		<div class="h5 text-white"><?php echo $compilation_max_total_price ?> €</div>
	</div>
	<?php } ?>
	<div class="col-12 progress-bar mb-1 p-0 compilation-summary-element-to-hide">
		<div class="progress"></div>
	</div>
	<div class="col-12 compilation-summary-element-to-hide mb-md-2" id="money-amount">
		<div class="row">
			<div class="col text-white px-1" id="minimum-amount" style="display:none">Der Mindestbetrag noch nicht erreicht</div>
			<div class="col-auto text-end text-white mb-2 d-none" id="total-amount">Gesamtbetrag: <span>0</span> €</div>
		</div>
	</div>
	<div id="your-box-products" class="col-12">
		<div class="text-white text-center empty-box mb-1">Ihre Box ist leer</div>
	</div>
</div>
<script>
$(document).ready(function() {
	function updateResult() {
		let selectedValues = [];

		$('input.form-check-input:checked').each(function() {
			selectedValues.push($(this).val());
		});
	}
	// Event-Delegierung für Checkboxen
	$(document).on('change', '.form-check-input', function() {
		updateResult();
	});
	// Initialer Wert setzen
	updateResult();

});
</script>