<?php
ob_start();
session_start();

require_once 'classes/db_conn.php';
require_once 'classes/user.php';

if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == TRUE) {
    die(header("location:index.php"));
}


if(isset($_POST['user_lgn'])){
    $user = new User();
    $user->login_user();
}

?>



<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Login Stranica</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">    
        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://www.markuptag.com/bootstrap/5/css/bootstrap.min.css">
    </head>
    <body>

        <?php include_once 'includes/navbar.php'; ?>

        <div class="container">
            <div class="row">
                <div class="col-md-10 col-lg-8 offset-md-1 offset-lg-2">
                    <div class="login-form bg-light mt-4 p-4">
                        <form action="" method="POST" class="row g-3">

                            <?php include_once 'includes/login_msgs.php'; ?>

                            <h4>Prijava!</h4>
                            <div class="col-12">
                                <label>Email</label>
                                <input type="email" name="email" class="form-control" placeholder="Email">
                            </div>
                            <div class="col-12">
                                <label>Šifra</label>
                                <input type="password" name="password" class="form-control" placeholder="Šifra">
                            </div>
                            <!--                        <div class="col-12">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" id="rememberMe">
                                                            <label class="form-check-label" for="rememberMe"> Remember me</label>
                                                        </div>
                                                    </div>-->
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary col-12" name="user_lgn">Prijavi se</button>
                            </div>
                        </form>
                        <hr class="mt-4">
                        <div class="col-12">
                            <p class="text-center mb-0">Nemaš nalog? <a href="register.php">Registruj se</a></p>
                        </div>
                        <div class="col-12">
                            <p class="text-center mb-0">Zaboravili ste šifru? <a href="reset_user_password.php">Napravi novu šifru</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bootstrap JS -->
        <script src="https://www.markuptag.com/bootstrap/5/js/bootstrap.bundle.min.js"></script>
    </body>
</html>