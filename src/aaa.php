<!doctype html>
<html lang="en">
 <head>
  <meta charset="UTF-8">
  <meta name="Generator" content="EditPlus®">
  <meta name="Author" content="">
  <meta name="Keywords" content="">
  <meta name="Description" content="">
  <title>Document</title>
 </head>
 <body>
  <?
  		print_r($_POST);

		foreach($_POST['juminno'] as $k=>$v){
			foreach($_POST['juminno'] as $m=>$n){
				if($v === $n && $k != $m){
					echo $k.":".$v." 동일한 주민번호가 있습니다 ".$n.":".$m;
				}
			}
		}
  ?>
 </body>
</html>
