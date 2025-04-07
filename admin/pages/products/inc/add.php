<div class="col-md-6">
	<h2 class="h4 mb-1">Neues Produkt hinzufügen</h2>
	<p class="ftsz-1 mb-2">Hinzugefügte Produkte sind <u>nicht</u> direkt aktiv.</p>
	<form id="productForm" method="POST" class="mb-3 p-md-4 p-3 mb-3 bg-light-grey rounded-4">
		<div class="mb-3">
			<label class="form-label">Name*</label>
			<input class="form-control form-control-lg" type="text" id="name" name="name" placeholder="Händedesinfektion">
		</div>
		<div class="mb-3">
				<label class="form-label">Kurzname*</label>
				<p class="ftsz-1 mb-0">Der Kurzname wird auf dem Antragsformular ausgegeben.</p>
				<input maxlength="21" class="form-control form-control-lg" type="text" id="short-name" name="short-name" placeholder="Händedesinf.">
			</div>
		<div class="row">
			<div class="col-12 mb-3">
				<label class="form-label">Packungsmenge*</label> 
				<input class="form-control form-control-lg" type="text" id="pack_quantity" name="pack_quantity" placeholder="500 ml oder 100 Stück">
			</div>
			<div class="col mb-3" title="Bitte geben Sie hier den Gesamtpreis des Artikels an (entsprechend der angegebenen Menge)">
				<label class="form-label d-block mb-0">Gesamtpreis*</label>
				<small>Gesamtpreis des Artikels entsprechend der angegebenen Menge</small>
				<input class="form-control form-control-lg w-100" style="max-width: 150px" type="number" step="0.01" id="price" name="price" placeholder="19,90">
			</div>
		</div>
		<div class="mb-3">
			<label class="form-label">Positionsnummer</label> 
			<input class="form-control form-control-lg" type="text" id="positionsnumber" name="positionsnumber" placeholder="z. B. 54.99.02.001">
		</div>
		<div class="mb-3">
			<label class="form-label">Beschreibung</label>
			<textarea rows="3" class="form-control form-control-lg" name="description" id="description" placeholder="Hochwirksame, gebrauchsfertige Schnelldesinfektion für alkoholbeständige Oberflächen und Gegenstände, wirksam gegen Bakterien, Viren und Pilze"></textarea>
		</div>
		<!--<input class="custom-btn custom-btn-md <?php echo BTN_OUTLINE_PRIMARY ?>" type="button" value="Speichern" id="saveProduct" disabled>-->
	</form>
</div>