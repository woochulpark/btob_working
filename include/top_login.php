<?php
	include "../include/common.php";
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

<script type="text/javascript" src="../js/jquery.min.js"></script>
<script type="text/javascript" src="../js/jquery-ui.custom.js"></script>
<script type="text/javascript" src="../js/design.js"></script>
<script type="text/javascript" src="../js/common.js"></script>
<script type="text/javascript" src="../js/placeholders.min.js"></script> 
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


