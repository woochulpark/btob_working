<!doctype html>
<html lang="en">
 <head>
  <meta charset="UTF-8">
  <meta name="Generator" content="EditPlus®">
  <meta name="Author" content="">
  <meta name="Keywords" content="">
  <meta name="Description" content="">
  <title>Document</title>
  <script type="text/javascript">
	function goPopup(){
	
	if ($(".ver_p").is(":visible")){
		var pop = window.open("/Ins/JusoPopup.do?isMobile=N","pop","width=570,height=420, scrollbars=yes, resizable=yes");	
	} else {
		var pop = window.open("/Ins/JusoPopup.do?isMobile=Y","pop","scrollbars=yes, resizable=yes");	
	}
	
}


function jusoCallBack(roadFullAddr,roadAddrPart1,addrDetail,roadAddrPart2,engAddr, jibunAddr, zipNo, admCd, rnMgtSn, bdMgtSn,detBdNmList,bdNm,bdKdcd,siNm,sggNm,emdNm,liNm,rn,udrtYn,buldMnnm,buldSlno,mtYn,lnbrMnnm,lnbrSlno,emdNo){
		
	var frm = document.insInfo;
	
	// 팝업페이지에서 주소입력한 정보를 받아서, 현 페이지에 정보를 등록합니다.
		frm.contAddr.value = roadAddrPart1 + " " + roadAddrPart2;
		frm.contAddrDetail.value = addrDetail;
		frm.contPost.value = zipNo;
}
  </script>

 </head>
 <body>
  
 </body>
</html>
