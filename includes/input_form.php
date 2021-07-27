
<div class="row justify-content-center mt-4">

    <div class="col-lg-9">
    <?php
    include_once 'input_msgs.php';
    ?>
    </div>

    <div class="col-lg-9">
        <form action="" method="POST">

            <div class="mb-3">
                <label class="form-label" for="majstor">Ime majstora:</label>
                <input class="form-control" type="text" name="majstor" id="majstor">
            </div>

            <div class="mb-3">
                <label class="form-label" for="kontakt">Kontakt:</label>
                <input class="form-control" type="text" name="kontakt" id="kontakt">
            </div>

            <div class="mb-3">
                <label class="form-label" for="granitne_pl">Cena - granitne plocice:</label>
                <input class="form-control" type="text" name="granitne_pl" id="granitne_pl">
            </div>

            <div class="mb-3">
                <label class="form-label" for="keramicke_pl">Cena - keramicke :</label>
                <input class="form-control" type="text" name="keramicke_pl" id="keramicke_pl">
            </div>

            <div class="mb-3">
                <label class="form-label" for="cokne">Cena - cokne:</label>
                <input class="form-control" type="text" name="cokne" id="cokne">
            </div>

            <div class="mb-3">
                <label class="form-label" for="ravnajucipod">Cena - ravnajuci pod:</label>
                <input class="form-control" type="text" name="ravnajucipod" id="velikiformat">
            </div>

            <div class="mb-3">
                <label class="form-label" for="komentar">Komentar:</label>
                <textarea class="form-control" name="komentar" id="komentar"></textarea>
            </div>
            <div class="mb-3">
                <button class="btn btn-primary float-end col-12 mb-4" type="submit" name="snimi_ponudu">Snimi ponudu</button>
            </div>

        </form>
    </div>
</div>