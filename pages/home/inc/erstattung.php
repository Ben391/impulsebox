<?php 
if($products = getProducts($mysqli,1)) { 
	$products[] = [
		'id' => 0,
		'active' => 1,
		'name' => 'wiederverwendbare Bettschutzeinlagen',
		'description' => 'Verhindert zuverlässig das Durchnässen der Matratze und ist besonders haltbar gekettelt',
		'img_id' => 99
	];
?>
<section id="produkte" class="container-fluid border-bottom py-xxl-5 py-5">
	<div class="container">
		<div class="row">
			<div class="col-md-6">
				<h2 class="px-2 mb-5">Welche Pflegehilfsmittel sind erstattungsfähig?</h2>
			</div>
		</div>
		<div class="row justify-content-center fs-1125 text-center">		
			<?php foreach($products AS $product) { ?>
			<div class="col-md-3 mb-4">
				<div class="bg-light-grey rounded-4 p-4 h-100">
					<?php 
					$image_extension = CheckImageExtension("img/products/large/".$product["id"]);
					 if ($image_extension) { 
						$product["id"];?>
						<?php switch($image_extension) {
							case("png"):?>
								<img class="img-fluid mb-3" src="<?php echo BASEHREF ?>img/products/large/<?php echo $product["id"] ?>.png?<?php echo time(); ?>">
						<?php break;
							case("jpg"):?>
								<img class="img-fluid mb-3" src="<?php echo BASEHREF ?>img/products/large/<?php echo $product["id"] ?>.jpg?<?php echo time(); ?>">
						<?php break;
							case("jpeg"):?>
								<img class="img-fluid mb-3" src="<?php echo BASEHREF ?>img/products/large/<?php echo $product["id"] ?>.jpeg?<?php echo time(); ?>">
						<?php break;
						} 
					}?>
					<h3 class="h5 mb-3"><?php echo ucfirst($product["name"]) ?></h3>
					<p class="ftsz-1 mb-0"><?php echo $product["description"] ?></p>
				</div>
			</div>
			<?php } ?>
		</div>
	</div>
</section>
<?php } ?>