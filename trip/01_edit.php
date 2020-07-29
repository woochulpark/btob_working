<? 
	include ("../include/top.php"); 

	$plan_get_que = " SELECT * FROM hana_plan WHERE no = '{$num}' and member_no = '{$_SESSION['s_mem_no']}' ";
	
	$plan_get_result = mysql_query($plan_get_que);

	if(!$plan_get_result) {
?>
	<script>
	alert('없는 플랜입니다. ');
	location.href="/main/main.php";
</script>
<?	
	exit;
	}

	$plan_get_row = mysql_fetch_array($plan_get_result);		

	if ($plan_get_row['trip_type']!='1' && $plan_get_row['trip_type']!='2') {
		
?>
<script>
	alert('잘못됩 접속 입니다..');
	location.href="../src/logout.php";
</script>
<?
	exit;
	}
	$tripType = $plan_get_row['trip_type'];
	$insuran_comp = $plan_get_row['insurance_comp'];
	$subs_no = $plan_get_row['no'];
	$plan_jcdate = $plan_get_row['plan_join_code_date'];
	$all_start_data = $plan_get_row['start_date'];
	$all_start_hour = $plan_get_row['start_hour'];
	$all_end_data   = $plan_get_row['end_date'];
	$all_end_hour  = $plan_get_row['end_hour'];
	$tripPurpose= $plan_get_row['trip_purpose'];
	$currResi = $plan_get_row['current_resi'];
	$nationNo = $plan_get_row['nation_no'];
	$memoEtc1 = $plan_get_row['etc_memo1'];
	$memoEtc2 = $plan_get_row['etc_memo2'];
	$ct1 = $plan_get_row['check_type_1'];
	$ct2 = $plan_get_row['check_type_2'];
	$ct3 = $plan_get_row['check_type_3'];
	$ct4 = $plan_get_row['check_type_4'];
	$ct5 = $plan_get_row['check_type_5'];
	$selAgre = $plan_get_row['select_agree'];
	$planType=  $plan_get_row['plan_type'];
	$comPlan = $plan_get_row['common_plan'];
	
?>
<script>
	var oneDepth = 1; //1차 카테고리
	
	var tripType="<?=$tripType?>";
	var total_won = 0;
	set_limit(<?=$tripType?>);
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
			maxDate: "+6M",

			onClose: function( selectedDate ) {    
				$("#end_date").val("");
				$("#end_date").datepicker("enable");
				$("#end_date").datepicker( "option", "minDate", new Date(Date.parse(selectedDate)) );
				<?// if ($tripType == '2'){ ?>
				
					var limitmonth = (get_limit() == 2)?3:1;
				$("#end_date").datepicker( "option", "maxDate", new Date(Date.parse(treemonthcal(selectedDate, limitmonth))) );
				<? //} elseif ($tripType == '1'){ ?>
				//$("#end_date").datepicker( "option", "maxDate", new Date(Date.parse(selectedDate) + (1000 * 60 * 60 * 24 * 30)) );
				//$("#end_date").datepicker( "option", "maxDate", new Date(Date.parse(treemonthcal(selectedDate, '1'))) );
				<?// } ?>

				view_reset();
				resetPlPr('');
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
				resetPlPr('');
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

		//$("#end_date").datepicker("disable");

		$("#start_hour,#end_hour").change(function(){
			view_reset();
			resetPlPr('');
		});
		
		$("#start_hour,#end_hour, #end_date").change(function(){

			if(get_limit() == 2){				
				if(!check_hour_max('start_date', 'end_date','start_hour','end_hour')){					
					$('#end_date').val('');
				}
			} else {
				if(!check_hour_max('start_date', 'end_date','start_hour','end_hour')){
					$('#end_date').val('');
				}
			}
		});
		
		if ("<?=$tripType?>" == '1') {
			$("#bound_1").prop("checked", true).change();
		} else if ("<?=$tripType?>" == '2') {
			$("#bound_2").prop("checked", true).change();
		} 

		//var rt = $("#right_wrap").offset().top + 56;
        var rt = $("#h1").offset().top + 56;   
			

		$(window).scroll(function () {
			var th = $("#header").outerHeight() + $(".join_step").outerHeight();
			var wt = $(window).scrollTop();

			if(wt >= rt){
				$("#h1").addClass("pa_aa");
			}else if(wt < rt) {
				$("#h1").removeClass("pa_aa");
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
		
		$('#bulk_confirm').on('click',function(){
			$('#bulk_confirm').prop('checked', false);
			//약관 확인 및 일괄 확인 레이어 팝업
		}); 

	}); //on ready 




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
	/*
	<?
		$session_val=time()."_".$type."_".$_SERVER['REMOTE_ADDR'];
$session_key =encode_pass($session_val,$pass_key);
$_SESSION['s_session_key']=$session_key;
print_r($_SESSION);
	?>
	*/
</script>

<div id="wrap">
	<div id="inner_wrap">
		<!-- header -->
		<? include ("../include/header.php"); ?>
			<!-- //header -->
			<!-- container -->
			<section id="container">
        <section id="h1">
            <div><h1><?=($tripType == 1)? '국내':'해외';?> 여행자 보험가입</h1></div>
            <div><span class="dot">*</span><span class="c_red">표시는 필수로입력하시기 바랍니다.<!--<?print_r($_SESSION)?>--></span></div>
        </section>
        <section id="ac_info">
            <table id="t_info">
                <tbody>
                    <tr>
                        <th>거래처 ID</th>
                        <td class="nb"><?=$_SESSION['s_mem_id']?></td class="nb">
                        <th>거래처명</th>
                        <td><?=$_SESSION['s_mem_com']?></td>
                        <th>청약번호</th>
                        <td class="nb"><?=$subs_no?></td>
                        <th>청약일</th>
                        <td class="nb"><?=$plan_jcdate?></td>
                    </tr>
                </tbody>
            </table>
        </section>
        <form action="" method="POST" name="formBox" id="formBox">
		<input type="hidden" name="trip_Type" value="<?=$tripType?>" />
		<input type="hidden" name="plan_Code" value="<?=$subs_no?>" />
		<input type="hidden" name="write_pattern" value="edimode" />
        <fieldset>
            <section id="ssc_info">
                <div class="tit"><h2>청약 정보</h2></div>
                <div class="textBox">
                    <div class="write_area">
                        <ul>
                            <li>
                                <label for=""><span class="dot">*</span><span class="c_red">보험사 선택</span></label>
                                <select name="selinsuran" id="selinsuran">
								<option value="">선택</option>
									<?
										foreach($insuran_option as $k=>$v){ 
											if($v != 'L_1' && $v != 'L_2'){
												//$chk_sel = explode('_',$v);												
									?>
	                                    <option value="<?=$v?>" <?=($v == $insuran_comp)?'selected':'';?> ><?=$k?></option>
									<?
											}
										}
									?>                                                    
                                </select>								
                            </li>
                            <li class="calendar">
                                <label for=""><span class="dot">*</span><span class="c_red">여행 기간</span></label> 
                                <div>
                                    <span class="day_form">
										<span class="date_picker2">
                                        <input type="text" id="start_date" name="start_date" value="<?=($all_start_data != '') ? $all_start_data:'';?>" style="border:0px;height:26px; width: 100px; padding-left: 3px; padding-right: 3px;" readonly >
										</span>
                                    </span>
                                    <span class="time">
                                        <select name="start_hour" id="start_hour" class="nb">
                                             <? for ($i=0;$i<24;$i++) { ?>
												 <option value="<?=sprintf("%02d", $i)?>" <?=($all_start_hour == sprintf("%02d", $i))?'selected':'';?> ><?=sprintf("%02d", $i)?>시</option>
										 <? } ?>
                                        </select>
                                    </span>
                                </div>
                                <div>
                                    <span class="day_form">
									<span class="date_picker2">
                                        <input type="text" id="end_date" name="end_date" value="<?=($all_end_data != '') ?$all_end_data:'';?>" style="border:0px;height:26px; width: 100px; padding-left: 3px; padding-right: 3px;" readonly >
										</span>
                                    </span>
                                    <span class="time">
                                        <select name="end_hour" id="end_hour" class="nb">
                                            <? for ($i=1;$i<25;$i++) { ?>
												 <option value="<?=sprintf("%02d", $i)?>" <?=($all_end_hour == sprintf("%02d", $i))?'selected':'';?>><?=sprintf("%02d", $i)?>시</option>
										 <? } ?>
                                        </select>
                                    </span>
                                </div>
                            </li>
                        </ul>
                        <ul>
                            <li>
                                <label for=""><span class="dot">*</span><span class="c_red">여행지</span></label>
                                <!--div class="wBox"-->
									<select id="nation" name="nation">
									<?
										if($tripType != 1){
									?>
										<option value="">선택</option>
										<?
											$sql_nation="select no, nation_name from nation  order by nation_name asc";
											$result_nation=mysql_query($sql_nation) or die(mysql_error());
											while($row_nation=mysql_fetch_array($result_nation)) {											
										?>
												<option value="<?=$row_nation['no']?>" <?=($row_nation['no'] == $nationNo)?"selected":"";?> ><?=$row_nation['nation_name']?></option>
										<?
											}
										} else {
										?>
												<option value="0">국내일원</option>
										<?
										}
										?>
									</select>
									<input type="hidden" id="select_nation" name="select_nation" value="<?=($nationNo != '')?"Y":"N";?>">
								<?/*</div>
                                <div class="btn"><button type="button" id="ch_nation" class="btn_s4" <?=($tripType < 2)?" disabled ": ""; ?>>선택</button></div>*/?>
                            </li>
                            <li>
                                <label for=""><span class="dot">*</span><span class="c_red">여행 목적</span></label>
                                <select name="trip_purpose" id="trip_purpose" onchange="trip_purpose_change(this.value);">
                                    <option value="">선택</option>
									<?
										foreach($trip_purpose_array as $k=>$v){
									?>
									<option value="<?=$k?>" <?=($k == $tripPurpose)?"selected":"";?> ><?=$v?></option>
									<?
										}
									?>
                                </select>
                            </li>
                        </ul>
                        <ul>
						<?/*
                            <li>
                                <label for=""><span class="dot">*</span><span class="c_red">공통 플랜</span></label>
                                <div class="wBox"><input type="text" id="" name="" readonly></div>
                                <div class="btn"><button type="button" id="common_plan_pop" class="btn_s4">선택</button></div>
                            </li>
						*/?>
                            <li>
                                <label for=""><span class="dot">*</span><span class="c_red">현재 체류지</span></label>
                                <div class="stay">
                                    <ul>
                                        <li>
                                            <input type="radio" id="r1" name="rr" value="2" <?=($currResi == '2')?"checked":"";?> />
                                            <label for="r1" class="radio_bx"  ><span></span>해외</label>
                                        </li>
                                        <li>
                                            <input type="radio" id="r2" name="rr" value="1" <?=($currResi == '1')?"checked":"";?> />
                                            <label for="r2" class="radio_bx"><span></span>국내</label>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                        </ul>
						<?
							$contact_que = " SELECT email, hphone FROM hana_plan_member WHERE hana_plan_no = '{$num}' and member_no = '{$_SESSION['s_mem_no']}' and main_check = 'Y'   ";
							
							$contact_result = mysql_query($contact_que);
							$contact_row = mysql_fetch_array($contact_result);
							if($contact_row['email'] != ''){
								$frontMail = decode_pass($contact_row['email'],$pass_key);
								$arr_Mail = explode("@",$frontMail);
							} else {
								$arr_Mail = array();
							}		
							
							if($contact_row['hphone'] != ''){
								$phone_decry = decode_pass($contact_row['hphone'],$pass_key);								
								$phone_first = substr($phone_decry, 0,3);
								$phone_mid = substr($phone_decry, 3,4);
								$phone_last = substr($phone_decry, 7,4);
							} else {
								$phone_first = '';
								$phone_mid = '';
							    $phone_last = '';
							}

							$first_put_que = "select * from hana_plan_change where hana_plan_no = '{$num}' limit 1 ";
							$first_put_result = mysql_query($first_put_que);						
							$first_put_row = mysql_fetch_array($first_put_result);
							$first_put_money = $first_put_row['change_price'];
						?>
                        <ul>
                            <li>
                                <label for="">대표자 이메일</label>
                                <div class="email">
                                    <ul>
                                        <li><input type="text" id="mail_f" name="mail_f" value="<?=trim(stripslashes($arr_Mail[0]))?>"></li>
                                        <li>@</li>
										 <li><input type="text" id="mail_b" name="mail_b" value="<?=trim(stripslashes($arr_Mail[1]))?>" readonly></li>
                                        <li>
                                            <select name="mail_b_sel" id="mail_b_sel">
                                                <option value="" >선택하세요</option>
                                                <?
													$mail_chk_arr = array();
													foreach($email_array as $k=>$v){
												?>
												<option value="<?=$v?>" <?=($v==trim($arr_Mail[1]))?"selected":"";?> ><?=$v?></option>
												<?
													if($v == trim($arr_Mail[1])){$mail_chk_arr[] = "Y";} else {$mail_chk_arr[] = "N";}
													}
												?>
                                                <option value="etc" <?=(!in_array("Y",$mail_chk_arr))?"selected":"";?> >기타[직접입력]</option>
                                            </select>										
                                        </li>
                                    </ul>
                                </div>
                            </li>                            
                        </ul>
						<ul>
							<li>
                                <label for="">대표자 휴대전화</label>
                                <div class="phone">
                                    <ul>
                                        <li>
                                            <select name="phonef" id="phonef" title="휴대폰번호 첫번째 자리" class="nb">
												<option value="">선택</option>
												<?
													foreach($hp_array as $k=>$v){
												?>
													<option value="<?=$v?>" <?=($v == $phone_first)?"selected":"";?> ><?=$v?></option>
												<?
													}
												?>
                                            </select>
                                        </li>
                                        <li>
                                            <input type="tel" id="phonem" name="phonem" maxlength="4" title="휴대폰 앞자리를 넣어주세요" value="<?=$phone_mid?>" class="nb">
                                        </li>
                                        <li>
                                            <input type="tel" id="phonel" name="phonel" maxlength="4" title="휴대폰 뒷자리를 넣어주세요" value="<?=$phone_last?>" class="nb">
                                        </li>
                                    </ul>
                                </div>
                            </li>
						</ul>
                    </div>
                    <div class="add_area">
                        <ul>
                            <li>
                                <label for="">추가 정보 1</label>
                                <textarea name="etc_memo1" id="etc_memo1"><?=$memoEtc1?></textarea>
                            </li>
                        </ul>
                        <ul>
                            <li>
                                <label for="">추가 정보 2</label>
                                <textarea name="etc_memo2" id="etc_memo2"><?=$memoEtc2?></textarea>
                            </li>
                        </ul>
                    </div>
                    <div id="check">
                        <ul>
                            <li>
                                <span class="dot">*</span><span class="c_red">계약 시 알릴사항 일괄 확인</span> <span><input type="checkbox" id="bulk_confirm" name="" value="" <?=($ct1 == 'Y' && $ct2 == 'Y' && $ct3 == 'Y' && $ct4 == 'Y' && $ct5 == 'Y' && $selAgre == 'Y')?"checked":"";?> /><label for="bulk_confirm" class="check_bx"><span></span></label></span>
								<input type="hidden" name="notice_confirm" id ="notice_confirm" value="<?=($ct1 == 'Y' && $ct2 == 'Y' && $ct3 == 'Y' && $ct4 == 'Y' && $ct5 == 'Y')?"Y":"N";?>" />
								<input type="hidden" name="contract_confirm" id="contract_confirm" value="<?=($selAgre == "Y")?"Y":"N";?>" />
                            </li>
                        </ul>
                    </div">
                </div>
            </section>
            <!--<div class="line"></div>-->
            <section id="is_info">
                <ul>
                    <li><h2 class="lineh">피보험자 총 명세</h2></li>
                    <li>&nbsp;<?//<button type="button" id="plusbt" class="btn_add">20명 추가</button>?></li>
					<li>
						<!--label for="" style="float:left;" class="aaa"><span class="dot">*</span><span class="c_red">공통 플랜</span></label-->
						<div><span class="dot" >*</span><span class="c_red">공통 플랜</span></div>
						<div class="wBox"><input type="text" id="common_plan" name="common_plan" value="<?=$comPlan?>" readonly></div>
						<div class="btn"><button type="button" id="common_plan_pop" class="btn_s4">선택</button></div>
						<input type="hidden" id="plan_chk" name="plan_chk" value="<?=$comPlan?>">
						<input type="hidden" name="plan_type" value="<?=$planType?>" />
					</li>
                    <li><button type="button" id="selcbt" class="btn_s3">선택취소</button></li> 
                </ul>
            </section>
			<div><span class="dot" style="vertical-align:bottom;">*</span><span class="c_red" style="vertical-align:top;font-weight:400">공통으로 적용될 플랜을 선택해 주세요. (공통 플랜이 적용되며 세부적으로 [변경]버튼을 이용하여 변경 가능합니다.)</span></div>
            <div id="is_add">
                <table id="t_list">
                    <caption>20명 추가</caption>
                    <thead>
                        <tr>
                            <th>선택</th>
                            <th>번호</th>
                            <th><span class="dot">*</span><span class="c_red">이름</span></th>
                            <th>영문 이름</th>
                            <th><span class="dot">*</span><span class="c_red">주민등록번호</span></th>
                            <th>나이</th>
                            <th><span class="dot">*</span><span class="c_red">플랜</span></th>
                            <th>보험료(원)</th>
                        </tr>
                    </thead>
                    <tbody>
						<?
							$get_mem_info_que = " SELECT * FROM hana_plan_member where member_no = '{$_SESSION['s_mem_no']}' AND hana_plan_no = '{$num}' ";
							$get_mem_info_res = mysql_query($get_mem_info_que);
							if(!isset($get_mem_info_res)){
								$mems_info_arr = array('','','','','','','','','','');
							}  else {
								$arr_in = 0;
								$availNpeople = 0;
								while($get_mem_info_row = mysql_fetch_array($get_mem_info_res)){
									$outInfo['memno'][] = $get_mem_info_row['no'];
									$outInfo['name'][] = $get_mem_info_row['name'];
									$outInfo['eng_name'][] = $get_mem_info_row['name_eng'];
									$outInfo['jumin'][] = trim(decode_pass($get_mem_info_row['jumin_1'],$pass_key))."-".trim(decode_pass($get_mem_info_row['jumin_2'],$pass_key));
									//$outInfo['jumin2'][] = decode_pass($get_mem_info_row['jumin_2'],$pass_key);
									$outInfo['planCode'][] = $get_mem_info_row['plan_code'];
									$outInfo['planTitle'][] = $get_mem_info_row['plan_title'];
									$outInfo['age'][] = $get_mem_info_row['age'];
									$outInfo['planPrice'][] = $get_mem_info_row['plan_price'];
									$outInfo['planState'][] = $get_mem_info_row['plan_state'];
									$outInfo['mainCheck'][] =  $get_mem_info_row['main_check'];
									if($get_mem_info_row['plan_state'] != 3){
										$availNpeople++;
									}
									$arr_in++;
								}
							}

							foreach($outInfo['jumin'] as $k=>$v){

								$m = $k + 1;
						?>

                        <tr>
                            <td>								
                                <input type="checkbox" id="n<?=$m?>" name="nob[]" <?=($m < 2)?"disabled Onclick=\"javascript:alert('대표자는 취소 불가');\"":"";?>>
								<label for="n<?=$m?>" class="check_bx">
								<input type="hidden" name="memnov[]" value="<?=$outInfo['memno'][$k]?>" />
								<input type="hidden" name="mainv[]" value="<?=$outInfo['mainCheck'][$k]?>"/>
								<span></span></label>
                            </td>
                            <td class="nb <?=($outInfo['planPrice'][$k] == 0 && $outInfo['planState'][$k] == 3)?"cancelpoint":"";?>"<?=($outInfo['planPrice'][$k]==0 && $outInfo['planState'][$k] == 3)?" cancel_light=\"red\"  ":"cancel_light=''";?> >
						<input type="hidden" name="plan_state[]" value="<?=$outInfo['planState'][$k]?>" />	
						<?=$m?></td>
                            <td><input type="text" name="input_name[]" class="add_field" value="<?=$outInfo['name'][$k]?>" ></td>
                            <td><input type="text" name="input_eng_name[]" class="add_field" value="<?=$outInfo['eng_name'][$k]?>"></td>
                            <td><input type="text" name="juminno[]" class="add_field" value="<?=$outInfo['jumin'][$k]?>"></td>
                            <td class="nb"><?=$outInfo['age'][$k]?><input type="hidden" name="hage[]" value="<?=$outInfo['age'][$k]?>"></td>
                            <td><input type="text" name="plan_code[]" class="add_field_plan" value="<?=$outInfo['planCode'][$k]?>" readonly >
								
								<input type="hidden" name="plan_title[]" value="<?=$outInfo['planTitle'][$k]?>" />
							<button type="button" name="ch_particul_plan" name="ch_particul_plan" class="btn_s4">변경</button></td>
                            <td class="t_price nb"><?=number_format($outInfo['planPrice'][$k])?><input type="hidden" name="particul_price[]" value="<?=$outInfo['planPrice'][$k]?>"></td>
                        </tr>
						<?
							}
								?>
                    </tbody>
                </table>
            </div>
			<div><span class="dot" style="vertical-align:bottom;">*</span><span class="c_red" style="vertical-align:top;font-weight:400">다수의 피보험자 명세를 입력 시 엑셀문서에서 "복사하기/붙여넣기"를 이용하시면 편리하게 입력하실 수 있습니다.</span></div>
            <section id="tt_price_area">
                <div id="check_all">
                    <button type="button"  class="btn_s5" id="allcbt">전체 선택</button>
                    <button type="button"  class="btn_s5" id="allnbt">전체 해제</button>
                </div>
                <div><button type="button" id="cal_insuran_tot" class="btn_count">총 납입 보험료 계산하기</button></div>
                <div>
                    <ul>
                        <li>총 인원</li>
                        <li><span class="t_num c_black" chkallp='<?=number_format($availNpeople)?>' id='talp'><?=number_format($availNpeople)?></span><span>명</span></li>
                    </ul>
                    <ul>
                        <li>총 납입 보험료</li>
                        <li><span class="t_num c_red" chkallam='<?=array_sum($outInfo['planPrice'])?>' id='tala'><?=number_format(array_sum($outInfo['planPrice']))?></span><span>원</span></li>
                    </ul>
					<?
					?>
                    <ul>
                        <li>추징/환급 보험료</li>
                        <li><span class="t_num c_blue" chkEdiallam='' id='tcala'><?=number_format(($first_put_money - array_sum($outInfo['planPrice'])))?></span><span>원</span></li>
                    </ul>					
					<?
					?>
                </div>
            </section>
            <section id="btn_area">
                <div class="btn_list">
                    <?/*<button type="button" name="button" class="btn_s3">삭제</button>*/?>
                    <button type="reset" name="reset_can" class="btn_s2">초기화</button>
                    <button type="button" name="subscript" class="btn_s1">수정하기</button>
                </div>
            </section>  
        </fieldset>
        </form>
		<!-- clone sheet start -->
			<table id="b2b_clone" style="display:none;">
				<tbody>
					<tr>						
						 <td>
                                <input type="checkbox" name="nob[]">
								<label class="check_bx"><span></span></label>
                            </td>
                            <td class="nb"></td>
                            <td><input type="text" name="input_name[]" class="add_field"></td>
                            <td><input type="text" name="input_eng_name[]" class="add_field"></td>
                            <td><input type="text" name="juminno[]" class="add_field"></td>
                            <td class="nb"><input type="hidden" name="hage[]" value=""></td>
                            <td><input type="text" name="plan_code[]" class="add_field_plan" readonly >
										
								<input type="hidden" name="plan_title[]" value="" />
							<button type="button" name="ch_particul_plan" class="btn_s4">변경</button></td>
                            <td class="t_price nb">0<input type="hidden" name="particul_price[]" value="0"></td>
					</tr>
				</tbody>
			  </table>

		<!-- clone sheet end -->
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

</body>
<script type="text/javascript">
	/*
	$('#nation').on('change',function(){
		$('#select_nation').val('N');
	});
*/
	//$('#ch_nation').on('click',function(){
		$('#nation').on('change',function(){
		var nation_no = $('#nation :selected').val();
		if(nation_no > 0){
			$.post('../src/nation_chk.php', {nation:nation_no }, function (data){			
				if (data.result=="true") {
							//if(data.msg){ 
							//$("#com_search_val").empty();
							var prt_msg = JSON.stringify(data.msg);
							var bbb="";
							var se_win_po;
							
							var ccc = JSON.parse(prt_msg);
							alert(ccc);
							resetPlPr('plan');
							$('#select_nation').val('Y');
				} else {
						var error_msg = JSON.stringify(data.msg)
						alert(error_msg);
							$('#nation option:eq(0)').attr('selected','selected');
				}
			},"json");
		} else {
			alert('여행지를 선택해주세요');
			return false;
		}
	});

	$('button[name=reset_can]').on('click',function(){
		
		console.log('바보');
		location.reload();
		console.log('멍청이');
	});
</script>
<script type="text/javascript" src="/js/multi_trip.js"></script>
</html>
