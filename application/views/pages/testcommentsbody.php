

    <div class="container-fluid">
      <div class="break"></div>
    </div>

    <div class="container-fluid">
      <div class="row">
        <div class="col-xs-12 col-sm-7 col-md-6 col-lg-4">

          <h2><?php echo $meme['Title'] ?></h2>

          <div class="embed-responsive embed-responsive-4by3">
            <?php echo $meme['Data']; ?>
          </div>

          <p>Added by: <a href="<?php echo site_url('/profile/'.$meme['User_Name']) ?>"><?php echo $meme['User_Name'] ?></a> ; Points: <?php echo $meme['Points']; ?></p>

        </div>
      </div>
    </div>

    <div class="container-fluid">
      <div class="row">
        <div class="col-xs-12 col-sm-7 col-md-6 col-lg-4">


          <h2>Comments:</h2>
          <?php if (isset($username)) : ?>
            <form method="POST">
              <textarea name="message" rows="5" cols="60"> </textarea>
              <input type="submit"/>
            </form>
          <?php endif; ?>
          <?php if ($comment_added) : ?>
            <h3>Comment successfully added.</h3>
          <?php endif; ?>
          <table>
          <?php if(empty($comments)) : ?>
            <p>It seems to be empty. No comments here.</p>
          <?php else : ?>
          <?php foreach($comments as $comment) : ?>
            <tr>
              <td><a href="<?php echo site_url('/profile/'.$comment['User_Name']) ?>"><?php echo $comment['User_Name'] ?></a></td>
              <td>Points: <?php echo $comment['Points'] ?></td>
            </tr>
            <tr>
              <td><?php echo $comment['ProfileImg_Id'] ?></td>
              <td><?php echo $comment['Message'] ?></td>
            </tr>
          <?php endforeach ?>
        <?php endif; ?>


        </div>
      </div>
    </div>
