<?php
header('P3P: CP="ALL CURa ADMa DEVa TAIa OUR BUS IND PHY ONL UNI PUR FIN COM NAV INT DEM CNT STA POL HEA PRE LOC OTC"');
header ('Cache-Control: no-cache, must-revalidate'); 
header ('Pragma: no-cache');
header ('Content-type: text/html; charset=UTF-8');
session_start();
define("__CHIBI__",time());
if(is_file("data/config/db.config.php")==true){
	include_once 'data/config/db.config.php';
	include_once "lib/db.conn.php";
	if(is_resource(mysql_query("DESC chibi_admin", $chibi_conn)) && is_resource(mysql_query("DESC chibi_skin",$chibi_conn)) && is_resource(mysql_query("DESC chibi_pic",$chibi_conn)) && is_resource(mysql_query("DESC chibi_comment",$chibi_conn)) && is_resource(mysql_query("DESC chibi_tpl",$chibi_conn)) && is_resource(mysql_query("DESC chibi_member",$chibi_conn)) && is_resource(mysql_query("DESC chibi_emoticon",$chibi_conn)) && is_resource(mysql_query("DESC chibi_log",$chibi_conn)))
	{
		echo "
	<script language=\"javascript\">
	alert('CHIBIBBS が既にインストールされています。');
	</script>
	";
		exit;
	}
}
$_SESSION['rndkey'] = time();
$_SESSION['setup'] = $_SESSION['rndkey'].'adminsetup';
?>
<!DOCTYPE html>
<html lang="ko">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
<link href="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.1/css/bootstrap-combined.min.css" rel="stylesheet">
<script src="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.1/js/bootstrap.min.js"></script>
<title>Chibi Tool BBS 1.10 インストール</title>
<style>
body{background:#e8e8e8;font-size:12px;margin:20px;font-family:돋움,dotum;}
#license{width:500px;height:150px;font-size:12px;}
#setupDiv{width:550px;height:100%;margin:0 auto;}
.control-label, input{font-size:12px !important;}
.controls{text-align:left;}
</style>
</head>
<body>
<div align="center" id="setupDiv">
<form method="post" id="install" action="install.check.php" class="form-horizontal">
<div class="control-group">
<input type="hidden" name="mode" value="install">
<input type="hidden" name="type" value="install">
<textarea readonly id="license">
** お知らせ **
1. 本掲示板のライセンスはGPLv3であります。
2. スキンの制作者はスキン制作に対して何か不明な点がありましたら連絡ください。
   最大限にサポートします。
3. 掲示板及びChibiPAINTプログラムに対するエラーはGithub及び制作者個人ホームページにお願いします。
4. 本掲示板を利用するためにはJAVAが必要です。
   JAVAをインストールしてない方は 
   http://www.java.com/ko/download/ie_manual.jsp?locale=jp&host=www.java.com
   でダウンロードしてください。
</textarea>
<?php 
if(!is_writable('./data')){
?>
<p class="text-error">data フォルダの権限が <b>707</b> もしくは <b>777</b>ではありません。<br/>data フォルダの権限を確認してください。</p>
<? }else{ ?>
</div>

<div class="control-group">
	<label class="control-label" for="host">ホスト名</label>
	<div class="controls">
		<input type="text" id="host" name="host" placeholder="ホスト名" required value="localhost">
	</div>
</div>
<div class="control-group">
	<label class="control-label" for="dbname">DB名</label>
	<div class="controls">
		<input type="text" id="dbname" name="dbname" placeholder="DB名" required>
		<span class="help-block">DB名を入力してください。</span>
	</div>
</div>
<div class="control-group">
	<label class="control-label" for="dbuser">DB ID</label>
	<div class="controls">
		<input type="text" id="dbuser" name="dbuser" placeholder="DB ID" required>
		<span class="help-block">DB IDを入力してください。</span>
	</div>
</div>
<div class="control-group">
	<label class="control-label" for="dbpass">DB パスワード</label>
	<div class="controls">
		<input type="password" id="dbpass" name="dbpass" placeholder="DB パスワード" required>
		<span class="help-block">DB パスワードを入力してください。</span>
	</div>
</div>
<div class="control-group">
	<label class="control-label" for="admin_id">管理者 ID</label>
	<div class="controls">
		<input type="text" id="admin_id" name="admin_id" placeholder="管理者 ID" onblur="checkID()"  required>
		<span class="help-block">掲示板全体の権限をもつ管理者IDを入力してください。</span>
	</div>
</div>
<div class="control-group">
	<label class="control-label" for="admin_pass">管理者 パスワード</label>
	<div class="controls">
		<input type="password" id="admin_pass" name="admin_pass" placeholder="管理者 パスワード" onblur="checkPASSWD()" required>
	</div>
</div>
<div class="control-group">
	<label class="control-label" for="nickname">管理者 ニックネーム</label>
	<div class="controls">
		<input type="text" id="nickname" name="nickname" placeholder="管理者 ニックネーム" required>
	</div>
</div>
<div class="control-group">
	<button type="submin" class="btn btn-primary">インストール</button>
</div>
</form>
<script type="text/javascript">
function checkID(){
	var pattern = /^[a-z]+[a-z0-9]*$/; 
		 if($("#admin_id").val() == ""){
		  alert("管理者 IDを入力してください");
		  $("#admin_id").focus();
	 }else if(!pattern.test($("#admin_id").val())){
		 alert("管理者IDは英文もしくは英文（小文字）＋数字で入力してください。");
		 $("#admin_id").focus();
	 }
	}
function checkPASSWD(){
		 if($("#admin_pass").val() == ""){
		  alert("管理者パスワードを入力してください。");
		  $("#admin_pass").focus();
	 }
	}
</script>
</div>
</body>
</html>
<?php
}
?>