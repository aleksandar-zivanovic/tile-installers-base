
function pretraga_majstora() {
    $(document).ready(function () {

        // ponistavanje pretrage
        $("#ponisti_pretragu").click(function () {
            $("#result_div").hide();
        });

        // pretraga majstora po imenu ili broju telefona
        $('#id_search').keyup(function () {
            var pojam = $('#id_search').val();
            if (pojam.length >= 2) {
                $.ajax({
                    url: 'includes/ajax_search_process.php?trazi_majstora=' + pojam,
                    cache: false,
                    success: function (response) {
                        $('#result_div').removeAttr('hidden');
                        $('#result_div').show();
                        $('#rezultat_pretrage').html(response);
                    }
                });
            }
        });

    });
}

function check_mail() {
    $(document).ready(function () {
        $('#email_id').keyup(function () {
            var email_check = $('#email_id').val();
            if (email_check.length >= 8) {
                $.ajax({
                    data: {'chkemail': email_check},
                    url: 'includes/ajax_user_reg_check.php',
                    context: this,
                    type: 'post',
                    success: function (resposne) {
                        if (resposne == "email postoji") {
                            $('#email_span').text("Korisnik sa ovim emailom postoji!");
                            $('#submit_btn').addClass('disabled');
                        } else {
                            $('#email_span').text('');
                            $('#submit_btn').removeClass('disabled');
                        }
                    }
                });
            }
        });
    });
}

function check_username() {
    $(document).ready(function () {
        $('#username_id').keyup(function () {
            var username_check = $('#username_id').val();
            if (username_check.length >= 3) {
                $.ajax({
                    url: 'includes/ajax_user_reg_check.php?check_username=' + username_check,
                    cache: false,
                    success: function (response) {
                        if (response == "korisnik postoji") {
                            $('#username_span').text("Korisničko ime je zauzeto!");
                            $('#submit_btn').addClass('disabled');
                        } else {
                            $('#username_span').text('');
                            $('#submit_btn').removeClass('disabled');
                        }
                    }
                });
            }
        });
    });
}