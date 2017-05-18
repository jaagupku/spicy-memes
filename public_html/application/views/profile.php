<?php
$title = $target;
$selection = 'profile';
include('header.php');
if (isset($username)) {
  array_push($scripts, '/assets/js/min/facebook.min.js');
}
array_push($scripts, '/assets/js/min/profile.min.js');
?>
<!-- USER PAGE -->

    <div class="container-fluid"><div class="break"></div></div>

    <div class="container-fluid">
      <div class="row">
        <div class="col-xs-12 col-custom-userpage col-centered">

          <div class="user-profile-userpage">
              <img class="profile-pic-userpage" alt="Profile Image" src="https://res.cloudinary.com/spicy-memes/image/upload/t_profile/<?php echo $profile_image;?>"  />
              <h2><?php echo($target) ?></h2>
          </div>

          <br>

          <?php if(isset($_SESSION['logged_in']) && $target===$username) :?>
          <!-- THIS DIV ONLY VISIBLE TO THE OWNER WHO IS LOGGED IN -->
          <div class="user-data-userpage">
            <table class="table">
              <tbody>
                <tr>
                  <td><strong>E-MAIL: </strong></td>
                  <td><?php echo($email) ?></td>
                </tr>
              </tbody>
            </table>
          </div>

          <div class="edit-profile-pswd">
            <a href="<?= site_url('/edit_profile') ?>"><?= lang('profile_editprofile') ?></a>
          </div>

          <?php if(!$this->session->fb_linked) {
            echo '<div class="social-wrap">
                    <button id="facebook" onClick="logInWithFacebook()" type="button">' . lang('profile_linkwithfacebook') . '</button>
                </div>';
          } else {
            echo '<div class="social-wrap">
                    <button id="facebook" onClick="unLinkFacebook()" type="button">' . lang('profile_unlinkwithfacebook') . '</button>
                </div>';
          } ?>

          <!-- THIS DIV ONLY VISIBLE TO THE OWNER WHO IS LOGGED IN ENDS HERE -->
         <?php endif; ?>

        </div>
      </div>
    </div>

    <!-- UPLOADS DIV -->

    <div class="container-fluid"><div class="break"></div></div>

    <div class="container-fluid">
      <div class="row">
        <div class="col-xs-12 col-custom-userpage col-centered">
          <?php if (count($memes) == 0): ?>

          <p>
            <?= lang('profile_nouploads') ?>
          </p>

          <?php else: ?>

          <p>
              <?= vsprintf(lang('profile_upload_stats'), array($meme_count['total'], $meme_count['picture'], $meme_count['video'])) ?>
          </p>

          <h2><?= lang('profile_uploads') ?>: </h2>

          <div class="sortingsection-userpage">
            <p><strong><?= lang('profile_sortby') ?>: </strong></p>
            <a class="sort" data-sortby="top" href="<?= site_url("profile/$target/top") ?>"><span class="label label-default"><?= lang('profile_sortby_top') ?></span></a>
            <a class="sort" data-sortby="comments" href="<?= site_url("profile/$target/comments") ?>"><span class="label label-default"><?= lang('profile_sortby_comments') ?></span></a>
            <a class="sort" data-sortby="date" href="<?= site_url("profile/$target/date") ?>"><span class="label label-default"><?= lang('profile_sortby_date') ?></span></a>
          </div>

          <div class="container-fluid"><div class="break"></div></div>

          <!-- START LOADING HERE -->

          <div class="uploads-userpage">
            <table class="table">
              <thead>
                <tr>
                  <th><?= lang('profile_title_title') ?></th>
                  <th><?= lang('profile_title_spicelevel') ?></th>
                  <th><?= lang('profile_title_comments') ?></th>
                  <th><?= lang('profile_title_date') ?></th>
                </tr>
              </thead>
              <tbody>
                <?php foreach($memes as $meme): ?>

                <tr>
                  <td><a href="<?= site_url('meme/' . $meme['Id']) ?>"><?= $meme['Title'] ?></a></td>
                  <td><?= lang('profile_spicelevel') ?>: <?= $meme['Points'] ?></td>
                  <td><?= lang('profile_comments') ?>: <a href="<?= site_url('meme/' . $meme['Id']) ?>"><span class="badge"><?php echo $meme['comments'] ?></span></a></td>
                  <td><?= lang('profile_addedon') ?>: <?= $meme['Date'] ?></td>
                </tr>

                <?php endforeach ?>
              </tbody>
            </table>
          </div>

          <?php endif ?>

          <!-- END LOADING HERE -->

        </div>
      </div>
    </div>
    <script type='text/javascript'>
      var profile_spicelevel = "<?= lang('profile_spicelevel') ?>";
      var profile_comments = "<?= lang('profile_comments') ?>";
      var profile_addedon = "<?= lang('profile_addedon') ?>";
    </script>
<?php
include('footer.php');
?>
