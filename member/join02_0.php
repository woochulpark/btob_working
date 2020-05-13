<? include ("../include/top_login.php"); ?>

<script>
	var oneDepth = 0; //1차 카테고리

	var id_check="N";

	function chk_same(){

		frm=document.send_form;

		if(!frm.uid.value) {
			alert('아이디를 입력하여 주십시오.');		
			frm.uid.focus();
			return false;
		}

		if(!idCheck(frm.uid.value)){
			alert('아이디는 5~12자 내의 영문, 숫자 조합으로 등록해 주세요.');
			$('input[name=uid]').focus();
			return false; 
		}
	
		$("#loading_area").css({"display":"block"});

		$.ajax({
			type : "POST",
			url : "../src/chk_same_uid.php",
			data : { 'uid' : frm.uid.value , 'auth_token' : auth_token },
			success : function(data, status)
			{
				var json = eval("(" + data + ")");

				if (json.result=="true") {
					alert(json.msg);
					id_check="Y"
					$("#check_uid").val(frm.uid.value);
					$("#loading_area").css({"display":"none"});
					return false;
				} else {
					alert(json.msg);
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

	function check_form() {
		var frm = document.send_form;
		
		if(frm.uid.value=='') {
			alert('아이디를 입력하여 주십시오.');
			frm.uid.focus();
			return false;
		}

		if(id_check=='N') {
			alert('아이디 중복 검사를 해 주십시오.');
			frm.uid.focus();
			return false;
		}  

		if(frm.uid.value!=frm.check_uid.value) {
			alert('아이디가 중복체크된 값과 다릅니다.');
			frm.uid.focus();
			return false;
		}
				
		if(frm.uid.value==frm.upw.value) {
			alert("비밀번호는 띄어쓰기 없는 영문, 숫자, 특수문자 (!,@,#,$,%,^,*,+,=,-) 조합 9~20자리 이내만 사용하실 수 있으며 아이디와 동일하게 사용할 수 없습니다.");
			$('input[name=upw]').focus();
			return false; 
		}

		if(!chkPwd(frm.upw.value)){
			alert("비밀번호는 띄어쓰기 없는 영문, 숫자, 특수문자 (!,@,#,$,%,^,*,+,=,-) 조합 9~20자리 이내만 사용하실 수 있으며 아이디와 동일하게 사용할 수 없습니다.");
			$('input[name=upw]').focus();
			return false; 
		}

		if(frm.upw.value!=frm.upws.value)
		{
			alert('비밀번호와 확인번호를 동일하게 입력하여 주십시오.');
			frm.upw.value='';
			frm.upws.value='';
			frm.upw.focus();
			return false;
		}

		if(frm.com_name.value=='') {
			alert('기업/단체 이름을 입력하여 주십시오.');
			frm.com_name.focus();
			return false;
		}

		if(frm.email.value=='') {
			alert('기업/단체 이메일을 입력하여 주십시오.');
			frm.email.focus();
			return false;
		}

		var eamil_address = frm.email.value;

		if(!emailCheck(eamil_address)){
			alert("이메일을 정확이 입력해 주세요.");
			$('input[name=email]').focus();
			return false; 
		}

		if(frm.hphone.value=='') {
			alert('전화번호를 입력하여 주십시오.');
			frm.hphone.focus();
			return false;
		}

		$("#loading_area").css({"display":"block"});
		$("#auth_token").val("<?=$site_check_key?>");	

		$.ajax({
			type : "POST",
			url : "../src/member_process.php",
			data :  $("#send_form").serialize(),
			success : function(data, status)
			{
				var json = eval("(" + data + ")");

				if (json.result=="true") {
					location.href="complete.php?uid="+json.msg;
					$("#loading_area").delay(100).fadeOut();
					return false;
				} else {
					alert(json.msg);
					$("#loading_area").delay(100).fadeOut();
					return false;
				}
				
			},
			error : function(err)
			{
				alert(err.responseText);
				$("#loading_area").delay(100).fadeOut();
				return false;
			}
		});
	}


	$(document).ready(function() {
		$(".join_step > ol > li:nth-child(2)").addClass("on");
	});

</script>

<div id="wrap">
	<div id="inner_wrap">
		<!-- header -->
		<? include ("../include/header.php"); ?>
			<!-- //header -->
			<!-- container -->
			<div id="container">


<form name="send_form" id="send_form" method="post" enctype="multipart/form-data">
<INPUT type="hidden" id="auth_token" name="auth_token" readonly>
<INPUT TYPE="hidden" name="check_uid" id="check_uid" value="" readonly>
                        <div class="join_step">
						<ol class="three">
							<li><span class="ico"><span>1</span></span><span class="txt">약관동의</span></li>
							<li><span class="ico "><span>2</span></span><span class="txt">정보입력</span></li>
							<li><span class="ico "><span>3</span></span><span class="txt">가입완료</span></li>
						</ol>
                           
                        </div>
						<h3 class="s_tit">아이디/비밀번호</h3>
                        <div class="gray_box">

							<div class="step_select one" style="max-width:500px; margin:0 auto !important;">
								<div class="select_ds">
									<label class="ss_tit db mt0">아이디</label>
									<div class="bt_include" style="width:100%;">
										<input style="width:100%;" placeholder="" type="text" name="uid" id="uid" class="input">
										<p class="add_bt"><a class="btnNormalB gray" href="javascript:void(0);" onclick="chk_same(); return false;"><span>중복확인</span></a></p>
									</div>
								</div>
								<div class="select_ds">
									<label class="ss_tit db">비밀번호</label>
								   <input type="password" class="input" value="" name="upw" placeholder="비밀번호 (영문, 숫자, 특수문자 (!,@,#,$,%,^,*,+,=,-) 조합 9~20자리 이내)">
								</div>
								<div class="select_ds">
									<label class="ss_tit db">비밀번호 확인</label>
								   <input type="password" class="input" value="" name="upws" placeholder="비밀번호 재확인">
								</div>
							   
							</div>
						</div>

						<h3 class="s_tit">기업/단체 확인 정보</h3>
                        <div class="gray_box">

							<div class="step_select one" style="max-width:500px; margin:0 auto !important;">
								<div class="select_ds">
									<label class="ss_tit db mt0">사업자 등록번호</label>
									<input style="width:100%;" placeholder="" type="text" name="com_no" class="input onlyNumber" maxlength="10" placeholder="숫자만 입력하세요.">
								</div>
								<div class="select_ds">
									<label class="ss_tit db mt0">기업/단체 이름</label>
									<input style="width:100%;" placeholder="" type="text" name="com_name" class="input">
								</div>
								<div class="select_ds">
									<label class="ss_tit db mt0">기업/단체 이메일</label>
									<input style="width:100%;" placeholder="" type="text" name="email" class="input">
								</div>
								<div class="select_ds">
									<label class="ss_tit db mt0">전화번호</label>
									<input style="width:100%;" placeholder="" type="text" name="hphone" class="input onlyNumber"  placeholder="숫자만 입력하세요.">
								</div>
							   
							</div>
						</div>

               

                        <div class="btn-tc "> <a href="javascript:void(0);" onclick="check_form();" class="btnStrong m_block"><span>가입하기</span></a> <a href="#url" class="btnStrong cancel m_block "><span>취소하기</span></a> </div>

</form>

			
				

		</div>	
			<!-- //container -->
	</div>
	<!-- //inner_wrap -->
<? include ("../include/footer.php"); ?>

</div>
<!-- //wrap -->

</body>

</html>
