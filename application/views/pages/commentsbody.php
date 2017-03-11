<?php
$title = $meme['Title'];
$selection = null;
include('header.php');
?>



    <div class="container-fluid"><div class="break"></div></div>

    <div class="container-fluid">
      <div class="row">
        <div class="col-xs-12 col-custom-commentspage col-centered">

          <h2><?php echo $meme['Title'] ?></h2>

          <div class="meme">
            <?php if ($meme['Data_Type']=="P") {
               echo '<img alt="'.$row['Title'].'" src="http://res.cloudinary.com/spicy-memes/image/upload/t_meme/'.$meme['Data'].'" />';
            } else {
               echo "<div class=\"embed-responsive embed-responsive-16by9\">
               <iframe class=\"embed-responsive-item\" src=\"https://www.youtube.com/embed/{$meme['Data']}\" allowfullscreen></iframe>
                 </div>";
            }
            ?>
          </div>

          <div class="memedata">
            <p>Spice Level: <span class="badge"><?php echo $meme['Points']; ?></span></p>
            <p>Added by: <a href="<?php echo site_url('/profile/'.$meme['User_Name']) ?>"><?php echo $meme['User_Name'] ?></a></p>
            <p>Comments: <a href="#"><span class="badge">1001</span></a></p>
          </div>

        </div>
      </div>
    </div>


    <div class="container-fluid"><div class="break"></div></div>


    <div class="container-fluid">
      <div class="row">
        <div class="col-xs-12 col-custom-commentspage col-centered">
          <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in']===TRUE) : ?>
            <form method="POST">
              <div class="form-group insert-comments">
                <label for="">INSERT SPICY COMMENT HERE:</label>
                <textarea name="message" class="form-control" rows="4"></textarea>
              </div>
              <button type="submit" class="btn btn-default">Submit</button>
            </form>
          <?php endif; ?>
          <?php if ($comment_added) : ?>
            <h3>Comment successfully added.</h3>
          <?php endif; ?>

        </div>
      </div>
    </div>


    <!-- HERE STARTS COMMENT READING SECTION BODY -->


    <div class="container-fluid"><div class="break"></div></div>


    <div class="container-fluid">
      <div class="row">
        <div class="col-xs-12 col-custom-commentspage col-centered">

          <div class="form-group">
            <label for="">READ SPICY COMMENTS HERE:</label>
          </div>

          <!-- MUST START LOADING COMMENTS HERE -->


          <?php if(empty($comments)) : ?>
            <div class="container-fluid"><div class="break"></div></div>
            <p>It seems to be empty. No comments here.</p>
          <?php else : ?>
          <?php foreach($comments as $comment) : ?>
            <div class="container-fluid"><div class="break"></div></div>
            <div class="read-comments">
              <a href="<?php echo site_url('/profile/'.$comment['User_Name']) ?>"><div class="profile-pic-comments"><?php echo '<img alt="Profile Image" src="http://res.cloudinary.com/spicy-memes/image/upload/t_profile/'.$comment['ProfileImg_Id'].'" />' ?></div></a>
              <div class="comment">
                <a href="<?php echo site_url('/profile/'.$comment['User_Name']) ?>" class="user-comments"><?php echo $comment['User_Name'] ?></a>
                <br>
                <p><?php echo $comment['Message'] ?></p>
                <div class="comment-data">
                  <div class="updownvote-comments">
                    <span class="	glyphicon glyphicon-arrow-up"></span>
                    <span class="	glyphicon glyphicon-arrow-down"></span>
                  </div>
                  <p>Points: <span class="badge"><?php echo $comment['Points'] ?></span></p>
                </div>
              </div>
            </div>
          <?php endforeach ?>
          <?php endif; ?>


          <!-- COMMENTS LOADING ENDS HERE -->

        </div>
      </div>
    </div>

<?php
include('footer.php');
?>
