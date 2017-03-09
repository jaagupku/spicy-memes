<?php
$scripts = array();
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $title; ?> - Spicy Memes</title>
    <link href="/assets/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/assets/css/header-style.css">
    <link rel="stylesheet" href="/assets/css/page.css">
  </head>
  <body>

    <nav class="navbar navbar-default">
      <div class="container-fluid">

        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="<?php echo site_url() ?>">Spicy Memes</a>
        </div>

        <div class="collapse navbar-collapse" id="myNavbar">
          <ul class="nav navbar-nav navbar-left list-inline">
            <li <?php if($selection==='hot') {echo 'class="active"';} ?> ><a href="<?php echo site_url('hot') ?>" <?php if($selection==='hot') {echo 'id="selected"';} else {echo 'id="notselected"';} ?>>HOT</a></li>
            <li <?php if($selection==='top') {echo 'class="active"';} ?> ><a href="<?php echo site_url('top') ?>" <?php if($selection==='top') {echo 'id="selected"';} else {echo 'id="notselected"';} ?>>TOP</a></li>
            <li <?php if($selection==='new') {echo 'class="active"';} ?> ><a href="<?php echo site_url('new') ?>" <?php if($selection==='new') {echo 'id="selected"';} else {echo 'id="notselected"';} ?>>NEW</a></li>
          </ul>

          <form class="navbar-form navbar-left">
            <div class="input-group">
              <input type="text" class="form-control" placeholder="Search">
              <div class="input-group-btn">
                <button class="btn btn-default" type="submit">
                  <i class="glyphicon glyphicon-search"></i>
                </button>
              </div>
            </div>
          </form>

          <ul class="nav navbar-nav navbar-right">
            <?php if (isset($username)) { ?>
              <li <?php if($selection==='addspice') {echo 'class="active"';} ?> ><a href="/index.php/meme/add">Add Some Spice</a></li>
              <li <?php if($selection==='profile') {echo 'class="active"';} ?> ><a href="/index.php/profile/<?= $username ?>" id="username"><span class="glyphicon glyphicon-user"></span><?= $username ?></a></li>
              <li><a href="/index.php/logout" id="logout"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
            <?php } else { ?>
              <li <?php if($selection==='register') {echo 'class="active"';} ?> ><a href="/index.php/register" id="signup"><span class="glyphicon glyphicon-user"></span> Sign Up</a></li>
              <li <?php if($selection==='login') {echo 'class="active"';} ?> ><a href="/index.php/login" id="login"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
            <?php } ?>
          </ul>
        </div>

      </div>
    </nav>
