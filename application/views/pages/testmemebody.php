    <h1>HOT MEMES</h1>
    <table>
      <?php foreach($memes as $row) : ?>
        <tr>
          <td><h2><a href="<?php echo site_url('/meme/'.$row['Id'])?>"><?php echo $row['Title']; ?></a></h2></td>
          <td><strong>Added by: <a href="<?php echo site_url('/profile/'.$row['User_Name']) ?>"><?php echo $row['User_Name'] ?></strong></td>
        </tr>
        <tr>
          <td><?php echo $row['Data']; ?></td>
          <td><strong>Points: <?php echo $row['Points']; ?></strong></td>
        </tr>
      <?php endforeach ?>
    </table>
