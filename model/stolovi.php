<?php

class Stolovi {

    public $stoID;
    public $naziv;
    public $brMesta;

    public function __construct($stoID = null, $naziv = null, $brMesta = null)
    {
        $this->stoID = $stoID;
        $this->naziv = $naziv;
        $this->brMesta = $brMesta;
    }

    public static function getAll(mysqli $conn) //dobija konekciju sa bazom kao ulazni element
    {
        $q = "SELECT * FROM stolovi";               //u varijablu q upisi sve kolone iz tabele 
        return $conn->query($q);                //objektno orijentisan nacin za vracanje query-a kao rezultata
    }
    public static function deleteById($stoID, mysqli $conn) //ulazni element id koji cemo da obrisemo i konekcija sa bazom
    {
        $q = "DELETE FROM stolovi WHERE stoID=$stoID"; //kveri za brisanje id-a iz tabele
        return $conn->query($q);                   //vracanje tabele (bez obrisanog id-a)
    }
    public static function add($naziv, $brMesta, mysqli $conn) // svi atributi objekta osim id-a, sam se generise
    {
        $q = "INSERT INTO stolovi(naziv, brMesta) values('$naziv', '$brMesta')"; //kveri za ubacivanje u tabelu
        return $conn->query($q); //vraca tabelu sa ubacenim id-em (novom rezervacijom) 
    }

    public function update(mysqli $conn)
    {
        $query = "UPDATE stolovi SET naziv=$this->naziv, brMesta=$this->brMesta WHERE id=$this->stoID";
        return $conn->query($query); //vraca tabelu sa update-ovanim sadrzajem 
    }

    public static function getByNaziv($naziv, mysqli $conn)
    {
        $q = "SELECT * FROM stolovi WHERE naziv=$naziv";
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