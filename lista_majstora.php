<?php
ob_start();
session_start();

if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == TRUE) {

    require_once 'classes/db_conn.php';
    require_once 'classes/majstor.php';
    require_once 'includes/functions.php';
    include_once 'includes/header.php';
} else {
    $_SESSION['lgin_needed'] = '<div class="h-auto alert alert-warning alert-dismissible" role="alert">Da bi pristupili sajtu, morate prvo da se prijavite! <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
    die(header("location:login.php"));
}
?>

<?php include_once 'includes/navbar.php'; ?>

<?php
$majstor = new Majstor();
?>


<div class="row justify-content-center mt-4">

    <div class="col-lg-12">
        <?php
        msg_brisanje_majstora();
        ?>
        <table class="table table-striped">
            <tr class="table-dark">
                <th class="col-lg-1">Ime</th>
                <th class="col-lg-1">Kontakt</th>
                <th class="col-lg-1">Granitne</th>
                <th class="col-lg-1">Keramicke</th>
                <th class="col-lg-1">Cokna</th>
                <th class="col-lg-1">Ravnajuci</th>
                <th class="col-lg-3">Komentar</th>
                <th class="col-lg-1">Izmeni/Obriši</th>
            </tr>

            <!-- lista svih majstora -->
            <?php $majstor->moja_lista_majstora(); ?>

        </table>

    </div>
</div>
</body>
</html>