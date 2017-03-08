<?php
$title = $target;
$selection = 'profile';
include('header.php');
?>

Username: <?php echo($target) ?> </br>
Email: <?php echo($email) ?> </br>
I have added total of <?php echo $meme_count['total'] ?> memes, which includes <?php echo $meme_count['picture'] ?> pictures and <?php echo $meme_count['video'] ?> videos.

<?php
include('footer.php');
?>
