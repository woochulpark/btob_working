<? include ("../include/top.php"); ?>
<script>
var oneDepth = 10; //1차 카테고리
	

</script>

<div id="wrap" class="main_wrap">
	<div id="inner_wrap">
		<!-- header -->
		<? include ("../include/header.php"); ?>
			<!-- //header -->
			<!-- container -->
			<div id="container">
				<? print_r($_SESSION); ?>
				<div class="mobile_notice">
					<? include ("notice.php"); ?>
				</div>
				<?
				if ($row_mem_info['uid'] != "hana" && $row_mem_info['uid'] !="hanamembers" && $row_mem_info['mem_type'] !="1") {
					//print_r($_SESSION);
    		    ?>
				<div class="main_banner">
					<ul>
						<li><div class="box"><img src="../img/main/banner01.jpg" alt=""><p class="txt"><strong>국내여행자 보험</strong>일반여행/수학여행/세미나/출장/수련회
최대 1개월까지 국내 전국일원</p></div>
						
							<p class="bt"><a href="../trip/01.php?tripType=1">가입하기</a></p>
							
						</li>
						<li><div class="box"><img src="../img/main/banner02.jpg" alt=""><p class="txt"><strong>해외여행자 보험</strong>일반여행/배낭여행/세미나/연수 등
최대 3개월까지 해외체류 </p></div>
							<p class="bt"><a href="../trip/02_0.php?tripType=2">가입하기</a></p>
						</li>
						<li><div class="box"><img src="../img/main/banner03.jpg" alt=""><p class="txt"><strong>장기체류자 보험</strong>유학/어학연수/주제원/워킹홀리데이 등
3개월 이상 해외체류 </p></div>
							
							<p class="bt"><a href="../study_abroad/01.php">가입하기</a></p>
						
						</li>
						
					</ul>
				</div>
 				<?
                }
                ?>
				<div class="web_notice">
					<? include ("notice.php"); ?>
				</div>

			</div>

	</div>
	<!-- //container -->
<? include ("../include/footer.php"); ?>
</div>
<!-- //wrap -->
</body>

</html>
