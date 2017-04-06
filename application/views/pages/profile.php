<?php
$title = $target;
$selection = 'profile';
include('header.php');
if (isset($username)) {
  array_push($scripts, '/assets/js/facebook.js');
}
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
            <a href="<?= site_url('/edit_profile') ?>">edit profile</a>
            <a href="#">change password</a>
          </div>

          <?php if(!$this->session->fb_linked) {
            echo '<div class="social-wrap">
                    <button id="facebook" onClick="logInWithFacebook()" type="button">Link with Facebook</button>
                </div>';
          } else {
            echo '<div class="social-wrap">
                    <button id="facebook" onClick="unLinkFacebook()" type="button">Unlink Facebook</button>
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
            I haven't uploaded anything yet.
          </p>

          <?php else: ?>

          <p>
            I have added total of <?php echo $meme_count['total'] ?> memes, which includes <?php echo $meme_count['picture'] ?> pictures and <?php echo $meme_count['video'] ?> videos.
          </p>

          <h2>UPLOADS: </h2>

          <div class="sortingsection-userpage">
            <p><strong>Sort by: </strong></p>
            <a href="<?= site_url("profile/$target/top") ?>"><span class="label label-default">top</span></a>
            <a href="<?= site_url("profile/$target/comments") ?>"><span class="label label-default">comments</span></a>
            <a href="<?= site_url("profile/$target/date") ?>"><span class="label label-default">date</span></a>
          </div>

          <div class="container-fluid"><div class="break"></div></div>

          <!-- START LOADING HERE -->

          <div class="uploads-userpage">
            <table class="table">
              <thead>
                <tr>
                  <th>TITLE</th>
                  <th>SPICE LEVEL</th>
                  <th>COMMENTS</th>
                  <th>DATE</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach($memes as $meme): ?>

                <tr>
                  <td><a href="<?= site_url('meme/' . $meme['Id']) ?>"><?= $meme['Title'] ?></a></td>
                  <td>Spice Level: <?= $meme['Points'] ?></td>
                  <td>Comments: <a href="<?= site_url('meme/' . $meme['Id']) ?>"><span class="badge"><?php echo $meme['comments'] ?></span></a></td>
                  <td>Added on: <?= $meme['Date'] ?></td>
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

<?php
include('footer.php');
?>
