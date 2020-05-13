<?php
session_start();

header("Content-Type:text/html; charset=UTF-8");
extract($_POST);
extract($_GET);
extract($_SERVER);
extract($_FILES);
extract($_ENV);
extract($_COOKIE);
extract($_SESSION);

ini_set("display_errors","0");
//$mem_type="2";

$root_dir=str_replace("/btob","",$_SERVER['DOCUMENT_ROOT']);

include $root_dir."/include/dbconn.php";
include $root_dir."/include/option_config.php";
include $root_dir."/lib/function.php";
include $root_dir."/lib/function_xss.php";
include $root_dir."/lib/function_thumbnail.php";
$chk_config['chk_code'] = 'outExcutechk';

if (!isset($_SERVER['HTTPS']) || $_SERVER['HTTPS']=="") {
	$redirect = "https://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
	header("Location: $redirect");
}
?>