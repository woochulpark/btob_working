<? 
	include ("../include/top.php"); 

	if ($start_year=="") {
		$start_year=date("Y");
	}

	if ($start_month=="") {
		$start_month=date("m");
	}

	if ($start_day=="") {
		$start_day="01";
	}

	if ($end_day=="") {
		$end_day=date("d");
	}
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
            <div><button type="button" name="button" class="btn_s2 info_modify">정보 수정</button></div>
        </section>
        <section id="mybiz_info">
            <div class="tit"><h2>거래처 정보</h2></div>
            <div class="textBox">
                <div class="write_area">
                    <ul>
                        <li>
                            <label>거래처 ID</label>
                            <div class="nb">215652156</div>
                        </li>
                        <li>
                            <label>상호명</label>
                            <div>000여행사</div>
                        </li>
                    </ul>
                    <ul>
                        <li>
                            <label>개업연월일<span class="stt">(사업자등록증 기준)</span></label>
                            <div class="nb">2014년 5월 14일</div>
                        </li>
                        <li>
                            <label>사업자 등록 번호</label>
                            <div class="nb">123-45-6789<span></span></div>
                        </li>
                    </ul>
                    <ul>
                        <li>
                            <label>전화번호</label>
                            <div class="nb">02-589-8585</div>
                        </li>
                        <li>
                            <label>팩스번호</label>
                            <div class="nb">02-589-8587</div>
                        </li>
                    </ul>
                    <ul>
                        <li class="add">
                            <label>주소</label>
                            <div>서울시 종로구 경희궁 1길 18(03176)</div>
                        </li>
                    </ul>
                </div>
            </div>
        </section>
        <div class="line_b"></div>
        <section id="mybiz_info">
            <div class="tit"><h2>비즈니스 포인트</h2></div>
            <div class="textBox">
                <div class="write_area">
                정책필요
                </div>    
            </div>
        </section>
        <div class="line_b"></div>
        <section id="result_mg">
            <h2>실적관리</h2>
            <form action="" method="" id="formBox">
            <fieldset>
                <div class="search">
                    <ul>
                        <li>
                            <select name="" id="" class="nb">
                                <?
								for($i=date("Y",time()); $i > 2012; $i--){
								?>
								<option value="<?=$i?>" <?=(date("Y",time()) == $i)?" selected ":"";?> ><?=$i?>년</option>
								<?
								}
								?>
                            </select>
                        </li>
                        <li>
                            <select name="" id="" class="nb">
							   <?
								for($i=12; $i > 0; $i--){
								?>
                                <option value="<?=($i < 10)?"0".$i:$i;?>" <?=(date("m",time()) == $i)?" selected ":"";?>><?=$i?>월</option>
                                  <?
								}
								?>
                            </select>
                        </li>
                        <li><button type="button" name="submit" class="btn_s1">검색</button></li>
                    </ul>
                </div>
            </fieldset>
            </form>
                <div class="result">
                    <div><button type="button" name="button" class="btn_s2">인보이스 출력</button></div>
                    <div>
                        <ul>
                            <li>미수보험료<span class="c_red pdL12">234,556</span>원</li>
                            <li>피보험자수<span class="c_black pdL12">8,945</span>명</li>
                            <li>실적<span class="c_blue pdL12">4,155,400</span>원</li>
                        </ul>
                    </div>
                </div>
        </section>
        <section id="of-x">
            <table id="t_re_list">
                <caption>실적관리 검색 결과</caption>
                <colgroup>
                    <col width="40px">
                    <col width="120px">
                    <col width="200px">
                    <col width="100px">
                    <col width="100px">
                    <col width="100px">
                    <col width="100px">
                    <col width="100px">
                    <col width="100px">
                    <col width="70px">
                    <col width="92px">
                    <col width="70px">
                    <col width="70px">
                </colgroup>
                <thead>
                    <tr>
                        <th scope="col">번호</th>
                        <th scope="col">보험사명</th>
                        <th scope="col">상품명</th>
                        <th scope="col">청약일</th>
                        <th scope="col">처리일</th>
                        <th scope="col">시작일</th>
                        <th scope="col">종료일</th>
                        <th scope="col">피보험자명</th>
                        <th scope="col">보험료</th>
                        <th scope="col">커미션율</th>
                        <th scope="col">할인보험료</th>
                        <th scope="col">선결제</th>
                        <th scope="col">정산여부</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="nb">20</td>
                        <td>DB손해보험</td>
                        <td class="t_left">안전한 여행의 시작! 에이...</td>
                        <td class="nb">2020-01-23</td>
                        <td class="nb">2020-01-14</td>
                        <td class="nb">2020-02-12</td>
                        <td class="nb">2020-06-03</td>
                        <td>홍길동</td>
                        <td class="t_right c_black nb">46,310</td>
                        <td class="c_red nb">20%</td>
                        <td class="t_right nb">5,000</td>
                        <td>YES</td>
                        <td>NO</td>
                    </tr>
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
                </tbody>
            </table>
        </section> 
        <section id="btn_area_list">
            <div>
                <span><button type="button" name="button" class="btn_download">엑셀 다운로드</button></span>
            </div>
        </section>
        <section id="paging">
            <a href="#" class="arrow first" id=""><span>첫페이지</span></a>
            <a href="#" class="arrow prev" id=""><span>이전페이지</span></a>
            <span class="num">
                <a href="#">1</a>
                <a href="#">2</a>
                <a href="#">3</a>
                <a href="#">4</a>
                <a href="#">5</a>
                <a href="#">6</a>
                <a href="#">7</a>
                <a href="#" class="on">8</a>
                <a href="#">9</a>
                <a href="#">10</a>
            </span>
            <a href="#" class="arrow next" id=""><span>다음페이지</span></a>
            <a href="#" class="arrow last" id=""><span>마지막페이지</span></a>
        </section>
    </section><!-- e : container -->
	<? include ("../include/footer.php"); ?>
</div>
<!-- //wrap -->
<script type="text/javascript">
	$(document).ready(function(){
		$('#excel_adjust_hyecho').on('click',function(){		
			$('form[name=form1]').attr('method','post');
			$('form[name=form1]').attr('action','./adjuste_excel_report.php');	
			$('form[name=form1]').submit();
			$('form[name=form1]').attr('action','/adjustment/list.php');	
		});	
	});


</script>

</body>

</html>
