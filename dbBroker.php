<?php
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$host = "localhost:3308";
$db = "sistemDB";
$user = "root";
$pass = "";

$conn = new mysqli($host,$user,$pass,$db);


if ($conn->connect_errno){
    exit("Neuspesna konekcija: greska> ".$conn->connect_error.", err kod>".$conn->connect_errno);
}
?>  