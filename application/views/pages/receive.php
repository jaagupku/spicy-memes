<?php
$title = 'About us';
$selection =null;
include('header.php');
?>

<?php

$public_key = openssl_pkey_get_public("-----BEGIN CERTIFICATE-----
MIIDljCCAn4CCQCrBgdPuWKvmTANBgkqhkiG9w0BAQUFADCBjDELMAkGA1UEBhMC
RUUxETAPBgNVBAgTCEhhcmp1bWFhMRAwDgYDVQQHEwdUYWxsaW5uMQ0wCwYDVQQK
EwRUZXN0MREwDwYDVQQLEwhiYW5rbGluazEXMBUGA1UEAxMObG9jYWxob3N0IDgw
ODAxHTAbBgkqhkiG9w0BCQEWDnRlc3RAbG9jYWxob3N0MB4XDTE3MDMyNjE2NTQx
M1oXDTM3MDMyMTE2NTQxM1owgYwxCzAJBgNVBAYTAkVFMREwDwYDVQQIEwhIYXJq
dW1hYTEQMA4GA1UEBxMHVGFsbGlubjENMAsGA1UEChMEVGVzdDERMA8GA1UECxMI
YmFua2xpbmsxFzAVBgNVBAMTDmxvY2FsaG9zdCA4MDgwMR0wGwYJKoZIhvcNAQkB
Fg50ZXN0QGxvY2FsaG9zdDCCASIwDQYJKoZIhvcNAQEBBQADggEPADCCAQoCggEB
ALwlG5PVbQyik4tXOrVYw+Pa06ap6LXhle6glcav+Wo4Y9Ip5y7eKsx32jUHLqpp
MORzzMSqmnSqQpZ6cU8tWhzZi3RTjeOu3RRTTz3SjmVWJDFnRxPKXk6pCKODmf1h
7J+sC1OzIi1nDLEwrKtbhxAIBKozpwqIMwsm+3zZDSVkVG4zkv2cBnoOcuKLJBEU
MXDRTAzE5DSxz5K8zz7vF1ek1B+xxRmDMNOz5z7KrDSZ9MK+1ID90fxZFr6xaN0b
YQ+C3EO1QrhC2NI6IjIDNtnmnffZHkU9vG9+2KS1/mCtdTfL3HGq4x6JXJSTYsWe
YsZKPEy+fSp4QWteqJLYVwMCAwEAATANBgkqhkiG9w0BAQUFAAOCAQEALAz8fmdJ
jCSyoH2E3PS38wty5SvCHTCqWC7YvGTQ5ESyRHuZYVQ0H07UCfgMN7yZ3HaGt6XE
f4/1cJBapA40v9l73aW5TlHVatStsYJcaRbxGd6dVKyWUG0bPJhYNBXHjbaLe5Jo
Z9B51H5vh07VUWNAbWN4/9abnsAWEgKvYJzPHJjuLGmdA0HVihqr5ulL6yZjcxea
qsNi1+83qiNpWJI4l3ZyG9ixY01Ph8pjFEWFUaDs/trlqpgFR9Rc++OonETpss/T
h4jNVNtu52yowcShDDXK5SGCJ4PBLitD2K7DGLMc0RjMsx8gvG8MMfnklBmOhveO
BuvFk35l06hv+g==
-----END CERTIFICATE-----");

$fields = array ();
 foreach ((array)$_REQUEST as $f => $v) {
       if (substr ($f, 0, 3) == 'VK_') {
           $fields[$f] = $v;
       }
   }

$data = str_pad (mb_strlen($fields["VK_SERVICE"], "UTF-8"),   3, "0", STR_PAD_LEFT) . $fields["VK_SERVICE"] .    /* 1111 */
        str_pad (mb_strlen($fields["VK_VERSION"], "UTF-8"),   3, "0", STR_PAD_LEFT) . $fields["VK_VERSION"] .    /* 008 */
        str_pad (mb_strlen($fields["VK_SND_ID"], "UTF-8"),    3, "0", STR_PAD_LEFT) . $fields["VK_SND_ID"] .     /* GENIPIZZA */
        str_pad (mb_strlen($fields["VK_REC_ID"], "UTF-8"),    3, "0", STR_PAD_LEFT) . $fields["VK_REC_ID"] .     /* uid100036 */
        str_pad (mb_strlen($fields["VK_STAMP"], "UTF-8"),     3, "0", STR_PAD_LEFT) . $fields["VK_STAMP"] .      /* 12345 */
        str_pad (mb_strlen($fields["VK_T_NO"], "UTF-8"),      3, "0", STR_PAD_LEFT) . $fields["VK_T_NO"] .       /* 10006 */
        str_pad (mb_strlen($fields["VK_AMOUNT"], "UTF-8"),    3, "0", STR_PAD_LEFT) . $fields["VK_AMOUNT"] .     /* 5 */
        str_pad (mb_strlen($fields["VK_CURR"], "UTF-8"),      3, "0", STR_PAD_LEFT) . $fields["VK_CURR"] .       /* EUR */
        str_pad (mb_strlen($fields["VK_REC_ACC"], "UTF-8"),   3, "0", STR_PAD_LEFT) . $fields["VK_REC_ACC"] .    /* EE871600161234567892 */
        str_pad (mb_strlen($fields["VK_REC_NAME"], "UTF-8"),  3, "0", STR_PAD_LEFT) . $fields["VK_REC_NAME"] .   /* Spicy Memes OÜ */
        str_pad (mb_strlen($fields["VK_SND_ACC"], "UTF-8"),   3, "0", STR_PAD_LEFT) . $fields["VK_SND_ACC"] .    /* EE152200221234567897 */
        str_pad (mb_strlen($fields["VK_SND_NAME"], "UTF-8"),  3, "0", STR_PAD_LEFT) . $fields["VK_SND_NAME"] .   /* Peeter Paan */
        str_pad (mb_strlen($fields["VK_REF"], "UTF-8"),       3, "0", STR_PAD_LEFT) . $fields["VK_REF"] .        /* 1234561 */
        str_pad (mb_strlen($fields["VK_MSG"], "UTF-8"),       3, "0", STR_PAD_LEFT) . $fields["VK_MSG"] .        /* Donation For Spicy Memes OÜ */
        str_pad (mb_strlen($fields["VK_T_DATETIME"], "UTF-8"), 3, "0", STR_PAD_LEFT) . $fields["VK_T_DATETIME"];  /* 2017-03-26T16:40:55+0300 */


if (openssl_verify ($data, base64_decode($fields["VK_MAC"]), $public_key) !== 1) {
    $signatureVerified = false;
}else{
    $signatureVerified = true;
}

?>

<?php if($fields["VK_SERVICE"] == "1111" and $signatureVerified):?>

    <div class="break"></div>

    <div class="container-fluid">
      <div class="row">
        <div class="col-xs-12 col-custom-about col-centered">
          <h2>Thank you for your donation!</h2>
            <div class="break"></div>
            <h3>Here's the donation information: </h3>
            <table class="table">
              <tbody>
                <tr>
                  <th>YOUR NAME: </th>
                    <td><?php echo $fields["VK_SND_NAME"]?></td>
                </tr>
                <tr>
                  <th>YOUR BANK ACCOUNT: </th>
                    <td><?php echo $fields["VK_SND_ACC"]?></td>
                </tr>
                <tr>
                  <th>AMOUNT DONATED: </th>
                    <td><?php echo $fields["VK_AMOUNT"]." ".$fields["VK_CURR"]?></td>
                </tr>
                <tr>
                  <th>DESCRIPTION: </th>
                    <td><?php echo $fields["VK_MSG"]?></td>
                </tr>
                <tr>
                  <th>DATE: </th>
                    <td><?php echo $fields["VK_T_DATETIME"]?></td>
                </tr>
              </tbody>
            </table>
        </div>
      </div>
    </div>

    <div class="break"></div>

<?php endif; ?>

<?php
include('footer.php');
?>
