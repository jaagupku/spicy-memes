<?php
$title = 'Add spice';
$selection = 'addmeme';
include('header.php');
array_push($scripts, '/assets/js/inittooltip.js');
?>
    <div class="container-fluid col-xs-12 col-custom-frontpage col-centered">
    <h1>Add meme</h1>
    <?php if (isset($error)) echo $error ?>
    <?php echo form_open_multipart('upload');?>
      <input type="text" name="title" size="43" maxlength="255" placeholder="Title" data-toggle="tooltip" title="This is place for spicy title." data-placement="auto right" /><br />
      <input type="text" name="link" size="43" placeholder="https://www.youtube.com/watch?v=KMU0tzLwhbE" data-toggle="tooltip" title="Clean youtube link or image link." data-placement="auto right" /><br />
      <label>OR</label>
      <input type="file" name="userfile" data-toggle="tooltip" title="Only .jpg, .png and .gif under 4MB" data-placement="auto right" />
      <input type="submit"/>
    </form>
    </div>

<?php
include('footer.php')
?>
