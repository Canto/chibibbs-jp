<?php
if(!defined("__CHIBI__")) exit();
$query = select_skin($cid,$chibi_conn);
$skin = (object) mysql_fetch_array($query);
$skin->op = unserialize($skin->op);
if(get_magic_quotes_gpc()) $skin->op = array_map('stripslashes', $skin->op);
$skin->op = (object) $skin->op;
if(empty($skin->op->painter_icon)) $skin->op->painter_icon = "[작가글]";
if(bbs_permission($member->permission,$skin->cid)=="true"){
?>
<form class="form-horizontal" method="post" action="admin.php?cAct=adminSkinSetupOk">
<input name="skin" type="hidden" value="<?php echo $skin->skin_name;?>">
<input name="op[bootstrap]" type="hidden" value="on">
<!-- // 스킨제작자 표시용
<input name="op[author]" type="hidden" value='<a href="http://canto.btool.kr" target="_blank">Canto</a>'>
-->
<table id="board-create" class="table table-bordered">
<thead>
<tr>
<th colspan="2" class="span12">
<a href="admin.php?cAct=adminSkinTpl&cid=<?=$cid?>&skin=<?=$skin->skin_name?>" class="btn offset4 span4">スキンデザイン修正</a>
</th>
</tr>
<tr>
<th colspan="2" class="span12">
スキン設定
</th>
</tr>
<tr>
<th colspan="2" class="span12">
<pre>
スキン名	: Default_EX
制作者		: Canto
ホームページ	: <a href="http://canto.btool.kr" target="_blank">http://canto.btool.kr</a>
バージョン		: 1.10
</pre>
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
<td class="span3 td-left">
<p>リンク色</p>
</td>
<td class="span9 td-right">
<input class="input-xlarge" type="text" name="op[link_color]" placeholder="リンク 色" value="<?php echo $skin->op->link_color;?>"  >
<p class="help-inline">リンク色を入力して下さい 例 > <code>#ffffff</code></p><br/><br/>
<input class="input-xlarge" type="text" name="op[hover_color]" placeholder="リンク マウスオーバー色" value="<?php echo $skin->op->hover_color;?>"  >
<p class="help-inline">リンクにマウスホーバーした際の色を入力して下さい。例 > <code>#ffffff</code></p>
</td>
</tr>
<tr>
<td class="span3 td-left">
<p>掲示板背景色</p>
</td>
<td class="span9 td-right">
<input class="input-xlarge" type="text" name="op[background_color]" placeholder="掲示板 背景色" value="<?php echo $skin->op->background_color;?>"  >
<p class="help-inline">掲示板背景色を入力してください > <code>#ffffff</code></p>
</td>
</tr>
<tr>
<td class="span3 td-left">
<p>掲示板背景イメージ</p>
</td>
<td class="span9 td-right">
<input class="input-xxlarge" type="text" name="op[background_img]" placeholder="背景イメージ" value="<?php echo $skin->op->background_img;?>">
<select name="op[repeat]">
<option value="">繰り替えオプション</option>
<option value="repeat" <?php if($skin->op->repeat=="repeat") echo "selected"; ?>>繰り替え</option>
<option value="repeat-x" <?php if($skin->op->repeat=="repeat-x") echo "selected"; ?>>水平</option>
<option value="repeat-y" <?php if($skin->op->repeat=="repeat-y") echo "selected"; ?>>垂直</option>
<option value="no-repeat" <?php if($skin->op->repeat=="no-repeat") echo "selected"; ?>>繰り替えなし</option>
<option value="fixed" <?php if($skin->op->repeat=="fixed") echo "selected"; ?>>固定</option>
<select>
<p class="help-inline"></p>
</td>
</tr>
<tr>
<td class="span3 td-left">
<p>お知らせ <br/> 線色,線種類 & 背景色</p>
</td>
<td class="span9 td-right">
<input class="input-xlarge" type="text" name="op[notice_border_color]" placeholder="お知らせ線色 & 太さ" value="<?php echo $skin->op->notice_border_color;?>">
<select name="op[notice_border_type]">
<option value="">線種類</option>
<option value="solid" <?php if($skin->op->notice_border_type=='solid') echo 'selected="selected"';?>>一般</option>
<option value="dotted" <?php if($skin->op->notice_border_type=='dotted') echo 'selected="selected"';?>>点(・)</option>
<option value="dashed" <?php if($skin->op->notice_border_type=='dashed') echo 'selected="selected"';?>>ダッシュ(-)</option>
<option value="double" <?php if($skin->op->notice_border_type=='double') echo 'selected="selected"';?>>이중 선</option>
<option value="groove" <?php if($skin->op->notice_border_type=='groove') echo 'selected="selected"';?>>홈 모양 선</option>
<option value="ridge" <?php if($skin->op->notice_border_type=='ridge') echo 'selected="selected"';?>>돌출 선</option>
<option value="inset" <?php if($skin->op->notice_border_type=='inset') echo 'selected="selected"';?>>내부 엠보싱</option>
<option value="outset" <?php if($skin->op->notice_border_type=='ouset') echo 'selected="selected"';?>>외부 엠보싱</option>
</select>
<p class="help-block">お知らせの線の色と太さを入力して下さい。　例 > <code>#ffffff 1px</code></p>
<input class="input-xlarge" type="text" name="op[notice_background_color]" placeholder="背景色" value="<?php echo $skin->op->notice_background_color;?>">
<p class="help-block">お知らせの背景色を入力してください。 例> <code>#ffffff</code></p>
<input class="input-xlarge" type="text" name="op[notice_font_color]" placeholder="テキスト色" value="<?php echo $skin->op->notice_font_color;?>">
<p class="help-block">お知らせのテキスト色を入力してください。　例> <code>#ffffff</code></p>
</td>
</tr>
<tr>
<td class="span3 td-left">
<p>テーブルの背景色</p>
</td>
<td class="span9 td-right">
<input class="input-xlarge" type="text" name="op[table_background_color]" placeholder="テーブルの背景色" value="<?php echo $skin->op->table_background_color;?>"  >
<p class="help-inline">例 > <code>#ffffff</code></p>
</td>
</tr>
<tr>
<td class="span3 td-left">
<p>テーブルの外側の線</p>
</td>
<td class="span9 td-right">
<input class="input-xlarge" type="text" name="op[table_border_color]" placeholder="色" value="<?php echo $skin->op->table_border_color;?>">
<p class="help-block">色を入力して下さい</p>
<input class="input-xlarge" type="text" name="op[table_border_size]" placeholder="太さ" value="<?php echo $skin->op->table_border_size;?>">
<p class="help-block">太さを入力してください</p>
<select name="op[table_border_type]">
<option value="">線の種類</option>
<option value="solid" <?php if($skin->op->table_border_type=='solid') echo 'selected="selected"';?>>一般</option>
<option value="dotted" <?php if($skin->op->table_border_type=='dotted') echo 'selected="selected"';?>>点(・)</option>
<option value="dashed" <?php if($skin->op->table_border_type=='dashed') echo 'selected="selected"';?>>대쉬(-) 선</option>
<option value="double" <?php if($skin->op->table_border_type=='double') echo 'selected="selected"';?>>이중 선</option>
<option value="groove" <?php if($skin->op->table_border_type=='groove') echo 'selected="selected"';?>>홈 모양 선</option>
<option value="ridge" <?php if($skin->op->table_border_type=='ridge') echo 'selected="selected"';?>>돌출 선</option>
<option value="inset" <?php if($skin->op->table_border_type=='inset') echo 'selected="selected"';?>>내부 엠보싱</option>
<option value="outset" <?php if($skin->op->table_border_type=='ouset') echo 'selected="selected"';?>>외부 엠보싱</option>
</select>
</td>
</tr>
<tr>
<td class="span3 td-left">
<p>テーブル内側の線</p>
</td>
<td class="span9 td-right">
<input class="input-xlarge" type="text" name="op[table_inner_border_color]" placeholder="色" value="<?php echo $skin->op->table_inner_border_color;?>">
<p class="help-block">色を入力してください</p>
<input class="input-xlarge" type="text" name="op[table_inner_border_size]" placeholder="太さ" value="<?php echo $skin->op->table_inner_border_size;?>">
<p class="help-block">太さを入力して下さい</p>
<select name="op[table_inner_border_type]">
<option value="">線の種類</option>
<option value="solid" <?php if($skin->op->table_inner_border_type=='solid') echo 'selected="selected"';?>>一般</option>
<option value="dotted" <?php if($skin->op->table_inner_border_type=='dotted') echo 'selected="selected"';?>>点(・)</option>
<option value="dashed" <?php if($skin->op->table_inner_border_type=='dashed') echo 'selected="selected"';?>>대쉬(-) 선</option>
<option value="double" <?php if($skin->op->table_inner_border_type=='double') echo 'selected="selected"';?>>이중 선</option>
<option value="groove" <?php if($skin->op->table_inner_border_type=='groove') echo 'selected="selected"';?>>홈 모양 선</option>
<option value="ridge" <?php if($skin->op->table_inner_border_type=='ridge') echo 'selected="selected"';?>>돌출 선</option>
<option value="inset" <?php if($skin->op->table_inner_border_type=='inset') echo 'selected="selected"';?>>내부 엠보싱</option>
<option value="outset" <?php if($skin->op->table_inner_border_type=='ouset') echo 'selected="selected"';?>>외부 엠보싱</option>
</select>
</td>
</tr>
<tr>
<td class="span3 td-left">
<p>絵の表示部分背景色</p>
</td>
<td class="span9 td-right">
<input class="input-xlarge" type="text" name="op[pic_background_color]" placeholder="背景色" value="<?php echo $skin->op->pic_background_color;?>">
<p class="help-block">背景色を入力してください</p>
</td>
</tr>
<tr>
<td class="span3 td-left">
<p>コメント背景色</p>
</td>
<td class="span9 td-right">
<input class="input-xlarge" type="text" name="op[reply_background_color]" placeholder="背景色"  value="<?php echo $skin->op->reply_background_color;?>">
<p class="help-block">コメントの背景色を入力してください</p>
</td>
</tr>
<tr>
<td class="span3 td-left">
<p>コメントの色</p>
</td>
<td class="span9 td-right">
<input class="input-xlarge" type="text" name="op[reply_text_color]" placeholder="色" value="<?php echo $skin->op->reply_text_color;?>">
<p class="help-block">コメントテキストの色を入力してください</p>
</td>
</tr>
<tr>
<td class="span3 td-left">
<p>再コメントバーの色</p>
</td>
<td class="span9 td-right">
<input class="input-xlarge" type="text" name="op[rereply_bar_color]" placeholder="色"  value="<?php echo $skin->op->rereply_bar_color;?>">
<p class="help-block">再コメントバーの色を入力してください。</p>
</td>
</tr>
<tr>
<td class="span3 td-left">
<p>再コメントの色</p>
</td>
<td class="span9 td-right">
<input class="input-xlarge" type="text" name="op[rereply_text_color]" placeholder="色"  value="<?php echo $skin->op->rereply_text_color;?>">
<p class="help-block">再コメントテキストの色を入力してください。</p>
</td>
</tr>
<tr>
<td class="span3 td-left">
<p>下整列の絵サイズ</p>
</td>
<td class="span9 td-right">
<input class="input-xlarge" type="text" name="op[table_down]" placeholder="下整列" value="<?php echo $skin->op->table_down;?>">
<p class="help-block">絵の横幅が指定したサイズ以上の場合、コメントが絵の下に移動します。</p>
</td>
</tr>
<tr>
<td class="span3 td-left">
<p>リサイズの横幅</p>
</td>
<td class="span9 td-right">
<input class="input-xlarge" type="text" name="op[resize]" placeholder="리사이즈" value="<?php echo $skin->op->resize;?>">
<p class="help-block">絵の横幅が指定サイズ以上の場合、リサイズされます。</p>
</td>
</tr>
<tr>
<td class="span3 td-left">
<p>書き込み情報表示</p>
</td>
<td class="span9 td-right">
<div class="controls-group">
	<p>
		<label class="checkbox inline">
			<input type="checkbox" id="op['tool']" name="op[tool]" value="show" <?php if($skin->op->tool=="show") echo "checked";?>>作成ツール情報
		</label>
		<label class="checkbox inline">
			<input type="checkbox" id="op['size']" name="op[size]" value="show" <?php if($skin->op->size=="show") echo "checked";?>>元サイズ & リサイズ情報
		</label>
		<label class="checkbox inline">
			<input type="checkbox" id="op['time']" name="op[time]" value="show" <?php if($skin->op->time=="show") echo "checked";?>>作成時間情報
		</label>
	</p>
</div>
<p class="help-block">書き込み上に情報を表示します。</p>
</td>
</tr>
<tr>
<td class="span3 td-left">
<p>時間表示スタイル</p>
</td>
<td class="span9 td-right">
<input class="input-xlarge" type="text" name="op[time_type]" placeholder="時間表示スタイル" value="<?php echo $skin->op->time_type;?>">
<p class="help-block">時間表時スタイルを設定します 例> <code>Y年m月d日 H時i分s秒</code></p>
</td>
</tr>
<tr>
<td class="span3 td-left">
<p>BTOOLアイコン</p>
</td>
<td class="span9 td-right">
<input class="input-xxlarge" type="text" name="op[btool_icon]" placeholder="BTOOLアイコン" required value='<?php echo $skin->op->btool_icon;?>'>
<p class="help-block"></p>
</td>
</tr>
<tr>
<td class="span3 td-left">
<p>CHIBIPAINTアイコン</p>
</td>
<td class="span9 td-right">
<input class="input-xxlarge" type="text" name="op[chibi_icon]" placeholder="アイコン" required value='<?php echo $skin->op->chibi_icon;?>'>
<p class="help-block"></p>
</td>
</tr>
<tr>
<td class="span3 td-left">
<p>ロードアイコン</p>
</td>
<td class="span9 td-right">
<input class="input-xxlarge" type="text" name="op[load_icon]" placeholder="アイコン" required value='<?php echo $skin->op->load_icon;?>'>
<p class="help-block"></p>
</td>
</tr>
<tr>
<td class="span3 td-left">
<p>Refreshアイコン</p>
</td>
<td class="span9 td-right">
<input class="input-xxlarge" type="text" name="op[reflash_icon]" placeholder="アイコン" required value='<?php echo $skin->op->reflash_icon;?>'>
<p class="help-block"></p>
</td>
</tr>
<tr>
<td class="span3 td-left">
<p>ログインアイコン</p>
</td>
<td class="span9 td-right">
<input class="input-xxlarge" type="text" name="op[login_icon]" placeholder="ログインアイコン" required value='<?php echo $skin->op->login_icon;?>'>
<p class="help-block">ログインアイコン</p>
</td>
</tr>
<tr>
<td class="span3 td-left">
<p>ログアウトアイコン</p>
</td>
<td class="span9 td-right">
<input class="input-xxlarge" type="text" name="op[logout_icon]" placeholder="ログアウトアイコン" required value='<?php echo $skin->op->logout_icon;?>'>
<p class="help-block"></p>
</td>
</tr>
<tr>
<td class="span3 td-left">
<p>掲示板管理アイコン</p>
</td>
<td class="span9 td-right">
<input class="input-xxlarge" type="text" name="op[admin_icon]" placeholder="掲示板管理アイコン" required value='<?php echo $skin->op->admin_icon;?>'>
<p class="help-block"></p>
</td>
</tr>
<tr>
<td class="span3 td-left">
<p>絵文字リストアイコン</p>
</td>
<td class="span9 td-right">
<input class="input-xxlarge" type="text" name="op[emoticon_icon]" placeholder="絵文字リストアイコン" required value='<?php echo $skin->op->emoticon_icon;?>'>
<p class="help-block"></p>
</td>
</tr>
<tr>
<td class="span3 td-left">
<p>コメントアイコン</p>
</td>
<td class="span9 td-right">
<input class="input-xxlarge" type="text" name="op[reply_icon]" placeholder="コメントアイコン" required value='<?php echo $skin->op->reply_icon;?>'>
<p class="help-block"></p>
</td>
</tr>
<tr>
<td class="span3 td-left">
<p>修正アイコン</p>
</td>
<td class="span9 td-right">
<input class="input-xxlarge" type="text" name="op[modify_icon]" placeholder="修正アイコン" required value='<?php echo $skin->op->modify_icon;?>'>
<p class="help-block"></p>
</td>
</tr>
<tr>
<td class="span3 td-left">
<p>削除アイコン</p>
</td>
<td class="span9 td-right">
<input class="input-xxlarge" type="text" name="op[del_icon]" placeholder="削除アイコン" required value='<?php echo $skin->op->del_icon;?>'>
<p class="help-block"></p>
</td>
</tr>
<tr>
<td class="span3 td-left">
<p>オプションアイコン</p>
</td>
<td class="span9 td-right">
<input class="input-xxlarge" type="text" name="op[op_icon]" placeholder="オプションアイコン" required value='<?php echo $skin->op->op_icon;?>'>
<p class="help-block"></p>
</td>
</tr>
<tr>
<td class="span3 td-left">
<p>絵の続きアイコン</p>
</td>
<td class="span9 td-right">
<input class="input-xxlarge" type="text" name="op[continue_icon]" placeholder="絵の続きアイコン" required value='<?php echo $skin->op->continue_icon;?>'>
<p class="help-block"></p>
</td>
</tr>
<tr>
<td class="span3 td-left">
<p>書き込みアイコン</p>
</td>
<td class="span9 td-right">
<input class="input-xxlarge" type="text" name="op[write_icon]" placeholder="書き込みアイコン" required value='<?php echo $skin->op->write_icon;?>'>
<p class="help-block"></p>
</td>
</tr>
<tr>
<td class="span3 td-left">
<p>Moreアイコン</p>
</td>
<td class="span9 td-right">
<input class="input-xxlarge" type="text" name="op[more_icon]" placeholder="Moreアイコン" required value='<?php echo $skin->op->more_icon;?>'>
<p class="help-block"></p>
</td>
</tr>
<tr>
<td class="span3 td-left">
<p>非公開アイコン</p>
</td>
<td class="span9 td-right">
<input class="input-xxlarge" type="text" name="op[secret_icon]" placeholder="非公開アイコン" required value='<?php echo $skin->op->secret_icon;?>'>
<p class="help-block"></p>
</td>
</tr>
<tr>
<td class="span3 td-left">
<p>ホームページアイコン</p>
</td>
<td class="span9 td-right">
<input class="input-xxlarge" type="text" name="op[hp_icon]" placeholder="ホームページアイコン" required value='<?php echo $skin->op->hp_icon;?>'>
<p class="help-block"></p>
</td>
</tr>
<tr>
<td class="span3 td-left">
<p>作成者アイコン</p>
</td>
<td class="span9 td-right">
<input class="input-xxlarge" type="text" name="op[painter_icon]" placeholder="作成者アイコン" required value='<?php echo $skin->op->painter_icon;?>'>
<p class="help-block"></p>
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
接続権限がありません.<br/>
掲示板管理者のみ接続可能なページです。<br/><br/>
<a class="btn btn-danger" href="javascript:history.go(-1);">もどる</a>
</div>
<?php
}
?>