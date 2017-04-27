var offlineCounter = 0;

$(document).ready(function() {
  loadVoting('read-comments', 'comment');

  var $online = $('.online'),
      $offline = $('.offline');

    Offline.options = {checks: {xhr: {url: '/online'}}};

  Offline.on('down', function () {
    console.log("NOW OFFLINE");
    $online.fadeOut(function () {
      $offline.fadeIn();
    });
  });

  Offline.on('up', function () {
    console.log("NOW ONLINE");
    $offline.fadeOut(function () {
      $online.fadeIn();
    });
    setTimeout(function(){
      $online.fadeOut("slow");
    },5000)
    if (localStorage.comment0) {
      for (i = 0; i < offlineCounter; i++) {
        console.log("Attempting upload nr " + offlineCounter + ". Message: " + localStorage.getItem("comment" + i));
        $.ajax({
          type: "POST",
          url: window.location.href,
          data: "message=" + localStorage.getItem("comment" + i),
          success: function () {
            console.log("Uploaded comment nr " + offlineCounter + ". Message: " + localStorage.getItem("comment" + i));
            localStorage.removeItem("comment" + i);
          }
        });
      }
      $("#commentForm").append('<p id="uploadedLocal">Connection restored, comments uploaded.</p>');
      setTimeout(function(){
        $("#uploadedLocal").fadeOut("slow");
      },5000)
      offlineCounter = 0;
    }
  });

  var submitComment = function (e) {
    Offline.check();
    if (Offline.state == 'down') {
      e.preventDefault();
      var comment = $("#comment").val();
      if (comment.length > 0) {
        localStorage.setItem("comment" + offlineCounter, comment);
        $("#comment").val("");
        console.log("Saved comment nr " + offlineCounter + ". Message: " + comment);
        offlineCounter += 1;
        $("#commentForm").append('<p class="savedLocal">You are offline, comment saved in local storage.</p>');
        setTimeout(function(){
          $(".savedLocal").fadeOut("slow");
        },5000)
      }
    }
  };
  $("#submitComment").click(submitComment);
});
