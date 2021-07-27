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
        <title>Resetovanje šifre</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">    
        
        <!--Bootstrap CSS-->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

        <!--Bootstrap JS-->
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
        
    </head>
    <body>

        <?php include_once 'includes/navbar.php'; ?>

        <div class="container">
            <div class="row">
                <div class="col-md-4 offset-md-4">
                    <div class="login-form bg-light mt-4 p-4">
                        <form action="includes/reset_pwd_process.php" method="POST" class="row g-3">

                            <?php
                            if (isset($_SESSION['new_user_verify_msg']) && !empty($_SESSION['new_user_verify_msg'])) {
                                echo $_SESSION['new_user_verify_msg'] . "<hr>";
                                unset($_SESSION['new_user_verify_msg']);
                            }
                            ?>

                            <h4>Resetovanje šifre!</h4>
                            <div class="col-12">
                                <label>Email</label>
                                <input type="email" name="rst_email" class="form-control" placeholder="Email">
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary col-12" name="user_rst_code">Prijavi se</button>
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
    </body>
</html>