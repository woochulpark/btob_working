<?php
	include "../include/common.php";
	if(!isset($_SESSION['s_mem_no']) && ($_SERVER['PHP_SELF'] != '/member/login.php' && $_SERVER['PHP_SELF'] != '/member/join.php' && $_SERVER['PHP_SELF'] != '/member/join02.php' && $_SERVER['PHP_SELF'] != '/member/complete.php' )  ) {
		include ("../include/login_check.php");	
	} 
	
	if(isset($_SESSION['s_mem_no']) && ($_SERVER['PHP_SELF'] == '/member/login.php' || $_SERVER['PHP_SELF'] == '/member/join.php' || $_SERVER['PHP_SELF'] == '/member/join02.php' || $_SERVER['PHP_SELF'] == '/member/complete.php')  ){
	?>
		<script>
	alert('로그인 중입니다. ');
	location.href="../main/main.php";
</script>
<?
	}

	$insuran_option = array('DB손해보험'=>'S_1', 'CHUBB'=>'S_2', 'MERITZ'=>'L_1','HANHWA'=>'L_2');

	if (!isset($_SERVER['HTTPS']) || $_SERVER['HTTPS']=="") {
		$redirect = "https://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
		header("Location: $redirect");
	}
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="ko" xml:lang="ko">
<head>

<title><?=$shop_name?></title>

<meta http-equiv="X-UA-Compatible" content="IE=Edge" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="title" content="ALV Generator" />
<meta name="description" content=""/>

<meta name="viewport" content="user-scalable=no,initial-scale=1.0,maximum-scale=1.0,minimum-scale=1.0,width=device-width">

<link rel="stylesheet" type="text/css" href="../css/basefont.css"/>
<link rel="stylesheet" type="text/css" href="../css/base.css"/>
<link rel="stylesheet" type="text/css" href="../css/import.css"/>
<link rel="stylesheet" type="text/css" href="../css/layout.css?ver=<?=date("Ymdhis",filemtime("../css/layout.css"))?>">
<link rel="stylesheet" type="text/css" href="../css/jquery-ui.css"/>
<?
	if($_SERVER['PHP_SELF'] != '/main/main.php'){
		if($_SERVER['PHP_SELF'] != '/member/join.php'){
?>
<link rel="stylesheet" type="text/css" href="../css/skin.css">
<?
		}
	if($_SERVER['PHP_SELF'] != '/member/join.php'){
?>
<link rel="stylesheet" type="text/css" href="../css/contents.css">
<?
	}
}

if($_SERVER['PHP_SELF'] == '/main/main.php'){
?>
<link rel="stylesheet" type="text/css" href="../css/main.css">
<?
}
?>
<script type="text/javascript" src="../js/jquery.min.js"></script>
<script type="text/javascript" src="../js/jquery-ui.custom.js"></script>
<script type="text/javascript" src="../js/jquery.bxslider.min.js"></script>
<script type="text/javascript" src="../js/layer_pop.js"></script>
<script type="text/javascript" src="../js/menu.js"></script>
<script type="text/javascript" src="../js/common.js"></script>
<script type="text/javascript" src="../js/trip.js"></script>
<script type="text/javascript" src="../js/design.js"></script>
<?
	if($_SERVER['PHP_SELF'] != '/main/main.php'){		
?>

<!--<script type="text/javascript" src="../js/common.js"></script>-->
<!--<script type="text/javascript" src="../js/placeholders.min.js"></script>-->
<?
}

	if($_SERVER['PHP_SELF'] == '/member/join.php'){	
?>
	<script type="text/javascript" src="../js/ez-mark.js"></script>
<?
	}
?>
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-173138907-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-173138907-1');
</script>
</head>
<body>
<ul id="skipToContent">
  <li><a href="#container">본문 바로가기</a></li>
  <li><a href="#gnbW">주메뉴 바로가기</a></li>
</ul>
<!-- loading -->
<div class="loading_area" id="loading_area" style="display:none">
    <div class="loader"></div>
    <div id="bg"></div>
</div>
<!-- //loading -->


