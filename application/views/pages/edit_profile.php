<?php
$title = lang('title_editprofile');
$selection = 'edit-profile';

include('header.php');
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
          <img class="profile-pic-userpage" alt="Profile Image"
               src="https://res.cloudinary.com/spicy-memes/image/upload/t_profile/<?= $profile_image; ?>"/>
          <input type="file" name="userfile" data-toggle="tooltip" title="Only .jpg, .png and .gif under 4MB"
                 data-placement="auto right" id="profile_image"/>
        </div>

        <div class="form-group">
          <label for="username"><?= lang('editprofile_username') ?>:</label>
          <input value="<?= $username ?>" name="username" type="text" class="form-control" id="username"
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
