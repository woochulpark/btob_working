<? include ("../include/top.php"); ?>
<? echo "<!--";
	print_r($_SESSION);
	echo "-->";
?>
<script>
var oneDepth = 10; //1차 카테고리
</script>
<script type="text/javascript">
	var oneDepth = 1; //1차 카테고리
	
	var tripType;
	var total_won = 0;
	var month_limit;

	function view_reset() {
		$(".join_step > ol > li:nth-child(1)").addClass("on");
		$(".join_step > ol > li:nth-child(2)").removeClass("on");
		$(".join_type").hide();
		$(".execute_bt > button").removeClass("disable");
		$(".last_selec, #showplan").hide();
		$(".hiddenplan").show();

		$(".total_won_1").html("0");
		$(".total_won_2").html("0원");
		$("#select_cnt").html("0명");

		$(".plan_tr").removeClass("tr_select");
		$('input:radio[name=plan_type]').prop('checked', false).change();
		
	}

	

	function trip_purpose_change(select_val) {
		if (select_val=="3") {
			alert("운동경기/위험활동/기타의 경우는 보험인수가 거절됩니다.");
			return false;
		}
	}	
	
		
	$(document).ready(function() {
		$(".join_step > ol > li:nth-child(1)").addClass("on");

		var slider = $('#notes_roll').bxSlider({
			infiniteLoop: true,

			auto: true,
			controls: false,
			adaptiveHeight: true,
			pager: true,
			pause: 3000,
			// pagerCustom: '#pager1',
		});
		var month_limit = false;
		var today = new Date();
		var tomorrow = new Date(Date.parse(today) + (1000 * 60 * 60 * 24));
		

		

		$("#cal_start_d").datepicker({
			showOn: "both",
			dateFormat: "yy-mm-dd",
			buttonImage: "../img/common/ico_cal.png",
			buttonImageOnly: true,
			showOtherMonths: true,
			dayNamesMin: ['일', '월', '화', '수', '목', '금', '토'],
			monthNamesShort: ['1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월'],
			monthNames: ['1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월'],
			buttonText: "Select date",
			minDate: today,		
			maxDate: "+6M",
			
			onClose: function( selectedDate ) {   				
				$("#cal_end_d").val("");
				$("#cal_end_d").datepicker("enable");
				$("#cal_end_d").datepicker( "option", "minDate", new Date(Date.parse(selectedDate)) );
				<?// if ($tripType == '2'){ ?>		
				var limitmonth = (get_limit() == 2)?3:1;
				$("#cal_end_d").datepicker( "option", "maxDate", new Date(Date.parse(treemonthcal(selectedDate, limitmonth))) );
				<?// } elseif ($tripType == '1'){ ?>			
				//$("#cal_end_d").datepicker( "option", "maxDate", new Date(Date.parse(treemonthcal(selectedDate, get_limit()))) );
				
				<?// } ?>

				view_reset();
			}         
		});

		$(" #cal_end_d").datepicker({
			showOn: "both",
			dateFormat: "yy-mm-dd",
			buttonImage: "../img/common/ico_cal.png",
			buttonImageOnly: true,
			showOtherMonths: true,
			dayNamesMin: ['일', '월', '화', '수', '목', '금', '토'],
			monthNamesShort: ['1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월'],
			monthNames: ['1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월'],
			buttonText: "Select date",
			minDate: today,
			onClose: function( selectedDate ) {    
				view_reset();			
			}                
		});
		$("#cal_start_d").datepicker("disable");
		$("#cal_end_d").datepicker("disable");

		$("#cal_start_h,#cal_end_h").change(function(){			
			view_reset();
		});
	
		$("#cal_start_h,#cal_end_h, #cal_end_d").change(function(){			
			if(get_limit() == 2){
				
				if(!check_hour_max('cal_start_d','cal_end_d', 'cal_start_h', 'cal_end_h')){
					$('#cal_end_d').val('');
				}
			} else {
				if(!check_hour_max('cal_start_d','cal_end_d', 'cal_start_h', 'cal_end_h')){
					$('#cal_end_d').val('');
				}
			}
		});
		

		var sel_insuran;
	$('#put_insu').change(function(){
		if($('#put_insu option:selected').val() != 'lognterm'){
			$("#ch_insu").css('display', 'none');
			$(".simple_cont div:nth-child(5)").css('display','block');
			$(".simple_cont div:nth-child(6)").css('display','block');
			$(".simple_cont div:nth-child(7)").css('padding-left',0);
			$("#cal_start_d").datepicker("enable");
		} else {
			$("#ch_insu").css('display', 'block');
			$(".simple_cont div:nth-child(5)").css('display','none');
			$(".simple_cont div:nth-child(6)").css('display','none');
			$(".simple_cont div:nth-child(7)").css('padding-left',304);
		}

		if($('#put_insu option:selected').val()  == 'oversea'){
			set_limit(2);
		} else if($('#put_insu option:selected').val()  == 'domestic'){
			set_limit(1);
		} else {
			$('#cal_start_d').datepicker("disable");
			$('#cal_start_h').attr('disabled','true');
			$('#cal_end_d').datepicker("disable");
			$('#cal_end_h').attr('disabled','true');
		}
	});
		
		

		var rt = $(".ba_box").offset().top + 56;
            
		$(window).scroll(function () {
			var th = $("#header").outerHeight() + $(".join_step").outerHeight();
			var wt = $(window).scrollTop();

			if(wt >= rt){
				$("#right_wrap").addClass("pa_aa");
			}else if(wt < rt) {
				$("#right_wrap").removeClass("pa_aa");
			}
			
			$('.pa_aa').css('top', wt - th);
		});

				
		$('#swin_close').on("click",function(){
			$("#search_window").hide();	
			$("#com_search_val").empty();
		});
	});	


</script>

<div id="wrap" class="main_wrap">

	<div id="inner_wrap">
		<!-- header -->
		<? include ("../include/header.php"); ?>
			<!-- //header -->
			<!-- container -->
			 <!-- s : container -->
    <section id="container">
        <div class="home__slider">
            <div class="bxslider">
                <div><a href="#"><img src="../img/main/evt_ba1.jpg" alt="보험계약대출 서비스 1 보험계약 해지 없이, 연3.7%~9.5% 이율로 홈페이지에서 간편하게 신청하세요."></a></div>
                <div><a href="#"><img src="../img/main/evt_ba2.jpg" alt="보험계약대출 서비스 2 보험계약 해지 없이, 연3.7%~9.5% 이율로 홈페이지에서 간편하게 신청하세요."></a></div>
                <div><a href="#"><img src="../img/main/evt_ba3.jpg" alt="보험계약대출 서비스 3 보험계약 해지 없이, 연3.7%~9.5% 이율로 홈페이지에서 간편하게 신청하세요."></a></div>
            </div>
        </div>
        
          <script>
            $(function(){
          $('.bxslider').bxSlider({
            mode: 'fade',
            captions: true,
            slideWidth: 1140,
            auto:true
          });
        });
        
          </script>
        <section id="ba_join">
            <div class="ba_box">
                <div><img src="../img/main/icon1.jpg" alt=""></div>
                <div><span>단기해외</span> 여행자 보험<br>가입하기</div>
                 <!-- s : 수정 0227 -->
                <div <?=($_SESSION['s_mem_type'] == 'B2C' || $_SESSION['s_mem_type2'] == 'N')?"style='height:40px;' ":"";?>>
				<?
					if($_SESSION['s_mem_type2'] != 'N'){
						if($_SESSION['s_mem_insu1'] != 'N'){	
				?>
                    <button type="button" insu_both="ov1" name="button"><img src="../img/main/logo_db.png" alt="DB손해보험"></button>
				<?
						}
						if($_SESSION['s_mem_insu2'] != 'N'){	
				?>
                    <button type="button" insu_both="ov2" name="button"><img src="../img/main/logo_chubb.png" alt="CHUBB"></button>
				<?
						}
					}	
				?>
                </div>
            </div>
            <div class="ba_box">
                <div><img src="../img/main/icon2.jpg" alt=""></div>
                <div><span>단기국내</span> 여행자 보험<br>가입하기</div>
                <div <?=($_SESSION['s_mem_type'] == 'B2C' || $_SESSION['s_mem_type1'] == 'N')?"style='height:40px;' ":"";?>>
				<?
					if($_SESSION['s_mem_type1'] != 'N'){
						if($_SESSION['s_mem_insu1'] != 'N'){	
				?>
                    <button type="button" insu_both="do1" name="button"><img src="../img/main/logo_db.png" alt="DB손해보험"></button>
				<?
						}
						if($_SESSION['s_mem_insu2'] != 'N'){	
				?>
                    <button type="button" insu_both="do2" name="button"><img src="../img/main/logo_chubb.png" alt="CHUBB"></button>
				<?
						}
					}	
				?>
                </div>
            </div>
            <div class="ba_box">
                <div><img src="../img/main/icon3.jpg" alt=""></div>
                <div><span>장기해외 </span> 여행자보험<br>(전문직/유학생) 가입하기</div>
                <div <?=($_SESSION['s_mem_type'] == 'B2C' || $_SESSION['s_mem_type3'] == 'N')?"style='height:40px;' ":"";?>>
				<?
					if($_SESSION['s_mem_type3'] != 'N'){
						if($_SESSION['s_mem_long1'] != 'N'){
				?>
                    <button type="button" insu_both="lt3" name="button"><img src="../img/main/logo_meritz.png" alt="Meritz"></button>
				<?
						}
						if($_SESSION['s_mem_long2'] != 'N'){
				?>
                    <button type="button" insu_both="lt4" name="button"><img src="../img/main/logo_hanhwa.png" alt="Hanhwa"></button>
				<?
						}
					}
				?>
                </div>
                <!-- e : 수정 0227 -->
            </div>
        </section>
        <section id="simple">
            <div class="ti">
                <h2>간편 여행자 보험 비교</h2>
                <p>간편하게 보험사 별 보험료를 비교하실 수 있습니다.</p>
            </div>
            <form name="simf" action="" method="POST" id="simplecal">
                <div class="simple_cont">
                    <div>
                        <label for="">보험선택</label>    
                        <select name="trip_both" id="put_insu">
							 <option value="">보험 상품선택</option>
							 <?
							 	if($_SESSION['s_mem_type2'] != "N") {
							 ?>
                            <option value="oversea">해외 여행자 보험</option>
							<?
								}
							 if($_SESSION['s_mem_type1'] != "N"){ 
							?>
                            <option value="domestic">국내 여행자 보험</option>
							<?
							 }
							if($_SESSION['s_mem_type3']  != "N"){
							?>
                            <option value="lognterm">장기 체류자 보험</option>
							<?
							}
							?>
                        </select>
                    </div>
					<div id="ch_insu" style="display:none;">
                        <label for="">보험사선택</label>    
                        <select name="insu_both" id="sel_insu">
							 <option value="">보험사 선택</option>
                            <option value="ME">MERITZ</option>
                            <option value="HH">HANHWA</option>
                        </select>
                    </div>
                    <div>
                        <label for="">생년월일</label>    
                        <input type="text" id="put_birth" name="pub_birth" placeholder="예시) 19720522" class="nb">
                    </div>
                    <div>
                        <label for="">성별</label>    
                        <div class="gender">
                            <div>
                                <input type="radio" id="r1" name="put_sex" value="male" />
                                <label for="r1" class="gender_bx"><span></span>남자</label>
                            </div>
                            <div>
                                <input type="radio" id="r2" name="put_sex" value="female" />
                                <label for="r2" class="gender_bx"><span></span>여자</label>
                            </div>
                        </div>
                    </div>
                    <div>
                        <label for="">출발</label>  
                        <div class="day_form">
                            <ul>
                                <li class="date_picker">
                                    <input type="text" id="cal_start_d" name="put_start_d" value="" readonly><!-- class="ui-datepicker-trigger hasDatepicker" -->
                                    <!--<button type="button" class="ui-datepicker-trigger"><img src="../img/common/ico_s.jpg" alt=" " title=" "></button>-->
                                </li>
                                <li class="time">
                                    <select name="put_start_h" id="cal_start_h">
                                         <? for ($i=0;$i<24;$i++) { ?>
												 <option value="<?=sprintf("%02d", $i)?>"><?=sprintf("%02d", $i)?>시</option>
										 <? } ?>
                                    </select>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div>
                        <label for="">도착</label>  
                        <div class="day_form">
                            <ul>
                                <li class="date_picker">
                                    <input type="text" id="cal_end_d" name="put_end_d" value="" readonly><!-- class="ui-datepicker-trigger hasDatepicker" -->
                                    <!--<button type="button" class="ui-datepicker-trigger"><img src="../img/common/ico_s.jpg" alt=" " title=" "></button>-->
                                </li>
                                <li class="time">
                                    <select name="put_end_h" id="cal_end_h">
                                        <? for ($i=1;$i<25;$i++) { ?>
												 <option value="<?=sprintf("%02d", $i)?>"><?=sprintf("%02d", $i)?>시</option>
										 <? } ?>
                                    </select>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div><button type="button" name="submit" id='simple_cal' class="btn">계산하기</button></div>
                </div>
            </form>
            
        </section>
        <section id="my">
            <?
				include('./notice_0.php');
			?>
            <div class="my_biz">
                <div class="ti">
                    <h2>마이 비즈니스</h2>
                    <p class="more"><a href="#">더보기 +</a></p>
                </div>
                <div>
                    <ul>
                        <li>2019년 12월</li>
                        <li>
                            <span class="item">미수보험료</span><span class="c_red nb">234,556</span><span class="unit">원</span><span class="bline">/</span>
                            <span class="item">총 계약건수</span><span class="c_black nb">9,999</span><span class="unit">건</span class="unit"><span class="bline">/</span class="bline">
                            <span class="item">실적</span><span class="c_blue nb">4,155,400</span><span class="unit">원</span class="unit">
                        </li>
                    </ul>
                    <ul>
                        <li>가용 포인트</li>
                        <li><span class="c_green nb">245,000</span><span class="unit">원</li>
                    </ul>
                </div>
                <div>
                    <ul>
                        <li>보험 신청 현황</li>
                        <li class="more"><a href="#">더보기 +</a></li>
                    </ul>
                    <ul>
                        <div class="list">
                            <ul>
                                <li><span>20191220</span>청약번호<span class="num">645972315</span><span>민윤기 외</span><span class="p_num">45</span>명</li>
                                <li>청약완료</li>
                            </ul>
                            <ul>
                                <li><span>20191220</span>청약번호<span class="num">648597311</span><span>김남준 외</span><span class="p_num">6</span>명</li>
                                <li>청약완료</li>
                            </ul>
                            <ul>
                                <li><span>20191220</span>청약번호<span class="num">512369744</span><span>양준일 외</span><span class="p_num">60,000</span>명</li>
                                <li>청약완료</li>
                            </ul>
                        </div>
                    </ul>
                </div>
            </div>
        </section>
    </section><!-- e : container -->
	<!-- //container -->
<? include ("../include/footer.php"); ?>
</div>
<!-- //wrap -->
</body>
<script type="text/javascript">
	$('#ba_join  button').on('click',function(e){		
		var classification = '';
		var insun = '';
		switch($(this).attr('insu_both')){
			case 'ov1': 
				classification = 2;
				insun = 1;
			break;
			case 'ov2': 
				classification = 2;
				insun = 2;					
			break;
			case 'do1': 
				classification = 1;
				insun = 1;
			break;
			case 'do2': 
				classification = 1;
				insun = 2;
			break;
			case 'lt3': 
				classification = "lo3";
				insun = 1;
			break;
			case 'lt4': 
				classification = "lo4";
				insun = 2;
			break;
		}

		if(typeof(classification) == 'number'){
			location.href="/trip/01.php?tripType="+classification+"&insuboth="+insun;
		} else {
			location.href="/trip/L0.php?insuboth="+insun;
		}
	});

</script>
<div id="modal" >
    <div class="modal-bg">
        <div class="modal-cont">
            <div class="head">
                <h1>간편 여행자 보험 비교 결과</h1>
                <span>입력하신 정보로 조회하여 비교된 보험 비교 결과입니다.</span>
                <a href="javascript:void[0]" class="close"><img src="../img/common/btn_close.png" alt=""></a>
            </div>
            <div id="modalbody" class="body">
                
        </div>
    </div>
</div>
<script>

    $('document').ready(function(){
		$("#simple_cal").on('click',function(e){
			var sel_insu		= $('#put_insu option:selected'); 
			var put_birth		= $('#put_birth');
			var sel_insu_com = $('#sel_insu');
			var sel_sex			= $('input[name=put_sex]:checked');
			var startdate		= $('#cal_start_d');
			var starthour		=	$('#cal_start_h');
			var enddate		= $('#cal_end_d');
			var endhour		= $('#cal_end_h');

			if(!sel_insu.val()){
				alert('보험 상품을 선택해 주세요');			
				return false;
			}
			if(!put_birth.val()){
				alert('생년월일을 입력해주세요.');
				return false;
			} else {
				var chk_birth = /^(19[0-9][0-9]|20\d{2})(0[0-9]|1[0-2])(0[1-9]|[1-2][0-9]|3[0-1])$/;
				if( !chk_birth.test(put_birth.val()) ){
					alert('정확한 생년월일을 입력해주세요.');
					return false;
				}
			}
			
			if(!sel_sex.val()){
				alert('성별을 선택해주세요');
				return false;
			}
			
			if(sel_insu.val() != 'lognterm'){

					if(!startdate.val()){
						alert('출발 연도를 입력해주세요.');
						return false;
					} else {
						var chk_startd = /^(19[0-9][0-9]|20\d{2})-(0[0-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/;
						if(!chk_startd.test(startdate.val())){
							alert('정확한 출발 연도를 입력해주세요.');
							return false;
						}
					}		
					
					if(!enddate.val()){
						alert('도착 연도를 입력해주세요.');
						return false;
					} else {
						var chk_startd = /^(19[0-9][0-9]|20\d{2})-(0[0-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/;
						if(!chk_startd.test(enddate.val())){
							alert('정확한 도착 연도를 입력해주세요.');
							return false;
						}
					}		

					 f_pop_modal('../src/simple_cal_result.php?tripT='+sel_insu.val()+'&birthT='+put_birth.val()+'&sexT='+sel_sex.val()+'&startdT='+startdate.val()+'&starthT='+starthour.val()+'&enddT='+enddate.val()+'&endhT='+endhour.val());
					 //장기 아닐경우
			}  else {
			//장기의 경우
			
				var encjv = sel_insu_com.val()+'//-//'+put_birth.val()+'//-//'+sel_sex.val();
				var longjoindata = btoa(encjv);
				location.href="../trip/L0_f.php?join_data="+longjoindata;
			} 
		});
    
		$(".close").click(function(){
			$("#modal").addClass("out");
		});
    });

	function f_pop_modal(page){
		
		//$("#yak_tit2").html(name);
		$('#modalbody').load(page, function(){
			//ViewlayerPop(20);
			 $("#modal").removeAttr("class").addClass("three");
		});				
	}

    </script>
</html>
