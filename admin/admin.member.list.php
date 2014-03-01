<?php
if(!defined("__CHIBI__")) exit();

$query = member_list("",$chibi_conn);

?>
<style type="text/css">
.td-center{text-align:center !important;}
tbody tr{background:#ffffff;}
thead tr{background:#d9edf7}
#memberdelDiv{display:none;position:fixed;z-index:1000;top:30%;}
.td-btn a{margin:1px 2px 1px 2px;}
</style>
<table class="table table-bordered table-hover list">
	<thead>
	<tr>
	<th colspan="7">
	総会員数 : <?php echo count_bbs("member","",$chibi_conn);?>
	</th>
<!--	<th class="td-center">
	<a class="btn btn-small btn-info" href="admin.php?act=adminMemberAdd">멤버 추가</a>
	</th>-->
	</tr>
		<tr>
			<th>会員 ID</th>
			<th>ニックネーム</th>
			<th class="td-center">ポイント</th>
			<th class="td-center">作成した絵の数</th>
			<th class="td-center">作成したコメントの数</th>
			<th class="td-center">最終ログイン時刻</th>
			<th class="span3 td-center">設定</th>
		</tr>
	</thead>
	<tbody>
	<?php
	while($member_list = mysql_fetch_array($query)){
		$member_list = (object) $member_list;
	?>
		<tr>
			<td><?php echo $member_list->user_id?></a></td>
			<td><?php echo $member_list->nickname?></td>
			<td class="td-center"><?php echo $member_list->point?></td>
			<td class="td-center"><?php echo $member_list->pic?></td>
			<td class="td-center"><?php echo $member_list->comment?></td>
			<td class="td-center"><?php if($device=="pc"){echo date("Y/m/d H:i:s",$member_list->lastlogin);}else{echo date("m/d H:s ",$member_list->lastlogin);}?></td>
			<td class="td-btn td-center">
			<?php 
			if($device=="pc"){
			?>
			<a class="btn btn-small btn-info" href="admin.php?cAct=adminMemberSetup&user_id=<?php echo $member_list->user_id;?>">会員情報修正</a>
			<a class="btn btn-small btn-danger memberdel" user_id="<?php echo $member_list->user_id;?>" link="admin.php?cAct=adminMemberDelete&user_id=<?php echo $member_list->user_id;?>">会員削除</a>
			<?php
			}else{
			?>
			<select class="span5 memberdel">
			<option value="#">設定</option>
			<option value="admin.php?cAct=adminMemberSetup&user_id=<?php echo $member_list->user_id;?>">会員情報修正</a>
			<option value="admin.php?cAct=adminMemberDelete&user_id=<?php echo $member_list->user_id;?>" >会員削除</a>
			</select>
			<?php
			}
			?>
			</td>
		<tr>
	<?php
	}
	?>
	</tbody>
</table>
<p class="text-right"><a class="btn btn-small btn-info" href="admin.php?cAct=adminMemberAdd">会員追加</a></p>
<script type="text/javascript">
$(function(){
<?php 
	if($device=="pc"){
?>
	$(".memberdel").click(function(){
		var link = $(this).attr("link");
		var memberid = $(this).attr("user_id");
		$("#memberbtndelete").attr("href",link);
		$("#userid").html(memberid);
		$("#memberdelDiv").fadeIn("fast");
	});
	$("#btncancel").click(function(){
		$("#memberdelDiv").fadeOut("fast");
	});
<?php
	}else{
?>
	$(".memberdel").change(function(){
		var link = $(this).val();
		if(link.indexOf("admin.php?cAct=adminMemberDelete")!=-1){
		var answer = confirm("会員を削除しますか？");
		if(answer){
			location.href = link;
		}else{
			$("option[value=\"#\"]").attr("selected","selected");
			return false;
		}
		}else{
		location.href = link;
		}
});
<?php
}
?>
});

</script>
<div id="memberdelDiv" class="container">
<div class="alert alert-error span6 offset3">
 <p><b>会員削除</b></p>
 <p><span id="userid"></span>会員を削除しますか？</p>
 <p><a id="memberbtndelete" href="#" class="btn btn-danger">削除</a> <a id="btncancel" class="btn">キャンセル</a>
</div>
</div>