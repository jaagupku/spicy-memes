<?php
$title = 'Register';
$selection = 'register';
include('header.php');
?>

<?php if (isset($error)) echo $error ?>
<div class="container-fluid">
  <div class="row">
    <div class="col-xs-12 col-custom-block col-centered">
      <form method="POST" action="<?php echo site_url("register"); ?>">
        <div class="form-group">
          <label for="usr_choose">Choose username:</label>
          <input name="username" type="text" class="form-control" id="usr_choose" placeholder="Username">
        </div>
        <div class="form-group">
          <label for="pwd_choose">Choose password:</label>
          <input name="password" type="password" class="form-control" id="pwd_choose" placeholder="Password">
        </div>
        <div class="form-group">
          <label for="pwd_repeat">Repeat password:</label>
          <input name="password_rpt" type="password" class="form-control" id="pwd_repeat" placeholder="Repeat password">
        </div>
        <div class="form-group">
          <label for="email">Enter e-mail:</label>
          <input name="email" type="email" class="form-control" id="email" placeholder="E-mail" value="<?php if(isset($email)) echo $email; ?>">
        </div>
        <?php if(isset($fbid)) echo "<input type=\"hidden\" name=\"facebookid\" value=\"$fbid\">"; ?>
        <button type="submit" class="btn btn-signup btn-sm">SIGN UP</button>
      </form>
    </div>
  </div>
</div>
<?php
include('footer.php');
?>
