  <?php foreach($memes as $row) : ?>

    <div class="container-fluid">
      <div class="break"></div>
    </div>

    <div class="container-fluid">
      <div class="row">
        <div class="col-xs-12 col-sm-7 col-md-6 col-lg-4 col-centered">

          <h2><a href="<?php echo site_url('/meme/'.$row['Id'])?>"><?php echo $row['Title']; ?></a></h2>

          <div class="embed-responsive embed-responsive-4by3">
            <?php echo $row['Data']; ?>
          </div>

          <p>Added by: <a href="<?php echo site_url('/profile/'.$row['User_Name']) ?>"><?php echo $row['User_Name'] ?></a> ; Points: <?php echo $row['Points']; ?></p>

        </div>
      </div>
    </div>

  <?php endforeach ?>
