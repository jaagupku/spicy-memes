var SPLITPATHNAME = location.pathname.split('/');
var FROM = SPLITPATHNAME.length > 2 ? parseInt(SPLITPATHNAME[2]) : 0;
var XLST = '';

$(function () {
    loadVoting('meme-container', 'meme');

    $.ajax({
        method: "GET",
        url: location.protocol + '//' + location.hostname + "/main/meme_xsl",
        dataType: 'xml'
    }).done(function (xlst) {
        XLST = xlst;
        window.onscroll = yHandler;
    });
});

$('#load-button').text("Loading...");

function yHandler() {
    var body = document.getElementById('memebody');
    var contentHeight = body.offsetHeight;
    var y = window.pageYOffset + window.innerHeight;
    if (y + 400 >= contentHeight) {
        window.onscroll = null;
        if ($('.meme').length < 50) {
            loadMore();
        } else {
            $('#load-button').text("Click here for more spice!");
        }
    }
}

function addFromXML(data, xlst, selector, fn) {
    var parsedXML = jQuery.parseXML(data);
    var xsltProcessor = new XSLTProcessor();
    xsltProcessor.importStylesheet(xlst);
    $(selector)[fn](xsltProcessor.transformToFragment(parsedXML, document));
}

function loadMore() {
    var loadbutton = document.getElementById('load-button');
    var from = loadbutton.getAttribute('data-load-from');
    var amount = loadbutton.getAttribute('data-load-amount');
    var type = loadbutton.getAttribute('data-load-type');
    var params = "type=" + type + "&from=" + from + "&amount=" + amount;

    $.ajax({
        method: "GET",
        url: location.protocol + '//' + location.hostname + "/index.php/ajax?" + params,
        error: function (xhr, status, error) {
            $("#load-button").hide();
        }
    }).done(function (result) {
        if (result === 'null') {
            window.onscroll = null;
            $("#load-button").hide();
            $('#load-more').append("<p>You have reached the end.</p>");
        } else {
            addFromXML(result, XLST, '#load-more', 'append');
            var nextFrom = parseInt(from) + parseInt(amount);
            loadbutton.setAttribute('data-load-from', nextFrom);
            loadbutton.setAttribute('href', "/index.php/" + type + "/" + nextFrom + "/" + amount);
            window.onscroll = yHandler;

            var memeCount = $('.meme').length;
            history.replaceState({}, '', '/' + type + '/' + FROM + '/' + memeCount);
        }
    });
}