<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Testing Spicy Memes</title>
    <link rel="stylesheet" href="/css/grid.css">
    <link rel="stylesheet" href="/css/header.css">
    <link rel="stylesheet" href="/css/page.css">
  </head>
  <body>

    <div class="header section group">
      <div class="search_bar col span_1_of_3">
        <input type="text" class="searchbar">
        <div class="hottopnew">
          <a href="#" class="hot">HOT</a>
          <a href="#" class="top">TOP</a>
          <a href="#" class="new">NEW</a>
        </div>
      </div>
      <div class="logo col span_1_of_3">
        <h1>Spicy Memes</h1>
      </div>
      <div class="login_signup col span_1_of_3">
          <?php if (isset($username)) { ?>
            <a href="/index.php/profile/<?= $username ?>" class="button_login"><?= $username ?></a>
            <a href="/index.php/logout" class="button_signup">LOG OUT</a>
          <?php } else { ?>
            <a href="/index.php/register" class="button_signup">SIGN UP</a>
            <a href="/index.php/login" class="button_login">LOG IN</a>
          <?php } ?>
      </div>
    </div>
