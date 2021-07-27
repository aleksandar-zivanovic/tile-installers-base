<?php include_once 'navbar.php'; ?>

<?php include_once 'input_form.php'; ?>

<?php
    $majstor = new Majstor();
    $majstor->zapamti_majstora();
?>