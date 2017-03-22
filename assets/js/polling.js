function startPolling() {
    var lastMeme = $('.meme-container').attr('data-id');
    var xsltFile;
    $.ajax({
        method: "GET",
        url: location.protocol + '//' + location.hostname + "/assets/xlst/meme.xsl"
    }).done(function(xlst) {
        xsltFile = xlst;
    });

    function poll() {
        $.ajax({
            url: location.protocol + '//' + location.hostname + '/index.php/main/newest',
            type: 'post',
            data: {lastMeme: lastMeme},
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
        var height = $(document).height();
        var scroll = $(document).scrollTop();
        addFromXML(result, xsltFile, '#memebody', 'prepend');
        lastMeme = $('.meme-container').attr('data-id');
        $(document).scrollTop($(document).height() - height + scroll);
    }

    setTimeout(poll, 10000);
}

$(function() {
    startPolling();
});
