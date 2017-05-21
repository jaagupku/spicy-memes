<?php
$title = lang('title_signup');
$selection = 'register';
include('templates/header.php');
?>

<div class="container-fluid">
  <div class="row">
    <div class="col-xs-12 col-custom-block col-centered">
      <?php if (isset($error)) echo '<p class="validationError">'.$error."</p>" ?>
      <form method="POST" action="<?php echo site_url("register"); ?>">
        <div class="form-group">
          <label for="usr_choose"><?= lang('signup_chooseusername') ?>:</label>
          <input name="username" type="text" class="form-control" id="usr_choose" placeholder="<?= lang('signup_chooseusername_placeholder') ?>"  value="<?php if(isset($usernameform)) echo $usernameform; ?>">
        </div>
        <div class="form-group">
          <label for="pwd_choose"><?= lang('signup_choosepassword') ?>:</label>
          <input name="password" type="password" class="form-control" id="pwd_choose" placeholder="<?= lang('signup_choosepassword_placeholder') ?>">
        </div>
        <div class="form-group">
          <label for="pwd_repeat"><?= lang('signup_repeatpassword') ?>:</label>
          <input name="password_rpt" type="password" class="form-control" id="pwd_repeat" placeholder="<?= lang('signup_repeatpassword') ?>">
        </div>
        <div class="form-group">
          <label for="email"><?= lang('signup_enteremail') ?>:</label>
          <input name="email" type="email" class="form-control" id="email" placeholder="<?= lang('signup_enteremail_placeholder') ?>" value="<?php if(isset($email)) echo $email; ?>">
        </div>
        <?php if(isset($fbid)) echo "<input type=\"hidden\" name=\"facebookid\" value=\"$fbid\">"; ?>
        <button type="submit" class="btn btn-signup btn-sm button"><?= lang('signup_signup') ?></button>
      </form>
    </div>
  </div>
</div>
<?php
include('templates/footer.php');
?>
