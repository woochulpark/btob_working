<? 
	include ("../include/top.php"); 
	
	$val_list = "page=".$page."&make=".$make."&search=".$search."&start_date=".$start_date."&end_date=".$end_date;

	$vi_q="select * from hana_plan where no='".$num."' and member_no='".$row_mem_info['no']."'";
	$vi_e=mysql_query($vi_q);
	$row=mysql_fetch_array($vi_e);

	if ($row['no']=="") {
?>
<script>
	alert('잘못된 접속 입니다.');
	//history.go(-1);
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
			hana_plan_member
		  where
			hana_plan_no='".$num."'
			and main_check='Y'
		 ";
	$result_mem=mysql_query($sql_mem);
	$row_mem=mysql_fetch_array($result_mem);

	if ($row_mem_info['mem_type']=="1") {
	    $plan_code_row=sql_one_one("plan_code_hana","plan_title"," and member_no='".$row_mem_info['no']."' and plan_code='".$row_mem['plan_code']."'");
	} else {
	    $plan_code_row=sql_one_one("plan_code_btob","plan_title"," and plan_code='".$row_mem['plan_code']."'");
	}
	
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
                        <td class="nb">1234564</td>
                        <th>청약번호</th>
                        <td class="nb">12345565455</td>
                        <th>증권번호</th>
                        <td class="nb">12346979</td>
                    </tr>
                    <tr>
                        <th>거래처명</th>
                        <td>000000여행사</td>
                        <th>청약일</th>
                        <td colspan="3" class="nb">2019-12-26</td>
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
                            <div>DB손해보험</div>
                        </li>
                        <li>
                            <label>공통플랜</label>
                            <div>플랜1플랜1플랜1플랜1</div>
                        </li>
                    </ul>
                    <ul>
                        <li>
                            <label>여행 기간</label>
                            <div class="nb">2019년 12월 4일 18시 ~ 2019년 12월 30일 06시 까지</div>
                        </li>
                        <li>
                            <label>여행지</label>
                            <div>필리핀</div>
                        </li>
                    </ul>
                    <ul>
                        <li>
                            <label>현재 체류지</label>
                            <div>해외</div>
                        </li>
                        <li>
                            <label>여행 목적</label>
                            <div>일반관광</div>
                        </li>
                    </ul>
                    <ul>
                        <li>
                            <label>대표자 이메일</label>
                            <div>toursafe@bis.com</div>
                        </li>
                        <li>
                            <label>대표자 휴대전화</label>
                            <div class="nb">010-1234-5678</div>
                        </li>
                    </ul>
                    <ul>
                        <li class="add">
                            <label>추가정보 <span>1</span></label>
                            <div>반짝이는 별빛들 깜빡이는 불 켜진 건물 우린 빛나고 있네 각자의 방 각자의 별에서 어떤 빛은 야망 어떤 빛은 방황 사람들의 불빛들 모두 소중한 하나 어두운 밤 (외로워 마) 별처럼 다 (우린 빛나) 사라지지 마 큰 존재니까 Let us shine 어쩜 이 밤의 표정이 이토록 또 아름다운 건 저 별들도 불빛도 아닌 우리 때문일 거야
                            </div>
                        </li>
                    </ul>
                    <ul>
                        <li class="add">
                            <label>추가정보 <span>2</span></label>
                            <div>반짝이는 별빛들 깜빡이는 불 켜진 건물 우린 빛나고 있네 각자의 방 각자의 별에서 어떤 빛은 야망 어떤 빛은 방황 사람들의 불빛들 모두 소중한 하나 어두운 밤 (외로워 마) 별처럼 다 (우린 빛나) 사라지지 마 큰 존재니까 Let us shine 어쩜 이 밤의 표정이 이토록 또 아름다운 건 저 별들도 불빛도 아닌 우리 때문일 거야
                            </div>
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
                    <tr>
                        <td class="nb">1</td>
                        <td>홍길동</td>
                        <td>HOGN GILDONG</td>
                        <td class="nb">123456-7894560</td>
                        <td class="nb">26</td>
                        <td>플랜1플랜1플랜1플랜1</td>
                        <td class="t_price nb">19,860</td>
                    </tr>
                    <tr>
                        <td class="nb">2</td>
                        <td>홍길동</td>
                        <td>HOGN GILDONG</td>
                        <td class="nb">123456-7894560</td>
                        <td class="nb">26</td>
                        <td>플랜1플랜1플랜1플랜1</td>
                        <td class="t_price nb">19,860</td>
                    </tr>
                    <tr>
                        <td class="nb">3</td>
                        <td>홍길동</td>
                        <td>HOGN GILDONG</td>
                        <td class="nb">123456-7894560</td>
                        <td class="nb">26</td>
                        <td>플랜1플랜1플랜1플랜1</td>
                        <td class="t_price nb">19,860</td>
                    </tr>
                    <tr>
                        <td class="nb">4</td>
                        <td>홍길동</td>
                        <td>HOGN GILDONG</td>
                        <td class="nb">123456-7894560</td>
                        <td class="nb">26</td>
                        <td>플랜1플랜1플랜1플랜1</td>
                        <td class="t_price nb">19,860</td>
                    </tr>
                    <tr>
                        <td class="nb">5</td>
                        <td>홍길동</td>
                        <td>HOGN GILDONG</td>
                        <td class="nb">123456-7894560</td>
                        <td class="nb">26</td>
                        <td>플랜1플랜1플랜1플랜1</td>
                        <td class="t_price nb">19,860</td>
                    </tr>
                    <tr>
                        <td class="nb">6</td>
                        <td>홍길동</td>
                        <td>HOGN GILDONG</td>
                        <td class="nb">123456-7894560</td>
                        <td class="nb">26</td>
                        <td>플랜1플랜1플랜1플랜1</td>
                        <td class="t_price nb">19,860</td>
                    </tr>
                    <tr>
                        <td class="nb">7</td>
                        <td>홍길동</td>
                        <td>HOGN GILDONG</td>
                        <td class="nb">123456-7894560</td>
                        <td class="nb">26</td>
                        <td>플랜1플랜1플랜1플랜1</td>
                        <td class="t_price nb">19,860</td>
                    </tr>
                    <tr>
                        <td class="nb">8</td>
                        <td>홍길동</td>
                        <td>HOGN GILDONG</td>
                        <td class="nb">123456-7894560</td>
                        <td class="nb">26</td>
                        <td>플랜1플랜1플랜1플랜1</td>
                        <td class="t_price nb">19,860</td>
                    </tr>
                    <tr>
                        <td class="nb">9</td>
                        <td>홍길동</td>
                        <td>HOGN GILDONG</td>
                        <td class="nb">123456-7894560</td>
                        <td class="nb">26</td>
                        <td>플랜1플랜1플랜1플랜1</td>
                        <td class="t_price nb">19,860</td>
                    </tr>
                    <tr>
                        <td class="nb">10</td>
                        <td>홍길동</td>
                        <td>HOGN GILDONG</td>
                        <td class="nb">123456-7894560</td>
                        <td class="nb">26</td>
                        <td>플랜1플랜1플랜1플랜1</td>
                        <td class="t_price nb">19,860</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <section id="dt_tt_price_area">
            <div class="tt_btn">
                <span><button type="button" name="button" id="endorsereq" class="btn_s2">배서 요청</button></span>
                <span><button type="button" name="button" id="endorsedet" class="btn_s2">배서 상세목록</button></span>
                <span><button type="button" name="button" class="btn_download">가입확인서 다운로드</button></span>
                <span><button type="button" name="button" class="btn_download">영문 가입확인서 다운로드</button></span>
            </div>
            <div><!--button type="button" name="button" class="btn_count">총 납입 보험료 계산하기</button--></div>
            <div>
                <ul>
                    <li>총 인원</li>
                    <li><span class="t_num c_black">87</span><span>명</span></li>
                </ul>
                <ul>
                    <li>총 납입 보험료</li>
                    <li><span class="t_num c_red">80,251,370</span><span>원</span></li>
                </ul>
                <ul>
                    <li>추징/환급 보험료</li>
                    <li><span class="t_num c_blue">251,370</span><span>원</span></li>
                </ul>
            </div>
        </section>
        <section id="btn_area">
            <div class="btn_list">
                <button type="button" name="button" class="btn_s2">목록</button>
            </div>
        </section> 
    </section><!-- e : container -->
	</div>
	<!-- //inner_wrap -->
	<? include ("../include/footer.php"); ?>
</div>
<!-- //wrap -->


</body>

</html>
