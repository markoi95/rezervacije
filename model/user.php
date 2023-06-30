<?php

class User{
    public $id;
    public $username;
    public $password;


public function __construct($id = null, $username=null, $password = null){
    $this->id = $id;
    $this->username = $username;
    $this->password = $password;
}

public static function logIn($user, mysqli $conn){
    $username = $user->username;
    $password = $user->password;
    
    $query = "SELECT * FROM user WHERE name='$user->username' and password='$user->password'";
    
    return $conn->query($query);
}
public static function getAll(mysqli $conn) //dobija konekciju sa bazom kao ulazni element
    {
        $q = "SELECT * FROM user";               //u varijablu q upisi sve kolone iz tabele 
        return $conn->query($q);                //objektno orijentisan nacin za vracanje query-a kao rezultata
    }

}
?>