<?php
if(!defined("__CHIBI__")) exit();

if(bbs_permission($member->permission,$cid)=="true"){
?>
<div class="span8 offset2"></div>
<div class="span8 offset2 alert alert-success">
<form class="form-horizontal" id="uploadForm" action="admin.emoticon.submit.php" onsubmit="return filesubmit()" method="post" enctype="multipart/form-data">
<legend><span class="text-success">絵文字追加 :: 掲示板 - <?php echo $cid;?></span></legend>
<div class="control-group">
    <label class="control-label" for="inputInst">命令語</label>
    <div class="controls">
      <input type="hidden" name="cid" value="<?php echo $cid;?>">
	  <input type="hidden" id="chk" name="chk" value="">
	  <input name="inst" class="input-large" id="inputInst" type="text" placeholder="/命令語形式に入力してください。" onblur="checkID()" required>
	  <span id="inst" class="help-inline"></span>
	   <p class="help-block"><span class="label label-warning">※注意</span> <code>/命令語</code> 形式に入力してください。</p>
    </div>
</div>
<div class="control-group">
    <label class="control-label" for="inputFile">ファイル</label>
    <div class="controls">
      <input name="image" class="input-large" id="inputFile" type="file" required>
    </div>  
</div>
<p class="text-right"><button type="submit" id="addEmoticon" class="btn btn-primary">絵文字追加</button></p>
<iframe id="uploadIFrame" name="uploadIFrame" src="" style="display:none;visibility:hidden"></iframe>
</form>
</div>
<div class="span10 offset1 well">
<ul id="em_list" class="unstyled inline">
<?php
$string = "SELECT * FROM `chibi_emoticon` where `cid`='".mysql_real_escape_string($cid)."'";
		$em_query = mysql_query($string,$chibi_conn);
		$em_list ='';
		while($em = mysql_fetch_array($em_query)){
		echo "<li style=\"width:100px;height:100px;text-align:center;\">
		<ul class=\"unstyled\">
		<li><img src=\"../".$em['url']."\" /></li>
		<li>".$em['inst']."</li>
		<li><button type=\"button\" class=\"btn btn-mini emoticon_del\" onclick=\"delemoticon('".$cid."','".$em['url']."','".$em['inst']."');\">삭제</button></li>
		</ul>
		</li>";
		}
?>
</ul>
</div>
<script type="text/javascript">
function checkID(){
	 if($("#inputInst").val() == ""){
	  
 }else{
  $.ajax({
   url: './admin.emoticon.id.check.php',
   type: 'POST',
   data: {'inst':$('#inputInst').val(),'cid':'<?php echo $cid;?>'},
   dataType: 'html',
   success: function(data){
	   if(data == true){
	    $("#inst").html("<span class=\"text-success\">使用可能な命令語です。</span>");
		$("#chk").val("true");
	   }else{
	    $("#inst").html("<span class=\"text-error\">既に使用中の命令語です。</span>");
		$("#chk").val("false");
	   }
   }
  });
 }
}
</script>
<script type="text/javascript">
function delemoticon(cid,href,inst){
	var url = "./admin.emoticon.del.php?cid="+cid+"&inst="+inst+"&url="+href;
	if(url!=""){
			$("#uploadIFrame").attr("src",url);
			 document.getElementById("uploadIFrame").onload = function()
			{
				alert('削除完了!!');
				location.href="admin.php?cAct=<?php echo $cAct;?>&cid=<?php echo $cid;?>";
			}
	}else{
		alert('削除失敗');
	}
 }
</script>
<script type="text/javascript">
function filesubmit(){
	 if($("#inputInst").val() == ""){
	  alert("命令語を入力してください。");
	  $('#inputInst').focus();
	  return false;
 }else if($("#chk").val()=="false"){
	alert('既に使用中の命令語です。');
	$('#inputInst').focus();
	return false;
 }else{
	 document.getElementById("uploadForm").target = "uploadIFrame";
	 document.getElementById("uploadIFrame").onload = function()
	{
			alert('登録完了!!');
			location.href="admin.php?cAct=<?php echo $cAct;?>&cid=<?php echo $cid;?>";
			
	}
	return true;
 }
}
</script>
<?php
}
?>