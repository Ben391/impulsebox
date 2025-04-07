<div class="col-md-6">
	<?php if($compilations = getCompilations()) { ?>
	<h2 class="h4 mb-3">Vorhandene Zusammenstellungen</h2>
	<div id="existing-compilations">
		<?php foreach($compilations as $compilation) { 
			if ($compilation["active"] == "1") {?>
			<div id="compilation-<?php echo $compilation["id"] ?>" class="p-md-4 p-3 mb-3 bg-light-grey rounded-4">
			<?php } else { ?>
			<div id="compilation-<?php echo $compilation["id"] ?>" class="p-md-4 p-3 mb-3 bg-light-grey rounded-4 opacity-50">
			<?php } ?>
				<div class="row">
					<div class="col-auto">
						#<?php echo $compilation["id"] ?>
					</div>
					<?php include "pages/compilations/inc/image_crop.php"; ?>
					<div class="col">
						<h5 class="compilation-name"><?php echo $compilation["name"] ?></h5>
					</div>
					<div class="col-12">
						<div class="compilation-content mb-3">
							<?php
							foreach($compilation["products_readable"] as $product_readable) { ?>
							<div><?php echo $product_readable; ?></div>
							<?php } ?>
						</div>
						<div class="compilation-total-price mb-3">Gesamtpreis: <?php echo number_format($compilation["total_price"], 2); ?>€</div>
						<button class="custom-btn toggle-active <?php echo ($compilation["active"] == 1) ? 'custom-btn-outline-danger' : 'custom-btn-outline-primary'; ?>" data-compilation-id="<?php echo $compilation["id"]; ?>" data-active="<?php echo $compilation["active"]; ?>">
							<?php echo ($compilation["active"] == 1) ? 'Deaktivieren' : 'Aktivieren'; ?>
						</button>
					</div>
				</div>
			</div>
		<?php } ?>
	</div>
	<?php } ?>
</div>