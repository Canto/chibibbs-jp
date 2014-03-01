<?php
header ('Content-type: text/html; charset=UTF-8');
define("__CHIBI__",time());
session_start();
/* register_globals = off 환경 변수 재설정 */
foreach($_POST as $key => $value){ 
global ${$key};
if(!get_magic_quotes_gpc()) ${$key} = addslashes($value); /* magic_quotes_gpc가 off일경우 slashes설정 */
else ${$key} = $value;
}

/* DB설정파일 변수설정 */
$HOSTNAME = $host;
$USERNAME = $dbuser;
$DBPASSWD = $dbpass;
$DBNAME = $dbname;
$S_ADMIN_ID = $admin_id;
$S_ADMIN_PASSWD = $admin_pass;

require_once "lib/db.conn.php";

if(is_resource($chibi_conn)) $db_check = true;
else $db_check = false;
$php = phpversion();
if(version_compare($php,'5.0','>'))$php_check = true;
else $php_check = false;
$mysql = mysql_get_server_info($chibi_conn);
if(version_compare($mysql,'5.0','>')) $mysql_check = true;
else $mysql_check = false;
$query = mysql_query("SHOW CHARACTER SET WHERE `Charset`='utf8';",$chibi_conn);
$array = mysql_fetch_array($query);
$encoding = $array['Default collation'];
if($encoding == 'utf8_general_ci') $encoding_check = true;
else $encoding_check = false;
?>
<!DOCTYPE html>
<html lang="ko">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.1/css/bootstrap-combined.min.css" rel="stylesheet">
<script src="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.1/js/bootstrap.min.js"></script>
<title>Chibi Tool BBS インストール</title>
<style type="text/css">
body{margin:20px;background:#e8e8e8;}
#installed {width:70%;margin:0 auto;padding:20px;}
#installed > a.close {right:0 !important;}
th {background:#d9edf7;}
tbody {background:#ffffff;}
</style>
</head>
<body>
<?php
if($db_check == false){/* DB 정보가 틀렸을 경우 */
?>
<div id="installed" class="alert alert-error">
<a class="close" href="javascript:history.go(-1);">&times;</a>
DB 情報が違います。もう一度確認してください。<br/><br/>
<a class="btn btn-danger" href="javascript:history.go(-1);">もどる</a>
</div>
<script type="text/javascript">
$('#installed').bind('closed', function () {
  history.go(-1);
})
</script>
<?php
}else{
?>
<div class="container">
<div id="row">
<table class="table table-bordered container" style="width:70%">
	<caption>Chibi BBS インストール可否チェック</caption>
	<thead>
	<tr>
	<th class="info"></th>
	<th class="info">サーバー情報</th>
	<th class="info">インストール最小仕様(おすすめ仕様)</th>
	<th class="info">インストール可否チェック</th>
	</tr>
	</thead>
	<tbody>
	<tr>
	<td>PHP バージョン</td>
	<td><p class="text-info"><?=$php?></p></td>
	<td><p class="text-info">5.0 ( 5.1.3 以上 )</p></td>
	<td><?php if($php_check==true){ echo "<p class=\"text-success\">インストール可能</p>";}else{ echo "<p class=\"text-error\">インストール不可</p>";}?></td>
	</tr>
	<tr>
	<td>Mysql バージョン</td>
	<td><p class="text-info"><?=$mysql?></p></td>
	<td><p class="text-info">5.0</p></td>
	<td><?php if($mysql_check==true){ echo "<p class=\"text-success\">インストール可能</p>";}else{ echo "<p class=\"text-error\">インストール不可</p>";}?></td>
	</tr>
	<tr>
	<td>Mysql エンコーディング(UTF-8)チェック</td>
	<td colspan="3"><?php if($encoding_check==true){ echo "<p class=\"text-success\">UTF-8使用可能</p>";}else{ echo "<p class=\"text-error\">UTF-8使用不可</p>";}?></td>
	</tr>
	<tr>
			<td colspan="4">
			<form method="post" id="install" action="install.ok.php" class="form-horizontal">
			<input type="hidden" name="mode" value="install">
			<input type="hidden" name="type" value="install">
			<input type="hidden" name="host" value="<?=$host?>">
			<input type="hidden" name="dbuser" value="<?=$dbuser?>">
			<input type="hidden" name="dbpass" value="<?=$dbpass?>">
			<input type="hidden" name="dbname" value="<?=$dbname?>">
			<input type="hidden" name="admin_id" value="<?=$admin_id?>">
			<input type="hidden" name="admin_pass" value="<?=$admin_pass?>">
			<input type="hidden" name="nickname" value="<?=$nickname?>">
			<div class="control-group">
			<?php if(($php_check && $mysql_check && $encoding_check) == true){
			?>
			<button type="submin" class="btn btn-primary">次のステップ</button>
			<?
			}else{
			?>
			<a class=\"btn btn-primary\" href=\"install.setup.php\">もどる</a><span class=\"help-block\">エラー項目があります。エラー項目を確認してください。</span>
			<?php
			}
			?>
			</div>
			</form>
			</td>
	</tbody>
</table>
</div>
</div>

<?php
}
/*
설치 체크 종료
*/
?>

</body>
</html>