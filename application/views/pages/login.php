<?php
$title = 'Log in';
$selection ='login';
include('header.php');
?>

<?php if (isset($error)) echo $error ?>
<form method="POST">
  <input type="text" name="username" placeholder="Username"/>
  <input type="password" name="password" placeholder="Password"/>
  <input type="submit"/>
</form>

<?php
include('footer.php');
?>
