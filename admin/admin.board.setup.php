<?php
if(!defined("__CHIBI__")) exit();
$query = select($cid,$chibi_conn);
$bbs = (object) mysql_fetch_array($query);
$bbs->spam = (object) unserialize($bbs->spam);
$bbs->notice = (object) unserialize($bbs->notice);
$bbs->op = (object) unserialize($bbs->op);
if(bbs_permission($member->permission,$bbs->cid)=="true"){
?>
<form class="form-horizontal" method="post" action="admin.php?cAct=adminBoardSetupOk">
<table id="board-create" class="table table-bordered">
<thead>
<tr>
<th colspan="2" class="span12">
掲示板 設定
</th>
</tr>
<thead>
<tbody>
<tr>
<td class="span3 td-left">
<p>掲示板 ID</p>
</td>
<td class="span9 td-right">
<input id="ncid" class="input-xlarge" type="text" name="ncid" placeholder="게시판 ID" value="<?php echo $bbs->cid;?>" onblur="checkID()" required><p id="chk_id" class="help-inline"></p>
<input id="cid" name="cid" type="hidden" value="<?php echo $bbs->cid;?>">
<p class="help-block">掲示板 IDを入力してください。<span class="text-warning">※ 英文(小文字)+数字</span></p>
<script type="text/javascript">
function checkID(){
var pattern = /^[a-z]+[a-z0-9_]*$/; 
var cid = "<?php echo $bbs->cid;?>";
if($("#ncid").val() == ""){
	  alert("掲示板 IDを入力してください。");
	  $("#ncid").focus();
 }else if(!pattern.test($("#ncid").val())){
	 alert("掲示板 IDは英文もしくは英文（小文字）＋数字で入力して下さい。");
	 $("#ncid").focus();
 }else{
	if(cid!=$("#ncid").val()){
  $.ajax({
   url: './admin.board.id.check.php',
   type: 'POST',
   data: {'cid':$('#ncid').val()},
   dataType: 'html',
   success: function(data){
	   if(data == true){
	    $("#chk_id").html("<span class=\"text-success\">利用可能なIDです。</span>");
	   }else{
	    $("#chk_id").html("<span class=\"text-error\">利用しているIDです。</span>");
		$("#ncid").focus();
	   }
   }
  });
	}
 }
}
</script>
</td>
</tr>
<tr>
<td class="span3 td-left">
<p>スキン設定</p>
</td>
<td class="span9 td-right">
<select name="skin">
<?php
	foreach(glob("../skin/*",GLOB_ONLYDIR) as $value){
			$skin = explode("/",$value);
			if($skin[2]==$bbs->skin)$s_chk="selected";
			else $s_chk="";
			if($skin[2]!="CB_gallery" || ($member->permission=="super" && $skin[2]=="CB_gallery")){
			echo "<option vlaue=\"".$skin[2]."\" ".$s_chk." >".$skin[2]."</option>";
			}
			 }
?>
</select>
<p class="help-block">利用するスキンを選択してください。</p>
</p>
</td>
</tr>
<tr>
<td class="span3 td-left">
<p>掲示板タイトル</p>
</td>
<td class="span9 td-right">
<input class="input-xxlarge" type="text" name="title" placeholder="掲示板タイトル" value="<?php echo $bbs->title;?>" required >
<p class="help-block">ブラウザタイトルに表示されます。</p>
</td>
</tr>
<tr>
<td class="span3 td-left">
<p>非公開設定</p>
</td>
<td class="span9 td-right">
<select name="secret">
<option value="off" <?php if($bbs->op->secret=="off") echo "selected"; ?>>公開</option>
<option value="on" <?php if($bbs->op->secret=="on") echo "selected"; ?>>非公開</option>
<select>
<p class="help-block">掲示板を公開 / 非公開に設定できます。</p>
</td>
</tr>
<tr>
<td class="span3 td-left">
<p>使用権限</p>
</td>
<td class="span9 td-right">
<select name="use_permission">
<option value="all" <?php if($bbs->op->use_permission=="all") echo "selected"; ?>>すべてのユーザー</option>
<option value="admin" <?php if($bbs->op->use_permission=="admin") echo "selected"; ?>>管理者のみ</option>
<select>
<p class="help-block">絵の投稿及びロード機能の使用権限を設定できます。</p>
</td>
</tr>
<!--
<tr>
<td class="span3 td-left">
<p>비툴의 사용여부</p>
</td>
<td class="span9 td-right">
<select name="btool">
<option value="off" <?php if($bbs->op->btool=="off") echo "selected"; ?>>미사용</option>
<option value="on" <?php if($bbs->op->btool=="on") echo "selected"; ?>>사용</option>
<select>
<p class="help-block">비툴프로그램의 사용여부를 설정 할 수 있습니다.<br/><span class="text-warning">비툴홈페이지(<a href="http://btool.net" target="_blank">http://btool.net</a>)에서 구입 후 이용하여 주세요.</p>
</td>
</tr>
-->
<input type="hidden" name="btool" value="off">
<tr>
<td class="span3 td-left">
<p>非公開パスワード</p>
</td>
<td class="span9 td-right">
<input class="input-large" type="password" name="passwd" placeholder="非公開パスワード">
<p class="help-block">非公開掲示板の場合、掲示板に接続する際に必要なパスワードです。<br/><span class="text-warning">パスワード変更の際のみ入力してください。</span></p>
</td>
</tr>
<tr>
<td class="span3 td-left">
<p>ページに表示する絵の数</p>
</td>
<td class="span9 td-right">
<input class="input-large" type="number" name="pic_page" placeholder="ページに表示する絵の数" required value="<?php echo $bbs->op->pic_page;?>">
<p class="help-block">ページに表示する絵の数を入力してください</p>
</td>
</tr>
<tr>
<td class="span3 td-left">
<p>ベージバーのページ数</p>
</td>
<td class="span9 td-right">
<input class="input-large" type="number" name="pic_page_bar" placeholder="ベージバーのページ数" required value="<?php echo $bbs->op->pic_page_bar;?>">
<p class="help-block">ベージバーに表示されるのページ数を入力してください。</p>
</td>
</tr>
<tr>
<td class="span3 td-left">
<p>絵の最大横幅</p>
</td>
<td class="span9 td-right">
<input class="input-xlarge" type="number" name="pic_max_width" placeholder="絵の最大横幅" required value="<?php echo $bbs->op->pic_max_width;?>">
<p class="help-block">絵の最大横幅を入力してください</p>
</td>
</tr>
<tr>
<td class="span3 td-left">
<p>絵の最大高さ</p>
</td>
<td class="span9 td-right">
<input class="input-xlarge" type="number" name="pic_max_height" placeholder="絵の最大高さ" required value="<?php echo $bbs->op->pic_max_height;?>">
<p class="help-block">絵の最大高さを入力してください</p>
</td>
</tr>
<tr>
<td class="span3 td-left">
<p>絵の最小横幅</p>
</td>
<td class="span9 td-right">
<input class="input-xlarge" type="number" name="pic_min_width" placeholder="絵の最小横幅" required value="<?php echo $bbs->op->pic_min_width;?>">
<p class="help-block">絵の最小横幅を入力してください</p>
</td>
</tr>
<tr>
<td class="span3 td-left">
<p>絵の最小高さ</p>
</td>
<td class="span9 td-right">
<input class="input-xlarge" type="number" name="pic_min_height" placeholder="絵の最小高さ" required value="<?php echo $bbs->op->pic_min_height;?>">
<p class="help-block">絵の最小高さを入力してください。</p>
</td>
</tr>
<tr>
<td class="span3 td-left">
<p>絵の基本横幅</p>
</td>
<td class="span9 td-right">
<input class="input-xlarge" type="number" name="pic_d_width" placeholder="絵の基本横幅" required value="<?php echo $bbs->op->pic_d_width;?>">
<p class="help-block"></p>
</td>
</tr>
<tr>
<td class="span3 td-left">
<p>絵の基本高さ</p>
</td>
<td class="span9 td-right">
<input class="input-xlarge" type="number" name="pic_d_height" placeholder="絵の基本高さ" required value="<?php echo $bbs->op->pic_d_height;?>">
<p class="help-block"></p>
</td>
</tr>
<!--//
<tr>
<td class="span3 td-left">
<p>자동축소 너비</p>
</td>
<td class="span9 td-right">
<input class="input-xlarge" type="number" name="pic_thumbnail_width" placeholder="자동축소 너비" required value="<?php echo $bbs->op->pic_thumbnail_width;?>">
<p class="help-block">해당 너비를 넘어가면 그림은 자동 축소 됩니다.</p>
</td>
</tr>
//-->
<tr>
<td class="span3 td-left">
<p>Group Icon</p>
</td>
<td class="span9 td-right">
<?php 
$inst = explode(',',$bbs->op->inst);
$position = explode(',',$bbs->op->position);
$cnt = count($inst);
?>
<p>Group数 <input class="position_num input-mini" type="number" class="position_num" value="<?php echo $cnt;?>"> <a href="javascript:;" class="position_btn btn">追加</a><span class="text-warning" style="margin-left:4px;"></span></p>
<?php 
if($cnt!=0){
	for($i=0;$i<$cnt;$i++){
?>
<p class="input_position">Groupネーム : <input type="text" name="inst[<?=$i?>]" value="<?=$inst[$i]?>"> イメージ : <input type="text" name="position[<?=$i?>]" value="<?=$position[$i]?>"></p>
<?php 
}
}
?>
<script>
$(document).ready(function(){
	$('.position_btn').click(function(){
	var cnt = $('.input_position').length;
	var num = $('.position_num').val();
	if(cnt > num) $('.input_position').slice(num,cnt).remove();
	else {
	for(i=cnt;i<num;i++){
		$('.position').append('<p class="input_position">명령어 : <input type="text" name="inst['+i+']" > 이미지 : <input type="text" name="position['+i+']"></p>');
	}
	}
	});
});
</script>
<p class="position"></p>
</td>
</tr>
<tr>
<td class="span3 td-left">
<p>Group Icon2</p>
</td>
<td class="span9 td-right">
<?php 
$inst2 = explode(',',$bbs->op->inst2);
$position2 = explode(',',$bbs->op->position2);
$cnt2 = count($inst2);
?>
<p>Group数 <input class="position_num2 input-mini" type="number" class="position_num2" value="<?php echo $cnt2;?>"> <a href="javascript:;" class="position_btn2 btn">追加</a><span class="text-warning" style="margin-left:4px;"></span></p>
<?php 
if($cnt2!=0){
	for($i=0;$i<$cnt2;$i++){
?>
<p class="input_position2">Groupネーム : <input type="text" name="inst2[<?=$i?>]" value="<?=$inst2[$i]?>"> イメージ : <input type="text" name="position2[<?=$i?>]" value="<?=$position2[$i]?>"></p>
<?php 
}
}
?>
<script>
$(document).ready(function(){
	$('.position_btn2').click(function(){
	var cnt2 = $('.input_position2').length;
	var num2 = $('.position_num2').val();
	if(cnt2 > num2) $('.input_position2').slice(num2,cnt2).remove();
	else {
	for(i=cnt2;i<num2;i++){
		$('.position2').append('<p class="input_position2">명령어 : <input type="text" name="inst2['+i+']" > 이미지 : <input type="text" name="position2['+i+']"></p>');
	}
	}
	});
});
</script>
<p class="position2"></p>
</td>
</tr>
<input type="hidden" name="pic_thumbnail_width" value="<?php echo $bbs->op->pic_thumbnail_width;?>">
<tr>
<td class="span3 td-left">
<p>IP 公開</p>
</td>
<td class="span9 td-right">
<select class="input-large" name="showip">
<option value="off" <?php if($bbs->op->showip=="off") echo "selected"; ?>>OFF</option>
<option value="admin" <?php if($bbs->op->showip=="admin") echo "selected"; ?>>管理者のみ公開</option>
<option value="all" <?php if($bbs->op->showip=="all") echo "selected"; ?>>全体公開</option>
<select>
<p class="help-block">絵＆コメント作成者のIPを公開します。</p>
</td>
</tr>
<tr>
<td class="span3 td-left">
<p>書き込みポイント</p>
</td>
<td class="span9 td-right">
<input class="input-large" type="number" name="pic_point" placeholder="書き込みポイント" value="<?php echo $bbs->op->pic_point;?>">
<p class="help-block"></p>
</td>
</tr>
<tr>
<td class="span3 td-left">
<p>コメントポイント</p>
</td>
<td class="span9 td-right">
<input class="input-large" type="number" name="comment_point" placeholder="コメントポイント" value="<?php echo $bbs->op->comment_point;?>">
<p class="help-block"></p>
</td>
</tr>
<tr>
<td class="span3 td-left">
<p>上段外部ページ</p>
</td>
<td class="span9 td-right">
<input class="input-xxlarge" type="text" name="include_head" placeholder="上段外部ページ" value="<?php echo $bbs->op->include_head;?>">
<p class="help-block"></p>
</td>
</tr>
<tr>
<td class="span3 td-left">
<p>下段外部ページ</p>
</td>
<td class="span9 td-right">
<input class="input-xxlarge" type="text" name="include_foot" placeholder="下段外部ページ" value="<?php echo $bbs->op->include_foot;?>">
<p class="help-block"></p>
</td>
</tr>
<tr>
<td class="span3 td-left">
<p>上段お知らせ</p>
</td>
<td class="span9 td-right">
<textarea rows="7" class="input-xxlarge" name="head" style="resize:none;" placeholder="上段お知らせ" ><?php echo $bbs->notice->head;?></textarea>
<p class="help-block"></p>
</td>
</tr>
<tr>
<td class="span3 td-left">
<p>下段お知らせ</p>
</td>
<td class="span9 td-right">
<textarea rows="7" class="input-xxlarge" name="foot" style="resize:none;" placeholder="下段お知らせ"><?php echo $bbs->notice->foot;?></textarea>
<p class="help-block"></p>
</td>
</tr>
<tr>
<td class="span3 td-left">
<p>使用可能なタグリスト</p>
</td>
<td class="span9 td-right">
<textarea rows="5" class="input-xxlarge" name="tag" style="resize:none;" ><?php echo $bbs->tag;?></textarea>
<p class="help-block">コメント部分に使用可能なタグリストです。<br/>font,b,img のように <code> , </code> で区分してください。<br/><span class="text-warning">コメント部分に<code>iframe</code>,<code>embed</code>,<code>object</code> タグを使用するのはセキュリティ上危険です<br/>使用に注意してください。</span></p>
</td>
</tr>
<tr>
<td class="span3 td-left">
<p>スパムIPフィルター</p>
</td>
<td class="span9 td-right">
<p>
<select class="input-large" name="op">
<option value="ban" <?php if($bbs->spam->op=="ban") echo "selected"; ?>>掲示板接続禁止</option>
<option value="write" <?php if($bbs->spam->op=="write") echo "selected"; ?>>書き込み禁止</option>
</select>
</p>
<textarea rows="5" class="input-xxlarge" name="ip" style="resize:none;" ><?php echo $bbs->spam->ip;?></textarea>
<p class="help-block">スパムIPフィルターです。<br/>複数のIPを入力する際には , を利用して下さい。</p>
</td>
</tr>
<tr>
<td class="span3 td-left">
<p>スパム単語フィルター</p>
</td>
<td class="span9 td-right">
<textarea rows="5" class="input-xxlarge" name="word" style="resize:none;"><?php echo $bbs->spam->word;?></textarea>
<p class="help-block">스スパム単語フィルターです<br/>複数の単語を入力する際には , を利用して下さい。</p>
</td>
</tr>
<tr>
<td colspan="2" class="td-left">
<p class="text-right">
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
접속권한이 없습니다.<br/>
해당 게시판 관리자만 접속 가능한 페이지 입니다.<br/><br/>
<a class="btn btn-danger" href="javascript:history.go(-1);">돌아가기</a>
</div>
<?php
}
?>