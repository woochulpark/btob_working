<? include ("../include/top.php"); ?>

<script>
	var oneDepth = 0; //1차 카테고리
	$(document).ready(function() {
		$(".join_step > ol > li:nth-child(3)").addClass("on");
	});
</script>

<div id="wrap">
	<div id="inner_wrap">
		<!-- header -->
		<?  include ("../include/header.php"); ?>
			<!-- //header -->
					 <!-- s : container -->
    <section id="container">
			<div style="height:40px;"></div>
				<!--div class="join_step">
					<ol class="three">
						<li><span class="ico"><span>1</span></span><span class="txt">약관동의</span></li>
						<li><span class="ico "><span>2</span></span><span class="txt">정보입력</span></li>
						<li><span class="ico "><span>3</span></span><span class="txt">가입완료</span></li>
					</ol>
				</div-->

				<p class="member_ok"><strong><?=$uid?></strong>님 회원가입을 축하드립니다.</p>
				<p class="tc f115"><strong class="point_c">관리자 승인</strong>으로 회원이 될 수 있습니다.</p>
				<div class="btn-tc">
					<a href="login.php" class="btnStrong m_block"><span>로그인</span></a>
				</div>
   

		</section>	
			<!-- //container -->
	</div>
	<!-- //inner_wrap -->
<? include ("../include/footer.php"); ?>

</div>
<!-- //wrap -->

</body>

</html>
