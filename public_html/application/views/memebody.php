<?php
include('templates/header.php');

if ($selection === 'new') {
    array_push($scripts, '/assets/js/min/polling.min.js');
}

array_push($scripts, '/assets/js/min/voting.min.js');
array_push($scripts, '/assets/js/min/main.min.js');
?>
<div id="memebody">
  <?php foreach($memes as $row) : ?>

  <div class="container-fluid"><div class="break"></div></div>

  <div class="container-fluid">
    <div class="meme-container" data-id="<?= $row['Id'] ?>">
      <div class="col-xs-12 col-custom-frontpage col-centered">
        <div class="meme">
          <h2><a href="<?php echo site_url('/meme/'.$row['Id'])?>"><?php echo $row['Title']; ?></a></h2>
            <?php if ($row['Data_Type'] === 'P') : ?>
                <img alt="<?= $row['Title'] ?>" src="https://res.cloudinary.com/spicy-memes/image/upload/t_meme/<?= $row['Data'] ?>" />
            <?php else: ?>
                <div class="embed-responsive embed-responsive-16by9 video not-loaded-video" data-id="<?= $row['Data'] ?>">
                    <img class="preview-image" alt="<?= $row['Title'] ?>" src="https://img.youtube.com/vi/<?= $row['Data'] ?>/hqdefault.jpg"/>
                    <a title="https://www.youtube.com/watch?v=<?= $row['Data'] ?>" href="https://www.youtube.com/watch?v=<?= $row['Data'] ?>" class="play-button"></a>
                </div>
            <?php endif ?>
        </div>

        <div class="memedata">
          <p><?= lang('meme_spicelevel') ?>: <span class="points badge"><?php echo $row['Points']; ?></span></p>
          <p><?= lang('meme_addedby') ?>: <a href="<?php echo site_url('/profile/'.$row['User_Name']) ?>"><?php echo $row['User_Name'] ?></a></p>
          <p><?= lang('meme_comments') ?>: <a href="<?php echo site_url('/meme/'.$row['Id'].'#comments')?>"><span class="badge"><?php echo $row['comments'] ?></span></a></p>
        </div>

        <div class="updownvote-frontpage">
          <a role="button" class="btn btn-upvotes btn-md"><span class="	glyphicon glyphicon-arrow-up upvote<?php if (isset($row['User_Vote']) && $row['User_Vote'] == 1) echo(' active-vote') ?>"></span></a>
          <a role="button" class="btn btn-downvotes btn-md"><span class="	glyphicon glyphicon-arrow-down downvote<?php if (isset($row['User_Vote']) && $row['User_Vote'] == -1) echo(' active-vote') ?>"></span></a>
        </div>

      </div>
    </div>
  </div>
  <?php endforeach ?>

<div id="load-more">
</div>
</div>
<?php if($nextpage != FALSE) : ?>
<div class="container-fluid">
  <div class="row">
    <div class="col-xs-12 col-custom-frontpage col-centered">
        <a role="button" id="load-button"
           data-load-amount="<?php echo $amount; ?>"
           data-load-from="<?php echo $from; ?>"
           data-load-type="<?php echo $selection; ?>"
           data-text-loading="<?= lang('meme_loading') ?>"
           data-text-morespice="<?= lang('meme_morespice') ?>"
           data-text-reachedend="<?= lang('meme_reachedend') ?>"
           class="btn btn-lg"
           href="<?php echo site_url($nextpage) ?>">
            <?= lang('meme_loadmore') ?>
        </a>
    </div>
  </div>
</div>
<?php else : ?>
<div class="container-fluid">
  <div class="row col-centered col-custom-frontpage">
    <p><?= lang('meme_endofpage') ?></p>
  </div>
</div>
<?php endif; ?>

<?php
include('templates/footer.php')
?>
