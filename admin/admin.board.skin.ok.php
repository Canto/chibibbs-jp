<?php
if(!defined("__CHIBI__")) exti();
if(strstr($_SERVER['HTTP_REFERER'],$_SERVER['SERVER_NAME'])&&strstr($_SERVER['HTTP_REFERER'],'cAct=adminSkinSetup')){ /* 접속경로 체크 */
$connect_page=true;
/* $_POST 변수 재 설정 */
foreach($_POST as $key => $value){ //register_globals = off 환경을 위해 POST변수 재설정
if(get_magic_quotes_gpc()) ${$key} = stripslashes($value);
else ${$key} = $value;
}
$op = $_POST['op'];
if(get_magic_quotes_gpc()) $op = array_map('stripslashes', $op);

$error='';

/* 입력 값 설정 */

include_once "../skin/".$skin."/skin.sql.php";

mysql_query($update_db,$chibi_conn);
$error = mysql_error();

}else{
	$connect_page = false;
}
?>
<div class="span8 offset2">
<?php
if($connect_page == false){
?>
<div class="alert alert-error">
<a class="close" href="javascript:history.go(-1);">&times;</a>
正しい経路で接続してください。<br/><br/>
<a class="btn btn-danger" href="javascript:history.go(-1);">もどる</a>
</div>
<?php
}
else if(empty($error)==false){
?>
<div class="alert alert-error">
<a class="close" href="javascript:history.go(-1);">&times;</a>
掲示板設定の保存に失敗しました。<br/>詳細 : <?php echo $error;?><br/><br/>
<a class="btn btn-danger" href="javascript:history.go(-1);">もどる</a>
</div>
<?php
}else if(empty($error)==true){
?>
<div class="alert alert-success">
<a class="close" href="javascript:history.go(-1);">&times;</a>
<?php echo $cid; ?> 掲示板設定を保存しました。<br/><br/>
<a class="btn btn-success" href="admin.php?cAct=adminSkinSetup&cid=<?php echo $cid; ?>&skin=<?php echo $skin; ?>">完了</a>
</div>
<?php
}
?>
</div>
