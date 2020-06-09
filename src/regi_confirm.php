<? 
	include ("../include/top.php"); 
	if(!$_SESSION['s_mem_id']){
?>
<script>
	alert('로그인이 필요합니다.');
	window.close();
</script>
<?
		exit;
	}


$sql="select 
		*
	  from
		hana_plan_member
	  where
		hana_plan_no='{$num}'
		and 
		member_no = '{$_SESSION['s_mem_no']}'
	 ";
$result=mysql_query($sql);
$row=mysql_fetch_array($result);

if ($row['no']=="") {
?>
<script>
	alert('신청내역이 없습니다.');
	window.close();
</script>
<?
	exit;
}

$sql_mem="select * from hana_plan_member where hana_plan_no='".$row['hana_plan_no']."'";
$result_mem=mysql_query($sql_mem);
while($row_mem=mysql_fetch_array($result_mem)) {
	if ($row_mem['main_check']=="Y") {
		$d_name=stripslashes($row_mem['name']);
	}

	$total_price=$total_price+$row_mem['plan_price'];

	${"plan_state_".$row_mem['plan_state']}++;

	$total_cnt++;
}

$sql_trip="select 
		*
	  from
		hana_plan
	  where
		no='".$row['hana_plan_no']."'
	 ";
$result_trip=mysql_query($sql_trip);
$row_trip=mysql_fetch_array($result_trip);

	$member_no=$row_trip['member_no'];

if ($row_trip['nation_no']=="0") {
	$nation_text="국내";
} else {
	$nation_row=sql_one_one("nation","nation_name"," and no='".$row_trip['nation_no']."'");
	$nation_text=stripslashes($nation_row['nation_name']);
}
?>

    <div id="wrap" class="confirmation_wrap">
        <div id="inner_wrap">
            <!-- container -->
            <div id="container">
                <h1 class="sub_tit">투어세이프 해외여행보험 가입확인서</h1>
                <h2 class="s_tit">기본정보</h2>
                <div class="table_line">
                    <table cellspacing="0" cellpadding="0" summary="회원정보입력" class="board-write ">
                        <caption>
                            기본정보
                        </caption>
                        <colgroup>
                            <col class="m_th" width="180px;">
                            <col width="%;">
                        </colgroup>
                        <tbody>

                            <tr>
                                <th>예약/결제자 </th>
                                <td><?=stripslashes($d_name)?></td>
                            </tr>
                            <tr>
                                <th>대표피보험자 </th>
                                <td><?=stripslashes($d_name)?></td>
                            </tr>
                            <tr>
                                <th>납입보험료 </th>
                                <td><?=number_format($total_price)?>원</td>
                            </tr>
                            <tr>
                                <th>피보험자 수 </th>
                                <td><?=$row_trip['join_cnt']?>명</td>
                            </tr>
                            <tr>
                                <th>보험기간 </th>
                                <td><?=$row_trip['start_date']?> <?=$row_trip['start_hour']?>시 ~ <?=$row_trip['end_date']?> <?=$row_trip['end_hour']?>시</td>
                            </tr>
							<tr>
                                <th>증권번호</th>
                                <td><?=$row_trip['plan_join_code']?></td>
                            </tr>
                            <tr>
                                <th>가입번호</th>
                                <td>A<?=date("Ymd",$row_trip['regdate'])?><?=sprintf("%06d", $row_trip['no'])?></td>
                            </tr>
                            <tr>
                                <th>가입일자</th>
                                <td><?=date("Y-m-d",$row_trip['regdate'])?></td>
                            </tr>
                            <tr>
                                <th>여행목적 </th>
                                <td><?=$trip_purpose_array[$row_trip['trip_purpose']]?></td>
                            </tr>

                        </tbody>
                    </table>
                </div>

                 <ul>
                    <li style="font-size:0.8em;">본 상품은 단체여행자보험상품으로 단체의 내규에 의해 계약자(주식회사 팔로미)와 보험회사(에이스아메리칸화재해상보험㈜)가 체결하여 제공됩니다.</li>
                </ul>

                <h2 class="s_tit">보험 가입자(피보험자) 정보</h2>
                <div class="table_line">
                    <table cellspacing="0" cellpadding="0" summary="보험 가입자(피보험자) 정보" class="table_style1">
                        <caption>
                            보험 가입자(피보험자) 정보
                        </caption>
                        <colgroup>
                            <col width="13%;">
							<col width="13%;">
                            <col width="13%;">
                            
                            <col width="10%;">
                            <col width="13%;">
							<col width="13%;">
                        </colgroup>
                        <thead>
                            <tr>
                                <th>성명</th>
								<th>가입사항</th>
                                <th>생년월일</th>
                                <th>성별</th>
                                <th>가입플랜</th>
								<th>보험료</th>
                            </tr>
                        </thead>
                        <tbody>
<?
	$i=1;

	$sql_mem="select 
		*
	  from
		hana_plan_member
	  where
		hana_plan_no='".$row['hana_plan_no']."' and plan_state!='3'
	  order by main_check desc
	 ";
	$result_mem=mysql_query($sql_mem);
	while($row_mem=mysql_fetch_array($result_mem)) {

		$sex_type=substr(decode_pass($row_mem['jumin_2'],$pass_key),0,1);

		if ($sex_type=="1" || $sex_type=="2") {
			$year_text="19".decode_pass($row_mem['jumin_1'],$pass_key);
		} elseif ($sex_type=="3" || $sex_type=="4") {
			$year_text="20".decode_pass($row_mem['jumin_1'],$pass_key);
		}
?>
                            <tr>

                                <td><?=stripslashes($row_mem['name'])?></td>
								<td><a href="javascript:void(0);" onclick="view_pop('<?=$row_mem[plan_code]?>');" class="btnTiny radius"><span>확인</span></a></td>
                                <td><?=date("Y-m-d",strtotime($year_text))?></td>
								<td><?=stripslashes($sex_array[$row_mem['sex']])?></td>
                                <td><?=stripslashes($row_mem['plan_code'])?></td>
                                <td><?=number_format($row_mem['plan_price'])?>원</td>
                            </tr>
<?
		$i++;
	}
?>

                        </tbody>
                    </table>
                </div>


            </div>

        </div>
        <!-- //container -->
    </div>
    <!-- //wrap -->

<script>
	function view_pop(code) {
		$.ajax({
			type : "POST",
			url : "../src/plan_code_view.php",
			data :  { "code" : code , "trip_type" : "<?=$row_trip['trip_type']?>" , "select_member_no" : "<?=$member_no?>" , "auth_token" : auth_token },
			success : function(data, status) {
				var json = eval("(" + data + ")");

				if (json.result=="true") {
					$("#plan_title").html(json.msg_title);

					var add_html="";

					var i_cnt=0;
					
					$.each(json.msg,function(key,state){
						if (i_cnt==0) {
							add_html = add_html+"<tr>"+
								"<td rowspan=\"26\">"+json.msg_title+"</td>"+
								"<td class=\"tl\">"+state.content+"</td>"+
								"<td class=\"tr\">"+state.price+"</td>"+
							"</tr>";
						} else {
							add_html = add_html+"<tr>"+
								"<td class=\"tl\">"+state.content+"</td>"+
								"<td class=\"tr\">"+state.price+"</td>"+
							"</tr>";
						}

						i_cnt++;
					});

					$("#plan_list").html(add_html);

					ViewlayerPop(0);

					$("#loading_area").delay(100).fadeOut();
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

<!-- 팝 -->
<div id="layerPop0" class="layerPop" style="display:none">
	<div class="layerPop_inner" style="padding-top: 15px;">
		<div class="pop_wrap">
			<div class="pop_wrap_in " style="max-width:1000px;">
				<div class="pop_head">
					<p class="title" id="yak_tit">보험가입사항</p>
					<p class="x_btn" onclick="CloselayerPop();"><img src="../img/common/close3.png" alt="닫기"></p>
				</div>
				<div class="pop_body ">
					<div class="table_line">
                    <table cellspacing="0" cellpadding="0" summary="보험가입사항" class="table_style2">
                        <caption>
                            보험가입사항
                        </caption>
                        <colgroup>
                            <col width="15%;">
                            <col width="%;">
                            <col width="15%;">
                        </colgroup>
                        <thead>
                            <tr>
                                <th>플랜명 </th>
								<th>담보내용 </th>
                                <th>가입금액</th>
                            </tr>
                        </thead>
                        <tbody id="plan_list">
                        </tbody>
                    </table>
                </div>
				</div>

			</div>
		</div>
	</div>
</div>
<!-- //팝 -->
    </body>

    </html>
