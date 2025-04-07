<div class="container py-4">
	<div class="row">
		<h1 class="h2 mb-2">Produkte</h1>
		<div class="alert alert-danger">
			<p class="mb-1">Durch neueste gesetzliche Änderungen und entsprechende Anpassungen in der Funktionalitäten der Webseite ist es <strong>nicht mehr möglich bzw. nicht empfehlenswert</strong>, in diesem Bereich Produkte hinzuzufügen, zu aktivieren oder zu deaktivieren.</p>
			<p class="mb-1">Um neue Produkte hinzuzufügen, zu deaktivieren oder zu aktivieren, wenden Sie sich bitte an den Entwickler: <a target="_blank" href="mailto:it@imogroup.de">it@imogroup.de</a> oder <a target="_blank" href="tel:051199994211">0511 9999 4 211</a></p>
			<p class="fw-bold mb-0">Es ist weiterhin möglich, die Preise, die Packungsmenge, das Artikelbild, die Bezeichnung und die Kurzbeschreibung zu aktualisieren.</p>
		</div>
		<div class="row">
			<div class="col-md-6 mb-3">
				<p class="ftsz-1 mb-0">Da auf dem PDF-Formular <strong>maximal</strong> 12 Produkte und 1 Einmalhandschuhe dargestellt werden können, können hier ebenfalls maximal 12 Produkte + 1 Einmalhandschuhe aktiviert werden.</p>
			</div>
			<div class="col-md-6 mb-3">
				<p class="ftsz-1 mb-0">Produkte, die bereits in Aufträgen enthalten sind, sollten idealerweise gar nicht oder nur minimal umbenannt bzw. verändert werden, da dies später zu Verwirrung führen kann.</p>
			</div>
		</div>
		<?php 
		include_once "pages/products/inc/list.php";
		include_once "pages/products/inc/add.php";
		?>
	</div>
</div>
<script>
$(document).ready(function(){

    $('#saveProduct').click(function(){
        var name = $('#name').val();
		var short_name = $('#short-name').val();
        var pack_quantity = $('#pack_quantity').val();
        var price = $('#price').val();
        var positionsnumber = $('#positionsnumber').val();
        var description = $('#description').val();
		
        if (!name || !short_name || !pack_quantity || !price) {
            alert('Bitte füllen Sie Pflichtfelder aus.');
            return;
        }

        $.ajax({
            url: 'pages/products/inc/save_product.php',
            type: 'POST',
            data: {
                name: name,
				short_name: short_name,
                pack_quantity: pack_quantity,
                price: price,
				positionsnumber:positionsnumber,
				description:description,
            },
            success: function(data) {
                alert(data);
                setTimeout(function() {
                    window.location.reload();
                }, 1000);
            },
            error: function() {
                alert('Fehler beim Speichern des Produkts.');
            }
        });
    });
    $('.update-product').click(function(){
        var product_id = $(this).data('product-id');
		var product_name = $('#product-' + product_id + ' .product-name').val();
		var product_short_name = $('#product-' + product_id + ' .product-short-name').val();
		var product_description = $('#product-' + product_id + ' .product-description').val();
		var product_pack_quantity = $('#product-' + product_id + ' .pack-quantity').val();
		var product_positionsnumber = $('#product-' + product_id + ' .positionsnumber').val();
        var price = $('#product-' + product_id + ' .product-price').val();

        $.ajax({
            url: 'pages/products/inc/update_product.php',
            type: 'POST',
            data: {
                product_id: product_id,
				product_name: product_name,
				product_short_name: product_short_name,
				product_description: product_description,
				product_pack_quantity: product_pack_quantity,
				product_positionsnumber: product_positionsnumber,
                price: price,
            },
            success: function(data) {
                alert(data);
            },
            error: function() {
                alert('Fehler beim Aktualisieren.');
            }
        });
	});
    $('.product-deactivate').click(function(){
        var product_id = $(this).data('product-id');
		var product_status = 0;

        $.ajax({
            url: 'pages/products/inc/product_status.php',
            type: 'POST',
            data: {
                product_id: product_id,
				product_status: product_status,
            },
            success: function(data) {
                alert(data);
                setTimeout(function() {
                    window.location.reload();
                }, 1000);
            },
            error: function() {
                alert('Fehler beim Aktualisieren.');
            }
        });
    });
    $('.product-activate').click(function(){
        var product_id = $(this).data('product-id');
		var product_status = 1;

        $.ajax({
            url: 'pages/products/inc/product_status.php',
            type: 'POST',
            data: {
                product_id: product_id,
				product_status: product_status,
            },
            success: function(data) {
                alert(data);
                setTimeout(function() {
                    window.location.reload();
                }, 1000);
            },
            error: function() {
                alert('Fehler beim Aktualisieren.');
            }
        });
    });
});
</script>