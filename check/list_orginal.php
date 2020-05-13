<? 
	include ("../include/top.php"); 

if (!$page) $page = 1;
$num_per_page = 10;
$num_per_page_start = $num_per_page*($page-1);
$page_per_block = 5;

	$add_query .=" and a.member_no ='".$row_mem_info['no']."'";	

	if ($start_date!='') {
		$s_date_r=strtotime($start_date." 000000");

		$add_query = $add_query." and a.regdate >='".$s_date_r."'";
	}

	if ($end_date!='') {
		$e_date_r=strtotime($end_date." 235959");

		$add_query = $add_query." and a.regdate <='".$e_date_r."'";
	}

	if($search) {
		if($make == 'name') {
			$add_query .=" and b.name like '%$search%'";
		} elseif ($make=="join_name") {
			$add_query .=" and a.join_name like '%$search%'";
		}
	}

 $sql="select 
		*, a.no as plan_hana_no, b.no as mem_no, b.hphone, b.email
	  from
		hana_plan a
		left join hana_plan_member b on a.no=b.hana_plan_no
	  where
		1 ".$add_query."
	  group by a.no
	  order by a.no desc
	 ";
$result=mysql_query($sql);
$total_record=mysql_num_rows($result);
$sql=$sql." limit $num_per_page_start, $num_per_page";
$result=mysql_query($sql) or die(mysql_error());

$list_page=list_page($num_per_page,$page,$total_record);//function_query
$total_page	= $list_page['0'];
$first		= $list_page['1'];
$last		= $list_page['2'];
$article_num = $total_record - $num_per_page*($page-1);
?>
<script>
	var oneDepth = 3; //1차 카테고리
	var select_num = "";
	
	function f_pop(num){
		select_num=num;
		ViewlayerPop(0);
	}

	$(document).ready(function() {

		$("#start_date").datepicker({
			showOn: "both",
			dateFormat: "yy-mm-dd",
			buttonImage: "../img/common/ico_cal.png",
			buttonImageOnly: true,
			showOtherMonths: true,
			dayNamesMin: ['일', '월', '화', '수', '목', '금', '토'],
			monthNamesShort: ['1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월'],
			monthNames: ['1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월'],
			buttonText: "Select date"        
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
			buttonText: "Select date"
		});

	});
</script>

<div id="wrap">
	<div id="inner_wrap">
		<!-- header -->
		<? include ("../include/header.php"); ?>
			<!-- //header -->
			<!-- container -->
			<div id="container">
				
				<div class="bbs_search">
<form method="get" action="<?=$PHP_SELF?>" name="form1">
						<fieldset>
							<legend>게시물 검색</legend>
							<div class="bbs_search_in" style="padding:0px; margin-bottom:5px; max-width:685px;">
								<div class="col-sm-2">
									<div class="select_ds pr5">
										<div class="date_picker">
											<input type="text" class="input" name="start_date" id="start_date" value="<?=$start_date?>" readonly placeholder="신청일 시작">
										</div>
									</div>
									<div class="select_ds pl5">
										<div class="date_picker">
											<input type="text" class="input" name="end_date" id="end_date" value="<?=$end_date?>" readonly placeholder="신청일 종료">
										</div>
									</div>
								</div>
							</div>
							<div class="bbs_search_in">
							<select name="make" class="select">
							  <option value="name" <? if ($make=="name") { ?>selected<? } ?>>피보험자</option>
							  <option value="join_name" <? if ($make=="join_name") { ?>selected<? } ?>>가입자</option>
							</select>
							<input type="text" id="searchstr" style="width:320px;" name="search" value="<?=$search?>" title="검색어를 입력하세요." placeholder="검색어를 입력하세요." class="input">
							<input class="btn_search" type="button" value="검색" onclick="document.form1.submit();">
							</div>
							<?php
								if($_SESSION['s_mem_id'] == 'hyecho_b2b'){
									echo "<div style='padding-top:10px;'><button type='button' class='btn_search' id='excel_hyecho'>엑셀저장</button></div>";	
								}
							?>
					</fieldset>
</form>
					
				</div>

				<div class="table_overflow">
					<div class="table_line2 overlayer">
						<table class="board-list" style="min-width:1500px;">
							<colgroup>
								<col class="w_cell" width="3%">
							</colgroup>
							<thead>
								<tr>
									<th class="w_cell">NO</th>
									<th>신청일</th>
									<th>진행상태</th>
									<th>수정처리일</th>
									<th>청약완료일</th>
									<th>대표피보험자(신청자)</th>
									<th>피보험자 주민등록번호</th>
									<th>여행지</th>
									<th>보험시작일</th>
									<th>보험종료일</th>
									<th>플랜명</th>
									<th>플랜코드</th>
									<th>보험료</th>
									<th>증권번호</th>
									<th>핸드폰</th>
									<?php
										if($_SESSION['s_mem_id'] != 'hyecho_b2b'){
									?>
									<th>이메일</th>
									<?php
										} else {
									?>
									<th>추가정보</th>
									<?php
										}
									?>
									<th>요청내용</th>
								</tr>
							</thead>
							<tbody>
<?
	$cur_time=time();

	while($row=mysql_fetch_array($result)) {
		$total_price=0;
		$total_cnt=0;
		$del_check="Y";


		$d_name=stripslashes($row['name']);
		

		$sql_mem="select * from hana_plan_member where hana_plan_no='".$row['plan_hana_no']."'";
		$result_mem=mysql_query($sql_mem);
		while($row_mem=mysql_fetch_array($result_mem)) {

			if ($row_mem['plan_state']!='3') {
				$total_price=$total_price+$row_mem['plan_price'];
			}

			if ($row_mem['main_check']=='Y') {
				if ($row_mem['plan_state']=='3') {
					$d_name="<span style=\"text-decoration: line-through;\">".$row_mem['name']."</span>";
				} else {
					$d_name=$row_mem['name'];
				}

				$jumin_1=decode_pass($row_mem['jumin_1'],$pass_key);

				if ($row_mem['jumin_2']!='') {
					$jumin_2=decode_pass($row_mem['jumin_2'],$pass_key);

					$jumin_no=$jumin_1."-".$jumin_2;
				} else {
					$jumin_no=$jumin_1;
				}

				$plan_code=$row_mem['plan_code'];
				
				if ($row_mem['hphone']!='') {
					$hphone=decode_pass($row_mem['hphone'],$pass_key);
				} else {
					$hphone="";
				}

				if ($row_mem['email']!='') {
					$email=decode_pass($row_mem['email'],$pass_key);
				} else {
					$email="";
				}
			}

			$total_cnt++;
		}


		if ($row['join_cnt']=="1") {
			$join_text=$d_name;
		} else {
			$join_text=$d_name." 외 ".($row['join_cnt']-1)."명";
		} 

		
		if ($row_mem_info['mem_type']=="1") {
		    $plan_code_row=sql_one_one("plan_code_hana","plan_title"," and member_no='".$row_mem_info['no']."' and plan_code='".$plan_code."'");
		} else {
			if($_SESSION['s_mem_id'] != 'hyecho_b2b'){
				$b2b_code_table = 'plan_code_btob';
			} else {
				$b2b_code_table = 'plan_code_mg';
			}
		    $plan_code_row=sql_one_one($b2b_code_table,"plan_title"," and plan_code='".$plan_code."'");
		}
		
		

		if ($row['nation_no']=="0") {
			$nation_text="국내";
		} else {
			$nation_row=sql_one_one("nation","nation_name"," and no='".$row['nation_no']."'");
			$nation_text=stripslashes($nation_row['nation_name']);
		}
?>
								<tr>
									<td class="w_cell"><?=$article_num?></td>
									<td><a href="view.php?num=<?=$row['plan_hana_no']?>&page=<?=$page?>&make=<?=$make?>&search=<?=$search?>&start_date=<?=$start_date?>&end_date=<?=$end_date?>"><?=date("Y-m-d",$row['regdate'])?></a></td>
									<td><a href="view.php?num=<?=$row['plan_hana_no']?>&page=<?=$page?>&make=<?=$make?>&search=<?=$search?>&start_date=<?=$start_date?>&end_date=<?=$end_date?>"><span class="<?=$plan_state_text_class_array[$row['plan_list_state']]?>"><?=$plan_state_text_array[$row['plan_list_state']]?></span></a></td>
									<td><a href="view.php?num=<?=$row['plan_hana_no']?>&page=<?=$page?>&make=<?=$make?>&search=<?=$search?>&start_date=<?=$start_date?>&end_date=<?=$end_date?>"><?=date("Y-m-d",$row['change_date'])?></a></td>
									<td><a href="view.php?num=<?=$row['plan_hana_no']?>&page=<?=$page?>&make=<?=$make?>&search=<?=$search?>&start_date=<?=$start_date?>&end_date=<?=$end_date?>"><?=$row['plan_join_code_date'] ?></a></td>
									<td><a href="view.php?num=<?=$row['plan_hana_no']?>&page=<?=$page?>&make=<?=$make?>&search=<?=$search?>&start_date=<?=$start_date?>&end_date=<?=$end_date?>"><?=$join_text?></a></td>
									<td><a href="view.php?num=<?=$row['plan_hana_no']?>&page=<?=$page?>&make=<?=$make?>&search=<?=$search?>&start_date=<?=$start_date?>&end_date=<?=$end_date?>"><?=$jumin_no?></a></td>
									<td><a href="view.php?num=<?=$row['plan_hana_no']?>&page=<?=$page?>&make=<?=$make?>&search=<?=$search?>&start_date=<?=$start_date?>&end_date=<?=$end_date?>"><?=$nation_text?></a></td>
									<td><a href="view.php?num=<?=$row['plan_hana_no']?>&page=<?=$page?>&make=<?=$make?>&search=<?=$search?>&start_date=<?=$start_date?>&end_date=<?=$end_date?>"><?=$row['start_date']?> <?=$row['start_hour']?>시</a></td>
									<td><a href="view.php?num=<?=$row['plan_hana_no']?>&page=<?=$page?>&make=<?=$make?>&search=<?=$search?>&start_date=<?=$start_date?>&end_date=<?=$end_date?>"><?=$row['end_date']?> <?=$row['end_hour']?>시</a></td>
									<td><a href="view.php?num=<?=$row['plan_hana_no']?>&page=<?=$page?>&make=<?=$make?>&search=<?=$search?>&start_date=<?=$start_date?>&end_date=<?=$end_date?>"><?=stripslashes($plan_code_row['plan_title'])?></a></td>
									<td><a href="view.php?num=<?=$row['plan_hana_no']?>&page=<?=$page?>&make=<?=$make?>&search=<?=$search?>&start_date=<?=$start_date?>&end_date=<?=$end_date?>"><?=stripslashes($plan_code)?></a></td>
									<td><a href="view.php?num=<?=$row['plan_hana_no']?>&page=<?=$page?>&make=<?=$make?>&search=<?=$search?>&start_date=<?=$start_date?>&end_date=<?=$end_date?>"><?=number_format($total_price)?></a></td>
									<td><a href="view.php?num=<?=$row['plan_hana_no']?>&page=<?=$page?>&make=<?=$make?>&search=<?=$search?>&start_date=<?=$start_date?>&end_date=<?=$end_date?>"><?=$row['plan_join_code']?></a></td>
									<td><a href="view.php?num=<?=$row['plan_hana_no']?>&page=<?=$page?>&make=<?=$make?>&search=<?=$search?>&start_date=<?=$start_date?>&end_date=<?=$end_date?>"><?=stripslashes($hphone)?></a></td>
									<td><a href="view.php?num=<?=$row['plan_hana_no']?>&page=<?=$page?>&make=<?=$make?>&search=<?=$search?>&start_date=<?=$start_date?>&end_date=<?=$end_date?>"><?=stripslashes($email)?></a></td>
									<td>
									<? if ($row['plan_list_state']!='2' && $row['plan_list_state']!='4' && $row['plan_list_state']!='3') { ?>
									<a href="javascript:void(0)" onclick="f_pop('<?=$row[plan_hana_no]?>');" class="btnTiny"><span>수정</span></a>
									<? } ?>
									</td>
		
								</tr>
<?
		$article_num--;
	}
?>							
							
							</tbody>
						</table>
					</div>
				</div>

<?
	$where .= "&make=$make";
	$where .= "&search=$search";
	$where .= "&start_date=$start_date";
	$where .= "&end_date=$end_date";
	list_page_numbering_div($page_per_block,$page,$total_page,$where);
?>
			</div>

	<!-- //container -->
	</div>
	<!-- //inner_wrap -->
	<? include ("../include/footer.php"); ?>
</div>
<!-- //wrap -->

<script>
	function plan_change() {
		var frm=document.send_form_pop;

		if (select_num=="") {
			alert('보험을 선택해 주세요.');
			return false;
		}

		if (frm.content.value=="") {
			alert('수정 내용을 입력해 주세요.');
			return false;
		}

		$("#auth_token").val(auth_token);
		$("#select_num").val(select_num);
		
		$("#loading_area").css({"display":"block"});

		$.ajax({
			type : "POST",
			url : "../src/plan_change_process.php",
			data :  $("#send_form_pop").serialize(),
			success : function(data, status) {
				console.log(data);
				var json = eval("(" + data + ")");

				if (json.result=="true") {
					alert(json.msg);
					location.reload();
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
	$(document).ready(function(){
		$('#excel_hyecho').on('click',function(){			
			var search_stdate;
			var search_eddate;
			var search_sel;
			var search_text;
						
			search_stdate = $('#start_date').val();
			search_eddate = $('#end_date').val();
			search_sel = $('select[name=make]').val();
			search_text = $('#searchstr').val();

			location.href='./excel_download_hyecho.php?start_date='+search_stdate+'&end_date='+search_eddate+'&make='+search_sel+'&search='+search_text;

		});
	});
</script>

<div id="layerPop0" class="layerPop" style="display:none;">
<form id="send_form_pop" name="send_form_pop">
<input type="hidden" id="auth_token" name="auth_token" readonly>
<input type="hidden" id="select_num" name="select_num" readonly>

	<div class="layerPop_inner">
		<div class="pop_wrap">
			<div class="pop_wrap_in " style="max-width:600px;">
				<div class="pop_head">
					<p class="title" id="pop_title">수정</p>
					<p class="x_btn" onclick="CloselayerPop();"><img src="../img/common/close3.png" alt="닫기"></p>
				</div>
				<div id="viewPop" class="pop_body ">
					<select class="txtb" name="change_type" style="width:100%">
						<option value="4">수정접수</option>
						<option value="2">취소접수</option>
					</select>
					<textarea name="content" class="textarea mt10" rows="6" cols="100" style="width:100%; height:150px;"></textarea>

					<div class="btn-tc">
						<a href="javascript:void(0);" onclick="plan_change();" class="btnNormal m_block"><span>신청</span></a>
					</div>
				</div>
			</div>
		</div>
	</div>
</form>
</div>
</body>

</html>
