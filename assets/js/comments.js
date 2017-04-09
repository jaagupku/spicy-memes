var offlineCounter = 0;

window.addEventListener("storage", function(e) {
 console.debug(e);
}, false);

$(document).ready(function() {
  loadVoting('read-comments', 'comment');

  var $online = $('.online'),
      $offline = $('.offline');

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
      setTimeout(function(){
        $online.fadeOut("slow");
      },5000)
    });
    if (localStorage.comment0) {
      for (i = 0; i < offlineCounter; i++) {
        console.log("Attempting upload nr " + offlineCounter + ". Message: " + comment);
        $.ajax({
          type: "POST",
          url: window.location.href,
          data: "message=" + localStorage.getItem("comment" + i),
          success: function () {
            console.log("Uploaded comment nr " + offlineCounter + ". Message: " + comment);
            localStorage.removeItem("comment" + i);
          }
        });
      }
      offlineCounter = 0;
    }
  });

  var submitComment = function (e) {
    if (Offline.check()) {
      e.preventDefault();
      var comment = $("#comment").val();
      if (comment.length > 0) {
        localStorage.setItem("comment" + offlineCounter, comment);
        $("#comment").val("");
        console.log("Saved comment nr " + offlineCounter + ". Message: " + comment);
        offlineCounter += 1;
      }
    }
  };
  $("#submitComment").click(submitComment);
});
