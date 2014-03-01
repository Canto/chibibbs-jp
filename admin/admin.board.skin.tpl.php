<?php
if(!defined("__CHIBI__")) exit();
$tpl=fopen("../data/".$cid."/tpl/".$cid.".tpl.php","r");
$tpl_file = '';
while (!feof($tpl)){
	$tpl_file = $tpl_file.fgets($tpl);
}
fclose($tpl);
$tpl_file = htmlspecialchars($tpl_file);

if(bbs_permission($member->permission,$cid)=="true"){
?>
<script>
$(document).ready(function(){
$('#reset').click(function(){
	$.ajax({
		   url: './admin.board.skin.tpl.load.php',
		   type: 'POST',
		   data: {'cid':'<?=$cid?>','skin':'<?=$skin?>'},
		   dataType: 'text',
		   success: function(data){
				$("#tpl").val(data);
				alert("スキンリセット完了!!");
				$("#tpl").focus();	   
		   }
	});
});
});
</script>
<textarea id="reset_tpl" style="display:none;"><?php echo $reset_tpl_file;?></textarea>
<form class="form-horizontal" method="post" action="admin.php?cAct=adminSkinTplOk">
<input name="skin" type="hidden" value="<?php echo $skin;?>">
<table id="board-create" class="table table-bordered">
<thead>
<tr>
<th colspan="2" class="span12">
<a href="admin.php?cAct=adminSkinSetup&skin=<?=$skin?>&cid=<?=$cid?>" class="btn offset4 span4">スキン設定</a>
</th>
</tr>
<tr>
<th colspan="2" class="span12">
スキンデザイン修正
</th>
</tr>
<thead>
<tbody>
<tr>
<td class="span3 td-left">
<p>掲示板 ID</p>
</td>
<td class="span9 td-right">
<input id="cid" class="input-xlarge" type="text" placeholder="掲示板 ID"  value="<?php echo $cid;?>" disabled >
<input name="cid" type="hidden" value="<?php echo $cid;?>">
</td>
</tr>
<tr>
<td colspan="2" class="span12 td-right">
<textarea id="tpl" name="tpl" rows="25" class="span12" style="resize:none;">
<?php echo $tpl_file;?>
</textarea>
</td>
</tr>
<tr>
<td colspan="2" class="td-left">
<p class="text-right">
  <button type="button" class="btn btn-warning" id="reset">初期化</button>
  <button type="submit" class="btn btn-success">設定保存</button>
  <a class="btn" href="admin.php?cAct=adminBoardList">キャンセル</a>
</p>
</td>
</tr>
</tbody>
</table>
</form>
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