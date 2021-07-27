<?php
ob_start();
session_start();

require_once 'classes/db_conn.php';
require_once 'classes/user.php';

if (isset($_GET['resetcd']) && strlen(trim($_GET['resetcd'])) == 100) {

    if (isset($_GET['email']) && filter_input(INPUT_GET, 'email', FILTER_VALIDATE_EMAIL)) {

        $user = new User();

        $user->email = htmlspecialchars(trim(filter_input(INPUT_GET, 'email', FILTER_SANITIZE_EMAIL)));
        $user->rst_code = htmlspecialchars(trim(filter_input(INPUT_GET, 'resetcd', FILTER_SANITIZE_STRING)));


        require_once 'classes/db_conn.php';
        $db = new Db_conn;
        $dbh = $db->getDbh();

        $query_rst_text = "SELECT * FROM users WHERE email = '" . $user->email . "' AND reset_code = '" . $user->rst_code . "'";
        $query = $dbh->prepare($query_rst_text);
        $query->execute();

        if ($query->rowCount() > 0) {
            ?>


            <!DOCTYPE html>
            <html lang="en">
                <head>
                    <title>Resetovanje šifre</title>
                    <meta charset="utf-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1">    
                    <!-- Bootstrap CSS -->
                    <link rel="stylesheet" href="https://www.markuptag.com/bootstrap/5/css/bootstrap.min.css">
                </head>
                <body>

                    <?php include_once 'includes/navbar.php'; ?>

                    <div class="container">
                        <div class="row">
                            <div class="col-md-4 offset-md-4">
                                <div class="login-form bg-light mt-4 p-4">
                                    <form action="includes/new_pwd_process.php" method="POST" class="row g-3">

                                        <?php
                                    if (isset($_SESSION['pwd_changed_msg']) && !empty($_SESSION['pwd_changed_msg'])) {
                                        echo $_SESSION['pwd_changed_msg'] . "<hr>";
                                        unset($_SESSION['pwd_changed_msg']);
                                    }
                                        ?>

                                        <h4>Promena šifre!</h4>
                                        <div class="col-12">
                                            <label>Nova šifra</label>
                                            <input type="text" name="npwd" class="form-control" placeholder="Nova šifra">
                                        </div>
                                        <div class="col-12">
                                            <label>Potvrdi šifru</label>
                                            <input type="text" name="npwd_cnfrm" class="form-control" placeholder="Potvrdi šifru">
                                            <input type="hidden" name="user_email" class="form-control" value="<?php echo $user->email; ?>">
                                            <input type="hidden" name="hrstcd" class="form-control" value="<?php echo $user->rst_code; ?>">
                                        </div>
                                        <div class="col-12">
                                            <button type="submit" class="btn btn-primary col-12" name="pwd_cnfrm">Prijavi se</button>
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



            <?php
        } else {
            $_SESSION['new_user_verify_msg'] = '<div class="alert alert-danger" role="alert">Greška! Podaci iz linka nisu ispravni!</div>';
            die(header("location:login.php"));
        }
    } else {
        $_SESSION['new_user_verify_msg'] = '<div class="alert alert-danger" role="alert">Greška! Email nedostaje!</div>';
        die(header("location:login.php"));
    }
} else {
    $_SESSION['new_user_verify_msg'] = '<div class="alert alert-danger" role="alert">Greška! Aktivacioni kod nedostaje ili je neispravan!</div>';
    die(header("location:reset_user_password.php"));
}
?>