<div class="pop_con w780">
        <div class="pop_con_inner">
            <div class="pop_head">
                <p class="tit" id="pop_title">약관 및 고지사항을 체크하여 주세요.</p>
                <p class="btn_close" onclick="close_pop('pop_wrap');"><img src="../img/common/btn_close.png" alt="닫기"></p>
            </div>
            <div class="pop_body pdT25">
                <div class="con_wrap">
                    <div id="section1">
                        <h2>여행 출발 전 고지사항</h2>
						<?
							if($_GET['tripType'] == '2'){
						?>
                        <ul>
                            <li>
                                현재 계신 곳이나 주로 거주하는 지역이 해외인가요?
                                <div>
                                    <span class="mgR20">
                                        <input type="radio" id="answer1" name="check_type_1" value="Y" />
                                        <label for="answer1" class="radio_bx"><span></span>예</label>
                                    </span>
                                    <span><input type="radio" id="answer2" name="check_type_1" value="N" />
                                        <label for="answer2" class="radio_bx"><span></span>아니오</label>
                                    </span>
                                </div>
                            </li>
                            <li>
                                최근 3개월 내에 <span class="c_red">입원, 수술, 질병확인</span> <span class="c_blue">[<a href="javascript:popup('../src/popup_disease.html','ppop','400', '231')">보기</a>]</span> 을 받은 사실이 있나요?
                                <div>
                                    <span class="mgR20">
                                        <input type="radio" id="answer3" name="check_type_2" value="Y" />
                                        <label for="answer3" class="radio_bx"><span></span>예</label>
                                    </span>
                                    <span><input type="radio" id="answer4" name="check_type_2" value="N" />
                                        <label for="answer4" class="radio_bx"><span></span>아니오</label>
                                    </span>
                                </div>
                            </li>
                            <li>
                                위험한 운동이나 전문적인 체육활동을 목적으로 출국하시나요?
                                <div>
                                    <span class="mgR20">
                                        <input type="radio" id="answer5" name="check_type_3" value="Y" />
                                        <label for="answer5" class="radio_bx"><span></span>예</label>
                                    </span>
                                    <span><input type="radio" id="answer6" name="check_type_3" value="N" />
                                        <label for="answer6" class="radio_bx"><span></span>아니오</label>
                                    </span>
                                </div>
                            </li>
                            <li>
                                여행 지역이 <span class="c_red">여행금지국가</span> <span class="c_blue">[<a href="javascript:popup('../src/popup_country.html', 'ppop1', '560', '530')">보기</a>]</span> 인가요?
                                <div>
                                    <span class="mgR20">
                                        <input type="radio" id="answer7" name="check_type_4" value="Y" />
                                        <label for="answer7" class="radio_bx"><span></span>예</label>
                                    </span>
                                    <span>
                                        <input type="radio" id="answer8" name="check_type_4" value="N" />
                                        <label for="answer8" class="radio_bx"><span></span>아니오</label>
                                    </span>
                                </div>
                            </li>
                        </ul>
						<?
						} else if($_GET['tripType'] == '1'){
						?>
							<ul>
                            <li>
                                최근 5년 내에 <span class="c_red">특정질병</span><span class="c_blue">[<a href="javascript:popup('../src/popup_spe_disease.html', 'ppop', '400', '231')">보기</a>]</span>에 대한 확진 또는 치료를 받은 적이 있나요?
                                <div>
                                    <span class="mgR20">
                                        <input type="radio" id="answer1" name="check_type_1" value="Y" />
                                        <label for="answer1" class="radio_bx"><span></span>예</label>
                                    </span>
                                    <span><input type="radio" id="answer2" name="check_type_1" value="N" />
                                        <label for="answer2" class="radio_bx"><span></span>아니오</label>
                                    </span>
                                </div>
                            </li>
                            <li>
                                기능장애 또는 유전성 질환을 갖고 계시나요?
                                <div>
                                    <span class="mgR20">
                                        <input type="radio" id="answer3" name="check_type_2" value="Y" />
                                        <label for="answer3" class="radio_bx"><span></span>예</label>
                                    </span>
                                    <span><input type="radio" id="answer4" name="check_type_2" value="N" />
                                        <label for="answer4" class="radio_bx"><span></span>아니오</label>
                                    </span>
                                </div>
                            </li>
                            <li>
                                현재 외국에 거주중이거나 가입하는 장소가 외국이신가요?
                                <div>
                                    <span class="mgR20">
                                        <input type="radio" id="answer5" name="check_type_3" value="Y" />
                                        <label for="answer5" class="radio_bx"><span></span>예</label>
                                    </span>
                                    <span><input type="radio" id="answer6" name="check_type_3" value="N" />
                                        <label for="answer6" class="radio_bx"><span></span>아니오</label>
                                    </span>
                                </div>
                            </li>
                            <li>
                                금강산, 개성공단 등 북한지역으로 여행을 가시나요?
                                <div>
                                    <span class="mgR20">
                                        <input type="radio" id="answer7" name="check_type_4" value="Y" />
                                        <label for="answer7" class="radio_bx"><span></span>예</label>
                                    </span>
                                    <span>
                                        <input type="radio" id="answer8" name="check_type_4" value="N" />
                                        <label for="answer8" class="radio_bx"><span></span>아니오</label>
                                    </span>
                                </div>
                            </li>
							<li>
                                여행중 직업, 직무 또는 동호회 활동으로 <span class="c_red">위험한 레포츠 등</span><span class="c_blue">[<a href="javascript:popup('../src/popup_danger_sports.html', 'ppop1', '400', '231')">보기</a>]</span>을 하시나요?
                                <div>
                                    <span class="mgR20">
                                        <input type="radio" id="answer9" name="check_type_5" value="Y" />
                                        <label for="answer7" class="radio_bx"><span></span>예</label>
                                    </span>
                                    <span>
                                        <input type="radio" id="answer10" name="check_type_5" value="N" />
                                        <label for="answer8" class="radio_bx"><span></span>아니오</label>
                                    </span>
                                </div>
                            </li>
                        </ul>
						<?
						}
						?>
                        <ul>
                            <li>
                                <input type="checkbox" id="an_all" name="" value="" />								
                                <label for="an_all" class="check_bx"><span></span> 모든 항목 아니오</label>								
                            </li>
                        </ul>
                    </div>
                    <div id="section2">
                        <h2>가입/이용동의</h2>
                        <ul>
                            <li><span class="c_red">[필수]</span> 이용약관</li>
                            <li><a href="javascript:void[0];" onclick="popup('../src/popup_terms.html', 'ppop3','800', '600')" class="btn_s2">내용 확인</a></li>
                            <li>
                                <input type="checkbox" id="agree1" name="chk1" value="" />
                                <label for="agree1" class="check_bx"><span></span> 동의합니다.</label>
                            </li>
                        </ul>
                        <ul>
                            <li><span class="c_red">[필수]</span> 보험약관 
							<?
								if($_GET['tripType'] == 2){
							?>
							<a href="https://ts.toursafe.co.kr/doc/overseas.pdf" target="_blank" class="btn_s2 mgL10">해외여행보험 약관</a>
							<?
								} else if($_GET['tripType'] == 1){
							?>
								<a href="https://ts.toursafe.co.kr/doc/domestic.pdf" target="_blank" class="btn_s2 mgL10">국내여행보험 약관</a>
							<?
								}	
							?>
							</li>
                            <li><a href="javascript:void[0];" onclick="popup('../src/popup_insurance.html', 'ppop4', '600', '200')" class="btn_s2">내용 확인</a></li>
                            <li>
                                <input type="checkbox" id="agree2" name="chk2" value="" />
                                <label for="agree2" class="check_bx"><span></span> 동의합니다.</label>
                            </li>
                        </ul>
                        <ul>
                            <li><span class="c_red">[필수]</span> 단체규약</li>
                            <li><a href="javascript:void[0];" onclick="popup('../src/popup_rule.html', 'ppop5', '800', '600')" class="btn_s2">내용 확인</a></li>
                            <li>
                                <input type="checkbox" id="agree3" name="chk3" value="" />
                                <label for="agree3" class="check_bx"><span></span> 동의합니다.</label>
                            </li>
                        </ul>
                        <ul>
                            <li><span class="c_red">[필수]</span> 개인정보 수집 및 이용</li>
                            <li><a href="javascript:void[0];" onclick="popup('../src/popup_privacy.html', 'ppop6', '800', '600')" class="btn_s2">내용 확인</a></li>
                            <li>
                                <input type="checkbox" id="agree4" name="chk4" value="" />
                                <label for="agree4" class="check_bx"><span></span> 동의합니다.</label>
                            </li>
                        </ul>
                        <ul>
                            <li>
                                <input type="checkbox" id="ag_all" name="" value="" />
                                <label for="ag_all" class="check_bx"><span></span> 전체 약관에 동의합니다.</label>
                            </li>
                        </ul>
                    </div>
                </div>
            </div><!-- e : pop_body -->
            <div class="pop_foot">
                <button type="button" id="check_contract" class="btn_popup_apply w20">확인</button>
            </div>
        </div>
    </div>
	<script type="text/javascript">
    function popup(src, popn, widthv, heightv) { 	
         var popa = window.open(src, popn, "width="+widthv+", height="+heightv+", toolbar=no, location=no, directories=no, status=no,  resizable=auto,  scrollbars=no, top=0, left=0"); 
		 popa.focus();
    }   	

		$('#an_all').on('click',function(){
			if ($('input[id^="answer"]:odd:checked').length != $('input[id^="answer"]:odd').length) {
				$('input[id^="answer"]:odd').prop('checked',true);
				$('input[id^="answer"]:even').prop('checked',false);
				$('#an_all').prop('checked', true);
			} else {
				$('input[id^="answer"]:odd').prop('checked',false);
				$('input[id^="answer"]:even').prop('checked',false);
				$('#an_all').prop('checked', false);
			}
		});

		$('input[id^="answer"]:odd').on('click',function(){
			if ($('input[id^="answer"]:odd:checked').length != $('input[id^="answer"]:odd').length) {
				$('#an_all').prop('checked', false);
			} else {
				$('#an_all').prop('checked', true);
			}
		});

		$('input[id^="answer"]:even').on('click',function(){
			if ($('input[id^="answer"]:even:checked').length > 0) {
				$('#an_all').prop('checked', false);
			} else {
				$('#an_all').prop('checked', true);
			}
		});

		$('#ag_all').on('click',function(){
			if($('input[name^="chk"]:checked').length != $('input[name^="chk"]').length){
				$('input[name^="chk"]').prop('checked',true);
				$('#ag_all').prop('checked',true);
			} else {
				$('input[name^="chk"]').prop('checked',false);
				$('#ag_all').prop('checked',false);
			}
		});

		$('input[name^="chk"]').on('click',function(){			
			if($('input[name^="chk"]:checked').length != $('input[name^="chk"]').length){
				$('#ag_all').prop('checked',false);
			} else {
				$('#ag_all').prop('checked',true);
			}
		});

		$('#check_contract').on('click',function(){
			var chk_an = 'N';
			var chk_ag = 'N';
		
			if ($('input[id^="answer"]:odd:checked').length != $('input[id^="answer"]:odd').length) {
				alert('여행 출발전 고지사항을 체크해 주세요.');
				return false;
			} else {
					$('input[name="notice_confirm"]').val('Y');
					chk_an = 'Y';
			}
			if($('input[name^="chk"]:checked').length != $('input[name^="chk"]').length){
				alert('약관 사항에 동의해 주세요.');
				return false;
			} else {			
					$('input[name="contract_confirm"]').val('Y');
					chk_ag = 'Y';
			}
			
			if(chk_an != 'N' && chk_ag != 'N'){
				alert('모든 사항에 체크 및 동의 해주셨습니다');
				$('#bulk_confirm').prop('checked',true);	
				close_pop('pop_wrap');
			}

		});
</script>