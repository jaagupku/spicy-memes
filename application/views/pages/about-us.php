<?php
$title = 'About us';
$selection ='aboutus';
include('header.php');

array_push($scripts, '/assets/js/googlemap.js');
array_push($scripts, 'https://maps.googleapis.com/maps/api/js?key=AIzaSyDuSD8hPdFABJxJjQeS9HtCNQs08neegNg&callback=initMap'); // async defer
?>

<h3>Our base of operations is located at:</h3>
<div style="height: 400px; width: 100%;" id="map"></div>

<?php
include('footer.php');
?>
