<?php

ob_start();
session_start();

if (isset($_GET['check_username']) || isset($_POST['chkemail'])) {

    if (!empty($_GET['check_username'])) {
        require_once '../classes/user.php';
        $user = new User();
        $user->username = trim(htmlspecialchars(filter_input(INPUT_GET, 'check_username', FILTER_SANITIZE_STRING)));
        if ($user->username_check() === TRUE) {
            echo "korisnik postoji";
        }
    }


    if (isset($_POST['chkemail']) && !empty($_POST['chkemail'])) {
        require_once '../classes/user.php';
        $user = new User();
        $user->email = trim(htmlspecialchars(filter_input(INPUT_POST, 'chkemail', FILTER_SANITIZE_EMAIL)));
        if ($user->email_check() === TRUE) {
            echo "email postoji";
        }
    }
} else {
    die(header('location:../index.php'));
}
?>