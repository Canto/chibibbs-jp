<?php
if(!defined("__CHIBI__")) exti();
if(strstr($_SERVER['HTTP_REFERER'],$_SERVER['SERVER_NAME'])&&strstr($_SERVER['HTTP_REFERER'],'cAct=adminBoardCreate')){ /* 접속경로 체크 */
$connect_page=true;
/* $_POST 변수 재 설정 */
foreach($_POST as $key => $value){ //register_globals = off 환경을 위해 POST변수 재설정
if(get_magic_quotes_gpc()) ${$key} = stripslashes($value);
else ${$key} = $value;
}
$error='';
$error_tpl='';
if($_POST['inst']) $arry_inst = implode($_POST['inst'],",");
else $arry_inst = '';
if($_POST['position']) $arry_position = implode($_POST['position'],",");
else $arry_position = '';
if($_POST['inst2']) $arry_inst2 = implode($_POST['inst2'],",");
else $arry_inst2 = '';
if($_POST['position2']) $arry_position2 = implode($_POST['position2'],",");
else $arry_position2 = '';
/* 입력 값 설정 */
$option = array( /* 옵션 입력 값 */
	'secret'=>$secret,
	'use_permission'=>$use_permission,
	'btool'=>$btool,
	'pic_page'=>$pic_page,
	'pic_page_bar'=>$pic_page_bar,
	'pic_max_width'=>$pic_max_width,
	'pic_max_height'=>$pic_max_height,
	'pic_min_width'=>$pic_min_width,
	'pic_min_height'=>$pic_min_height,
	'pic_d_width'=>$pic_d_width,
	'pic_d_height'=>$pic_d_height,
	'pic_thumbnail_width'=>$pic_thumbnail_width,
	'inst'=>$arry_inst,
	'position'=>$arry_position,
	'inst2'=>$arry_inst2,
	'position2'=>$arry_position2,
	'showip'=>$showip,
	'pic_point'=>$pic_point,
	'comment_point'=>$comment_point,
	'include_head'=>$include_head,
	'include_foot'=>$include_foot
	);
$option = serialize($option); /* 배열의 직렬화 */

$notice = array( /* 공지사항 입력 값 */
	'head'=>$head,
	'foot'=>$foot
	);
$notice = serialize($notice); /* 배열의 직렬화 */

$spam = array( /* 스팸 입력 값 */
	'op'=>$op,
	'ip'=>$ip,
	'word'=>$word
	);
$spam = serialize($spam); /* 배열의 직렬화 */

$sql = "INSERT INTO `chibi_admin` (
`cid`, `skin`, `passwd`, `permission`, `title`, `notice`, `tag`, `spam`, `op`) VALUES ('".mysql_real_escape_string($cid)."', '".mysql_real_escape_string($skin)."', '".mysql_real_escape_string(md5($passwd))."', '', '".mysql_real_escape_string($title)."', '".mysql_real_escape_string($notice)."', '".mysql_real_escape_string($tag)."', '".mysql_real_escape_string($spam)."', '".mysql_real_escape_string($option)."');";

/*
ob_start();
include_once "skin/".$skin."/layout.php";
$tpl = ob_get_contents();
ob_end_clean();
$tpl_insert_string = "INSERT INTO `chibi_tpl` (`cid`, `skin`, `tpl`, `css` ) VALUES ('".mysql_real_escape_string($cid)."', '".mysql_real_escape_string($skin)."', '".mysql_real_escape_string($tpl)."','');";
*/

if(is_writable("../data/")){
if(is_dir("../data/".$cid)==false){
	$data_permission = true;
		umask(0);
		mkdir("../data/".$cid,0755);
		mkdir("../data/".$cid."/emoticon",0755);
		if(is_dir("../data/".$cid)==true && is_dir("../data/".$cid."/emoticon")==true) $mkdir = true;
		else $mkdir = false;
		mkdir("../data/".$cid."/tpl",0755);
		
/* 템플릿 초기 설정 */
$tpl = fopen("../skin/".$skin."/layout.php", "r");
$tpl_file = '';
while (!feof($tpl)){
$tpl_file = $tpl_file.fgets($tpl);
}
$fp=fopen("../data/".$cid."/tpl/".$cid.".tpl.php","w");
fwrite($fp,$tpl_file);
fclose($fp);
fclose($tpl);
chmod("../data/".$cid."/tpl/".$cid.".tpl.php",0644);

if(file_exists("../skin/".$skin."/user.fn.php")){
	require_once '../skin/'.$skin.'/user.fn.php';
	if(function_exists('user_convert')){
		$content = user_convert($tpl_file);
	}else{
		$content = conveert($tpl_file);
	}
}else{
	$content = convert($tpl_file);
}

$fp=fopen("../data/".$cid."/tpl/".$cid.".tpl.compiled.php","w");
fwrite($fp,$content);
fclose($fp);
chmod("../data/".$cid."/tpl/".$cid.".tpl.compiled.php",0644);

}
}else{
	$data_permission = false;
}

if($mkdir==true){
/* 스킨 초기 설정 로드 */
	include_once "../skin/".$skin."/skin.sql.php";
	mysql_query($skin_insert_string,$chibi_conn);
	mysql_query($sql,$chibi_conn);
	$error = mysql_error();
/*	mysql_query($tpl_insert_string,$chibi_conn);
	$error_tpl = mysql_error();
	*/
}
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
else if($data_permission == false){
?>
<div class="alert alert-error">
<a class="close" href="javascript:history.go(-1);">&times;</a>
data フォルダの権限が 755 もしくは 707 ではありません。<br/>権限を変更してください。<br/><br/>
<a class="btn btn-danger" href="javascript:history.go(-1);">もどる</a>
</div>
<?php
}
else if(empty($error)==false){
?>
<div class="alert alert-error">
<a class="close" href="javascript:history.go(-1);">&times;</a>
掲示板作成に失敗しました。<br/>エラー内容 : <?php echo $error;?><br/><?php echo $error_tpl;?><br/>
<a class="btn btn-danger" href="javascript:history.go(-1);">もどる</a>
</div>
<?php
}else if(empty($error)==true && $mkdir==true){
?>
<div class="alert alert-success">
<a class="close" href="javascript:history.go(-1);">&times;</a>
<?php echo $cid; ?> 掲示板を作成しました。<br/><br/>
<a class="btn btn-success" href="admin.php?cAct=adminBoardCreate">完了</a>
</div>
<?php
}
?>
</div>
