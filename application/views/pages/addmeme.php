<?php
$title = 'Add spice';
$selection = 'addmeme';
include('header.php');
?>

    <h1>Add meme</h1>
    <?php if (isset($error)) echo $error ?>
    <?php echo form_open_multipart('upload');?>
      <input type="text" name="title" placeholder="Title" />
      <input type="text" name="link" placeholder="URL" />
      <label>OR</label>
      <input type="file" name="userfile" />
      <input type="submit"/>
    </form>

<?php
include('footer.php')
?>
