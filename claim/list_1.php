<? 
	include ("../include/top.php"); 
?>
<script>
	var oneDepth = 4; //1차 카테고리
</script>

<div id="wrap">
	<div id="inner_wrap">
		<!-- header -->
		<? include ("../include/header.php"); ?>
			<!-- //header -->
			<!-- container -->
			<div id="container">
				
                   <ul class="claim_list">
						<li>
							<dl>
								<dt>배상책임<span class="ico"><img src="../img/pages/claim_ico01.png" alt=""></span></dt>
								<dd>
									<ul class="bul02">
										<li>배상책임 청구 구비서류</li>
									</ul>
								</dd>
							</dl>
							<p class="bt"><a href="view.php?type=1">자세히 보기</a></p>
						</li>
						<li>
							<dl>
								<dt>의료비<span class="ico"><img src="../img/pages/claim_ico02.png" alt=""></span></dt>
								<dd>
									<ul class="bul02">
										<li>의료비 청구 구비서류(국내/해외)</li>
										<li>해외 교통사고 의료비 청구 구비서류 </li>
									</ul>
								</dd>
							</dl>
							<p class="bt"><a href="view.php?type=2">자세히 보기</a></p>
						</li>
						<?
							if($_SESSION['s_mem_id'] != 'hyecho_b2b' && $_SESSION['s_mem_id'] != 'followme_b2b'){
						?>
						<li>
							<dl>
								<dt>휴대폰 파손<span class="ico"><img src="../img/pages/claim_ico04.png" alt=""></span></dt>
								<dd>
									<ul class="bul02">
										<li>휴대품 파손 청구 구비서류</li>
										<li>항공사 파손 청구 구비서류 </li>
									</ul>
								</dd>
							</dl>
							<p class="bt"><a href="view.php?type=4">자세히 보기</a></p>
						</li>
						<?
						   } else {
						?>
							<li>
							<dl>
								<dt>휴대품 파손<span class="ico"><img src="../img/pages/claim_ico04.png" alt=""></span></dt>
								<dd>
									<ul class="bul02">
										<li>휴대품 파손 청구 구비서류</li>
										<li>항공사 파손 청구 구비서류 </li>
									</ul>
								</dd>
							</dl>
							<p class="bt"><a href="view.php?type=4">자세히 보기</a></p>
						</li>
						<?
							}
							if($_SESSION['s_mem_id'] != 'hyecho_b2b' && $_SESSION['s_mem_id'] != 'followme_b2b'){
						?>
						<li>
							<dl>
								<dt>여행불편보상<span class="ico"><img src="../img/pages/claim_ico05.png" alt=""></span></dt>
								<dd>
									<ul class="bul02">
										<li>비상 의복과 필수품 구입 비용  영수증</li>
									</ul>
								</dd>
							</dl>
							<p class="bt"><a href="view.php?type=5">자세히 보기</a></p>
						</li>
						<?
							}

							if($_SESSION['s_mem_id'] != 'hyecho_b2b' && $_SESSION['s_mem_id'] != 'followme_b2b'){
						?>
						<li>
							<dl>
								<dt>휴대폰 도난<span class="ico"><img src="../img/pages/claim_ico03.png" alt=""></span></dt>
								<dd>
									<ul class="bul02">
										<li>휴대품 도난 청구 구비서류</li>
										<li>휴대폰 도난 청구 구비서류</li>
										<li>항공사 분실(도난)</li>
									</ul>
								</dd>
							</dl>
							<p class="bt"><a href="view.php?type=3">자세히 보기</a></p>
						</li>
						<?
							} else {
						?>
							<li>
							<dl>
								<dt>휴대품 도난<span class="ico"><img src="../img/pages/claim_ico03.png" alt=""></span></dt>
								<dd>
									<ul class="bul02">
										<li>휴대품 도난 청구 구비서류</li>
										<li>휴대폰 도난 청구 구비서류</li>
										<li>항공사 분실(도난)</li>
									</ul>
								</dd>
							</dl>
							<p class="bt"><a href="view.php?type=3">자세히 보기</a></p>
						</li>
						<?
							}
							if($_SESSION['s_mem_id'] != 'hyecho_b2b' && $_SESSION['s_mem_id'] != 'followme_b2b'){
						?>
						<li>
							<dl>
								<dt>여권분실<span class="ico"><img src="../img/pages/claim_ico06.png" alt=""></span></dt>
								<dd>
									<ul class="bul02">
										<li>여권 발급 후 지불 영수증</li>
										<li>여권 사진 (신분증으로 대체 가능)</li>
									</ul>
								</dd>
							</dl>
							<p class="bt"><a href="view.php?type=6">자세히 보기</a></p>
						</li>
						<?
							}	
						?>
				   </ul>     



		
		</div>
		<!-- //container -->
	</div>
	<!-- //inner_wrap -->
	<? include ("../include/footer.php"); ?>
</div>
<!-- //wrap -->


</body>

</html>
