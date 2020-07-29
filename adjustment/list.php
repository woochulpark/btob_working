<? 
	include ("../include/top.php"); 

	if (!$page) $page = 1;
	$num_per_page = 10;
	$num_per_page_start = $num_per_page*($page-1);
	$page_per_block = 10;

	if ($start_year=="") {
		$start_year=date("Y");
	}

	if ($start_month=="") {
		$start_month=date("m");
	}

	//if ($start_day=="") {
		$start_day="01";
	//}

	//if ($end_day=="") {
		$prt_end = $start_year."-".$start_month."-01";
		$end_day=date("t", strtotime($prt_end));
	//}
?>
<script>
	var oneDepth = 2; //1차 카테고리
</script>

<div id="wrap">
	<div id="inner_wrap">
		<!-- header -->
		<? include ("../include/header.php"); ?>
			<!-- //header -->
			  <!-- s : container -->
    <section id="container">
        <section id="h1">
            <div><h1>마이 비즈니스</h1></div>
            <div><button type="button" name="button" id="editMeminfo" class="btn_s2 info_modify">정보 수정</button></div>
        </section>
        <section id="mybiz_info">
            <div class="tit"><h2>거래처 정보</h2></div>
            <div class="textBox">
			<?
				$que_account = " SELECT uid,com_name,hphone,fax_contact,com_no, com_open_date,post_no,post_addr, post_addr_detail, file_real_name, file_name FROM toursafe_members where uid = '{$_SESSION['s_mem_id']}' ";				
				$result_account = mysql_query($que_account);

				if(!$result_account){
					exit;
				}  else {
					while($row=mysql_fetch_row($result_account)){
						$com_id = $row[0];
						$company_n = $row[1];
						$contact = decode_pass($row[2],$pass_key);
						$fax = ($row[3] != '')?decode_pass($row[3],$pass_key) : '';//decode_pass($row['fax_contact'],$pass_key);
						$business_no = $row[4];
						$openDate = $row[5];
						$fr_name = $row[9];
						$f_name = $row[10];
						$postNo = $row[6];
						$postAddr = $row[7];
						$postDetail = $row[8];
					}
					$arr_opDate = explode("-",$openDate);
				}

				//$check_date_start=strtotime($start_year.$start_month.$start_day." 00:00:00");
					//$check_date_end=strtotime($start_year.$start_month.$end_day." 23:59:59");
					$check_date_start=strtotime($start_year.$start_month.$start_day." 00:00:00");
					$check_date_end=strtotime($start_year.$start_month.$end_day." 23:59:59");
			?>
                <div class="write_area">
                    <ul>
                        <li>
                            <label>거래처 ID</label>
                            <div class="nb"><?=$com_id?></div>
                        </li>
                        <li>
                            <label>상호명</label>
                            <div><?=$company_n?></div>
                        </li>
                    </ul>
                    <ul>
                        <li>
                            <label>개업연월일<span class="stt">(사업자등록증 기준)</span></label>
                            <div class="nb"><?=($openDate != '') ? $arr_opDate[0]."년 ".$arr_opDate[1]."월 ".$arr_opDate[2]."일 " : "&nbsp;";?></div>
                        </li>
                        <li>
                            <label>사업자 등록 번호</label>
                            <div class="nb"><?=$business_no?>
							<?
								if($fr_name != '' && $f_name != ''){
							?>
							<span id="fDown"></span>
							<?
								}
							?>
							</div>
                        </li>
                    </ul>
                    <ul>
                        <li>
                            <label>전화번호</label>
                            <div class="nb"><?=$contact?></div>
                        </li>
                        <li>
                            <label>팩스번호</label>
                            <div class="nb"><?=$fax?></div>
                        </li>
                    </ul>
                    <ul>
                        <li class="add">
                            <label>주소</label>
                            <div><?=$postAddr." ".$postDetail." (".$postNo.")"?></div>
                        </li>
                    </ul>
                </div>
            </div>
        </section>
        <div class="line_b"></div>
<?
	if($_SESSION['s_mem_insu1'] == 'Y'){
		
		$point_s_start = date("Y-m-d H:i:s", $check_date_start);
		$point_s_end = date("Y-m-d H:i:s", $check_date_end);
		//SELECT sum(if(whether = 'A', point, 0)) as total_acc, sum(if(whether = 'U', point, 0)) as total_use FROM hana_plan_point where member_no = '28' and reg_date >= '2020-05-01 00:00:00' and reg_date <='2020-05-31 23:59:59'
		$point_que = "SELECT sum(if(whether = 'A', point, 0)) as total_acc, sum(if(whether = 'U', point, 0)) as total_use FROM hana_plan_point where member_no = '{$_SESSION['s_mem_no']}' and reg_date <= '{$point_s_end}' and reg_date >='$point_s_start' ";
		//echo "<!--".$point_que."-->";
		$point_result = mysql_query($point_que);
		$point_row = mysql_fetch_array($point_result);
?>
        <section id="mybiz_info">
            <div class="tit"><h2>비즈니스 포인트</h2></div>
            <div class="textBox">
                <div class="write_area">
					<div class="point_prt">	
						<ul >
                            <li>누적 Point<span class="c_red pdL12"><?=($point_row['total_acc'] =='')? 0:$point_row['total_acc'];?></span> point</li>
                            <li>사용 Point<span class="c_black pdL12"><?=($point_row['total_use'] =='')? 0:$point_row['total_use'];?></span> point</li>
                            <li>잔여 Point<span class="c_blue pdL12"><? echo $point_row['total_acc'] - $point_row['total_use']; ?></span> point</li>
                        </ul>
					</div>
                </div>    
            </div>
        </section>
        <div class="line_b"></div>
<?
	}
?>
        <section id="result_mg">
            <h2>실적관리</h2>
            <form action="" method="" id="formBox" name="formBox">
            <fieldset>
                <div class="search">
                    <ul>
                        <li>
                            <select name="start_year" id="start_year" class="nb">
                                <?
								for($i=date("Y",time()); $i > 2012; $i--){
								?>
								<option value="<?=$i?>" <?=($start_year == $i)?" selected ":"";?> ><?=$i?>년</option>
								<?
								}
								?>
                            </select>
                        </li>
                        <li>
                            <select name="start_month" id="start_month" class="nb">
							   <?
								for($i=12; $i > 0; $i--){
								?>
                                <option value="<?=($i < 10)?"0".$i:$i;?>" <?=($start_month == $i)?" selected ":"";?>><?=$i?>월</option>
                                  <?
								}
								?>
                            </select>
                        </li>
                        <li><button type="button" name="submit2" class="btn_s1" onclick="document.formBox.submit();">검색</button></li>
                    </ul>
                </div>
            </fieldset>
            </form>
<?
	$sql_total_sum="select 
		 FROM_UNIXTIME(b.change_date,'%Y년 %m월') as c_date, FROM_UNIXTIME(b.change_date,'%Y%m') as check_date, sum(in_price) as all_in_price, sum(change_price) as all_change_price, sum(change_price-((change_price*com_percent)/100)) as all_real_change_price,
		 sum(a.join_cnt) as all_people
	  from
		hana_plan a
		left join hana_plan_change b on a.no=b.hana_plan_no and b.change_date >='{$check_date_start}' and b.change_date <='{$check_date_end}'
	  where
		a.member_no='{$_SESSION['s_mem_no']}' and b.change_date!=''
	 ";
	 $sql_total_result = mysql_query($sql_total_sum);
	 $sql_total_rows = mysql_fetch_array($sql_total_result);
?>
                <div class="result">
                    <div><button type="button" name="button" class="btn_s2" onclick="window.open('invoice.php?check_start=<?=$check_date_start?>&check_end=<?=$check_date_end?>', 'invoice', 'width=900,height=650,left=100,top=0,scrollbars=yes')">인보이스 출력</button></div>
                    <div>
                        <ul>
                            <!--li>미수보험료<span class="c_red pdL12">234,556</span>원</li-->
                            <li>피보험자수<span class="c_black pdL12"><?=number_format($sql_total_rows['all_people'])?></span>명</li>
                            <li>실적<span class="c_blue pdL12"><?=number_format($sql_total_rows['all_change_price'])?></span>원</li>
                        </ul>
                    </div>
                </div>
        </section>
        <section id="of-x">
            <table id="t_re_list">
                <caption>실적관리 검색 결과</caption>
                <colgroup>
                    <col width="40px">
                    <col width="190px">
                    <!--col width="100px"-->
                    <col width="100px">
                    <col width="100px">
                    <col width="100px">
                    <col width="100px">
                    <col width="100px">
                    <col width="100px">
                    <col width="100px">
                    <col width="92px">
                    <col width="70px">
                    <!--col width="70px"-->
                </colgroup>
                <thead>
                    <tr>
                        <th scope="col">번호</th>
                        <th scope="col">보험사명</th>
                        <!--th scope="col">상품명</th-->
                        <th scope="col">청약일</th>
                        <th scope="col">처리일</th>
                        <th scope="col">시작일</th>
                        <th scope="col">종료일</th>
                        <th scope="col">피보험자명</th>
                        <th scope="col">보험료</th>
                        <th scope="col"><?=($_SESSION['s_mem_insu1'] == "Y") ? "포인트":"";?><?=( ($_SESSION['s_mem_insu1'] == "Y") &&  ($_SESSION['s_mem_insu2'] == "Y") ) ? "/":"";?><?=($_SESSION['s_mem_insu2'] == "Y") ? "커미션":"";?></th>
                        <th scope="col">할인보험료</th>
                        <th scope="col">선결제</th>
                        <!--th scope="col">정산여부</th-->
                    </tr>
                </thead>
				<?					
					/*
					$sql_sum="select 
					 FROM_UNIXTIME(b.change_date,'%Y년 %m월') as c_date, FROM_UNIXTIME(b.change_date,'%Y%m') as check_date, sum(in_price) as all_in_price, sum(change_price) as all_change_price, sum(change_price-((change_price*com_percent)/100)) as all_real_change_price
				  from
					hana_plan a
					left join hana_plan_change b on a.no=b.hana_plan_no and b.change_date >='".$check_date_start."' and b.change_date <='".$check_date_end."'
				  where
					a.member_no='{$_SESSION['s_mem_no']}' and b.change_date!=''
				 ";
				 */
				 $sql_sum = "select 
		*, b.no as plan_hana_no, c.uid, c.com_name, a.regdate as confirm_date, a.no as hana_plan_change_no, a.com_percent, c.no as member_no, b.join_hphone as hphone, b.regdate as regdate, b.insurance_comp, a.change_type plan_state, a.change_date as change_date, sum(a.change_price-((a.change_price*a.com_percent)/100)) as all_real_change_price, sum(a.in_price) as all_in_price
	  from
		hana_plan_change a
		left join hana_plan b on a.hana_plan_no=b.no
		left join toursafe_members c on b.member_no=c.no 
	  where
		1 = 1 and b.member_no = '{$_SESSION['s_mem_no']}'
		and a.change_date >='{$check_date_start}' and a.change_date <='{$check_date_end}'
		and a.change_date != ''
	  group by a.no
	  order by a.no desc";		
	  
	  				$result = mysql_query($sql_sum);
					$total_record=mysql_num_rows($result);
				 
				 $sql_sum=$sql_sum." limit $num_per_page_start, $num_per_page";
				 	$result_sum = mysql_query($sql_sum);
						 //echo "<!--".$sql_sum."-->";
					
					$list_page=list_page($num_per_page,$page,$total_record);//function_query
					$total_page	= $list_page['0'];
					$first		= $list_page['1'];
					$last		= $list_page['2'];
					$article_num = $total_record - $num_per_page*($page-1);
				?>
                <tbody>
				<?
					while($row_sum = mysql_fetch_array($result_sum)){
				?>
                    <tr>
                        <td class="nb"><?=$article_num?></td>
                        <td><? echo array_search($row_sum['insurance_comp'],$insuran_option);?></td>
                        <!--td class="t_left">안전한 여행의 시작! 에이...</td-->
                        <td class="nb"><?=$row_sum['plan_join_code_date']?></td>
                        <td class="nb"><?=date("Y-m-d",$row_sum['change_date'])?></td>
                        <td class="nb"><?=$row_sum['start_date']?></td>
                        <td class="nb"><?=$row_sum['end_date']?></td>
                        <td><?=$row_sum['join_name']?></td>
                        <td class="c_black nb"><!--t_right--><?=number_format($row_sum['change_price'])?></td>
                        <td class="c_red nb"><?=($row_sum['com_percent'] != '')? $row_sum['com_percent']."%":number_format($row_sum['com_point']);?></td>
                        <td class="nb"><?=number_format($row_sum['all_real_change_price'])?></td>
                        <td><?=($row_sum['all_in_price'] == 0) ? 'NO':'YES';?></td>
                        <!--td>NO</td-->
                    </tr>
					<? 
						$article_num--;
						}
				/*
                    <tr>
                        <td class="nb">19</td>
                        <td>DB손해보험</td>
                        <td class="t_left">여행에 안심을 더하다! 당신...</td>
                        <td class="nb">2020-01-23</td>
                        <td class="nb">2020-01-14</td>
                        <td class="nb">2020-02-12</td>
                        <td class="nb">2020-06-03</td>
                        <td>홍길동</td>
                        <td class="t_right c_black nb">738,800</td>
                        <td class="c_red nb">20%</td>
                        <td class="t_right nb">70,450</td>
                        <td>YES</td>
                        <td>NO</td>
                    </tr>
                    <tr>
                        <td class="nb">18</td>
                        <td>DB손해보험</td>
                        <td class="t_left">공인인증서 없이, 동반자도 ...</td>
                        <td class="nb">2020-01-23</td>
                        <td class="nb">2020-01-14</td>
                        <td class="nb">2020-02-12</td>
                        <td class="nb">2020-06-03</td>
                        <td class="nb">홍길동</td>
                        <td class="t_right c_black nb">15,890</td>
                        <td class="c_red nb">20%</td>
                        <td class="t_right nb">39,510</td>
                        <td>YES</td>
                        <td>NO</td>
                    </tr>
                    <tr>
                        <td class="nb">17</td>
                        <td>DB손해보험</td>
                        <td class="t_left">여행에 안심을 더하다! 당신...</td>
                        <td class="nb">2020-01-23</td>
                        <td class="nb">2020-01-14</td>
                        <td class="nb">2020-02-12</td>
                        <td class="nb">2020-06-03</td>
                        <td>홍길동</td>
                        <td class="t_right c_black nb">2,346,310</td>
                        <td class="c_red nb">20%</td>
                        <td class="t_right nb">245,000</td>
                        <td>YES</td>
                        <td>NO</td>
                    </tr>
                    <tr>
                        <td class="nb">16</td>
                        <td>DB손해보험</td>
                        <td class="t_left">안전한 여행의 시작! 에...</td>
                        <td class="nb">2020-01-23</td>
                        <td class="nb">2020-01-14</td>
                        <td class="nb">2020-02-12</td>
                        <td class="nb">2020-06-03</td>
                        <td>홍길동</td>
                        <td class="t_right c_black nb">9,700,810</td>
                        <td class="c_red nb">20%</td>
                        <td class="t_right nb">333,730</td>
                        <td>YES</td>
                        <td>NO</td>
                    </tr>
                    <tr>
                        <td class="nb">15</td>
                        <td>DB손해보험</td>
                        <td class="t_left">안전한 여행의 시작! 에...</td>
                        <td class="nb">2020-01-23</td>
                        <td class="nb">2020-01-14</td>
                        <td class="nb">2020-02-12</td>
                        <td class="nb">2020-06-03</td>
                        <td class="nb">홍길동</td>
                        <td class="t_right c_black nb">642,880</td>
                        <td class="c_red nb">20%</td>
                        <td class="t_right nb">12,780</td>
                        <td>YES</td>
                        <td>NO</td>
                    </tr>
                    <tr>
                        <td class="nb">14</td>
                        <td>DB손해보험</td>
                        <td class="t_left">공인인증서 없이, 동반자도...</td>
                        <td class="nb">2020-01-23</td>
                        <td class="nb">2020-01-14</td>
                        <td class="nb">2020-02-12</td>
                        <td class="nb">2020-06-03</td>
                        <td>홍길동</td>
                        <td class="t_right c_black nb">1,467,200</td>
                        <td class="c_red nb">20%</td>
                        <td class="t_right nb">300,540</td>
                        <td>YES</td>
                        <td>NO</td>
                    </tr>
                    <tr>
                        <td class="nb">13</td>
                        <td>DB손해보험</td>
                        <td class="t_left">안전한 여행의 시작! 에...</td>
                        <td class="nb">2020-01-23</td>
                        <td class="nb">2020-01-14</td>
                        <td class="nb">2020-02-12</td>
                        <td class="nb">2020-06-03</td>
                        <td>홍길동</td>
                        <td class="t_right c_black nb">1,790,450</td>
                        <td class="c_red nb">20%</td>
                        <td class="t_right nb">375,810</td>
                        <td>YES</td>
                        <td>NO</td>
                    </tr>
                    <tr>
                        <td class="nb">12</td>
                        <td>DB손해보험</td>
                        <td class="t_left">공인인증서 없이, 동반자...</td>
                        <td class="nb">2020-01-23</td>
                        <td class="nb">2020-01-14</td>
                        <td class="nb">2020-02-12</td>
                        <td class="nb">2020-06-03</td>
                        <td>홍길동</td>
                        <td class="t_right c_black nb">320,000</td>
                        <td class="c_red nb">20%</td >
                        <td class="t_right nb">10,560</td>
                        <td>YES</td>
                        <td>NO</td>
                    </tr>
                    <tr>
                        <td class="nb">11</td>
                        <td>DB손해보험</td>
                        <td class="t_left">안전한 여행의 시작! 에...</td>
                        <td class="nb">2020-01-23</td>
                        <td class="nb">2020-01-14</td>
                        <td class="nb">2020-02-12</td>
                        <td class="nb">2020-06-03</td>
                        <td>홍길동</td>
                        <td class="t_right c_black nb">3,364,800</td>
                        <td class="c_red nb">20%</td>
                        <td class="t_right nb">118,900</td>
                        <td>YES</td>
                        <td>NO</td>
                    </tr>
					*/
					?>
                </tbody>
            </table>
        </section> 
        <section id="btn_area_list">
            <div>
                <span><button type="button" id="excel_adjust_hyecho" class="btn_download">엑셀 다운로드</button></span>
            </div>
        </section>
		<?
			
				$where = "&start_year=".$start_year;
				$where .= "&start_month=".$start_month;

	        b2b_list_page_numbering_div($page_per_block,$page,$total_page,$where);
		?>
    </section><!-- e : container -->
	<? include ("../include/footer.php"); ?>
</div>
<!-- //wrap -->
<script type="text/javascript">
	$(document).ready(function(){
		$('#excel_adjust_hyecho').on('click',function(){		
			$('form[name=formBox]').attr('method','post');
			$('form[name=formBox]').attr('action','./adjuste_excel_report.php');	
			$('form[name=formBox]').submit();
			$('form[name=formBox]').attr('action','/adjustment/list.php');	
		});	

		$('#editMeminfo').on('click',function(){
			location.href="/member/join03.php";
		});

		$('#fDown').on('click',function(){
			location.href="/lib/download.php";
		});
	});


</script>

</body>

</html>
