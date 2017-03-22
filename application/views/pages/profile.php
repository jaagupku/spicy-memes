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
              <img class="profile-pic-userpage" alt="Profile Image" src="http://res.cloudinary.com/spicy-memes/image/upload/t_profile/<?php echo $profile_image;?>"  />
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
            <a href="#">edit profile</a>
            <a href="#">change password</a>
          </div>

          <?php if(!$this->session->fb_linked) {
            echo '<p><a href="#" onClick="logInWithFacebook()">LINK FB with the JavaScript SDK</a></p>';
          } else {
            echo '<p id="unlink"><a href="#" onClick="unLinkFacebook()" >Unlink fb</a></p>';
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

          <p>
          I have added total of <?php echo $meme_count['total'] ?> memes, which includes <?php echo $meme_count['picture'] ?> pictures and <?php echo $meme_count['video'] ?> videos.
          </p>
          <h2>UPLOADS: </h2>

          <div class="sortingsection-userpage">
            <p><strong>Sort by: </strong></p>
            <a href="#"><span class="label label-default">top</span></a>
            <a href="#"><span class="label label-default">comments</span></a>
            <a href="#"><span class="label label-default">date</span></a>
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
                <tr>
                  <td><a href="comments_page.html">Some Shitty Meme Title</a></td>
                  <td>Spice Level: 666</td>
                  <td>Comments: <a href="comments_page.html"><span class="badge">1001</span></a></td>
                  <td>Added on: 10.03.2017 2:25PM</td>
                </tr>
                <tr>
                  <td><a href="comments_page.html">Some Shitty Meme Title</a></td>
                  <td>Spice Level: 666</td>
                  <td>Comments: <a href="comments_page.html"><span class="badge">1001</span></a></td>
                  <td>Added on: 10.03.2017 2:25PM</td>
                </tr>
              </tbody>
            </table>
          </div>

          <!-- END LOADING HERE -->

        </div>
      </div>
    </div>

<?php
include('footer.php');
?>
