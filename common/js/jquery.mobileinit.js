/*jquery.mobile.min.js가 로드되기 이전에 바인딩해야 함.*/
$(document).bind(
	"mobileinit", function(){
		$.mobile.allowCrossDomainPages = true;
		$.extend($.mobile, {
			defualtTransition : "none",
			//loadingMessage : "Please Wait...",
			ajaxEnabled : false
			//ajaxLinksEnabled = false 
	});
});