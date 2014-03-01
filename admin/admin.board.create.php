<?php
if(!defined("__CHIBI__")) exit();
if($member->permission=="all" || $member->permission =="super"){
?>
<form class="form-horizontal" method="post" action="admin.php?cAct=adminBoardCreateOk">
<table id="board-create" class="table table-bordered">
<thead>
<tr>
<th colspan="2" class="span12">
掲示板作成
</th>
</tr>
<thead>
<tbody>
<tr>
<td class="span3 td-left">
<p>掲示板ID</p>
</td>
<td class="span9 td-right">
<input id="cid" class="input-xlarge" type="text" name="cid" placeholder="掲示板 ID"  onblur="checkID()" required><p id="chk_id" class="help-inline"></p>
<p class="help-block">掲示板IDを入力してください。<span class="text-warning">※ 英文(小文字)+数字</span></p>
<script type="text/javascript">
function checkID(){
var pattern = /^[a-z]+[a-z0-9_]*$/; 
	 if($("#cid").val() == ""){
	  alert("掲示板 IDを入力してください。");
	  $("#cid").focus();
 }else if(!pattern.test($("#cid").val())){
	 alert("掲示板IDは英文小文字もしくは英文（小文字）＋数字で入力してください。");
	 $("#cid").focus();
 }else{
  $.ajax({
   url: './admin.board.id.check.php',
   type: 'POST',
   data: {'cid':$('#cid').val()},
   dataType: 'html',
   success: function(data){
	   if(data == true){
	    $("#chk_id").html("<span class=\"text-success\">使用可能なIDです。</span>");
	   }else{
	    $("#chk_id").html("<span class=\"text-error\">既に使用中のIDです。</span>");
		$("#cid").focus();
	   }
   }
  });
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
			if($skin[2]=="CB_default")$s_chk="selected";
			else $s_chk="";
			echo "<option vlaue=\"".$skin[2]."\" ".$s_chk." >".$skin[2]."</option>";
			 }
?>
</select>
<p class="help-block">使用するスキンを選択してください。</p>
</p>
</td>
</tr>
<tr>
<td class="span3 td-left">
<p>掲示板のタイトル</p>
</td>
<td class="span9 td-right">
<input class="input-xxlarge" type="text" name="title" placeholder="掲示板タイトル" required >
<p class="help-block">ブラウザに表示するタイトルを入力してください。</p>
</td>
</tr>
<tr>
<td class="span3 td-left">
<p>非公開設定</p>
</td>
<td class="span9 td-right">
<select name="secret">
<option value="off">公開</option>
<option value="on">非公開</option>
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
<option value="all" >すべて</option>
<option value="admin" >管理者のみ</option>
<select>
<p class="help-block">絵及びロード機能の使用権限を設定できます。</p>
</td>
</tr>
<!--
<tr>
<td class="span3 td-left">
<p>비툴의 사용여부</p>
</td>
<td class="span9 td-right">
<select name="btool">
<option value="off">미사용</option>
<option value="on">사용</option>
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
<input class="input-large" type="password" name="passwd" placeholder="非公開パスワード" required>
<p class="help-block">掲示板が非公開の場合、掲示板に接続するためのパスワードを指定できます。</p>
</td>
</tr>
<tr>
<td class="span3 td-left">
<p>１ページあたり表示する絵の数</p>
</td>
<td class="span9 td-right">
<input class="input-large" type="number" name="pic_page" placeholder="１ページあたり表示する絵の数" required value="5">
<p class="help-block">１ページあたり表示する絵の数を入力してください。</p>
</td>
</tr>
<tr>
<td class="span3 td-left">
<p>ページバーのページ数</p>
</td>
<td class="span9 td-right">
<input class="input-large" type="number" name="pic_page_bar" placeholder="ページ数" required value="10">
<p class="help-block">ベージバーに表示するページの数を入力してください。</p>
</td>
</tr>
<tr>
<td class="span3 td-left">
<p>絵の最大横幅</p>
</td>
<td class="span9 td-right">
<input class="input-xlarge" type="number" name="pic_max_width" placeholder="絵の最大横幅" required >
<p class="help-block"></p>
</td>
</tr>
<tr>
<td class="span3 td-left">
<p>絵の最大高さ</p>
</td>
<td class="span9 td-right">
<input class="input-xlarge" type="number" name="pic_max_height" placeholder="絵の最大高さ" required >
<p class="help-block"></p>
</td>
</tr>
<tr>
<td class="span3 td-left">
<p>絵の最小横幅</p>
</td>
<td class="span9 td-right">
<input class="input-xlarge" type="number" name="pic_min_width" placeholder="絵の最小横幅" required >
<p class="help-block"></p>
</td>
</tr>
<tr>
<td class="span3 td-left">
<p>絵の最小高さ</p>
</td>
<td class="span9 td-right">
<input class="input-xlarge" type="number" name="pic_min_height" placeholder="絵の最小高さ" required >
<p class="help-block"></p>
</td>
</tr>
<tr>
<td class="span3 td-left">
<p>絵の基本横幅</p>
</td>
<td class="span9 td-right">
<input class="input-xlarge" type="number" name="pic_d_width" placeholder="絵の基本横幅" required >
<p class="help-block"></p>
</td>
</tr>
<tr>
<td class="span3 td-left">
<p>絵の基本高さ</p>
</td>
<td class="span9 td-right">
<input class="input-xlarge" type="number" name="pic_d_height" placeholder="絵の基本高さ" required >
<p class="help-block"></p>
</td>
</tr>
<!--
<tr>
<td class="span3 td-left">
<p>자동축소 너비</p>
</td>
<td class="span9 td-right">
<input class="input-xlarge" type="number" name="pic_thumbnail_width" placeholder="자동축소 너비" required >
<p class="help-block">해당 너비를 넘어가면 그림은 자동 축소 됩니다.</p>
</td>
</tr>
!-->
<tr>
<td class="span3 td-left">
<p>グループ</p>
</td>
<td class="span9 td-right">
<?php 
$cnt = count($bbs->op->inst);

?>
<p>グループ個数 <input class="position_num input-mini" type="number" class="position_num" value=""> <a href="javascript:;" class="position_btn btn">追加</a><span class="text-warning" style="margin-left:4px;">イメージはhttpを含むURLで入力してください。</span></p>
<script>
$(document).ready(function(){
	$('.position_btn').click(function(){
	var cnt = $('.input_position').length;
	var num = $('.position_num').val();
	if(cnt > num) $('.input_position').slice(num,cnt).remove();
	else {
	for(i=cnt;i<num;i++){
		$('.position').append('<p class="input_position">グループ名 : <input type="text" name="inst['+i+']" > イメージ : <input type="text" name="position['+i+']"></p>');
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
<p>追加グループ</p>
</td>
<td class="span9 td-right">
<?php 
$cnt2 = count($bbs->op->inst2);

?>
<p>グルーム個数<input class="position_num2 input-mini" type="number" class="position_num2" value=""> <a href="javascript:;" class="position_btn2 btn">追加</a><span class="text-warning" style="margin-left:4px;">イメージはhttpを含むURLで入力してください。</span></p>
<script>
$(document).ready(function(){
	$('.position_btn2').click(function(){
	var cnt2 = $('.input_position2').length;
	var num2 = $('.position_num2').val();
	if(cnt2 > num2) $('.input_position2').slice(num2,cnt2).remove();
	else {
	for(i=cnt2;i<num2;i++){
		$('.position2').append('<p class="input_position2">グループ名 : <input type="text" name="inst2['+i+']" > イメージ : <input type="text" name="position2['+i+']"></p>');
	}
	}
	});
});
</script>
<p class="position2"></p>
<p>追加グループ使用法 :: スキン -> スキンデザイン修正で追加グループを表示させたい部分に<br/><code><\?php if($bbs->op->inst2) echo position($comment->op->position2,$bbs->op->inst2,$bbs->op->position2);\?></code> を入れてください。</p>
</td>
</tr>
<tr>
<td class="span3 td-left">
<p>IP 公開</p>
</td>
<td class="span9 td-right">
<select class="input-large" name="showip">
<option value="off">OFF</option>
<option value="admin">管理者のみ公開</option>
<option value="all">すべて公開</option>
<select>
<p class="help-block">絵やコメントの作成者のIPを公開します。</p>
</td>
</tr>
<tr>
<td class="span3 td-left">
<p>絵のポイント</p>
</td>
<td class="span9 td-right">
<input class="input-large" type="number" name="pic_point" placeholder="絵のポイント" value="10">
<p class="help-block">絵を作成する際に与えられるポイントです。</p>
</td>
</tr>
<tr>
<td class="span3 td-left">
<p>コメントポイント</p>
</td>
<td class="span9 td-right">
<input class="input-large" type="number" name="comment_point" placeholder="コメントポイント" value="5">
<p class="help-block">コメントを作成する際に与えられるポイントです。</p>
</td>
</tr>
<tr>
<td class="span3 td-left">
<p>上段外部ページ</p>
</td>
<td class="span9 td-right">
<input class="input-xxlarge" type="text" name="include_head" placeholder="上段外部ページ" >
<p class="help-block">掲示板上段に表示させる外部ページを指定してください。</p>
</td>
</tr>
<tr>
<td class="span3 td-left">
<p>下段外部ページ</p>
</td>
<td class="span9 td-right">
<input class="input-xxlarge" type="text" name="include_foot" placeholder="下段外部ページ" >
<p class="help-block">掲示板下段に表示させる外部ページを入力してください。</p>
</td>
</tr>
<tr>
<td class="span3 td-left">
<p>上段お知らせ</p>
</td>
<td class="span9 td-right">
<textarea rows="7" class="input-xxlarge" name="head" style="resize:none;" placeholder="上段お知らせ"></textarea>
<p class="help-block">掲示板の上段に表示させるお知らせの内容を入力してください。</p>
</td>
</tr>
<tr>
<td class="span3 td-left">
<p>下段お知らせ</p>
</td>
<td class="span9 td-right">
<textarea rows="7" class="input-xxlarge" name="foot" style="resize:none;" placeholder="下段お知らせ"></textarea>
<p class="help-block">掲示板下段に表示させるお知らせの内容を入力してください。</p>
</td>
</tr>
<tr>
<td class="span3 td-left">
<p>使用可能なタグのリスト</p>
</td>
<td class="span9 td-right">
<textarea rows="5" class="input-xxlarge" name="tag" style="resize:none;" >font,b,img</textarea>
<p class="help-block">コメントとニックネームで使用可能なタグのリストです。<br/>font,b,img のように <code> , </code> で区切って入力してください<br/><span class="text-warning"><code>iframe</code>,<code>embed</code>,<code>object</code> タグなどは使用する際にセキュリティ上問題が発生する可能性があります。<br/>使用する際に注意してください。</span></p>
</td>
</tr>
<tr>
<td class="span3 td-left">
<p>スパムIP フィルター</p>
</td>
<td class="span9 td-right">
<p>
<select class="input-large" name="op">
<option value="ban">掲示板接続禁止</option>
<option value="write">絵 / コメント作成禁止</option>
</select>
</p>
<textarea rows="5" class="input-xxlarge" name="ip" style="resize:none;" ></textarea>
<p class="help-block">スパムIPフィルターです。IPを入力して下さい。<br/>複数のIPの場合 <code> , </code> で区切ってください。</p>
</td>
</tr>
<tr>
<td class="span3 td-left">
<p>スパム単語フィルター</p>
</td>
<td class="span9 td-right">
<textarea rows="5" class="input-xxlarge" name="word" style="resize:none;">aloha,viagra</textarea>
<p class="help-block">スパム単語フィルターです。<br/>複数の単語は , で区切ってください。</p>
</td>
</tr>
<tr>
<td colspan="2" class="td-left">
<p class="text-right">
  <button type="submit" class="btn btn-success">掲示板作成</button>
  <button type="button" class="btn ">キャンセル</button>
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
管理者のみ接続可能なページです。<br/><br/>
<a class="btn btn-danger" href="javascript:history.go(-1);">もどる</a>
</div>
<?php
}
?>