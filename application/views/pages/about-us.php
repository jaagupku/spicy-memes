<?php
$title = 'About us';
$selection ='aboutus';
include('header.php');

array_push($scripts, '/assets/js/googlemap.js');
array_push($scripts, 'https://maps.googleapis.com/maps/api/js?key=AIzaSyDuSD8hPdFABJxJjQeS9HtCNQs08neegNg&callback=initMap'); // async defer
?>

<div class="container-fluid"><div class="break"></div></div>

<div class="container-fluid">
  <div class="row">
    <div class="col-xs-12 col-custom-about col-centered">
      <h2>ABOUT US</h2>
      <p>Spicy Memes is a website founded by three students from University of Tartu. The idea was to create an ultimate scrolling simulator for the spiciest memes ever made. Our team includes: Jaagup Kuhi, Henri-Martin Jaakson ja Agu-Art Annuk. </p>
    </div>
  </div>
</div>

<div class="container-fluid"><div class="break"></div></div>

<div class="aboutus-location">
  <h2>OUR BASE LOCATION</h2>
  <div id="map"></div>
</div>

<div class="container-fluid"><div class="break"></div></div>



<?php

$private_key = openssl_pkey_get_private(
"-----BEGIN RSA PRIVATE KEY-----
MIICXAIBAAKBgQDyuO5rqXoY0Hks9ezyYNk3WBwBOTqbuvTBiIeSJmZk4WxGICV2
lNeWnHX5tZ9iZ9DRWAi2cr8KKMFAlltbByHOLBFO063tk0jYB/LMOFx596RAi3qq
FESKc+m7U+f6BOb2/CIzGNrDV+pyMFPzJlXZio0mgZIZ1w/Nj89qNUN2FwIDAQAB
AoGAdwHvfIAzKlmFIGNQEyMjPbyItpzdvJ91BDMx7ZnAWLQiR1vZooOmFOWP/qhr
hm9KdmpIk1Q9kPickFNoZYBgtOZ7Ah8sXmT9wmGf5CzWEj6fXS94tvXlYlRavQs1
lm6ar98yLJQ+y/RlOYTqPWrvQVi+wkRcVIildzUmBnxSBSECQQD58XoNZWawuuSc
EwkPuEDufm28v0S3e57AOt7uTVpMHM9l0s/WmR4efHsOaV7LL5P9COsLNCu/qdIv
+lUGmiRxAkEA+Jqo6lZonavrWQ3aNYm1VmnrARl3K+nIRnTb2wXeebkLwn59YP9m
LkpYmSidceO867E4oA2Jek6p/NmSLhNnBwJBAOXj9GYT6VMOY60mWQRLbfWu9dJQ
fqzhGFApFdlL7ozpRt2Z/C6fITPbPPgxdM4gUda/+CiS8NZWJYyZjNEIwBECQATM
b3A+hLxuYheQ9eJMqyxk1P1rcWpuk8gQX2IF5fpxgPGbIW5q350LIFSsfQWCwNXH
0PD98eZjeFKCHJk5FKcCQEu1ffs0bKpFELMqQFpoh2Pe8ITeO2USI7WfoYpkqoG3
tC6MqDd13VFYmOsqyxLxWFwsON2PINHu+zqcuMpxGAk=
-----END RSA PRIVATE KEY-----");   /*Selle key peaks enda omaga asendama*/


function getCurrentDate() {
    $dt = new DateTime("now", new DateTimeZone('Europe/Helsinki'));
	return $dt->format('Y-m-d\TH:i:s\+0200');

}

$fields = array(
        "VK_SERVICE"     => "1011",
        "VK_VERSION"     => "008",
        "VK_SND_ID"      => "uid100036",
        "VK_STAMP"       => "12345",
        "VK_AMOUNT"      => "5",
        "VK_CURR"        => "EUR",
        "VK_ACC"         => "EE871600161234567892",
        "VK_NAME"        => "Spicy Memes OÜ",
        "VK_REF"         => "1234561",
        "VK_LANG"        => "EST",
        "VK_MSG"         => "Donation For Spicy Memes OÜ",
        "VK_RETURN"      => "http://localhost/aboutus/received",
        "VK_CANCEL"      => "http://localhost/aboutus/notreceived",
        "VK_DATETIME"    => getCurrentDate(),
        "VK_ENCODING"    => "utf-8",
);

$data = str_pad (mb_strlen($fields["VK_SERVICE"], "UTF-8"), 3, "0", STR_PAD_LEFT) . $fields["VK_SERVICE"] .    /* 1011 */
        str_pad (mb_strlen($fields["VK_VERSION"], "UTF-8"), 3, "0", STR_PAD_LEFT) . $fields["VK_VERSION"] .    /* 008 */
        str_pad (mb_strlen($fields["VK_SND_ID"], "UTF-8"),  3, "0", STR_PAD_LEFT) . $fields["VK_SND_ID"] .     /* uid100036 */
        str_pad (mb_strlen($fields["VK_STAMP"], "UTF-8"),   3, "0", STR_PAD_LEFT) . $fields["VK_STAMP"] .      /* 12345 */
        str_pad (mb_strlen($fields["VK_AMOUNT"], "UTF-8"),  3, "0", STR_PAD_LEFT) . $fields["VK_AMOUNT"] .     /* 5 */
        str_pad (mb_strlen($fields["VK_CURR"], "UTF-8"),    3, "0", STR_PAD_LEFT) . $fields["VK_CURR"] .       /* EUR */
        str_pad (mb_strlen($fields["VK_ACC"], "UTF-8"),     3, "0", STR_PAD_LEFT) . $fields["VK_ACC"] .        /* EE871600161234567892 */
        str_pad (mb_strlen($fields["VK_NAME"], "UTF-8"),    3, "0", STR_PAD_LEFT) . $fields["VK_NAME"] .       /* Spicy Memes OÜ */
        str_pad (mb_strlen($fields["VK_REF"], "UTF-8"),     3, "0", STR_PAD_LEFT) . $fields["VK_REF"] .        /* 1234561 */
        str_pad (mb_strlen($fields["VK_MSG"], "UTF-8"),     3, "0", STR_PAD_LEFT) . $fields["VK_MSG"] .        /* Torso Tiger */
        str_pad (mb_strlen($fields["VK_RETURN"], "UTF-8"),  3, "0", STR_PAD_LEFT) . $fields["VK_RETURN"] .     /* http://localhost:8080/project/yiz7ecU8okN7t8pc?payment_action=success */
        str_pad (mb_strlen($fields["VK_CANCEL"], "UTF-8"),  3, "0", STR_PAD_LEFT) . $fields["VK_CANCEL"] .     /* http://localhost:8080/project/yiz7ecU8okN7t8pc?payment_action=cancel */
        str_pad (mb_strlen($fields["VK_DATETIME"], "UTF-8"), 3, "0", STR_PAD_LEFT) . $fields["VK_DATETIME"];    /* 2017-03-26T14:44:00+0300 */


openssl_sign ($data, $signature, $private_key, OPENSSL_ALGO_SHA1);

$fields["VK_MAC"] = base64_encode($signature);
?>



<div class="container-fluid">
  <div class="row">
    <div class="col-xs-12 col-custom-about col-centered">
      <h2>DONATIONS</h2>
      <p>To help us boost our creativity and make everything more spicy, we have included a big red donate button. So everyone who thinks we deserve some recognition, fill the form and hit that button. </p>
      <strong>NB! Donations cost 5 euros!</strongs>
    </div>
  </div>
  <div class="break"></div>
  <div class="row">
    <div class="col-xs-12 col-custom-about col-centered">
      <form method="post" action="http://localhost:8080/banklink/ipizza">
        <?php foreach($fields as $key => $val):?>
                    <input type="hidden" name="<?php echo $key; ?>" value="<?php echo htmlspecialchars($val); ?>" />
        <?php endforeach; ?>
        <div class="form-group">
          <label for="PANGALINK_NAME">YOUR NAME : </label>
          <input type="text" name="PANGALINK_NAME" id="PANGALINK_NAME" class="form-control" placeholder="Enter your name" required>
        </div>
        <div class="form-group">
          <label for="PANGALINK_ACCOUNT">YOUR BANK ACCOUNT : </label>
          <input type="text" id="PANGALINK_ACCOUNT" class="form-control" name="PANGALINK_ACCOUNT" placeholder="Enter your bank account" required>
        </div>
        <button type="submit" class="btn btn-lg donate-button">DONATE</button>
      </form>
    </div>
  </div>
</div>

<?php
include('footer.php');
?>
