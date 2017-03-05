<?php
$title = 'Register';
$selection = 'register';
include('header.php');
?>

<?php if (isset($error)) echo $error ?>
<form method="POST">
  <input type="text" name="username" placeholder="Username"/>
  <input type="password" name="password" placeholder="Password"/>
  <input type="email" name="email" placeholder="E-mail"/>
  <input type="submit"/>
</form>

<?php
include('footer.php')
?>
