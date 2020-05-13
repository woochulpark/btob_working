
<!DOCTYPE html>
<html lang="ko">

<head>
    <title></title>
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">

    <meta charset="utf-8">
    <meta name="viewport" content="user-scalable=yes,initial-scale=1.0,maximum-scale=5.0,minimum-scale=1.0,width=device-width">

    <link rel="stylesheet" type="text/css" href="../css/base.css" />

	<style>
	
	.img_close {background:#000; position: relative; height:50px;}
    .img_close > a {display: block; width: 30px; height: 30px; position: absolute; right: 10px; top: 50%; transform: translateY(-50%); -webkit-transform: translateY(-50%)}
	img {max-width:100%; max-height:100%;}
	</style>
</head>

<body>
<p class="img_close"><a href="javascript:void(0);" onclick="history.go(-1);"><img src="../img/common/close.png" alt=""></a></p>

<div class="tc"><img src="<?=$type?>" border="0"></div>
</body>
</html>
