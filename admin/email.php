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
  if(!isset($_POST['type']) || strlen(trim($_POST['alias'])) < 2 ||
    strlen(trim($_POST['password'])) < 2)
    $formNotComplete = true;

  if(!$formNotComplete)
  {
    $alias = ($_POST['alias']); $password = sha1(($_POST['password']));
    $type = ($_POST['type']);

    $addItemSuccess = addEmailAdress($webhosting, $alias, $password, $type);
  }

  if((isset($addItemSuccess) &&!$addItemSuccess) || $formNotComplete)
  {
    $POST_alias = isset($_POST['alias']) ? $_POST['alias'] : "";
    $POST_type = isset($_POST['type']) ? $_POST['type'] : "";
    $addError = true;
  }
}

if(isset($_POST['delSubmit'])){
  require('db.php');

  $alias = ($_POST['delAlias']);
  $type = ($_POST['type']);

  $delItemSuccess = deleteEmailAdress($webhosting, $alias);
}


if(isset($_POST['editSubmit'])){
  require('db.php');

  $old_alias = ($_POST['editOldAlias']);
  $alias = ($_POST['editAlias']); $password = sha1(($_POST['editPassword']));
  $type = ($_POST['editType']);

  $editItemSuccess = updateEmailAdress($webhosting, $old_alias, $alias, $password, $type);
}

?>

<div class="col-xs-12 col-sm-6 col-md-8" ng-controller="EmailController">
<?php 
if (isset($addItemSuccess)) {
if ($addItemSuccess): ?>

<div>Emailova adresa <?php echo($alias . "@" . $_SESSION['domain']); ?> byla uspesne pridana</div>

<?php else: ?>

<div>Emailova adresa  se nepodarila pridat, nejspise uz existuje stejny alias nebo heslo je kratsi nez 4 znaky</div>

<?php endif; } ?>

<?php 
if (isset($delItemSuccess)) {
if ($delItemSuccess): ?>

<div>Emailova adresa <?php echo($alias . "@" . $_SESSION['domain']); ?> byla uspesne odstranena</div>

<?php else: ?>

<div>Emailova adresu <?php echo($alias . "@" . $_SESSION['domain']); ?> se nepodarilo odstranit</div>

<?php endif; } ?>

<?php 
if (isset($formNotComplete)) {
if ($formNotComplete): ?>

<div>Vsechna pole jsou povinna a musi obsahovat nejmene 2 znaky</div>

<?php endif; } ?>

<?php 
if (isset($editItemSuccess)) {
if ($editItemSuccess): ?>

  <?php if ($old_alias == $alias): ?>
    <div>Emailova adresa <?php echo($alias . "@" . $_SESSION['domain']); ?> byla upravena</div>
  <?php else: ?>
    <div>Emailova adresa <?php echo($old_alias . "@" . $_SESSION['domain']); ?> byla zmenena na <?php echo($alias . "@" . $_SESSION['domain']); ?></div>
  <?php endif;  ?>
<?php else: ?>

<div>Emailovou adresu <?php echo($alias . "@" . $_SESSION['domain']); ?> se nepodarilo upravit</div>

<?php endif; } ?>
  <h2>New Mailbox</h2>
  <div class="panel panel-default">
    <div class="panel-body">
      <form class="form-horizontal" role="form" method="post">
        <div class="form-group">
          <label for="inputAddress" class="col-sm-2 control-label">Address</label>
          <div class="col-sm-10">
            <div class="input-group">
              <input name="alias" type="text" class="form-control" id="inputAddress" placeholder="Mailbox address"
              <?php if (isset($addError) and !$addError) echo('value="'.$POST_alias.'"'); ?> >
              <span class="input-group-addon">@<?php echo($_SESSION['domain']);?></span>
            </div>
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label">Type</label>
          <div class="col-sm-10">
            <div class="btn-group input-group btn-group-justified" data-toggle="buttons">
              <label class="btn btn-primary <?php if (isset($addItemSuccess) and !$addItemSuccess and $POST_type === "0") echo('active'); ?> ">
                <input type="radio" name="type" value="0" <?php if (isset($addError) and $addError and $POST_type === "0") echo('checked'); ?>/>POP3</label>
              <label class="btn btn-primary <?php if (isset($addItemSuccess) and !$addItemSuccess and $POST_type === "1") echo('active'); ?> ">
                <input type="radio" name="type" value="1" <?php if (isset($addError) and $addError and $POST_type === "1") echo('checked'); ?>/>IMAP</label>
              <label class="btn btn-primary <?php if (isset($addItemSuccess) and !$addItemSuccess and $POST_type === "2") echo('active'); ?> ">
                <input type="radio" name="type" value="2" <?php if (isset($addError) and $addError and $POST_type === "2") echo('checked'); ?>/>POP3 & IMAP</label>
            </div>
          </div>
        </div>
        <div class="form-group">
          <label for="inputPassword" class="col-sm-2 control-label">Password</label>
          <div class="col-sm-10">
            <div class="input-group">
              <span class="input-group-addon glyphicon glyphicon-lock"></span>
              <input name="password" type="password" class="form-control" id="inputPassword" placeholder="Password">
            </div>
          </div>
        </div>
        <div class="form-group">
          <div class="col-sm-offset-2 col-sm-10">
            <button name="addSubmit" type="submit" class="btn btn-success"><span class="glyphicon glyphicon-inbox"> Create mailbox</span></button>
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
          <td>Alias</td>
          <td>Type</td>
          <td>Usage</td>
          <td></td>
          <td></td>
        </tr>
        <?php 
          $emails = getEmailAdress($webhosting);

          foreach($emails as $email)
          {
              ?>
              <tr>
                <td><strong><?php echo($email['alias']); ?></strong></td>
                <td><?php echo($EmailTypeDict[$email['type']]); ?></td>
                <td>
                  <div class="progress">
                    <div class="progress-bar" role="progressbar" aria-valuenow="<?php echo($email['used']); ?>" 
                         aria-valuemin="0" aria-valuemax="<?php echo($email['size']); ?>" 
                         style="width: <?php echo($email['used'] * 100 / $email['size']); ?>%;">
                      <?php echo($email['used']); ?> MB
                    </div>
                  </div>
                </td>
                <td>
                  <button type="button" class="btn btn-warning" 
                    ng-click="mailbox.doClick('<?php echo($email['alias']); ?>', '<?php echo($email['type']); ?>')">
                    <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Edit
                  </button>
                </td>
                <td>
                  <form class="form-horizontal" role="form" method="post">
                    <input name="delAlias" type="hidden" value="<?php echo($email['alias']); ?>"/>
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
  <h2 ng-show="mailbox.edit" id="edit">Edit mailbox</h2>
  <div ng-show="mailbox.edit" class="panel panel-default">
    <div class="panel-body">
      <form class="form-horizontal" role="form" method="post">
        <input type="hidden" name="editOldAlias" value="{{mailbox.address}}"/>
          <div class="form-group">
          <label for="inputAddress" class="col-sm-2 control-label">Address</label>
          <div class="col-sm-10">
            <div class="input-group">
              <input name="editAlias" type="text" class="form-control" id="inputAddress" value="{{mailbox.address}}">
              <span class="input-group-addon">@<?php echo($_SESSION['domain']);?></span>
            </div>
          </div>
        </div>
        <div class="form-group">
          <label for="inputPath" class="col-sm-2 control-label">Type</label>
          <div class="col-sm-10">
            <div class="btn-group input-group btn-group-justified" data-toggle="buttons">
              <label class="btn btn-primary">
                <input type="radio" name="editType" value="0" />POP3</label>
              <label class="btn btn-primary">
                <input type="radio" name="editType" value="1" />IMAP</label>
              <label class="btn btn-primary">
                <input type="radio" name="editType" value="2" />POP3 & IMAP</label>
            </div>
          </div>
        </div>
        <div class="form-group">
          <label for="inputPassword" class="col-sm-2 control-label">Password</label>
          <div class="col-sm-10">
            <div class="input-group">
              <span class="input-group-addon glyphicon glyphicon-lock"></span>
              <input name="editPassword" type="password" class="form-control" id="inputPassword" placeholder="Password">
            </div>
          </div>
        </div>
        <div class="form-group">
          <div class="col-sm-offset-2 col-sm-10">
            <button name="editSubmit" type="submit" class="btn btn-success"><span class="glyphicon glyphicon-pencil"> Edit mailbox</span></button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
