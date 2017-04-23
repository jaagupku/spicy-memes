<?php
$scripts = array();
if (!isset($username)) {
  array_push($scripts, '/assets/js/facebook.js');
}
?>
<!DOCTYPE html>
<!-- HEADER -->
<html lang="<?= lang('lang_code') ?>">
  <head>
    <meta charset="utf-8">
    <meta name="description" content="Browse spiciest memes here.">
    <meta name="keywords" content="Spicy Memes, memes, spicymemes, veebirakendus, spice, meme, spicymemes.cs.ut.ee">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $title; ?> - <?= lang('title_spicymemes') ?></title>
    <link href="/assets/bootstrap-3.3.7-dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="/assets/css/merged.min.css" rel="stylesheet"/>
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
          <a class="navbar-brand" href="<?php echo site_url() ?>"><?= lang('header_spicymemes') ?></a>
        </div>

        <div class="collapse navbar-collapse" id="burger-material">

          <ul class="nav navbar-nav">
            <li <?php if($selection==='hot') {echo 'class="active"';} ?> ><a href="<?php echo site_url('hot') ?>" class="hot"><?= lang('header_hot') ?></a></li>
            <li <?php if($selection==='top') {echo 'class="active"';} ?> ><a href="<?php echo site_url('top') ?>" class="top"><?= lang('header_top') ?></a></li>
            <li <?php if($selection==='new') {echo 'class="active"';} ?> ><a href="<?php echo site_url('new') ?>" class="new"><?= lang('header_new') ?></a></li>
          </ul>

          <form class="navbar-form navbar-left" method="GET" action="/search">
            <div class="input-group">
              <label for="srch" class="hidden-label"><?= lang('header_search') ?>: </label>
              <input type="search" class="form-control" placeholder="<?= lang('header_search') ?>" id="srch" name="value">
              <div class="input-group-btn">
                <button class="btn btn-default" type="submit">
                  <span class="glyphicon glyphicon-search"></span>
                </button>
              </div>
            </div>
          </form>

          <ul class="nav navbar-nav navbar-right loginsignup">
            <?php if (isset($username)) { ?>
              <?php if (isset($_SESSION['user_type']) && $_SESSION['user_type'] > 0) : ?>
                <li <?php if($selection==='report') {echo 'class="active"';} ?>><a href="<?php echo site_url('report/view') ?>"><span class="glyphicon glyphicon-alert"></span> <?= lang('report') ?></a></li>
                <li <?php if($selection==='users') {echo 'class="active"';} ?>><a href="<?php echo site_url('admin/view_users') ?>"><span class="glyphicon glyphicon-eye-open"></span> <?= lang('users') ?></a></li>
              <?php endif; ?>
              <li <?php if($selection==='profile') {echo 'class="active"';} ?> ><a href="<?php echo site_url("profile/".$username) ?>" id="username"><span class="glyphicon glyphicon-user"></span> <?= $username ?></a></li>
              <li><a href="<?= site_url("logout") ?>" id="logout"><span class="glyphicon glyphicon-log-out"></span> <?= lang('header_logout') ?></a></li>
            <?php } else { ?>
              <li><a href="<?= site_url("login") ?>" role="button" class="btn-login" <?php if (!in_array($selection, array('login', 'register'))) echo 'data-toggle="modal" data-target="#signuploginmodal" data-remote="false"' ?>><span class="glyphicon glyphicon-log-in"></span> <?= lang('header_login') ?></a></li>
              <li><a href="<?= site_url("register") ?>" role="button" class="btn-signup" <?php if (!in_array($selection, array('login', 'register'))) echo 'data-toggle="modal" data-target="#signuploginmodal" data-remote="false"' ?>><span class="glyphicon glyphicon-user"></span> <?= lang('header_signup') ?></a></li>
            <?php } ?>
          </ul>

        </div><!-- /.navbar-collapse -->
      </div><!-- /.container-fluid -->
    </nav>

   <div class="container-fluid"><div class="break"></div></div>
   <div class="container-fluid"><div class="break"></div></div>


    <!-- ADD SOME SPICE BODY  -->
    <div class="container-fluid">
      <div class="row">
        <div class="changelanguage">
            <p>
                <a href="<?= site_url(strtok($_SERVER["REQUEST_URI"],'?') . '?' . http_build_query(array_merge($_GET, array('language' => 'english')))) ?>">ENG</a> |
                <a href="<?= site_url(strtok($_SERVER["REQUEST_URI"],'?') . '?' . http_build_query(array_merge($_GET, array('language' => 'estonian')))) ?>">EST</a>
            </p>
        </div>
        <?php if($selection !== 'addmeme') : ?>
        <div class="addsomespice">
            <a role="button" class="btn btn-lg addsomespice-button" href="<?php echo site_url("meme/add"); ?>" <?php if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in']===FALSE) {echo 'data-toggle="modal" data-remote="false" data-target="#signuploginmodal"';} ?>><?= lang('addsomespice') ?></a>
        </div>
       <?php endif; ?>
      </div>
    </div>

    <?php if (!isset($username) && $selection !== 'login' && $selection !== 'register'): ?>
    <!-- signuploginmodal  -->
    <div class="modal fade" id="signuploginmodal" role="dialog">
      <div class="modal-dialog">

        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title"><?= lang('modal_login') ?></h4>
          </div>
          <div class="modal-body">
            <form method="POST" action="<?php echo site_url("login"); ?>">
              <div class="form-group">
                <label for="usr"><?= lang('modal_username') ?>:</label>
                <input name="username" type="text" class="form-control" id="usr" placeholder="<?= lang('modal_username') ?>">
              </div>
              <div class="form-group">
                <label for="pwd"><?= lang('modal_password') ?>:</label>
                <input name="password" type="password" class="form-control" id="pwd" placeholder="<?= lang('modal_password') ?>">
              </div>
              <button type="submit" class="btn btn-login btn-sm"><?= lang('modal_login') ?></button><br><br>
              <a href="#"><?= lang('modal_forgotpassword') ?></a>
              <div class="form-group">
                <p><?= lang('modal_or') ?></p>
                <div class="social-wrap">
                  <button id="facebook" onClick="logInWithFacebook()" type="button"><?= lang('modal_signupwithfacebook') ?></button>
                </div>
              </div>
            </form>
          </div>
          <div class="modal-header">
            <h4 class="modal-title"><?= lang('modal_signup') ?></h4>
          </div>
          <div class="modal-body">
            <form method="POST" action="<?php echo site_url("register"); ?>">
              <div class="form-group">
                <label for="usr_choose"><?= lang('modal_chooseusername') ?>:</label>
                <input name="username" type="text" class="form-control" id="usr_choose" placeholder="<?= lang('modal_chooseusername_placeholder') ?>">
              </div>
              <div class="form-group">
                <label for="pwd_choose"><?= lang('modal_choosepassword') ?>:</label>
                <input name="password" type="password" class="form-control" id="pwd_choose" placeholder="<?= lang('modal_choosepassword_placeholder') ?>">
              </div>
              <div class="form-group">
                <label for="pwd_repeat"><?= lang('modal_repeatpassword') ?>:</label>
                <input name="password_rpt" type="password" class="form-control" id="pwd_repeat" placeholder="<?= lang('modal_repeatpassword') ?>">
              </div>
              <div class="form-group">
                <label for="email"><?= lang('modal_enteremail') ?>:</label>
                <input name="email" type="email" class="form-control" id="email" placeholder="<?= lang('modal_enteremail_placeholder') ?>">
              </div>
              <button type="submit" class="btn btn-signup btn-sm"><?= lang('modal_signup') ?></button>
            </form>
          </div>
        </div>

      </div>
    </div>
    <?php endif ?>
