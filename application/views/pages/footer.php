    <div class="container-fluid"><div class="break"></div></div>
    <div class="container-fluid"><div class="break"></div></div>

    <div class="container-fluid footer">
      <a class="link-about" href="">ABOUT US</a>
      <div class="social-media">
        <a href="https://www.facebook.com/"><i id="social-fb" class="fa fa-facebook-square social"></i></a>
        <a href="https://twitter.com/"><i id="social-tw" class="fa fa-twitter-square social"></i></a>
        <a href="https://instagram.com/"><i id="social-ig" class="fa fa-instagram social"></i></a>
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
