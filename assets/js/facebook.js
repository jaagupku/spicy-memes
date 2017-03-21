logInWithFacebook = function() {
  FB.login(function(response) {
    if (response.authResponse) {
      window.location.href = location.protocol + '//' + location.hostname + "/index.php/login_fb_callback";
    } else {
      alert('User cancelled login or did not fully authorize.');
    }
  });
  return false;
};
window.fbAsyncInit = function() {
  FB.init({
    appId: '1239529539502104',
    cookie: true, // This is important, it's not enabled by default
    version: 'v2.8'
  });
};

(function(d, s, id){
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) {return;}
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/sdk.js";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));
