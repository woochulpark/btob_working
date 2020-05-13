/**
@author : 김종관
@email : apmsoft@gmail.com
*/
var headline_count;
var headline_interval;
var old_headline = 0;
var current_headline = 0;
var headline_top = 0;
jQuery(function($) 
{
	$.fn.scrollup= function(params)
	{
		var targetID = $(this);
		
		var param = $.extend({
			delaytime : 3000,
			top:0
		},params||{});
		
		headline =param.top;
		
		headline_count = $("div.headline").size();
	    $("div.headline:eq("+current_headline+")").css('top',headline+'px');
	 
	    headline_interval = setInterval(headline_rotate,param.delaytime); //time in milliseconds
	    $(targetID).hover(function() {
	        clearInterval(headline_interval);
	    }, function() {
	        headline_interval = setInterval(headline_rotate,param.delaytime); //time in milliseconds
	        headline_rotate();
	    });
	}
});

function headline_rotate() {
    current_headline = (old_headline + 1) % headline_count;
    $("div.headline:eq(" + old_headline + ")").animate({top: -25},"slow", function() {
        $(this).css('top','210px');
    });
    $("div.headline:eq(" + current_headline + ")").show().animate({top: headline},"slow");
    old_headline = current_headline;
}