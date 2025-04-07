<script>
$(document).ready(function() {
  // Wenn ein Navigationslink angeklickt wird
  $('.nav-link').click(function(event) {
    // Entferne die 'active'-Klasse von allen Navigationslinks
    $('.nav-link').removeClass('text-custom-primary');
    // Füge die 'text-custom-primary'-Klasse zum angeklickten Navigationslink hinzu
    $(this).addClass('text-custom-primary');
  });

  // Beim Scrollen
  $(window).on('scroll', function() {
    // Durchlaufe alle Sektionen
    $('section').each(function() {
      var sectionTop = $(this).offset().top - 50;  // Der Wert "50" dient als Puffer
      var sectionBottom = sectionTop + $(this).height();
      
      // Überprüfe, ob der Benutzer die Sektion erreicht hat
      if ($(window).scrollTop() >= sectionTop && $(window).scrollTop() <= sectionBottom) {
        // Finde den entsprechenden Navigationslink
        var navLink = $('.nav-link[href="#' + $(this).attr('id') + '"]');
        // Entferne die 'text-custom-primary'-Klasse von allen anderen Navigationslinks
        $('.nav-link').removeClass('text-custom-primary');
        // Füge die 'text-custom-primary'-Klasse zum entsprechenden Navigationslink hinzu
        navLink.addClass('text-custom-primary');
      }
    });
  });
});
</script>
<?php if($current_page == "unterschrift") { ?>
<script src="<?php echo BASEHREF ?>js/signature_pad.min.js"></script>
<?php } ?>
<?php include_once "footer/modal-contact.php" ?>
<footer class="container-fluid bg-main-blue-impulsebox text-white py-5">
	<div class="container" style="font-size: 1rem">
		<div class="row mb-md-0 mb-3">
			<div class="col-md col-12 order-2 order-md-1 text-center text-md-start mb-5">
				<div class="mb-3">
					<div style="font-size:1.125rem; font-weight:400"><?php echo $company["servicename"] ?></div>
					<div class="opacity-75" style="line-height: 1.6">
					ist ein Service der <br>
					<?php echo $company["company"] ?><br>
					<?php echo $company["street"] ?><br>
					<?php echo $company["zipcode"] . " " . $company["city"] ?>
					</div>
				</div>
				<div>
					<i class="fa-solid fa-square-phone fa-xl opacity-50 me-3"></i>
					<a class="text-white text-decoration-none" style="" target="_blank" href="tel:<?php echo $company["phone"] ?>"><?php echo $company["phone"] ?></a>
				</div>
				<div class="mb-3">
					<i class="fa-solid fa-square-envelope fa-xl opacity-50 me-3"></i>
					<a class="text-white text-decoration-none" style="" target="_blank" href="mailto:<?php echo $company["email"] ?>">
						<?php echo $company["email"] ?>
					</a>
				</div>
			</div>
<!--			<div class="col-md col-12 text-center text-md-end order-3">
				<?php if($footer_links = get_footer_links($mysqli)) { ?>
				<ul class="list-unstyled">
					<?php foreach($footer_links AS $footer_link) { ?>
					<li class="px-2 mb-3">
						<a target="<?php echo $footer_link["target"] ?>" class="text-white text-decoration-none" href="<?php echo $footer_link["url"] ?>"><?php echo $footer_link["name"] ?> <i class="fa-solid fa-square-up-right opacity-75 ms-1"></i></a>
						<div class="opacity-75" style="font-size:0.875rem; line-height: 1.5"><?php echo $footer_link["description"] ?></div>
					</li>
					<?php } ?>
				</ul>
				<?php } ?>
			</div>-->
		</div>
		<div class="row">
			<div class="col-md col-12 text-center text-md-start">
				<span class="opacity-50 me-2">
					<span class="d-block d-md-inline me-1">© <?php echo date("Y") ?></span> 
					<?php echo $company["company"] ?>
				</span> 
			</div>
			<div class="col-md col-12 mb-3 mb-md-0 order-first order-md-last">
				<ul class="nav justify-content-center justify-content-md-end">
					<li class="px-3">
						<a class="text-white text-decoration-none" href="<?php echo BASEHREF ?>agb/">AGB</a>
					</li>
					<li class="px-3">
						<a class="text-white text-decoration-none" href="<?php echo BASEHREF ?>datenschutz/">Datenschutz</a>
					</li>
					<li class="ps-3 pe-2">
						<a class="text-white text-decoration-none" href="<?php echo BASEHREF ?>impressum/">Impressum</a>
					</li>
				</ul>
			</div>
		</div>
	</div>
</footer>