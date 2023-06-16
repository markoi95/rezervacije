<?php
    require "../dbBroker.php";
    require "../model/rezervacija.php";
    require "../model/stolovi.php";

    if(isset($_POST['naziv'])) {
        $myArray = Stolovi::getByNaziv($_POST['naziv'], $conn);
        echo json_encode($myArray);
    }

    if(isset($_POST['rezID'])) {
        $myArray = Rez::getById($_POST['rezID'], $conn);
        echo json_encode($myArray);
    }

    if(isset($_POST['sto'])) {
        $myArray = Rez::getBySto($_POST['sto'], $conn);
        echo json_encode($myArray);
    }
?>