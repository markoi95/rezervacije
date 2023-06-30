<?php

require "dbBroker.php";
require "model/rezervacija.php";
require "model/stolovi.php";
require "model/user.php";

session_start();
if (empty($_SESSION['loggeduser']) || $_SESSION['loggeduser'] == '') {
    header("Location: index.php");
    exit();
}

$resultRez = Rez::getAllPending($conn);    //varijabla za sve rezervacije, atr: rezID, sto, datumRez, opis; objekat,
if (!$resultRez) {                  //update funkcije da ne poziva rezervacije iz proslosti
    echo "Greska kod upita<br>";
    exit();
}

$resultSto = Stolovi::getAll($conn); //varijabla za sve stolove, atr: stoID, naziv, brMesta; objekat
if (!$resultSto) {
    echo "Greska kod upita<br>";
    exit();
}
$resultUser = User::getAll($conn); //varijabla za sve stolove, atr: stoID, naziv, brMesta; objekat
if (!$resultSto) {
    echo "Greska kod upita<br>";
    exit();
}

//funkcija za sortiranje #resultSto koja vraca niz objekata (atr: stoID, naziv, brMesta) sortiran po nazivu (num,abc);
//funkcija za sortiranje #resultRez koja vraca niz objekata (atr: rezID, sto, datumRez, opis, korisnik)
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Главна страница</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <button type="button" onclick="location.href='logout.php';"class="btn btn-warning float-end m-2 fw-bold">LOG OUT</button>
    <div class="container text-center">
        <h1 style="color:whitesmoke" class="display-1 fw-bold">Naslov 12345</h1>    
    </div>
    <div class="container-fluid">
        <div class="row ms-5 pt-3 justify-content-center">

            <div class="col-lg-9 border-4 rounded-5 text-center">
                <div class="row">
                    <?php
                        while ($redSto = $resultSto->fetch_array()) {
                    ?>
                    <div class="col-sm-3 mt-2 mb-2"> 
                            <!-- Button trigger modal -->
                                <button type="button" id="<?php echo $redSto["naziv"]?>" onClick="reply_stoID(this.id)" 
                                    class="btn btnStolovi fs-3 border border-5 rounded-5 fw-bold" data-bs-toggle="modal" data-bs-target="#dodajRezModal">
                                        <?php echo $redSto["naziv"];
                                        ?>
                                </button>
                    </div>
                    <?php } ?>
                </div>
            </div>

                <div class="col pt-3 ">
                    <div class="container">
                        <div class="d-grid gap-2 col mx-auto">
                            <div class="text-center">
                                <div class="btn-group-vertical" role="group" aria-label="Basic example">
                                    <label for="dugme" class="fs-3 fw-bold text-white ">Dodaj/obriši sto:</label>
                                    <button type="button" id="dugme" class="btn mb-1 btn-lg fs-3 fw-bold border border-4 rounded-1" 
                                        data-bs-toggle="modal" data-bs-target="#dodajStoModal"></button>
                                    <button type="button" id="dugmeBrisi" class="btn mb-1 btn-lg border border-4 rounded-5 mt-2" 
                                        data-bs-toggle="modal" data-bs-target="#ObrisiModal"></button>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                <!--  <div class="form-check">
                        <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios1" value="option1" checked>
                        <label class="form-check-label" for="exampleRadios1">
                            Default radio
                        </label>
                    </div> -->
                    
                </div>
        </div>
    </div>                           
    <!-- //zatvara container-fluid -->

        <div class="row ms-5 pt-3 justify-content-md-center">
            <div class="col-4">
                <button type="button" id="prikazi" onclick="prikaziRezervacije()" class="btn fs-5 fw-bold border border-1">САКРИЈ РЕЗЕРВАЦИЈЕ</button>
            </div>
        </div>

        <div class="row ms-5 pt-3" id="tabelaRezervacija">
            <div class="col">
                <div class="container" >   
                    <?php if(empty($resultRez)){ ?>
                        <div class="text-center fs-1 " ><?php echo "NEMA REZERVACIJA" ?></div>
                    <?php
                        }else{
                            ?>
                    <table class="table text-center table-bordered sortable">
                        <thead >
                            <tr>
                                <th scope="col">Сто</th>
                                <th scope="col">Датум</th>
                                <th scope="col">Опис</th>
                                <th scope="col">Корисник</th> 
                                <th scope="col">Акција</th>
                            </tr>
                    </thead>
                    
                    <?php
                       while ($redRez = $resultRez->fetch_array()) {
                    ?>
                        <tbody>
                            <tr>
                            <td><?php echo $redRez["sto"] ?></td>
                            <td><?php echo $redRez["datumRez"] ?></td>
                            <td><?php echo $redRez["opis"] ?></td>
                            <td><?php echo $redRez["korisnik"] ?></td>
                            <td>
                                <button type="button" onClick="obrisiRez(<?php echo $redRez["rezID"] ?>)"class="btn btn-danger fw-bold">ОБРИШИ</button>

                                <button type="button" class="btn btn-success fw-bold" onClick="reply_rezID(<?php echo $redRez["rezID"]?>)" 
                                    data-bs-toggle="modal" data-bs-target="#izmeniRezModal">ИЗМЕНИ</button>
                                    
    
                            </td>
                            </tr>
                            <?php
                                }
                            }
                            ?> 
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-3 pt-3 pe-3">
                <div class="bg-light">
                    <div class="form-group">
                        <label for="exampleFormControlSelect1">Filtriraj po korisniku:</label>
                        <select class="form-control" id="exampleFormControlSelect1">
                        <?php
                            foreach($resultUser as $redUser) {
                        ?>
                            <option><?php echo $redUser["name"]?></option>
                <?php
                    }
                ?>
                        </select>
                    </div
                    <div class="form-group">
                        <label for="exampleFormControlSelect1">Filtriraj po datumu rezervacije:</label>
                        <select class="form-control" id="exampleFormControlSelect1">
                        <?php
                            foreach($resultRez as $redRez) {
                        ?>
                            <option><?php echo $redRez["datumRez"]?></option>
                <?php
                    }
                ?>
                        </select>
                    </div
                </div>
            </div>
        </div>

    <!-- Modal za dodavanje rezervacije-->
    <div class="modal fade" id="dodajRezModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">

                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ZATVORI</button>
            </div>

            <div class="modal-body">
                <form action="#" method="post" id="dodajRez">
                <div class="row justify-content-center">
                    <div class="col">
                        <div class="form-group">
                            <input type="hidden" id="korisnik" value="<?php echo $_SESSION['korisnik'] ?>" class="form-control form-control-lg mb-3" name="korisnik">
                        </div>
                        <div class="form-group">
                            <input type="text" id="stoNaziv" value="X" class="form-control form-control-lg mb-3" name="stoNaziv" readonly> <!-- reply_stoID u js -->
                        </div>
                        
                        <div class="form-group">
                            <input class="form-control form-control-lg mb-3" type="date" name="datum" id="datepicker" min="<?php echo date('Y-m-d'); ?>" required> <!-- dodati restrikciju -->
                        </div>

                        <div class="form-group">
                            <input  class="form-control form-control-lg" type="text" name="detalji" placeholder="Unesi detalje" required>
                        </div>

                        <div class="form-group">
                            <button class="btn btn-secondary" type="submit" id="zakazi">POTVRDI</button>
                        </div>
                    </div>
                </div>
                </form>
            </div>
        </div>
        </div>
    </div>
    </div>

    <!-- Modal za dodavanje stola-->
    <div class="modal fade" id="dodajStoModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title display-5" >Unesi detalje:</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="#" method="post" id="dodajSto">
                    <div class="form-group">
                            <input  class="form-control form-control-lg mb-1" type="text" name="naziv" id="naziv" placeholder="Unesi naziv stola" required>
                            <span class="fs-3 fw-bold text-danger" id="upozorenje"></span>
                    </div>
                    <div class="form-group">
                            <input  class="form-control form-control-lg" type="text" name="brMesta" placeholder="Unesi broj mesta" required>
                    </div>
                </div>
                    <div class="modal-footer">
                        <div class="form-group">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ZATVORI</button>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-secondary" type="submit" id="dodajS">POTVRDI</button>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal za brisanje stola-->
    <div class="modal fade" id="ObrisiModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Izaberi sto za brisanje:</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <select name="stolovii" id="stolovii">
                    <?php
                        foreach ($resultSto as $redSto1){
                    ?>
                    <option value="<?php echo $redSto1["stoID"]?>"> <?php echo $redSto1["naziv"]?></option>
                    <?php } ?>
                    </select>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onClick="obrisiSto()" data-bs-dismiss="modal">OBRIŠI STO</button>
                </div>

            </div>
        </div>
    </div>

    <!-- Modal za menjanje rezervacije-->
    <div class="modal fade" id="izmeniRezModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ZATVORI</button>
            </div>

            <div class="modal-body">
                <form action="#" method="post" id="izmeniRez">
                <div class="row justify-content-center">
                    <div class="col">

                        <div class="form-group">
                            <input type="hidden" id="rezID" value="x" class="form-control form-control-lg mb-3" name="rezID">
                        </div>
                        <div class="form-group">
                            <input type="hidden" id="korisnik1" value="<?php echo $_SESSION['korisnik'] ?>" class="form-control form-control-lg mb-3" name="korisnik1">
                        </div>

                        <div class="form-group">
                            <select name="stoUpdate" id="stoUpdate">

                                <?php
                                    foreach ($resultSto as $redSto1){
                                ?>
                                    <option value="<?php echo $redSto1["naziv"]?>" name="naziv1">
                                        <?php echo $redSto1["naziv"]?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <input class="form-control form-control-lg mb-3" type="date" name="datum1" placeholder="Odaberi datum" required>
                        </div>
                        <div class="form-group">
                            <input  class="form-control form-control-lg" type="text" name="detalji1" placeholder="Unesi detalje" required>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-secondary" type="submit" id="zakazi" data-bs-dismiss="modal">POTVRDI</button>
                        </div>
                    </div>
                </div>
                </form>
            </div>

        </div>
        </div>
    </div>
    
    <script src="https://www.kryogenix.org/code/browser/sorttable/sorttable.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>                
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="js/main.js"></script>
    <!-- <script>
        function proveriNaziv(){
            var naziv = document.getElementById("naziv");
            const button1 = document.getElementById("dodajS");
            $.ajax({                
                    url: 'handler/get.php',
                    type:'POST',
                    dataType: 'JSON',
                    data:{
                        naziv: naziv.value
                    },
                    success: function(data) {
                        if(jQuery.isEmptyObject(data)){
                        document.getElementById("upozorenje").innerHTML = "";
                        button1.disabled = false;
                        console.log("prazan");
                        }else {
                            console.log(data);
                            document.getElementById("upozorenje").innerHTML = "STO VEĆ POSTOJI";
                            button1.disabled = true;
                        }
                    }
                });
            }
    </script> -->    
</body>
</html>