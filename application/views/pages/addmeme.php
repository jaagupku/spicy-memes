    <h1>Add meme</h1>
    <form method="POST">
      <input type="text" name="title" placeholder="Title"/>
      <input type="text" name="title" placeholder="Title"/>
      <input type="submit"/>
    </form>

    <?php echo $cloudinary_js_auto_config ?>
    <script>$(function() {
  if($.fn.cloudinary_fileupload !== undefined) {
    $("input.cloudinary-fileupload[type=file]").cloudinary_fileupload();
  }
});</script>
    <script type="text/javascript" src="/assets/js/jquery.min.js"></script>
    <script type="text/javascript" src="/assets/js/jquery.ui.widget.js"></script>
    <script type="text/javascript" src="/assets/js/jquery.iframe-transport.js"></script>
    <script type="text/javascript" src="/assets/js/jquery.fileupload.js"></script>
    <script type="text/javascript" src="/assets/js/jquery.cloudinary.js"></script>
