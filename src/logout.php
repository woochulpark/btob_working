<?
session_start("s_mem_id");
/*
unset($_SESSION['s_mem_id']);
unset($_SESSION['s_mem_no']);
unset($_SESSION['s_mem_type1']);
unset($_SESSION['s_mem_type2']);
unset($_SESSION['s_mem_type3']);
*/
//unset($_SESSION);
session_destroy();
echo "<script>location.href='../member/login.php';</script>";

?>