<?php
error_reporting(-1);
ini_set('display_errors', 'On');

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if ($_SESSION['login'] !== true)
{
  echo("Unauthorized Access");
  exit();
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
  </head>
  <body>
    <nav class="navbar navbar-default" role="navigation">
      <div class="container-fluid">
        <div class="navbar-header">
          <a class="navbar-brand" href="#">domain.com</a>
        </div>
        <p class="navbar-text navbar-justified">Webhosting administration</p>
        <p class="navbar-text navbar-right">
          Signed in as <a href="#" class="navbar-link"><?php echo($_SESSION['name'] . ' ' . $_SESSION['surname']); ?></a>
          &nbsp;&nbsp;
          <span class="badge">14</span>
          &nbsp;&nbsp;
          <a href="logout.php"><span class="glyphicon glyphicon-log-out" aria-hidden="true"></span></a>
          &nbsp;&nbsp;
        </p>
      </div>
    </nav>
    <div class="container">
      <div class="page-header">
        <h1>Webhosting administration <small>domain.com</small></h1>
      </div>
    </div>
    <div class="jumbotron">
      <div class="container">
        <div class="row">
          <div class="col-md-4 col-sm-6">
            <div class="thumbnail">
              <div class="caption">
                <h3>FTP accounts</h3>
                <p><small>manage FTP accounts, manage files & folders</small></p>
                <p><a href="#" class="btn btn-primary" role="button">Button</a> <a href="#" class="btn btn-default" role="button">Button</a></p>
              </div>
            </div>
          </div>
          <div class="col-md-4 col-sm-6">
            <div class="thumbnail">
              <div class="caption">
                <h3>Email boxes</h3>
                <p><small>setup email boxes, browse emails, set email notification</small></p>
                <p><a href="#" class="btn btn-primary" role="button">Button</a> <a href="#" class="btn btn-default" role="button">Button</a></p>
              </div>
            </div>
          </div>
          <div class="col-md-4 col-sm-6">
            <div class="thumbnail">
              <div class="caption">
                <h3>MySQL Database</h3>
                <p><small>manage MySQL databases, browse curent databases</small></p>
                <p><a href="#" class="btn btn-primary" role="button">Button</a> <a href="#" class="btn btn-default" role="button">Button</a></p>
              </div>
            </div>
          </div>
          <div class="col-md-4 col-sm-6">
            <div class="thumbnail">
              <div class="caption">
                <h3>DNS records</h3>
                <p><small>modify details on registered domain, browse DNS records</small></p>
                <p><a href="#" class="btn btn-primary" role="button">Button</a> <a href="#" class="btn btn-default" role="button">Button</a></p>
              </div>
            </div>
          </div>
          <div class="col-md-4 col-sm-6">
            <div class="thumbnail">
              <div class="caption">
                <h3>Stats</h3>
                <p><small>used space, visits counter, users informations</small></p>
                <p><a href="#" class="btn btn-primary" role="button">Button</a> <a href="#" class="btn btn-default" role="button">Button</a></p>
              </div>
            </div>
          </div>
          <div class="col-md-4 col-sm-6">
            <div class="thumbnail">
              <div class="caption">
                <h3>Account settings</h3>
                <p><small>change password, contact details, notifications</small></p>
                <p><a href="#" class="btn btn-primary" role="button">Button</a> <a href="#" class="btn btn-default" role="button">Button</a></p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>