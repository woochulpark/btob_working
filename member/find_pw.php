<? include ("../include/top_login.php"); ?>

<script>
	var oneDepth = 0; //1차 카테고리
	
	function pass_search() {
		var pass_id = $("#pass_id").val();
		var pass_name = $("#pass_name").val();
		var pass_email = $("#pass_email").val();

		if (pass_id=="") {
			alert('아이디를 입력하세요.');
			$("#pass_id").focus();
			return false;
		}
		
		if (pass_name=="") {
			alert('기업명을 입력하세요.');
			$("#pass_name").focus();
			return false;
		}

		if (pass_email=="") {
			alert('이메일을 입력하세요.');
			$("#pass_email").focus();
			return false;
		}

		$("#loading_area").css({"display":"block"});
	
		$.ajax({
			type : "POST",
			url : "../src/pass_search.php",
			data :  { "pass_id" : pass_id ,"pass_name" : pass_name, "pass_email" : pass_email, 'auth_token' : auth_token },
			success : function(data, status)
			{
				var json = eval("(" + data + ")");

				if (json.result=="true") {
					location.href="../member/find_ok.php";
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
</script>

<div id="wrap">
	<div id="inner_wrap">
		<!-- header -->
		<? include ("../include/header.php"); ?>
			<!-- //header -->
			<!-- container -->
			<div id="container">
				

				<ul class="atab two">
					<li class=""><a href="find_id.php">아이디 찾기</a></li>
					<li class="on"><a href="find_pw.php">비밀번호 찾기</a></li>
				</ul>

				<div class="login_wrap" style="max-width:560px;">

					<ul class="signup pt0 mb20" style="border-bottom:1px solid #000">
						<li>
								<input type="text" name="pass_id" id="pass_id" placeholder="아이디">
							</li>
							<li>
								<input type="text" name="pass_name" id="pass_name" placeholder="기업명">
							</li>
							<li>
								<input type="text" name="pass_email" id="pass_email" placeholder="이메일주소">
							</li>
					</ul>

					<p class="login_bt">
						<a href="javascript:void(0);" onclick="pass_search();" class="btn"><span>확인</span></a>
					</p>
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
