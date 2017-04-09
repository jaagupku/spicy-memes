<?php
$title = lang('title_editprofile');
$selection = 'edit-profile';

include('header.php');
array_push($scripts, '/assets/js/inittooltip.js');
?>

<div class="container-fluid">
  <div class="row">
    <div class="col-xs-12 col-custom-block col-centered">
      <form method="POST" action="<?php echo site_url("edit_profile"); ?>" enctype="multipart/form-data">
        <div class="form-group">
            <?= $error ?>
        </div>

        <div class="form-group">
          <label for="profile_image"><?= lang('editprofile_profileimage') ?>:</label>
          <img class="profile-pic-userpage" alt="<?= lang('editprofile_profileimage') ?>"
               src="https://res.cloudinary.com/spicy-memes/image/upload/t_profile/<?= $profile_image; ?>"/>
          <input type="file" name="userfile" data-toggle="tooltip" title="<?=lang('addmeme_file_tooltip')?>"
                 data-placement="auto right" id="profile_image"/>
        </div>

        <div class="form-group">
          <label for="usernameEditProfile"><?= lang('editprofile_username') ?>:</label>
          <input value="<?= $username ?>" name="username" type="text" class="form-control" id="usernameEditProfile"
                 placeholder="<?= lang('editprofile_username') ?>">
        </div>

        <div class="form-group">
          <label for="email"><?= lang('editprofile_email') ?>:</label>
          <input value="<?= $email ?>" name="email" type="email" class="form-control" id="email" placeholder="<?= lang('editprofile_email') ?>">
        </div>

        <div class="form-group">
          <label for="language"><?= lang('editprofile_language') ?>:</label>
          <select name="language" class="form-control" id="language">
            <option<?= $language == 'english' ? ' selected="selected"' : ''?> value="english">english</option>
            <option<?= $language == 'estonian' ? ' selected="selected"' : ''?> value="estonian">eesti</option>
          </select>
        </div>

        <button type="submit" class="btn btn-login btn-sm"><?= lang('editprofile_update') ?></button>
        <br><br>
      </form>
    </div>
  </div>
</div>

<?php
include('footer.php')
?>
