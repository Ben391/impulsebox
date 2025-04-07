<?php
if($total_price = getCompilationPrices()) {
	$compilation_max_total_price = floatval($total_price["compilation_max_total_price"]);
	$compilation_min_total_price = floatval($total_price["compilation_min_total_price"]);
} else {
	$compilation_max_total_price = 40;
	$compilation_min_total_price = 29;
}
?>
<div class="container py-4">
	<div class="row">
		<h1 class="h2 mb-3">Zusammenstellungen</h1>
		<?php 
		include_once "inc/compilation-price-range.php";
		include_once "inc/list.php";
		include_once "inc/add-new.php";
		?>
	</div>
</div>
<script>
$(document).ready(function(){
    var $modal, image, cropper;
			$('input[type="file"]').change(function(event){
			var compilation_id = $(this).attr('id').split('_')[2];
			var files = event.target.files;
			image = document.getElementById('sample_image_' + compilation_id);
			$modal = $('#modal-' + compilation_id);

			var done = function(url){
				image.src = url;
				$modal.modal('show');
			};

			if(files && files.length > 0) {
				var reader = new FileReader();
				reader.onload = function(event) {
					done(reader.result);
				};
				reader.readAsDataURL(files[0]);
			}
    	});
		$('.modal').on('shown.bs.modal', function() {
			console.log('Modal shown');
			var compilation_id = $(this).attr('id').split('-')[1];
			image = document.getElementById('sample_image_' + compilation_id);
			cropper = new Cropper(image, {
				aspectRatio: 1,
				viewMode: 3,
				preview: '.preview'
			});
			$modal = $(this); // Set $modal to the current modal
		}).on('hidden.bs.modal', function(){
			console.log('Modal hidden');
			cropper.destroy();
			cropper = null;
		});

		$('.crop').click(function(){
			var compilation_id = $(this).data('compilations-id');
			var canvas = cropper.getCroppedCanvas({
				width: 400,
				height: 400
			});

			canvas.toBlob(function(blob){
				var url = URL.createObjectURL(blob);
				var reader = new FileReader();
				reader.readAsDataURL(blob);
				reader.onloadend = function(){
					var base64data = reader.result;

					$.ajax({
						url: 'pages/compilations/inc/upload_img.php',
						method: 'POST',
						data: {
							image: base64data, 
							id: compilation_id
						},
						success: function(data){
							console.log('Image uploaded, modal closing');
							$modal.modal('hide');
							// Füge einen Zeitstempel hinzu, um den Browser-Cache zu umgehen
							$('#uploaded_image_' + compilation_id).attr('src', data + '?' + new Date().getTime());
						},
						error: function(err) {
							console.error('Upload failed', err);
						}
					});
				};
			}, 'image/png');
		});

	
	
    $('#saveCompilation').click(function(){
		var compilation = {};
		var compilationName = $('#compilationName').val();
		var totalPrice = 0;
		var isValid = true;
		
		if(!compilationName) {
			alert('Bitte geben Sie einen Namen für die Zusammenstellung ein.');
			return;
		}
		
        $('.product-checkbox:checked').each(function() {
			var productId = $(this).data('product-id');
			var price = parseFloat($("#product-" + productId + " .product-price").text());
			var quantity = $('.product-quantity[data-product-id="' + productId + '"]').val() || 1;
			
			// Überprüfen, ob die Menge eingegeben wurde
			if(!quantity || isNaN(quantity) || quantity < 1) {
				alert('Bitte geben Sie die Menge für alle ausgewählten Produkte ein.');
				isValid = false;  // Setzen Sie die Variable auf false
				return false;  // Beendet die .each()-Schleife
			}
			
			totalPrice += price * quantity;

            compilation[productId] = {
                "quantity": quantity,
                "size": "",
                "intolerance": ""
            };
        });
		
		// Überprüfen, ob Produkte ausgewählt wurden
		if (Object.keys(compilation).length === 0) {
			alert('Bitte wählen Sie mindestens ein Produkt aus.');
			return;
		}
		
		// Überprüfen, ob alles gültig ist, bevor der AJAX-Aufruf erfolgt
		if (!isValid) {
			return;
		}
		
		if (totalPrice > <?php echo json_encode($compilation_max_total_price); ?>) {
			alert('Gesamtpreis übersteigt ' + <?php echo json_encode($compilation_max_total_price); ?> + ' EUR.');
			return;
		} else if (totalPrice < <?php echo json_encode($compilation_min_total_price); ?>) {
			alert('Gesamtpreis unter ' + <?php echo json_encode($compilation_min_total_price); ?> + ' EUR.');
			return;   
		}

        $.ajax({
            url: 'pages/compilations/inc/save_compilation.php',
            type: 'POST',
            data: {
                compilation: JSON.stringify(compilation),
                name: compilationName
            },
            success: function(data) {
				alert('Neue Zusammenstellung wurde angelegt.');
				setTimeout(function() {
					window.location.reload();
				});
                //alert(data);
            },
            error: function() {
                alert('Fehler beim Speichern der Zusammenstellung.');
            }
        });
    });
	$('.toggle-active').click(function() {
		var compilationId = $(this).data('compilation-id');
		var currentActive = $(this).data('active');

		// Den neuen Status bestimmen
		var newActive = currentActive == 1 ? 0 : 1;

		$.ajax({
			url: 'pages/compilations/inc/toggle_active.php',
			type: 'POST',
			data: {
				id: compilationId,
				active: newActive
			},
			success: (data) => {
				alert(data);
				setTimeout(function() {
					window.location.reload();
				});
				// Button-Text und data-active Attribut aktualisieren
				$(this).text(newActive == 1 ? 'Deaktivieren' : 'Aktivieren');
				$(this).data('active', newActive);

				// Klassen hinzufügen/entfernen basierend auf dem neuen Status
				if (newActive == 1) {
					$(this).addClass('custom-btn-outline-primary').removeClass('custom-btn-outline-danger');
				} else {
					$(this).addClass('custom-btn-outline-danger').removeClass('custom-btn-outline-primary');
				}
			},
			error: () => {
				alert('Fehler beim Ändern des Status.');
			}
		});
	});
    $.get("../../inc/compilation_total_prices.php", function(data) {
        var result = JSON.parse(data);
        $("#max_price").val(result.compilation_max_total_price);
        $("#min_price").val(result.compilation_min_total_price);
    });

    // Daten aktualisieren
    $("#save").click(function(){
        var max_price = $("#max_price").val();
        var min_price = $("#min_price").val();
        
        $.post("../../inc/compilation_total_prices.php", { max_price: max_price, min_price: min_price }, function(data) {
            alert("Daten aktualisiert");
			setTimeout(function() {
				window.location.reload();
			});
        });
    });
	
	function calculateTotal() {
		let total = 0;
		$('.product-checkbox:checked').each(function() {
			let productId = $(this).data('product-id');
			let price = parseFloat($("#product-" + productId + " .product-price").text());
			let quantity = parseInt($('#product-' + productId + ' .product-quantity').val()) || 1;
			total += price * quantity;
		});
		$('#total-price').text('Gesamtsumme: ' + total.toFixed(2));
	}

    // Event Listener für Checkbox Änderungen
    $(document).on('change', '.product-checkbox', function() {
        calculateTotal();
    });

    // Event Listener für Mengenänderungen
    $(document).on('input', '.product-quantity', function() {
        calculateTotal();
    });
});
</script>