function initMap() {
  var pepe = {lat: 58.378263, lng: 26.714566};
  var map = new google.maps.Map(document.getElementById('map'), {
    zoom: 18,
    center: pepe
  });
  var marker = new google.maps.Marker({
    position: pepe,
    icon: location.protocol + '//' + location.hostname + '/assets/feelsbadman48.png',
    title: 'FeelsGoodMan',
    map: map
  });
  marker.setAnimation(google.maps.Animation.DROP);
  marker.addListener('mouseover', function() {
    marker.setIcon(location.protocol + '//' + location.hostname + '/assets/feelsgoodman48.png');
  });
  marker.addListener('mouseout', function() {
    if (marker.getAnimation() == null) {
      marker.setIcon(location.protocol + '//' + location.hostname + '/assets/feelsbadman48.png');
    }
  });
  marker.addListener('click', function() {
    if (marker.getAnimation() !== null) {
      marker.setAnimation(null);
    } else {
      marker.setAnimation(google.maps.Animation.BOUNCE);
    }
  });
}
