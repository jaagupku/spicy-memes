<?php
include('header.php');

array_push($scripts, '/assets/js/script.js');
?>
<div id="memebody">
<?php
include('memecontainer.php')
?>

<div id="load-more">
</div>
</div>
<?php if($nextpage != FALSE) : ?>
<div class="container-fluid">
  <div class="row">
    <div class="col-xs-12 col-custom-frontpage col-centered">
        <a role="button" id="load-button" data-load-amount="<?php echo $amount; ?>" data-load-from="<?php echo $from; ?>" data-load-type="<?php echo $selection; ?>" class="btn btn-lg" href="<?php echo site_url($nextpage) ?>">LOAD MORE</a>
    </div>
  </div>
</div>
<?php else : ?>
<div class="container-fluid">
  <div class="row col-centered col-custom-frontpage">
    <p>End of page, no more memes.</p>
  </div>
</div>
<?php endif; ?>

<?php
include('footer.php')
?>
