<?php

ob_start();
session_start();
require_once 'includes/functions.php';
require_once 'classes/user.php';
require_once 'classes/majstor.php';

is_user_logged_in();

if (!isset($_POST['obrisi_majstora']) && !isset($_POST['izmeni_majstora']) && !isset($_POST['edit_majstor_process']) && !isset($_SESSION['edited_id'])) {
    die(header("location:index.php"));
}

//var_dump($_POST);
//var_dump($_SESSION);

$majstor = new Majstor();
if (isset($_SESSION['edited_id']) && !empty($_SESSION['edited_id'])) {
    $majstor->id = trim($_SESSION['edited_id']);
} else {
    $majstor->id = trim(htmlspecialchars($_POST['majstor_id']));
}
$result = $majstor->majstor_details();


// brisanje majstora iz baze
if (isset($_POST['obrisi_majstora'])) {
    $majstor->obrisi_majstora();
}


// promena podataka o majstoru
if (isset($_POST['izmeni_majstora']) || isset($_POST['edit_majstor_process']) || isset($_SESSION['edited_id'])) {
    unset($_SESSION['edited_id']);
    if (isset($_POST['edit_majstor_process'])) {
        $majstor->azuriraj_podatke_o_majstoru();
    }
    include_once 'includes/edit_majstor.php';
}
?>