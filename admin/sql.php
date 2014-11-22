<?php
if(!isset($_SESSION['domain']))
{
  exit();
}


$webhosting = getWebHosting($_SESSION['id']);

if(isset($_POST['addSubmit'])){
  require('db.php');
  $addError = false;


  $formNotComplete = false;
  if(!isset($_POST['addType']) || strlen(trim($_POST['addLogin'])) < 2 ||
    strlen(trim($_POST['addPassword'])) < 2 || strlen(trim($_POST['addName'])) < 2)
    $formNotComplete = true;

  if(!$formNotComplete)
  {
    $password = sha1((trim($_POST['addPassword'])));
    $login = trim($_POST['addLogin']); 
    $name = trim($_POST['addName']);
    $type = $_POST['addType'];
    $db_server = $name . ".sql.".$_SESSION['domain'];


    $addItemSuccess = addDatabase($webhosting, $name, $login, $password, $type, $db_server);
  }

  if((isset($addItemSuccess) &&!$addItemSuccess) || $formNotComplete) 
  {
    $POST_login = isset($_POST['addLogin']) ? $_POST['addLogin'] : "";
    $POST_type = isset($_POST['addType']) ? $_POST['addType'] : "";
    $POST_name = isset($_POST['addName']) ? $_POST['addName'] : "";
    $addError = true;
  }

}

if(isset($_POST['delSubmit'])){
  require('db.php');

  $name = ($_POST['delName']);

  $delItemSuccess = deleteDatabase($webhosting, $name);
}

?>

<div class="col-xs-12 col-sm-6 col-md-8">

<?php 
if (isset($addItemSuccess)) {
if ($addItemSuccess): ?>

<div>Databaze "<?php echo($name); ?>" byla uspesne pridana</div>

<?php else: ?>

<div>Databazi se nepodarilo pridat. Nejspise uz existuje databaze se stejnym nazvem</div>

<?php endif; } ?>

<?php 
if (isset($formNotComplete)) {
if ($formNotComplete): ?>

<div>Vsechna pole jsou povinna a musi obsahovat nejmene 2 znaky</div>

<?php endif; } ?>


<?php 
if (isset($delItemSuccess)) {
if ($delItemSuccess): ?>

<div>Databaze <?php echo($name); ?> byla uspesne odstranena</div>

<?php else: ?>

<div>Databazi <?php echo($name); ?> se nepodarilo odstranit, nejspise k tomu nemate dostatecne opravneni nebo neexistuje.</div>

<?php endif; } ?>

  <h2>New Database</h2>
  <div class="panel panel-default">
    <div class="panel-body">
      <form class="form-horizontal" role="form" method="post">
        <div class="form-group">
          <label for="inputName" class="col-sm-2 control-label">Name</label>
          <div class="col-sm-10">
            <input name="addName" type="text" class="form-control" id="inputName" placeholder="New database name"
            <?php if (isset($addError) and $addError) echo('value="'.$POST_name.'"'); ?> >
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label">Type</label>
          <div class="col-sm-10">
            <div class="btn-group input-group btn-group-justified" data-toggle="buttons">
              <label class="btn btn-primary <?php if (isset($addError) and $addError and $POST_type === "0") echo('active'); ?>  ">
                <input type="radio" name="addType" value="0" <?php if (isset($addError) and $addError and $POST_type === "0") echo('checked'); ?> />MySQL</label>
              <label class="btn btn-primary <?php if (isset($addError) and $addError and $POST_type === "1") echo('active'); ?>  ">
                <input type="radio" name="addType" value="1" <?php if (isset($addError) and $addError and $POST_type === "1") echo('checked'); ?> />PostgreSQL</label>
              <label class="btn btn-primary <?php if (isset($addError) and $addError and $POST_type === "2") echo('active'); ?>  ">
                <input type="radio" name="addType" value="2" <?php if (isset($addError) and $addError and $POST_type === "2") echo('checked'); ?> />MariaDB</label>
            </div>
          </div>
        </div>
        <div class="form-group">
          <label for="inputLogin" class="col-sm-2 control-label">Login</label>
          <div class="col-sm-10">
            <input name="addLogin" type="text" class="form-control" id="inputLogin" placeholder="Database login"
            <?php if (isset($addError) and $addError) echo('value="'.$POST_login.'"'); ?> >
          </div>
        </div>
        <div class="form-group">
          <label for="inputPassword" class="col-sm-2 control-label">Password</label>
          <div class="col-sm-10">
            <div class="input-group">
              <span class="input-group-addon glyphicon glyphicon-lock"></span>
              <input name="addPassword" type="password" class="form-control" id="inputPassword" placeholder="Password">
            </div>
          </div>
        </div>
        <div class="form-group">
          <div class="col-sm-offset-2 col-sm-10">
            <button name="addSubmit" type="submit" class="btn btn-success"><span class="glyphicon glyphicon-tasks"> Create database</span></button>
          </div>
        </div>
      </form>
    </div>
  </div>
  <h2>Manage existing databases</h2>
  <div class="panel panel-default">
    <div class="panel-body">
      <table class="table table-bordered">
        <tr>
          <td>Name</td>
          <td>Login</td>
          <td>Type</td>
          <td>Usage</td>
          <td></td>
          <td></td>
        </tr>
        <?php 
              $dbs = getDatabases($webhosting);

              foreach($dbs as $db)
              {
              ?>
        <tr>
          <td><strong><?php echo($db['name']); ?></strong></td>
          <td><?php echo($db['login']); ?></td>
          <td><?php echo($DbTypeDict[$db['type']]); ?></td>
          <td>
            <div class="progress">
              <div class="progress-bar" role="progressbar" aria-valuenow="95" aria-valuemin="0" aria-valuemax="100" style="width: 95%;">
                80 MB
              </div>
            </div>
          </td>
          <td>
            <button type="button" class="btn btn-info">
              <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Adminer
            </button>
          </td>
          <td>
            <form class="form-horizontal" role="form" method="post">
              <input name="delName" type="hidden" value="<?php echo($db['name']); ?>"/>
              <button name="delSubmit" type="submit" class="btn btn-danger">
                <span class="glyphicon glyphicon-remove" aria-hidden="true"></span> Delete
              </button>
            </form>
          </td>
        </tr>
        <?php
          }
          ?>
      </table>
    </div>
  </div>
</div>
