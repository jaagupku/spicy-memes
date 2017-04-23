logInWithFacebook = function() {
  FB.login(function(response) {
    if (response.authResponse) {
      window.location.href = location.protocol + '//' + location.hostname + "/login_fb_callback";
    } else {
      alert('User cancelled login or did not fully authorize.');
    }
  }, {scope: 'email'});
  return false;
};
unLinkFacebook = function() {
  $("#facebook").text("Loading...");
  $("#facebook").attr("onClick", "");
  FB.getLoginStatus(function(response) {
    if (response.status === 'connected') {
      accessToken = response.authResponse.accessToken;
      FB.api('/me/permissions', 'DELETE', { access_token : accessToken }, function(response) {
        if (!response || response.error) {
          alert('Error occured');
        } else {
          window.location.href = location.protocol + '//' + location.hostname + "/users/unlink_fb";
        }
      });
    } else {
      alert('Log in Facebook and try again.');
    }
  });
};
window.fbAsyncInit = function() {
  FB.init({
    appId: '1239529539502104',
    cookie: true, // This is important, it's not enabled by default
    version: 'v2.8'
  });
};

window.load = function() {(function(d, s, id){
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) {return;}
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/sdk.js";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'))};
