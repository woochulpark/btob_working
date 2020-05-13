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
 $resno = '5003031067017';
  if (!preg_match('/^[[:digit:]]{6}[1-4][[:digit:]]{6}$/', $resno)){
	echo "바보";

  } else {
	echo "멍청이";
  }
  ?>
 </body>
</html>
