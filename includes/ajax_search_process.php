<?php
ob_start();
session_start();

if(isset($_GET['trazi_majstora'])){
    $trazeni_pojma = trim(htmlspecialchars(filter_input(INPUT_GET, 'trazi_majstora', FILTER_SANITIZE_STRING)));
    require_once '../classes/majstor.php';
    $majstor = new Majstor();
    $majstor->ajax_pretraga($trazeni_pojma);
    
}