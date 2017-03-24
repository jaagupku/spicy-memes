<?php
$title = 'Log in';
$selection = 'login';
include('header.php');

array_push($scripts, '/assets/js/facebook.js');
?>

<?php if (isset($error)) echo $error ?>
<div class="container-fluid">
  <div class="row">
    <div class="col-xs-12 col-lg-12">
      <form method="POST" action="<?php echo site_url("login"); ?>">
        <div class="form-group">
          <label for="usr">Username:</label>
          <input name="username" type="text" class="form-control" id="usr" placeholder="Username">
        </div>
        <div class="form-group">
          <label for="pwd">Password:</label>
          <input name="password" type="password" class="form-control" id="pwd" placeholder="Password">
        </div>
        <div class="form-group">
          <p>OR</p>
          <div class="social-wrap">
            <button id="facebook" onClick="logInWithFacebook()" type="button">Sign in with Facebook</button>
          </div>
        </div>
        <a href="#">Forgot password?</a><br><br>
        <button type="submit" class="btn btn-login btn-sm">LOG IN</button>
      </form>
    </div>
  </div>
</div>
<?php
include('footer.php');
?>
