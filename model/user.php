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

}
?>