<?php

if (isset($_SESSION['new_user_verify_msg']) && !empty($_SESSION['new_user_verify_msg'])) {
    echo $_SESSION['new_user_verify_msg'] . "<hr>";
    unset($_SESSION['new_user_verify_msg']);
}

if (isset($_SESSION['lgin_needed']) && !empty($_SESSION['lgin_needed'])) {
    echo $_SESSION['lgin_needed'] . "<hr>";
    unset($_SESSION['lgin_needed']);
}

if (isset($_SESSION['rst_pwd_msg']) && !empty($_SESSION['rst_pwd_msg'])) {
    echo $_SESSION['rst_pwd_msg'] . "<hr>";
    unset($_SESSION['rst_pwd_msg']);
}

if (isset($_SESSION['pwd_changed_msg']) && !empty($_SESSION['pwd_changed_msg'])) {
    echo $_SESSION['pwd_changed_msg'] . "<hr>";
    unset($_SESSION['pwd_changed_msg']);
}


if (isset($_SESSION['login_msg']) && !empty($_SESSION['login_msg'])) {
    echo $_SESSION['login_msg'] . "<hr>";
    unset($_SESSION['login_msg']);
}