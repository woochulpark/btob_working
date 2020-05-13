var token = "elkjgnrljtkbv23994jfn31ndnasn2mnce";
var host = "http://dealcar.co.kr";

//@ return String (device name)
function check_device(){
	var mobileKeyWords = new Array('iPhone', 'iPod', 'BlackBerry', 'Android', 'Windows CE', 'LG', 'MOT', 'SAMSUNG', 'SonyEricsson');//iPad
	var device_name = '';
	for (var word in mobileKeyWords){
		if (navigator.userAgent.match(mobileKeyWords[word]) != null){
			device_name=mobileKeyWords[word];
			break;
		}
	}
return device_name;
}

function GetUrlValue(VarSearch) {
	
	var SearchString = window.location.search.substring(1);
	
	var VariableArray = SearchString.split('&');
	for(var i=0; i<VariableArray.length;i++) {
		var KeyValuePair = VariableArray[i].split('=');

		if(KeyValuePair[0] == VarSearch) {
			return decodeURI(KeyValuePair[1]);
		}else{
			return "";
		}
	}
}

function parseUrl(url){
	var a=document.createElement('a');
	a.href=url;
	return a;
}

function home_btn() {
	location.href="main_page.html";
}

function go_tel(cust_tel) {
	alert('전화 : '+cust_tel);
}

function go_sms(cust_tel) {
	alert('문자 : '+cust_tel);
}