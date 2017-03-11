$(function () {
    function update_score(element, vote, previous) {
        var parent = element.parents('.row').first();

        parent.find('.active-vote').removeClass('active-vote');

        if (vote == 1) {
            parent.find('.upvote').addClass('active-vote');
        } else if (vote == -1) {
            parent.find('.downvote').addClass('active-vote');
        }

        var points = parent.find('.points').first();
        points.html(parseInt(points.html()) + (vote - previous));
    }

    function previous_vote(element) {
        var active_vote = element.parents('.row').first().find('.active-vote');

        if (active_vote.length == 0) {
            return 0;
        }

        return active_vote.first().hasClass('upvote') ? 1 : -1;
    }

    function vote(element, vote) {
        var meme_id = element.parents('.row').first().attr('data-id');
        var previous = previous_vote(element);

        vote = vote == previous_vote(element) ? 0 : vote;

        $.ajax({
            url: location.protocol + '//' + location.hostname + '/index.php/voting/meme',
            type: 'post',
            data: {meme_id: meme_id, vote: vote},
            success: function (response) {
                update_score(element, vote, previous);
            },
            error: function (jqXHR, status, error) {
                alert(error)
            }
        });
    }

    $(document).on('click tap', '.upvote', function () {
        vote($(this), 1);
    });

    $(document).on('click tap', '.downvote', function () {
        vote($(this), -1);
    });
});

function yHandler(){
	var body =document.getElementById('memebody');
	var contentHeight = body.offsetHeight;
	var y = window.pageYOffset + window.innerHeight;
	if(y + 333 >= contentHeight){
    window.onscroll = null;
		loadMore();
	}
}

window.onscroll = yHandler;

function loadMore() {
  var xhttp = new XMLHttpRequest();
  var loadbutton = document.getElementById('load-button');
  var from = loadbutton.getAttribute('data-load-from');
  var amount = loadbutton.getAttribute('data-load-amount');
  var params = "from="+from+"&amount=" + amount;
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      var nextFrom = parseInt(from) + parseInt(amount);
      $("#load-more").append(this.response);
      loadbutton.setAttribute('data-load-from', nextFrom);
      loadbutton.setAttribute('href', "/index.php/" + loadbutton.getAttribute('data-load-type') + "/" + from + "/" + amount);
      window.onscroll = yHandler;
    } else {
      $("#load-button").hide();
    }
  };
  console.log(params);
  xhttp.open("POST", "/index.php/" + $("#load-button").data("loadType"), true);
  xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  xhttp.send(params);
}
