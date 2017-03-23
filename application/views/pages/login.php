<?php
$title = 'Log in';
$selection ='login';
include('header.php');

array_push($scripts, '/assets/js/facebook.js');
?>

<?php if (isset($error)) echo $error ?>
<form method="POST">
  <input type="text" name="username" placeholder="Username"/>
  <input type="password" name="password" placeholder="Password"/>
  <input type="submit"/>
</form>

<div class="social-wrap">
  <button id="facebook" onClick="logInWithFacebook()" type="button">Sign in with Facebook</button>
</div>

<?php
include('footer.php');
?>
