$(function(){

    var reportAlert = $('<div/>');
    reportAlert.html('<div class="alert alert-success">
    	<strong>Heads up!</strong> Report was downloaded to 
    	<a href="#" class="alert-link">'+filePath+'</a> succesfully.
    	</div>').css("float","left");
    $('body').prepend(reportAlert);

    reportAlert.fadeIn(500).delay(5000).queue(function(n) {
      $(this).fadeOut(1000); n();
  	});
});