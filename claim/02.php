<? 
	include ("../include/top.php"); 
	include ("../include/link_session_check.php");
	

if($_SESSION['login_check_key_1']=="" || $_SESSION['login_check_key_2']=="" || $_SESSION['login_check_key_3']=="" || $_SESSION['login_check_key_4']=="") {
?>
<script>
	alert('세션이 종료되었습니다. 다시 시도해 주세요.');
	location.href="../accept/01.php";
</script>
<?php
	exit;
}

$sql="select 
		*
	  from
		hana_plan_member
	  where
	    gift_key='".$_SESSION['login_check_key_1']."'
		and name='".$_SESSION['login_check_key_2']."'
		and jumin_1='".$_SESSION['login_check_key_3']."'
		and hphone='".$_SESSION['login_check_key_4']."'
	 ";
$result=mysql_query($sql);
$row=mysql_fetch_array($result);

if ($row['gift_state']!="1") {
?>
<script>
	alert('이미 승인된 선물 내역 입니다.');
	location.href="../accept/01.php";
</script>
<?php
	exit;
}

if ($row['plan_state']!="1") {
?>
<script>
	alert('선물내역이 취소되었습니다.');
	location.href="../accept/01.php";
</script>
<?php
	exit;
}

$hphone=decode_pass($row['hphone'],$pass_key);
$jumin_1=decode_pass($row['jumin_1'],$pass_key);

$sql_trip="select 
		*
	  from
		hana_plan
	  where
		no='".$row['hana_plan_no']."'
	 ";
$result_trip=mysql_query($sql_trip);
$row_trip=mysql_fetch_array($result_trip);

if ($row_trip['nation_no']=="0") {
	$nation_text="국내";
} else {
	$nation_row=sql_one_one("nation","nation_name"," and no='".$row_trip['nation_no']."'");
	$nation_text=stripslashes($nation_row['nation_name']);
}

$plan_code_row=sql_one_one("plan_code_hana","plan_title"," and plan_code='".$row['plan_code']."'");
?>

<script>
	var oneDepth = 5; //1차 카테고리

	function form_submit() {
		var frm=document.send_form;

		if (frm.jumin_1.value=="") {
			alert('주민등록번호 앞자리를 입력하세요.');
			frm.jumin_1.focus();
			return false;
		}

		if ($("#jumin_1").val().length!="6") {
			alert('주민등록번호 앞자리를 정확히 입력하세요.');
			return false;
		}

		if (frm.jumin_2.value=="") {
			alert('주민등록번호 뒷자리를 입력하세요.');
			frm.jumin_2.focus();
			return false;
		}

		if ($("#jumin_2").val().length!="7") {
			alert('주민등록번호 뒷자리를 정확히 입력하세요.');
			return false;
		}

		if ($("input:checkbox[name='chk1']").is(":checked") == false) {
			alert('투어세이프 사이트 이용약관에 동의해 주세요.');
			return false;
		}

		if ($("input:checkbox[name='chk2']").is(":checked") == false) {
			alert('단체보험규약에 동의해 주세요.');
			return false;
		}

		$("#auth_token").val(auth_token);
		$("#loading_area").css({"display":"block"});

		$.ajax({
			type : "POST",
			url : "../src/gift_confirm_process.php",
			data :  $("#send_form").serialize(),
			success : function(data, status) {
				var json = eval("(" + data + ")");

				if (json.result=="true") {
					location.href="complete.php";
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

	$(document).ready(function() {


		$('#allagree').click(function() {
			if ($(this).is(":checked")) {
				$('.agree').prop("checked", true);
				$('.agree').parent().addClass("ez-checked");

			} else {
				$('.agree').prop("checked", false);
				$('.agree').parent().removeClass("ez-checked");
			}
		})

		$('.agree').click(function() {
			if ($(this).is(":checked")) {
				if ($("#ok_check").is(":checked") && $("#ok_check2").is(":checked")) {

					$('#allagree').prop("checked", true);
					$('#allagree').parent().addClass("ez-checked");

				}
			} else {
				$('#allagree').prop("checked", false);
				$('#allagree').parent().removeClass("ez-checked");

			}
		})

	});


	function f_pop(page, name) {
		$.ajax({
			url: page,
			success: function(data) {
				$('#yak_area').html(data);
				$("#yak_tit").html(name);
			}
		})
		ViewlayerPop(0);
	}

</script>

<div id="wrap">
	<div id="inner_wrap">
		<!-- header -->
		<? include ("../include/header.php"); ?>
			<!-- //header -->
			<!-- container -->
			<div id="container">
				<h3 class="step_tit"><strong>받은 선물 등록하기</strong></h3>

				<ul class="step4_step four">
					<li>
						<div class="box">보험기간<span class="ico"><img src="../img/pages/step4_ico07.png" alt=""></span>
							<p class="table"><span class="point_c"><span class="ib"><?=date("Y년 m월 d일",strtotime($row_trip['start_date']))?> <?=$row_trip['start_hour']?>시 ~ </span><span class="ib"><?=date("Y년 m월 d일",strtotime($row_trip['end_date']))?> <?=$row_trip['end_hour']?>시</span></span>
							</p>
						</div>
					</li>
					<li>
						<div class="box">여행지 <span class="ico"><img src="../img/pages/step4_ico03.png" alt=""></span>
							<p class="table"><span class="point_c"><?=$nation_text?> </span></p>
						</div>
					</li>

					<li>
						<div class="box">보험상품<span class="ico"><img src="../img/pages/step4_ico06.png" alt=""></span>
							<p class="table"><span class="point_c">CHUBB <?=$type_array[$row_trip['trip_type']]?> <?=stripslashes($plan_code_row['plan_title'])?></span></p>
						</div>
					</li>
					<li>
						<div class="box">보험금액<span class="ico"><img src="../img/pages/step4_ico05.png" alt=""></span>
							<p class="table"><span class="point_c"><?=number_format($row['plan_price'])?>원</span></p>
						</div>
					</li>
					<li>
						<div class="box">보험나이<span class="ico"><img src="../img/pages/step4_ico09.png" alt=""></span>
							<p class="table"><span class="point_c"><?=stripslashes($row['age'])?>세</span></p>
						</div>
					</li>
					<li>
						<div class="box">피보험자명<span class="ico"><img src="../img/pages/step4_ico10.png" alt=""></span>
							<p class="table"><span class="point_c"><?=stripslashes($row['name'])?></span></p>
						</div>
					</li>
					<li>
						<div class="box">휴대폰번호<span class="ico"><img src="../img/pages/step4_ico11.png" alt=""></span>
							<p class="table"><span class="point_c"><?=stripslashes($hphone)?></span></p>
						</div>
					</li>
				</ul>

<? if ($row['no']!="" && $row['gift_state']=="1") { ?>
<form id="send_form" name="send_form">
<input type="hidden" id="auth_token" name="auth_token" readonly>
				<div class="gray_box mt20">
					<div class="step_select one">
						<div class="select_ds">
							<label class="ss_tit db mt0">주민등록번호</label>
							<div class="col-sm-2" style="max-width:400px;">
								<div class="select_ds pr10">
									<input type="number" oninput="maxLengthCheck(this)" name="jumin_1" id="jumin_1" value="<?=substr($jumin_1,2,6)?>" placeholder="" class="onlyNumber input" maxlength="6" readonly>
									<span class="pa_minus">-</span>
								</div>
								<div class="select_ds pl5">
									<input type="password" name="jumin_2" id="jumin_2" value="" placeholder="" class="onlyNumber input" maxlength="7">
								</div>

							</div>
						</div>

					</div>
					<div class="table_line mt20">
						<table class="table_style1">
							<colgroup>
								<col width="%">
								<col class="m_th_b" width="200">
								<col class="m_th_s" width="200">
							</colgroup>

							<tbody>
								<tr>
									<td class="tl">
										투어세이프 사이트 이용약관 동의
									</td>
									<td>
										<label><input type="checkbox" class="agree" name="chk1" value="" id="ok_check">동의합니다.</label>
									</td>
									<td>
										<a href="javascript:void(0)" onclick="f_pop('../include/clause1.php', '투어세이프 사이트 이용약관');" class="btnNormalB line radius"><span>내용확인</span></a>
									</td>

								</tr>
								<tr>
									<td class="tl">
										단체보험규약 동의
									</td>
									<td>
										<label><input type="checkbox" class="agree" name="chk2" value="" id="ok_check2">동의합니다.</label>
									</td>
									<td>
										<a href="javascript:void(0)" onclick="f_pop('../include/clause1.php', '단체보험규약');" class="btnNormalB line radius"><span>내용확인</span></a>
									</td>

								</tr>
							</tbody>
						</table>
					</div>

					<div class="tc f105 pt10 all_check">
						<label><input type="checkbox" id="allagree" class="" value="" name=""> <strong>전체 약관에 동의합니다.</strong></label>
					</div>
				</div>
				<div class="btn-tc">
					<a href="javascript:void(0);" onclick="form_submit();" class="btnBig m_block"><span>등록</span></a>
				</div>
</form>
<? } ?>

			</div>

	</div>
	<!-- //container -->
</div>
<!-- //wrap -->

<div id="layerPop0" class="layerPop" style="display: none;">
	<div class="layerPop_inner">
		<div class="pop_wrap">
			<div class="pop_wrap_in " style="max-width:1000px;">
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


</body>

</html>
