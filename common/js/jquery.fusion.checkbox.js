jQuery(function($) 
{
	$.fn.fusionCheckbox= function(params)
	{
		var targetID = $(this);
		
		var checkboxz = $.extend({
			name : 'chkuid',
		},params||{});

		// 기본 css 값 넣어주기
		$(targetID).attr('class','chkdis');
		
		$(targetID).click(function(){
			var mode=$(this).attr('class');
			if(mode=='chkena'){
				$("input:checkbox[name="+checkboxz.name+"]:checked").each(function(){
					$(this).removeAttr('checked');
				});
				$(targetID).attr('class','chkdis');
			}else{
				$("input:checkbox[name="+checkboxz.name+"]").each(function(){
					$(this).attr('checked','checked');
				});
				$(targetID).attr('class','chkena');
			}
		});
	}
});