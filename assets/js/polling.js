function startPolling() {
    function poll() {
        $.ajax({
            url: location.protocol + '//' + location.hostname + '/index.php/main/newest',
            type: 'post',
            data: {lastMeme: $('.meme-container').attr('data-id')},
            success: function (result) {
                prepend(result);
                setTimeout(poll, 10000);
            },
            error: function (jqXHR, status, error) {
                alert(status + ': ' + error);
            }
        })
    }

    function prepend(result) {
        if (result == '') {
            return;
        }

        $.ajax({
            method: "GET",
            url: location.protocol + '//' + location.hostname + "/assets/xlst/meme.xsl"
        }).done(function(xlst) {
            var height = $(document).height();
            var scroll = $(document).scrollTop();
            addFromXML(result, xlst, '#memebody', 'prepend');
            $(document).scrollTop($(document).height() - height + scroll);
        });
    }

    setTimeout(poll, 10000);
}

$(function() {
    startPolling();
});