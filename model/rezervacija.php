<?php

class Rez {

    public $rezID;
    public $sto;
    public $datumRez;
    public $opis;
    public $korisnik;

    public function __construct($rezID = null, $sto = null, $datumRez = null, $opis = null, $korisnik=null)
    {
        $this->rezID = $rezID;
        $this->sto = $sto;
        $this->datumRez = $datumRez;
        $this->opis = $opis;
        $this->korisnik = $korisnik;
    }

    public static function getAll(mysqli $conn) //dobija konekciju sa bazom kao ulazni element
    {
        $q = "SELECT * FROM rezervacije";               //u varijablu q upisi sve kolone iz tabele rez
        return $conn->query($q);                //objektno orijentisan nacin za vracanje query-a kao rezultata
    }
    public static function deleteById($rezID, mysqli $conn) //ulazni element id koji cemo da obrisemo i konekcija sa bazom
    {
        $q = "DELETE FROM rezervacije WHERE rezID=$rezID"; //kveri za brisanje id-a iz tabele
        return $conn->query($q);                   //vracanje tabele (bez obrisanog id-a)
    }
    public static function deleteBySto($sto, mysqli $conn) //ulazni element id koji cemo da obrisemo i konekcija sa bazom
    {
        $q = "DELETE FROM rezervacije WHERE sto=$sto"; //kveri za brisanje id-a iz tabele
        return $conn->query($q);                   //vracanje tabele (bez obrisanog id-a)
    }
    public static function add($sto, $datumRez, $opis, $korisnik, mysqli $conn) // svi atributi objekta osim id-a, sam se generise
    {
        $q = "INSERT INTO rezervacije(sto, datumRez, opis, korisnik) values('$sto', '$datumRez','$opis','$korisnik')"; //kveri za ubacivanje u tabelu
        return $conn->query($q); //vraca tabelu sa ubacenim id-em (novom rezervacijom) 
    }

    public static function update($rezID, $sto, $datumRez, $opis, $korisnik, mysqli $conn)
    {
        $q = "UPDATE rezervacije SET sto=$sto, datumRez=$datumRez, opis=$opis, korisnik=$korisnik WHERE rezID=$rezID";
        return $conn->query($q); //vraca tabelu sa update-ovanim sadrzajem 
    }
    public static function getByID($rezID, mysqli $conn)
    {
        $q = "SELECT * FROM rezervacije WHERE rezID=$rezID";
        $myArray = array();
        if ($result = $conn->query($q)) {

            while ($row = $result->fetch_array(1)) {
                $myArray[] = $row;
            }
        }
        return $myArray;
    }
    public static function getBySto($sto, mysqli $conn)
    {
        $q = "SELECT * FROM rezervacije WHERE sto=$sto";
        $myArray = array();
        if ($result = $conn->query($q)) {

            while ($row = $result->fetch_array(1)) {
                $myArray[] = $row;
            }
        }
        return $myArray;
    }

}


?>