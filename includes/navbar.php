<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="index.php">Navbar</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="index.php">Home</a>
                </li>
                <?php
                if (!isset($_SESSION['user_id']) || $_SESSION['user_id'] != TRUE) {
                    ?>
                    <li class="nav-item">
                        <a class="nav-link" href="login.php">Log in</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="register.php">Register</a>
                    </li>
                <?php } else { ?>
                    <li class="nav-item">
                        <a class="nav-link" href="lista_majstora.php">Lista majstora 
                            <span class="badge bg-secondary">
                                <?php
                                require_once 'classes/majstor.php';
                                $majstor = new Majstor();
                                echo $majstor->ukupno_mojih_majstora();
                                ?>


                            </span></a>
                    </li>
                    <li class="nav-item">
                    <li class="nav-item">
                        <a class="nav-link" href="account.php">Tvoj nalog</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Logout</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Dobrodošli <?php echo $_SESSION['username']; ?></a>
                    </li>
                </ul>
                <form class="col-lg-4 col-md-12 col-sm-12">
                    <input id="id_search" class="form-control me-2" type="search" name="trazi_majstora" placeholder="Nadji majstora po imenu ili kontaktu" aria-label="Search">
                </form>
                <script>
    //                    $(document).ready(function () {
    //
    //                        // ponistavanje pretrage
    //                        $("#ponisti_pretragu").click(function () {
    //                            $("#result_div").hide();
    //                        });
    //
    //                        // pretraga majstora po imenu ili broju telefona
    //                        $('#id_search').keyup(function () {
    //                            var pojam = $('#id_search').val();
    //                            if (pojam.length >= 2) {
    //                                $.ajax({
    //                                    url: 'includes/ajax_search_process.php?trazi_majstora=' + pojam,
    //                                    cache: false,
    //                                    success: function (response) {
    //                                        $('#result_div').removeAttr('hidden');
    //                                        $('#result_div').show();
    //                                        $('#rezultat_pretrage').html(response);
    //                                    }
    //                                });
    //                            }
    //                        });
    //
    //                    });
                    pretraga_majstora();
                </script>
            <?php } ?>
        </div>
    </div>
</nav>

<div id="result_div" class="row mt-4" hidden>
    <div class="col-lg-12">
        <table class="table table-striped">
            <tr class="table-primary">
                <th class="col-lg-3">Ime</th>
                <th class="col-lg-2">Kontakt</th>
                <th class="col-lg-1">Granitne</th>
                <th class="col-lg-1">Keramicke</th>
                <th class="col-lg-1">Cokna</th>
                <th class="col-lg-1">Ravnajuci</th>
                <th class="col-lg-3">Komentar</th>
            </tr>
            <tbody id="rezultat_pretrage">

            </tbody>
        </table>
        <button id="ponisti_pretragu" class="btn btn-outline-warning col-lg-12 mb-4" type="button"><strong>Poništi pretragu</strong></button>
    </div>

</div>