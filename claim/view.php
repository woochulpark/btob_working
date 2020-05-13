<? 
	include ("../include/top.php"); 
?>
<script>
	var oneDepth = 4; //1차 카테고리
	var num = "<?=$type?>";

	$(document).ready(function(){

		$(".claim").hide();
		$("#claim"+num).show();

		$(".faq_list .title").click(function() {
                $(".title").removeClass("on");
                var item = $(this);

                if (item.next().css('display') != "none") {
                    $(".answer_wrap").slideUp(200);

                } else {
                    $(".answer_wrap").slideUp(200);
                    $(this).addClass("on");
                    $(this).next(".answer_wrap").slideDown(200);
                }
            });

	});
	function f_Tab(num, el){
		$(".btab > li").removeClass("on");
		$(el).parent().addClass("on");
		$(".tab_area").hide();
		$("#tab"+num).show();
		
	}
</script>

<div id="wrap">
	<div id="inner_wrap">
		<!-- header -->
		<? include ("../include/header.php"); ?>
			<!-- //header -->
			<!-- container -->
			<div id="container">
				<!-- 1 -->
				<div id="claim1" class="claim" style="display:none;">
					<h3 class="step_tit"><strong>배상책임</strong> </h3>
					<p>보험금 청구 구비서류 안내 (배상책임)</p>
                  <ul class="faq_list mt20">

						<li>
							<p class="title"><span class="q">1.</span>보험금 청구서</p>
							<div class="answer_wrap" style="display: none;">
								<div class="answer">
									미성년자의 경우 개인정보 동의란 (또는 위임사항)에 부모님(법정대리인)이 서명
								</div>
							</div>
						</li>
						<li>
							<p class="title"><span class="q">2.</span>본인 확인용 서류</p>
							<div class="answer_wrap" style="display: none;">
								<div class="answer">
									<ul class="bul_num">
										<li>ⓐ 해외여행 : 여권사본, 출입국증명서 (여권 스탬프면 사본으로 대체 가능)</li>
										<li>ⓑ 국내여행 : 신분증사본<br>* 미성년자의 경우 등본 or 가족관계증명서 추가 첨부</li>
									</ul>
								</div>
							</div>
						</li>
						<li>
							<p class="title"><span class="q">3.</span>통장 사본</p>
							<div class="answer_wrap" style="display: none;">
								<div class="answer">
									미성년자의 경우 부모님(법정대리인) 통장사본
								</div>
							</div>
						</li>
						<?
							if($_SESSION['s_mem_id'] != 'hyecho_b2b'){
						?>
						<li>
							<p class="title"><span class="q">4.</span>목격자 서류</p>
							<div class="answer_wrap" style="display: none;">
								<div class="answer">
									<ul class="bul_num">
										<li>1) 목격자 확인서</li>
										<li>2) 목격자 확인용 서류
											<ul class="bul_num">
												<li>ⓐ 해외여행 : 여권사본, 출입국증명서 (여권 스탬프면 사본으로 대체 가능)</li>
												<li>ⓑ 국내여행 : 신분증사본<br>* 미성년자의 경우 등본 or 가족관계증명서 추가 첨부</li>
											</ul>
										</li>
									</ul>
 
								</div>
							</div>
						</li>
						<?
							}
						?>
						<li>
							<p class="title"><span class="q"><?=($_SESSION['s_mem_id'] != 'hyecho_b2b')?"5":"4";?>.</span>손해배상 증빙서류</p>
							<div class="answer_wrap" style="display: none;">
								<div class="answer">
									<ul class="bul_num">
										<li>1) 대물 배상 시 - 피해품 수리 견적서 혹은 배상 후 지불한 영수증과 입금(결제)내역 등 증빙서류</li>
										<li>2) 의료비 배상 시 - 피해자 진단서, 초진(응급)진료차트, 치료비 영수증 / 사고관련 입증서류 및 합의서</li>
									</ul>
 
								</div>
							</div>
						</li>
						<li>
							<p class="title"><span class="q"><?=($_SESSION['s_mem_id'] != 'hyecho_b2b')?"6":"5";?>.</span>주민등록 등본</p>
							<div class="answer_wrap" style="display: none;">
								<div class="answer">
									주민등록 등본
								</div>
							</div>
						</li>
					</ul>
				</div>
				<!-- //1 -->
				<!-- 2 -->
				<div id="claim2" class="claim" style="display:none;">
				<h3 class="step_tit"><strong>의료비</strong> </h3>
					<p>보험금 청구 구비서류 안내 (의료비)</p>
                  <ul class="faq_list mt20">
						<li>
							<p class="title"><span class="q">1.</span>보험금 청구서</p>
							<div class="answer_wrap" style="display: none;">
								<div class="answer">
									미성년자의 경우 개인정보 동의란 (또는 위임사항)에 부모님(법정대리인)이 서명
								</div>
							</div>
						</li>
						<li>
							<p class="title"><span class="q">2.</span>본인 확인용 서류</p>
							<div class="answer_wrap" style="display: none;">
								<div class="answer">
									<ul class="bul_num">
										<li>ⓐ 해외여행 : 여권사본, 출입국증명서 (여권 스탬프면 사본으로 대체 가능)</li>
										<li>ⓑ 국내여행 : 신분증사본<br>* 미성년자의 경우 등본 or 가족관계증명서 추가 첨부</li>
									</ul>
								</div>
							</div>
						</li>
						<li>
							<p class="title"><span class="q">3.</span>통장 사본</p>
							<div class="answer_wrap" style="display: none;">
								<div class="answer">
									미성년자의 경우 부모님(법정대리인) 통장사본
								</div>
							</div>
						</li>
						<li>
							<p class="title"><span class="q">4.</span>의료비 관련 제출 서류</p>
							<div class="answer_wrap" style="display: none;">
								<div class="answer">
									<ul class="bul_num">
										<li>1) 목격자 확인서</li>
										<li>2) 목격자 확인용 서류
											<ul class="bul_num">
												<li>ⓐ 해외치료시 : 치료비 영수증(원본), 진단서(medical record) / 초진기록 or 의사소견서</li>
												<li>ⓑ 국내치료시 : 진료 내역서, 영수증 사본</li>
												<li>ⓒ 해외치료시 진단서, 영수증 원본 없는 경우<br>: 진료 내역서, 영수증 사본 제출, 목격자 확인서(여행중 동행자 또는 가이드 등의 목격자 확인서와 함께 여권사본 및 출입국 스탬프를 함께 첨부)</li>
												<li>* 진단서, 통원확인서, 처방전, 진료확인서, 소견서, 수술확인서, 진료차트 등에는 진단명이 기재되어 있어야 합니다.</li>
												<li>* 사고내용, 특성, 상품(보장내역)에 따라 추가 심사서류를 요구할 수 있습니다.</li>
											</ul>
										</li>
									</ul>
 
								</div>
							</div>
						</li>
						
					</ul>
				</div>
				<!-- //2 -->

				<!-- 3 -->
				<div id="claim3" class="claim" style="display:none;">
				<h3 class="step_tit"><strong>휴대품 도난</strong> </h3>
					<p>보험금 청구 구비서류 안내 (휴대품 도난)</p>
                  <ul class="faq_list mt20">
						<li>
							<p class="title"><span class="q">1.</span>보험금 청구서</p>
							<div class="answer_wrap" style="display: none;">
								<div class="answer">
									미성년자의 경우 개인정보 동의란 (또는 위임사항)에 부모님(법정대리인)이 서명
								</div>
							</div>
						</li>
						<li>
							<p class="title"><span class="q">2.</span>본인 확인용 서류</p>
							<div class="answer_wrap" style="display: none;">
								<div class="answer">
									<ul class="bul_num">
										<li>ⓐ 해외여행 : 여권사본, 출입국증명서 (여권 스탬프면 사본으로 대체 가능)</li>
										<li>ⓑ 국내여행 : 신분증사본<br>* 미성년자의 경우 등본 or 가족관계증명서 추가 첨부</li>
									</ul>
								</div>
							</div>
						</li>
						<li>
							<p class="title"><span class="q">3.</span>통장 사본</p>
							<div class="answer_wrap" style="display: none;">
								<div class="answer">
									미성년자의 경우 부모님(법정대리인) 통장사본
								</div>
							</div>
						</li>
						<li>
							<p class="title"><span class="q">4.</span>목격자 서류</p>
							<div class="answer_wrap" style="display: none;">
								<div class="answer">
									<ul class="bul_num">
										<li>1) 목격자 확인서</li>
										<li>2) 목격자 확인용 서류
											<ul class="bul_num">
												<li>ⓐ 해외여행 : 여권사본, 출입국증명서 (여권 스탬프면 사본으로 대체 가능)</li>
												<li>ⓑ 국내여행 : 신분증사본<br>* 미성년자의 경우 등본 or 가족관계증명서 추가 첨부</li>
											</ul>
										</li>
									</ul>
 
								</div>
							</div>
						</li>
						<li>
							<p class="title"><span class="q">5.</span>피해품 내역서 및 영수증</p>
							<div class="answer_wrap" style="display: none;">
								<div class="answer">
									<ul class="bul_num">
										<li>1) 물품 영수증 (없는 경우 보험금청구서 상에 상품명, 구입년월, 금액 기재)</li>
										<li>2) 항공사 사고일 경우
											<ul class="bul_num">
												<li>ⓐ 항공사에서 보상받은 경우 : 항공사 처리확인서</li>
												<li>ⓑ 항공사에서 보상받지 못한 경우 : 항공사 보상불가 확인서</li>
											</ul>
										</li>
									</ul>

									<p class="pt20">※ 휴대폰을 제외한 일반 mp3 나 카메라의 경우에는 최근에 산것은 영수증을 꼭 준비 해주셔야 합니다.<br>
  몇년전에 산 물건일 경우에는 어느정도의 감안이 되오니 일단 영수증은 최대한 준비해 주시는게 좋습니다.<br>
※ 도난당한 물품이 핸드폰일 경우 해당 통신사의 대리점에 가셔서 서류를 발급 받고 제출하셔야 합니다.<br>
SK-이용계약등록사항증명서 / KT-원부증명서 / LG-가입사실확인서</p>
									
									<p class="pt20">※ 도난당한 물품이 핸드폰일 경우 폰케어 보험 가입된 고객 중, SK텔레콤 통신사 가입 고객은 동일기종으로 기기변경 할 경우 변경시 발생하는 자부담금(본인부담금) 확인되는 서류가 추가로 들어와야 합니다.<br>
자부담금(본인부담금) 서류는 통신사가 지정해 주는 지정대리점에서 발급가능(대리점마다 상이할 수 있음)하며 새로 개통하는 서류에 자부담금(본인부담금)을 기재하도록 요청 하거나, 혹 지정 대리점에서 관련 서류 발급이 어렵다고 할 경우 지정대리점 직원 명함에 자부담금(본인부담금)작성한 서류 보내면 됩니다.</p>
 
								</div>
							</div>
						</li>
						<li>
							<p class="title"><span class="q">6.</span>경찰서 확인서 (Police Report)</p>
							<div class="answer_wrap" style="display: none;">
								<div class="answer">
									


									<p>폴리스 리포트 사본<br>※ 수하물 도난인 경우는 리포트 불필요</p>
									
								
								</div>
							</div>
						</li>
						
					</ul>
				</div>
				<!-- //3 -->

				<!-- 4 -->
				<div id="claim4" class="claim" style="display:none;">
				<h3 class="step_tit"><strong>휴대품 파손</strong> </h3>
					<p>보험금 청구 구비서류 안내 (휴대품 파손)</p>
                  <ul class="faq_list mt20">
						<li>
							<p class="title"><span class="q">1.</span>보험금 청구서</p>
							<div class="answer_wrap" style="display: none;">
								<div class="answer">
									미성년자의 경우 개인정보 동의란 (또는 위임사항)에 부모님(법정대리인)이 서명
								</div>
							</div>
						</li>
						<li>
							<p class="title"><span class="q">2.</span>본인 확인용 서류</p>
							<div class="answer_wrap" style="display: none;">
								<div class="answer">
									<ul class="bul_num">
										<li>ⓐ 해외여행 : 여권사본, 출입국증명서 (여권 스탬프면 사본으로 대체 가능)</li>
										<li>ⓑ 국내여행 : 신분증사본<br>* 미성년자의 경우 등본 or 가족관계증명서 추가 첨부</li>
									</ul>
								</div>
							</div>
						</li>
						<li>
							<p class="title"><span class="q">3.</span>통장 사본</p>
							<div class="answer_wrap" style="display: none;">
								<div class="answer">
									미성년자의 경우 부모님(법정대리인) 통장사본
								</div>
							</div>
						</li>
						<?
							if($_SESSION['s_mem_id'] != 'hyecho_b2b'){
						?>
						<li>
							<p class="title"><span class="q">4.</span>목격자 서류</p>
							<div class="answer_wrap" style="display: none;">
								<div class="answer">
									<ul class="bul_num">
										<li>1) 목격자 확인서</li>
										<li>2) 목격자 확인용 서류
											<ul class="bul_num">
												<li>ⓐ 해외여행 : 여권사본, 출입국증명서 (여권 스탬프면 사본으로 대체 가능)</li>
												<li>ⓑ 국내여행 : 신분증사본<br>* 미성년자의 경우 등본 or 가족관계증명서 추가 첨부</li>
												<li>※ 목격자 없을 시 청구서 사고내용에 “목격자 없음” 이라고 필수 작성</li>
											</ul>
										</li>
									</ul>
 
								</div>
							</div>
						</li>
						<?
							}
						?>
						<li>
							<p class="title"><span class="q"><?=($_SESSION['s_mem_id'] != 'hyecho_b2b')?"5":"4";?>.</span>피해품 내역서 및 영수증</p>
							<div class="answer_wrap" style="display: none;">
								<div class="answer">
									<ul class="bul_num">
										<li>1) 공항에서 파손시
											<ul class="bul_num">
												<li>ⓐ 항공사에서 보상받은 경우 : 항공사 처리 확인서</li>
												<li>ⓑ 항공사에서 보상받지 못한 경우 : 항공사 보상불가 확인서</li>
											</ul>
										</li>
										<li>※ 파손된 물품이 핸드폰일 경우
											<ul class="bul_num">
												<li>ⓐ SK-이용계약등록사항증명서 / KT-원부증명서 / LG-가입사실확인서 (해당 통신사의 고객센터 혹은 대리점에서 발급 가능)</li>
												<li>ⓑ 파손보험가입여부를 원부증명서 또는 가입사실증명서 상단에 기재</li>
											</ul>
										</li>
									</ul>
 
								</div>
							</div>
						</li>
						<li>
							<p class="title"><span class="q"><?=($_SESSION['s_mem_id'] != 'hyecho_b2b')?"6":"5";?>.</span>수리비 관련 서류</p>
							<div class="answer_wrap" style="display: none;">
								<div class="answer">
									<ul class="bul_num">
										<li>1) 수리 가능한 경우
											<ul class="bul_num">
												<li>ⓐ 수리영수증(수리한 경우) </li>
												<li>ⓑ 수리견적서(파손 되어 수리 가능한 경우)</li>
											</ul>
										</li>
										<li>2) 수리 불가능한 경우
											<ul class="bul_num">
												<li>ⓐ 수리 불능확인서</li>
											</ul>
										</li>
									</ul>
 
								</div>
							</div>
						</li>
						<li>
							<p class="title"><span class="q"><?=($_SESSION['s_mem_id'] != 'hyecho_b2b')?"7":"6";?>.</span>물품사진</p>
							<div class="answer_wrap" style="display: none;">
								<div class="answer">
									휴대품이 파손 되어 보관 중인 경우
								</div>
							</div>
						</li>
						
					</ul>
				</div>
				<!-- //4 -->

				<!-- 5 -->
				<div id="claim5" class="claim" style="display:none;">
				<h3 class="step_tit"><strong>여행불편보상</strong> </h3>
					<p>보험금 청구 구비서류 안내 (여행불편보상)</p>
                  <ul class="faq_list mt20">
						<li>
							<p class="title"><span class="q">1.</span>보험금 청구서</p>
							<div class="answer_wrap" style="display: none;">
								<div class="answer">
									미성년자의 경우 개인정보 동의란 (또는 위임사항)에 부모님(법정대리인)이 서명
								</div>
							</div>
						</li>
						<li>
							<p class="title"><span class="q">2.</span>본인 확인용 서류</p>
							<div class="answer_wrap" style="display: none;">
								<div class="answer">
									<ul class="bul_num">
										<li>ⓐ 해외여행 : 여권사본, 출입국증명서 (여권 스탬프면 사본으로 대체 가능)</li>
										<li>ⓑ 국내여행 : 신분증사본<br>* 미성년자의 경우 등본 or 가족관계증명서 추가 첨부</li>
										<li>ⓒ e-ticket</li>
									</ul>
								</div>
							</div>
						</li>
						<li>
							<p class="title"><span class="q">3.</span>통장 사본</p>
							<div class="answer_wrap" style="display: none;">
								<div class="answer">
									미성년자의 경우 부모님(법정대리인) 통장사본
								</div>
							</div>
						</li>
						<li>
							<p class="title"><span class="q">4.</span>항공사 확인서</p>
							<div class="answer_wrap" style="display: none;">
								<div class="answer">
									항공사 확인서
								</div>
							</div>
						</li>
						<li>
							<p class="title"><span class="q">5.</span>손해 입증 자료</p>
							<div class="answer_wrap" style="display: none;">
								<div class="answer">
									<p>구입 일시/내역/장소가 확인 가능한 영수증에 한함</p>
									<ul class="bul_num">
										<li>① 결항/지연/취소/과적에 의한 탑승거부로 4시간 내에 대체(항공)수단이 제공되지 못한 경우
											<ul class="bul01">
												<li>- 식사, 간식, 전화통화 영수증, 숙박비, 숙박시설에 대한 교통비</li>
												<li>- 수화물이 다른 항공편으로 출발한 경우 비상 의복 및 필수품 구입 비용 영수증 (단, 숙박이 필요한 경우에 한함)</li>
											</ul>
										</li>
										<li>②  수화물이 6시간 내에 도착하지 못한 경우
											<ul class="bul01">
												<li>- 비상 의복과 필수품 구입 비용 영수증</li>
											</ul>
										</li>
										<li>③  수화물이 24시간내에 도착하지 못한 경우
											<ul class="bul01">
												<li>- 예정된 도착지에 도착 후 120시간 내에 발생한 의복과 필수품 등의 구입 비용 영수증</li>
											</ul>
										</li>
										<li>※  발생 영수증의 경우 반드시 구입 일시가 기재된 영수증이어야 합니다.</li>
										<li>※  항공사 확인서의 경우 결항, 지연, 과적에 의한 탑승거부 등 항공편 또는 수화물의 지연사유와 지연된 시간이 반드시 기재되어 있어야 합니다. <br>(항공사 담당자 및 연락처가 기재되어 있지 않을 경우에는 서류 여백에 해당 사항을 별도 기재바랍니다.)</li>
									</ul>
 
								</div>
							</div>
						</li>
						
						
					</ul>
				</div>
				<!-- //5 -->

				<!-- 6 -->
				<div id="claim6" class="claim" style="display:none;">
				<h3 class="step_tit"><strong>여권분실</strong> </h3>
					<p>보험금 청구 구비서류 안내 (여권분실)</p>
                  <ul class="faq_list mt20">
						<li>
							<p class="title"><span class="q">1.</span>보험금 청구서</p>
							<div class="answer_wrap" style="display: none;">
								<div class="answer">
									미성년자의 경우 개인정보 동의란 (또는 위임사항)에 부모님(법정대리인)이 서명
								</div>
							</div>
						</li>
						<li>
							<p class="title"><span class="q">2.</span>여권 관련 서류</p>
							<div class="answer_wrap" style="display: none;">
								<div class="answer">
									<ul class="bul_num">
										<li>1) 여권 발급 후 지불 영수증</li>
										<li>2) 여권 사진 (신분증으로 대체 가능)</li>
										<li>3) 단수여권 발급받은 경우 지불 영수증</li>
									</ul>
								</div>
							</div>
						</li>
						<li>
							<p class="title"><span class="q">3.</span>통장 사본</p>
							<div class="answer_wrap" style="display: none;">
								<div class="answer">
									미성년자의 경우 부모님(법정대리인) 통장사본
								</div>
							</div>
						</li>
						
					</ul>
				</div>
				<!-- //6 -->
				<?
					if($_SESSION['s_mem_id'] != 'hyecho_b2b'){
				?>
				<h3 class="step_tit"><strong>청구 양식 다운로드</strong> (Download)</h3>

				<div class="data_down">
					<ul id="tab1" class="tab_area">
						<li><a href="../lib/pdf_download.php?type=1"><span>CHUBB 가이드확인서</span></a></li>
						<li><a href="../lib/pdf_download.php?type=2"><span>CHUBB 목격자확인서</span></a></li>
						<li><a href="../lib/pdf_download.php?type=3"><span>CHUBB 보험금청구서</span></a></li>
					</ul>
				</div>
				<?
				} else {
					
					if($type == "1" || $type == "4" || $type=="3"){
				?>
					<h3 class="step_tit"><strong>청구 양식 다운로드</strong> (Download)</h3>

						<div class="data_down">
							<ul id="tab1" class="tab_area">
								<li><a href="../lib/pdf_download.php?type=4"><span>물보험 개인정보 동의서</span></a></li>
								<li><a href="../lib/pdf_download.php?type=5"><span>물보험 사고 확인서</span></a></li>
								<li><a href="../lib/pdf_download.php?type=6"><span>물보험 청구서</span></a></li>
							</ul>
						</div>
				<?
						//배상책임, 휴대폰 파손, 휴대품 도난(mg) 		
					} elseif($type == "2"){
				?>
					<h3 class="step_tit"><strong>청구 양식 다운로드</strong> (Download)</h3>

						<div class="data_down">
							<ul id="tab1" class="tab_area">
								<li><a href="../lib/pdf_download.php?type=7"><span>인보험 개인정보 동의서</span></a></li>
								<li><a href="../lib/pdf_download.php?type=8"><span>인보험 청구서</span></a></li>
								<!--li><a href="../lib/pdf_download.php?type=6"><span>물보험 청구서</span></a></li-->
							</ul>
						</div>
				<?
					}// 의료비 (mg)
				}
				?>
		</div>
		<!-- //container -->
	</div>
	<!-- //inner_wrap -->
	<? include ("../include/footer.php"); ?>
</div>
<!-- //wrap -->


</body>

</html>
