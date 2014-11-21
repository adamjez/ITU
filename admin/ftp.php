<?php
if(!isset($_SESSION['domain']))
{
  exit();
}

$webhosting = getWebHosting($_SESSION['id']);

if(isset($_POST['addSubmit'])){
  require('db.php');

  $pass = generatePassword();
  $password = sha1($pass);
  $login = trim($_POST['addLogin']); 

  $path = trim($_POST['addPath']);
  $mail = $_POST['addEmail'];
  $ftp_server = "ftp.".$_SESSION['domain'];

  if($path == "")
    $path = "\\";


  if(strlen($login) < 2 or !filter_var($mail, FILTER_VALIDATE_EMAIL))
    $addItemSuccess = false;
  else
    $addItemSuccess = addFtpAccount($webhosting, $login, $password, $path, $ftp_server);
  
  if(!$addItemSuccess) 
  {
    $POST_login = $login;
    $POST_path = $path;
    $Post_mail = $mail;
  }
  else
  {
    mail($mail,"Registrovani FTP uctu", "Byl vam vytvoren FTP ucet na serveru: " . $ftp_server . 
      " s loginem " . $login . " a s heslem " . $pass . " ");

  }
}

if(isset($_POST['delSubmit'])){
  require('db.php');

  $login = ($_POST['delLogin']);

  $delItemSuccess = deleteFtpAccount($webhosting, $login);
}

if(isset($_POST['acSubmit']) or isset($_POST['deSubmit'])){
  require('db.php');

  $login = ($_POST['changeLogin']);
  $status = isset($_POST['acSubmit']) ? 0 : 1;

  $changeItemSuccess = changeFtpAccount($webhosting, $login, $status);

}

?>
        <div class="col-xs-12 col-sm-6 col-md-8">

<?php 
if (isset($addItemSuccess)) {
if ($addItemSuccess): ?>

<div>Ftp ucet <?php echo($login); ?> byl uspesne pridana a heslo bylo zaslano na emailovou adresu <?php echo($mail); ?></div>

<?php else: ?>

<div>FTP ucet se nepodarilo pridat. Bud jste zadali kratky login nebo email neni validni nebo jiz stejny login existuje</div>

<?php endif; } ?>

<?php
if (isset($changeItemSuccess)) {
if ($changeItemSuccess): ?>

<div>Ftp ucet <?php echo($login); ?> byl uspesne zmenen na <?php echo($StatusDict[$status]); ?></div>

<?php else: ?>

<div>Nepodarilo se zmenit stav FTP uctu <?php echo($login); ?>. Nejspis zadany ucet neexistuje nebo k tomu nemate prava.</div>

<?php endif; } ?>

<?php 
if (isset($delItemSuccess)) {
if ($delItemSuccess): ?>

<div>FTP ucet <?php echo($login); ?> byl uspesne odstranen</div>

<?php else: ?>

<div>FTP ucet <?php echo($login); ?> se nepodarilo odstranit</div>

<?php endif; } ?>

          <h2>New FTP account</h2>
          <div class="panel panel-default">
  <div class="panel-body">
          <form class="form-horizontal" role="form" method="post">
            <div class="form-group">
              <label for="inputName" class="col-sm-2 control-label">Login name</label>
              <div class="col-sm-10">
                <input name="addLogin" type="text" class="form-control" id="inputName" placeholder="FTP account name"
                <?php if (isset($addItemSuccess) and !$addItemSuccess) echo('value="'.$POST_login.'"'); ?> >
              </div>
            </div>
            <div class="form-group">
              <label for="inputPath" class="col-sm-2 control-label">Path</label>
              <div class="col-sm-10">
                <input name="addPath" type="text" class="form-control" id="inputPath" placeholder="Path to folder"
                <?php if (isset($addItemSuccess) and !$addItemSuccess) echo('value="'.$POST_path.'"'); ?> >
              </div>
            </div>
            <div class="form-group">
              <label for="inputEmail" class="col-sm-2 control-label">Email</label>
              <div class="col-sm-10">
                <input name="addEmail" type="email" class="form-control" id="inputEmail" placeholder="Users email"
                <?php if (isset($addItemSuccess) and !$addItemSuccess) echo('value="'.$POST_mail.'"'); ?> >
              </div>
            </div>
            <div class="form-group">
              <div class="col-sm-offset-2 col-sm-10">
                <button name="addSubmit" type="submit" class="btn btn-success"><span class="glyphicon glyphicon-user"> Add account</span></button>
              </div>
            </div>
          </form>
          </div>
          </div>
          <h2>Manage Existing accounts</h2>
                    <div class="panel panel-default">
  <div class="panel-body">
            <table class="table table-bordered">
              <tr>
                <td>Login</td>
                <td>Status</td>
                <td></td>
                <td></td>
              </tr>
              <?php 
              $accounts = getFtpAccounts($webhosting);

              foreach($accounts as $account)
              {
              ?>

              <tr>
                <td><strong><?php echo($account['login']); ?></strong></td>
                <td><?php echo($StatusDict[$account['status']]); ?></td>
                <?php if ($account['status'] == 0):  ?>
                  <td>
                    <form class="form-horizontal" role="form" method="post">
                      <input name="changeLogin" type="hidden" value="<?php echo($account['login']); ?>"/>
                      <button name="deSubmit" type="submit" class="btn btn-warning"><span class="glyphicon  glyphicon-minus" aria-hidden="true"></span> Deactivate</button>
                    </form>
                  </td>
                <?php else: ?>
                  <td>
                    <form class="form-horizontal" role="form" method="post">
                      <input name="changeLogin" type="hidden" value="<?php echo($account['login']); ?>"/>
                      <button name="acSubmit" type="submit" class="btn btn-success"><span class="glyphicon  glyphicon-plus" aria-hidden="true"></span> Activate</button></td>
                    </form>
                <?php endif; ?>
                <td>
                  <form class="form-horizontal" role="form" method="post">
                    <input name="delLogin" type="hidden" value="<?php echo($account['login']); ?>"/>
                    <button name="delSubmit" type="submit" class="btn btn-danger"><span class="glyphicon  glyphicon-remove" aria-hidden="true"></span> Delete</button></td>
                  </form>
              </tr>

              <?php
              }
              ?>
            
            </table>
            </div>
            </div>
            <h2>FTP details</h2>
                      <div class="panel panel-default">
  <div class="panel-body">
              <table class="table">
                <tr>
                  <td><strong>Hostname</strong></td>
                  <td><?php echo($_SESSION['domain']);?></td>
                </tr>
                <tr>
                  <td><strong>FTP server</strong></td>
                  <td>ftp.<?php echo($_SESSION['domain']);?></td>
                </tr>
                <tr>
                  <td><strong>Port</strong></td>
                  <td>21</td>
                </tr>
              </table>
            </div>
            </div>
          <h2>WebFTP</h2>
                                <div class="panel panel-default">
  <div class="panel-body">
          <button type="button" class="btn btn-link"><span class="glyphicon glyphicon-new-window"> Go to WebFTP</span></button>
          </div>
          </div>
        </div>
