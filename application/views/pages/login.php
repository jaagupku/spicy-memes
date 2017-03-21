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

<p><a href="#" onClick="logInWithFacebook()">Log In with Facebook</a></p>

<?php
include('footer.php');
?>
