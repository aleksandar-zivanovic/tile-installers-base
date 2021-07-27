<?php

class Majstor {

    public $id;
    public $ime;
    public $kontakt;
    public $granitne_pl;
    public $keramicke_pl;
    public $cokne;
    public $ravnajuci_sloj;
    public $komentar;
    public $created_at;
    public $edited_at;
    public $created_by;

    public function zapamti_majstora() {
        if (isset($_POST['snimi_ponudu'])) {

            if (!empty($_POST['majstor']) && !empty($_POST['kontakt']) && !empty($_POST['granitne_pl']) && !empty($_POST['keramicke_pl']) && !empty($_POST['cokne']) && !empty($_POST['ravnajucipod'])) {
                if (!ctype_digit(trim($_POST['kontakt']))) {
                    $_SESSION['novi_majstor_greska'] = '<div class="alert alert-danger" role="alert">Broj telefona mora da bude broj u formatu: <i>0631234567</i></div>';
                    die(header('location:index.php'));
                }

                // taking data from the form
                $this->ime = clean(filter_input(INPUT_POST, 'majstor', FILTER_SANITIZE_STRING));
                $this->kontakt = clean(filter_input(INPUT_POST, 'kontakt', FILTER_SANITIZE_STRING));
                $this->granitne_pl = clean(filter_input(INPUT_POST, 'granitne_pl', FILTER_SANITIZE_STRING));
                $this->keramicke_pl = clean(filter_input(INPUT_POST, 'keramicke_pl', FILTER_SANITIZE_STRING));
                $this->cokne = clean(filter_input(INPUT_POST, 'cokne', FILTER_SANITIZE_STRING));
                $this->ravnajuci_sloj = clean(filter_input(INPUT_POST, 'ravnajucipod', FILTER_SANITIZE_STRING));
                $this->komentar = clean(filter_input(INPUT_POST, 'komentar', FILTER_SANITIZE_STRING));
                $this->created_by = clean($_SESSION['user_id']);

                $db = new Db_conn();
                $dbh = $db->getDbh();

                $query_novi_majstor = "INSERT INTO majstori(ime_prezime, kontakt, cena_vf , cena_mf, cena_cokna, cena_ravnajucisloj, komentar, created_by, created_at ) VALUES (:ime, :kon, :cgr, :cke, :cco, :crs, :kom, :crb, CURRENT_TIMESTAMP)";
                $query = $dbh->prepare($query_novi_majstor);
                $query->bindValue(":ime", $this->ime, PDO::PARAM_STR);
                $query->bindValue(":kon", $this->kontakt, PDO::PARAM_STR);
                $query->bindValue(":cgr", $this->granitne_pl, PDO::PARAM_STR);
                $query->bindValue(":cke", $this->keramicke_pl, PDO::PARAM_STR);
                $query->bindValue(":cco", $this->cokne, PDO::PARAM_STR);
                $query->bindvalue(":crs", $this->ravnajuci_sloj, PDO::PARAM_STR);
                $query->bindvalue(":crb", $this->created_by, PDO::PARAM_INT);
                $query->bindvalue(":kom", $this->komentar, PDO::PARAM_STR);

                if ($query->execute()) {
                    $_SESSION['novi_majstor_succ'] = '<div class="h-auto alert alert-primary" role="alert">Uspesno ste se uneli novog majstora u bazu podataka!!!</div>';
                    header('location:index.php');
                } else {
                    $_SESSION['novi_majstor_fail'] = '<div class="alert alert-danger" role="alert">Greska prilikom unosa novog majstora!!! Molim Vas pokusajte ponovo.</div>';
                    header('location:index.php');
                }

//                $_SESSION['novi_majstor_greska'] = '<div class="alert alert-danger" role="alert">Doslo je do greske. Pokusajte ponovo!</div>';
            } else {
                $_SESSION['novi_majstor_greska'] = '<div class="alert alert-danger" role="alert">Niste popunili sva polja!!!</div>';
                header('location:index.php');
            }
        }
    }

    public function azuriraj_podatke_o_majstoru() {
        if (!empty($_POST['edt_ime']) && !empty($_POST['edt_cko']) && !empty($_POST['edt_cgp']) && !empty($_POST['edt_ckp']) && !empty($_POST['edt_cco']) && !empty($_POST['edt_crp'])) {

            if (!is_numeric(trim($_POST['edt_cko']))) {
                $_SESSION['edit_acc_msg'] = '<div class="alert alert-danger" role="alert">Broj telefona mora da bude broj u formatu: <i>0631234567</i></div>';
                $_SESSION['edited_id'] = $this->id;
                die(header('location:azuriraj_majstora.php'));
            }

            // taking data from the form
            $this->ime = clean(filter_input(INPUT_POST, 'edt_ime', FILTER_SANITIZE_STRING));
            $this->kontakt = clean(filter_input(INPUT_POST, 'edt_cko', FILTER_SANITIZE_STRING));
            $this->granitne_pl = clean(filter_input(INPUT_POST, 'edt_cgp', FILTER_SANITIZE_STRING));
            $this->keramicke_pl = clean(filter_input(INPUT_POST, 'edt_ckp', FILTER_SANITIZE_STRING));
            $this->cokne = clean(filter_input(INPUT_POST, 'edt_cco', FILTER_SANITIZE_STRING));
            $this->ravnajuci_sloj = clean(filter_input(INPUT_POST, 'edt_crp', FILTER_SANITIZE_STRING));
            $this->komentar = clean(filter_input(INPUT_POST, 'edt_komentar', FILTER_SANITIZE_STRING));

            $db = new Db_conn();
            $dbh = $db->getDbh();

            $query_azuriraj_majstora = "UPDATE majstori SET ime_prezime = :ime, kontakt = :kon, cena_vf = :cgr, cena_mf = :cke, cena_cokna = :cco, cena_ravnajucisloj = :crs, komentar = :kom, edited_at = CURRENT_TIMESTAMP WHERE id = " . $this->id;
            $query = $dbh->prepare($query_azuriraj_majstora);
            $query->bindValue(":ime", $this->ime, PDO::PARAM_STR);
            $query->bindValue(":kon", $this->kontakt, PDO::PARAM_STR);
            $query->bindValue(":cgr", $this->granitne_pl, PDO::PARAM_STR);
            $query->bindValue(":cke", $this->keramicke_pl, PDO::PARAM_STR);
            $query->bindValue(":cco", $this->cokne, PDO::PARAM_STR);
            $query->bindvalue(":crs", $this->ravnajuci_sloj, PDO::PARAM_STR);
            $query->bindvalue(":kom", $this->komentar, PDO::PARAM_STR);

            if ($query->execute()) {
                $_SESSION['edited_id'] = $this->id;
                $_SESSION['edit_acc_msg'] = '<div class="h-auto alert alert-primary" role="alert">Uspesno ste izmenili podatke o ovom majstoru!!!</div>';
                die(header('location:azuriraj_majstora.php'));
            } else {
                $_SESSION['edited_id'] = $this->id;
                $_SESSION['edit_acc_msg'] = '<div class="alert alert-danger" role="alert">Greska prilikom izmene podataka!!! Molim Vas pokusajte ponovo.</div>';
                die(header('location:azuriraj_majstora.php'));
            }
        } else {
            $_SESSION['edited_id'] = $this->id;
            $_SESSION['edit_acc_msg'] = '<div class="alert alert-danger" role="alert">Niste popunili sva polja!!!</div>';
            die(header('location:azuriraj_majstora.php'));
        }
    }

    public function get_db() {
        require_once 'db_conn.php';
        $db = new Db_conn();
        $dbh = $db->getDbh();
        return $dbh;
    }

    public function moja_lista_majstora() {
        $dbh = $this->get_db();

        $this->created_by = trim(htmlspecialchars($_SESSION['user_id']));
        $lista_query = "SELECT * FROM majstori WHERE created_by = :crb";
        $query_moja_lista = $dbh->prepare($lista_query);
        $query_moja_lista->bindValue(":crb", $this->created_by, PDO::PARAM_LOB);
        $query_moja_lista->execute();
        while ($result = $query_moja_lista->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr>";
            echo "<td>" . $result['ime_prezime'] . "</td>";
            echo "<td>" . $result['kontakt'] . "</td>";
            echo "<td>" . $result['cena_vf'] . "</td>";
            echo "<td>" . $result['cena_mf'] . "</td>";
            echo "<td>" . $result['cena_cokna'] . "</td>";
            echo "<td>" . $result['cena_ravnajucisloj'] . "</td>";
            echo "<td>" . $result['komentar'] . "</td>";
            ?>

            <td>
                <form action="azuriraj_majstora.php" method="POST">
                    <input type="hidden" name="majstor_id" value="<?php echo $result['id']; ?>">
                    <button type="submit" class="btn btn-danger mb-2 col-12" name="obrisi_majstora"><strong>Obriši</strong></button>
                    <button type="submit" class="btn btn-info text-white col-12" name="izmeni_majstora"><strong>Izmeni</strong></button>
                </form>
            </td>

            <?php
            echo "</tr>";
        }
    }

    public function ukupno_mojih_majstora() {
        $dbh = $this->get_db();

        $this->created_by = trim(htmlspecialchars($_SESSION['user_id']));
        $ukupno_query = "SELECT COUNT(*) FROM majstori WHERE created_by = :crb";
        $query_ukupno = $dbh->prepare($ukupno_query);
        $query_ukupno->bindValue(":crb", $this->created_by, PDO::PARAM_LOB);
        $query_ukupno->execute();
        return $query_ukupno->fetchColumn();
    }

    public function obrisi_majstora() {
        $dbh = $this->get_db();
        $obrisi_mastora_query = "DELETE FROM majstori WHERE id = :id";
        $query_om = $dbh->prepare($obrisi_mastora_query);
        $query_om->bindValue(':id', $this->id, PDO::PARAM_INT);
        if ($query_om->execute()) {
            $_SESSION['brisanje_majstora'] = '<div class="h-auto alert alert-primary alert-dismissible" role="alert">Uspešno ste obrisali odabranog majstora iz Vaše liste! <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
            die(header("location:lista_majstora.php"));
        }
    }

    public function majstor_details() {
        require_once 'db_conn.php';
        $db = new Db_conn();
        $dbh = $db->getDbh();

        $majstor_details_query = "SELECT * FROM majstori WHERE id = " . $this->id;
        $query = $dbh->prepare($majstor_details_query);
        $query->execute();
        $result = $query->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function ajax_pretraga($pojam) {
        require_once 'db_conn.php';
        $db = new Db_conn();
        $dbh = $db->getDbh();

        $majstor_details_query = "SELECT * FROM majstori WHERE ime_prezime LIKE '%" . $pojam . "%' OR kontakt LIKE '%" . $pojam . "%'";
        $query = $dbh->prepare($majstor_details_query);
        $query->execute();

        while ($result = $query->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr>";
            echo "<td>" . $result['ime_prezime'] . "</td>";
            echo "<td>" . $result['kontakt'] . "</td>";
            echo "<td>" . $result['cena_vf'] . "</td>";
            echo "<td>" . $result['cena_mf'] . "</td>";
            echo "<td>" . $result['cena_cokna'] . "</td>";
            echo "<td>" . $result['cena_ravnajucisloj'] . "</td>";
            echo "<td>" . $result['komentar'] . "</td>";
            echo "</tr>";
        }
    }

}

/* END of the CLASS */