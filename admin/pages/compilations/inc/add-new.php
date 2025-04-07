<div class="col-md-6">
	<?php if($products = getProducts($mysqli,1)) { ?>
	<h2 class="h4 mb-3">Neue Zusammenstellung erstellen</h2>
	<div id="products" class="row p-md-4 p-3 mb-3 bg-light-grey rounded-4">
		<?php foreach($products AS $product) { ?>
		<div id="product-<?php echo $product["id"] ?>" class="col-12 mb-2">
			<div class="row d-flex align-items-center">
				<div class="col-auto">
					<div class="form-check form-check-inline">
						<input class="form-check-input product-checkbox" type="checkbox" data-product-id="<?php echo $product["id"] ?>">
					</div>
				</div>
				<div class="col">
					<div class="product-name"><?php echo $product["name"] ?></div>
					<div class="product-price"><?php echo $product["price"] ?></div>
				</div>
				<div class="col-auto">
					<input type="number" class="form-control form-control-lg product-quantity" data-product-id="<?php echo $product["id"] ?>" placeholder="Menge" min="1" style="max-width:120px" req>
				</div>
			</div>
		</div>
		<?php } ?>
	</div>
	<div id="total-price" class="fw-bold mb-3">Gesamtsumme: 0</div>
	<input class="form-control form-control-lg mb-3" type="text" id="compilationName" placeholder="Name der Zusammenstellung" required>
	<button class="custom-btn custom-btn-md <?php echo BTN_PRIMARY ?>" id="saveCompilation">Neue Zusammenstellung anlegen</button>
	<?php }	?>
</div>