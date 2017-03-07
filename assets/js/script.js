function update_score(element, vote) {
    var parent = element.parent();
    var previous = previous_vote(element);

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
    var active_vote = $(element.parent().find('.active-vote'));

    if (active_vote.length == 0) {
        return 0;
    }

    return active_vote.first().hasClass('upvote') ? 1 : -1;
}

function vote(element, vote) {
    var meme_id = element.parent().parent().attr('data-id');

    vote = vote == previous_vote(element) ? 0 : vote;

    $.ajax({
        url: location.protocol + '//' + location.hostname + '/index.php/voting/meme',
        type: 'post',
        data: {meme_id: meme_id, vote: vote},
        success: function(response) { update_score(element, vote); },
        error: function(jqXHR, status, error) { alert(error) }
    });
}

$(function() {
    $(document).on('click tap', '.upvote', function () { vote($(this), 1); });
    $(document).on('click tap', '.downvote', function () { vote($(this), -1); });
});
