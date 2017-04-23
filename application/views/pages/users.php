<?php
$title = lang('title_users');
$selection = 'users';
include('header.php');
?>
<div class="container-fluid">
  <div class="row">
    <div class="col-xs-12 col-custom-block col-centered">
      <table class="table">
        <thead>
          <tr>
            <th><?= lang('user_name') ?></th>
            <th><?= lang('user_email')?></th>
            <th><?= lang('user_create_date') ?></th>
            <th><?= lang('user_last_login_date') ?></th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          <?php foreach($users as $row) : ?>
            <tr>
              <td><a href="<?php echo site_url("profile/".$row['User_Name']); ?>"><?= $row['User_Name']?></a></td>
              <td><?= $row['Email'] ?></td>
              <td><?= $row['Creation_Date'] ?></td>
              <td><?= $row['Last_Login_Time'] ?></td>
              <td><a href="<?php echo site_url('admin/delete_user?userid='.$row['Id']); ?>"><span class="glyphicon glyphicon-trash"></span><?= lang('user_delete_user') ?></a></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
      <?php if($is_more) : ?>
      <a href="<?php echo site_url("admin/view_users"."?amount=$amount&from=" . ($from+$amount)); ?>"><?= lang('users_load_more') ?></a>
      <?php endif;?>
    </div>
  </div>
</div>
<?php
include('footer.php');
?>
