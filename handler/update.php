<?php
    require "../dbBroker.php";
    require "../model/rezervacija.php";
    require "../model/stolovi.php";

    if (isset($_POST['rezID']) && isset($_POST['stoUpdate'])  &&isset($_POST['datum1']) && isset($_POST['detalji1']) && isset($_POST['korisnik1'])) {

        $status = Rez::update($_POST['rezID'],$_POST['stoUpdate'], $_POST['datum1'], $_POST['detalji1'], $_POST['korisnik1'], $conn);
        if ($status) {
            echo 'Uspesno';
        } else {
            echo $status;
            echo 'Neuspesno';
        }
    }



?>