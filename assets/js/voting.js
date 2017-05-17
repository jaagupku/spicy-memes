function loadVoting(containerClassName, ajaxSubPath) {
    var votes = ["Down", "Remove", "Up"];

    var updatePoints = function (container, vote, previousVote) {
        container.find('.active-vote').removeClass('active-vote');

        if (vote == 1) {
            container.find('.upvote').addClass('active-vote');
        } else if (vote == -1) {
            container.find('.downvote').addClass('active-vote');
        }

        var points = container.find('.points').first();
        points.html(parseInt(points.html()) + (vote - previousVote));
    };

    var getPreviousVote = function (container) {
        var activeVote = container.find('.active-vote');

        if (activeVote.length == 0) {
            return 0;
        }

        return activeVote.first().hasClass('upvote') ? 1 : -1;
    };

    var vote = function (container, vote) {
        var id = container.attr('data-id');
        var previousVote = getPreviousVote(container);

        vote = vote == previousVote ? 0 : vote;

        $.ajax({
            url: location.protocol + '//' + location.hostname + '/voting/' + ajaxSubPath,
            type: 'post',
            data: {id: id, vote: vote},
            success: function () {
               ga('send', {
                    hitType: 'event',
                    eventCategory: 'Voting',
                    eventAction: votes[vote + 1],
                    eventLabel: ajaxSubPath,
                    eventValue: parseInt(id)
                });
                console.log(parseInt(id));
                updatePoints(container, vote, previousVote);
            },
            error: function (jqXHR, status, error) {
                if (error == 'Not Found') {
                    $('#signuploginmodal').modal();
                } else {
                    alert(status + ': ' + error);
                }
            }
        });
    };

    $(document).on('click tap', '.upvote', function () {
        vote($(this).closest('.' + containerClassName), 1);
    });

    $(document).on('click tap', '.downvote', function () {
        vote($(this).closest('.' + containerClassName), -1);
    });
}
