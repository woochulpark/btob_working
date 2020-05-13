/**
version :0.2
*/
jQuery(function($) 
{
	$.fusionModal= function(mask, dialog, params)
	{
		var mask_id = (mask !='') ? $(mask) : '';
		var dialog_id = $(dialog);
		var param = $.extend({
			mask_op:0.8,
			maskIndex:900,
			dialogIndex:901,
			winH : null,
			winW : null,
			scrollTop:null,
			documentH:null,
			documentW:null,
			dialogW:null,
			dialogH:null,
			win_resize:true,
			scroll_resize:true
		},params||{});

		// 기본 css
		if(mask_id) $(mask_id).css({'position':'absolute','left':0,'top':0,'z-index':param.maskIndex,'background-color':'#000','display':'block'});
		$(dialog_id).css({'position':'absolute','left':0,'top':0,'display':'block','z-index':param.dialogIndex});

		// 창 리사이즈할때 마다 갱신
		
		$(window).resize(function () {
			get_window_size();
			get_document_scrolltop();
			get_document_size();

			if(param.win_resize){
				if(mask_id) $(mask_id).css({'width':param.winW,'height':param.documentH});
				$(dialog_id).css('top', param.scrollTop-param.dialogH/2);
				$(dialog_id).css('left', param.winW/2-param.dialogW/2);
			}
		});

		// 스크롤할때마다 위치 갱신
		$(window).scroll(function () {
			get_window_size();
			get_document_scrolltop();
			get_document_size();

			if(param.scroll_resize){
				$(dialog_id).css('top', param.scrollTop-param.dialogH/2);
				$(dialog_id).css('left', param.winW/2-param.dialogW/2);
			}
		});

		// 윈도우 화면 사이즈 구하기
		function get_window_size(){
			param.winH = $(window).height();
			param.winW = $(window).width();
		}

		// 도큐멘트 화면 사이즈 구하기
		function get_document_size(){
			param.documentH = $(document).height();
			param.documentW = $(document).width();
		}

		// 스크롤 높이 구하기
		function get_document_scrolltop(){
			var _y =(window.pageYOffset) ? window.pageYOffset
			: (document.documentElement && document.documentElement.scrollTop) ? document.documentElement.scrollTop
			: (document.body) ? document.body.scrollTop
			: 0;

			if(_y<1){ param.scrollTop = param.winH/2;}
			else{ param.scrollTop = param.winH/2+_y;}
		}

		//$(mask_id).click(function(){
		//	fusionModal_close(mask,dialog);
		//});
		
		function modal_window()
		{
			get_window_size();
			get_document_scrolltop();
			get_document_size();

			// 마스크
			if(mask_id){
				$(mask_id).css({'width':param.winW,'height':param.documentH});
				$(mask_id).fadeTo("slow",param.mask_op);
			}

			// dialog창 리사이즈
			if(param.dialogW == null && param.dialogH==null){
				param.dialogW =$(dialog_id).width();
				param.dialogH = $(dialog_id).height();
			}
			$(dialog_id).css({'width':param.dialogW,'height':param.dialogH});
			$(dialog_id).css('top', param.scrollTop-param.dialogH/2);
			$(dialog_id).css('left', param.winW/2-param.dialogW/2);
			$(dialog_id).fadeIn(1000);
		}

		modal_window();
	},

	// 창닫기
	fusionModal_close= function(mask, dialog, callMethod)
	{
		var callbacks = $.Callbacks();
		var callFunction =callMethod;
		
		var mask_id = (mask !='') ? $(mask) : '';
		var dialog_id = $(dialog);
		if(mask_id) $(mask_id).hide();
		$(dialog_id).hide();

		if(callFunction != undefined){
			callbacks.add(callFunction);
			callbacks.fire(targetID,json);
		}
	}
});