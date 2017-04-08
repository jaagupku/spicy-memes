<?php
$title = lang('title_login');
$selection = 'login';
include('header.php');

array_push($scripts, '/assets/js/facebook.js');
?>

<div class="container-fluid">
  <div class="row">
    <div class="col-xs-12 col-custom-block col-centered">
      <?php if (isset($error)) echo "<p>".$error."</p>" ?>
      <form method="POST" action="<?php echo site_url("login"); ?>">
        <div class="form-group">
          <label for="usr"><?= lang('login_username') ?>:</label>
          <input name="username" type="text" class="form-control" id="usr" placeholder="<?= lang('login_username') ?>">
        </div>
        <div class="form-group">
          <label for="pwd"><?= lang('login_password') ?>:</label>
          <input name="password" type="password" class="form-control" id="pwd" placeholder="<?= lang('login_password') ?>">
        </div>
        <button type="submit" class="btn btn-login btn-sm"><?= lang('login_login') ?></button><br><br>
        <a href="#"><?= lang('login_forgotpassword') ?></a>
        <div class="form-group">
          <p><?= lang('login_or') ?></p>
          <div class="social-wrap">
            <button id="facebook" onClick="logInWithFacebook()" type="button"><?= lang('login_loginwithfacebook') ?></button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
<?php
include('footer.php');
?>
