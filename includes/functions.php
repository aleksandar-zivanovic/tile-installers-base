<?php

function clean($value) {
    return trim(htmlspecialchars($value));
}

function is_user_logged_in() {
    if (!isset($_SESSION['user_id']) && !isset($_SESSION['user_loggedin']) && $_SESSION['user_loggedin'] != TRUE) {
        $_SESSION['lgin_needed'] = '<div class="h-auto alert alert-warning alert-dismissible" role="alert">Da bi pristupili sajtu, morate prvo da se prijavite! <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
        die(header("location:index.php"));
    }
}

function msg_brisanje_majstora() {
    if (!empty($_SESSION['brisanje_majstora'])) {
        echo $_SESSION['brisanje_majstora'];
        unset($_SESSION['brisanje_majstora']);
    }
}