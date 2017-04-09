<?php
$title = 'About us';
$selection =null;
include('header.php');
?>


    <div class="break"></div>

    <div class="container-fluid">
      <div class="row">
        <div class="col-xs-12 col-custom-about col-centered">
          <h2><?= lang('notreceive_didntworkout') ?></h2>
          <div class="break"></div>
          <h2><?= lang('notreceive_goto1') ?> <a href="<?php echo base_url(); ?>/aboutus"><?= lang('aboutus_aboutus') ?></a> <?= lang('notreceive_gototryagain2') ?>!</h2>
        </div>
      </div>
    </div>

    <div class="break"></div>

<?php
include('footer.php');
?>
