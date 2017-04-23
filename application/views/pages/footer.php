    <div class="container-fluid"><div class="break"></div></div>
    <div class="container-fluid"><div class="break"></div></div>

    <div class="container-fluid footer">
      <a class="link-about" href="<?php echo site_url("aboutus"); ?>"><?= lang('footer_about') ?></a>
      <div class="container-fluid"><div class="break"></div></div>
      <div class="site-map">
        <ul>
          <li><a href="<?php echo site_url("hot"); ?>"><?= lang('header_hot') ?></a></li>
          <li><a href="<?php echo site_url("top"); ?>"><?= lang('header_top') ?></a></li>
          <li><a href="<?php echo site_url("new"); ?>"><?= lang('header_new') ?></a></li>
          <li><a href="<?php echo site_url("meme/add"); ?>"><?= lang('footer_addsomepsice') ?></a></li>
          <?php  if (!isset($_SESSION['logged_in'])) : ?>
          <li><a href="<?php echo site_url("login"); ?>"><?= lang('footer_login') ?></a></li>
          <li><a href="<?php echo site_url("register"); ?>"><?= lang('footer_register') ?></a></li>
          <?php endif; ?>
          <li><a href="<?php echo site_url("aboutus"); ?>"><?= lang('footer_about') ?></a></li>
        </ul>
      </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="/assets/js/jquery-3.1.1.min.js">\x3C/script>')</script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script>$.fn.modal || document.write('<script src="/assets/bootstrap-3.3.7-dist/js/bootstrap.min.js">\x3C/script>')</script>

    <?php foreach ($scripts as $script) { ?>
    <script src="<?= $script ?>"></script>
    <?php } ?>
  </body>
</html>
