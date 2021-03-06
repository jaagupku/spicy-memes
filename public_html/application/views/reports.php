<?php
$title = lang('title_report');
$selection = 'report';
include('templates/header.php');
?>
<div class="container-fluid">
  <div class="row">
    <div class="col-xs-12 col-custom-block col-centered">
      <table class="table">
        <thead>
          <tr>
            <th><?= lang('report_id') ?></th>
            <th><?= lang('report_meme_title')?></th>
            <th><?= lang('report_type') ?></th>
            <th><?= lang('report_date') ?></th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          <?php foreach($reports as $row) : ?>
            <tr>
              <td><?= $row['Id'] ?></td>
              <td><a href="<?php echo site_url("meme/".$row['Meme_Id']); ?>"><?= $row['Meme_Title']?></a></td>
              <td><?php if($row['Type'] == 0) {echo lang('report_other').': '.$row['Data'];} else {echo lang('report_type'.$row['Type']);} ?></td>
              <td><?= $row['Date'] ?></td>
              <td><a href="<?php echo site_url('report/show_mercy?reportid='.$row['Id']); ?>"><span class="glyphicon glyphicon-ok"></span><?= lang('report_show_mercy') ?></a><br><a href="<?php echo site_url('report/delete_meme?reportid='.$row['Id']); ?>"><span class="glyphicon glyphicon-trash"></span><?= lang('report_remove_meme') ?></a></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
      <?php if($is_more) : ?>
      <a href="<?php echo site_url("report/view"."?amount=$amount&from=" . ($from+$amount)); ?>"><?= lang('report_load_more') ?></a>
      <?php endif;?>
    </div>
  </div>
</div>
<?php
include('templates/footer.php');
?>
