<div class="container">
	<div class="row mb-3" id="configurator-section">
		<div class="col-12 text-center order-2">
			<h1 class="h3 d-md-block d-none mb-0">Wählen Sie Ihre Produkte</h1>
			<p class="mb-2 d-md-block d-none">
				Konfigurieren Sie Ihre Box nach Ihren Bedürfnissen.<br>Bei Bedarf können Sie Ihre Auswahl jeden Monat problemlos anpassen - sei es telefonisch, via E-Mail oder direkt in Ihrem Benutzerkonto.
			</p>
		</div>
		<div id="compilation-section" class="col-12">
			<?php 
			// include_once "pages/application/choose/compilations.php"; 
			$compilation_ids = isset($compilation_ids) ? $compilation_ids : [];
			?>
		</div>
		<div id="our-products" class="col-md-6 mb-md-4 mb-3 px-md-2 px-1 order-2">
			<?php include_once "our-products.php"; ?>
		</div>
		<div id="your-box" class="col-md-6 mb-md-4 mb-3 px-md-2 px-1 order-md-2 order-1">
			<?php include_once "your-box.php"; ?>
		</div>
		<div id="bed-protectors" class="col-12 mb-md-4 mb-3 px-md-2 px-1 order-2">
			<?php include_once "inc/bed-protectors.php"; ?>
		</div>
		<div class="col-12 text-center mb-md-5 mb-1 order-2">
			<input type="hidden" name="entry_id" value="<?php echo $entry_id ?>">
			<input type="hidden" name="user_id" value="<?php echo $user_id ?>">
			<a class="custom-btn custom-btn-md <?php echo BTN_PRIMARY ?> custom-btn-disabled w-md-100-custom mt-3" id="proceed" href="<?php echo BASEHREF ?>versichertendaten/">
				<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true" style="display:none;"></span>
				<span class="btn-text">
					<i class="fa-regular fa-circle-check fa-lg me-2"></i>
					Speichern und weiter
				</span>
			</a>
			<div class="col-12 text-center font-weight-400">
				<div id="message" class="mt-md-4 mt-3" style="display: none"></div>
			</div>
		</div>
	</div>
</div>
<script>
$(document).ready(function() {
	checkBedProtectorsAmount();
	var minimalAmount = <?php echo $compilation_min_total_price ?>;
	var maximalAmount = <?php echo $compilation_max_total_price ?>;
	var totalAmount = 0;
	// Variable im JSON Format um "Ihre Box" mit gespeicherten Produktdaten (falls eingeloggt, aus der DB und falls nicht eingeloggt aus der Session) zu füllen
	var initialProducts = <?php echo $products_json ?? 'null'; ?>;
	var entryId = <?php echo $entry_id ?? 'null'; ?>;
	//console.log("Initial products:", initialProducts);
	var productPrices = {};
	let productPromises = [];
	// Lade die Preise aller Produkte beim ersten Mal
	$('.product').each(function() {
		var productId = $(this).attr('id');
		let promise = $.get('pages/application/choose/inc/get_product_price.php', { product_id: productId })
		.then(function(productPrice) {
			productPrices[productId] = parseFloat(productPrice);
		})
		.fail(function() {
			console.error('Fehler beim Laden des Preises für Produkt', productId);
		});
		productPromises.push(promise);
	});
	// Überprüft den Gesamtbetrag
	function checkAmount() {
		if (totalAmount > 0 && totalAmount < minimalAmount) {
			$('#minimum-amount').html('Der Mindestbetrag <span class="font-weight-600">nicht</span> erreicht').show();
			$('#proceed').addClass("custom-btn-disabled");
		} else if (totalAmount >= minimalAmount) {
			$('#minimum-amount').html('Der Mindestbetrag <span class="font-weight-600">erreicht</span>').show();
			$('#proceed').removeClass("custom-btn-disabled");
		} else {
			$('#minimum-amount').addClass("custom-btn-disabled");
		}
	}
	$('.product').click(function() {
		if ($(this).hasClass('disabled')) {
			return;
		}
		var productId = $(this).attr('id');
		var productPrice = productPrices[productId];
		// console.log("Price for product", productId, ":", productPrice);
		// Animationsteil:
		var originalProductElement = $(this); // Sie haben bereits das angeklickte Element
		var animationElement = originalProductElement.clone();
		$('body').append(animationElement);

		animationElement.css({
			position: 'absolute',
			left: originalProductElement.offset().left,
			top: originalProductElement.offset().top,
			zIndex: 1000,
			width: originalProductElement.width(),
			height: originalProductElement.height()
		});

		// Animate die Kopie
		animationElement.animate({
			left: '+=500px',
			opacity: 0
		}, 300, function() {
			animationElement.remove();
		});

		if (totalAmount + productPrice <= maximalAmount) {
			var existingProduct = $('#your-box-products').find(`.selected-product[data-id='${productId}']`);

			if (existingProduct.length) {
				var currentQtyText = existingProduct.find('.qty').text(); // z.B. " (2)"
				var currentQty = parseInt(currentQtyText.match(/\d+/)[0]); // Extrahiert nur die Zahl
				existingProduct.find('.qty').text(` ${currentQty + 1}`);            
				totalAmount += productPrice;
				$('#total-amount span').text(totalAmount.toFixed(2));
				updateProgressBar();
				checkAmount();
				refreshProductStatus();
			} else {
				var size = '';  // Hole den size Wert aus dem Element oder einer anderen Quelle
				var intolerance = '';  // Hole den intolerance Wert aus dem Element oder einer anderen Quelle
				addProductToBox(productId, 1, size, intolerance);
			}
		}
	});

	// Menge aktualisieren
	$('#your-box-products').on('click', '.qty-section', function() {
		// Deaktiviere das Klicken (durch zu schnelles Klicken kam es zu negativen Gesamtmengen)
		var $qtySection = $(this);
		if ($qtySection.data('isProcessing')) return;
		$qtySection.data('isProcessing', true);

		var selectedProduct = $(this).closest('.selected-product'); 
		var productId = selectedProduct.attr('id'); 
		var productPrice = productPrices[productId]; 

		var currentQtyText = selectedProduct.find('.qty').text();
		var currentQty = parseInt(currentQtyText.match(/\d+/)[0]);

		if (currentQty > 1) {
			selectedProduct.find('.qty').text(` ${currentQty - 1}`);				
		} else {
			selectedProduct.fadeOut(300, function() {
				$(this).remove();
				updateBoxStatus();
				updateProductAddedClass();
			});
		}

		selectedProduct.css('opacity', '0.6');
		selectedProduct.animate({opacity: 1}, 700, function() {
			// Reaktiviere das Klicken am Ende der Animation
			$qtySection.data('isProcessing', false);
		});

		// Animationsteil:
		var animationElement = selectedProduct.clone();
		$('body').append(animationElement);

		// Setzt die Anfangswerte für das Element
		animationElement.css({
			position: 'absolute',
			left: selectedProduct.offset().left,
			top: selectedProduct.offset().top,
			zIndex: 1000,
			width: selectedProduct.width(),  // damit das Element die ursprüngliche Größe beibehält
			height: selectedProduct.height()  // ebenso für die Höhe
		});

		// Animate die Kopie nach links
		animationElement.animate({
			left: '-=500px',  // Hier wird der Wert um 500px reduziert, um das Element nach links zu bewegen
			opacity: 0
		}, 300, function() {
			animationElement.remove();
		});

		totalAmount -= productPrice;
		$('#total-amount span').text(totalAmount.toFixed(2));
		updateProgressBar();
		checkAmount();
		refreshProductStatus();
	});

	function updateProgressBar() {
		var amount = parseInt($("#total-amount span").text());
		var percentage = (amount / maximalAmount) * 100;

		// Begrenzen Sie den Prozentsatz zwischen 0 und 100.
		percentage = Math.min(Math.max(percentage, 0), 100);

		// Ändern Sie die Farbe der Progressbar basierend auf dem Betrag
		if (amount >= minimalAmount) {
			$(".progress").css("background-color", "#719E40");
		} else {
			$(".progress").css("background-color", "#d4dd4f");
		}
		$(".progress").css("width", percentage + "%");
	}

	function addProductToBox(productId, qty, size = '', intolerance = '') {

		var originalProductElement = $(`#our-products .product[id='${productId}']`);
		var productElement = originalProductElement.clone();

		productElement.removeClass('product').addClass('selected-product');
		productElement.attr('data-id', productId);

		var productNameElement = productElement.find('.product-qty');
		productNameElement.append(`<span class="qty"> ${qty}</span>`);

		// Füge das Produkt oben in den Kasten ein
		$('#your-box-products').prepend(productElement);

		if (productId == 1) {
			productElement.find('.product-size').show();
			productElement.find('.product-intolerance').show();

			// Setze die Größe und Intoleranz, falls vorhanden
			if (size) {
				productElement.find(`input[name='product-size'][value='${size}']`).prop('checked', true);
			}
			if (intolerance) {
				intolerance.split(',').forEach(function(intol) {
					productElement.find(`input[name='product_intolerance'][value='${intol.trim()}']`).prop('checked', true);
				});
			}
		}

		totalAmount += productPrices[productId] * qty;

		$('#total-amount span').text(totalAmount.toFixed(2));
		updateProgressBar();
		checkAmount();
		refreshProductStatus();

		productElement.find('.qty-section').addClass('bg-light-grey');
		productElement.find('.circle').html('<div class="minus"></div>').removeClass('bg-main-green-impulsebox').addClass('bg-yellow-impulsebox');

		productElement.find('.circle').attr('title', 'Aus meiner Box entfernen');

		productElement.css('opacity', '0.2');
		productElement.animate({ opacity: 1 }, 700);

		updateBoxStatus();

		// Animationsteil:
		var animationElement = originalProductElement.clone();
		$('body').append(animationElement);

		animationElement.css({
			position: 'absolute',
			left: originalProductElement.offset().left,
			top: originalProductElement.offset().top,
			zIndex: 1000,
			width: originalProductElement.width(),  // damit das Element die ursprüngliche Größe beibehält
			height: originalProductElement.height()  // ebenso für die Höhe
		});

		// Check the window width.
		var windowWidth = $(window).width();

		if (windowWidth > 768) {
			// Otherwise, move the element to the right.
			animationElement.animate({
				left: '+=500px',  // Move right by 500px.
				opacity: 0        // Fade out.
			}, 300, function() {
				// Remove the animated element after animation completes.
				animationElement.remove();
			});
		} else {
			// If window width is greater than 768px, move the element upwards.
			animationElement.animate({
				top: '-=500px',  // Move up by 500px.
				opacity: 0      // Fade out.
			}, 300, function() {
				// Remove the animated element after animation completes.
				animationElement.remove();
			});
		}

		updateProductAddedClass();
	}
	
	// Bei Klick-Ereignissen die Funktion ebenfalls ausführen
	$("#button-decrement").click(function(){
		var currentVal = parseInt($("#bed_protectors_amount").val());
		if (!isNaN(currentVal) && currentVal > 0) {
			$("#bed_protectors_amount").val(currentVal - 1);
		}
		checkBedProtectorsAmount();
	});

	$("#button-increment").click(function(){
		var currentVal = parseInt($("#bed_protectors_amount").val());
		if (!isNaN(currentVal) && currentVal < 4) {
			$("#bed_protectors_amount").val(currentVal + 1);
		}
		checkBedProtectorsAmount();
	});

function checkBedProtectorsAmount() {
    var currentVal = parseInt($("#bed_protectors_amount").val());

    if (currentVal === 0) {
        $("#button-decrement").addClass("custom-btn-disabled");
    } else {
        $("#button-decrement").removeClass("custom-btn-disabled");
    }

    if (currentVal === 4) {
        $("#button-increment").addClass("custom-btn-disabled");
    } else {
        $("#button-increment").removeClass("custom-btn-disabled");
    }
}	


	function updateBoxStatus() {
		var numberOfProducts = $('#your-box-products .selected-product').length;
		if (numberOfProducts > 0) {
			$('#your-box-products .empty-box').hide();
			$('#money-amount').show();
		} else {
			$('#your-box-products .empty-box').show();
			$('#money-amount').hide();
		}
	}

	function refreshProductStatus() {
		$('.product').removeClass('disabled');
		$('.product').each(function() {
			var checkProductId = $(this).attr('id');
			if (totalAmount + productPrices[checkProductId] > maximalAmount) {
				$(this).addClass('disabled');
			}
		});
	}

	function updateProductAddedClass() {
		// Für jedes Produkt in #our-products
		$('#our-products .product').each(function() {
			var productId = $(this).attr('id');

			// Überprüfen Sie, ob dieses Produkt in #your-box-products vorhanden ist
			var existsInBox = $('#your-box-products').find(`.selected-product[data-id='${productId}']`).length > 0;

			// Wenn ja, fügen Sie die .added Klasse hinzu, sonst entfernen Sie sie
			if (existsInBox) {
				$(this).addClass('added');
			} else {
				$(this).removeClass('added');
			}
		});
	}

	function loadInitialProducts() {
		if (initialProducts !== null) {
			for (let productId in initialProducts) {
				if (initialProducts.hasOwnProperty(productId)) {
					let quantity = initialProducts[productId].quantity;
					let size = initialProducts[productId].size;
					let intolerance = initialProducts[productId].intolerance;
					addProductToBox(productId, quantity, size, intolerance);
				}
			}
		}
	}

	$.when(...productPromises).done(function() {
		// Diese Funktion wird erst aufgerufen, wenn ALLE Produkt-Preise geladen sind.

		// Wenn Sie Initialprodukte haben, die auf der Seite geladen werden sollten,
		// laden Sie sie jetzt:
		loadInitialProducts();
		updateProductAddedClass();

		// Überprüfen Sie den Gesamtbetrag und aktualisieren Sie die Produktverfügbarkeit 
		// basierend auf den geladenen Preisen:
		refreshProductStatus();

		// Sie können auch andere Funktionen oder Operationen hier hinzufügen, die darauf warten müssen, 
		// dass alle Produkt-Preise geladen sind, bevor sie ausgeführt werden.
	});
	var compilation_ids = <?php echo json_encode($compilation_ids); ?>;
	
	if (Array.isArray(compilation_ids) && compilation_ids.length > 0) {
	  $.each(compilation_ids, function(index, compilationId) {
		$('#c-' + compilationId).click(function() {
		  // Gemeinsamer Code zur Behandlung von Klick-Ereignissen
		  $.ajax({
			url: 'pages/application/choose/inc/get_complitation.php',
			type: 'POST',
			data: { id: compilationId },
			success: function(response) {
			  var products = JSON.parse(response);

			  // Bestehende Produkte löschen
			  $('#your-box-products .selected-product').remove();
			  totalAmount = 0;

			  // Neue Produkte hinzufügen
			  for (var productId in products) {
				var productInfo = products[productId];
				addProductToBox(
				  productId,
				  productInfo.quantity,
				  productInfo.size,
				  productInfo.intolerance
				);
			  }

			  // Benutzeroberfläche aktualisieren
			  $('#total-amount span').text(totalAmount.toFixed(2));
			  updateProgressBar();
			  checkAmount();
			  refreshProductStatus();
			},
			error: function(error) {
			  console.log("Error:", error);
			}
		  });
		});
	  });
	}
	
    $(document).on('click', '#proceed', function(e) {
        e.preventDefault();
        var clickedButton = $(this);
        if (!validateSizes()) {
            $('#message, #message-product-size').text('Bitte wählen Sie eine Größe für Handschuhe aus.').addClass('text-danger').show();
			
            // Scrollen zu der KVNR Eingabe-Feld
            $('html, body').animate({
                scrollTop: $('#message-product-size').offset().top
            }, 500);
			
			return false;
        }		
        clickedButton.find('.spinner-border').show();
        clickedButton.find('.btn-text').hide();
        var product_data = [];
        var product_data_json = {};
        var entry_id = <?php echo $entry_id ?>;
        var user_id = <?php echo $user_id ?>;

		$('#your-box-products .selected-product').each(function() {
			var product = $(this);
			var id = product.attr('data-id');
			var name = product.data('name');
			var packQuantity = product.data('pack_quantity');
			var qty = parseInt(product.find('.qty').text().trim(), 10);
			var price = parseFloat(product.find('.product-price').text().replace('Preis:', '').trim());

			var intoleranceCheckboxInputs = product.find('input[name="product_intolerance"]:checked');
			var intoleranceArray = [];

			intoleranceCheckboxInputs.each(function() {
				intoleranceArray.push($(this).val());
			});

			var intolerance = intoleranceArray.join(", ");

			var productSizeElement = product.find('.product-size');
			if (productSizeElement.length > 0) {
				var selectedSizeInput = productSizeElement.find('input[name="product-size"]:checked');
				if (selectedSizeInput.length > 0) {
					var size = selectedSizeInput.val();
				} else {
					var size = "";
				}
			} else {
				var size = "";
			}
			
			if (intolerance !== "") {
				product_data_json[id] = {
					quantity: qty,
					size: size,
					intolerance: intolerance
				};
			} else {
				product_data_json[id] = {
					quantity: qty,
					size: size,
					intolerance: ""
				};
			}

			product_data.push({
				id: id,
				name: name,
				pack_quantity: packQuantity,
				price: price,
				quantity: qty,
				size: size,
				intolerance: intolerance,
			});
		});
		
		var bed_protectors_amount = $("#bed_protectors_amount").val()
		//console.log("product_data_json:", product_data_json);
        // POST-Request mit zusätzlichen Callbacks für Fehlerbehandlung
        $.ajax({
            type: "POST",
            url: 'pages/application/choose/save-choose.php',
            data: { 
				product_data: product_data,
				product_data_json: product_data_json,
				bed_protectors_amount: bed_protectors_amount,
				entry_id: entry_id,
				user_id: user_id
			},
            success: function(response) {
				$('#message').show().text("Efolgreich gespeichert").addClass('text-success');
                setTimeout(function() {
                  window.location.href = "<?php echo $next_page_url ?>";
                }, 1000);
            },
            error: function(jqXHR, textStatus, errorThrown) {
				console.error('Ein Fehler ist beim Senden aufgetreten. Status: ' + textStatus + '. Fehler: ' + errorThrown);
				$('#message').text('Ein Fehler ist beim Senden aufgetreten. Status: ' + textStatus + '. Fehler: ' + errorThrown).addClass('text-danger').show();
            }
        });
		
		function validateSizes() {
			var allSizesValid = true;

			$('#your-box-products .selected-product').each(function() {
				var product = $(this);
				var productSizeElement = product.find('.product-size');

				if (productSizeElement.length > 0) {
					var selectedSizeInput = productSizeElement.find('input[name="product-size"]:checked');

					if (selectedSizeInput.length === 0) {
						allSizesValid = false; // Setzen Sie die Variable auf false, wenn keine Option ausgewählt ist.
						productSizeElement.removeClass('border-warning').addClass('border-danger');
						return false; // Stoppe die each-Schleife
					} else {
						productSizeElement.removeClass('border-danger').addClass('border-success');
					}
				}
			});

			return allSizesValid;
		}
    });
	
});
</script>