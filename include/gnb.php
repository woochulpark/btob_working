<div class="gnb">
    <ul>	
		<li class="gnb01"><a href="javascript:void(0);"><span>여행자 보험가입</span></a>
		<!--<?print_r($_SESSION)?>-->
		<? if(isset($_SESSION['s_mem_no']) && ($_SESSION['s_mem_type'] != 'B2C')){  ?>
			<ul class="sub_menu">			
		    	<li class="lnb2"><a href="../trip/01.php?tripType=2">단기해외 여행자 보험가입</a></li>			
				<li class="lnb1"><a href="../trip/01.php?tripType=1">단기국내 여행자 보험가입</a></li>				
				<li class="lnb3"><?//<a href="../trip/L0.php">?><a href="javascript:alert('준비중입니다.');">장기해외 여행자보험 보험가입<br>(전문직/유학생)</a></li>		    
			</ul>
		<? } ?>
        </li>        
        <li class="gnb03"><a href="javascript:void(0);"><span>신청내역 조회/수정</span></a>
		<? if(isset($_SESSION['s_mem_no']) && ($_SESSION['s_mem_type'] != 'B2C')){  ?>
			<ul class="sub_menu">
				<li class="lnb1"><a href="../check/list.php">신청내역 조회/수정</a></li>
				<li class="lnb2"><a href="../check/endorse_list.php">배서진행현황</a></li>
			</ul>
		<? } ?>
		</li>			
		<li class="gnb02"><a href="../adjustment/list.php"><span>마이 비즈니스</span></a></li>		
		<li class="gnb04"><? if(isset($_SESSION['s_mem_no']) && ($_SESSION['s_mem_type'] != 'B2C')){ ?><a href="../claim/list.php"><span>청구안내</span></a><? } else { ?><a href="javascript:void(0);"><span>청구안내</span></a><? } ?></li>		
        <li class="gnb05"><a href="../customer/list.php"><span>공지사항</span></a></li>
		<li class="gnb06"><a href="../src/logout.php"><span>로그아웃</span></a></li>
    </ul>
</div>
