function initMap() {
  var base = {lat: 58.378273, lng: 26.714576};
  var map = new google.maps.Map(document.getElementById('map'), {
    zoom: 18,
    center: base
  });
  var marker = new google.maps.Marker({
    position: base,
    icon: location.protocol + '//' + location.hostname + '/assets/feelsgoodman48.png',
    title: 'FeelsGoodMan',
    map: map
  });
  marker.setAnimation(google.maps.Animation.DROP);
  toggleBounce = function() {
    if (marker.getAnimation() !== null) {
      marker.setAnimation(null);
    } else {
      marker.setAnimation(google.maps.Animation.BOUNCE);
    }
  }
  marker.addListener('click', toggleBounce);
}
