<?php
if(!defined("__CHIBI__")) exit();
if(strstr($_SERVER['HTTP_REFERER'],$_SERVER['SERVER_NAME'])&&strstr($_SERVER['HTTP_REFERER'],'cAct=adminBoardList')){ /* 접속경로 체크 */
$connect_page=true;
$cid = $_GET['cid'];

if(empty($member->permission)==false){
$member_permission = "all";
$error='';
$sql_pic = "DELETE FROM `chibi_pic` WHERE `cid`='".mysql_real_escape_string($cid)."'";
$sql_cmt = "DELETE FROM `chibi_comment` WHERE `cid`='".mysql_real_escape_string($cid)."'";
mysql_query($sql_pic,$chibi_conn);
$error = mysql_error();
mysql_query($sql_cmt,$chibi_conn);
$error_cmt = mysql_error();
if(empty($error)==true||empty($error_cmt)==true){
rmfile("../data/".$cid);
}
}else{
$connect_page=false;
}
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
else if(empty($error)==false||empty($error_cmt)==false){
?>
<div class="alert alert-error">
<a class="close" href="javascript:history.go(-1);">&times;</a>
<?php echo $cid; ?> 掲示板リセットに失敗しました。<br/>詳細 : <?php echo $error;?><br/><?php echo $error_cmt;?><br/>
<a class="btn btn-danger" href="javascript:history.go(-1);">もどる</a>
</div>
<?php
}else if(empty($error)==true||empty($error_cmt)==true){
?>
<div class="alert alert-success">
<a class="close" href="javascript:history.go(-1);">&times;</a>
<?php echo $cid; ?> 掲示板をリセットしました。<br/><br/>
<a class="btn btn-success" href="admin.php?cAct=adminBoardList">完了</a>
</div>
<?php
}
?>
</div>