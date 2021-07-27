<?php
ob_start();
session_start();

if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == TRUE) {

    require_once 'classes/db_conn.php';
    require_once 'classes/majstor.php';
    require_once 'includes/functions.php';

    include_once 'includes/header.php';
    include_once 'includes/body.php';
} else {
    $_SESSION['lgin_needed'] = '<div class="h-auto alert alert-warning alert-dismissible" role="alert">Da bi pristupili sajtu, morate prvo da se prijavite! <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
    die(header("location:login.php"));
}

include_once 'includes/footer.php';
?>