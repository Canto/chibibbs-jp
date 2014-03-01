<?php
if(!defined("__CHIBI__")) exit();

$query = select($cid,$chibi_conn);
$bbs = (object) mysql_fetch_array($query);
$bbs->spam = (object) unserialize($bbs->spam);
$bbs->notice = (object) unserialize($bbs->notice);
$bbs->op = (object) unserialize($bbs->op);

if(bbs_permission($member->permission,$bbs->cid)=="true"){

function cnt($sql,$chibi_conn){
$query = mysql_query($sql,$chibi_conn);
$row = mysql_fetch_row($query);
return $row[0];
}

$y = date('Y');
$m = date('m');
$d = date('d');
$total = "SELECT count(*) FROM `chibi_log` where `cid`='".mysql_real_escape_string($cid)."' AND date LIKE '".mysql_real_escape_string($y)."%'";
$total = cnt($total,$chibi_conn);
$total_m = "SELECT count(*) FROM `chibi_log` where `cid`='".mysql_real_escape_string($cid)."' AND date LIKE '".mysql_real_escape_string($y).mysql_real_escape_string($m)."%'";
$total_m = cnt($total_m,$chibi_conn);
$total_w = "SELECT count(*) FROM `chibi_log` where `cid`='".mysql_real_escape_string($cid)."' AND date LIKE '".mysql_real_escape_string($y).mysql_real_escape_string($m)."__'";
$total_w = cnt($total_w,$chibi_conn);
?>
<?php
$m_device_sql = "SELECT * FROM `chibi_log` where `cid`='".mysql_real_escape_string($cid)."' AND date LIKE '".mysql_real_escape_string($y).mysql_real_escape_string($m)."%'";
$m_device_query = mysql_query($m_device_sql,$chibi_conn);
while($m_device_array = mysql_fetch_array($m_device_query)){
	$m_device = unserialize($m_device_array['op']);
	$c_device[] = $m_device['device'];
	$browser[] = $m_device['browser'];
}
$k_device = @array_count_values($c_device);
$k_browser = @array_count_values($browser);

?>
<div class="well span10 offset1">
<ul class="inline" style="text-align:center">
<li><a href="./admin.php?cAct=adminBoardStatistics&cid=<?=$cid?>&statistics=month">月間訪問統計</a></li>
<li><a href="./admin.php?cAct=adminBoardStatistics&cid=<?=$cid?>&statistics=day">日間訪問統計</a></li>
<li><a href="./admin.php?cAct=adminBoardStatistics&cid=<?=$cid?>&statistics=dayoftheweek">曜日別訪問統計</a></li>
<li><a href="./admin.php?cAct=adminBoardStatistics&cid=<?=$cid?>&statistics=time">時間帯別訪問統計</a></li>
<li><a href="./admin.php?cAct=adminBoardStatistics&cid=<?=$cid?>&statistics=connectos">接続環境</a></li>
<li><a href="./admin.php?cAct=adminBoardStatistics&cid=<?=$cid?>&statistics=connectbrowser">接続ブラウザ</a></li>
</ul>
</div>
<table id="board-create" class="table table-bordered" style="margin:auto;width:90%;">
<thead>
<tr>
<th style="font-size:18px;">
<b><?=$cid?> 掲示板 : 総計</b>
</th>
</tr>
</thead>
<tbody>
<?php if($statistics=="month"){ ?>
<tr >
<td class="td-left ">
<p><b>月間訪問数 : <?=$y?>年 総 <?=$total?>人訪問</b></p>
</td>
</tr>
<tr >
<td>
<?php
for($i=1;$i<13;$i++){
$m_i = sprintf('%02d',$i);
$month = "SELECT count(*) FROM `chibi_log` where `cid`='".mysql_real_escape_string($cid)."' AND date LIKE '".mysql_real_escape_string($y).mysql_real_escape_string($m_i)."%'";
$month = cnt($month,$chibi_conn);
@$month_g = round($month/$total*100,0);
?>
<?=$i?> 月 : <?php if($month) echo $month."人 訪問(".$month_g."%)";?>
<div class="progress progress-info inline">
<div class="bar" style="width:<?=$month_g?>%"></div>
</div>
<?php
}
?>
</td>
</tr>
<?php }else if($statistics=="day"){ ?>
<tr>
<td class="td-left">
<p><b>日別訪問数 : <?=date('n')?>月 総 <?=$total_m?> 人訪問</b></p>
</td>
</tr>
<tr>
<td>
<?php
for($i=1;$i<date('t')+1;$i++){
$d_i = sprintf('%02d',$i);
$day = "SELECT count(*) FROM `chibi_log` where `cid`='".mysql_real_escape_string($cid)."' AND date LIKE '".mysql_real_escape_string($y).mysql_real_escape_string($m).mysql_real_escape_string($d_i)."%'";
$day = cnt($day,$chibi_conn);
@$day_g = round($day/$total_m*100,0);
?>
<?=$i?> 일 : <?php if($day) echo $day."명 방문(".$day_g."%)";?>
<div class="progress progress-info">
<div class="bar" style="width:<?=$day_g?>%"></div>
</div>

<?php
}
?>
</td>
</tr>
<?php }else if($statistics=="dayoftheweek"){ ?>
<tr>
<td class="td-left">
<p><b>曜日別訪問数 : <?=date('n')?>月　総 <?=$total_m?> 人訪問</b></p>
</td>
</tr>
<tr >
<td>
<?php
for($i=1;$i<8;$i++){
switch($i){
	case 1 : 
		$dw = "Mon";
		break;
	case 2 :
		$dw = "Tue";
		break;
	case 3 :
		$dw = "Wed";
		break;
	case 4 :
		$dw = "Thu";
		break;
	case 5 :
		$dw = "Fri";
		break;
	case 6 :
		$dw = "Sat";
		break;
	default :
		$dw = "Sun";
		break;
}

$w_day = "SELECT count(*) FROM `chibi_log` where `cid`='".mysql_real_escape_string($cid)."' AND date LIKE '".mysql_real_escape_string($y).mysql_real_escape_string($m)."%".mysql_real_escape_string($dw)."'";
$w_day = cnt($w_day,$chibi_conn);
@$w_day_g = round($w_day/$total*100,0);
?>
<?=$dw?>: <?php if($w_day) echo $w_day."人 訪問(".$w_day_g."%)";?>
<div class="progress progress-info">
<div class="bar" style="width:<?=$w_day_g?>%"></div>
</div>

<?php
}
?>
</td>
</tr>
<?php }else if($statistics=="time"){ ?>
<tr>
<td class="td-left">
<p><b>時間帯別訪問数 : <?=date('n')?>月　総 <?=$total_m?> 人訪問</b></p>
</td>
</tr>
<tr>
<td>
<?php
for($i=0;$i<24;$i++){
$t_i = sprintf('%02d',$i);
$time = "SELECT count(*) FROM `chibi_log` where `cid`='".mysql_real_escape_string($cid)."' AND date LIKE '".mysql_real_escape_string($y).mysql_real_escape_string($m)."__".mysql_real_escape_string($t_i)."%'";
$time = cnt($time,$chibi_conn);
@$time_g = round($time/$total_m*100,0);
?>
<?=$i?> 時 : <?php if($time) echo $time."人訪問(".$time_g."%)";?>
<div class="progress progress-info">
<div class="bar" style="width:<?=$time_g?>%"></div>
</div>

<?php
}
?>
</td>
</tr>


<?php }else if($statistics=="connectos"){ ?>
<tr>
<td class="td-left">
<p><b>接続環境 : <?=date('n')?>月　総 <?=$total_m?> 人訪問</b></p>
</td>
</tr>
<tr>
<td>
<?php
@arsort($k_device);
if(count($k_device)<10)$max = count($k_device);
else $max = 10;
for($i=0;$i<$max;$i++){
@$device_g = round($k_device[key($k_device)]/$total_m*100,0);
$device_sum = $device_sum + $k_browser[key($k_browser)];
if($i==9){
?>
その他 : <?=$total_m-$device_sum?>人訪問(<?=round(($total_m-$device_sum)/$total_m*100,0)?>%)
<div class="progress progress-info">
<div class="bar" style="width:<?=round(($total_m-$device_sum)/$total_m*100,0)?>%"></div>
</div>
<?php
}else{
?>
<?=key($k_device)?> : <?=$k_device[key($k_device)]?>人訪問(<?=$device_g?>%)
<div class="progress progress-info">
<div class="bar" style="width:<?=$device_g?>%"></div>
</div>
<?php
}
next($k_device);
}
?>
</td>
</tr>
<?php }else if($statistics=="connectbrowser"){ ?>
<tr>
<td class="td-left">
<p><b>接続ブラウザ : <?=date('n')?>月　総 <?=$total_m?> 人訪問</b></p>
</td>
</tr>
<tr>
<td>
<?php
@arsort($k_browser);
if(count($k_browser)<10)$max = count($k_browser);
else $max = 10;
for($i=0;$i<$max;$i++){
@$browser_g = round($k_browser[key($k_browser)]/$total_m*100,0);
$browser_sum = $browser_sum + $k_browser[key($k_browser)];
//print_r($k_device_sort);
if($i==9){
?>
その他 : <?=$total_m-$browser_sum?>人訪問(<?=round(($total_m-$browser_sum)/$total_m*100,0)?>%)
<div class="progress progress-info">
<div class="bar" style="width:<?=round(($total_m-$browser_sum)/$total_m*100,0)?>%"></div>
</div>
<?php
}else{
?>
<?=key($k_browser)?> : <?=$k_browser[key($k_browser)]?>人訪問(<?=$browser_g?>%)
<div class="progress progress-info">
<div class="bar" style="width:<?=$browser_g?>%"></div>
</div>
<?php
}
next($k_browser);
}
?>
</td>
</tr>
<?php }else{ 
$day = "SELECT count(*) FROM `chibi_log` where `cid`='".mysql_real_escape_string($cid)."' AND date LIKE '".mysql_real_escape_string($y).mysql_real_escape_string($m).mysql_real_escape_string(date('d'))."%'";
$day = cnt($day,$chibi_conn);
?>
<tr>
<td class="td-left">
<p><b><?=date('n')?>月　総 <?=$total_m?> 人訪問</b></p>
<p><b><?=date('d')?>日　総 <?=$day?> 人訪問</b></p>
</td>
</tr>
<?php } ?>
</tbody>
</table>
<br/>
<?php
}else{
?>

<div class="span6 offset3 alert alert-error margin20">
<a class="close" href="javascript:history.go(-1);">&times;</a>
接続権限がありません。<br/>
掲示板管理者のみ接続可能なページです。<br/><br/>
<a class="btn btn-danger" href="javascript:history.go(-1);">もどる</a>
</div>
<?php
}
?>