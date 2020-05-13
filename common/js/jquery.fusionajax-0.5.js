/**
@author : 김종관
@email : apmsoft@gmail.com

[방법 1]
@prints : 외부 함수 function prints(){}
function prints(obj, data){
	데이타처리
}

$('#list').fusionAjaxRecord({
	'filename':'./modules/bbs_view.php',
	'data':{
			page:1,
			uid:10
	}
}, prints);

[방법 2]
$('#menu').fusionAjaxRecord({
	'filename':'/xml_parse.php',
	'data':{
		xml_file:'/manifest.xml',
		xpath:'navigation/index'
	}
}, function(obj, data){
	// 데이타처리
});
*/
jQuery(function($) 
{
	$.fn.fusionAjaxRecord= function(params,callMethod)
	{
		var targetID = $(this);
		var callbacks = $.Callbacks();
		var callFunction =callMethod;

		var param = $.extend({
			filename : null,
			data : ''
		},params||{});

		$.ajax({
			type: "post",
			url: param.filename,
			//crossDomain: true,
			cache: false,
			dataType :'text',
			data :param.data,
			success: function(data, status)
			{
				var json = eval("(" + data + ")");
				//var json =$.parseJSON(data);
				if(typeof(json.result) != 'undefined')
				{
					if(json.result == 'false'){
						alert(json.msg);
						if(typeof(json.fieldname) !='undefined' && json.fieldname != ''){
							$('#'+json.fieldname).focus();
						}
					}else{
						callbacks.add(callFunction);
						callbacks.fire(targetID,json);
					}
				}
			},
			error: function(data, status, errorThrown){
				//alert(data.responseText+' '+status+' '+errorThrown);
				alert('처리 중 입니다. 확인 후 잠시만 기다려주세요.');
				location.reload;
			}
		});
	}
});