<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Tvoj nalog</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">    

        <!--Bootstrap CSS-->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

        <!--Bootstrap JS-->
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>

        <!--jQuery 3.6.0-->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    </head>
    <body>

        <div class="container">
            <div class="row">
                <div class="col-md-10 col-lg-8 offset-md-1 offset-lg-2">

                    <?php
                    if (!empty($_SESSION['edit_acc_msg'])) {
                        echo $_SESSION['edit_acc_msg'];
                        unset($_SESSION['edit_acc_msg']);
                    }
                    ?>

                    <div class="login-form bg-light mt-4 p-4">
                        <form action="azuriraj_majstora.php" method="POST" class="row g-3">
                            <h4>Podaci o majstoru!</h4>
                            <div class="col-12">
                                <label>Ime i prezime majstora:</label>
                                <input type="hidden" name="majstor_id" class="form-control" value="<?php echo clean($result['id']); ?>">
                                <input type="text" name="edt_ime" class="form-control" value="<?php echo clean($result['ime_prezime']); ?>">
                            </div>
                            <div class="col-12">
                                <label>Kontakt telefon:</label>
                                <input type="text" name="edt_cko" class="form-control" value="<?php echo clean($result['kontakt']); ?>">
                            </div>
                            <div class="col-12">
                                <label>Cena - granitne pločice::</label>
                                <input type="text" name="edt_cgp" class="form-control" value="<?php echo clean($result['cena_vf']); ?>">
                            </div>
                            <div class="col-12">
                                <label>Cena - keramičke pločice:</label>
                                <input type="text" name="edt_ckp" class="form-control" value="<?php echo clean($result['cena_mf']); ?>">
                            </div>
                            <div class="col-12">
                                <label>Cena - cokne:</label>
                                <input type="text" name="edt_cco" class="form-control" value="<?php echo clean($result['cena_cokna']); ?>">
                            </div>
                            <div class="col-12">
                                <label>Cena - ravnajuci pod:</label>
                                <input type="text" name="edt_crp" class="form-control" value="<?php echo clean($result['cena_ravnajucisloj']); ?>">
                            </div>

                            <div class="col-12">
                                <label>Komentar:</label>
                                <textarea class="form-control" name="edt_komentar" id="komentar"><?php echo clean($result['komentar']); ?></textarea>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary col-12" name="edit_majstor_process">Promeni podatke o majstoru</button>
                                <a href="lista_majstora.php" class="mt-2 btn btn-warning col-12">Otkaži promene</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>