function update_score(element, upvote) {
    var points = element.parent().find('.points').first();
    points.html(parseInt(points.html()) + (upvote ? 1 : -1));
}

function vote(element, upvote) {
    var meme_id = element.parent().parent().attr('data-id');

    $.ajax({
        url: location.protocol + '//' + location.hostname + '/index.php/voting/meme',
        type: 'post',
        data: {meme_id: meme_id, upvote: upvote},
        success: function(response) { update_score(element, upvote); },
        error: function(jqXHR, status, error) { alert(error) }
    });
}

$(function() {
    $(document).on('click tap', '.upvote', function () { vote($(this), true); });
    $(document).on('click tap', '.downvote', function () { vote($(this), false); });
});
