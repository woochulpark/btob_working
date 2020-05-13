<? 
	include ("../include/top.php"); 

	session_start("s_session_key");

	$session_val=time()."_".$tripType."_".$row_mem_info['no'];
	$session_key =encode_pass($session_val,$pass_key);
	$_SESSION['s_session_key']=$session_key;

	$check_key=time()."_".rand(10000,99999).$row_mem_info['no'];

	$currDate = date("Y-m-d");
	
	$all_birth_data = '';
	$all_sex_data = '';
	$all_start_data = '';
	$all_start_hour = '';
	$all_end_data = '';
	$all_end_hour = '';
	$all_jumin_no = '';

	if(!isset($_GET['join_data'])){

	} else {
		$array_simple = base64_decode($_GET['join_data']);
		$row_simple = explode("//-//",$array_simple);		
		$all_birth_data = $row_simple[1];
		$all_start_data  = $row_simple[3];
		$all_start_hour = $row_simple[4];
		$all_end_data = $row_simple[5];
		$all_end_hour = $row_simple[6];

		$birth_year = substr($all_birth_data,0,4);
		$cut_jumin = substr($all_birth_data,2,6);
		
		if($birth_year >= 1800 && $birth_year <= 1899){
			if($row_simple[2] == 'male'){
				$all_sex_data = 9;
			}  else {
				$all_sex_data = 0;
			}
		} else if($birth_year >= 1900 && $birth_year <= 1999){
			if($row_simple[2] == 'male'){
				$all_sex_data = 1;
			}  else {
				$all_sex_data = 2;			
			}
		} else if($birth_year >= 2000 && $birth_year <= 2999){
			if($row_simple[2] == 'male'){
				$all_sex_data = 3;			
			}  else {
				$all_sex_data = 4;			
			}
		}	
		$all_jumin_no = $cut_jumin."-".$all_sex_data;
		/*
		Array
(
    [0] =&gt; oversea
    [1] =&gt; 19750419
    [2] =&gt; male
    [3] =&gt; 2020-03-18
    [4] =&gt; 00
    [5] =&gt; 2020-03-31
    [6] =&gt; 01
)
*/
	}
	
	

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
<script>
	var oneDepth = 1; //1차 카테고리
	
	var tripType="<?=$tripType?>";
	var total_won = 0;
	set_limit(<?=$_GET['tripType']?>);
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

		$("#end_date").datepicker("disable");

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
            <div><h1><?=($_GET['tripType'] == 1)? '국내':'해외';?> 여행자 보험가입</h1></div>
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
                        <td class="nb">12346979</td>
                        <th>청약일</th>
                        <td class="nb">2019-12-26</td>
                    </tr>
                </tbody>
            </table>
        </section>
        <form action="" method="" id="formBox">
		<input type="hidden" name="trip_Type" value="<?=$_GET['tripType']?>" />
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
												$chk_sel = explode('_',$v);												
									?>
	                                    <option value="<?=$v?>" <?=($chk_sel[1] == $_GET['insuboth'])?'selected':'';?> ><?=$k?></option>
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
                                        <input type="text" id="start_date" name="" value="<?=($all_start_data != '') ? $all_start_data:'';?>" style="border:0px;height:26px; width: 100px; padding-left: 3px; padding-right: 3px;" readonly >
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
                                        <input type="text" id="end_date" name="" value="<?=($all_end_data != '') ?$all_end_data:'';?>" style="border:0px;height:26px; width: 100px; padding-left: 3px; padding-right: 3px;" readonly >
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
                                <div class="wBox">
									<select id="nation" name="nation">
									<?
										if($_GET['tripType'] != 1){
									?>
										<option value="">선택</option>
										<?
											$sql_nation="select no, nation_name from nation  order by nation_name asc";
											$result_nation=mysql_query($sql_nation) or die(mysql_error());
											while($row_nation=mysql_fetch_array($result_nation)) {											
										?>
												<option value="<?=$row_nation['no']?>"><?=$row_nation['nation_name']?></option>
										<?
											}
										} else {
										?>
												<option value="0">국내일원</option>
										<?
										}
										?>
									</select>
									<input type="hidden" id="select_nation" name="select_nation" value="N">
								</div>
                                <div class="btn"><button type="button" id="ch_nation" class="btn_s4" <?=($_GET['tripType'] < 2)?" disabled ": ""; ?>>선택</button></div>
                            </li>
                            <li>
                                <label for=""><span class="dot">*</span><span class="c_red">여행 목적</span></label>
                                <select name="trip_purpose" id="trip_purpose" onchange="trip_purpose_change(this.value);">
                                    <option value="">선택</option>
									<?
										foreach($trip_purpose_array as $k=>$v){
									?>
									<option value="<?=$k?>"><?=$v?></option>
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
                                            <input type="radio" id="r1" name="rr" value="해외" />
                                            <label for="r1" class="radio_bx"><span></span>해외</label>
                                        </li>
                                        <li>
                                            <input type="radio" id="r2" name="rr" value="국내" />
                                            <label for="r2" class="radio_bx"><span></span>국내</label>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                        <ul>
                            <li>
                                <label for="">대표자 이메일</label>
                                <div class="email">
                                    <ul>
                                        <li><input type="text" id="mail_f" name="mail_f"></li>
                                        <li>@</li>
										 <li><input type="text" id="mail_b" name="mail_b" readonly></li>
                                        <li>
                                            <select name="mail_b_sel" id="mail_b_sel">
                                                <option value="" selected>선택하세요</option>
                                                <?
													foreach($email_array as $k=>$v){
												?>
												<option value="<?=$v?>"><?=$v?></option>
												<?
													}
												?>
                                                <option value="etc">기타[직접입력]</option>
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
                                            <select name="" id="" title="휴대폰번호 첫번째 자리" class="nb">
												<option value="">선택</option>
												<?
													foreach($hp_array as $k=>$v){
												?>
													<option value="<?=$v?>"><?=$v?></option>
												<?
													}
												?>
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
                                <label for="">추가 정보 1</label>
                                <textarea name="" id=""></textarea>
                            </li>
                        </ul>
                        <ul>
                            <li>
                                <label for="">추가 정보 2</label>
                                <textarea name="" id=""></textarea>
                            </li>
                        </ul>
                    </div>
                    <div id="check">
                        <ul>
                            <li>
                                <span class="dot">*</span><span class="c_red">계약 시 알릴사항 일괄 확인</span> <span><input type="checkbox" id="bulk_confirm" name="" value="" /><label for="bulk_confirm" class="check_bx"><span></span></label></span>
								<input type="hidden" name="notice_confirm" id ="notice_confirm" value="N" />
								<input type="hidden" name="contract_confirm" id="contract_confirm" value="N" />
                            </li>
                        </ul>
                    </div">
                </div>
            </section>
            <!--<div class="line"></div>-->
            <section id="is_info">
                <ul>
                    <li><h2 class="lineh">피보험자 총 명세</h2></li>
                    <li><button type="button" id="plusbt" class="btn_add">20명 추가</button></li>
					<li>
						<!--label for="" style="float:left;" class="aaa"><span class="dot">*</span><span class="c_red">공통 플랜</span></label-->
						<div><span class="dot" >*</span><span class="c_red">공통 플랜</span></div>
						<div class="wBox"><input type="text" id="common_plan" name="common_plan" readonly></div>
						<div class="btn"><button type="button" id="common_plan_pop" class="btn_s4">선택</button></div>
						<input type="hidden" id="plan_chk" name="plan_chk">
					</li>
                    <li><button type="button" id="seldbt" class="btn_s3">선택삭제</button></li> 
                </ul>
            </section>
			<div><span class="dot" style="vertical-align:bottom;">*</span><span class="c_red" style="vertical-align:top;font-weight:400">다수의 피보험자 명세를 입력 시 엑셀문서에서 "복사하기/붙여넣기"를 이용하시면 편리하게 입력하실 수 있습니다.</span></div>
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
                        <tr>
                            <td>
                                <input type="checkbox" id="n1" name="nob[]">
								<label for="n1" class="check_bx"><span></span></label>
                            </td>
                            <td class="nb">1</td>
                            <td><input type="text" id="" name="input_name[]" class="add_field"></td>
                            <td><input type="text" id="" name="input_eng_name[]" class="add_field"></td>
                            <td><input type="text" id="" name="juminno[]" class="add_field" value="<?=($all_jumin_no != "") ? $all_jumin_no:''; ?>"></td>
                            <td class="nb"><input type="hidden" name="hage[]" value=""></td>
                            <td><input type="text" id="" name="plan_code[]" class="add_field_plan" readonly ><button type="button" name="ch_particul_plan" name="ch_particul_plan" class="btn_s4">변경</button></td>
                            <td class="t_price nb">0<input type="hidden" name="particul_price[]" value="0"></td>
                        </tr>
                        <tr>
                            <td>
									<input type="checkbox" id="n2" name="nob[]">
									<label for="n2" class="check_bx"><span></span></label>
                            </td>
                            <td class="nb">2</td>
                            <td><input type="text" id="" name="input_name[]" class="add_field"></td>
                            <td><input type="text" id="" name="input_eng_name[]" class="add_field"></td>
                            <td><input type="text" id="" name="juminno[]" class="add_field"></td>
                            <td class="nb"><input type="hidden" name="hage[]" value=""></td>
                            <td><input type="text" id="" name="plan_code[]" class="add_field_plan" readonly ><button type="button" name="ch_particul_plan" class="btn_s4">변경</button></td>
                            <td class="t_price nb">0<input type="hidden" name="particul_price[]" value="0"></td>
                        </tr>
                        <tr>
                            <td>
                                <input type="checkbox" id="n3" name="nob[]">
								<label for="n3" class="check_bx"><span></span></label>
                            </td>
                            <td class="nb">3</td>
                            <td><input type="text" id="" name="input_name[]" class="add_field"></td>
                            <td><input type="text" id="" name="input_eng_name[]" class="add_field"></td>
                            <td><input type="text" id="" name="juminno[]" class="add_field"></td>
                            <td class="nb"><input type="hidden" name="hage[]" value=""></td>
                            <td><input type="text" id="" name="plan_code[]" class="add_field_plan" readonly ><button type="button" name="ch_particul_plan" class="btn_s4">변경</button></td>
                            <td class="t_price nb">0<input type="hidden" name="particul_price[]" value="0"></td>
                        </tr>
                        <tr>
                            <td>
                                <input type="checkbox" id="n4" name="nob[]">
								<label for="n4" class="check_bx"><span></span></label>
                            </td>
                            <td class="nb">4</td>
                            <td><input type="text" id="" name="input_name[]" class="add_field"></td>
                            <td><input type="text" id="" name="input_eng_name[]" class="add_field"></td>
                            <td><input type="text" id="" name="juminno[]" class="add_field"></td>
                            <td class="nb"><input type="hidden" name="hage[]" value=""></td>
                            <td><input type="text" id="" name="plan_code[]" class="add_field_plan" readonly ><button type="button" name="ch_particul_plan" class="btn_s4">변경</button></td>
                            <td class="t_price nb">0<input type="hidden" name="particul_price[]" value="0"></td>
                        </tr>
                        <tr>
                            <td>
                                <input type="checkbox" id="n5" name="nob[]">
								<label for="n5" class="check_bx"><span></span></label>
                            </td>
                            <td class="nb">5</td>
                            <td><input type="text" id="" name="input_name[]" class="add_field"></td>
                            <td><input type="text" id="" name="input_eng_name[]" class="add_field"></td>
                            <td><input type="text" id="" name="juminno[]" class="add_field"></td>
                            <td class="nb"><input type="hidden" name="hage[]" value=""></td>
                            <td><input type="text" id="" name="plan_code[]" class="add_field_plan" readonly ><button type="button" name="ch_particul_plan" class="btn_s4">변경</button></td>
                            <td class="t_price nb">0<input type="hidden" name="particul_price[]" value="0"></td>
                        </tr>
                        <tr>
                            <td>
                                <input type="checkbox" id="n6" name="nob[]">
								<label for="n6" class="check_bx"><span></span></label>
                            </td>
                            <td class="nb">6</td>
                            <td><input type="text" id="" name="input_name[]" class="add_field"></td>
                            <td><input type="text" id="" name="input_eng_name[]" class="add_field"></td>
                            <td><input type="text" id="" name="juminno[]" class="add_field"></td>
                            <td class="nb"><input type="hidden" name="hage[]" value=""></td>
                            <td><input type="text" id="" name="plan_code[]" class="add_field_plan" readonly ><button type="button" name="ch_particul_plan" class="btn_s4">변경</button></td>
                            <td class="t_price nb">0<input type="hidden" name="particul_price[]" value="0"></td>
                        </tr>
                        <tr>
                            <td>
                                <input type="checkbox" id="n7" name="nob[]">
								<label for="n7" class="check_bx"><span></span></label>
                            </td>
                            <td class="nb">7</td>
                            <td><input type="text" id="" name="input_name[]" class="add_field"></td>
                            <td><input type="text" id="" name="input_eng_name[]" class="add_field"></td>
                            <td><input type="text" id="" name="juminno[]" class="add_field"></td>
                            <td class="nb"><input type="hidden" name="hage[]" value=""></td>
                            <td><input type="text" id="" name="plan_code[]" class="add_field_plan" readonly ><button type="button" name="ch_particul_plan" class="btn_s4">변경</button></td>
                            <td class="t_price nb">0<input type="hidden" name="particul_price[]" value="0"></td>
                        </tr>
                        <tr>
                            <td>
                                <input type="checkbox" id="n8" name="nob[]">
								<label for="n8" class="check_bx"><span></span></label>
                            </td>
                            <td class="nb">8</td>
                            <td><input type="text" id="" name="input_name[]" class="add_field"></td>
                            <td><input type="text" id="" name="input_eng_name[]" class="add_field"></td>
                            <td><input type="text" id="" name="juminno[]" class="add_field"></td>
                            <td class="nb"><input type="hidden" name="hage[]" value=""></td>
                            <td><input type="text" id="" name="plan_code[]" class="add_field_plan" readonly ><button type="button" name="ch_particul_plan" class="btn_s4">변경</button></td>
                            <td class="t_price nb">0<input type="hidden" name="particul_price[]" value="0"></td>
                        </tr>
                        <tr>
                            <td>
                                <input type="checkbox" id="n9" name="nob[]">
								<label for="n9" class="check_bx"><span></span></label>
                            </td>
                            <td class="nb">9</td>
                            <td><input type="text" id="" name="input_name[]" class="add_field"></td>
                            <td><input type="text" id="" name="input_eng_name[]" class="add_field"></td>
                            <td><input type="text" id="" name="juminno[]" class="add_field"></td>
                            <td class="nb"><input type="hidden" name="hage[]" value=""></td>
                            <td><input type="text" id="" name="plan_code[]" class="add_field_plan" readonly ><button type="button" name="ch_particul_plan" class="btn_s4">변경</button></td>
                            <td class="t_price nb">0<input type="hidden" name="particul_price[]" value="0"></td>
                        </tr>
                        <tr>
                            <td>
                                <input type="checkbox" id="n10" name="nob[]">
								<label for="n10" class="check_bx"><span></span></label>
                            </td>
                            <td class="nb">10</td>
                            <td><input type="text" id="" name="input_name[]" class="add_field"></td>
                            <td><input type="text" id="" name="input_eng_name[]" class="add_field"></td>
                            <td><input type="text" id="" name="juminno[]" class="add_field"></td>
                            <td class="nb"><input type="hidden" name="hage[]" value=""></td>
                            <td><input type="text" id="" name="plan_code[]" class="add_field_plan" readonly ><button type="button" name="ch_particul_plan" class="btn_s4">변경</button></td>
                            <td class="t_price nb">0<input type="hidden" name="particul_price[]" value="0"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <section id="tt_price_area">
                <div id="check_all">
                    <button type="button"  class="btn_s5" id="allbt">전체 선택</button>
                    <button type="button"  class="btn_s5" id="allnbt">전체 해제</button>
                </div>
                <div><button type="button" id="cal_insuran_tot" class="btn_count">총 납입 보험료 계산하기</button></div>
                <div>
                    <ul>
                        <li>총 인원</li>
                        <li><span class="t_num c_black" chkallp='' id='talp'>0</span><span>명</span></li>
                    </ul>
                    <ul>
                        <li>총 납입 보험료</li>
                        <li><span class="t_num c_red" chkallam='' id='tala'>0</span><span>원</span></li>
                    </ul>
					<?/*
                    <ul>
                        <li>추징/환급 보험료</li>
                        <li><span class="t_num c_blue">251,370</span><span>원</span></li>
                    </ul>
					*/
					?>
                </div>
            </section>
            <section id="btn_area">
                <div class="btn_list">
                    <?/*<button type="button" name="button" class="btn_s3">삭제</button>*/?>
                    <button type="reset" name="reset" class="btn_s2">초기화</button>
                    <button type="button" name="subscript" class="btn_s1">신청하기</button>
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
                            <td><input type="text" id="" name="input_name[]" class="add_field"></td>
                            <td><input type="text" id="" name="input_eng_name[]" class="add_field"></td>
                            <td><input type="text" id="" name="juminno[]" class="add_field"></td>
                            <td class="nb"><input type="hidden" name="hage[]" value=""></td>
                            <td><input type="text" id="" name="plan_code[]" class="add_field_plan" readonly ><button type="button" name="ch_particul_plan" class="btn_s4">변경</button></td>
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
	
	$('#nation').on('change',function(){
		$('#select_nation').val('N');
	});

	$('#ch_nation').on('click',function(){
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
				}
			},"json");
		} else {
			alert('여행지를 선택해주세요');
			return false;
		}
	});
</script>
<script type="text/javascript" src="/js/multi_trip.js"></script>
</html>
