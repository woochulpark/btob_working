<?
	$juso_api_key = "U01TX0FVVEgyMDIwMDIyMTE3MzY1MzEwOTQ4ODA=";
?>
<!doctype html>
<html lang="en">
 <head>
 <meta charset="UTF-8">
 <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <title>Document</title>
 <script language="javascript">
// opener관련 오류가 발생하는 경우 아래 주석을 해지하고, 사용자의 도메인정보를 입력합니다. ("주소입력화면 소스"도 동일하게 적용시켜야 합니다.)
//document.domain = "abc.go.kr";

function init(){
	var url = location.href;
	
	var confmKey = "<?=$juso_api_key?>";
	
	//var confmKey = "TESTJUSOGOKR";
	var resultType = "4"; // 도로명주소 검색결과 화면 출력내용, 1 : 도로명, 2 : 도로명+지번, 3 : 도로명+상세건물명, 4 : 도로명+지번+상세건물명
	var inputYn= "<?=$_POST['inputYn']?>";
	if(inputYn != "Y"){
		document.form.confmKey.value = confmKey;
		document.form.returnUrl.value = url;
		document.form.resultType.value = resultType;
	
		document.form.action="http://www.juso.go.kr/addrlink/addrLinkUrl.do"; //인터넷망
		
		//document.form.action="http://www.juso.go.kr/addrlink/addrMobileLinkUrl.do"; //모바일 웹인 경우, 인터넷망
		
		document.form.submit();
	}else{
		<?
	//request.setCharacterEncoding("UTF-8");  //한글깨지면 주석제거
	//request.setCharacterEncoding("EUC-KR");  //해당시스템의 인코딩타입이 EUC-KR일경우에
	$inputYn = $_POST['inputYn']; 
	$roadFullAddr = $_POST['roadFullAddr']; 
	$roadAddrPart1 = $_POST['roadAddrPart1']; 
	$roadAddrPart2 = $_POST['roadAddrPart2']; 
	$engAddr = $_POST['engAddr']; 
	$jibunAddr = $_POST['jibunAddr']; 
	$zipNo = $_POST['zipNo']; 
	$addrDetail = $_POST['addrDetail']; 
	$admCd    = $_POST['admCd'];
	$rnMgtSn = $_POST['rnMgtSn'];
	$bdMgtSn  = $_POST['bdMgtSn'];
	$detBdNmList  = $_POST['detBdNmList'];	
	/** 2017년 2월 추가제공 **/
	$bdNm  = $_POST['bdNm'];
	$bdKdcd  = $_POST['bdKdcd'];
	$siNm  = $_POST['siNm'];
	$sggNm  = $_POST['sggNm'];
	$emdNm  = $_POST['emdNm'];
	$liNm  = $_POST['liNm'];
	$rn  = $_POST['rn'];
	$udrtYn  = $_POST['udrtYn'];
	$buldMnnm  = $_POST['buldMnnm'];
	$buldSlno  = $_POST['buldSlno'];
	$mtYn  = $_POST['mtYn'];
	$lnbrMnnm  = $_POST['lnbrMnnm'];
	$lnbrSlno  = $_POST['lnbrSlno'];
	/** 2017년 3월 추가제공 **/
	$emdNo  = $_POST['emdNo'];

?>
		opener.jusoCallBack("<?=$roadFullAddr?>","<?=$roadAddrPart1?>","<?=$addrDetail?>","<?=$roadAddrPart2?>","<?=$engAddr?>","<?=$jibunAddr?>","<?=$zipNo?>", "<?=$admCd?>", "<?=$rnMgtSn?>", "<?=$bdMgtSn?>", "<?=$detBdNmList?>", "<?=$bdNm?>", "<?=$bdKdcd?>", "<?=$siNm?>", "<?=$sggNm?>", "<?=$emdNm?>", "<?=$liNm?>", "<?=$rn?>", "<?=$udrtYn?>", "<?=$buldMnnm?>", "<?=$buldSlno?>", "<?=$mtYn?>", "<?=$lnbrMnnm?>", "<?=$lnbrSlno?>", "<?=$emdNo?>");
		window.close();
		}
}
</script>
</head>
<body onload="init();">
	<form id="form" name="form" method="post">
		<input type="hidden" id="confmKey" name="confmKey" value=""/>
		<input type="hidden" id="returnUrl" name="returnUrl" value=""/>
		<input type="hidden" id="resultType" name="resultType" value=""/>
		<!-- 해당시스템의 인코딩타입이 EUC-KR일경우에만 추가 START-->
		<!-- 
		<input type="hidden" id="encodingType" name="encodingType" value="EUC-KR"/>
		 -->
		<!-- 해당시스템의 인코딩타입이 EUC-KR일경우에만 추가 END-->
	</form>
</body>
</html>
