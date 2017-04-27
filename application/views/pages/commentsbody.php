<?php
$title = $meme['Title'];
$selection = null;
include('header.php');

if ($this->session->logged_in === true) {
    array_push($scripts, '/assets/js/lib/offline.min.js');
    array_push($scripts, "/assets/js/min/voting.min.js");
    array_push($scripts, "/assets/js/min/comments.min.js");
}
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
            <p><?= lang('comments_comments') ?>: <a href="#comments"><span class="badge"><?= $meme['comments'] ?></span></a></p>
            <p><a href="#" role="button" class="btn-login" data-toggle="modal" data-target="<?= isset($username) ? '#reportmodal' : '#signuploginmodal' ?>" data-remote="false"><?= lang('report') ?></a></p>
          </div>

        </div>
      </div>
    </div>

    <!-- reportmodal  -->
    <div class="modal fade" id="reportmodal" role="dialog">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h3 class="modal-title"><?= lang('title_report') ?></h3>
          </div>
          <div class="modal-body">
            <form method="POST" action="<?php echo site_url("report/post_report"); ?>">
              <fieldset>
                <legend><?= lang('report_type') ?>:</legend>
                <div class="radio">
                  <label for="option1"><input id="option1" type="radio" name="type" value="1"><?= lang('report_type1') ?></label>
                </div>
                <div class="radio">
                  <label for="option2"><input id="option2" type="radio" name="type" value="2"><?= lang('report_type2') ?></label>
                </div>
                <div class="radio">
                  <label for="option3"><input id="option3" type="radio" name="type" value="3"><?= lang('report_type3') ?></label>
                </div>
                <div class="radio">
                  <label for="option4"><input id="option4" type="radio" name="type" value="4"><?= lang('report_type4') ?></label>
                </div>
                <div class="radio">
                  <label for="option5"><input id="option5" type="radio" name="type" value="0"><?= lang('report_other') ?></label>
                </div>
                <div class="form-group">
                  <label for="data"><?= lang('report_other') ?></label>
                  <input name="data" type="text" class="form-control" id="data" placeholder="<?= lang('report_other') ?>">
                </div>
                <input name="memeid" type="hidden" value="<?=$meme['Id']?>">
                <div class="form-group">
                  <button type="submit" class="btn btn-login btn-sm"><?= lang('report') ?></button>
                </div>
              </fieldset>
            </form>
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

    <div class="container-fluid" id="comments">
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
            <div class="sortingsection-userpage">
              <p><strong><?= lang('search_sortby') ?>: </strong></p>
              <a class="sort" href="<?= site_url(strtok($_SERVER['REQUEST_URI'], '?') . '?' . http_build_query(array_merge($_GET, array('sort' => 'top')))  . '#comments') ?>"><span class="label label-default"><?= lang('search_sortby_top') ?></span></a>
              <a class="sort" href="<?= site_url(strtok($_SERVER['REQUEST_URI'], '?') . '?' . http_build_query(array_merge($_GET, array('sort' => 'date')))  . '#comments') ?>"><span class="label label-default"><?= lang('search_sortby_date') ?></span></a>
            </div>
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
                  <?php if ($this->session->logged_in && ($_SESSION['user_id'] === $comment['User_Id'] || $_SESSION['user_type'] > 0)): ?>
                  <p id="deleteComment"><a href="<?php echo site_url('meme/delete_comment?id='.$comment['Id']);?>"><?= lang('comment_delete') ?></a></p>
                  <?php endif; ?>
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
