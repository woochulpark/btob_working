<? 
	include ("../include/top.php"); 
	
	$val_list = "page=".$page."&search_info=".$search_info."&search=".$search."&insu_ch=".$insu_ch."&insu_ch_b".$insu_ch_b."&searchDate=".$searchDate."&s_start_date=".$s_start_date."&s_end_date=".$s_end_date;

	$vi_q="select * from hana_plan_test where no='".$num."' and member_no='{$_SESSION['s_mem_no']}'";

	$vi_e=mysql_query($vi_q);
	$row=mysql_fetch_array($vi_e);

	if ($row['no']=="") {
?>
<script>
	alert('잘못된 접속 입니다.');
	history.go(-1);
</script>
<?
		//exit;
	}

	if ($row['nation_no']=="0") {
		$nation_text="국내";
	} else {
		$nation_row=sql_one_one("nation","nation_name"," and no='".$row['nation_no']."'");
		$nation_text=stripslashes($nation_row['nation_name']);
	}

	$sql_mem="select 
			*
		  from
			hana_plan_member_test
		  where
			hana_plan_no='".$num."'
			and main_check='Y'
		 ";
	$result_mem=mysql_query($sql_mem);
	$row_mem=mysql_fetch_array($result_mem);
	
/*
	if ($row_mem_info['mem_type']=="1") {
	    $plan_code_row=sql_one_one("plan_code_hana","plan_title"," and member_no='".$row_mem_info['no']."' and plan_code='".$row_mem['plan_code']."'");
	} else {
	    $plan_code_row=sql_one_one("plan_code_btob","plan_title"," and plan_code='".$row_mem['plan_code']."'");
	}
*/	
    $cooperation_row = sql_one("toursafe_members","uid, com_name", " and no = '{$row['member_no']}' ");

	$plan_mem_sql = "select 
			*
		  from
			hana_plan_member_test
		  where
			hana_plan_no='{$num}'
			and
			member_no = '{$_SESSION['s_mem_no']}' ";
	$plan_mem_result = mysql_query($plan_mem_sql);

	$prt_start_date = explode("-",$row['start_date']);
	$prt_end_date = explode("-",$row['end_date']);
?>
<script>
	var oneDepth = 3; //1차 카테고리
</script>

<div id="wrap">
	<div id="inner_wrap">
		<!-- header -->
		<? include ("../include/header.php"); ?>
			<!-- //header -->
			<!-- s : container -->
    <section id="container">
        <section id="h1">
            <h1>신청내역조회/수정</h1>
        </section>
        <section id="dt_ac_info">
            <table id="t_info">
                <tbody>
                    <tr>
                        <th>거래처 ID</th>
                        <td class="nb"><?=$cooperation_row[0]['uid']?></td>
                        <th>청약번호</th>
                        <td class="nb"><?=$row['no']?></td>
                        <th>증권번호</th>
                        <td class="nb"><?=$row['plan_join_code']?></td>
                    </tr>
                    <tr>
                        <th>거래처명</th>
                        <td><?=$cooperation_row[0]['com_name']?></td>
                        <th>청약일</th>
                        <td colspan="3" class="nb"><?=$row['plan_join_code_date']?></td>
                    </tr>
                </tbody>
            </table>
        </section>
        <section id="dt_ssc_info">
            <div class="tit"><h2>청약 정보</h2></div>
            <div class="textBox">
                <div class="write_area">
                    <ul>
                        <li>
                            <label>보험사 선택</label>
                            <div><?=($row['insurance_comp'] != '')? $row['insurance_comp']:"&nbsp;";?></div>
                        </li>
                        <li>
                            <label>공통플랜</label>
                            <div><?=($row['common_plan'] != '')? $row['common_plan']:"&nbsp;";?></div>
                        </li>
                    </ul>
                    <ul>
                        <li>
                            <label>여행 기간</label>
                            <div class="nb"><?=$prt_start_date[0]?>년 <?=$prt_start_date[1]?>월 <?=$prt_start_date[2]?>일 <?=$row['start_hour']?>시 ~ <?=$prt_end_date[0]?> 년 <?=$prt_end_date[1]?>월 <?=$prt_end_date [1]?>일 <?=$row['end_hour']?>시 까지</div>
                        </li>
                        <li>
                            <label>여행지</label>
                            <div><?=$nation_text?></div>
                        </li>
                    </ul>
                    <ul>
                        <li>
                            <label>현재 체류지</label>
                            <div><?=($row['current_resi'] != '')? $row['current_resi']:"&nbsp;"?></div>
                        </li>
                        <li>
                            <label>여행 목적</label>
                            <div><?=($row['trip_purpose'] != '')? $trip_purpose_array[$row['trip_purpose']]:"&nbsp;"?></div>
                        </li>
                    </ul>
                    <ul>
                        <li>
                            <label>대표자 이메일</label>

                            <div><?=($row_mem['email'] != '2dfc410077d20e74')? decode_pass($row_mem['email'],$pass_key):"&nbsp;"?></div>
                        </li>
                        <li>
                            <label>대표자 휴대전화</label>
                            <div class="nb"><?=($row_mem['hphone'] != '')? decode_pass($row_mem['hphone'],$pass_key):"&nbsp;"?></div>
                        </li>
                    </ul>
                    <ul>
                        <li class="add">
                            <label>추가정보 <span>1</span></label>
                            <div><?=($row['etc_memo1'] != '')?$row['etc_memo1']:"&nbsp;";?>
                            </div>
                        </li>
                    </ul>
                    <ul>
                        <li class="add">
                            <label>추가정보 <span>2</span></label>
                            <div><?=($row['etc_memo2'] != '')?$row['etc_memo2']:"&nbsp;";?></div>
                        </li>
                    </ul>
                </div>
            </div>
        </section>
        <div class="line"></div>
        <section>
            <h2>피보험자 총 명세</h2>
        </section>
        <div id="dt_is_list_area">
            <table id="t_re_list">
                <thead>
                    <tr>
                        <th scope="col">번호</th>
                        <th scope="col">이름</th>
                        <th scope="col">영문 이름</th>
                        <th scope="col">주민등록번호</th>
                        <th scope="col">나이</th>
                        <th scope="col">플랜</th>
                        <th scope="col">보험료(원)</th>
                    </tr>
                </thead>
                <tbody>
				<?
					if($plan_mem_result){
						$mem_cnt = 1;
						$totalPrice = 0;
						while($plan_mem_row = mysql_fetch_array($plan_mem_result)){		
							if($plan_mem_row['plan_state']!='3') {
								$totalPrice = $totalPrice + $plan_mem_row['plan_price'];
							}
				?>
                    <tr>
                        <td class="nb"><?=$mem_cnt?></td>
                        <td><?=$plan_mem_row['name']?></td>
                        <td><?=($plan_mem_row['name_eng'] != '')? $plan_mem_row['name_eng']:'&nbsp;';?></td>
                        <td class="nb"><?=decode_pass($plan_mem_row['jumin_1'],$pass_key)?>-*******</td>
                        <td class="nb"><?=$plan_mem_row['age']?></td>
                        <td><?=$plan_mem_row['plan_code']?></td>
                        <td class="t_price nb"><?=number_format($plan_mem_row['plan_price'])?></td>
                    </tr>
					<?
								$mem_cnt++;
							}
						} //plan_mem_result if end						
			
					?>
                </tbody>
            </table>
        </div>
        <section id="dt_tt_price_area">
            <div class="tt_btn">
                <span><button type="button" name="endorsereq" id="endorsereq" class="btn_s2">배서 요청</button></span>
                <span><button type="button" name="endorsedet" id="endorsedet" class="btn_s2">배서 상세목록</button></span>
                <span><button type="button" name="regiconf" id="regiconf" class="btn_download">가입확인서 다운로드</button></span>
               <!-- <span><button type="button" name="button" class="btn_download">영문 가입확인서 다운로드</button></span> -->
            </div>
            <div><!--button type="button" name="button" class="btn_count">총 납입 보험료 계산하기</button--></div>
            <div>
                <ul>
                    <li>총 인원</li>
                    <li><span class="t_num c_black"><?=number_format($row['join_cnt'])?></span><span>명</span></li>
                </ul>
                <ul>
                    <li>총 납입 보험료</li>
                    <li><span class="t_num c_red"><?=number_format($totalPrice)?></span><span>원</span></li>
                </ul>
                <ul>
                    <li>추징/환급 보험료</li>
                    <li><span class="t_num c_blue">251,370</span><span>원</span></li>
                </ul>
            </div>
        </section>
        <section id="btn_area">
            <div class="btn_list">
                <button type="button" name="listgo" class="btn_s2">목록</button>
            </div>
        </section> 
    </section><!-- e : container -->
	</div>
	<!-- //inner_wrap -->
	<? include ("../include/footer.php"); ?>
</div>
<!-- //wrap -->


</body>
<script type="text/javascript">
	$('button[name=listgo]').on('click',function(){
		var remain = '<?=$val_list?>';
		location.href='/check/list.php?'+remain;
	});

	$('button[name=regiconf]').on('click',function(){
		window.open('/src/regi_confirm.php?num=<?=$row['no']?>', 'confirmation', 'width=900,height=650,left=100,top=0,scrollbars=yes')
	});
</script>
</html>
