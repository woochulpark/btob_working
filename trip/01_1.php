<? 
	include ("../include/top.php"); 

	session_start("s_session_key");

	$session_val=time()."_".$tripType."_".$row_mem_info['no'];
	$session_key =encode_pass($session_val,$pass_key);
	$_SESSION['s_session_key']=$session_key;

	$check_key=time()."_".rand(10000,99999).$row_mem_info['no'];

	$currDate = date("Y-m-d");
	
	if ($tripType!='1' && $tripType!='2') {
?>
<script>
	alert('잘못됩 접속 입니다..');
	location.href="../src/logout.php";
</script>
<?
	exit;
	}

	$sql_check="select * from hana_plan_tmp where member_no='".$row_mem_info['no']."'";
	$result_check=mysql_query($sql_check);
	$row_check=mysql_fetch_array($result_check);

	if ($row_check['no']!='') {
		$sql_delete="delete from hana_plan_tmp where member_no='".$row_mem_info['no']."'";
		mysql_query($sql_delete);

		$sql_delete="delete from hana_plan_member_tmp where tmp_no='".$row_check['no']."'";
		mysql_query($sql_delete);
	}
?>
<script type="text/javascript" src="../js/trip.js"></script>
<script type="text/javascript" src="../js/jquery.bxslider.min.js"></script>
<link rel="stylesheet" type="text/css" href="../css/jquery.bxslider.css" />
<script type="text/javascript" src="../common/js/ajaxfileupload.js"></script>
<script>
	var oneDepth = 1; //1차 카테고리
	
	var tripType="<?=$tripType?>";
	var total_won = 0;

	function file_proc() {
		if (confirm("엑셀 업로드시 기존 입력한 내용은 초기화 됩니다.\n\n업로드 하시겠습니까?")) {

			$("#loading_area").css({"display":"block"});

			$.ajaxFileUpload({
				url:'../src/excel_file_proc.php',
				secureuri:false,
				fileElementId:"upfilename",
				dataType: 'json',
				data:{ "send_name" : "upfilename" },
				success: function (data, status){

					var json = data;

					if (json.result=="true") {
						var json_cnt=0;

						$('.infoform-add').remove();

						$.each(json.msg,function(key,state){
							if (json_cnt==0) {
								$("#m_input_name").val(state['name']);
								$("#m_jumin_1").val(state['jumin1']);
								$("#m_jumin_2").val(state['jumin2']);

								$("#m_hphone1").val(state['hphone1']);
								$("#m_hphone2").val(state['hphone2']);
								$("#m_hphone3").val(state['hphone3']);

								$("#m_email1").val(state['email1']);
								$("#m_email2").val(state['email2']);

							} else {
								var	div = '<div class="infoform  infoform-add">';
									div += '<p class="ico_ceo2"><span>피보험자</span></p>';
									div += '<span class="delspan " style="width:100px;background:#ff6600;color:#fff;border:1px solid;">제거</span>';
									div += '<div class="step_select two">';
										div += '<div class="select_ds cb">';
											div += '<label class="ss_tit db"><strong class="point_c">이름 *</strong></label>';
											div += '<input class="input" name="input_name[]" value="'+state['name']+'" placeholder="홍길동" type="text">';
										div += '</div>';
										div += '<div class="select_ds">';
											div += '<label class="ss_tit db"><strong class="point_c">주민등록번호 (외국인등록번호) *</strong></label>';
											div += '<div class="col-sm-2">';
												div += '<div class="select_ds pr10">';
													div += '<input class="input onlyNumber" name="jumin_1[]" placeholder="801010" maxlength="6" type="number"  oninput="maxLengthCheck(this)" value="'+state['jumin1']+'" >';
													div += '<span class="pa_minus">-</span>';
												div += '</div>';
												div += '<div class="select_ds pl5">';
													div += '<input class="input onlyNumber" name="jumin_2[]" placeholder="*******" type="password" maxlength="7" value="'+state['jumin2']+'" >';
												div += '</div>';
											div += '</div>';
										div += '</div>';
									div += '</div>';
								div += '</div>';

								$(div).appendTo("#mantable");
							}

							json_cnt++;
						});	
						
						$(".onlyNumber").keyup(function(event){
							if (!(event.keyCode >=37 && event.keyCode<=40)) {
								var inputVal = $(this).val();
								$(this).val(inputVal.replace(/[^0-9]/gi,''));
							}
						});

						var changeCount = $('#mantable .infoform').length;
						$('#join_cnt').val(changeCount);

						view_reset();

						$("#loading_area").delay(300).fadeOut();

					} else {
						alert(json.msg);
						view_reset();
						$("#loading_area").delay(300).fadeOut();
						return false;
					} 
				},
				error:function(data,status){alert('upload error.');}
			});
		}

	}

	var cal_type_id = new Array();
	cal_type_id[1]=0;
	cal_type_id[2]=0;
	cal_type_id[3]=0;
	cal_type_id[4]=0;

	var cal_type_code = new Array();
	cal_type_code[1]="";
	cal_type_code[2]="";
	cal_type_code[3]="";
	cal_type_code[4]="";

	function view_reset() {
	
		$(".join_step > ol > li:nth-child(1)").addClass("on");
		$(".join_step > ol > li:nth-child(2)").removeClass("on");
		$(".join_type").hide();
		$(".execute_bt > button").removeClass("disable");
		$(".last_selec").hide();
		$(".hiddenplan").show();
		$(".total_won_1").html("0");
		$(".total_won_2").html("0원");
		$("#select_cnt").html("0명");

		$(".plan_tr").removeClass("tr_select");
		$('input:radio[name=plan_type]').prop('checked', false).change();
		
	}

	function manchange(val) {

		// 현재 선택되어 있는 인원
		var now = $('.infoform').length;
		var diff = parseInt(val) - parseInt(now);
		var div = '<div class="infoform  infoform-add">';
				div += '<p class="ico_ceo2"><span>피보험자</span></p>';
				div += '<span class="delspan " style="width:100px;background:#ff6600;color:#fff;border:1px solid;">제거</span>';
				div += '<div class="step_select two">';
					div += '<div class="select_ds cb">';
						div += '<label class="ss_tit db"><strong class="point_c">이름 *</strong></label>';
						div += '<input class="input" name="input_name[]" placeholder="홍길동" type="text">';
					div += '</div>';
					div += '<div class="select_ds">';
						div += '<label class="ss_tit db"><strong class="point_c">주민등록번호 (외국인등록번호) *</strong></label>';
						div += '<div class="col-sm-2">';
							div += '<div class="select_ds pr10">';
								div += '<input class="input onlyNumber" name="jumin_1[]" placeholder="801010" maxlength="6" type="number"  oninput="maxLengthCheck(this)">';
								div += '<span class="pa_minus">-</span>';
							div += '</div>';
							div += '<div class="select_ds pl5">';
								div += '<input class="input onlyNumber" name="jumin_2[]" placeholder="*******" type="password" maxlength="7">';
							div += '</div>';
						div += '</div>';
					div += '</div>';
				div += '</div>';
			div += '</div>';
		// 추가
		if (diff > 0) { // 늘어나는 경우
			for (var i = 0; i < diff; i++) {
				$(div).appendTo("#mantable");
			}
		} else if (diff < 0) { // 줄어드는 경우
			if (confirm('인원축소 및 변경시에는 기존 작성된 데이터가 삭제됩니다.\n기존 데이터 보존 상태로 가입자 수 변경은 \n개별인원 제거(-) 버튼을 사용해주세요.\n개별인원 제거를 사용하시고자 하는 경우, 취소 버튼을 눌러주세요.') == true) {
				$('.infoform-add').remove();
				for (var i = 0; i < val - 1; i++) {
					$(div).appendTo("#mantable");
				}
			} else {
				return;
			}
		}

		$(".onlyNumber").keyup(function(event){
			if (!(event.keyCode >=37 && event.keyCode<=40)) {
				var inputVal = $(this).val();
				$(this).val(inputVal.replace(/[^0-9]/gi,''));
			}
		});

		view_reset();
	}

	function trip_purpose_change(select_val) {
		if (select_val=="3") {
			alert("운동경기/위험활동/기타의 경우는 보험인수가 거절됩니다.");
			return false;
		}
	}
	
	$(document).on('click', '.delspan', function() {
		$(this).parent().remove();
		var changeCount = $('#mantable .infoform').length;
		alert('인원변경이 있습니다. 보험료조회를 다시 진행해 주세요.');
		$('#join_cnt').val(changeCount);

		view_reset();
	});


	


	$(document).ready(function() {

		
/*		
		$(".join_type").show();
		$(".last_selec, #showplan").show();
		$("#showplan").show();
*/

		$(".join_step > ol > li:nth-child(1)").addClass("on");

		var slider = $('#notes_roll').bxSlider({
			infiniteLoop: true,

			auto: false,
			controls: false,
			adaptiveHeight: true,
			pager: true,
			pause: 3000,
			// pagerCustom: '#pager1',
		});

		var today = new Date();
		var tomorrow = new Date(Date.parse(today) + (1000 * 60 * 60 * 24));

		$("#start_date").datepicker({
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
			<? if ($tripType == '2'){ ?>
			maxDate: "+6M",
			<? } elseif ($tripType == '1'){ ?>
			maxDate: "+1M",
			<? } ?>
			onClose: function( selectedDate ) {    
				$("#end_date").val("");
				$("#end_date").datepicker("enable");
				$("#end_date").datepicker( "option", "minDate", new Date(Date.parse(selectedDate)) );
				<? if ($tripType == '2'){ ?>
				//$("#end_date").datepicker( "option", "maxDate", new Date(Date.parse(selectedDate) + (1000 * 60 * 60 * 24 * 90)) );
				$("#end_date").datepicker( "option", "maxDate", new Date(Date.parse(treemonthcal(selectedDate, '3'))) );
				<? } elseif ($tripType == '1'){ ?>
				//$("#end_date").datepicker( "option", "maxDate", new Date(Date.parse(selectedDate) + (1000 * 60 * 60 * 24 * 30)) );
				$("#end_date").datepicker( "option", "maxDate", new Date(Date.parse(treemonthcal(selectedDate, '1'))) );
				<? } ?>

				view_reset();
			}         
		});

		$(" #end_date").datepicker({
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
				var date_term=dateDiff($("#start_date").val(),$("#end_date").val());
				
				/*
				if (tripType=="1") {
					if (parseInt(date_term)>30) {
						alert('30일 해당 기간까지만 보장됩니다');
					}
				} else if (tripType=="2") {
					if (parseInt(date_term)>90) {
						alert('90일 해당 기간까지만 보장됩니다');
					}
				}
				*/
			}                
		});

		$("#end_date").datepicker("disable");

		$("#start_hour,#end_hour").change(function(){
			view_reset();
		});
		
		$("#start_hour,#end_hour, #end_date").change(function(){
			if(tripType == 2){
				
				if(!check_hour_max()){
					$('#end_date').val('');
				}
			}
		});
		
		if ("<?=$tripType?>" == '1') {
			$("#bound_1").prop("checked", true).change();
		} else if ("<?=$tripType?>" == '2') {
			$("#bound_2").prop("checked", true).change();
		} 

		var rt = $("#right_wrap").offset().top + 56;
            
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

		$("#nation_search").focusin(function(){
			nation_search_fun();
		});
		
		$("#nation_search").on("paste keyup ",function(){
			nation_search_fun();
		});
		
		$('#swin_close').on("click",function(){
			$("#search_window").hide();	
			$("#com_search_val").empty();
		});

		$(document).on("click",'.ttt',function(){
				var ncode;				
				var nname;
				ncode = $(this).attr('nation_no');
				nname = $(this).text();
				$('input[name=nation]').val(ncode);
				$('input[name=nation_search]').val(nname);
				$("#search_window").hide();	
				$("#com_search_val").empty();
		});

	});

	function nation_search_fun(){
	
		
				var chkn = $("#nation_search").val();
				if(chkn == ''){
					$("#search_window").hide();	
					$("#com_search_val").empty();
					return false;
				}			

				$.ajax({
				type : "POST",
				url : "../src/nation_search.php",
				data :  $("#nation_search").serialize(),
				dataType:"json",
				success : function(data, status) {
					//var json = eval("(" + data + ")");		
					
					if (data.result=="true") {
						if(data.msg){ 
						$("#com_search_val").empty();
						var aaa = JSON.stringify(data.msg)
						var bbb="";
						var se_win_po;
						
						var ccc = JSON.parse(aaa);
						console.log(ccc);
						$.each(ccc,function(ind,itm){
							bbb+="<li nation_no='"+itm.nation_code+"' class='ttt' style='cursor:pointer'><a href='#none'>"+itm.nation_name+"</a></li>";
						});
						
						$("#com_search_val").append(bbb);
						//console.log("offset : "+$("#nation").offset()+" height : "+$("#nation").height() );
						var input_h = $("#nation_search").height();
						se_win_po = $("#nation_search").offset();
						var input_w = $("#nation_search").width();
						$('.br_color').css({width:(input_w + 10)+'px'});
						$("#search_window").css({top: (se_win_po.top+ input_h) +'px', left:se_win_po.left + 'px' });
						$("#search_window").show();	
		
						return false;
						} else {
							$('input[name=nation]').val('');
							$("#search_window").hide();	
							$("#com_search_val").empty();
						}
					} else {
						alert(json.msg);
						$("#search_window").hide();	
						return false;
					}
					
				},
				error : function(err)
				{
					alert(err.responseText);
				
					return false;
				}
				}); // ajax end
	
	} //function end


	function v_pop(){
		$("#pop_title1").html("보험인수 제한 국가 안내");
		ViewlayerPop(1);
	}
	
	function treemonthcal(kind, kind1){
		var start_date = kind;
		var data_arr = start_date.split('-');
		var hap_year;
		var hap_month;
		var gap_month;
		var enddate;
		var gap_day;

		 hap_month = Number(data_arr[1]) + Number(kind1);
		 //console.log(hap_month);
		 if(hap_month > 12){
			//gap_month = hap_month - Number(data_arr[1]);
			gap_month = hap_month - 12;

			//console.log('차이: '+gap_month);
		  hap_year = Number(data_arr[0]) + 1;
		 } else {
			gap_month = hap_month;
		  hap_year = Number(data_arr[0]);
		 }

		// 2019-08-21 추가 분 -  월을 분리해서 사용하는 중에 10보다 작은 월에 0을 붙여야 한다. (안붙이면 오류)
		 if(gap_month < 10){
			gap_month = "0"+gap_month;
		 } 

		var lastDay = ( new Date(hap_year, gap_month,'')).getDate().toString();

		if(data_arr[2] > lastDay){
			gap_day = lastDay;
		} else {
			gap_day = data_arr[2];
		}
		//console.log('종료 일자 : '+lastDay);
		enddate = hap_year+"-"+gap_month+"-"+gap_day;
		//console.log('종료일 : '+enddate);
		return enddate;
	}

	function check_hour_max(){
		var stdate = $('#start_date').val();
		var enddate = $('#end_date').val();

		var sthour = $('#start_hour').val();
		var edhour = $('#end_hour').val();
		
		var maxdate;	

		if(tripType == "2"){
			maxdate = treemonthcal(stdate, '3');
		} else {
			maxdate = treemonthcal(enddate, '1');
		}
		
		if(!cutMaxTripday(stdate, enddate, maxdate, sthour, edhour, tripType)){
			alert('단기해외여행자보험은 최대 3개월까지 가입가능합니다. 3개월 이상 가입 신청 시 유학(장기체류)보험으로 신청해주세요.');
			return false;
		} else {
			return true;
		}
	}
</script>

<div id="wrap">
	<div id="inner_wrap">
		<!-- header -->
		<? include ("../include/header.php"); ?>
			<!-- //header -->
			<!-- container -->
			<div id="container">
				<? include ("step.php"); ?>


<form id="send_form" name="send_form">
<input type="hidden" id="auth_token" name="auth_token" readonly>
<input type="hidden" id="total_won" name="total_won" readonly>
<input type="hidden" id="send_type" name="send_type" value="1" readonly>
<input type="hidden" id="tripType" name="tripType" value="<?=$tripType?>" readonly>

<input type="hidden" id="cal_type_1_code" name="cal_type_1_code" value="" readonly>
<input type="hidden" id="cal_type_2_code" name="cal_type_2_code" value="" readonly>
<input type="hidden" id="cal_type_3_code" name="cal_type_3_code" value="" readonly>
<input type="hidden" id="cal_type_4_code" name="cal_type_4_code" value="" readonly>


					<div class="left_wrap">
						<h3 class="step_tit"><strong>STEP 1.</strong> 여행정보를 입력해주세요.</h3>
						<div class="gray_box">

							
							<div class="step_select one">
								<div class="select_ds" style="max-width:375px;">
									<label class="ss_tit">여행종류</label>
									<ul class="box_radio">
										<li><label><input type="radio" value="2" name="bound" id="bound_2" disabled>해외</label></li>
										<li><label><input type="radio" value="1" name="bound" id="bound_1" disabled>국내</label></li>
									</ul>
								</div>

							</div>

							<? if ($tripType=="2") { ?>
							<ol class="bul_num pt10">
								<li>1. 여러국가를 여행하셔도 보장되오니, <span class="blue">여러국가를 여행하실 경우에는 가장 오래 체류할 국가를 선택</span>해주시면 됩니다. 
								      단, 여행 예정인 국가 중 보험인수 제한 국가가 포함되어 있을 경우 보험 가입이 불가능 합니다. (<a href="javascript:void(0);" onclick="v_pop();"><span class="red" style="text-decoration: underline; font-weight:bold;">여행금지국가</span></a> 확인)</li>
								<li>2. 이중국적자, 외국인의 경우 모국으로 여행은 가입 불가합니다.</li>
							</ol>
							<? } ?>

							<div class="step_select two">
								<div class="select_ds cb">
									<label class="ss_tit">여행국가</label>
									<?
	if ($tripType=="2") {
?>
									<input type="text"  class="input" name="nation_search" id="nation_search"  placeholder="여행국가 명을 입력하세요.">
									<input type="hidden"  value="" name="nation" >
<?
		
	} else {
?>
									<input type="text"  class="input" value="국내일원" name="nation_search" id="nation_search" readonly>
									<input type="hidden"  value="국내" name="nation" >
	<?
	}
?>		
								</div>

								<div class="select_ds cb">
									<label class="ss_tit">여행목적</label>
									<select class="select" name="trip_purpose" id="trip_purpose" onchange="trip_purpose_change(this.value);">
										<option value="">선택</option>
<? for ($i=1;$i<=count($trip_purpose_array);$i++) { ?>
										<option value="<?=$i?>"><?=$trip_purpose_array[$i]?></option>
<? } ?>
									</select>
								</div>
							</div>

							<div class="step_select two">
								<div class="select_ds cb">
									<label class="ss_tit">출발일</label>
									<div class="col-sm-2">
										<div class="select_ds pr10" style="width:65%;">
											<div class="date_picker">
												<input type="text" class="input" name="start_date" id="start_date" value="" readonly>
											</div>
										</div>
										<div class="select_ds pl10" style="width:35%;">
											<select name="start_hour" id="start_hour" class="select">
												 <? for ($i=0;$i<24;$i++) { ?>
												 <option value="<?=sprintf("%02d", $i)?>"><?=sprintf("%02d", $i)?>시</option>
												 <? } ?>
											</select>
										</div>

									</div>
								</div>
								<div class="select_ds cb">
									<label class="ss_tit">도착일</label>
									<div class="col-sm-2">
										<div class="select_ds pr10" style="width:65%;">
											<div class="date_picker">
												<input type="text" class="input" name="end_date" id="end_date" readonly>
											</div>
										</div>
										<div class="select_ds pl10" style="width:35%;">
											<select name="end_hour" id="end_hour" class="select">
												 <? for ($i=1;$i<25;$i++) { ?>
												 <option value="<?=sprintf("%02d", $i)?>"><?=sprintf("%02d", $i)?>시</option>
												 <? } ?>
											</select>
										</div>

									</div>
								</div>
							</div>
							
							<div class="step_select one">
								<div class="select_ds">
									<label class="ss_tit db">피보험자-여행인원</label>
									<select class="select" name="join_cnt" id="join_cnt" style="max-width:353px;" onchange="manchange(this.value)">
									<? for ($i=1;$i<26;$i++) { ?>
									<option value="<?=$i?>">여행인원 <?=$i?>명</option>
									<? } ?>
								</select>
									<p class="ib" style="padding:5px;">* 최대 25명까지 동시가입 가능</p>
								</div>
							</div>
						</div>

						<h3 class="s_tit">여행자정보 입력 <span class="point_c small">* 필수입력란</span></h3>
						<div class="tr" id="excel_btn" style="margin-top:-45px; height:45px">
							<div class="excel_btn">
								<div class="file_input">
								<?php
										if($_SESSION['s_mem_id'] != 'hyecho_b2b'){
									?>
									<a href="../투어세이프_B2B_엑셀샘플.xlsx"><label>엑셀 샘플 다운로드</label></a>
								<?
										} else {
								?>
								<a href="../투어세이프_B2B_hyecho_엑셀샘플.xlsx"><label>엑셀 샘플 다운로드</label></a>
								<?
									}
									?>
								</div>
							</div>

							<div class="excel_btn">
								<div class="file_input">
									<label>엑셀 업로드<input type="file" name="upfilename" id="upfilename" onchange="file_proc();"></label>
								</div>
							</div>
						</div>
						
						<div id="mantable" class="gray_box">
						<p class="ico_ceo"><span>대표피보험자</span></p>
							<div class="infoform">
								<div class="step_select two">
									<div class="select_ds cb">
										<label class="ss_tit db"><strong class="point_c">이름 *</strong></label>
										<input class="input" name="input_name[]" id="m_input_name" placeholder="홍길동" type="text">
									</div>
									<div class="select_ds">
										<label class="ss_tit db"><strong class="point_c">주민등록번호 (외국인등록번호) *</strong></label>
										<div class="col-sm-2">
											<div class="select_ds pr10">
												<input class="input onlyNumber" name="jumin_1[]" id="m_jumin_1" placeholder="801010" maxlength="6" type="number" oninput="maxLengthCheck(this, 'm_jumin_2')">
												<span class="pa_minus">-</span>
											</div>
											<div class="select_ds pl5">
												<input class="input onlyNumber" name="jumin_2[]" id="m_jumin_2" placeholder="*******" type="password" maxlength="7">
											</div>
										</div>
									</div>
								</div>
								<div class="step_select two">
									<div class="select_ds cb">
										<label class="ss_tit db"><strong class="point_c">휴대폰 번호 *</strong></label>
										<div class="col-sm-3 tel">
											<div class="select_ds pr10">
												<input type="number" class="input onlyNumber" id="m_hphone1" size="9" title="휴대전화 식별번호를 넣어주세요." maxlength="3" style="width:100%" value="010" name="hphone1[]"  oninput="maxLengthCheck(this, 'm_hphone2')">
												<span class="pa_minus">-</span> </div>
											<div class="select_ds pl5 pr10">
												<input type="number" class="input onlyNumber" id="m_hphone2" size="9" title="휴대전화 앞자리를 넣어주세요." maxlength="4" value="" style="width:100%" name="hphone2[]" oninput="maxLengthCheck(this, 'm_hphone3')">
												<span class="pa_minus">-</span>
											</div>
											<div class="select_ds pl5">
												<input type="number" class="input onlyNumber" id="m_hphone3" size="9" title="휴대전화 뒷자리를 넣어주세요." maxlength="4" value="" style="width:100%" name="hphone3[]" oninput="maxLengthCheck(this, 'm_email1')">
											</div>
										</div>
									</div>
									<div class="select_ds">
									<?php
										if($_SESSION['s_mem_id'] != 'hyecho_b2b'){
									?>
										<label class="ss_tit db">이메일</label>
										<div class="col-sm-2">
											<div class="select_ds pr15">
												<input name="email1[]" value="" class="input" id="m_email1" style="width:100%;" placeholder="이메일" type="email">
												<span class="pa_minus">@</span> </div>
											<div class="select_ds pl5">
												<input name="email2[]" value="" class="input" id="m_email2" style="width:100%;" type="email">
											</div>
										</div>
									<?php
										} else {
									?>
										<label class="ss_tit db">추가정보</label>
										<div class="col-sm-2">
											<!--div class="select_ds pr15"-->
												<input name="email1[]" value="" class="input" id="m_email1" style="width:100%;" placeholder="추가정보" type="text">
												<!--<span class="pa_minus">@</span--> <!--/div-->
											<!--div class="select_ds pl5">
												<input name="email2[]" value="" class="input" id="m_email2" style="width:100%;" type="email">
											</div-->
										</div>
									<?php
										}	
									?>
									</div>
								</div>
							</div>
						</div>

						
						<div class="showplan_web">
							<h3 class="s_tit">보장내용</h3>
							<? include ("plan.php"); ?>


						</div>
						


					</div>
					<!-- right -->
					<div id="right_wrap" class="right_wrap">
						<p class="execute_bt"><button type="button" onclick="insuterminator();"><span>보험료 계산</span></button></p>

						<div class="join_type" style="display:none;">
							<h4>가입 상품을 선택해주세요.</h4>
							<div class="in_box">
								<img src="../img/pages/chubb.png" alt="chubb">
								<p class="txt"><?=($_SESSION['s_mem_id'] != 'hyecho_b2b' && $_SESSION['s_mem_id'] != 'followme_b2b')?"에이스손해보험 Chubb " :"MG손해보험 ";?>여행자보험</p>
								<ul class="box_radio small full three" id="insurance_type">
								</ul>
							</div>
						</div>
						
						

						<div class="last_selec" style="display:none;">
							<h4>최종 확인 후 가입버튼을<br> 선택하여주세요.
							</h4>
							<div class="in_box">

								<ul>
									<li><span class="fl">선택보험사</span><strong class="fr"><?=($_SESSION['s_mem_id'] != 'hyecho_b2b' && $_SESSION['s_mem_id'] != 'followme_b2b')?"에이스손해보험":"MG손해보험";?></strong></li>
									<li><span class="fl fb">총 가입인원</span><strong class="fr fb" id="select_cnt">0</strong></li>
									<li style="font-size:1.1em;"><span class="fl fb">총 보험료</span><strong class="fr point_c fb total_won_2">0</strong></li>
								</ul>
							</div>
							<p class="bt"><button type="button" onclick="submitInsu();">보험가입</button></p>
						</div>

						<div class="showplan_mobile">
							<h3 class="s_tit">보장내용</h3>
							<? include ("plan.php"); ?>
							
						</div>
		
						<div class="notes_wrap">
							<div class="in_wrap">
								<h4>가입전 알아두실 사항</h4>
								<ul id="notes_roll">
									<li>
										<div class="notes_box">
											<ul class="bul02">
												<li><span class="org">출국직전</span>까지 가입가능합니다.</li>
												<?=($_SESSION['s_mem_id'] != 'hyecho_b2b' && $_SESSION['s_mem_id'] != 'followme_b2b')? '<li><span class="org">가입확인서</span>는 휴대폰으로 카카오톡 또는 문자메세지로 발송해 드립니다.</li>':'';?>
												<li>투어세이프 고객센터 <span class="org">1800-9010 (평일 09시~18시)</span></li>
											</ul>
										</div>
									</li>
								</ul>
							</div>

						</div>
					</div>
					<!-- right -->
</form>



			</div>

	<!-- //container -->
	</div>
	<!-- //inner_wrap -->
	<? include ("../include/footer.php"); ?>
</div>
<!-- //wrap -->

<div id="layerPop0" class="layerPop" style="display: none;">
	<div class="layerPop_inner">
		<div class="pop_wrap">
			<div class="pop_wrap_in mini" style="max-width:500px;">
				<div class="pop_head">
					<p class="title " id="pop_title"></p>
					<p class="x_btn" onclick="CloselayerPop();"><img src="../img/common/btn_close2.png" alt="닫기"></p>
				</div>
				<div class="pop_body pt0" id="pop_content"></div>

			</div>
		</div>
	</div>
</div>

<div id="layerPop1" class="layerPop" style="display: none;">
	<div class="layerPop_inner">
		<div class="pop_wrap">
			<div class="pop_wrap_in " style="max-width:600px;">
				<div class="pop_head">
					<p class="title" id="pop_title1"></p>
					<p class="x_btn" onclick="CloselayerPop();"><img src="../img/common/close3.png" alt="닫기"></p>
				</div>
				<div id="viewPop" class="pop_body ">
    					<strong>아시아</strong><p>아프가니스탄, 이스라엘, 이라크, 이란, 북한, 레바논, 파키스탄, 팔레스타인 자치구, 시리아, 타지키스탄, 예멘<br/><br/>
    					<strong>아프리카</strong><p>부르키나파소, 부룬디, 콩고(자이레), 중앙아프리카, 콩고, 코트디브와르, 알제리, 이집트, 기니, 리비아, 말리, 나이지리아, 수단, 시에라리온, 소말리아, 챠드, 자이레, 이디오피아, 케냐, 니제르<br/><br/>
    					<strong>유럽</strong><p>우크라이나, 크림반도<br/><br/>
    					<strong>북아메리카</strong><p>쿠바, 니카라과<br/><br/>
    					<strong>남아메리카</strong><p>아이티, 베네수엘라<br/><br/>
    					<strong>기타</strong><p>남극<br/><br/>
    					* 외교부의 여행금지대상 국가정보는 수시로 변경됩니다. 여행금지대상국가의 경우 가입이 불가하거나 또는 보상 대상에서 제외될 수 있습니다.<br/><br/>
						<a href="http://www.0404.go.kr/dev/main.mofa" style="text-decoration: underline;" target="_blank" title="외교부 홈페이지 새창열림">외교부 해외안전여행 여행제한 및 금지구역 확인</a>
				</div>

			</div>
		</div>
	</div>
</div>
<!-- 여행국가 초성 검색 View -->
<div class="search_win_css" id="search_window"  style="display:none;">
	<div class="br_color">
	<div class="dis_win_css">
		<ul class="slist" id="com_search_val"></ul>	
	</div>
		<div class="swin_close" id="swin_close"><button class="winclose" type="button"><span>닫기</span></button></div>
		</div>
</div>

<!-- 여행국가 초성 검색 View -->
</body>

</html>
