<? include ("../include/top.php"); ?>

<script>
	var oneDepth = 5; //1차 카테고리
</script>

<?
	$DB_name = "free";
	$table_name="board_1";

	$field = "hit=hit+1";
	
	$sql_add = " and no='$no' and table_name='$table_name'";
	sql_up($DB_name,$field,$sql_add); // 히트수 증가

	//리스트가 될 쿼리를 작성한다.
	$this_q="select * from $DB_name where 1 and no='$no'";
	$query_e =mysql_query($this_q) or die(mysql_error());
	$que=mysql_fetch_array($query_e);

	$qs = "page=$page&make=$make&search=$search";
	$s_url = $PHP_SELF;

	if ($que['no']=="") { 
?>
<script>
	alert('해당게시물이 없습니다.');
	history.go(-1);
</script>
<?
		exit;
	}
?>
<div id="wrap">
	<div id="inner_wrap">
		<!-- header -->
		<? include ("../include/header.php"); ?>
			<!-- //header -->
			<!-- container -->
			<div style="height:40px;"></div>
			<div id="container">
				<div class="view_tit">
					<h3 class="v_tit"><?=stripslashes($que['title'])?></h3>
				</div>

				<p class="click_count">조회수 : <?=stripslashes($que['hit'])?></p>
				<div class="board-view_top">
					<table cellspacing="0" cellpadding="0" summary="상세" class="board-view">
						<caption>
							상세
						</caption>
						<colgroup>
							<col class="m_th_s" width="130px;">
							<col width="30%;">
							<col class="m_th_s" width="130px;">
							<col width="30%">

						</colgroup>
						<tbody>
							<tr>
								<th>작성일</th>
								<td><? $regdate = date("Y.m.d",strtotime($que[regdate])); echo$regdate; ?></td>
								<th>작성자</th>
								<td><?=stripslashes($que['name'])?></td>
							</tr>
							<tr>
								<th>첨부파일</th>
								<td colspan="3">
<?
$file_d = explode(";",$que[file_name]);
$real_file_d = explode(';',$que[real_file_name]);
$fcnt = count($file_d);
if($que[file_name]!=""){
	for($i=0;$i<$fcnt;$i++){
		$file_print .= "<a href='../lib/download.php?file_name=".urlencode($real_file_d[$i])."&save_file=".$file_d[$i]."&meta=free'  class=\"down_file\"><span>".$real_file_d[$i]."</span></a> ";
	}
}

if($file_print){
?>
	<?=$file_print?>
<?
}	

?>														
								</td>

							</tr>


							<tr>
								<td class="view_td" colspan="4">
<? if ($que['youtube_url']!="") { ?>
<div class="tc"> <iframe width="854" height="480" class="movie_frame" src="https://www.youtube.com/embed/<?=$que['youtube_url']?>" frameborder="0" allowfullscreen></iframe></div>
<? } ?>
<?

if ($que[text_type]=="2") {
	echo fnFilterString_return(stripslashes(nl2br($que[content])));
} else {
	echo fnFilterString_return(stripslashes($que[content]));
}	
?>	
								</td>
							</tr>

						</tbody>
					</table>
				</div>
				<div class="btn-tc p_none"> <a href="list.php?<?=$qs?>" class="btnStrong m_block "><span>목록</span></a> </div>

<?
		// 이전/다음 체크;
		$pre_q="select no,title from $DB_name where del_key='Y' and regdate < '$que[regdate]' and table_name='$table_name' order by regdate desc limit 1";
		$pre_e=mysql_query($pre_q) or die(mysql_error());
		$pre=mysql_fetch_array($pre_e);


		$nex_q="select no,title from $DB_name where del_key='Y' and regdate > '$que[regdate]' and table_name='$table_name' order by regdate asc limit 1";
		$nex_e=mysql_query($nex_q) or die(mysql_error());
		$nex=mysql_fetch_array($nex_e);

?>
                                    <div class="next_list">
                                        <dl class="next">
                                            <dt>이전글</dt>
                                            <dd>
												<? if($nex[no]) { ?>
											   <a href="<?=$PHP_SELF?>?admin_mode=read&no=<?=$nex[no]?>&<?=$qs?>"><?=$nex[title]?></a>
												<? } else { ?>
												등록된 글이 없습니다.
											   <? } ?>		  
											  </dd>
                                        </dl>
                                        <dl class="prev">
                                            <dt>다음글</dt>
                                            <dd>
											  <? if($pre[no]) { ?>
											   <a  href="<?=$PHP_SELF?>?admin_mode=read&no=<?=$pre[no]?>&<?=$qs?>"><?=$pre[title]?></a>
												<? } else { ?>
												등록된 글이 없습니다.
											   <? } ?>	
											  </dd>
                                        </dl>
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
