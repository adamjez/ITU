<?php
error_reporting(-1);
ini_set('display_errors', 'On');

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['login']) || $_SESSION['login'] !== true)
{
  header('Location: index.php');
}

include('functions.php');
if(!isset($_SESSION['active_domain']))
{
  $domain = getDefaultDomain($_SESSION['id']);

  if($domain == null)
    $_SESSION['domain']= 'NOT EXISTS';
  else {
    $_SESSION['domain'] = $domain['name'] . '.' . $domain['tld'];
  }
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
    <style type="text/css">
      .bs-sidebar .nav > .active > ul {
          display: block;
          margin-bottom: 8px;
      }
    </style>
  </head>
  <body>
    <nav class="navbar navbar-default" role="navigation">
      <div class="container-fluid">
        <div class="navbar-header">
          <a class="navbar-brand" href="#"><?php echo($_SESSION['domain']);?></a>
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
        <h1>Webhosting administration <small><?php echo($_SESSION['domain']);?></small></h1>
      </div>
    </div>
    <div class="jumbotron">
      <div class="container">
        <div class="col-xs-6 col-md-4">
          <ul class="nav nav-pills nav-stacked">
            <li role="presentation" 
              <?php if(isset($_GET['site']) and $_GET['site'] == 'ftp'): ?> class="active" <?php endif; ?>>
              <a href="manage.php?site=ftp">FTP</a>
            </li>
            <li role="presentation" 
              <?php if(isset($_GET['site']) and $_GET['site'] == 'email'): ?>class="active" <?php endif; ?>>
              <a href="manage.php?site=email">Email</a>
            </li>
            <li role="presentation" 
              <?php if(isset($_GET['site']) and $_GET['site'] == 'sql'): ?>class="active" <?php endif; ?>>
              <a href="manage.php?site=sql">MySQL</a>
            </li>
            <li role="presentation" 
              <?php if(isset($_GET['site']) and $_GET['site'] == 'dns'): ?>class="active" <?php endif; ?>>
              <a href="#">DNS</a>
            </li>
            <li role="presentation" 
              <?php if(isset($_GET['site']) and $_GET['site'] == 'stats'): ?>class="active" <?php endif; ?>>
              <a href="#">Stats</a>
            </li>
          </ul>
        </div>
        
        <?php
          if(!isset($_GET['site']) || !file_exists($_GET['site'] . ".php"))
            header('Location: dashboard.php');

          require($_GET['site'] . ".php");
        ?>

      </div>
    </div>
  </body>
</html>