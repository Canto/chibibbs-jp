<?php
header('P3P: CP="ALL CURa ADMa DEVa TAIa OUR BUS IND PHY ONL UNI PUR FIN COM NAV INT DEM CNT STA POL HEA PRE LOC OTC"');
header ('Content-type: text/html; charset=UTF-8');
session_start();
define("__CHIBI__",time());

include_once "data/config/db.config.php";
include_once "lib/db.conn.php";
include_once "lib/bbs.fn.php";

/* $_GET 변수 재설정 */
if(empty($_GET["user_id"])==false) $user_id = $_GET["user_id"];

$login_check = login_check($chibi_conn);

?>
<!DOCTYPE html>
<html lang="ko">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.1/css/bootstrap-combined.min.css" rel="stylesheet">
<script src="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.1/js/bootstrap.min.js"></script>
<title>Chibi Tool BBS ログアウト</title>
<style type="text/css">
body{margin:20px;background:#e8e8e8;}
td{background:#ffffff;}
</style>
</head>
<body>
<div class="container">
<div class="row-fluid">
<div class="span6 offset3">
<?php
	if(empty($user_id)==true){
?>
<div class="alert alert-error">
<a class="close" href="javascript:history.go(-1);">&times;</a>
正しい経路で接続してください。<br/><br/>
<a class="btn btn-danger" href="javascript:history.go(-1);">もどる</a>
</div>
<?php
}else{
	if(login_check($chibi_conn) == false){
?>
<div class="alert alert-error">
<a class="close" href="javascript:history.go(-1);">&times;</a>
ログイン状態ではありません。<br/>
先にログインしてください。<br/><br/>
<a class="btn btn-danger" href="javascript:history.go(-1);">もどる</a>
</div>
<?php
}else{
	if(logout($user_id,$chibi_conn)){
	echo "<script type=\"text/javascript\">
			alert(\"ログアウトしました。\");
			location.href = \"".$_SERVER['HTTP_REFERER']."\";
		</script>";
	}else{
	echo "<script type=\"text/javascript\">
			alert(\"ログアウトに失敗しました。\");
			location.href = \"".$_SERVER['HTTP_REFERER']."\";
		</script>";
	}
}
}
?>
</div>
</div>
</body>
</html>