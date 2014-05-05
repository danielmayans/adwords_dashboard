function alert_download(){
    var reportAlert = $('<div/>');
    reportAlert.html('<div class="alert alert-success"><strong>Heads up!</strong> Report was downloaded to <a href="#" class="alert-link">'+dirname+'</a> succesfully.</div>').css({
    	'float':'left',
    	'position':'absolute',
    	'top':'0',
    	'right':'0'
    });
    $('body').prepend(reportAlert);

    $('body').append($('<a/>').attr('href',dirname).text('DOWNLOAD REPORT').attr('id','download').css({
        'color':'white',
        'backgroundColor':'green',
        'padding':'10px',      
        'float':'left'}));

    $('#download').hover(
        function(){
            $(this).css({
                'backgroundColor':'lightgreen',
                'color':'green',
                'border':'1px solid green'
            });
        },
        function(){
            $(this).css({
                'backgroundColor':'green',
                'color':'white',
                'border':'0'
            });
        }
    );

    reportAlert.fadeIn(500).delay(5000).queue(function(n) {
      $(this).fadeOut(1000); n();
  	});
}