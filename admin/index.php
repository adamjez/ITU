<?php
error_reporting(-1);
ini_set('display_errors', 'On');


if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$email = $password = $error = '';

if(isset($_POST['submit'])){
  require('db.php');
  $email = $_POST['email']; $password = sha1($_POST['password']);


  $_SESSION['POST'] = $email;
  $qz = "SELECT ID FROM CLIENT WHERE email='".$email."' AND password=UNHEX('".$password."')" ;
  $qz = str_replace("\'","",$qz);
  $result = mysqli_query($conn,$qz);


  if ($result->num_rows != 0){
    $row = $result->fetch_assoc();
    $_SESSION['login'] = true; 
    $_SESSION['name'] = $row[0]['name']; 
    $_SESSION['surname'] = $row[0]['surname']; 
    $_SESSION['id'] = $row[0]['id']; 

    header('LOCATION:dashboard.html'); die();
  }
  else {
    header('LOCATION:index.php'); die();
    $error = "Invalid combination of email and password";

  }
  $result->close();
}

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Webhosting administration</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <style>
      body {
        padding-bottom: 40px;
      }
      .form-signin {
        background-color: #eee;
        max-width: 330px;
        padding: 15px;
        margin: 0 auto;
      }
      .form-signin .form-signin-heading,
      .form-signin .checkbox {
        margin-bottom: 10px;
      }
      .form-signin .checkbox {
        font-weight: normal;
      }
      .form-signin .form-control {
        position: relative;
        height: auto;
        -webkit-box-sizing: border-box;
           -moz-box-sizing: border-box;
                box-sizing: border-box;
        padding: 10px;
        font-size: 16px;
      }
      .form-signin .form-control:focus {
        z-index: 2;
      }
      .form-signin input[type="email"] {
        margin-bottom: -1px;
        border-bottom-right-radius: 0;
        border-bottom-left-radius: 0;
      }
      .form-signin input[type="password"] {
        margin-bottom: 10px;
        border-top-left-radius: 0;
        border-top-right-radius: 0;
      }
    </style>
  </head>
  <body>
    <nav class="navbar navbar-default" role="navigation">
      <div class="container-fluid">
        <p class="navbar-text navbar-justified">Webhosting administration</p>
      </div>
    </nav>
    <div class="container">
      <div class="page-header">
        <h1>Webhosting administration <small>domain.com</small></h1>
      </div>
    </div>
    <?php if (isset($_SESSION['POST'])): ?>
    <div>ZADAL JSI SPATNY LOGIN!!!!</div>
    <?php endif; ?>
    <div class="jumbotron">
      <div class="container">
        <form class="form-signin" role="form" method="post">
          <h2 class="form-signin-heading">Please sign in</h2>
          <label for="inputEmail" class="sr-only">Email address</label>
          <input name="email" type="email" id="inputEmail" class="form-control" placeholder="Email address" required autofocus
          <?php if (isset($_SESSION['POST'])) echo('value="'.$_SESSION['POST'].'"'); ?> >
          <label for="inputPassword" class="sr-only">Password</label>
          <input name="password" type="password" id="inputPassword" class="form-control" placeholder="Password" required>
          <button name="submit" class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
        </form>
      </div>
    </div>
  </body>
</html>

<?php
unset($_SESSION['POST']);
?>