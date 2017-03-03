<h1>HOT MEMES</h1>
<table>
  <?php foreach($memes as $row) : ?>
    <tr>
      <td><h2><?php echo $row['Title']; ?></h2></td>
      <td><strong>Added by: <?php echo $row['User_Name']; ?></strong></td>
    </tr>
    <tr>
      <td><?php echo $row['Data']; ?></td>
      <td><strong>Points: <?php echo $row['Points']; ?></strong></td>
    </tr>
  <?php endforeach ?>
</table>
