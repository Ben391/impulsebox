<?php if($choosedCompilation = getChoosedCompilation($_GET["entry-id"])) { ?>
<div class="container">
	<div class="row mb-3">
		<div class="col">
			<h3>Ihre Auswahl</h3>
			<?php foreach($choosedCompilation AS $choosedProduct) { ?>
				<div><?php echo $choosedProduct["quantity"] ?> x <?php echo $choosedProduct["product_name"] ?></div>
			<?php }	?>
		</div>
	</div>
</div>
<?php } ?>