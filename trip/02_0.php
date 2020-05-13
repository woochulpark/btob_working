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
			 <!-- s : container -->
    <section id="container">
        <section id="h1">
            <div><h1>장기 체류자 보험가입</h1></div>
            <div><span class="dot">*</span>표시는 필수로입력하시기 바랍니다.</div>
        </section>
        <section id="ac_info">
            <table id="t_info">
                <tbody>
                    <tr>
                        <th>거래처 ID</th>
                        <td class="nb">1234564</td>
                        <th>거래처명</th>
                        <td>00000여행사</td>
                        <th>청약번호</th>
                        <td class="nb">12346979</td>
                        <th>청약일</th>
                        <td class="nb">2019-12-26</td>
                    </tr>
                </tbody>
            </table>
        </section>
        <form action="" method="" id="formBox">
        <fieldset>
            <section id="ssc_info">
                <div class="tit"><h2>청약 정보</h2></div>
                <div class="textBox">
                    <div class="write_area">
                        <ul>
                            <li>
                                <label for=""><span class="dot">*</span>보험사 선택</label>
                                <select name="" id="">
                                    <option value="">DB손해보험</option>
                                    <option value=""> </option>
                                    <option value=""> </option>
                                    <option value=""> </option>
                                    <option value=""> </option>
                                    <option value=""> </option>
                                    <option value=""> </option>
                                    <option value=""> </option>
                                    <option value=""> </option>
                                </select>
                            </li>
                            <li class="calendar">
                                <label for=""><span class="dot">*</span>보험 기간</label> 
                                <div>
                                    <span class="day_form">
                                        <input type="text" id="" name="" value=""><!-- class="ui-datepicker-trigger hasDatepicker" -->
                                        <!--<button type="button" class="ui-datepicker-trigger"><img src="../img/common/ico_s.jpg" alt=" " title=" "></button>-->
                                    </span>
                                    <span class="time">
                                        <select name=" " id=" " class="nb">
                                            <option value="">00시</option>
                                            <option value=""> </option>
                                            <option value=""> </option>
                                            <option value=""> </option>
                                            <option value=""> </option>
                                            <option value=""> </option>
                                            <option value=""> </option>
                                            <option value=""> </option>
                                            <option value=""> </option>
                                        </select>
                                    </span>
                                </div>
                                <div>
                                    <span class="day_form">
                                        <input type="text" id="" name="" value=""><!-- class="ui-datepicker-trigger hasDatepicker" -->
                                        <!--<button type="button" class="ui-datepicker-trigger"><img src="../img/common/ico_s.jpg" alt=" " title=" "></button>-->
                                    </span>
                                    <span class="time">
                                        <select name=" " id=" " class="nb">
                                            <option value="">00시</option>
                                            <option value=""> </option>
                                            <option value=""> </option>
                                            <option value=""> </option>
                                            <option value=""> </option>
                                            <option value=""> </option>
                                            <option value=""> </option>
                                            <option value=""> </option>
                                            <option value=""> </option>
                                        </select>
                                    </span>
                                </div>
                            </li>
                        </ul>
                        <ul>
                            <li>
                                <label for=""><span class="dot">*</span>목적지</label>
                                <div class="wBox"><input type="text" id="" name="" placeholder="지역명을 입력해주세요"></div>
                                <div class="btn"><button type="button" name="button" class="btn_s4">선택</button></div>
                            </li>
                            <li>
                                <label for=""><span class="dot">*</span>여행 목적</label>
                                <select name=" " id=" ">
                                    <option value="">기타</option>
                                    <option value=""> </option>
                                    <option value=""> </option>
                                    <option value=""> </option>
                                    <option value=""> </option>
                                    <option value=""> </option>
                                    <option value=""> </option>
                                    <option value=""> </option>
                                    <option value=""> </option>
                                </select>
                            </li>
                        </ul>
                        <ul>
                            <li>
                                <label for=""><span class="dot">*</span>공통 플랜</label>
                                <div class="wBox"><input type="text" id="" name=""></div>
                                <div class="btn"><button type="button" name="button" class="btn_s4">선택</button></div>
                            </li>
                            <li>
                                <label for=""><span class="dot">*</span>현재 체류지</label>
                                <select name=" " id=" ">
                                    <option value="">기타</option>
                                    <option value=""> </option>
                                    <option value=""> </option>
                                    <option value=""> </option>
                                    <option value=""> </option>
                                    <option value=""> </option>
                                    <option value=""> </option>
                                    <option value=""> </option>
                                    <option value=""> </option>
                                </select>
                            </li>
                        </ul>
                        <ul>
                            <li>
                                <label for="">대표자 이메일</label>
                                <div class="email">
                                    <ul>
                                        <li><input type="text" id="" name=""></li>
                                        <li>@</li>
                                        <li>
                                            <select name="" id="">
                                                <option value="" selected>선택하세요</option>
                                                <option value="hanmail.net">hanmail.net</option>
                                                <option value="daum.net">daum.net</option>
                                                <option value="naver.com">naver.com</option>
                                                <option value="gmail.com">gmail.com</option>
                                                <option value="nate.com">nate.com</option>
                                                <option value="lycos.co.kr">lycos.co.kr</option>
                                                <option value="paran.com">paran.com</option>
                                                <option value="hanmir.com">hanmir.com</option>
                                                <option value="empal.com">empal.com</option>
                                                <option value="netian.com">netian.com</option>
                                                <option value="dreamwiz.com">dreamwiz.com</option>
                                                <option value="hanafos.com">hanafos.com</option>
                                                <option value="hananet.net">hananet.net</option>
                                                <option value="korea.com">korea.com</option>
                                                <option value="hotmail.com">hotmail.com</option>
                                                <option value="hanwha.com">hanwha.com</option>
                                                <option value="etc">기타[직접입력]</option>
                                            </select>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li>
                                <label for="">대표자 휴대전화</label>
                                <div class="phone">
                                    <ul>
                                        <li>
                                            <select name="" id="" title="휴대폰번호 첫번째 자리" class="nb">
                                                <option value="010" selected="selected">010</option>
                                                <option value="011">011</option>
                                                <option value="016">016</option>
                                                <option value="017">017</option>
                                                <option value="018">018</option>
                                                <option value="019">019</option> 
                                            </select>
                                        </li>
                                        <li>
                                            <input type="tel" id="" name="" maxlength="4" title="휴대폰 앞자리를 넣어주세요" class="nb">
                                        </li>
                                        <li>
                                            <input type="tel" id="" name="" maxlength="4" title="휴대폰 뒷자리를 넣어주세요" class="nb">
                                        </li>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="add_area">
                        <ul>
                            <li>
                                <label for="">추가 정보 <span>1</span></label>
                                <textarea name="" id=""></textarea>
                            </li>
                        </ul>
                        <ul>
                            <li>
                                <label for="">추가 정보 <span>2</span></label>
                                <textarea name="" id=""></textarea>
                            </li>
                        </ul>
                    </div>
                </div>
            </section>
            <section id="is_info">
                <ul>
                    <li><h2 class="lineh">피보험자 총 명세</h2></li>
                    <li><button type="button" name="button" class="btn_add">20명 추가</button></li>
                    <li><button type="button" name="button" class="btn_s3">선택삭제</button></li> 
                </ul>
            </section>
            <div id="is_add_lstay">
                <table id="t_list">
                    <caption>20명 추가</caption>
                    <thead>
                        <tr>
                            <th>선택</th>
                            <th>번호</th>
                            <th><span>*</span>이름</th>
                            <th>영문 이름</th>
                            <th><span>*</span>주민등록번호</th>
                            <th>나이</th>
                            <th><span>*</span>직업</th>
                            <th><span>*</span>플랜</th>
                            <th>보험료(원)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <input type="checkbox" id="n1" name="" value="" />
                                <label for="n1" class="check_bx"><span></span></label>
                            </td>
                            <td class="nb">1</td>
                            <td><input type="text" id="" name="" class="add_field"></td>
                            <td><input type="text" id="" name="" class="add_field"></td>
                            <td><input type="text" id="" name="" class="add_field"></td>
                            <td class="nb">26</td>
                            <td class="job"><button class="btn_s4">선택</button></td>
                            <td><input type="text" id="" name="" class="add_field_plan"><button type="button" name="button" class="btn_s4">변경</button></td>
                            <td class="t_price nb">19,860</td>
                        </tr>
                        <tr>
                            <td>
                                <input type="checkbox" id="n2" name="" value="" />
                                <label for="n2" class="check_bx"><span></span></label>
                            </td>
                            <td class="nb">2</td>
                            <td><input type="text" id="" name="" class="add_field"></td>
                            <td><input type="text" id="" name="" class="add_field"></td>
                            <td><input type="text" id="" name="" class="add_field"></td>
                            <td class="nb">26</td>
                            <td class="job"><button class="btn_s4">선택</button></td>
                            <td><input type="text" id="" name="" class="add_field_plan"><button type="button" name="button" class="btn_s4">변경</button></td>
                            <td class="t_price nb">19,860</td>
                        </tr>
                        <tr>
                            <td>
                                <input type="checkbox" id="n3" name="" value="" />
                                <label for="n3" class="check_bx"><span></span></label>
                            </td>
                            <td class="nb">2</td>
                            <td><input type="text" id="" name="" class="add_field"></td>
                            <td><input type="text" id="" name="" class="add_field"></td>
                            <td><input type="text" id="" name="" class="add_field"></td>
                            <td class="nb">26</td>
                            <td class="job"><button class="btn_s4">선택</button></td>
                            <td><input type="text" id="" name="" class="add_field_plan"><button type="button" name="button" class="btn_s4">변경</button></td>
                            <td class="t_price nb">19,860</td>
                        </tr>
                        <tr>
                            <td>
                                <input type="checkbox" id="n4" name="" value="" />
                                <label for="n4" class="check_bx"><span></span></label>
                            </td>
                            <td class="nb">2</td>
                            <td><input type="text" id="" name="" class="add_field"></td>
                            <td><input type="text" id="" name="" class="add_field"></td>
                            <td><input type="text" id="" name="" class="add_field"></td>
                            <td class="nb">26</td>
                            <td class="job"><button class="btn_s4">선택</button></td>
                            <td><input type="text" id="" name="" class="add_field_plan"><button type="button" name="button" class="btn_s4">변경</button></td>
                            <td class="t_price nb">19,860</td>
                        </tr>
                        <tr>
                            <td>
                                <input type="checkbox" id="n5" name="" value="" />
                                <label for="n5" class="check_bx"><span></span></label>
                            </td>
                            <td class="nb">2</td>
                            <td><input type="text" id="" name="" class="add_field"></td>
                            <td><input type="text" id="" name="" class="add_field"></td>
                            <td><input type="text" id="" name="" class="add_field"></td>
                            <td class="nb">26</td>
                            <td class="job"><button class="btn_s4">선택</button></td>
                            <td><input type="text" id="" name="" class="add_field_plan"><button type="button" name="button" class="btn_s4">변경</button></td>
                            <td class="t_price nb">19,860</td>
                        </tr>
                        <tr>
                            <td>
                                <input type="checkbox" id="n6" name="" value="" />
                                <label for="n6" class="check_bx"><span></span></label>
                            </td>
                            <td class="nb">2</td>
                            <td><input type="text" id="" name="" class="add_field"></td>
                            <td><input type="text" id="" name="" class="add_field"></td>
                            <td><input type="text" id="" name="" class="add_field"></td>
                            <td class="nb">26</td>
                            <td class="job"><button class="btn_s4">선택</button></td>
                            <td><input type="text" id="" name="" class="add_field_plan"><button type="button" name="button" class="btn_s4">변경</button></td>
                            <td class="t_price nb">19,860</td>
                        </tr>
                        <tr>
                            <td>
                                <input type="checkbox" id="n7" name="" value="" />
                                <label for="n7" class="check_bx"><span></span></label>
                            </td>
                            <td class="nb">2</td>
                            <td><input type="text" id="" name="" class="add_field"></td>
                            <td><input type="text" id="" name="" class="add_field"></td>
                            <td><input type="text" id="" name="" class="add_field"></td>
                            <td class="nb">26</td>
                            <td class="job"><button class="btn_s4">선택</button></td>
                            <td><input type="text" id="" name="" class="add_field_plan"><button type="button" name="button" class="btn_s4">변경</button></td>
                            <td class="t_price nb">19,860</td>
                        </tr>
                        <tr>
                            <td>
                                <input type="checkbox" id="n8" name="" value="" />
                                <label for="n8" class="check_bx"><span></span></label>
                            </td>
                            <td class="nb">2</td>
                            <td><input type="text" id="" name="" class="add_field"></td>
                            <td><input type="text" id="" name="" class="add_field"></td>
                            <td><input type="text" id="" name="" class="add_field"></td>
                            <td class="nb">26</td>
                            <td class="job"><button class="btn_s4">선택</button></td>
                            <td><input type="text" id="" name="" class="add_field_plan"><button type="button" name="button" class="btn_s4">변경</button></td>
                            <td class="t_price nb">19,860</td>
                        </tr>
                        <tr>
                            <td>
                                <input type="checkbox" id="n9" name="" value="" />
                                <label for="n9" class="check_bx"><span></span></label>
                            </td>
                            <td class="nb">2</td>
                            <td><input type="text" id="" name="" class="add_field"></td>
                            <td><input type="text" id="" name="" class="add_field"></td>
                            <td><input type="text" id="" name="" class="add_field"></td>
                            <td class="nb">26</td>
                            <td class="job"><button class="btn_s4">선택</button></td>
                            <td><input type="text" id="" name="" class="add_field_plan"><button type="button" name="button" class="btn_s4">변경</button></td>
                            <td class="t_price nb">19,860</td>
                        </tr>
                        <tr>
                            <td>
                                <input type="checkbox" id="n10" name="" value="" />
                                <label for="n10" class="check_bx"><span></span></label>
                            </td>
                            <td class="nb">2</td>
                            <td><input type="text" id="" name="" class="add_field"></td>
                            <td><input type="text" id="" name="" class="add_field"></td>
                            <td><input type="text" id="" name="" class="add_field"></td>
                            <td class="nb">26</td>
                            <td class="job"><button class="btn_s4">선택</button></td>
                            <td><input type="text" id="" name="" class="add_field_plan"><button type="button" name="button" class="btn_s4">변경</button></td>
                            <td class="t_price nb">19,860</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <section id="tt_price_area">
                <div id="check_all">
                    <button type="button" name="button" class="btn_s5">전체 선택</button>
                    <button type="button" name="button" class="btn_s5">전체 해제</button>
                </div>
                <div><button type="button" name="button" class="btn_count">총 납입 보험료 계산하기</button></div>
                <div>
                    <ul>
                        <li>총 인원</li>
                        <li><span class="t_num c_black">87</span><span>명</span></li>
                    </ul>
                    <ul>
                        <li>총 납입 보험료</li>
                        <li><span class="t_num c_red">80,251,370</span><span>원</span></li>
                    </ul>
                    <!--
                    <ul>
                        <li>추징/환급 보험료</li>
                        <li><span class="refund">251,370</span><span>원</span></li>
                    </ul>
                    -->
                </div>
            </section>
            <p class="ptxt">※ 장기체류 여행자 보험은 접수 후 상담을 진행하여 계약 및 결제를 진행합니다.</p>
            <section id="btn_area">
                <div class="btn_list">
                    <button type="button" name="button" class="btn_s3">삭제</button>
                    <button type="button" name="reset" class="btn_s2">초기화</button>
                    <button type="button" name="submit" class="btn_s1">접수완료</button>
                </div>
            </section>  
        </fieldset>
        </form>
    </section><!-- e : container -->

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
