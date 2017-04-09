<?php
$title = lang('title_aboutus');
$selection ='aboutus';
include('header.php');

array_push($scripts, '/assets/js/googlemap.js');
array_push($scripts, 'https://maps.googleapis.com/maps/api/js?key=AIzaSyDuSD8hPdFABJxJjQeS9HtCNQs08neegNg&callback=initMap'); // async defer
?>

<div class="container-fluid"><div class="break"></div></div>

<div class="container-fluid">
  <div class="row">
    <div class="col-xs-12 col-custom-about col-centered">
      <h2><?= lang('aboutus_aboutus') ?></h2>
      <p><?= lang('aboutus_aboutus_description') ?></p>
    </div>
  </div>
</div>

<div class="container-fluid"><div class="break"></div></div>

<div class="aboutus-location">
  <h2><?= lang('aboutus_ourbase') ?></h2>
  <div id="map"></div>
</div>

<div class="container-fluid"><div class="break"></div></div>

<?php

$private_key = openssl_pkey_get_private(
 "-----BEGIN RSA PRIVATE KEY-----
MIIEpAIBAAKCAQEAt5MFUTdzFUMUxVfl4GCiGKSiU2DXkXRPxQvOc8py0RBw+Yu/
Jo8osXM+c/svIF0gxgGRtkoN85G6M+zaliPzUUrEEpHE+qBG8nE1QQEyzB1vHKz2
1u4VJXeIMAnJ07KnrL4DgtkQfrn8agMl7i7x2IxVBFLrJpsBpPcjjAf+2bVTDEyv
4Nfyj/q/NHwRtv0o1vTcyg3JX+eSsJpUDy4fj/3QSkOIdKxLXeMEMvK1+Zj1oLAL
4riPLdGgEpfI8LGOm/4rQuESVSLBcSVWQ3eYhiHvXSIKeTjw/aA/Uk40xCbipsRX
JNx5EXl0zoKVg+pdYo6i5HIl9nMCcfl6AU0F/QIDAQABAoIBAGwGCtn4/DKlz8I0
8COyGZDQyGiyEwgX3p0ATpOarSfTOffOwUQKeBK70yNiyx+LTa7W24zeVQlgVqcZ
mKNDMnpCudCHkNc+m6Es9v5ymxa7t1ezfGmLnkv24+AI0ohNmBexlNVZsDgyb5Ne
mOJpI42fPqQVuyRzkGsntvY++jvXVUuppaHy//UmFuLMVJFyueasmUUkx//vWAxx
hfQdOmYM4gTY9skYPckRH/rkxbvkVDNuSF+B4KNMlF2wqZtZi0+4I8fxiFXk8Rr+
MeyqXqMOJR1oUIH13a4fSyIeo2rW+xBswM+7aM2uq9NBUjxbxoIUmBm6p9TEGvff
RLroo40CgYEA4sXCgeHXALSKvXWsaXUycPs9vVowhqUL0IeNHOmcE8bJfAbdFnPU
1517jhg5005xLtN/B1wVjYx2Aa2UMS4gq07S2OYGkf0sg0o1A6naIIzki/J87+Rf
Jj5gLz1fC/ODxOr31G+Bong6M6brlqAVxKTOz14RGGKVPzBOuAL2d3sCgYEAzzv1
fWyWrpXSsHEu6zeo/Mrv+pcg6mlLFIjUYILtmkB/IklXZ93P2+HQhCuk/JskzVQT
SWeaDPDGctcGIhy0TfzpPFY4TZeX4a7mMzWOccwbxz5ztA2yF3UhAFHwtY3BVxq4
CXdVTGsdkAQq78wE9Nb68A9mDfJQboi2p+5UwucCgYBW309+FhgZSxCDN9sOozjp
kzW5nh1M11lJT0Q9uThzUwnIm5CCk2kMGGZGrv0n97rgJ2FYXmxbR13Fkstcc8FM
Huwi7yvBLW2p9fmNJ7pKEe9TtVcrRx80NVz/e9E3cNgfzauXFAhjRw90zhMeJsFw
DXq0ceK2pr1p8YWWdHwalQKBgQDG7wf6HwOHFMvsFLq1kfjmsukr5WfznqA0ViWJ
gCYWrVNd1onRa1zd9yfzuPHojAYIFW1uScXYJkpac4+vr15mfyJmiV4DHkLuorbY
8dCL7SO9YHYxofQUEJxdcktf/XRb6YpBjAyWDz2Rwm51Q6R+ZOD/EckmGjab5SFy
k5dKgQKBgQCDoldwSZnZLnsSDTzchhX+4WAf70F0dr3MNj9/ZTi9yH9f3Od1eSnz
ILrOIVltD9KoeLufXJq8mPjA3Kw42BUd75GE+uFm5gxMMdllEXeSnIAxw+0dkS6J
qOI62bCy6Q1u74kdH/YUWesXZEe9wgsCymJ3atMeXxoZFJUreivLQw==
-----END RSA PRIVATE KEY-----");   /*Selle key peaks enda omaga asendama*/

function getCurrentDate() {
    $dt = new DateTime("now", new DateTimeZone('Europe/Helsinki'));
	return $dt->format('Y-m-d\TH:i:s\+0300');

}

$fields = array(
        "VK_SERVICE"     => "1011",
        "VK_VERSION"     => "008",
        "VK_SND_ID"      => "uid100023",
        "VK_STAMP"       => "12345",
        "VK_AMOUNT"      => "5",
        "VK_CURR"        => "EUR",
        "VK_ACC"         => "EE871600161234567892",
        "VK_NAME"        => "Spicy Memes OÜ",
        "VK_REF"         => "1234561",
        "VK_LANG"        => "EST",
        "VK_MSG"         => "Donation For Spicy Memes OÜ",
        "VK_RETURN"      => site_url("aboutus/received"),
        "VK_CANCEL"      => site_url("aboutus/notreceived"),
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
      <h2><?= lang('aboutus_donations') ?></h2>
      <p><?= lang('aboutus_donations_description') ?></p>
      <strong><?= lang('aboutus_donations_nb') ?></strong>
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
          <label for="PANGALINK_NAME"><?= lang('aboutus_name') ?> : </label>
          <input type="text" name="PANGALINK_NAME" id="PANGALINK_NAME" class="form-control" placeholder="<?= lang('aboutus_name_placeholder') ?>" required>
        </div>
        <div class="form-group">
          <label for="PANGALINK_ACCOUNT"><?= lang('aboutus_bank') ?> : </label>
          <input type="text" id="PANGALINK_ACCOUNT" class="form-control" name="PANGALINK_ACCOUNT" placeholder="<?= lang('aboutus_bank_placeholder') ?>" required>
        </div>
        <button type="submit" class="btn btn-lg donate-button"><?= lang('aboutus_donate') ?></button>
      </form>
    </div>
  </div>
</div>

<?php
include('footer.php');
?>
