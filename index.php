<?php

require "dbBroker.php";
require "model/user.php";

session_start();
if (isset($_POST['username']) && isset($_POST['password'])) { //iz POST-a uzmi username i password
    $name = $_POST['username'];
    $pass = $_POST['password'];
    $user_id = 1;

    $korisnik = new User(null, $name, $pass);

    $rs = User::logIn($korisnik, $conn); //login funkcija iz klase User

    // if (!empty($resp) && $resp->num_rows >0) {
    if ($rs->num_rows == 1 ) {
      echo "Uspesno ste se prijavili";
      $_SESSION['loggeduser'] = "prijavljen";
      $_SESSION['user_id'] = $korisnik->id;
      $_SESSION['korisnik'] = $korisnik->username;
      header('Location: home.php');
      exit();
    } else {
        echo '<script type="text/javascript">alert("Pogresni podaci za login");
        window.location.href = "index.php";</script>';
      exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Почетна страница</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">

</head>
    <body id="pozadinaIndex">
    <div class="vh-100 d-flex justify-content-center align-items-center">
      <div class="container">
        <div class="row d-flex justify-content-center">
          <div class="col-12 col-md-8 col-lg-6">
            <div class="card">
              <div class="card-body p-5">
                <form class="mb-3 mt-md-4" method="POST" action="#">
                  <h2 class="fw-bold mb-2 text-uppercase text-center display-3" id="dobrodosli" >Dobrodošli</h2>
                  <p class="mb-2">Unesite Vaše korisničko ime i šifru:</p>
                  <div class="mb-3">
                    <label for="text" class="form-label">Korisnik</label>
                    <input type="text" class="form-control border-3 rounded-pill" name="username" placeholder="Korisnik" required>
                  </div>
                  <div class="mb-3">
                    <label for="password" class="form-label">Šifra</label>
                    <input type="password" class="form-control border-3 rounded-pill" name="password" placeholder="*******" required>
                  </div>
                  <!-- <p class="small"><a class="text-primary" href="forget-password.html">Forgot password?</a></p> -->
                  <div class="d-grid">
                    <button class="btn btn-outline-dark uloguj" type="submit">Prijavi se</button>
                  </div>
                </form>
                <!-- <div>
                  <p class="mb-0  text-center">Don't have an account? <a href="signup.html" class="text-primary fw-bold">Sign
                      Up</a></p>
                </div> -->
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.7.0.js" integrity="sha256-JlqSTELeR4TLqP0OG9dxM7yDPqX1ox/HfgiSLBj8+kM=" crossorigin="anonymous"></script>
</body>
</html>