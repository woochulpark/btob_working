<? 
	include ("../include/top.php"); 
	include ("../include/link_session_check.php");
?>

<script>
	var oneDepth = 3; //1차 카테고리

	function check_form() {

		var frm=document.send_form;

		if (frm.search_name.value=="") {
			alert('이름을 입력하세요.');
			$("#search_name").focus();
			return false;
		}

		if(frm.search_jumin_1.value=='') {
			alert('주민등록번호 앞자리를 입력하여 주십시오.');
			frm.search_jumin_1.focus();
			return false;
		}

		if(frm.search_jumin_1.value.length < 6) {
			alert('주민등록번호 앞자리를 정확히 입력하여 주십시오.');
			frm.search_jumin_1.focus();
			return false;
		}

		if(frm.search_jumin_2.value=='') {
			alert('주민등록번호 뒷자리를 입력하여 주십시오.');
			frm.search_jumin_2.focus();
			return false;
		}

		if(frm.search_jumin_2.value.length < 7) {
			alert('주민등록번호 뒷자리를 정확히 입력하여 주십시오.');
			frm.search_jumin_2.focus();
			return false;
		}

		$("#loading_area").css({"display":"block"});

		$.ajax({
			type : "POST",
			url : "../src/plan_login_check.php",
			data :  $("#send_form").serialize(),
			success : function(data, status) {
				var json = eval("(" + data + ")");

				if (json.result=="true") {
					location.href="list.php";
					$("#loading_area").css({"display":"none"});
					return false;
				} else {
					alert('일치하는 정보가 없습니다'); 
					$("#loading_area").css({"display":"none"});
					return false;
				}
				
			},
			error : function(err)
			{
				alert(err.responseText);
				$("#loading_area").css({"display":"none"});
				return false;
			}
		});
	}
</script>

<div id="wrap">
	<div id="inner_wrap">
		<!-- header -->
		<? include ("../include/header.php"); ?>
			<!-- //header -->
			<!-- container -->
			<div id="container">
				<h3 class="step_tit"><strong>가입내역 조회</strong></h3>
				<div class="gray_box">

<form name="send_form" id="send_form">
					<div class="step_select one" style="max-width:500px; margin:0 auto;">
						<div class="select_ds">
							<label class="ss_tit db mt0">이름</label>
							<input type="text" name="search_name" id="search_name" class="input" placeholder="">
						</div>
						<div class="select_ds">
							<label class="ss_tit db">주민등록번호 (외국인등록번호)</label>
							<div class="col-sm-2">
								<div class="select_ds pr10">
									<input type="number" oninput="maxLengthCheck(this)" name="search_jumin_1" value="" placeholder="" class="onlyNumber input" maxlength="6">
									<span class="pa_minus">-</span>
								</div>
								<div class="select_ds pl5">
									<input type="password" name="search_jumin_2" value="" placeholder="" class="onlyNumber input" maxlength="7">
								</div>

							</div>
						</div>

					</div>
				</div>

				<div class="btn-tc">

					<a href="javascript:void(0);" onclick="check_form();" class="btnBig m_block"><span>조회하기</span></a>
				</div>
</form>


			</div>

	</div>
	<!-- //container -->
</div>
<!-- //wrap -->


</body>

</html>
