<header class="<?php if(is_home(HOMEURL)) { ?>fixed-top header-home<?php } ?>">
	<nav class="navbar navbar-expand-md">
		<div class="container-fluid px-3">
			<a class="navbar-brand" href="<?php echo BASEHREF ?>">
				<img class="header-logo-white" border="0" alt="<?php echo $company["servicename"] ?>" src="<?php echo BASEHREF ?>img/logo/logo_white.png" style="display: none;">
				<img class="header-logo" border="0" alt="<?php echo $company["servicename"] ?>" src="<?php echo BASEHREF ?>img/logo/logo.png">
			</a>
			<div class="d-md-none d-block custom-btn <?php echo BTN_OUTLINE_PRIMARY ?> me-3" data-bs-toggle="modal" data-bs-target="#contact" style="margin-left: auto;">
				<i class="fa-solid fa-phone fa-lg"></i>
			</div>
			<button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
				<div class="offcanvas-header">
					<a class="navbar-brand" href="<?php echo BASEHREF ?>">
						<img class="header-logo-offcanvas" border="0" alt="<?php echo $company["servicename"] ?>" src="<?php echo BASEHREF ?>img/logo/evs-main-logo.png">
					</a>
					<button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
				</div>
				<div class="offcanvas-body pt-0" style="font-size:1rem; font-weight: 400">
					<ul class="navbar-nav d-flex align-items-center me-auto mb-md-0 mb-3">
						<?php if(!is_home(HOMEURL)) { ?>
						<li class="nav-item px-xxl-2 px-0">
							<a class="nav-link" href="<?php echo BASEHREF ?>">Startseite</a>
						</li>
						<?php } ?>
						<?php if($current_page_area != "application" AND $current_page != "konto") { ?>
						<li class="nav-item px-xxl-2 px-0">
							<a class="nav-link" href="#vorteile">
								<span class="d-xxl-inline-block d-none">Ihre</span>
								 Vorteile
							</a>
						</li>
						<li class="nav-item px-xxl-2 px-0">
							<a class="nav-link" href="#erhalt">So funktioniert es</a>
						</li>
						<li class="nav-item px-xxl-2 px-0">
							<a class="nav-link" href="#produkte">Produkte</a>
						</li>
						<li class="nav-item px-xxl-2 px-0">
							<a class="nav-link" href="#voraussetzungen">Voraussetzungen</a>
						</li>
						<li class="nav-item px-xxl-2 px-0 ">
							
							<a class="nav-link" href="#formulare">Formulare</a>
						</li>
						<li class="nav-item px-xxl-2 px-0">
							<a class="nav-link" href="#faq">
								<span class="d-xxl-block d-none">Fragen und Antworten</span>
								<span class="d-xxl-none d-block">FAQ</span>
							</a>
						</li>
						<?php } ?>
					</ul>
					<div class="d-flex flex-md-row flex-column">
						<button class="ripple-box custom-btn <?php echo BTN_OUTLINE_PRIMARY ?> me-xxl-3 me-2 d-md-block d-none" data-bs-toggle="modal" data-bs-target="#contact">
							<i class="fa-solid fa-phone"></i>
							<span class="d-xxl-inline-block d-none ms-2">Kontakt</span>
						</button>
						<?php if(isLoggedIn()) { ?>
							<?php if($entry_status > 0) {
								if($current_page !== "konto") { ?>
									<a class="custom-btn <?php echo BTN_GRADIENT ?> me-xxl-3 me-md-2 me-0 mb-md-0 mb-3" href="<?php echo BASEHREF ?>auswahl/">Mein Konto</a>
								<?php }
							} else { ?>
								<?php if($current_page_area !== "application") { ?>
								<a class="custom-btn <?php echo BTN_GRADIENT ?> me-xxl-3 me-md-2 mb-md-0 mb-3" href="<?php echo BASEHREF ?>zusammenfassung/">Antrag vervollständigen</a>
								<?php } ?>
							<?php } ?>
							<a class="custom-btn <?php echo BTN_OUTLINE_DANGER ?>" href="<?php echo BASEHREF ?>auth/logout.php" class="logout-button">Abmelden</a>
						<?php } else { ?>
							<?php if($current_page_area !== "application") { ?>
								<a href="<?php echo BASEHREF ?>auswahl/" class="custom-btn <?php echo BTN_GRADIENT; if(isLoggedInAsAdmin()) { ?> disabled<?php } ?> mb-md-0 mb-3 me-xxl-3 me-md-2 me-0">
									<span>Pflegehilfsmittel beantragen</span>
								</a>
							<?php } ?>
							<a href="<?php echo BASEHREF ?>konto/" class="custom-btn <?php echo BTN_OUTLINE_SECONDARY; if(isLoggedInAsAdmin()) { ?> disabled<?php } ?>">Anmelden</a>
						<?php } ?>
					</div>
					<div class="d-md-none d-block mt-3">
						<ul class="navbar-nav d-flex flex-row justify-content-center">
							<li class="px-2">
								<a class="nav-link" href="<?php echo BASEHREF ?>agb/">AGB</a>
							</li>
							<li class="px-2">
								<a class="nav-link" href="<?php echo BASEHREF ?>datenschutz/">Datenschutz</a>
							</li>
							<li class="px-2">
								<a class="nav-link" href="<?php echo BASEHREF ?>impressum/">Impressum</a>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</nav>
</header>
<script>$(".offcanvas-body a").click(function(){$('.offcanvas').offcanvas('hide');});</script>
<?php if(is_home(HOMEURL)) { ?>
<script>
$(document).ready(function() {
    // Cached selectors
    var $header = $('header');
    var $headerLogo = $('.header-logo');
    var $headerLogoWhite = $('.header-logo-white');
    var $btnPrimary = $('.custom-btn-outline-primary', $header);
    var $btnSecondary = $('.custom-btn-outline-secondary', $header);
	var $btnDanger = $('.custom-btn-outline-danger', $header);
	var $navbarToggler = $('.navbar-toggler');
	var $navbarTogglerIcon = $('.navbar-toggler-icon');
	
    var prevScrollpos = $(window).scrollTop();
    var isWideScreen = $(window).width() > 768;

    function updateUI() {
        var currentScrollPos = $(window).scrollTop();
        isWideScreen = $(window).width() > 768;

        if (currentScrollPos > 0) {
            $header.addClass('header-scroll shadow-sm');
			$navbarToggler.removeClass('navbar-toggler-white');
			$navbarTogglerIcon.removeClass('navbar-toggler-icon-white');
            $headerLogo.show();
            $headerLogoWhite.hide();
        } else {
            $header.removeClass('header-scroll shadow-sm');
			$navbarToggler.addClass('navbar-toggler-white');
			$navbarTogglerIcon.addClass('navbar-toggler-icon-white');
            $headerLogo.hide();
            $headerLogoWhite.show();
        }
		
            if (currentScrollPos > 0) {
                $btnPrimary.addClass('custom-btn-outline-primary').removeClass('custom-btn-outline-primary-white');

            } else {
                $btnPrimary.addClass('custom-btn-outline-primary-white').removeClass('custom-btn-outline-primary');
            }

        if (isWideScreen) {
            if (currentScrollPos > 0) {
                $btnPrimary.addClass('custom-btn-outline-primary').removeClass('custom-btn-outline-primary-white');
                $btnSecondary.addClass('custom-btn-outline-secondary').removeClass('custom-btn-outline-secondary-white');
				$btnDanger.addClass('custom-btn-outline-danger').removeClass('custom-btn-outline-danger-white');
            } else {
                $btnPrimary.addClass('custom-btn-outline-primary-white').removeClass('custom-btn-outline-primary');
                $btnSecondary.addClass('custom-btn-outline-secondary-white').removeClass('custom-btn-outline-secondary');
				$btnDanger.addClass('custom-btn-outline-danger-white').removeClass('custom-btn-outline-danger');
            }
        }
        
        prevScrollpos = currentScrollPos;
    }

    // Initialize UI
    updateUI();

    // Update on scroll
    $(window).scroll(updateUI);
});
</script>
<?php } ?>