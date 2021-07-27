<?php
ob_start();
session_start();

require_once 'classes/db_conn.php';
require_once 'classes/user.php';

if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == TRUE) {
    die(header("location:index.php"));
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Registracija korisnika</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!--Bootstrap CSS-->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

        <!--Bootstrap JS-->
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>

        <!--jQuery 3.6.0-->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

        <!-- Custom JS -->
        <script src="js/custom.js"></script>

    </head>
    <body>
        <?php include_once 'includes/navbar.php'; ?>

        <div class="container">
            <div class="row">
                <div class="col-md-10 col-lg-8 offset-md-1 offset-lg-2">
                    <div class="bg-light mt-4 p-4">
                        <form action="includes/reg_process.php" method="POST" class="row g-3">
                            <h4>Registracija korisnika</h4>

                            <?php
                            if (isset($_SESSION['reg_kor']) && !empty($_SESSION['reg_kor'])) {
                                echo $_SESSION['reg_kor'];
                                unset($_SESSION['reg_kor']);
                            }
                            ?>

                            <div class="col-12 voice">
                                <label>Korisničko ime: </label>
                                <span style="color: red;"><small id="username_span" ></small></span>
                                <input id="username_id" type="text" name="username" class="form-control" placeholder="Korisničko ime">
                            </div>
                            <div class="col-12">
                                <label>Šifra: </label>
                                <input type="password" name="password" class="form-control" placeholder="Šifra">
                            </div>
                            <div class="col-12">
                                <label>Email: </label>
                                <span style="color: red;"><small id="email_span" ></small></span>
                                <input id="email_id" type="email" name="email" class="form-control" placeholder="Email">
                            </div>

                            <div class="col-12">
                                <button id="submit_btn" type="submit" class="btn btn-primary col-12" name="registracija">Registruj se</button>
                            </div>
                        </form>
                        <hr class="mt-4">
                        <div class="col-12">
                            <p class="text-center mb-0">Imaš nalog? <a href="login.php">Prijavi se</a></p>
                        </div>
                        <div class="col-12">
                            <p class="text-center mb-0">Zaboravili ste šifru? <a href="reset_user_password.php">Napravi novu šifru</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script>
            // proverava da li je neko registrovan sa tim emailom
            check_mail();
            
            // proverava da li je korisnicko ime vec zauzeto
            check_username();
        </script>

    </body>
</html>