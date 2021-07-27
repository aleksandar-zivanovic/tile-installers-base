<?php

if (isset($_SESSION['novi_majstor_succ']) && !empty($_SESSION['novi_majstor_succ'])) {
    echo $_SESSION['novi_majstor_succ'];
    unset($_SESSION['novi_majstor_succ']);
}

if (isset($_SESSION['novi_majstor_fail']) && !empty($_SESSION['novi_majstor_fail'])) {
    echo $_SESSION['novi_majstor_fail'];
    unset($_SESSION['novi_majstor_fail']);
}

if (isset($_SESSION["novi_majstor_greska"]) && !empty($_SESSION["novi_majstor_greska"])) {
    echo $_SESSION["novi_majstor_greska"];
    unset($_SESSION["novi_majstor_greska"]);
}

//    prebaceno u reset_user_password.php
//    if (isset($_SESSION['new_user_verify_msg']) && !empty($_SESSION['new_user_verify_msg'])){
//        echo $_SESSION['new_user_verify_msg'];
//        unset($_SESSION['new_user_verify_msg']);
//    }

if (isset($_SESSION['login_msg']) && !empty($_SESSION['login_msg'])) {
    echo $_SESSION['login_msg'];
    unset($_SESSION['login_msg']);
}
?>