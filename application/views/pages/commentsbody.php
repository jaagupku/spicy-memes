<?php
$title = $meme['Title'];
$selection = null;
include('header.php');

array_push($scripts, '/assets/js/offline.min.js');
array_push($scripts, "/assets/js/voting.js");
array_push($scripts, "/assets/js/comments.js");
?>

    <div class="container-fluid"><div class="break"></div></div>

    <div class="container-fluid">
      <div class="row">
        <div class="col-xs-12 col-custom-commentspage col-centered">

          <h2><?php echo $meme['Title'] ?></h2>

          <div class="meme">
            <?php if ($meme['Data_Type']=="P") {
               echo '<img alt="'.$meme['Title'].'" src="https://res.cloudinary.com/spicy-memes/image/upload/t_meme/'.$meme['Data'].'" />';
            } else {
               echo "<div class=\"embed-responsive embed-responsive-16by9\">
               <iframe class=\"embed-responsive-item\" src=\"https://www.youtube.com/embed/{$meme['Data']}\" allowfullscreen></iframe>
                 </div>";
            }
            ?>
          </div>

          <div class="memedata">
            <p><?= lang('comments_spicelevel') ?>: <span class="badge"><?php echo $meme['Points']; ?></span></p>
            <p><?= lang('comments_addedby') ?>: <a href="<?php echo site_url('/profile/'.$meme['User_Name']) ?>"><?php echo $meme['User_Name'] ?></a></p>
            <p><?= lang('comments_comments') ?>: <a href="#"><span class="badge"><?= $meme['comments'] ?></span></a></p>
          </div>

        </div>
      </div>
    </div>

    <div class="container-fluid"><div class="break"></div></div>

    <div class="container-fluid">
      <div class="row">
        <div id="commentForm" class="col-xs-12 col-custom-commentspage col-centered">
          <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in']===TRUE) : ?>
            <form method="POST">
              <div class="form-group insert-comments">
                <label for="message"><?= lang('comment_insertspicycommenthere') ?>:</label>
                <textarea id="comment" name="message" class="form-control" rows="4"></textarea>
              </div>
              <button id="submitComment" type="submit" class="btn btn-default" ><?= lang('comment_submit') ?></button>
            </form>
          <?php endif; ?>
          <?php if ($comment_added) : ?>
            <h3><?= lang('comment_commentsuccessfullyadded') ?></h3>
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
            <h3><?= lang('comment_readspicycommentshere') ?>:</h3>
          </div>

          <!-- MUST START LOADING COMMENTS HERE -->
          <?php if(empty($comments)) : ?>
            <div class="container-fluid"><div class="break"></div></div>
            <p><?= lang('comment_nocomments') ?></p>
          <?php else : ?>
          <?php foreach($comments as $comment) : ?>
            <div class="container-fluid"><div class="break"></div></div>
            <div class="read-comments" data-id="<?= $comment['Id'] ?>">
              <a href="<?php echo site_url('/profile/'.$comment['User_Name']) ?>"><?php echo '<img class="profile-pic-comments" alt="Profile Image" src="https://res.cloudinary.com/spicy-memes/image/upload/t_profile/'.$comment['ProfileImg_Id'].'" />' ?></a>
              <div class="comment">
                <a href="<?php echo site_url('/profile/'.$comment['User_Name']) ?>" class="user-comments"><?php echo $comment['User_Name'] ?></a>
                <br>
                <p><?php echo $comment['Message'] ?></p>
                <div class="comment-data">
                  <div class="updownvote-comments">
                    <span class="glyphicon glyphicon-arrow-up upvote<?php if (isset($comment['User_Vote']) && $comment['User_Vote'] == 1) echo(' active-vote') ?>"></span>
                    <span class="glyphicon glyphicon-arrow-down downvote<?php if (isset($comment['User_Vote']) && $comment['User_Vote'] == -1) echo(' active-vote') ?>"></span>
                  </div>
                  <p><?= lang('comment_points') ?>: <span class="badge points"><?php echo $comment['Points'] ?></span></p>
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
