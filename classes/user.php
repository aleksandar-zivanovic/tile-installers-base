<?php

class User {

    public $userid;
    public $username;
    public $email;
    public $pwd;
    public $act_code;
    public $rst_code;
    private $hshd_pwd;
    public $created_at;

//    private $db_pwd; // sifra koja se dobija upitom iz baze
//    private $raw_pwd;

    public function registracija() {
        if (isset($_POST['registracija'])) {
            if (!empty($_POST['username']) && !empty($_POST['password']) && !empty($_POST['email'])) {
                include_once 'db_conn.php';

                $this->username = trim(htmlspecialchars(filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING)));
                $this->email = trim(htmlspecialchars(filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL)));
                $this->pwd = trim(htmlspecialchars(filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING)));
                $hashed_pwd = $this->pwd_hash();

                $db = new Db_conn();
                $dbh = $db->getDbh();

                // provera korisnickog imena
                $query_usr_check = "SELECT * FROM users WHERE username = :un";
                $query = $dbh->prepare($query_usr_check);
                $query->bindValue(":un", $this->username, PDO::PARAM_STR);
                $query->execute();
                if ($query->fetch(PDO::FETCH_ASSOC) > 0) {
                    $_SESSION['reg_kor'] = '<div class="alert alert-danger" role="alert">Korisničko ime već postoji. Odaberi drugo korisničko ime.</div>';
                    die(header("location:../register.php"));
                }

                // provera email adrese
                $query_em_check = "SELECT * FROM users WHERE email = :ea";
                $query = $dbh->prepare($query_em_check);
                $query->bindValue(":ea", $this->email, PDO::PARAM_STR);
                $query->execute();
                if ($query->fetch(PDO::FETCH_ASSOC) > 0) {
                    $_SESSION['reg_kor'] = '<div class="alert alert-danger" role="alert">Korisnik sa ovom email adresom već postoji!</div>';
                    die(header("location:../register.php"));
                }

                // generating activation code
                $this->act_code = bin2hex(random_bytes(50));

                // upis novog korisnika u bazu (posle provere korisnickog imena i sifre
                $query_registracija = "INSERT INTO users (username, pwd, email, created_at, activation_code) VALUES (:un, :pwd, :em, CURRENT_TIMESTAMP, :ac)";
                $query = $dbh->prepare($query_registracija);
                $query->bindValue(":un", $this->username, PDO::PARAM_STR);
                $query->bindValue(":pwd", $hashed_pwd, PDO::PARAM_STR);
                $query->bindValue(":em", $this->email, PDO::PARAM_STR);
                $query->bindValue(":ac", $this->act_code, PDO::PARAM_STR);
                if ($query->execute()) {
                    $_SESSION['reg_kor'] = '<div class="h-auto alert alert-primary" role="alert">Uspešno ste se uneli podatke. Ostao je još jedan korak. Na email smo ti poslali verifikacioni link. Posle verifikacije moći ćeš da se prijaviš na sajt.</div>';

                    require_once '../includes/user_reg_send_mail.php';
                }
            } else {
                $_SESSION['reg_kor'] = '<div class="alert alert-danger" role="alert">Niste popunili sva potrebna polja. Pokušajte ponovo.</div>';
                die(header("location:../register.php"));
            }
        }
    }

    private function pwd_hash() {
        $this->hshd_pwd = hash('sha512', $this->pwd);
        $this->hshd_pwd = password_hash($this->hshd_pwd, PASSWORD_BCRYPT, ['cost' => 12]);
        return $this->hshd_pwd;
    }

    public function pwd_verify($db_pwd) {
        $this->hshd_pwd = hash('sha512', $this->pwd);
        if (password_verify($this->hshd_pwd, $db_pwd)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    // verifikacija emaila pri registraciji novog user-a
    public function email_verification() {
        if (isset($_GET['actcd']) && strlen(trim($_GET['actcd'])) == 100) {
            if (isset($_GET['email'])) {

                $this->email = htmlspecialchars(trim(filter_input(INPUT_GET, 'email', FILTER_SANITIZE_EMAIL)));
                $this->act_code = htmlspecialchars(trim(filter_input(INPUT_GET, 'actcd', FILTER_SANITIZE_STRING)));

                require_once 'db_conn.php';
                $db = new Db_conn;
                $dbh = $db->getDbh();

                $query_text = "SELECT * FROM users WHERE email = '" . $this->email . "' AND activation_code = '" . $this->act_code . "'";
                $query = $dbh->prepare($query_text);
                $query->execute();

                if ($query->rowCount() > 0) {
                    $rez = $query->fetch(PDO::FETCH_ASSOC);
                    echo $this->userid = $rez['usr_id'];
                    $sql_confirmed = "UPDATE users SET activated = TRUE, activation_code = 'NULL' where usr_id = " . $this->userid;
                    $query = $dbh->prepare($sql_confirmed);
                    if ($query->execute()) {
                        $_SESSION['new_user_verify_msg'] = '<div class="h-auto alert alert-primary" role="alert">Uspešno ste potvrdili svoju email adresu. Sada možete da se prijavite na sajt!.</div>';
                        die(header("location:login.php"));
                    } else {
                        // greska NUV001 - nije izvrsen upis verifikacije u bazu
                        $_SESSION['new_user_verify_msg'] = '<div class="alert alert-danger" role="alert">Greška! Pokušajte ponovo. Ako se ova greška ponovi, prijavi administratoru. Kod greške je <strone>NUV001</strone></div>';
                        die(header("location:index.php"));
                    }
                } else {
                    $_SESSION['new_user_verify_msg'] = '<div class="alert alert-danger" role="alert">Greška! Ovaj kod i/ili email je pogrešan</div>';
                    die(header("location:index.php"));
                }
            } else {
                $_SESSION['new_user_verify_msg'] = '<div class="alert alert-danger" role="alert">Greška! Email nedostaje!</div>';
                die(header("location:index.php"));
            }
        } else {
            $_SESSION['new_user_verify_msg'] = '<div class="alert alert-danger" role="alert">Greška! Aktivacioni kod nedostaje ili je neispravan!</div>';
            die(header("location:index.php"));
        }
    }

    public function login_user() {
        require_once 'db_conn.php';
        $db = new Db_conn;
        $dbh = $db->getDbh();


        if (isset($_POST['email']) && !empty($_POST['email'])) {

            if (isset($_POST['password']) && !empty($_POST['password'])) {

                $this->email = htmlspecialchars(trim(filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL)));
                $this->pwd = htmlspecialchars(trim(filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING)));



                $count_query = "SELECT COUNT(*) FROM users WHERE email = :em";
                $query_count = $dbh->prepare($count_query);
                $query_count->bindValue(":em", $this->email, PDO::PARAM_STR);
                $query_count->execute();


                if ($rezultat = $query_count->fetch(PDO::FETCH_COLUMN) > 0) {
                    $login_query = "SELECT * FROM users WHERE email = :em";
                    $query_login = $dbh->prepare($login_query);
                    $query_login->bindValue(":em", $this->email, PDO::PARAM_STR);
                    $query_login->execute();
                    $result = $query_login->fetch(PDO::FETCH_ASSOC);
                    $db_pwd = $result["pwd"];

                    $pass_matching = $this->pwd_verify($db_pwd);

                    if ($pass_matching === TRUE) {
                        $_SESSION['user_id'] = $result["usr_id"];
                        $_SESSION['user_loggedin'] = TRUE;
                        $_SESSION['username'] = $result['username'];
                        $_SESSION['email'] = $result['email'];
                        $_SESSION['login_msg'] = '<div class="h-auto alert alert-primary alert-dismissible" role="alert">Uspešno ste prijavili na sajt! <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
                        die(header("location:index.php"));
                    }
                } else {
                    $_SESSION['login_msg'] = '<div class="alert alert-danger" role="alert">Uneli ste pogresne podatke. Pokšuajte ponovo.</div>';
                    die(header("location:login.php"));
                }
            } else {
                $_SESSION['login_msg'] = '<div class="alert alert-danger" role="alert">Niste uneli šifru.</div>';
                die(header("location:login.php"));
            }
        } else {
            $_SESSION['login_msg'] = '<div class="alert alert-danger" role="alert">Niste uneli email adresu.</div>';
            die(header("location:login.php"));
        }
    }

    public function user_reset_code() {

        if (isset($_POST['user_rst_code'])) {
            var_dump($_POST['rst_email']);
            if (!empty($_POST['rst_email']) && filter_input(INPUT_POST, 'rst_email', FILTER_VALIDATE_EMAIL)) {
                $this->email = htmlspecialchars(trim(filter_input(INPUT_POST, 'rst_email', FILTER_SANITIZE_EMAIL)));

                require_once 'db_conn.php';
                $db = new Db_conn();
                $dbh = $db->getDbh();
                $email_check_query = "SELECT COUNT(*) FROM users WHERE email = :em";
                $query = $dbh->prepare($email_check_query);
                $query->bindValue(':em', $this->email, PDO::PARAM_STR);
                $query->execute();
                if ($query->fetch(PDO::FETCH_ASSOC) > 0) {

                    // generating reset code
                    $this->rst_code = bin2hex(random_bytes(50));

                    $act_code_query = "UPDATE users SET reset_code = '" . $this->rst_code . "' WHERE email = '" . $this->email . "'";
                    $query_act_code = $dbh->prepare($act_code_query);
                    if ($query_act_code->execute()) {
                        include_once '../includes/user_reset_send_email.php';
                    }

                    echo "<br>POSTOJI EMAIL<br>";
                } else {
                    echo "<br>EMAIL NE POSTOJI!!!<br>";
                }
            } else {
                echo "<br>Niste uneli email ili email adresa nije validna<br>";
            }
        } else {
            echo " kontrolni tekst : niste pritisnuli dugme za reset!!!";
        }
    }

    // unos nove sifre od strane user-a
    public function new_pwd() {

        $this->email = htmlspecialchars(trim(filter_input(INPUT_POST, 'user_email', FILTER_SANITIZE_EMAIL)));
        $this->pwd = htmlspecialchars(trim(filter_input(INPUT_POST, 'npwd', FILTER_SANITIZE_STRING)));
        $this->rst_code = htmlspecialchars(trim(filter_input(INPUT_POST, 'hrstcd', FILTER_SANITIZE_STRING)));
        $hashed_pwd = $this->pwd_hash();

        if (!empty($_POST['npwd']) && strlen(trim($_POST['npwd'])) >= 3 && !empty($_POST['npwd_cnfrm']) && strlen(trim($_POST['npwd_cnfrm'])) >= 3) {

            if (trim($_POST['npwd']) === trim($_POST['npwd_cnfrm'])) {
                if (isset($_POST['user_email']) && filter_input(INPUT_POST, 'user_email', FILTER_VALIDATE_EMAIL)) {
                    require_once 'db_conn.php';
                    $db = new Db_conn;
                    $dbh = $db->getDbh();

                    $query_rst_text = "SELECT * FROM users WHERE email = '" . $this->email . "' AND reset_code = '" . $this->rst_code . "'";
                    $query = $dbh->prepare($query_rst_text);
                    $query->execute();

                    if ($query->rowCount() > 0) {
                        $rez = $query->fetch(PDO::FETCH_ASSOC);
                        echo $this->userid = $rez['email'];
                        $sql_confirmed = "UPDATE users SET pwd = '" . $hashed_pwd . "', reset_code = CURRENT_TIMESTAMP WHERE email = '" . $this->email . "'";
                        $query = $dbh->prepare($sql_confirmed);

                        if ($query->execute()) {
                            $_SESSION['pwd_changed_msg'] = '<div class="h-auto alert alert-primary" role="alert">Uspešno ste promenili šifru. Sada možete da se prijavite sa novom šifrom!.</div>';
                            die(header("location:../login.php"));
                        } else {
                            // greska NUV001 - nije izvrsen upis verifikacije u bazu
                            $_SESSION['pwd_changed_msg'] = '<div class="alert alert-danger" role="alert">Greška! Pokušajte ponovo. Ako se ova greška ponovi, prijavi administratoru.</div>';
                            die(header("location:../new_password.php?email=" . $this->email . "&resetcd=" . $this->rst_code));
                        }
                    } else {
                        $_SESSION['pwd_changed_msg'] = '<div class="alert alert-danger" role="alert">Greška! Link za resetovanje šifre nije ispravan!</div>';
                        die(header("location:../login.php"));
                    }
                }
            } else {
                $_SESSION['pwd_changed_msg'] = '<div class="alert alert-danger" role="alert">Greška! Šifre moraju da bude iste.</div>';
                die(header("location:../new_password.php?email=" . $this->email . "&resetcd=" . $this->rst_code));
            }
        } else {
            $_SESSION['pwd_changed_msg'] = '<div class="alert alert-danger" role="alert">Greška! Šifre moraju da imaju najmanje 3 karaktera.</div>';
            die(header("location:../new_password.php?email=" . $this->email . "&resetcd=" . $this->rst_code));
        }
    }

    public function users_details() {
        require_once 'db_conn.php';
        $db = new Db_conn();
        $dbh = $db->getDbh();

        $this->userid = $_SESSION['user_id'];

        $user_details_query = "SELECT * FROM users WHERE usr_id = " . $this->userid;
        $query = $dbh->prepare($user_details_query);
        $query->execute();
        $result = $query->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function get_db() {
        require_once 'db_conn.php';
        $db = new Db_conn();
        $dbh = $db->getDbh();
        return $dbh;
    }

    public function email_check() {

        $dbh = $this->get_db();
        $query_em_check = "SELECT COUNT(*) FROM users WHERE email = :ea";
        $query = $dbh->prepare($query_em_check);
        $query->bindValue(":ea", $this->email, PDO::PARAM_STR);
        $query->execute();
        if ($query->fetchColumn() > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function username_check() {

        $dbh = $this->get_db();
        $query_un_check = "SELECT COUNT(*) FROM users WHERE username = :un";
        $query = $dbh->prepare($query_un_check);
        $query->bindValue(":un", $this->username, PDO::PARAM_STR);
        $query->execute();
        if ($query->fetchColumn() > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function edit_account() {

        $this->username = htmlspecialchars(trim(filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING)));
        $this->email = htmlspecialchars(trim(filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL)));
        $this->userid = $_SESSION['user_id'];

        // query bez sifre
        if (empty($_POST['new_password'])) {
            if (filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL)) {
                if ($this->email_check() === TRUE && $this->email != $_SESSION['email']) {
                    $_SESSION['edit_acc_msg'] = '<div class="alert alert-danger" role="alert">Greška! Ovo korisnik sa ovim emailom već postoji!</div>';
                    die(header("location:../account.php"));
                } else {
                    if ($this->username_check() === TRUE && $this->username != trim($_SESSION['username'])) {
                        $_SESSION['edit_acc_msg'] = '<div class="alert alert-danger" role="alert">Greška! Ovo korisnik sa korisničkim <i>imenom</i> ' . $this->username . ' već postoji!</div>';
                        die(header("location:../account.php"));
                    } else {
                        $dbh = $this->get_db();
                        $edit_user_query = "UPDATE users SET username = :un, email = :em WHERE usr_id = :uid";
                        $query = $dbh->prepare($edit_user_query);
                        $query->bindValue('un', $this->username, PDO::PARAM_STR);
                        $query->bindValue('em', $this->email, PDO::PARAM_STR);
                        $query->bindValue('uid', $this->userid, PDO::PARAM_INT);
                        if ($query->execute()) {
                            $_SESSION['username'] = $this->username;
                            $_SESSION['edit_acc_msg'] = '<div class="h-auto alert alert-primary" role="alert">Uspešno ste promenili svoje podatke!</div>';
                            die(header("location:../account.php"));
                        }
                    }
                }
            } else {
                $_SESSION['edit_acc_msg'] = '<div class="alert alert-danger" role="alert">Greška! Uneli ste neispravnu email adresu!</div>';
                die(header("location:../account.php"));
            }
        } else {
            $this->pwd = htmlspecialchars(trim(filter_input(INPUT_POST, 'new_password', FILTER_SANITIZE_STRING)));
            $this->pwd = $this->pwd_hash($this->pwd);
            if (filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL)) {
                if ($this->email_check() === TRUE && $this->email != $_SESSION['email']) {
                    $_SESSION['edit_acc_msg'] = '<div class="alert alert-danger" role="alert">Greška! Ovo korisnik sa ovim emailom već postoji!</div>';
                    die(header("location:../account.php"));
                } else {
                    if ($this->username_check() === TRUE && $this->username != trim($_SESSION['username'])) {
                        $_SESSION['edit_acc_msg'] = '<div class="alert alert-danger" role="alert">Greška! Ovo korisnik sa korisničkim <i>imenom</i> ' . $this->username . ' već postoji!</div>';
                        die(header("location:../account.php"));
                    } else {
                        $dbh = $this->get_db();
                        $edit_user_query = "UPDATE users SET username = :un, pwd = :pwd , email = :em WHERE usr_id = :uid";
                        $query = $dbh->prepare($edit_user_query);
                        $query->bindValue('un', $this->username, PDO::PARAM_STR);
                        $query->bindValue('pwd', $this->pwd, PDO::PARAM_STR);
                        $query->bindValue('em', $this->email, PDO::PARAM_STR);
                        $query->bindValue('uid', $this->userid, PDO::PARAM_INT);
                        if ($query->execute()) {
                            $_SESSION['username'] = $this->username;
                            $_SESSION['edit_acc_msg'] = '<div class="h-auto alert alert-primary" role="alert">Uspešno ste promenili svoje podatke!</div>';
                            die(header("location:../account.php"));
                        }
                    }
                }
            } else {
                $_SESSION['edit_acc_msg'] = '<div class="alert alert-danger" role="alert">Greška! Uneli ste neispravnu email adresu!</div>';
                die(header("location:../account.php"));
            }
        }
    }

}
