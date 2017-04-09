var uri = location.protocol + '//' + location.hostname + "/users/userMemesJSON?username=" + $(".user-profile-userpage h2").text() + "&order=";
var correctHash = ['top', 'comments', 'date'];
var fillTable = function(data) {
  var htmlData = "";
  $.each(data, function(key, value) {
    htmlData += '<tr><td><a href="' + location.protocol + '//' + location.hostname + 'meme/' + data.Id + '">' + value.Title + '</a></td><td>' + profile_spicelevel + ': ' + value.Points + '</td><td> ' + profile_comments + ': <a href="' + location.protocol + '//' + location.hostname + 'meme/' + value.Id + '"><span class="badge">' + value.comments + '</span></a></td><td>' + profile_addedon + ': ' + value.Date + '</td></tr>';
  });
  $(".uploads-userpage table tbody").html(htmlData);
};
var getUserMemeData = function(orderBy) {
  $.ajax({
    type: "GET",
    dataType: "json",
    url: uri + orderBy,
    success: function (r) {
      location.hash = orderBy;
      fillTable(r);
    }
  });
}
$(document).ready(function() {
  var order = location.hash.slice(1);
  if ($.inArray(order, correctHash) > -1) {
    getUserMemeData(order);
  }

  $(".sort").click(function(e) {
    e.preventDefault();
    getUserMemeData($(this).attr("data-sortby"));
  });
});
