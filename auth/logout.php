<?php
include_once "../inc/settings.php";
unset($_SESSION['loggedin']);
unset($_SESSION['user_id']);
unset($_SESSION['email']);
unset($_SESSION['product_data']);
unset($_SESSION['products']);
unset($_SESSION['compilation_name']);
unset($_SESSION['bed_protectors_amount']);
unset($_SESSION['insured_person_data']);
header("Location:" . BASEHREF);
exit;