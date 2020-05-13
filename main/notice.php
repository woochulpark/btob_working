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
