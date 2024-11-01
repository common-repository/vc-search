<?php
require_once("../apifunc.php");// 共通関数読み込み
require_once("../apiclass.php");// classファイル読み込み
include_once('../../../../wp-load.php');//get_option

// linkshare 参加企業リスト（提携済み）取得
$lstoken= get_option('ls_search_token');
if ($lstoken=="") {$lstoken=LSTOKEN;}
$lsurl = "http://findadvertisers.linksynergy.com/merchantsearch?token=$lstoken";
$lsBuff = file_get_contents($lsurl);
$xml = simplexml_load_string ($lsBuff);
$lshits = $xml->midlist->merchant;

?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>VC Search ショートコード生成パネル（リンク生成・商品紹介）</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf8" />
	<script type="text/javascript" src="../tiny_mce_popup.js?ver=3241-1141"></script>
	<script type="text/javascript" src="panel.js?ver=327-1235"></script>
	<script type="text/javascript" src="../utils/mctabs.js?ver=327-1235"></script>
</head>
<body onresize="PasteLSDialog.resize();" style="display:none; overflow:hidden;">
<!--タブ-->
		<div class="tabs">
			<ul>
<li id="general_tab" class="current"><span><a href="javascript:mcTabs.displayTab('general_tab','general_panel');generatePreview();" onmousedown="return false;">リンクシェア</a></span></li>
<li id="vc_tab"><span><a href="javascript:mcTabs.displayTab('vc_tab','vc_panel');" onmousedown="return false;">バリューコマース</a></span></li>
<li id="ya_tab"><span><a href="javascript:mcTabs.displayTab('ya_tab','ya_panel');" onmousedown="return false;">ヤフーオクション</a></span></li>
<li id="ys_tab"><span><a href="javascript:mcTabs.displayTab('ys_tab','ys_panel');" onmousedown="return false;">ヤフーショッピング</a></span></li>
<li id="rk_tab"><span><a href="javascript:mcTabs.displayTab('rk_tab','rk_panel');" onmousedown="return false;">楽天市場</a></span></li>
<li id="am_tab"><span><a href="javascript:mcTabs.displayTab('am_tab','am_panel');" onmousedown="return false;">Amazon.co.jp</a></span></li>
<li id="at_tab"><span><a href="javascript:mcTabs.displayTab('at_tab','at_panel');" onmousedown="return false;">アクセストレード</a></span></li>
<li id="saiyasune_tab"><span><a href="javascript:mcTabs.displayTab('saiyasune_tab','saiyasune_panel');" onmousedown="return false;">最安値検索</a></span></li>
<li id="asinjan_tab"><span><a href="javascript:mcTabs.displayTab('asj na _tab','asinjan_panel');" onmousedown="return false;">Amazon商品詳細表示＆JANコード横断検索</a></span></li>
<li id="jalan_tab"><span><a href="javascript:mcTabs.displayTab('jalan_tab','jalan_panel');" onmousedown="return false;">じゃらんエリア検索</a></span></li>
<li id="googleco_tab"><span><a href="javascript:mcTabs.displayTab('googleco_tab','googleco_panel');" onmousedown="return false;">Googleカスタム検索</a></span></li>
<li id="chiebukuros_tab"><span><a href="javascript:mcTabs.displayTab('chiebukuros_tab','chiebukuros_panel');" onmousedown="return false;">Yahoo!知恵袋</a></span></li>
<li id="kensaku_tab"><span><a href="javascript:mcTabs.displayTab('kensaku_tab','kensaku_panel');" onmousedown="return false;">検索フォーム設置</a></span></li>
<li id="syoki_tab"><span><a href="javascript:mcTabs.displayTab('syoki_tab','shyoki_panel');" onmousedown="return false;">初期設定用[vcpage]</a></span></li>
				</ul>
			</div>
			
<div class="panel_wrapper">
<!--パネルリンクシェア-->
<div id="general_panel" class="panel current">
	<form name="source" onsubmit="return PasteLSDialog.insert();" action="#">
					<table border="0" cellpadding="4" cellspacing="0">
						<tr>
							<td class="nowrap"><label id="linktextlabel" for="title">リンクテキスト</label></td>
							<td><input id="linktext" name="linktext" type="text" value="" /></td>
						  </tr>
						  <tr>
							<td class="nowrap"><label id="keywordlabel" for="title">検索キーワード</label></td>
							<td><input id="keyword" name="keyword" type="text" value="" /></td>
						</tr>
						<tr>
							<td class="nowrap"><label id="ecsitelabel" for="title">ECサイト</label></td>
							<td><select id="mid"><option value="0" selected="selected">すべての提携済みECサイト</option>
						<?php foreach ($lshits as $hit) { ?>
						<option value="<?php echo h($hit->mid); ?>"><?php echo h($hit->merchantname); ?></option>
<?php } ?>
</select>
</td></tr>
							<tr>
							<td><label id="targetlistlabel" for="targetlist">並び順</label></td>
							<td id="targetlistcontainer"><select id="sort_type"><option value="0" selected="selected">参考価格の安い順</option><option value="1">参考価格の高い順</option></select></td>
						</tr>
						<tr>
							<td><label id="hyoujihouhou" for="targetlist">表示方法</label></td>
							<td id="hyoujihouhou２">
							<input type="radio" name="itemview" value="searchlink" id="searchlink" checked>検索リンク生成
							<input type="radio" name="itemview" value="entryitem" id="entryitem">エントリ内アイテム表示
							</td>
						</tr>
					</table>
		<div class="mceActionPanel">
			<div style="float: left">
				<input type="button" name="cancel" value="{#cancel}" onclick="tinyMCEPopup.close();" id="cancel" />
			</div>

			<div style="float: right">
				<input type="submit" name="insert" value="{#insert}" id="insert" />
			</div>
		</div>
		</form>
	</div>
<!--パネル:バリューコマース-->
<div id="vc_panel" class="panel">
<form name="source" onsubmit="return PasteVCDialog.insert();" action="#">
					<table border="0" cellpadding="4" cellspacing="0">
						<tr>
							<td class="nowrap"><label id="vclinktextlabel" for="title">リンクテキスト</label></td>
							<td><input id="vclinktext" name="vclinktext" type="text" value="" /></td>
						  </tr>
						  <tr>
							<td class="nowrap"><label id="vckeywordlabel" for="title">検索キーワード</label></td>
							<td><input id="vckeyword" name="vckeyword" type="text" value="" /></td>
						</tr>
						<tr>
							<td><label id="vctargetlistlabel" for="targetlist">カテゴリー</label></td>
							<td id="vctargetlistcontainer"><select id="vccategory" name="vccategory"><option value="">すべての商品</option><option value="computers">コンピュータ</option><option value="electronics">家電、AV機器</option><option value="music">音楽、CD</option><option value="books">本、コミック</option><option value="dvd">DVD</option><option value="fooddrink">フード、ドリンク</option><option value="fashion">ファッション、アクセサリー</option><option value="beautys">美容、健康</option><option value="toysgameshobbies">おもちゃ、ホビー</option><option value="recreationoutdoor">レジャー、アウトドア</option><option value="homeinterior">生活、インテリア</option><option value="babymaternity">ベビー、キッズ、マタニティ</option><option value="officesupplies">ビジネス、ステーショナリー</option></select></td>
						</tr>
						<tr>
							<td><label id="vctargetlistlabel2" for="targetlist">並び順</label></td>
							<td id="vctargetlistcontainer2"><select name="vcsort_type" id="vcsort_type"><option value="0" selected="selected">スコア順</option><option value="1">価格の高い順</option><option value="2">価格の安い順</option><option value="3">今日の売れ筋順</option><option value="4">週間の売れ筋順</option><option value="5">月間の売れ筋順</option></select></form></td>
						</tr>
							<tr>
							<td><label id="vchyoujihouhou" for="targetlist">表示方法</label></td>
							<td id="vchyoujihouhou２">
							<input type="radio" name="vcitemview" value="vcsearchlink" id="vcsearchlink" checked>検索リンク生成
							<input type="radio" name="vcitemview" value="vcentryitem" id="vcentryitem">エントリ内アイテム表示
							</td>
						</tr>
					</table>

		<div class="mceActionPanel">
			<div style="float: left">
				<input type="button" name="cancel" value="{#cancel}" onclick="tinyMCEPopup.close();" id="cancel" />
			</div>

			<div style="float: right">
				<input type="submit" name="insert" value="{#insert}" id="insert" />
			</div>
		</div>
	</form>
	</div>
<!--パネル:ヤフオク-->
<div id="ya_panel" class="panel">
	<form name="source" onsubmit="return PasteYADialog.insert();" action="#">
					<table border="0" cellpadding="4" cellspacing="0">
						<tr>
							<td class="nowrap"><label id="yalinktextlabel" for="title">リンクテキスト</label></td>
							<td><input id="yalinktext" name="yalinktext" type="text" value="" /></td>
						  </tr>
						  <tr>
							<td class="nowrap"><label id="yakeywordlabel" for="title">検索キーワード</label></td>
							<td><input id="yakeyword" name="yakeyword" type="text" value="" /></td>
						</tr>
						<tr>
							<td><label id="yatargetlistlabel" for="targetlist">並び順</label></td>
							<td id="yatargetlistcontainer"><select id="yasort_type"><option value="0" selected="selected">終了時間が近い順</option><option value="1">入札数が多い順</option><option value="2">現在価格安い順</option><option value="3">現在価格高い順</option><option value="4">即決価格安い順</option></select></td>
						</tr>
					</table>
		<div class="mceActionPanel">
			<div style="float: left">
				<input type="button" name="cancel" value="{#cancel}" onclick="tinyMCEPopup.close();" id="cancel" />
			</div>

			<div style="float: right">
				<input type="submit" name="insert" value="{#insert}" id="insert" />
			</div>
		</div>
	</form>
	</div>
	
<!--パネル:ヤフーショッピング-->
<div id="ys_panel" class="panel">
	<form name="source" onsubmit="return PasteYSDialog.insert();" action="#">
					<table border="0" cellpadding="4" cellspacing="0">
						<tr>
							<td class="nowrap"><label id="yslinktextlabel" for="title">リンクテキスト</label></td>
							<td><input id="yslinktext" name="yslinktext" type="text" value="" /></td>
						  </tr>
						  <tr>
							<td class="nowrap"><label id="yskeywordlabel" for="title">検索キーワード</label></td>
							<td><input id="yskeyword" name="yskeyword" type="text" value="" /></td>
						</tr>
						<tr>
							<td><label id="ystargetlistlabel" for="targetlist">並び順</label></td>
							<td id="ystargetlistcontainer"><select id="yssort_type">
							<option value="0" selected="selected">商品価格安い順</option>
							<option value="1">商品価格高い順</option>
							<option value="2">おすすめ順</option>
							<option value="3">売れ筋順</option>
							<option value="4">アフィリエイト料率が高い順</option>
							<option value="5">レビュー件数が多い順</option>
							</select></td>
						</tr>
					</table>


		<div class="mceActionPanel">
			<div style="float: left">
				<input type="button" name="cancel" value="{#cancel}" onclick="tinyMCEPopup.close();" id="cancel" />
			</div>

			<div style="float: right">
				<input type="submit" name="insert" value="{#insert}" id="insert" />
			</div>
		</div>
	</form>
	</div>
	
<!--パネル:楽天市場-->
<div id="rk_panel" class="panel">
	<form name="source" onsubmit="return PasteRKDialog.insert();" action="#">
					<table border="0" cellpadding="4" cellspacing="0">
						<tr>
							<td class="nowrap"><label id="rklinktextlabel" for="title">リンクテキスト</label></td>
							<td><input id="rklinktext" name="rklinktext" type="text" value="" /></td>
						  </tr>
						  <tr>
							<td class="nowrap"><label id="rkkeywordlabel" for="title">検索キーワード</label></td>
							<td><input id="rkkeyword" name="rkkeyword" type="text" value="" /></td>
						</tr>
						<tr>
							<td><label id="rktargetlistlabel" for="targetlist">ジャンル</label></td>
							<td id="rktargetlistcontainer"><select id="rkcategory" name="rkcategory"><option value="0">すべての商品</option><option value="101240">CD・DVD・楽器</option><option value="100804">インテリア・寝具・収納</option><option value="101164">おもちゃ・ホビー・ゲーム</option><option value="100533">キッズ・ベビー・マタニティ</option><option value="215783">キッチン・日用品雑貨・文具</option><option value="216129">ジュエリー・腕時計</option><option value="101070">スポーツ・アウトドア</option><option value="100938">ダイエット・健康</option><option value="100316">水・ソフトドリンク</option><option value="100026">水・ソフトドリンク</option><option value="100026">パソコン・周辺機器</option><option value="216131">バッグ・小物・ブランド雑貨</option><option value="100371">レディースファッション・靴</option><option value="100005">花・ガーデン・DIY</option><option value="101213">ペット・ペットグッズ</option><option value="211742">家電・AV・カメラ</option><option value="101114">車・バイク</option><option value="100227">食品</option><option value="100939">美容・コスメ・香水</option><option value="200162">本・雑誌・コミック</option><option value="101381">旅行・出張・チケット</option><option value="200163">不動産・住まい</option><option value="101438">学び・サービス・保険</option><option value="100000">百貨店・総合通販・ギフト</option><option value="402853">デジタルコンテンツ</option><option value="503190">車用品・バイク用品</option><option value="100433">インナー・下着・ナイトウエア</option><option value="510901">日本酒・焼酎</option><option value="510915">ビール・洋酒</option><option value="551167">スイーツ</option><option value="551169">医薬品・コンタクト・介護</option><option value="551177">メンズファッション・靴</option></select></td>
						</tr>
						<tr>
							<td><label id="rktargetlistlabel2" for="targetlist">並び順</label></td>
							<td id="rktargetlistcontainer2"><select name="rksort_type" id="rksort_type"><option value="0">楽天標準ソート順</option><option value="1">アフィリエイト料率順（昇順）</option><option value="2">アフィリエイト料率順（降順）</option><option value="3">レビュー件数順（昇順）</option><option value="4">レビュー件数順（降順）</option><option value="5">価格順（昇順）</option><option value="6">価格順（降順）</option><option value="7">価商品更新日時順（昇順）</option><option value="8">商品更新日時順（降順）</option></select></td>
						</tr>
						<tr>
							<td><label id="rakutenhyoujihouhou" for="targetlist">表示方法</label></td>
							<td id="rakutenhyoujihouhou２">
							<input type="radio" name="itemview" value="searchlink" id="rakutensearchlink" checked>検索リンク生成
							<input type="radio" name="itemview" value="entryitem" id="rakutenentryitem">エントリ内アイテム表示
							</td>
						</tr>
					</table>

		<div class="mceActionPanel">
			<div style="float: left">
				<input type="button" name="cancel" value="{#cancel}" onclick="tinyMCEPopup.close();" id="cancel" />
			</div>

			<div style="float: right">
				<input type="submit" name="insert" value="{#insert}" id="insert" />
			</div>
		</div>
	</form>
	</div>

	<!--パネル:Amazon-->
	<?php
	$Amazonitemsearchtapi= new Amazonitemsearchtapi();
	$arr_categories = $Amazonitemsearchtapi->arr_categories;
	$arr_sorts =$Amazonitemsearchtapi->arr_sorts;
	?>
<div id="am_panel" class="panel">
	<form name="source" onsubmit="return PasteAMDialog.insert();" action="#">
					<table border="0" cellpadding="4" cellspacing="0">
						<tr>
							<td class="nowrap"><label id="amlinktextlabel" for="title">リンクテキスト</label></td>
							<td><input id="amlinktext" name="amlinktext" type="text" value="" /></td>
						  </tr>
						  <tr>
							<td class="nowrap"><label id="amkeywordlabel" for="title">検索キーワード</label></td>
							<td><input id="amkeyword" name="amkeyword" type="text" value="" /></td>
						</tr>
						<tr>
<!--							<td><label id="amcategorylistlabel" for="targetlist">カテゴリー</label></td>
							<td id="categorylistcontainer"><?php echo DrawSelectMenu("amcategory", $arr_categories, $v_category,""); ?>
							</td>
						</tr>
						<tr>
							<td><label id="amtargetlistlabel2" for="targetlist">並び順</label></td>
							<td id="amtargetlistcontainer2"><?php echo DrawSelectMenu("amsort_type", $arr_sorts, $v_sort_type,""); ?></td>
						</tr>-->
							<tr>
							<td><label id="amazonhyoujihouhou" for="targetlist">表示方法</label></td>
							<td id="amazonhyoujihouhou2">
							<input type="radio" name="itemview" value="searchlink" id="amazonsearchlink" checked>検索リンク生成
							<input type="radio" name="itemview" value="entryitem" id="amazonentryitem">エントリ内アイテム表示
							</td>
						</tr>
					</table>

		<div class="mceActionPanel">
			<div style="float: left">
				<input type="button" name="cancel" value="{#cancel}" onclick="tinyMCEPopup.close();" id="cancel" />
			</div>

			<div style="float: right">
				<input type="submit" name="insert" value="{#insert}" id="insert" />
			</div>
		</div>
	</form>
	</div>



<!--パネル:アクセストレード-->
<div id="at_panel" class="panel">
	<form name="source" onsubmit="return PasteATDialog.insert();" action="#">
					<table border="0" cellpadding="4" cellspacing="0">
						<tr>
							<td class="nowrap"><label id="atlinktextlabel" for="title">リンクテキスト</label></td>
							<td><input id="atlinktext" name="atlinktext" type="text" value="" /></td>
						  </tr>
						  <tr>
							<td class="nowrap"><label id="atkeywordlabel" for="title">検索キーワード</label></td>
							<td><input id="atkeyword" name="atkeyword" type="text" value="" /></td>
						</tr>
						<tr>
							<td><label id="attargetlistlabel" for="targetlist">並び順</label></td>
							<td id="attargetlistcontainer"><select id="atsort_type"><option value="0" selected="selected">参考価格の安い順</option><option value="1">参考価格の高い順</option></option></select></td>
						</tr>
					</table>


		<div class="mceActionPanel">
			<div style="float: left">
				<input type="button" name="cancel" value="{#cancel}" onclick="tinyMCEPopup.close();" id="cancel" />
			</div>

			<div style="float: right">
				<input type="submit" name="insert" value="{#insert}" id="insert" />
			</div>
		</div>
	</form>
</div>


<!--パネル:最安値-->
<div id="saiyasune_panel" class="panel">
<form name="source" onsubmit="return PasteSaiyasuneDialog.insert();" action="#">
					<table border="0" cellpadding="4" cellspacing="0">
						<tr>
							<td class="nowrap"><label id="saiyasunelinktextlabel" for="title">検索キーワード</label></td>
							<td><input id="saiyasunekeyword" name="saiyasunekeyword" type="text" value="" /></td>
						  </tr>
						  <tr>
							<td class="nowrap"><label id="saiyasunengkeywordlabel" for="title">NGキーワード</label></td>
							<td><input id="saiyasunengkeyword" name="saiyasunengkeyword" type="text" value="" /></td>
						</tr>
						  <tr>
							<td class="nowrap"><label id="saiyasunekeywordlabel" for="title">JANコード</label></td>
							<td><input id="saiyasunejancode" name="saiyasunejancode" type="text" value="" /></td>
						</tr>
					</table>

		<div class="mceActionPanel">
			<div style="float: left">
				<input type="button" name="cancel" value="{#cancel}" onclick="tinyMCEPopup.close();" id="cancel" />
			</div>

			<div style="float: right">
				<input type="submit" name="insert" value="{#insert}" id="insert" />
			</div>
		</div>
	</form>
	</div>


<!--パネル:Amazon detail to jancode Oudan Search, Keyword Auction Search-->
<div id="asinjan_panel" class="panel">
<form name="source" onsubmit="return PasteAsinjanDialog.insert();" action="#">
					<table border="0" cellpadding="4" cellspacing="0">
						  <tr>
							<td class="nowrap"><label id="asincodelabel" for="title">ASINコード</label></td>
							<td><input id="asincode" name="asincode" type="text" value="" /><!--<br />
							Amazon.co.jpのASINコードからAmazonの商品詳細情報を取得、またそこから得られたJANコードから他のアフィリエイトASPやECサイトを横断検索をし、同じ商品が買えるお店をリストアップします。--></td>
						</tr>
						<tr>
							<td class="nowrap"><label id="asinkeywordlabel" for="title">検索キーワード</label></td>
							<td><input id="asinkeyword" name="asinkeyword" type="text" value="" /><!--<br />
							ヤフオクで検索するためのキーワードです。アマゾンと同じ商品名でも良いですが、少し加工することにより、引っ掛かり易くなります。--></td>
						</tr>
					</table>

		<div class="mceActionPanel">
			<div style="float: left">
				<input type="button" name="cancel" value="{#cancel}" onclick="tinyMCEPopup.close();" id="cancel" />
			</div>

			<div style="float: right">
				<input type="submit" name="insert" value="{#insert}" id="insert" />
			</div>
		</div>
	</form>
	</div>

<!--パネル:じゃらん-->
<div id="jalan_panel" class="panel">
	<form name="source" onsubmit="return PasteJalanDialog.insert();" action="#">
じゃらんのエリア絞り込み検索メニュー（javascript）をここに挿入しますか？

		<div class="mceActionPanel">
			<div style="float: left">
				<input type="button" name="cancel" value="{#cancel}" onclick="tinyMCEPopup.close();" id="cancel" />
			</div>

			<div style="float: right">
				<input type="submit" name="insert" value="{#insert}" id="insert" />
			</div>
		</div>
	</form>
</div>

<!--パネル:Googleカスタム検索-->
<div id="googleco_panel" class="panel">
	<form name="source" onsubmit="return PastegooglecoDialog.insert();" action="#">

					<table border="0" cellpadding="4" cellspacing="0">
						  <tr>
							<td class="nowrap"><label id="googlecolabel" for="title">Google検索キーワード</label></td>
							<td><input id="googlecokeyword" name="googlecokeyword" type="text" value="" /></td>
						</tr>
					</table>
		<div class="mceActionPanel">
			<div style="float: left">
				<input type="button" name="cancel" value="{#cancel}" onclick="tinyMCEPopup.close();" id="cancel" />
			</div>

			<div style="float: right">
				<input type="submit" name="insert" value="{#insert}" id="insert" />
			</div>
		</div>
	</form>
</div>


<!--パネル:Yahoo!知恵袋検索-->
<div id="chiebukuros_panel" class="panel">
	<form name="source" onsubmit="return PastechiebukurosDialog.insert();" action="#">

					<table border="0" cellpadding="4" cellspacing="0">
						  <tr>
							<td class="nowrap"><label id="chiebukuroslabel" for="title">YAHOO!知恵袋　質問キーワード</label></td>
							<td><input id="chiebukuroskeyword" name="chiebukuroskeyword" type="text" value="" /></td>
						</tr>
						<tr>
							<td><label id="chiebukuroslabel2" for="targetlist">表示数</label></td>
							<td id="chiebukurosselect"><select id="chiebukurosresults"><option value="1" selected="selected">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option><option value="6">6</option><option value="7">7</option><option value="8">8</option><option value="9">9</option><option value="10">10</option></select></td>
						</tr>
						<tr>
							<td><label id="charnumslabel3" for="charnum">表示文字数</label></td>
							<td id="charnumtd"><select id="charnum"><option value="1" selected="selected">100文字</option><option value="2">200文字</option><option value="3">300文字</option><option value="4">全文</option></select></td>
						</tr>
					</table>
		<div class="mceActionPanel">
			<div style="float: left">
				<input type="button" name="cancel" value="{#cancel}" onclick="tinyMCEPopup.close();" id="cancel" />
			</div>

			<div style="float: right">
				<input type="submit" name="insert" value="{#insert}" id="insert" />
			</div>
		</div>
	</form>
</div>

<!--パネル:初期設定-->
<div id="shyoki_panel" class="panel">
	<form name="source" onsubmit="return PastesyokiDialog.insert();" action="#">
	商品検索結果ページを生成するコード[vcpage]を埋め込みます。
	新規ページ作成し、下記ボタンを押して挿入してください。完了後、管理画面からのこのページのURLを入力してください。
		<div class="mceActionPanel">
			<div style="float: left">
				<input type="button" name="cancel" value="{#cancel}" onclick="tinyMCEPopup.close();" id="cancel" />
			</div>

			<div style="float: right">
				<input type="submit" name="insert" value="{#insert}" id="insert" />
			</div>
		</div>
	</form>
</div>

<!--パネル:検索フォーム設置-->
<div id="kensaku_panel" class="panel">
	<form name="source" onsubmit="return PastekensakuDialog.insert();" action="#">
	商品検索フォームを設置します。準備中。

		<div class="mceActionPanel">
			<div style="float: left">
				<input type="button" name="cancel" value="{#cancel}" onclick="tinyMCEPopup.close();" id="cancel" />
			</div>

			<div style="float: right">
				<input type="submit" name="insert" value="{#insert}" id="insert" />
			</div>
		</div>
	</form>
</div>
	
</div>
<img border="0" width="1" height="1" src="http://ad.linksynergy.com/fs-bin/show?id=GSFNlAS0O*w&bids=186984.200060&type=3&subid=0">
</body>
</html>
