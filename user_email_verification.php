<?php
ob_start();
session_start();

require_once 'classes/user.php';
$user = new User;
$user->email_verification();