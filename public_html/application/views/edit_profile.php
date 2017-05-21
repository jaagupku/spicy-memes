<?php
$title = lang('title_editprofile');
$selection = 'edit-profile';

include('templates/header.php');
array_push($scripts, '/assets/js/min/inittooltip.min.js');
?>

<div class="modal fade" id="confirmationmodal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><?= lang('modal_confirmation') ?></h4>
            </div>
            <div class="modal-body">
                <form method="POST" action="<?= site_url("users/delete"); ?>">
                    <div class="form-group">
                        <label for="usr"><?= lang('modal_enterusername') ?>:</label>
                        <input name="username" type="text" class="form-control" id="usr" placeholder="<?= lang('modal_username') ?>">
                    </div>
                    <button type="submit" class="btn btn-confirmdelete btn-sm"><?= lang('modal_deletemyaccount') ?></button>
                </form>
            </div>
        </div>
    </div>
</div>

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

        <hr>

        <div class="form-group">
          <label for="new_password"><?= lang('editprofile_newpassword') ?>:</label>
          <input name="new_password" type="password" class="form-control" id="new_password" placeholder="<?= lang('editprofile_newpassword') ?>">

          <label for="repeat_new_password"><?= lang('editprofile_repeatnewpassword') ?>:</label>
          <input name="repeat_new_password" type="password" class="form-control" id="repeat_new_password" placeholder="<?= lang('editprofile_repeatnewpassword') ?>">
        </div>

        <hr>

        <div class="form-group">
          <label for="email"><?= lang('editprofile_currentpassword') ?>:</label>
          <input name="current_password" type="password" class="form-control" id="current_password" placeholder="<?= lang('editprofile_currentpassword') ?>">
        </div>

        <div class="form-group">
          <button type="submit" class="btn button btn-edit btn-sm"><?= lang('editprofile_update') ?></button>
        </div>

        <hr>
      </form>

      <form action="<?= site_url("users/confirm/") ?>" onsubmit="return false">
        <div class="form-group">
          <button class="btn button btn-delete-account btn-sm" data-toggle="modal" data-target="#confirmationmodal" data-remote="false"><?=lang('editprofile_delete') ?></button>
        </div>
      </form>
    </div>
  </div>
</div>

<?php
include('templates/footer.php')
?>
