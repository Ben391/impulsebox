<?php
include_once "../../inc/settings.php";
unset($_SESSION['loggedin_as_admin']);
unset($_SESSION['admin_id']);
unset($_SESSION['admin_email']);
// Leite den Benutzer zur Startseite oder Login-Seite um
header("Location:" . ADMIN_BASEHREF);
exit;