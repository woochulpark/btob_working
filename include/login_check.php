<?php
if($_SESSION['s_mem_id']=="") {
?>
<script>
	alert('로그인 후 이용해 주세요.');
	location.href="../member/login.php";
</script>
<?php
	exit;
}

$sql_mem_info="select * from toursafe_members where uid='".$_SESSION['s_mem_id']."'";
$result_mem_info=mysql_query($sql_mem_info);
$row_mem_info=mysql_fetch_array($result_mem_info);

if ($row_mem_info['no']=="") {
?>
<script>
	alert('회원 정보가 없습니다.');
	location.href="../src/logout.php";
</script>
<?
	exit;
}


if ($row_mem_info['mem_state']=="1") {
?>
<script>
	alert('관리자 승인 대기중 입니다.');
	location.href="../src/logout.php";
</script>
<?
	exit;
}

?>