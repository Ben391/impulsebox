<?php $admin = getAdmin($mysqli, $_SESSION['admin_id']); ?>
<header class="border-bottom ftsz-1">
	<nav class="navbar navbar-expand-lg">
		<div class="container-fluid">
			<a class="navbar-brand" href="<?php echo ADMIN_BASEHREF ?>">
				<img border="0" alt="<?php echo $company["servicename"] ?>" src="<?php echo BASEHREF ?>img/logo/logo.png" style="height:54px">
			</a>
			<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarSupportedContent">
				<ul class="navbar-nav me-auto mb-2 mb-lg-0">
					<li class="nav-item px-1">
						<a class="nav-link ftsz-1" href="<?php echo ADMIN_BASEHREF ?>">Dashboard</a>
					</li>
					<li class="nav-item px-1">
						<a class="nav-link ftsz-1" href="<?php echo ADMIN_BASEHREF ?>entries/">Anträge</a>
					</li>
					<li class="nav-item px-1">
						<a class="nav-link ftsz-1" href="<?php echo ADMIN_BASEHREF ?>products/">Produkte</a>
					</li>
					<li class="nav-item px-1">
						<a class="nav-link ftsz-1 <?php if($current_page == "import") echo ' import'; ?>" href="<?php echo ADMIN_BASEHREF ?>import/">Import</a>
					</li>
					<li class="nav-item px-1 dropdown">
						<a class="nav-link ftsz-1 dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
						Einstellungen
						</a>
						<ul class="dropdown-menu ftsz-1">
							<li>
								<a class="dropdown-item <?php if($current_page == "status") echo ' active'; ?>" href="<?php echo ADMIN_BASEHREF ?>status/">Bearbeitungsstatus bearbeiten</a>
							</li>
							<li>
								<a class="dropdown-item <?php if($current_page == "email-vorlagen") echo ' active'; ?>" href="<?php echo ADMIN_BASEHREF ?>email-vorlagen/">E-Mail-Vorlagen</a>
							</li>
							<li>
								<a class="dropdown-item <?php if($current_page == "caregiver-services") echo ' active'; ?>" href="<?php echo ADMIN_BASEHREF ?>caregiver-services/">Pflegedienste</a>
							</li>
							<li>
								<a class="dropdown-item <?php if($current_page == "mitarbeiter") echo ' active'; ?>" href="<?php echo ADMIN_BASEHREF ?>mitarbeiter/">Mitarbeiter</a>
							</li>
						</ul>
					</li>
					<li class="nav-item px-1 dropdown">
						<a class="nav-link ftsz-1 dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
						Unternehmen
						</a>
						<ul class="dropdown-menu ftsz-1">
							<li>
								<a class="dropdown-item <?php if($current_page == "company-data") echo ' active'; ?>" href="<?php echo ADMIN_BASEHREF ?>company-data/">Unternehmensdaten</a>
							</li>
							<li>
								<a class="dropdown-item <?php if($current_page == "rechtliches") echo ' active'; ?>" href="<?php echo ADMIN_BASEHREF ?>rechtliches/">Rechtliches</a>
							</li>
						</ul>
					</li>
					<li class="nav-item px-1">
						<a target="_blank" class="nav-link ftsz-1" href="<?php echo BASEHREF ?>">
							Zur Startseite <i class="fa-solid fa-square-up-right ms-1 opacity-75"></i>
						</a>
					</li>
				</ul>
				<div class="d-flex flex-md-row flex-column">
					<?php if(isLoggedInAsAdmin()) { ?>
						<div class="d-flex align-items-center px-4">Hallo&nbsp;<a href="<?php echo ADMIN_BASEHREF ?>profile/"><?php echo $admin["first_name"] ?></a>!</div>
						<a class="custom-btn <?php echo BTN_OUTLINE_DANGER ?>" href="<?php echo ADMIN_BASEHREF ?>auth/logout.php" class="logout-button">Abmelden</a>
					<?php } ?>
				</div>
			</div>
		</div>
	</nav>
</header>
