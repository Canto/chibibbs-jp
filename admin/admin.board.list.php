<?php
if(!defined("__CHIBI__")) exit();

$query = select('',$chibi_conn);

?>
<style type="text/css">
.td-center{text-align:center !important;}
tbody tr{background:#ffffff;}
thead tr{background:#d9edf7}
.td-btn a{margin:1px 2px 1px 2px;}
#boarddelDiv{display:none;position:fixed;z-index:1000;top:30%;}
#boardresetDiv{display:none;position:fixed;z-index:1000;top:30%;}
</style>
<table class="table table-bordered table-hover list">
	<thead>
		<tr>
			<th>掲示板ID</th>
			<?php if($device!="mobile"){?>
			<th>使用中のスキン</th>
			<?php }?>
			<th class="td-center">総訪問者</th>
			<th class="td-center">今日の訪問者</th>
			<th class="td-center">絵の数</th>
			<th class="td-center">コメントの数</th>
			<th class="span6 td-center">設定</th>
		</tr>
	</thead>
	<tbody>
	<?php
	while($bbs = mysql_fetch_array($query)){
		$bbs = (object) $bbs;
		if(bbs_permission($member->permission,$bbs->cid)=="true"){
	?>
		<tr>
			<td><a href="../index.php?cid=<?php echo $bbs->cid;?>" target="_blank"><?php echo $bbs->cid;?></a></td>
			<?php if($device!="mobile"){?><td><?php echo $bbs->skin;?></td><?php }?>
			<td class="td-center"><?php echo count_bbs("log","cid='".mysql_real_escape_string($bbs->cid)."'",$chibi_conn);?></td>
			<td class="td-center"><?php echo count_bbs("log","date LIKE '".mysql_real_escape_string($today)."%' AND cid='".mysql_real_escape_string($bbs->cid)."'",$chibi_conn);?></td>
			<td class="td-center"><?php echo count_bbs("pic","cid='".mysql_real_escape_string($bbs->cid)."'",$chibi_conn);?></td>
			<td class="td-center"><?php echo count_bbs("comment","cid='".mysql_real_escape_string($bbs->cid)."'",$chibi_conn);?></td>
			<td class="td-btn td-center">
			<?php 
			if($device=="pc"){
			?>
			<a class="btn btn-mini btn-info" href="admin.php?cAct=adminBoardSetup&cid=<?php echo $bbs->cid;?>">掲示板設定</a>
			<a class="btn btn-mini btn-info" href="admin.php?cAct=adminSkinSetup&cid=<?php echo $bbs->cid;?>&skin=<?php echo $bbs->skin;?>">スキン設定</a>
			<a class="btn btn-mini btn-info" href="admin.php?cAct=adminEmoticonSetup&cid=<?php echo $bbs->cid;?>">絵文字設定</a>
			<a class="btn btn-mini btn-warning boardreset" cid="<?php echo $bbs->cid;?>" link="admin.php?cAct=adminBoardReset&cid=<?php echo $bbs->cid;?>">初期化</a>
			<?php if($member->permission=="super"|$member->permission=="all"){ ?>
			<a class="btn btn-mini btn-danger boarddel" cid="<?php echo $bbs->cid;?>" link="admin.php?cAct=adminBoardDelete&cid=<?php echo $bbs->cid;?>">削除</a>
			<?php } ?>
			<?php
			}else{
			?>
			<select class="span5" onchange="menu_change(this.options[this.selectedIndex].value,'<?=$bbs->cid?>');" id="menu">
			<option value="#">設定</option>
			<option value="admin.php?cAct=adminBoardSetup&cid=<?php echo $bbs->cid;?>">掲示板設定</option>
			<option value="admin.php?cAct=adminSkinSetup&cid=<?php echo $bbs->cid;?>&skin=<?php echo $bbs->skin;?>">スキン設定</option>
			<option value="admin.php?cAct=adminEmoticonSetup&cid=<?php echo $bbs->cid;?>">絵文字設定</option>
			<option class="text-warning" value="admin.php?cAct=adminBoardReset&cid=<?php echo $bbs->cid;?>">初期化</option>
			<?php if($member->permission=="super"|$member->permission=="all"){ ?>
			<option class="text-danger" value="admin.php?cAct=adminBoardDelete&cid=<?php echo $bbs->cid;?>">削除</option>
			<? } ?>
			</select>
			<?php
			}
			?>
			</td>
		<tr>
	<?php
		}
	}
	?>
	</tbody>
</table>
			<script>
			function menu_change(val,cid){
				if(val=="admin.php?cAct=adminBoardReset&cid="+cid){
					var answer = confirm('リセットしますか？');
					if(answer){
						location = val;
					}else{
						return false;
					}
				}else if(val=="admin.php?cAct=adminBoardDelete&cid="+cid){
					var answer = confirm('掲示板を削除しますか？');
					if(answer){
						location = val;
					}else{
						return false;
					}
				}else{
					location = val;
				}
			}
			</script>
<script type="text/javascript">
$(function(){
<?php 
	if($device=="pc"){
?>
	$(".boarddel").click(function(){
		var link = $(this).attr("link");
		var boardcid = $(this).attr("cid");
		$("#boardbtndelete").attr("href",link);
		$("#cid").html(boardcid);
		$("#boarddelDiv").fadeIn("fast");
	});
	$("#btncancel").click(function(){
		$("#boarddelDiv").fadeOut("fast");
	});
<?php
	}else{
?>
	$(".boarddel").change(function(){
		var link = $(this).val();
		if(link.indexOf("admin.php?cAct=adminBoardDelete")!=-1){
		var answer = confirm("掲示板を削除しますか?");
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
<script type="text/javascript">
$(function(){
<?php 
	if($device=="pc"){
?>
	$(".boardreset").click(function(){
		var link = $(this).attr("link");
		var boardcid = $(this).attr("cid");
		$("#boardbtnreset").attr("href",link);
		$("#resetcid").html(boardcid);
		$("#boardresetDiv").fadeIn("fast");
	});
	$("#btnresetcancel").click(function(){
		$("#boardresetDiv").fadeOut("fast");
	});
<?php
	}else{
?>
	$(".boardreset").change(function(){
		var link = $(this).val();
		if(link.indexOf("admin.php?cAct=adminBoardReset")!=-1){
		var answer = confirm("掲示板をリセットしますか？");
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
<div id="boarddelDiv" class="container">
<div class="alert alert-error span6 offset3">
 <p><b>掲示板削除</b></p>
 <p><span id="cid"></span>掲示板を削除しますか？</p>
 <p><a id="boardbtndelete" href="#" class="btn btn-danger">削除</a> <a id="btncancel" class="btn">キャンセル</a>
</div>
</div>
<div id="boardresetDiv" class="container">
<div class="alert alert-warning span6 offset3">
 <p><b>掲示板リセット</b></p>
 <p><span id="resetcid"></span>掲示板をリセットしますか?</p>
 <p><a id="boardbtnreset" href="#" class="btn btn-warning">リセット</a> <a id="btnresetcancel" class="btn">キャンセル</a>
</div>
</div>