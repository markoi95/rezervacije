<?php
    require "../dbBroker.php";
    require "../model/rezervacija.php";
    require "../model/stolovi.php";

    if(isset($_POST['stoNaziv']) && isset($_POST['datum']) && isset($_POST['detalji']) && isset($_POST['korisnik'])){ //vrednosti iz modal Forme koje se salju POST-om kada se submit

        $status = Rez::add($_POST['stoNaziv'],$_POST['datum'],$_POST['detalji'], $_POST['korisnik'], $conn);
        if($status){
            print  'radi';
        }else{
            print  'ne radi';
        }
        
    }
    if(isset($_POST['naziv']) && isset($_POST['brMesta'])){ //vrednosti iz modal Forme koje se salju POST-om kada se submit

        $status = Stolovi::add($_POST['naziv'],$_POST['brMesta'], $conn);
        if($status){
            echo json_encode("radi");
        }else{
            echo 'ne radi';
        }
        
    }

?>