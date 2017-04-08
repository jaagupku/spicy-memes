<?php
$title = lang('title_addmeme');
$selection = 'addmeme';
include('header.php');
array_push($scripts, '/assets/js/inittooltip.js');
?>
    <div class="container-fluid col-xs-12 col-custom-frontpage col-centered">
    <h1><?= lang('addmeme_addmeme') ?></h1>
    <?php if (isset($error)) echo "<p>".$error."</p>" ?>
    <?php echo form_open_multipart('upload');?>
      <input type="text" name="title" size="43" maxlength="255" placeholder="<?= lang('addmeme_title_placeholder') ?>" data-toggle="tooltip" title="<?= lang('addmeme_title_tooltip') ?>" data-placement="auto right" /><br />
      <input type="text" name="link" size="43" placeholder="<?= lang('addmeme_link_placeholder') ?>" data-toggle="tooltip" title="<?= lang('addmeme_link_tooltip') ?>" data-placement="auto right" /><br />
      <label><?= lang('addmeme_or') ?></label>
      <input type="file" name="userfile" data-toggle="tooltip" title="<?= lang('addmeme_file_tooltip') ?>" data-placement="auto right" />
      <input type="submit" value="<?= lang('addmeme_submit') ?>"/>
    </form>
    </div>

<?php
include('footer.php')
?>
