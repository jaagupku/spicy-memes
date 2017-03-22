$(function() {
    loadVoting('meme-container', 'meme');
});

function yHandler(){
	var body =document.getElementById('memebody');
	var contentHeight = body.offsetHeight;
	var y = window.pageYOffset + window.innerHeight;
	if(y + 400 >= contentHeight){
    window.onscroll = null;
    if ($('.meme').length < 50) {
  		loadMore();
    }
	}
}

function addFromXML(data, xlst, selector, fn) {
    var parsedXML = jQuery.parseXML(data);
    var xsltProcessor = new XSLTProcessor;
    xsltProcessor.importStylesheet(xlst);
    $(selector)[fn](xsltProcessor.transformToFragment(parsedXML, document));
}

function loadMore() {
  var loadbutton = document.getElementById('load-button');
  var from = loadbutton.getAttribute('data-load-from');
  var amount = loadbutton.getAttribute('data-load-amount');
  var type = loadbutton.getAttribute('data-load-type');
  var params = "type="+type+"&from="+from+"&amount=" + amount;
  $.ajax({
    method: "GET",
    url: location.protocol + '//' + location.hostname + "/assets/xlst/meme.xsl"
  }).done(function(xlst) {
    $.ajax({
      method: "GET",
      url: location.protocol + '//' + location.hostname + "/index.php/ajax?" + params,
      error: function(xhr, status, error) {
        $("#load-button").hide();
      }
    }).done(function(result) {
      addFromXML(result, xlst, '#load-more', 'append');
      var nextFrom = parseInt(from) + parseInt(amount);
      loadbutton.setAttribute('data-load-from', nextFrom);
      loadbutton.setAttribute('href', "/index.php/" + type + "/" + from + "/" + amount);
      window.onscroll = yHandler;
    });
  });
}


window.onscroll = yHandler;
