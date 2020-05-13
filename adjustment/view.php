<? 
	include ("../include/top.php"); 

	if (!$page) $page = 1;
	$num_per_page = 10;
	$num_per_page_start = $num_per_page*($page-1);
	$page_per_block = 5;

	$add_query .=" and b.member_no='".$row_mem_info['no']."'";

	$add_query = $add_query." and a.change_date >='".$check_start."'";
	$add_query = $add_query." and a.change_date <='".$check_end."'";

	

	$sql="select 
		count(a.no) as t_cnt, sum(change_price) as t_won
	  from
		hana_plan_change a
		left join hana_plan b on b.no=a.hana_plan_no
		left join hana_plan_member d on d.hana_plan_no=b.no
	  where
		1 ".$add_query."
	";
	$result=mysql_query($sql);
	$t_row=mysql_fetch_array($result);

 $sql="select 
		*, b.regdate as regdate, b.no as plan_hana_no, a.change_date as confirm_date, a.no as hana_plan_change_no, d.hphone as hphone, a.com_percent
	  from
		hana_plan_change a
		left join hana_plan b on a.hana_plan_no=b.no
		left join hana_plan_member d on d.hana_plan_no=b.no
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
	var oneDepth = 2; //1차 카테고리
	$(document).ready(function() {
           

            $("#start_date, #end_date").datepicker({
                showOn: "both",
                buttonImage: "../img/common/ico_cal.png",
                buttonImageOnly: true,
                showOtherMonths: true,

                dayNamesMin: ['일', '월', '화', '수', '목', '금', '토'],
                monthNamesShort: ['1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월'],
                monthNames: ['1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월'],
                buttonText: "Select date"
            });
 });

function pop_detail(kind){
	var popw;
	popw = window.open('./pop_view.php?num='+kind,'detailp', 'width=1200, height=700, left=200, top=200, menubar=no, location=no, resizable=no, scrollbars=no, status=no, toolbar=no');
	popw.focus();
}
</script>

<div id="wrap">
	<div id="inner_wrap">
		<!-- header -->
		<? include ("../include/header.php"); ?>
			<!-- //header -->
			<!-- container -->
			<div id="container">
				
				<div class="table_overflow mt20">
					<div class="table_line2 overlayer">
						<table class="board-list" style="min-width:1500px;">
							<colgroup>
								<col class="w_cell" width="3%">
							</colgroup>
							<thead>
								<tr>
									<th class="w_cell">NO</th>
									<th >신청일</th>
									<th >처리일</th>
									<th >대표피보험자(신청자)</th>
									<?  if ($row_mem_info['mem_type']=="2") { ?>
									<th >피보험자 주민등록번호</th>
									<?
										}
									?>
									<th >여행지</th>
									<th >보험시작일</th>
									<th >보험종료일</th>
									<th >플랜명</th>
									<th >보험료</th>
									<th >협정요율(수수료율)</th>
									<th >입금금액</th>
									<th >선결제</th>
									
									<?  if ($row_mem_info['mem_type']=="2") { ?>
									<th >납입방법 및 입금일자</th>
									
									<? } ?>
									<th >증권번호</th>
									<th >가입번호</th>
									<?  if ($row_mem_info['mem_type']=="2") { ?>
									<th >핸드폰</th>
									<?
										}
									?>
								</tr>
							</thead>
							<tbody>
<?
	$cur_time=time();

	while($row=mysql_fetch_array($result)) {
		$total_price=0;
		$total_cnt=0;
		$del_check="Y";

		
		$sql_mem="select * from hana_plan_member where hana_plan_no='".$row['plan_hana_no']."' and main_check='Y'";
		$result_mem=mysql_query($sql_mem);
		$row_mem=mysql_fetch_array($result_mem);


			if ($row_mem['plan_state']=='3') {
				$d_name="<span style=\"text-decoration: line-through;\">".$row_mem['name']."</span>";
			} else {
				$d_name=$row_mem['name'];
			}

			$jumin_1=decode_pass($row_mem['jumin_1'],$pass_key);

			if ($row_mem['jumin_2']!='') {
				$jumin_2=decode_pass($row_mem['jumin_2'],$pass_key);

				$jumin_no=$jumin_1."- *******";//.$jumin_2;
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
		
		if ($row['join_cnt']=="1") {
			$join_text=$row['join_name'];
		} else {
			$join_text=$row['join_name']." 외 ".($row['join_cnt']-1)."명";
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
									<td><?=date("Y-m-d",$row['regdate'])?></td>
									<td><?=date("Y-m-d",$row['confirm_date'])?></td>
									<td><a href='javascript:pop_detail(<?=$row['plan_hana_no']?>);'><?=$join_text/*stripslashes($row['join_name'])*/?></a></td>
									<?  if ($row_mem_info['mem_type']=="2") { ?>
									<td><?=$jumin_no?></td>
									<? } ?>
									<td><?=$nation_text?></td>
									<td><?=$row['start_date']?> <?=$row['start_hour']?>시</td>
									<td><?=$row['end_date']?> <?=$row['end_hour']?>시</td>
									<td><?=stripslashes($plan_code_row['plan_title'])?></td>
									<td><?=number_format($row['change_price'])?></td>
									<td><?=stripslashes($row['com_percent'])?> %</td>
									<td><?=number_format($row['change_price']-(($row['change_price']*$row['com_percent'])/100))?></td>
									<td><?=number_format($row['in_price'])?></td>
									
									<?  if ($row_mem_info['mem_type']=="2") { ?>
									
									<td><?=$row['add_input_1']?></td>
									
									<? } ?>
									<td><?=stripslashes($row['plan_join_code'])?></td>
									<td>A<?=date("Ymd",$row['regdate'])?><?=sprintf("%06d", $row['plan_hana_no'])?></td>
									<?  if ($row_mem_info['mem_type']=="2") { ?>
									<td><?=stripslashes($hphone)?></td>
									<? } ?>
		
								</tr>
<?
		$article_num--;
	}
?>
							</tbody>
						</table>
<?
	$where .= "&check_start=".$check_start."&check_end=".$check_end."";
	list_page_numbering_div($page_per_block,$page,$total_page,$where);
?>
					</div>
				</div>

	

		</div>
		<!-- //container -->
	</div>
	<!-- //inner_wrap -->
	<? include ("../include/footer.php"); ?>
</div>
<!-- //wrap -->


</body>

</html>
