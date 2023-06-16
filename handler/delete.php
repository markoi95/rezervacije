<?php
    require "../dbBroker.php";
    require "../model/rezervacija.php";
    require "../model/stolovi.php";

    if(isset($_POST['rezID'])){
    
        $status = Rez::deleteById($_POST['rezID'], $conn);
        if($status){
            echo 'radi';
        }else{
            echo 'ne radi';
        }
    }

    if(isset($_POST['stoID'])){
    
        $status = Stolovi::deleteById($_POST['stoID'], $conn);
        if($status){
            echo 'radi';
        }else{
            echo 'ne radi';
        }
    }
    if(isset($_POST['naziv'])){
    
        $status = Stolovi::deleteBySto($_POST['naziv'], $conn);
        if($status){
            echo 'radi';
        }else{
            echo 'ne radi';
        }
    }

    if(isset($_POST['sto'])){
    
        $status = Rez::deleteBySto($_POST['sto'], $conn);
        if($status){
            echo 'radi';
        }else{
            echo 'ne radi';
        }
    }


?>