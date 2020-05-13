<? include ("../include/top.php"); ?>
<?

	if ($_SESSION['s_mem_id']!='') {
?>
<script>
	location.href="../main/main.php";
</script>
<?
		exit;
	}
?>

<script>
	var oneDepth = 0; //1차 카테고리
	
	function main_login_check() {

		if($("#login_uid").val()==""){
			alert('아이디를 입력해주세요');
			$("#login_uid").focus();
			return false;
		}

		if($("#login_upw").val()==""){
			alert('비밀번호를 입력해주세요');
			$("#login_upw").focus();
			return false;
		}

		$("#loading_area").css({"display":"block"});

		$.ajax({
			type : "POST",
			url : "../src/login_check.php",
			data :  $("#main_login_form").serialize(),
			async : false,
			success : function(data, status)
			{
				
				var json = eval("(" + data + ")");

				if (json.result=="true") {
					location.href="../main/main.php";
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

		return false;
	}
</script>

<div id="wrap">
	<div id="inner_wrap">
		<!-- header -->
		<? include ("../include/header.php"); ?>
			<!-- //header -->
			<div style="height:20px;"></div>
			<!-- container -->
			<div id="container">
				
<form id="main_login_form" name="main_login_form">
<INPUT TYPE="hidden" id="main_go_login_url" value="">
<INPUT TYPE="hidden" NAME="auth_token" value="<?=$site_check_key?>">
				<div class="login_wrap" style="max-width:650px;">
					<h3 class="title tc mt0">투어세이프 비즈파트너 로그인</h3>
					<ul class="signup">
						<li>
							<input type="text" name="login_uid" id="login_uid" placeholder="아이디">
						</li>
						<li>
							<input type="password" name="login_upw" id="login_upw" placeholder="비밀번호" onkeydown="javascript: if (event.keyCode == 13) {main_login_check();}">
						</li>
					</ul>
					<ul class="find_idpw">
						<li><a href="../member/find_id.php">아이디찾기</a></li>
						<li><a href="../member/find_pw.php">비밀번호찾기</a></li>
					</ul>
					<p class="login_bt">
						<button type="button" class="btn" onclick="main_login_check();">로그인</button>
					</p>

					<div class="join_go">
						<a href="join.php">회원가입</a>
					</div>
</form>
				</div>
		</div>	
			<!-- //container -->
	</div>
	<!-- //inner_wrap -->
<? include ("../include/footer.php"); ?>

</div>
<!-- //wrap -->

</body>

</html>
