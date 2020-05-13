<? 
	include ("../include/top.php"); 
	include ("../include/hana_check.php");

	$sql_check="select * from hana_plan_tmp where member_no='".$row_mem_info['no']."' and session_key='".$_SESSION['s_session_key']."'";
	$result_check=mysql_query($sql_check);
	$row_check=mysql_fetch_array($result_check);

	if ($row_check['no']=='') {
?>
<script>
	alert('세션정보가 삭제 되었습니다.\n다시 시도해 주세요.');
	history.go(-1);
</script>
<?
		exit;
	}

	$tripType=$row_check["trip_type"];
	
	$sql_nation="select * from nation where use_type='N'";
	$result_nation=mysql_query($sql_nation) or die(mysql_error());
	while($row_nation=mysql_fetch_array($result_nation)) {
		if ($no_nation_text=="") {
			$no_nation_text=stripslashes($row_nation['nation_name']);
		} else {
			$no_nation_text=$no_nation_text.", ".stripslashes($row_nation['nation_name']);
		}
	}

	$x=0;
	$plan_price=0;

	$sql_mem="select name,hphone,plan_price from hana_plan_member_tmp where tmp_no='".$row_check['no']."' order by no asc";
	$result_mem=mysql_query($sql_mem);
	while($row_mem=mysql_fetch_array($result_mem)) {
		$plan_price=$plan_price+$row_mem['plan_price'];

		if ($bill_name=="") {
			$bill_name=$row_mem['name'];
		}

		if ($bill_hphone=="") {
			$bill_hphone=decode_pass($row_mem['hphone'],$pass_key);
		}
	}

	$tripType=$row_check['trip_type'];
	$nation_no=$row_check['nation_no'];
	$plan_type=$row_check['plan_type'];
	
	if ($tripType=="2") {
		$sql_nation="select * from nation where no='".$nation_no."' and use_type='Y'";
		$result_nation=mysql_query($sql_nation) or die(mysql_error());
		$row_nation=mysql_fetch_array($result_nation);
	} else {
		$row_nation['nation_name']="국내";
	}

	if($_SESSION['s_mem_id'] != 'hyecho_b2b' && $_SESSION['s_mem_id'] != 'followme_b2b'){
		$b2b_code_table = 'plan_code_btob';
	} else {
		$b2b_code_table = 'plan_code_mg';
	}

	$sql_code="select plan_title from ".$b2b_code_table." where trip_type='".$tripType."' and plan_type='".$plan_type."'";
	$result_code=mysql_query($sql_code) or die(mysql_error());
	$row_code=mysql_fetch_array($result_code);
?>
<script>
	var oneDepth = 1; //1차 카테고리

	$(document).ready(function() {
		$(".join_step > ol > li:nth-child(3)").addClass("on");
		
		$('#all_no').click(function() {
			if ($(this).is(":checked")) {
				$('.aa_no').prop("checked", true);
				$('.aa_no').parent().parent().addClass("ez-selected");
				$('.aa_ok').parent().parent().removeClass("ez-selected");
				$('.aa_ok').prop("checked", false);
			} else {
				$('.aa_no').prop("checked", false);
				$('.aa_no').parent().parent().removeClass("ez-selected");
			}
		})

		$('.aa_ok').click(function() {
			$('#all_no').prop("checked", false);
			$('#all_no').parent().removeClass("ez-checked");
		})
		
		$('.aa_no').change(function(){
			if ($('.aa_no:checked').length == $('.aa_no').length) {
				$('#all_no').prop("checked", true);
				$('#all_no').parent().addClass("ez-checked");
			}
		});
		

		$('#allagree').click(function() {
			if ($(this).is(":checked")) {
				$('.agree').prop("checked", true);
				$('.agree').parent().addClass("ez-checked");

			} else {
				$('.agree').prop("checked", false);
				$('.agree').parent().removeClass("ez-checked");
			}
		})

		$('.agree').change(function(){
			if ($('.agree:checked').length == $('.agree').length) {
				$('#allagree').prop("checked", true);
				$('#allagree').parent().addClass("ez-checked");
			}else {
				$('#allagree').prop("checked", false);
				$('#allagree').parent().removeClass("ez-checked");
			}
		});
	});

	function f_pop(page,name){
		
		$("#yak_tit").html(name);
		$('#yak_area').load(page, function(){
			ViewlayerPop(0);
		});
		
	}
	
	function v_pop(num){
		if(num == 1) {
			$("#pop_title").html("입원, 수술, 질병확진");
			$("#viewPop").html("암, 백혈병, 협심증, 심근경색, 심장판막증, 간경화증, 뇌졸중증(뇌출혈, 뇌경색), 에이즈 및 HIV");
		}else if (num == 2) {
			$("#pop_title").html("여행금지 및 인수제한국가");
			$("#viewPop").html("<?=$no_nation_text?>");
		}else if (num == 3) {
			$("#pop_title").html("특정질병");
			$("#viewPop").html("암, 백혈병, 협심증, 심근경색, 심장판막증, 간경화증, 뇌졸중(뇌출혈, 뇌경색), 당뇨병, 에이즈(AIDS) 및 HIV보균");
		}else if (num == 4) {
			$("#pop_title").html("위험한 레포츠");
			$("#viewPop").html("스쿠버다이빙, 행글라이딩/패러글라이딩, 스카이다이빙, 수상스키, 자동차/오토바이경주, 번지점프, 빙벽/암벽등반, 제트스키, 래프팅, 이와 비슷한 위험도가 높은 활동");
		}
		ViewlayerPop(1);
	}

	function go_submit() {
		var frm = document.send_form;
		
		if ("<?=$tripType?>"=="2") {
			var check_type_1 = $("input:radio[name=check_type_1]:checked").val();
			var check_type_2 = $("input:radio[name=check_type_2]:checked").val();
			var check_type_3 = $("input:radio[name=check_type_3]:checked").val();
			var check_type_4 = $("input:radio[name=check_type_4]:checked").val();
			
			if (check_type_1=="" || check_type_1==null || check_type_2=="" || check_type_2==null || check_type_3=="" || check_type_3==null || check_type_4=="" || check_type_4==null) {
				alert('여행 출발전 고지사항을 체크해 주세요.');
				return false;
			}

			if (check_type_1=="Y" || check_type_2=="Y" || check_type_3=="Y" || check_type_4=="Y") {
				alert('여행 출발전 고지사항 중 예가 선택되어 있으면 다음단계로 진행 할 수 없습니다.');
				return false;
			}
		} else if ("<?=$tripType?>"=="1") {
			var check_type_1 = $("input:radio[name=check_type_1]:checked").val();
			var check_type_2 = $("input:radio[name=check_type_2]:checked").val();
			var check_type_3 = $("input:radio[name=check_type_3]:checked").val();
			var check_type_4 = $("input:radio[name=check_type_4]:checked").val();
			var check_type_5 = $("input:radio[name=check_type_5]:checked").val();
			
			if (check_type_1=="" || check_type_1==null || check_type_2=="" || check_type_2==null || check_type_3=="" || check_type_3==null || check_type_4=="" || check_type_4==null || check_type_5=="" || check_type_5==null) {
				alert('여행 출발전 고지사항을 체크해 주세요.');
				return false;
			}

			if (check_type_1=="Y" || check_type_2=="Y" || check_type_3=="Y" || check_type_4=="Y" || check_type_5=="Y") {
				alert('여행 출발전 고지사항 중 예가 선택되어 있으면 다음단계로 진행 할 수 없습니다.');
				return false;
			}
		}

		if ($("input:checkbox[name='chk1']").is(":checked") == false) {
			alert('이용약관에 동의해 주세요.');
			return false;
		}

		if ($("input:checkbox[name='chk2']").is(":checked") == false) {
			alert('보험약관에  동의해 주세요.');
			return false;
		}

		if ($("input:checkbox[name='chk3']").is(":checked") == false) {
			alert('단체규약에  동의해 주세요.');
			return false;
		}

		if ($("input:checkbox[name='select_agree']").is(":checked") == false) {
			alert('개인정보 수집 및 이용에 동의해 주세요.');
			return false;
		}

		$("#auth_token").val(auth_token);
		$("#loading_area").css({"display":"block"});

		$.ajax({
			type : "POST",
			url : "../src/bill_process.php",
			data :  $("#send_form").serialize(),
			success : function(data, status) {
				var json = eval("(" + data + ")");

				if (json.result=="true") {
					location.href="complete.php?check="+json.msg;
					$("#loading_area").delay(300).fadeOut();
					return false;
				} else {
					alert(json.msg);
					$("#loading_area").delay(100).fadeOut();
					return false;
				}
				
			},
			error : function(err)
			{
				alert(err.responseText);
				$("#loading_area").delay(100).fadeOut();
				return false;
			}
		});
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


					<h3 class="step_tit"><strong>STEP 3.</strong> 약관 및 고지사항을 체크하여 주세요</h3>

					<div class="gray_box">
						<h4 class="ss_tit mt0">여행자보험 가입신청정보</h4>
						<ul class="step4_step">
							<li>
								<div class="box">출발일시<span class="ico"><img src="../img/pages/step4_ico01.png" alt=""></span>
									<p class="table"><span class="point_c"><?=$row_check['start_date']?><br><?=$row_check['start_hour']?>시</span></p>
								</div>
							</li>
							<li>
								<div class="box">도착일시 <span class="ico"><img src="../img/pages/step4_ico02.png" alt=""></span>
									<p class="table"><span class="point_c"><?=$row_check['end_date']?><br><?=$row_check['end_hour']?>시</span></p>
								</div>
							</li>
							<li>
								<div class="box">지역 <span class="ico"><img src="../img/pages/step4_ico03.png" alt=""></span>
									<p class="table"><span class="point_c"><?=$row_nation['nation_name']?> </span></p>
								</div>
							</li>
							<li>
								<div class="box">인원 <span class="ico"><img src="../img/pages/step4_ico04.png" alt=""></span>
									<p class="table"><span class="point_c"><?=number_format($row_check['join_cnt'])?>명</span></p>
								</div>
							</li>
							<li>
								<div class="box">총금액 <span class="ico"><img src="../img/pages/step4_ico05.png" alt=""></span>
									<p class="table"><span class="point_c"><?=number_format($plan_price)?>원 </span></p>
								</div>
							</li>
							<li>
								<div class="box">상품유형<span class="ico"><img src="../img/pages/step4_ico06.png" alt=""></span>
									<p class="table"><span class="point_c"><?=$type_array[$tripType]?><br><?=$row_code['plan_title']?></span></p>
								</div>
							</li>
						</ul>
					</div>

					<h3 class="s_tit">여행 출발전 고지사항</h3>
					<div class="gray_box">
						<? if ($tripType=="2") { ?>
						<ol class="notice_list">
							<li><strong>1. 현재 계신 곳이나 주로 거주하는 지역이 해외인가요?</strong>
								<ul class="box_radio small full">
									<li><label><input type="radio" value="Y" name="check_type_1" class="aa_ok">예</label></li>
									<li><label><input type="radio" value="N" name="check_type_1" class="aa_no">아니오</label></li>
								</ul>
							</li>
							<li><strong>2. 최근 3개월 내에 <a href="javascript:void(0);" onclick="v_pop(1);"><span class="red">입원, 수술, 질병확진[보기]</span></a>을 받은 사실이 있나요?</strong>
								<ul class="box_radio small full">
									<li><label><input type="radio" value="Y" name="check_type_2" class="aa_ok">예</label></li>
									<li><label><input type="radio" value="N" name="check_type_2" class="aa_no">아니오</label></li>
								</ul>
							</li>
							<li><strong>3. 위험한 운동이나 전문적인 체육활동을 목적으로 출국하시나요?</strong>
								<ul class="box_radio small full">
									<li><label><input type="radio" value="Y" name="check_type_3" class="aa_ok">예</label></li>
									<li><label><input type="radio" value="N" name="check_type_3" class="aa_no">아니오</label></li>
								</ul>
							</li>
							<li><strong>4. 여행지역이 <a href="javascript:void(0);" onclick="v_pop(2);"><span class="red">여행금지국가[보기]</span></a>인가요?</strong>
								<ul class="box_radio small full">
									<li><label><input type="radio" value="Y" name="check_type_4" class="aa_ok">예</label></li>
									<li><label><input type="radio" value="N" name="check_type_4" class="aa_no">아니오</label></li>
								</ul>
							</li>
						</ol>
						
						<? } elseif ($tripType=="1") { ?>
						<ol class="notice_list">
							<li><strong>1. 최근 5년 내에 <a href="javascript:void(0);" onclick="v_pop(3);"><span class="blue">특정질병[보기]</span></a>에 대한 확진 또는 치료를 받은 적이 있나요?</strong>
								<ul class="box_radio small full">
									<li><label><input type="radio" value="Y" name="check_type_1" class="aa_ok">예</label></li>
									<li><label><input type="radio" value="N" name="check_type_1" class="aa_no">아니오</label></li>
								</ul>
							</li>
							<li><strong>2. 기능장애 또는 유전성 질환을 갖고 계시나요?</strong>
								<ul class="box_radio small full">
									<li><label><input type="radio" value="Y" name="check_type_2" class="aa_ok">예</label></li>
									<li><label><input type="radio" value="N" name="check_type_2" class="aa_no">아니오</label></li>
								</ul>
							</li>
							<li><strong>3. 현재 외국에 거주중이거나 가입하는 장소가 외국이신가요?</strong>
								<ul class="box_radio small full">
									<li><label><input type="radio" value="Y" name="check_type_3" class="aa_ok">예</label></li>
									<li><label><input type="radio" value="N" name="check_type_3" class="aa_no">아니오</label></li>
								</ul>
							</li>
							<li><strong>4. 금강산, 개성공단 등 북한지역으로 여행을 가시나요?</strong>
								<ul class="box_radio small full">
									<li><label><input type="radio" value="Y" name="check_type_4" class="aa_ok">예</label></li>
									<li><label><input type="radio" value="N" name="check_type_4" class="aa_no">아니오</label></li>
								</ul>
							</li>
							<li class="one"><strong>5. 여행중 직업, 직무 또는 동호회 활동으로 <a href="javascript:void(0);" onclick="v_pop(4);"><span class="blue">위험한 레포츠 등[보기]</span></a>을 하시나요?</strong>
								<ul class="box_radio small full">
									<li><label><input type="radio" value="Y" name="check_type_5" class="aa_ok">예</label></li>
									<li><label><input type="radio" value="N" name="check_type_5" class="aa_no">아니오</label></li>
								</ul>
							</li>
						</ol>
						<? } ?>
						
						<div class="tc f115 pt10 mt20 all_check" style="border-top:1px dashed #ccc">
							<label><input type="checkbox" id="all_no" value="" name=""> <strong>모든항목 아니오</strong></label>
						</div>


					</div>





					<h3 class="s_tit">가입/이용동의</h3>
					<div class="table_line">
						<table class="table_style1">
							<colgroup>

								<col width="%">
								<col class="m_th_b" width="200">
								<col class="m_th_s" width="200">
							</colgroup>

							<tbody>
								<tr>
									<td class="tl ">
										<span class="point_c">[필수] 이용약관</span>
									</td>
									<td>
										<label><input type="checkbox" name="chk1" class="agree">동의합니다.</label>
									</td>
									<td>
										<a href="javascript:void(0)" onclick="f_pop('../include/clause1.php', '이용약관');" class="btnNormalB line radius"><span>내용확인</span></a>
									</td>
									
								</tr>
								<tr>
									<td class="tl ">
										<span class="point_c">[필수] 보험약관</span> &nbsp;&nbsp;&nbsp;<span class="ib">
										<? if ($tripType=="1") { ?>
										<a href="../doc/국내여행보험약관.pdf" target="_blank" class="btnTiny"><span>국내여행보험약관</span></a> 
										<? } else { ?>
										<a href="../doc/해외여행보험약관.pdf" target="_blank" class="btnTiny"><span>해외여행보험약관</span></a>
										<? } ?>
										</span>
									</td>
									<td>
										<label><input type="checkbox" name="chk2" class="agree">동의합니다.</label>
									</td>
									<td>
										<a href="javascript:void(0)" onclick="f_pop('../include/clause2.php', '보험약관');" class="btnNormalB line radius"><span>내용확인</span></a>
									</td>
									
								</tr>
								<tr>
									<td class="tl ">
										<span class="point_c">[필수] 단체규약</span>
									</td>
									<td>
										<label><input type="checkbox" name="chk3" class="agree">동의합니다.</label>
									</td>
									<td>
										<a href="javascript:void(0)" onclick="f_pop('../include/clause3.php', '단체규약');" class="btnNormalB line radius"><span>내용확인</span></a>
									</td>
									
								</tr>
								<tr>
									<td class="tl ">
										<span class="point_c">[필수] 개인정보 수집 및 이용</span>
									</td>
									<td>
										<label><input type="checkbox" name="select_agree" class="agree" value="Y">동의합니다.</label>
									</td>
									<td>
										<a href="javascript:void(0)" onclick="f_pop('../include/clause4.php', '개인정보 수집 및 이용');" class="btnNormalB line radius"><span>내용확인</span></a>
									</td>
									
								</tr>
							</tbody>
						</table>
					</div>
					<div class="tc f115 pt10 mt20 all_check" style="border-top:1px dashed #ccc">
						<label><input type="checkbox" id="allagree" class="" value="" name=""> <strong>전체 약관에 동의합니다.</strong></label>
					</div>
					<div class="btn-tc"><a href="javascript:void(0);" onclick="go_submit();" class="btnBig m_block"><span>신청하기</span></a></div>


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
			<div class="pop_wrap_in " style="max-width:700px;">
				<div class="pop_head">
					<p class="title" id="yak_tit"></p>
					<p class="x_btn" onclick="CloselayerPop();"><img src="../img/common/close3.png" alt="닫기"></p>
				</div>
				<div id="yak_area" class="pop_body ">
					
				</div>

			</div>
		</div>
	</div>
</div>

<div id="layerPop1" class="layerPop" style="display: none;">
	<div class="layerPop_inner">
		<div class="pop_wrap">
			<div class="pop_wrap_in " style="max-width:600px;">
				<div class="pop_head">
					<p class="title" id="pop_title"></p>
					<p class="x_btn" onclick="CloselayerPop();"><img src="../img/common/close3.png" alt="닫기"></p>
				</div>
				<div id="viewPop" class="pop_body ">
					
				</div>

			</div>
		</div>
	</div>
</div>
</body>

</html>
