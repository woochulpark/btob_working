<?
$no=array();
$title=array();
$content=array();
$reg_arr=array();

$cur_date=date("Y-m-d");

$i = 0;
$DB_name = 'free';
$sql_add="";
$sql_add .=" and table_name='board_1'";
$sql_add .=" order by regdate desc limit 3";
$out = sql_one($DB_name,'*',$sql_add);
while($row=$out[$i]){
	$no[$i] = stripslashes($row[no]);
	$title[$i] = stripslashes($row[title]);
	$content[$i] = stripslashes(strip_tags(fnFilterString_bak($row[content])));

	$reg=explode(" ",$row[regdate]);
	$reg_arr[$i]=explode("-",$reg[0]);

	$date_term[$i]=dateDiff($cur_date,$reg[0]);

	$i++;
}
?>
 <div class="notice">
                <div class="ti">
                    <h2>알려드립니다.</h2>
                    <p class="more"><a href="/customer/list.php?page=&make=&search=">더보기 +</a></p>
                </div>
				<?
					if($i  > 0){
				?>
                <div>
                    <ul>
                        <li><a href="../customer/view.php?admin_mode=read&no=<?=$no[0]?>"><?=substrhan($title[0], 72 , "....")?></a></li>
                    </ul>
                    <ul>
                        <li><a href="../customer/view.php?admin_mode=read&no=<?=$no[0]?>"><?=substrhan($content[0], 212, "...")?></a></li>
                    </ul>
                    <ul>
                        <li><?=$reg_arr[0][0]?>-<?=$reg_arr[0][1]?>-<?=$reg_arr[0][2]?></li>
                    </ul>
                </div>
				
                <div>
					<?
						for($k = 1; $k < 3; $k++){
					?>
                    <ul>
                        <li><a href="../customer/view.php?admin_mode=read&no=<?=$no[$k]?>"><?=substrhan($title[$k], 72 , "....")?></a></li>
                        <li><?=$reg_arr[$k][0]?>-<?=$reg_arr[$k][1]?>-<?=$reg_arr[$k][2]?></li>
                    </ul>
					<?
				} // end for
					
					?>
                    <!--ul>
                        <li><a href="#">지급정산일 안내입니다. 인보이스 발행 및 지급정산일 ...</a></li>
                        <li>2020-02-26</li>
                    </ul-->
                </div>
				<?
			
				}
				?>
            </div>
<!--
<h3 class="m_tit">공지사항</h3>
<div class="main_board">
	<ul>
		<? for ($i=0;$i<count($no);$i++) { ?>
		<li><a href="../customer/view.php?admin_mode=read&no=<?=$no[$i]?>">
			<span class="ico">
				<span class="notice">공지</span>
				<? if ($date_term[$i]<7) { ?>
				<span class="new">NEW</span>
				<? } ?>
			</span>
			<strong class="tit"><?=$title[$i]?></strong><span class="txt"><?=$content[$i]?></span><span class="date"><?=$reg_arr[$i][0]?>.<?=$reg_arr[$i][1]?>.<?=$reg_arr[$i][2]?></span></a></li>
		<? } ?>
	</ul>
	<p class="more"><a href="../customer/list.php"><span>더보기</span></a></p>
</div>
-->