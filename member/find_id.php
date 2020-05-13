<? include ("../include/top_login.php"); ?>

<script>
	var oneDepth = 0; //1차 카테고리
	
	function id_search() {
		var id_name = $("#id_name").val();
		var id_email = $("#id_email").val();

		if (id_name=="") {
			alert('기업명을 입력하세요.');
			$("#id_name").focus();
			return false;
		}

		if (id_email=="") {
			alert('이메일을 입력하세요.');
			$("#id_email").focus();
			return false;
		}

		$("#loading_area").css({"display":"block"});

		$.ajax({
			type : "POST",
			url : "../src/id_search_check.php",
			data :  { "id_name" : id_name ,"id_email" : id_email, 'auth_token' : auth_token },
			success : function(data, status)
			{
				var json = eval("(" + data + ")");

				if (json.result=="true") {
					alert("요청하신 아이디는 '"+json.msg+"' 입니다.");
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
						<li class="on"><a href="find_id.php">아이디 찾기</a></li>
						<li class=""><a href="find_pw.php">비밀번호 찾기</a></li>
					</ul>

					<div class="login_wrap" style="max-width:560px;">

						<ul class="signup pt0 mb20" style="border-bottom:1px solid #000">
							<li>
								<input type="text" name="id_name" id="id_name" placeholder="기업명">
							</li>
							<li>
								<input type="text" name="id_email" id="id_email" placeholder="이메일주소">
							</li>
						</ul>

						<p class="login_bt">
							<a href="javascript:void(0);" onclick="id_search();" class="btn"><span>확인</span></a>
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
