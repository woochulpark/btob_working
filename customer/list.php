<? include ("../include/top.php"); ?>

<script>
	var oneDepth = 5; //1차 카테고리
</script>

<div id="wrap">
	<div id="inner_wrap">
		<!-- header -->
		<? include ("../include/header.php"); ?>
			<!-- //header -->
			<!-- container -->
			<div style="height:40px;"></div>
			<div id="container">
			
<?
$DB_name = 'free';
$table_name="board_1";

if (!$page) $page = 1;
$num_per_page = 10;
$num_per_page_start = $num_per_page*($page-1);
$page_per_block = 5;


if($search) {
	if($make == 'all') {
		$sql_add .=" and (title like '%$search%' or content like '%$search%' )";
	} else {
		$sql_add .=" and $make like '%$search%'";	
	}
}
$sql_add .=" and table_name='$table_name'";
$sql_add .=" order by notice asc, regdate desc";
$total_record = sql_cnt($DB_name,$sql_add);
$sql_add .=" limit $num_per_page_start, $num_per_page";
$out = sql_one($DB_name,'*',$sql_add);

$list_page=list_page($num_per_page,$page,$total_record);//function_query
$total_page	= $list_page['0'];
$first		= $list_page['1'];
$last		= $list_page['2'];
$article_num = $total_record - $num_per_page*($page-1);

$qs = "make=$make&search=$search&site=$site";

?>
				<div class="bbs_search">
					<div class="bbs_search_in">
<form method="get" action="<?=$PHP_SELF?>" name="form1">
<input type="hidden" name="site" value="<?=$site?>">
							<fieldset>
								<legend>게시물 검색</legend>
								<select name="make" class="select">
								  <option value="title" <? if ($make=="title") { ?>selected<? } ?>>제목</option>
								  <option value="content" <? if ($make=="content") { ?>selected<? } ?>>내용</option>
								  <option value="all" <? if ($make=="all") { ?>selected<? } ?>>제목+내용</option>
								</select>
								<input type="text" id="searchstr" style="width:320px;" value="<?=$search?>" title="검색어를 입력하세요." placeholder="검색어를 입력하세요." class="input" name="search">
								<input class="btn_search" type="button" value="검색" onclick="document.form1.submit();">
							</fieldset>
</form>
					</div>
				</div>

				<div class="table_line">
					<table class="board-list" cellspacing="0" cellpadding="0" summary="게시판 리스트">
						<caption>
							게시판 리스트
						</caption>
						<colgroup>
							<col class="w_cell" width="10%">
							<col width="%">
							<col class="w_cell" width="12%">
							<col class="w_date" width="15%">
							<col class="w_cell" width="12%">

						</colgroup>
						<thead>
							<tr>
								<th class="w_cell" scope="col">번호</th>
								<th scope="col">제목</th>
								<th class="w_cell" scope="col">작성자</th>
								<th scope="col">등록일</th>
								<th class="w_cell" scope="col">조회수</th>
							</tr>
						</thead>
						<tbody>
<?
if($total_record){
	$i = 0;
	while($row=$out[$i])
	{

		$title = stripslashes($row[title]);
		$reg=explode(" ",$row[regdate]);
?>
							<tr>
								<td class="w_cell"><? if ($row[notice]=="Y"){ ?><span class="ico">공지</span><? } else { ?><?=$article_num?><?	} ?></td>
								<td class="subject"><a href="view.php?admin_mode=read&no=<?=$row[no]?>&<?=$qs?>&page=<?=$page?>"><?=$title?></a></td>
								<td class="w_cell"><?=stripslashes($row['name'])?></td>
								<td><?=$reg[0]?></td>
								<td class="w_cell"><?=number_format($row['hit'])?></td>
							</tr>
<?
		$i++;
		$article_num--;
	}
}
?>
						</tbody>
					</table>
				</div>
<?

	$where .= "&site=$site";
	$where .= "&make=$make";
	$where .= "&search=$search";
	list_page_numbering_div($page_per_block,$page,$total_page,$where);
?>


		</div>	
			<!-- //container -->
	</div>
	<!-- //inner_wrap -->
<? include ("../include/footer.php"); ?>

</div>
<!-- //wrap -->

</body>

</html>
