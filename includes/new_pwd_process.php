<?php
ob_start();
session_start();
include_once '../classes/user.php';
$new_user = new User();
$new_user->new_pwd();
?>