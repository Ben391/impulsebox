<div class="row gx-0 bg-light-grey rounded-4 px-md-4 px-2 pt-md-4 pt-2 pb-md-3 pb-2">
	<div class="col-12 col-md-auto d-flex align-items-center justify-content-center">
		<img class="img-fluid" style="max-height: 150px;" src="<?php echo BASEHREF ?>img/products/99.png">
	</div>
	<div class="col mb-2 px-md-3 px-0">
		<div class="h5 mb-1">Wiederverwendbare Bettschutzeinlagen</div>
		<p class=" mb-1">Zusätzlich* zu Ihren 40 EUR - Extra Schutz nach Genehmigung durch Ihre Krankenkasse.</p>
		<p class="mb-1">Diese Bettschutzeinlagen können bis zu 250 Mal gewaschen werden. Neben einem erhöhten Liegekomfort und Schutz erzeugen Sie weniger Müll.</p>
		<p class="mb-0">* maximal 4 St. Im Jahr. Wenn Sie nicht befreit sind, fallen Rezeptgebühren von 10% an.</p>
	</div>
	<div class="col-md-auto col-12 d-flex align-items-center justify-content-center">
		<div class="input-group" style="width:150px">
			<button class="custom-btn <?php echo BTN_WARNING ?>" type="button" id="button-decrement">
				<span class="ftsz-1125" style="font-weight: 600">-</span>
			</button>
			<input type="text" class="form-control form-control-lg text-center" name="bed_protectors_amount" id="bed_protectors_amount" value="<?php echo $bed_protectors_amount ?>">
			<button class="custom-btn <?php echo BTN_PRIMARY ?>" type="button" id="button-increment">
				<span class="ftsz-1125" style="font-weight: 600">+</span>
			</button>
		</div>
	</div>
</div>
