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

<div class="container-fluid">
  <div class="row">
    <div class="col-xs-12 col-custom-about col-centered">
      <h2>DONATIONS</h2>
      <p>To help us boost our creativity and make everything more spicy, we have included a big red donate button. So everyone who thinks we deserve some recognition, hit that button. </p>
      <div class="break"></div>
      <a role="button" class="btn btn-lg" href="#">DONATE</a>
    </div>
  </div>
</div>

<?php
include('footer.php');
?>
