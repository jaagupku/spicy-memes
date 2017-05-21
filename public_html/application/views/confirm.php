<?php
$title = lang('title_editprofile');
$selection = 'confirm-deletion';

include('templates/header.php');
?>

    <div class="container-fluid">
        <div class="row">
            <div class="col-xs-12 col-custom-block col-centered">
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

<?php
include('templates/footer.php')
?>