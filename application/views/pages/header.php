<?php
$scripts = array();
if (!isset($username)) {
  array_push($scripts, '/assets/js/facebook.js');
}
?>
<!DOCTYPE html>
<!-- HEADER -->
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $title; ?> - Spicy Memes</title>
    <link href="/assets/bootstrap-3.3.7-dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="/assets/css/headerstyle.css" rel="stylesheet">
    <link href="/assets/css/footerstyle.css" rel="stylesheet">
    <link href="/assets/css/allpagesstyle.css" rel="stylesheet">
    <link href="/assets/css/commentspagestyle.css" rel="stylesheet">
    <link href="/assets/css/frontpagebodystyle.css" rel="stylesheet">
    <link href="/assets/css/userpagestyle.css" rel="stylesheet">
    <link href="/assets/css/aboutpagestyle.css" rel="stylesheet">
    <link href="/assets/css/font-awesome.min.css" rel="stylesheet">
  </head>
  <body>

    <nav class="navbar navbar-default navbar-fixed-top">
      <div class="container-fluid">

        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#burger-material">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="<?php echo site_url() ?>">SPICY MEMES</a>
        </div>


        <div class="collapse navbar-collapse" id="burger-material">

          <ul class="nav navbar-nav">
            <li <?php if($selection==='hot') {echo 'class="active"';} ?> ><a href="<?php echo site_url('hot') ?>" class="hot">HOT</a></li>
            <li <?php if($selection==='top') {echo 'class="active"';} ?> ><a href="<?php echo site_url('top') ?>" class="top">TOP</a></li>
            <li <?php if($selection==='new') {echo 'class="active"';} ?> ><a href="<?php echo site_url('new') ?>" class="new">NEW</a></li>
          </ul>

          <form class="navbar-form navbar-left">
            <div class="input-group">
              <label for="srch" class="hidden-label">Search: </label>
              <input type="search" class="form-control" placeholder="Search" id="srch">
              <div class="input-group-btn">
                <button class="btn btn-default" type="submit">
                  <span class="glyphicon glyphicon-search"></span>
                </button>
              </div>
            </div>
          </form>

          <ul class="nav navbar-nav navbar-right loginsignup">
            <?php if (isset($username)) { ?>
              <li <?php if($selection==='profile') {echo 'class="active"';} ?> ><a href="<?php echo site_url("profile/".$username) ?>" id="username"><span class="glyphicon glyphicon-user"></span> <?= $username ?></a></li>
              <li><a href="<?= site_url("logout") ?>" id="logout"><span class="glyphicon glyphicon-log-out"></span> LOG OUT</a></li>
            <?php } else { ?>
              <li><a href="<?= site_url("register") ?>" role="button" class="btn btn-signup btn-md" data-toggle="modal" data-target="#signuploginmodal" data-remote="false"><span class="glyphicon glyphicon-user"></span> SIGN UP</a></li>
              <li><a href="<?= site_url("login") ?>" role="button" class="btn btn-login btn-md" data-toggle="modal" data-target="#signuploginmodal" data-remote="false"><span class="glyphicon glyphicon-log-in"></span> LOG IN</a></li>
            <?php } ?>
          </ul>

        </div><!-- /.navbar-collapse -->
      </div><!-- /.container-fluid -->
    </nav>

   <div class="container-fluid"><div class="break"></div></div>
   <div class="container-fluid"><div class="break"></div></div>
   <?php if($selection !== 'addmeme') : ?>
    <!-- ADD SOME SPICE BODY  -->
    <div class="container-fluid">
      <div class="row">
        <div class="col-xs-12 col-lg-12 addsomespice">
            <a role="button" class="btn btn-lg" href="<?php echo site_url("meme/add"); ?>" <?php if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in']===FALSE) {echo 'data-toggle="modal" data-remote="false" data-target="#signuploginmodal"';} ?>>ADD SOME SPICE</a>
        </div>
      </div>
    </div>
   <?php endif; ?>

    <?php if (!isset($username) && $selection !== 'login' && $selection !== 'register'): ?>
    <!-- signuploginmodal  -->
    <div class="modal fade" id="signuploginmodal" role="dialog">
      <div class="modal-dialog">

        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">LOG IN</h4>
          </div>
          <div class="modal-body">
            <form method="POST" action="<?php echo site_url("login"); ?>">
              <div class="form-group">
                <label for="usr">Username:</label>
                <input name="username" type="text" class="form-control" id="usr" placeholder="Username">
              </div>
              <div class="form-group">
                <label for="pwd">Password:</label>
                <input name="password" type="password" class="form-control" id="pwd" placeholder="Password">
              </div>
              <button type="submit" class="btn btn-login btn-sm">LOG IN</button><br><br>
              <a href="#">Forgot password?</a>
              <div class="form-group">
                <p>OR</p>
                <div class="social-wrap">
                  <button id="facebook" onClick="logInWithFacebook()" type="button">Sign in with Facebook</button>
                </div>
              </div>
            </form>
          </div>
          <div class="modal-header">
            <h4 class="modal-title">SIGN UP</h4>
          </div>
          <div class="modal-body">
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
                <input name="email" type="email" class="form-control" id="email" placeholder="E-mail">
              </div>
              <button type="submit" class="btn btn-signup btn-sm">SIGN UP</button>
            </form>
          </div>
        </div>

      </div>
    </div>
    <?php endif ?>
