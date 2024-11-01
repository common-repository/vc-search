<?php
/*
VC Search API class by wackey
*/

/*  Copyright 2009-2010 wackey

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/


/***----------------------------------------------------
　APIアクセス時の参照データ、リクエストURL組み立て補助
----------------------------------------------------***/

// ■バリューコマース商品検索API

class valuecommerceapi {

// ソート順番を配列に代入
public $arr_sorts = array(
	"0" => "スコア順", 
	"1" => "価格の高い順", 
	"2" => "価格の安い順" ,
	"3" => "今日の売れ筋順", 
	"4" => "週間の売れ筋順" ,
	"5" => "月間の売れ筋順" 
    );

// カテゴリーを配列に代入
public $arr_categories = array(
	""         => "すべてのカテゴリー", 
	"computers"         => "コンピュータ", 
	"electronics"       => "家電、AV機器", 
	"music"             => "音楽、CD", 
	"books"             => "本、コミック", 
	"dvd"               => "DVD", 
	"fooddrink"         => "フード、ドリンク", 
	"fashion"           => "ファッション、アクセサリー", 
	"beautys"           => "美容、健康", 
	"toysgameshobbies"  => "おもちゃ、ホビー", 
	"recreationoutdoor" => "レジャー、アウトドア", 
	"homeinterior"      => "生活、インテリア", 
	"babymaternity"     => "ベビー、キッズ、マタニティ", 
	"officesupplies"    => "ビジネス、ステーショナリー"
    );

function vcsort ($v_sort_type,&$v_sort_by,&$v_sort_order,&$v_sort_rank) {
    // 並べ順の選択肢からパラメータを設定
    switch ($v_sort_type) {
    case 0:
	    $v_sort_by = "score";
	    $v_sort_order = "asc";
	    break;
    case 1: //価格安い順
	    $v_sort_by = "price";
	    $v_sort_order = "desc";
	    break;
    case 2: //価格高い順
	    $v_sort_by = "price";
	    $v_sort_order = "asc";
	    break;
    case 3: //今日の売れ筋順
	    $v_sort_rank = "dayly";
	    break;
    case 4: //週間の売れ筋順
	    $v_sort_rank = "weekly";
	    break;
    case 5: //月間の売れ筋順
	    $v_sort_rank = "monthly";
	    break;
    default:
	break;
    }
}

} //class valuecommerceapi end


class linkshareitemsearchapi {

// ソート順番を配列に代入
public $arr_sorts = array(
	"0" => "参考価格の安い順", 
	"1" => "参考価格の高い順"
    );

function linksheresort ($ls_sort_type,&$ls_sort_order) {
    // 並べ順の選択肢からパラメータを設定
	switch ($ls_sort_type) {
	case 0:
	$ls_sort_order = "asc";
	break;
	case 1: //価格安い順
	$ls_sort_order = "dsc";
	break;
	default:
	break;
	}
}

} //class linkshareitemsearchapi end

// ■楽天市場商品検索API

class rakutenichibaapi {

// ソート順番を配列に代入
public $arr_sorts = array(
	"0" => "楽天標準ソート順", 
	"3" => "レビュー件数順（昇順）", 
	"4" => "レビュー件数順（降順）" ,
	"5" => "価格順（昇順）", 
	"6" => "価格順（降順）" ,
	"7" => "商品更新日時順（昇順）", 
	"8" => "商品更新日時順（降順）" 
    );

// 管理画面用ソート順番を配列に代入
public $arr_sorts_admin = array(
	"0" => "楽天標準ソート順", 
	"1" => "アフィリエイト料率順（昇順）", 
	"2" => "アフィリエイト料率順（降順）", 
	"3" => "レビュー件数順（昇順）", 
	"4" => "レビュー件数順（降順）" ,
	"5" => "価格順（昇順）", 
	"6" => "価格順（降順）" ,
	"7" => "商品更新日時順（昇順）", 
	"8" => "商品更新日時順（降順）" 
    );

// カテゴリーを配列に代入
public $arr_categories = array(
	"0"=>"すべての商品",
	"101240"=>"CD・DVD・楽器",
	"100804"=>"インテリア・寝具・収納",
	"101164"=>"おもちゃ・ホビー・ゲーム",
	"100533"=>"キッズ・ベビー・マタニティ",
	"215783"=>"キッチン・日用品雑貨・文具",
	"216129"=>"ジュエリー・腕時計",
	"101070"=>"スポーツ・アウトドア",
	"100938"=>"ダイエット・健康",
	"100316"=>"水・ソフトドリンク",
	"100026"=>"水・ソフトドリンク",
	"100026"=>"パソコン・周辺機器",
	"216131"=>"バッグ・小物・ブランド雑貨",
	"100371"=>"レディースファッション・靴",
	"100005"=>"花・ガーデン・DIY",
	"101213"=>"ペット・ペットグッズ",
	"211742"=>"家電・AV・カメラ",
	"101114"=>"車・バイク",
	"100227"=>"食品",
	"100939"=>"美容・コスメ・香水",
	"200162"=>"本・雑誌・コミック",
	"101381"=>"旅行・出張・チケット",
	"200163"=>"不動産・住まい",
	"101438"=>"学び・サービス・保険",
	"100000"=>"百貨店・総合通販・ギフト",
	"402853"=>"デジタルコンテンツ",
	"503190"=>"車用品・バイク用品",
	"100433"=>"インナー・下着・ナイトウエア",
	"510901"=>"日本酒・焼酎",
	"510915"=>"ビール・洋酒",
	"551167"=>"スイーツ",
	"551169"=>"医薬品・コンタクト・介護",
	"551177"=>"メンズファッション・靴",
    );

function rakutensort ($rakuten_sort_type,&$rakuten_sort_order) {
    // 並べ順の選択肢からパラメータを設定
    switch ($rakuten_sort_type) {
    case 0: //楽天標準ソート順
	    $rakuten_sort_order  = "standard";
	    break;
    case 1: //アフィリエイト料率順（昇順）
	    $rakuten_sort_order = "+affiliateRate";
	    break;
    case 2: //アフィリエイト料率順（降順）
	    $rakuten_sort_order  = "-affiliateRate";
	    break;
    case 3: //レビュー件数順（昇順）
	    $rakuten_sort_order  = "+reviewCount";
	    break;
    case 4: //レビュー件数順（降順）
	    $rakuten_sort_order  = "-reviewCount";
	    break;
    case 5: //価格順（昇順）
	    $rakuten_sort_order  = "+itemPrice";
	    break;
    case 6: //価格順（降順）
	    $rakuten_sort_order  = "-itemPrice";
	    break;
    case 7: //商品更新日時順（昇順）
	    $rakuten_sort_order  = "+updateTimestamp";
	    break;
    case 8: //商品更新日時順（降順）
	    $rakuten_sort_order  = "-updateTimestamp";
	    break;
    default:
	    break;
    }
}



} //class rakutenichibaapi end


// ■ヤフーショッピング商品検索API

class yahooshoppingapi {

// ソート順を配列に代入
public $arr_sorts = array(
	"-score" => "おすすめ順",
	"%2Bprice" => "商品価格が安い順",
	"-price" => "商品価格が高い順",
	"%2Bname" => "ストア名昇順",
	"-name" => "ストア名降順",
	"-sold" => "売れ筋順"
);

// カテゴリーを配列に代入
public $arr_categories = array(
	 "1" => "すべてのカテゴリから",
	 "13457" => "ファッション",
	 "2498" => "食品",
	 "2500" => "ダイエット、健康",
	 "2501" => "コスメ、香水",
	 "2502" => "パソコン、周辺機器",
	 "2504" => "AV機器、カメラ",
	 "2505" => "家電",
	 "2506" => "家具、インテリア",
	 "2507" => "花、ガーデニング",
	 "2508" => "キッチン、生活雑貨、日用品",
	 "2503" => "DIY、工具、文具",
	 "2509" => "ペット用品、生き物",
	 "2510" => "楽器、趣味、学習",
	 "2511" => "ゲーム、おもちゃ",
	 "2497" => "ベビー、キッズ、マタニティ",
	 "2512" => "スポーツ",
	 "2513" => "レジャー、アウトドア",
	 "2514" => "自転車、車、バイク用品",
	 "2516" => "CD、音楽ソフト",
	 "2517" => "DVD、映像ソフト",
	 "10002" => "本、雑誌、コミック"
);

function yshsort ($v_sort_type,&$v_sort_order) {
    // 並べ順の選択肢からパラメータを設定
    switch ($v_sort_type) {
    case 0://商品価格安い順
	    $v_sort_order = "%2Bprice";
	    break;
    case 1: //商品価格高い順
	    $v_sort_order = "-price";
	    break;
    case 2: //おすすめ順
	    $v_sort_order = "-score";
	    break;
    case 3: //売れ筋順
	    $v_sort_order = "-sold";
	    break;
    case 4: //アフィリエイト料率が高い順
	    $v_sort_order = "-affiliate";
	    break;
    case 5: //レビュー件数が多い順
	    $v_sort_order = "-review_count";
	    break;
    default:
	    break;
    }
}// function yshsort


}


// ■ヤフオクオークション検索API

class yahooauctionapi {

// ソート順を配列に代入
public $arr_sorts = array(
	"0" => "終了間際順",
	"1" => "入札数が多い順",
	"2" => "現在価格安い順",
	"3" => "現在価格高い順",
	"4" => "即決価格安い順"
);

function yaucsort ($v_sort_type,&$v_sort_by,&$v_sort_order) {
    switch ($v_sort_type) {
    case 0://終了間際順
	    $v_sort_by = "end";
	    $v_sort_order = "a";//昇順
	    break;
    case 1: //入札数が多い順
	    $v_sort_by = "bids";
	    $v_sort_order = "d";
	    break;
    case 2: //現在価格安い順
	    $v_sort_by = "cbids";
	    $v_sort_order = "a";
	    break;
    case 3: //現在価格高い順
	    $v_sort_by = "cbids";
	    $v_sort_order = "d";
	    break;
    case 4: //即決価格安い順
	    $v_sort_by = "bidorbuy";
	    $v_sort_order = "a";
	    break;
    default:
	    break;
    }
}

} // class yahooaucapi


// ■Amazon.co.jp商品検索API

class Amazonitemsearchtapi {

// カテゴリーを配列に代入
public $arr_categories = array(
	"All"         => "全て", 
	"Apparel"       => "アパレル", 
	"Baby"             => "ベビー＆マタニティ", 
	"Beauty"             => "コスメ", 
	"Books"               => "本(和書)", 
	"Classical"         => "クラシック音楽", 
	"DVD"           => "DVD", 
	"Electronics"           => "エレクトロニクス", 
	"ForeignBooks"  => "洋書", 
	"Grocery" => "食品", 
	"HealthPersonalCare"      => "ヘルスケア", 
	"Hobbies"     => "ホビー", 
	"Jewelry"    => "ジュエリー",
	"Kitchen"    => "ホーム＆キッチン",
	"Music"    => "ミュージック",
	"MusicTracks"    => "曲名",
	"Software"    => "ソフトウェア",
	"SportingGoods"    => "スポーツ＆アウトドア",
	"Toys"    => "おもちゃ",
	"VHS"    => "VHS",
	"Video"    => "ビデオ",
	"VideoGames"    => "ゲーム",
	"Watches"    => "時計"
);

// ソート順番を配列に代入
public $arr_sorts = array(
	"0" => "価格の安い順番", 
	"1" => "価格の高い順番", 
	"2" => "売れ筋ランキング順",
    );


// Amazonソート順
function amazonsort ($v_sort_type,&$v_sort_order,$v_category) {
    // 並べ順の選択肢からパラメータを設定
    switch ($v_sort_type) {
    case 0://商品価格安い順
	    $v_sort_order = "price";
	    if ($v_category=="Books"|$v_category=="Classical"|$v_category=="DVD"|$v_category=="ForeignBooks"|$v_category=="Music"|$v_category=="VHS"|$v_category=="Video") {$v_sort_order = "pricerank";}
	    break;
    case 1: //商品価格高い順
	    $v_sort_order = "-price";
	    if ($v_category=="Books"|$v_category=="ForeignBooks") {$v_sort_order = "inverse-pricerank";}
	    if ($v_category=="Classical"|$v_category=="DVD"|$v_category=="Music"|$v_category=="VHS"|$v_category=="Video") {$v_sort_order = "-pricerank";}
	    break;
    case 2: //売れ筋ランキング順
	    $v_sort_order = "salesrank";
	    if ($v_category=="Beauty") {$v_sort_order = "reviewrank";}
	    break;
    default:
	    break;
    }// stich
}// function amazonsort


// ■Amazon用セレクトメニュー作成：<select>タグによるメニュー描画、パラメータから選択されているものを選択状態にする。
// select name、select option配列、選択、オプション
function DrawSelectMenu2($name, $source_arr, $select_value) {
	$menu = "<select name=\"$name\">";
	foreach($source_arr as $key => $value) {
		$menu .= "<option value=\"$key\"";
		if ($key == $select_value) {
			$menu .= " selected";
		}
		$menu .= ">$value</option>";
	}
	$menu .= "</select>";
	return $menu;
}



// 商品キーワード検索リクエストURL組み立て関数ItemSearch
function awsrequesturl($v_category,$v_keyword,$v_sort_order,$v_page) {
$amzacckey=get_option('amzacckey');
if ($amzacckey==="") {$amzacckey==AMZACCKEY;}
$amzseckey=get_option('amzseckey');
if ($amzacckey==="") {$amzacckey==AMZSECKEY;}
$amzassid=get_option('amzassid');
if ($amzassid==="") {$amzassid==AMZASSID;}

$baseurl = 'http://ecs.amazonaws.jp/onca/xml';
$params = array();
$params['Service']        = 'AWSECommerceService';
$params['AWSAccessKeyId'] = $amzacckey;
$params['Version']        = '2009-10-01';
$params['Operation']      = 'ItemSearch';
$params['SearchIndex']    = $v_category;
//$params['asin']       = $asin;
$params['Keywords']       = $v_keyword;
if (!$v_category=="All") {
$params['Sort']       = $v_sort_order;
}
$params['AssociateTag']   = $amzassid;
$params['ContentType']   = 'text/xml';
$params['ResponseGroup']   = 'Medium,Reviews,OfferSummary';
$params['ItemPage']   = $v_page;
$params['Timestamp'] = gmdate('Y-m-d\TH:i:s\Z');
// パラメータの順序を昇順に並び替えます
ksort($params);
$canonical_string = '';
foreach ($params as $k => $v) {
    $canonical_string .= '&'.urlencode_rfc3986($k).'='.urlencode_rfc3986($v);
}
$canonical_string = substr($canonical_string, 1);

$parsed_url = parse_url($baseurl);
$string_to_sign = "GET\n{$parsed_url['host']}\n{$parsed_url['path']}\n{$canonical_string}";
$signature = base64_encode(hash_hmac('sha256', $string_to_sign, $amzseckey, true));
$awsurl = $baseurl.'?'.$canonical_string.'&Signature='.urlencode_rfc3986($signature);
return $awsurl;
}


// 商品詳細情報リクエストURL組み立て関数ItemLookup
function Awsitemlookupurl($asinno) {

$amzacckey=get_option('amzacckey');
if ($amzacckey==="") {$amzacckey==AMZACCKEY;}
$amzseckey=get_option('amzseckey');
if ($amzacckey==="") {$amzacckey==AMZSECKEY;}
$amzassid=get_option('amzassid');
if ($amzassid==="") {$amzassid==AMZASSID;}

$baseurl = 'http://ecs.amazonaws.jp/onca/xml';
$params = array();
$params['Service']        = 'AWSECommerceService';
$params['AWSAccessKeyId'] = $amzacckey;
$params['Version']        = '2009-10-01';
$params['Operation']      = 'ItemLookup';
$params['ItemId']       = $asinno;
$params['AssociateTag']   = $amzassid;
$params['Condition']   = 'New';
$params['ContentType']   = 'text/xml';
$params['ResponseGroup']   = 'Large,Tracks';
$params['Timestamp'] = gmdate('Y-m-d\TH:i:s\Z');
// パラメータの順序を昇順に並び替えます
ksort($params);
$canonical_string = '';
foreach ($params as $k => $v) {
    $canonical_string .= '&'.urlencode_rfc3986($k).'='.urlencode_rfc3986($v);
}
$canonical_string = substr($canonical_string, 1);
$parsed_url = parse_url($baseurl);
$string_to_sign = "GET\n{$parsed_url['host']}\n{$parsed_url['path']}\n{$canonical_string}";
$signature = base64_encode(hash_hmac('sha256', $string_to_sign, $amzseckey, true));
$awsurl = $baseurl.'?'.$canonical_string.'&Signature='.urlencode_rfc3986($signature);
return $awsurl;
}

} // class Amazonproductapi


/***----------------------------------------------------
　並列通信（価格比較等）ロジック
----------------------------------------------------***/

// ■商品検索横断検索：並列通信クラス

class heiretsuapi {

// 並列通信処理（安い順）

function heiretsuget($keyword,$ngword,$jancode,&$xml_ywsurl,&$xml_rwsurl,&$xml_lsurl,&$xml_vcurl,&$xml_aturl,&$xml_awsurl,&$xml_yacurl) {

// データベースから設定情報を読み込む
$vctoken= get_option('vc_search_token');
if ($vctoken=="") {$vctoken=VCTOKEN;}
$vcpagepage= get_option('vc_search_page');
if ($vcpagepage=="") {$vcpagepage=VCPAGEPAGE;}
$vc_yahoo_appid= get_option('vc_yahoo_appid');
if ($vc_yahoo_appid=="") {$vc_yahoo_appid=VC_YAHOO_APPID;}
$lstoken= get_option('ls_search_token');
if ($lstoken=="") {$lstoken=LSTOKEN;}
$jalantoken= get_option('jalan_search_token');
if ($jalantoken=="") {$jalantoken=JALANTOKEN;}
$jalan_pid= get_option('jalan_pid');
if ($jalan_pid=="") {$jalan_pid=JALAN_PID;}
$jalan_sid= get_option('jalan_sid');
if ($jalan_sid=="") {$jalan_sid=JALAN_SID;}
$rakutentoken= get_option('rakuten_search_token');
if ($rakutentoken=="") {$rakutentoken=RAKUTENTOKEN;}
$rakutenaffid= get_option('rakuten_affiliate_id');
if ($rakutenaffid=="") {$rakutenaffid=RAKUTENAFFID;}
$ysh_sid=get_option('ysh_sid');
if ($ysh_sid=="") {$ysh_sid=YSH_SID;}
$ysh_pid=get_option('ysh_pid');
if ($ysh_pid=="") {$ysh_pid=YSH_PID;}
$yauc_sid=get_option('yauc_sid');
if ($yauc_sid=="") {$yauc_sid=YAUC_SID;}
$yauc_pid=get_option('yauc_pid');
if ($yauc_pid=="") {$yauc_pid=YAUC_PID;}
$attoken=get_option('attoken');
if ($attoken=="") {$attoken=ATTOKEN;}
$amzacckey=get_option('amzacckey');
if ($amzacckey==="") {$amzacckey==AMZACCKEY;}
$amzseckey=get_option('amzseckey');
if ($amzacckey==="") {$amzacckey==AMZSECKEY;}
$amzassid=get_option('amzassid');
if ($amzassid==="") {$amzassid==AMZASSID;}

// ■検索条件調整
$minprice = "100";
$maxprice = "1000000";
$query = $keyword;// 検索クエリー
$query4url = urlencode($query);// URLエンコード
$jan = $jancode;// 商品コード指定
$rwsquery = $query;// 楽天検索用クエリー
$rwsquery4url = rawurlencode($rwsquery);// URLエンコード
$rwsngquery = $ngword;// 楽天検索用NGクエリー
$rwsngquery4url = rawurlencode($rwsngquery);// URLエンコード

// ■各社リクエストURL組立■

// YAHOO!ショッピングリクエストURL組み立て
$ywsurl = "http://shopping.yahooapis.jp/ShoppingWebService/V1/itemSearch?appid=$vc_yahoo_appid&jan=$jan&sort=%2Bprice&hits=5&availability=1&price_from=$minprice&price_to=$maxprice&affiliate_from=2.0";
//$ywsurl = $ywsurl . "&affiliate_type=yid&affiliate_id=$token";
$ywsurl = $ywsurl . "&affiliate_type=vc&affiliate_id=http%3A%2F%2Fck.jp.ap.valuecommerce.com%2Fservlet%2Freferral%3Fsid%3D" . $ysh_sid . "%26pid%3D" . $ysh_pid . "%26vc_url%3D";

// 楽天リクエストURL組み立て
$rwsurl = "http://api.rakuten.co.jp/rws/3.0/rest?developerId=$rakutentoken&affiliateId=$rakutenaffid&operation=ItemSearch&version=2009-04-15&keyword=$rwsquery4url&sort=%2BitemPrice&hits=5&availability=1&minPrice=$minprice&maxPrice=$maxprice&NGKeyword=$rwsngquery4url";

// linkshareリクエストURL組み立て
$lsurl = "http://feed.linksynergy.com/productsearch?token=$lstoken&keyword=$query4url&max=5&sort=retailprice&sorttype=asc";
// &mid=3472,25051

// バリューコマースリクエストURL組み立て
$vcurl = "http://webservice.valuecommerce.ne.jp/productdb/search?token=$vctoken&keyword=$query4url&sort_by=price&sort_order=asc&price_max=$maxprice&price_min=$minprice&result_per_page=5";

// アクセストレードリクエストURL組み立て
// http://interspace.typepad.jp/webservice/atws/index.html
$aturl = "http://xml.accesstrade.net/at/ws.html?ws_type=searchgoods&ws_ver=1&ws_id=$attoken&search=$query4url&price_max=$maxprice&price_min=$minprice&row=5&sort1=3";

// AmazonリクエストURL組み立て
$baseurl = 'http://ecs.amazonaws.jp/onca/xml';
$params = array();
$params['Service']        = 'AWSECommerceService';
$params['AWSAccessKeyId'] = $amzacckey;
$params['Version']        = '2009-03-31';
$params['Operation']      = 'ItemSearch';
$params['SearchIndex']    = 'Blended';
$params['asin']       = "B001GQJJAE";
$params['AssociateTag']   = $amzassid;
$params['Condition']   = 'New';
$params['ContentType']   = 'text/xml';
$params['ResponseGroup']   = 'Medium,Reviews,OfferSummary';
$params['Timestamp'] = gmdate('Y-m-d\TH:i:s\Z');
// パラメータの順序を昇順に並び替えます
ksort($params);
$canonical_string = '';
foreach ($params as $k => $v) {
    $canonical_string .= '&'.urlencode_rfc3986($k).'='.urlencode_rfc3986($v);
}
$canonical_string = substr($canonical_string, 1);

$parsed_url = parse_url($baseurl);
$string_to_sign = "GET\n{$parsed_url['host']}\n{$parsed_url['path']}\n{$canonical_string}";
$signature = base64_encode(hash_hmac('sha256', $string_to_sign, $amzseckey, true));
$awsurl = $baseurl.'?'.$canonical_string.'&Signature='.urlencode_rfc3986($signature);

// ヤフオクリクエストURL組み立て
$yacurl = "http://auctions.yahooapis.jp/AuctionWebService/V1/Search?appid=$appid&query=$query4url&aucminprice=$minprice&aucmaxprice=$maxprice&sort=cbids&order=a";

// ■並列通信用マルチハンドルを用意■
$mh = curl_multi_init();

//通信先ごとにCurl Handleを作り、それを $mh にaddしていく（Y!ショッピング）
$ch_ywsurl = curl_init($ywsurl);
curl_setopt($ch_ywsurl, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($ch_ywsurl, CURLOPT_TIMEOUT, 5);
curl_multi_add_handle($mh, $ch_ywsurl);

// 同様に（楽天市場）
$ch_rwsurl = curl_init($rwsurl);
curl_setopt($ch_rwsurl, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($ch_rwsurl, CURLOPT_TIMEOUT, 5);
curl_multi_add_handle($mh, $ch_rwsurl);

// 同様に （リンクシェア）
$ch_lsurl = curl_init($lsurl);
curl_setopt($ch_lsurl, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($ch_lsurl, CURLOPT_TIMEOUT, 5);
curl_multi_add_handle($mh, $ch_lsurl);

// 同様に （バリューコマース）
$ch_vcurl = curl_init($vcurl);
curl_setopt($ch_vcurl, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($ch_vcurl, CURLOPT_TIMEOUT, 5);
curl_multi_add_handle($mh, $ch_vcurl);

// 同様に （アクセストレード）
$ch_aturl = curl_init($aturl);
curl_setopt($ch_aturl, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($ch_aturl, CURLOPT_TIMEOUT, 5);
curl_multi_add_handle($mh, $ch_aturl);

// 同様に （Amazon.co.jp）
$ch_awsurl = curl_init($awsurl);
curl_setopt($ch_awsurl, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($ch_awsurl, CURLOPT_TIMEOUT, 5);
curl_multi_add_handle($mh, $ch_awsurl);

// 同様に （ヤフオク）
$ch_yacurl = curl_init($yacurl);
curl_setopt($ch_yacurl, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($ch_yacurl, CURLOPT_TIMEOUT, 5);
curl_multi_add_handle($mh, $ch_yacurl);

// せーので複数の通信を同時実行。whileで全て返ってくるのを待ちます  
do { curl_multi_exec($mh, $running); } while ( $running );

// 個々のXMLは、それぞれのCurl Handleを指定することで取得できる  
$xml_ywsurl = curl_multi_getcontent($ch_ywsurl);
$xml_rwsurl = curl_multi_getcontent($ch_rwsurl);
$xml_lsurl = curl_multi_getcontent($ch_lsurl);
$xml_vcurl = curl_multi_getcontent($ch_vcurl);
$xml_aturl = curl_multi_getcontent($ch_aturl);
$xml_awsurl = curl_multi_getcontent($ch_awsurl);
$xml_yacurl = curl_multi_getcontent($ch_yacurl);


// 後始末  
curl_multi_remove_handle($mh, $ch_ywsurl);
curl_close($ch_ywsurl);
curl_multi_remove_handle($mh, $ch_rwsurl);
curl_close($ch_rwsurl);
curl_multi_remove_handle($mh, $ch_lsurl);
curl_close($ch_lsurl);
curl_multi_remove_handle($mh, $ch_vcurl);
curl_close($ch_vcurl);
curl_multi_remove_handle($mh, $ch_aturl);
curl_close($ch_aturl);
curl_multi_remove_handle($mh, $ch_awsurl);
curl_close($ch_awsurl);
curl_multi_remove_handle($mh, $ch_yacurl);
curl_close($ch_yacurl);

curl_multi_close($mh);
// ■並列通信ここまで■

return;

}//function

}//class




?>
