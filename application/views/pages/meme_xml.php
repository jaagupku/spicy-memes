<?xml version="1.0" encoding="UTF-8"?>
<root>
	<memes>
	<?php foreach($memes as $row) : ?>
		<meme>
			<id><?php echo $row['Id']; ?></id>
			<link><?php echo site_url('/meme/'.$row['Id'])?></link>
			<title><?php echo $row['Title']; ?></title>
			<datatype><?php echo $row['Data_Type']; ?></datatype>
			<data><?php echo $row['Data']; ?></data>
      <points><?php echo $row['Points']; ?></points>
			<profile><?php echo site_url('/profile/'.$row['User_Name']) ?></profile>
      <uploader><?php echo $row['User_Name']; ?></uploader>
      <vote><?php echo $row['User_Vote']; ?></vote>
			<comments>1001</comments>
		</meme>
  <?php endforeach; ?>
  </memes>
</root>
