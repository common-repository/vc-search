<?php
/* これは文字化け防止のための日本語文字列です。
   このソースファイルは UTF-8 で保存されています。
   Above is a Japanese strings to avoid charset mis-understanding.
   This source file is saved with UTF-8. */
/*
Plugin Name: VC Search
Plugin URI: http://web-service-api.jp/vcsearch/
Description: ブログ内に各種Web API利用のプログラムを手軽に埋め込むことが出来るアフィリエイト対応プラグイン。自分のブログデザイン内で商品検索が出来るショッピングモール風画面や検索窓、ページング等必要な機能を網羅。アフィリエイト以外にも関連検索キーワードの提示や各種Web APIを利用してサイト内を回遊しやすい仕組みを導入している。
Author: wackey
Version: 1.89a
Author URI: http://web-service-api.jp/vcsearch/
*/

/*  Copyright 2009-2011 wackey

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

require_once("apifunc.php");// 共通関数読み込み
require_once("apiclass.php");// classファイル読み込み
require_once("hairetsuclass.php");// 配列classファイル読み込み
require_once("admin_must.php");// admin_must.php読み込み
require_once("admin_linkshare.php");// admin_linkshare.php読み込み
require_once("admin_valuecommerce.php");// admin_valuecommerce.php読み込み
require_once("admin_rakuten.php");// admin_rakuten.php読み込み
require_once("admin_amazon.php");// admin_amazon.php読み込み
require_once("admin_moshimo.php");// admin_moshimo.php読み込み

// WordPress 3.0ネットワーク一括設定用（管理画面で入力されなかったらここの値が適用）
define("VCTOKEN", "");
define("VCPAGEPAGE", "");
define("VC_YAHOO_APPID", "");
define("YSH_SID", "");
define("YSH_PID", "");
define("YAUC_SID", "");
define("YAUC_PID", "");
define("AMZACCKEY", "");
define("AMZSECKEY", "");
define("AMZASSID", "");
define("LSTOKEN", "");
define("JALANTOKEN", "");
define("JALAN_SID", "");
define("JALAN_PiD", "");
define("ATTOKEN", "");
define("RAKUTENTOKEN", "");
define("RAKUTENAFFID", "");
define("GOOGLE_AJAX_APIKEY", "");
define("GOOGLE_CUSTOM_ID", "");
define("GOOGLE_CUSTOM_NAME", "");

// ヘッダにプラグイン用CSS追記 cssファイルはプラグインディレクトリ内にある
function add_vc_css() {
echo "<link rel=\"stylesheet\" href=\"".WP_PLUGIN_URL."/vc-search/vc_search.css\" type=\"text/css\" />";
}


/***------------------------------------------
　検索結果画面描画
------------------------------------------***/

// 検索結果描画関数（全API共通）
function vcpage_func( $atts, $content = null ) {

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
if ($amzacckey=="") {$amzacckey==AMZACCKEY;}
$amzseckey=get_option('amzseckey');
if ($amzacckey=="") {$amzacckey==AMZSECKEY;}
$amzassid=get_option('amzassid');
if ($amzassid=="") {$amzassid==AMZASSID;}
$google_ajax_apikey=get_option('google_ajax_apikey');
if ($google_ajax_apikey=="") {$google_ajax_apikey==GOOGLE_AJAX_APIKEY;}
$google_custom_id=get_option('google_custom_id');
if ($google_custom_id=="") {$google_ajax_apikey==GOOGLE_CUSTOM_ID;}
$google_custom_name=get_option('google_custom_name');
if ($google_custom_name=="") {$google_ajax_apikey==GOOGLE_CUSTOM_NAME;}

// フォームからGETで送られて受け取った値を変数へ格納（一時取り込み）
$v_category =$_GET["category"];
$v_keyword =$_GET["keyword"];
$v_page =$_GET["page"];
$v_sort_by =$_GET["sort_by"];
$v_sort_order =$_GET["sort_order"];
$v_sort_type =$_GET["sort_type"];
$v_sort_rank=$_GET["rank"];
$v_jancode=$_GET["jancode"];// JANコードはAPIで対応したら使う
$v_keyword = str_replace("　", " ",$v_keyword);

// バリュコマなら
if ($_GET["pagetype"]=="vc") {

$valuecommerceapi = new valuecommerceapi();
$arr_sorts = $valuecommerceapi->arr_sorts;
$arr_categories =$valuecommerceapi->arr_categories;

$keyword = str_replace("　", " ",$keyword);// 全角スペース半角変換
$keyword = $v_keyword; //表示用
$v_keyword = urlencode(str_replace(" ", "+", trim($v_keyword))); //検索する場合は、トリムをかけて空白は「＋」で繋ぐ（AND検索）

// デフォルト値の設定
if(!isset($v_sort_by)) $v_sort_by = "";
if(!isset($v_sort_order)) $v_sort_order = "";
if(!isset($v_sort_type)) $v_sort_type = 0;
if(!isset($v_page) || $v_page == "") $v_page = 1;
if(!isset($v_sort_rank)) $v_sort_rank = "";
if(!isset($v_jancode)) $v_jancode = "";

// 並び順を設定
$valuecommerceapi->vcsort($v_sort_type,$v_sort_by,$v_sort_order,$v_sort_rank);


// バリューコマースリクエストURL組み立て
$vcurl = "http://webservice.valuecommerce.ne.jp/productdb/search?token=$vctoken&keyword=$v_keyword&category=$v_category&sort_by=$v_sort_by&sort_order=$v_sort_order&page=$v_page&results_per_page=10&rank=$v_sort_rank";

// 改ページ用パラメータ
$params = $vcpagepage . "pagetype=vc&keyword=$v_keyword&category=$v_category&sort_by=$v_sort_by&sort_order=$v_sort_order&sort_type=$v_sort_type&rank=$v_sort_rank";

// バリュコマsimpleXMLデータ取り出し配列変数に代入
$vcBuff = file_get_contents($vcurl);
$vcBuff = str_replace('vc:', 'vc', $vcBuff);
$vcBuff = str_replace('&', '&amp;', $vcBuff);
$xml = simplexml_load_string ($vcBuff);

$resultcount = h($xml->channel->vcresultcount);
$totalpage = h($xml->channel->vcpagecount);

 if ($resultcount != 0) {//検索件数が0件でない場合,変数$hitsに検索結果を格納します。
$hits = $xml->channel->item;
$hithairetsu=new HitsHitHairetsu;
$hithairetsu->valuecommerceitemhit($hits,$itemname,$aflinkurl,$imgurl,$price,$description,$shopname,$vcpvimg,$guid,$jancode,$souryou,$reviewnum,$reviewavr,$reviewurl,$faviconurl);
}


// バリュコマならend
} else if ($_GET["pagetype"]=="yshopping") {
//ヤフーショッピングなら

$yahooshoppingapi = new yahooshoppingapi();
$arr_sorts = $yahooshoppingapi->arr_sorts;
$arr_categories =$yahooshoppingapi->arr_categories;

$keyword = $v_keyword; //表示用
$v_keyword = urlencode(trim($v_keyword)); 

// デフォルト値の設定
if(!isset($v_page)) $v_page = "";
if(!isset($v_sort_by)) $v_sort_by = "";
if(!isset($v_sort_order)) $v_sort_order = "";
if(!isset($v_sort_type)) $v_sort_type = "2";
if(!isset($v_page) || $v_page == "") $v_page = 1;
if(!isset($v_sort_rank)) $v_sort_rank = "";
if(!isset($v_jancode)) $v_jancode = "";

// 並べ順の選択肢からパラメータを設定
$v_sort_type=$yahooshoppingapi->yshsort ($v_sort_type,&$v_sort_order);

$offset = ($v_page*10)-10;
$ywsurl = "http://shopping.yahooapis.jp/ShoppingWebService/V1/itemSearch?appid=$vc_yahoo_appid&query=$v_keyword&hits=10&availability=1&affiliate_from=2.0&offset=$offset&sort=$v_sort_type&category_id=$v_category";
$ywsurl = $ywsurl . "&affiliate_type=vc&affiliate_id=http%3A%2F%2Fck.jp.ap.valuecommerce.com%2Fservlet%2Freferral%3Fsid%3D" . $ysh_sid . "%26pid%3D" . $ysh_pid. "%26vc_url%3D";

// 改ページ用パラメータ
$params = $vcpagepage . "pagetype=yshopping&keyword=$v_keyword&sorttype=$v_sort_type";

$vcBuff = file_get_contents($ywsurl );
$xml = simplexml_load_string ($vcBuff);

$resultcount = h($xml["totalResultsAvailable"]);
$totalpage = h($xml["totalResultsAvailable"] / 10);

if ($resultcount!= 0) {
$hits = $xml->Result->Hit;
$hithairetsu=new HitsHitHairetsu;
$hithairetsu->yahooshoppingitemhit($hits,$itemname,$aflinkurl,$imgurl,$price,$description,$shopname,$vcpvimg,$guid,$jancode,$souryou,$reviewnum,$reviewavr,$reviewurl,$faviconurl);
}

// ヤフーショッピングならend
} else if ($_GET["pagetype"]=="yauction") {
//ヤフーオークションなら
$yahooauctionapi = new yahooauctionapi();
$arr_sorts = $yahooauctionapi->arr_sorts;
//$arr_categories =$yahooauctionapi>arr_categories;


$keyword = $v_keyword; //表示用
$v_keyword = urlencode(trim($v_keyword)); 

// デフォルト値の設定
if(!isset($v_page)) $v_page = "";
if(!isset($v_sort_by)) $v_sort_by = "";
if(!isset($v_sort_order)) $v_sort_order = "";
if(!isset($v_sort_type)) $v_sort_type = 0;
if(!isset($v_page) || $v_page == "") $v_page = 1;
if(!isset($v_sort_rank)) $v_sort_rank = "";
if(!isset($v_jancode)) $v_jancode = "";

// ソート順設定
$yahooauctionapi->yaucsort($v_sort_type,$v_sort_by,$v_sort_order);

$offset = ($v_page*10)-9;
$yacurl = "http://auctions.yahooapis.jp/AuctionWebService/V2/search?appid=$vc_yahoo_appid&query=$v_keyword&page=$v_page&sort=$v_sort_by&order=$v_sort_order";

// 改ページ用パラメータ
$params = $vcpagepage . "pagetype=yauction&keyword=$v_keyword&sort=$v_sort_type";

$vcBuff = file_get_contents($yacurl);
$xml = simplexml_load_string ($vcBuff);

$resultcount = h($xml["totalResultsAvailable"] );
$totalpage = h($xml["totalResultsAvailable"] /50);

if ($resultcount!= 0) {//検索件数が0件でない場合,変数$hitsに検索結果を格納します。
$hits = $xml->Result->Item;
$hithairetsu=new HitsHitHairetsu;
$hithairetsu->yahooauctionitemhit($hits,$itemname,$aflinkurl,$imgurl,$price,$description,$shopname,$vcpvimg,$guid,$jancode,$souryou,$reviewnum,$reviewavr,$reviewurl,$faviconurl);
}

// ヤフーオークションならend
} else if ($_GET["pagetype"]=="amazon_vc") {
//Amazonなら

$keyword = $v_keyword; //表示用
$v_keyword = trim($v_keyword); 

$Amazonitemsearchtapi= new Amazonitemsearchtapi();
$arr_categories = $Amazonitemsearchtapi->arr_categories;
$arr_sorts =$Amazonitemsearchtapi->arr_sorts;

// デフォルト値の設定
if(!isset($v_page)) $v_page = "";
if(!isset($v_sort_by)) $v_sort_by = "";
if(!isset($v_sort_order)) $v_sort_order = "";
if(!isset($v_sort_type)) $v_sort_type = 0;
if(!isset($v_page) || $v_page == "") $v_page = 1;
if(!isset($v_sort_rank)) $v_sort_rank = "";
if(!isset($v_jancode)) $v_jancode = "";
if(!isset($v_category)) $v_category= "All";

// ソート順設定
$Amazonitemsearchtapi->amazonsort($v_sort_type,$v_sort_order,$v_category);

// AmazonリクエストURL組み立て
$awsurl = $Amazonitemsearchtapi->awsrequesturl($v_category,$v_keyword,$v_sort_order,$v_page);

// 改ページ用パラメータ
$params = $vcpagepage . "pagetype=amazon_vc&keyword=$v_keyword&category=$v_category";

$vcBuff = file_get_contents($awsurl);
$xml = simplexml_load_string ($vcBuff);
$resultcount = h($xml->Items->TotalResults);
$totalpage = h($xml->Items->TotalPages);

if ($resultcount != 0) {//検索件数が0件でない場合,変数$hitsに検索結果を格納します。
$hits = $xml->Items->Item;
$hithairetsu=new HitsHitHairetsu;
$hithairetsu->amazonitemhit($hits,$itemname,$aflinkurl,$imgurl,$price,$description,$shopname,$vcpvimg,$guid,$jancode,$souryou,$reviewnum,$reviewavr,$reviewurl,$faviconurl);
}


// Amazonならend
} else if ($_GET["pagetype"]=="ls") {
//リンクシェアなら

$linkshareitemsearchapi= new linkshareitemsearchapi();
$arr_sorts = $linkshareitemsearchapi->arr_sorts;

// フォームからGETで送られて受け取った値を変数へ格納

$ls_category =$_GET["category"];
$ls_keyword =$_GET["keyword"];
$v_page =$_GET["page"];
$ls_sort_by =$_GET["sort_by"];
$ls_sort_order =$_GET["sort_order"];
$ls_sort_type =$_GET["sort_type"];
$ls_sort_rank=$_GET["rank"];
$ls_jancode=$_GET["jancode"];// JANコードはAPIで対応したら使う
$mid=$_GET["mid"];

$keyword = $ls_keyword; //表示用
$ls_keyword = urlencode('"'.trim($ls_keyword).'"'); //検索する場合は、トリムをかけて引用符で囲む

// デフォルト値の設定
if(!isset($v_page )) $v_page  = "1";
if(!isset($ls_sort_by)) $ls_sort_by = "";
if(!isset($ls_sort_order)) $ls_sort_order = "dsc";
if(!isset($ls_sort_type)) $ls_sort_type = 0;
if(!isset($v_page ) || $v_page  == "") $v_page  = 1;
if(!isset($ls_sort_rank)) $ls_sort_rank = "";
if(!isset($ls_jancode)) $ls_jancode = "";

// 並べ順の選択肢からパラメータを設定
$linkshareitemsearchapi->linksheresort($ls_sort_type,$ls_sort_order);

// リンクシェアリクエストURL組み立て
if ($mid==0 | $mid=="") {
$lsurl = "http://productsearch.linksynergy.com/productsearch?token=$lstoken&keyword=$ls_keyword&max=10&pagenumber=$v_page&sort=retailprice&sorttype=$ls_sort_order";
} else {
$lsurl = "http://productsearch.linksynergy.com/productsearch?token=$lstoken&keyword=$ls_keyword&max=10&pagenumber=$v_page&sort=retailprice&sorttype=$ls_sort_order&mid=$mid";
}

// 改ページ用パラメータ
$params = $vcpagepage . "pagetype=ls&keyword=".urlencode($keyword)."&sort=retailprice&sorttype=$ls_sort_order&mid=$mid";

// リンクシェアsimpleXML,データ取り出し配列変数に代入
$lsBuff = file_get_contents($lsurl);
$xml = simplexml_load_string ($lsBuff);
$resultcount = h($xml->TotalMatches);
$totalpage = h($xml->TotalPages);

if ($resultcount != 0) {//検索件数が0件でない場合,変数$hitsに検索結果を格納します。
$hits = $xml->item;
$hithairetsu=new HitsHitHairetsu;
$hithairetsu->linkshareitemhit($hits,$itemname,$aflinkurl,$imgurl,$price,$description,$shopname,$vcpvimg,$guid,$jancode,$souryou,$reviewnum,$reviewavr,$reviewurl,$faviconurl);
} // if $resultcoundt


//リンクシェアならend
} else if ($_GET["pagetype"]=="jalan") {
// じゃらんなら

// フォームからGETで送られて受け取った値を変数へ格納
$v_page =$_GET["page"];
$jalan_pref =$_GET["pref "];
$jalan_l_area =$_GET["l_area"];
$jalan_s_area =$_GET["s_area"];

// デフォルト値の設定
if(!isset($v_page)) $v_page = "1";

// じゃらんリクエストURL組み立て
$start = 10*($v_page-1)+1;
if ($start< 0) {$start=1;}
$jalanurl = "http://jws.jalan.net/APIAdvance/HotelSearch/V1/?key=$jalantoken&pref=$jalan_pref&l_area=$jalan_l_area&s_area=$jalan_s_area&count=10&start=$start";

// 改ページ用パラメータ
$params = $vcpagepage . "pagetype=jalan&pref=$jalan_pref&l_area=$jalan_l_area&s_area=$jalan_s_area";

//if (isset($jalan_pref)) {
$jalanBuff = @file_get_contents($jalanurl);
$xml = @simplexml_load_string ($jalanBuff);

$resultcount = h($xml->NumberOfResults);
$totalpage = h($xml->NumberOfResults) / 10;

$hits = $xml->Hotel;


if (!$resultcount==0) {
foreach ($hits as $hit) {

$itemname[] = h($hit->HotelName);
$aflinkurl[] = "http://ck.jp.ap.valuecommerce.com/servlet/referral?sid=$jalan_sid&pid=$jalan_pid&vc_url=".urlencode($hit->HotelDetailURL);
//$aflinkurl[] = h($hit->HotelDetailURL);
if (strlen($hit->PictureURL)) {
	$imgurl[] = h($hit->PictureURL);
} else {
	$imgurl[] = "c_img/noimage.gif";
}

$price[] = h($hit->price);
$description[] = h($hit->HotelCatchCopy).h($hit->HotelCaption);
$shopname[] = h($hit->HotelName);
$vcpvimg[]="";
$guid[]="";
$jancode[]="";
$souryou[] = "";
$reviewnum[] = "";
$reviewavr[] = "";
$reviewurl[] = "";
$faviconurl[] = h($hit->HotelDetailURL);
$vcpvimg[] = "<img src=\"http://ad.jp.ap.valuecommerce.com/servlet/gifbanner?sid=$jalan_sid&pid=$jalan_pid\" height=\"0\" width=\"0\" border=\"0\">";

}  //foreach
} // if

// じゃらんend
} else if ($_GET["pagetype"]=="google") {
// google検索なら

$ret ='<div id="searchcontrol"></div>';
 return $ret;

// google検索end
} else if ($_GET["pagetype"]=="asin") {
// ASIN検索なら

// フォームからGETで送られて受け取った値を変数へ格納
$asin=$_GET["asin"];// JANコードはAPIで対応したら使う


// 最低価格と最高価格の設定
$minprice = "100";
$maxprice = "1000000";

$asinno = $asin;

// ■Amazon.co.jpの処理■
// AmazonリクエストURL組み立て
$awsitem=new Amazonitemsearchtapi;
$awsurl = $awsitem->Awsitemlookupurl($asinno);

$xml = simplexml_load_file ($awsurl);
$amaitem = $xml->Items->Item;
$jancode = $amaitem->ItemAttributes->EAN;


// ■YAHOO!ショッピングの処理■
// YAHOO!ショッピングリクエストURL組み立て
$ywsurl = "http://shopping.yahooapis.jp/ShoppingWebService/V1/itemSearch?appid=$vc_yahoo_appid&jan=$jancode&sort=%2Bprice&hits=5&availability=1&price_from=$minprice&price_to=$maxprice&affiliate_from=2.0";
//$ywsurl = $ywsurl . "&affiliate_type=yid&affiliate_id=$token";
$ywsurl = $ywsurl . "&affiliate_type=vc&affiliate_id=http%3A%2F%2Fck.jp.ap.valuecommerce.com%2Fservlet%2Freferral%3Fsid%3D" . $ysh_sid . "%26pid%3D" . $ysh_pid . "%26vc_url%3D";

$xml = simplexml_load_file ($ywsurl);
if ($xml["totalResultsReturned"] != 0) {
$hits = $xml->Result->Hit;
$hithairetsu=new HitsHitHairetsu;
$hithairetsu->yahooshoppingitemhit($hits,$itemname,$aflinkurl,$imgurl,$price,$description,$shopname,$vcpvimg,$guid,$jancode,$souryou,$reviewnum,$reviewavr,$reviewurl,$faviconurl);
}


// ■楽天市場の処理■
// 楽天リクエストURL組み立て
$rwsurl = "http://api.rakuten.co.jp/rws/3.0/rest?developerId=$rakutentoken&affiliateId=$rakutenaffid&operation=ItemSearch&version=2009-04-15&keyword=$jancode&sort=%2BitemPrice&hits=5&availability=1&minPrice=$minprice&maxPrice=$maxprice";

$rwsBuff = file_get_contents($rwsurl);
$rwsBuff = str_replace('header:Header', 'headerHeader', $rwsBuff);
$rwsBuff = str_replace('itemSearch:ItemSearch', 'itemSearchItemSearch', $rwsBuff);

$xml = simplexml_load_string ($rwsBuff);

$resultcount = h($xml->Body->itemSearchItemSearch->count);
$totalpage = h($xml->Body->itemSearchItemSearch->pageCount);

if (!$resultcount==0) {
$hits = $xml->Body->itemSearchItemSearch->Items->Item;
$hithairetsu=new HitsHitHairetsu;
$hithairetsu->rakutenichibaitemhit($hits,$itemname,$aflinkurl,$imgurl,$price,$description,$shopname,$vcpvimg,$guid,$jancode,$souryou,$reviewnum,$reviewavr,$reviewurl,$faviconurl);
}


// ■リンクシェアの処理■
// linkshareリクエストURL組み立て
$lsurl = "http://productsearch.linksynergy.com/productsearch?token=$lstoken&keyword=$jancode&max=5&sort=retailprice&sorttype=asc";
// &mid=3472,25051

$xml = simplexml_load_file ($lsurl);
$resultcount = h($xml->TotalMatches);
$totalpage = h($xml->TotalPages);

if ($resultcount != 0) {//検索件数が0件でない場合,変数$hitsに検索結果を格納します。
$hits = $xml->item;
$hithairetsu=new HitsHitHairetsu;
$hithairetsu->linkshareitemhit($hits,$itemname,$aflinkurl,$imgurl,$price,$description,$shopname,$vcpvimg,$guid,$jancode,$souryou,$reviewnum,$reviewavr,$reviewurl,$faviconurl);
} // if $resultcoundt


// ■バリューコマースの処理■
// バリューコマースリクエストURL組み立て
$vcurl = "http://webservice.valuecommerce.ne.jp/productdb/search?token=$vctoken&product_id=$jancode&sort_by=price&sort_order=asc&price_max=$maxprice&price_min=$minprice&result_per_page=5&ec_code=02t5n,0png4,0zttq,05f47,0j3hc,08x8b,07s9u,08fsg,bdrxs,0ha4k,0jcf6,03p68,03gpr,0wz95,09muc,bdufh,077ap,02spk,090a7,078nc";

$vcBuff = file_get_contents($vcurl);

$vcBuff = str_replace('vc:', 'vc', $vcBuff);
$xml = simplexml_load_string ($vcBuff);
$resultcount = h($xml->channel->vcresultcount);
$totalpage = h($xml->channel->vcpagecount);

 if ($resultcount != 0) {//検索件数が0件でない場合,変数$hitsに検索結果を格納します。
$hits = $xml->channel->item;
$hithairetsu=new HitsHitHairetsu;
$hithairetsu->valuecommerceitemhit($hits,$itemname,$aflinkurl,$imgurl,$price,$description,$shopname,$vcpvimg,$guid,$jancode,$souryou,$reviewnum,$reviewavr,$reviewurl,$faviconurl);
}


// ■アクセストレードの処理■
// アクセストレードリクエストURL組み立て
// http://interspace.typepad.jp/webservice/atws/index.html
$aturl = "http://xml.accesstrade.net/at/ws.html?ws_type=searchgoods&ws_ver=1&ws_id=$attoken&search=$jancode&price_max=$maxprice&price_min=$minprice&row=5&sort1=3";

$atBuff = file_get_contents($aturl);
$xml = simplexml_load_string ($atBuff);
$resultcount = h($xml->TotalCount);
$totalpage = h($xml->TotalPage);
if (!$resultcount==0) {
$hits = $xml->Goods;
$hithairetsu=new HitsHitHairetsu;
$hithairetsu->actritemhit($hits,$itemname,$aflinkurl,$imgurl,$price,$description,$shopname,$vcpvimg,$guid,$jancode,$souryou,$reviewnum,$reviewavr,$reviewurl,$faviconurl);
} // if

// ■ヤフオクの処理■
// フォームに入力されたキーワードを取り出してURLエンコードする
$query = h($amaitem->ItemAttributes->Title);
$query4url = urlencode($query); // URLエンコード

// ヤフオクリクエストURL組み立て
$yacquery= $query4url . urlencode(" ") . h($amaitem->ItemAttributes->Artist);
$yacurl = "http://auctions.yahooapis.jp/AuctionWebService/V1/Search?appid=$vc_yahoo_appid&query=$yacquery&aucminprice=$minprice&aucmaxprice=$maxprice&sort=cbids&order=a";

$yacBuff = file_get_contents($yacurl);
$xml = simplexml_load_string ($yacBuff);
$yaitems = $xml->item;

// 値段安い順番に並び替える（全部）
asort($price); 

$ret = '<p>amazon.co.jpでの商品名：<a href="'.h($amaitem->DetailPageURL).'" target="_blank">'.h($amaitem->ItemAttributes->Title).'</a></p>';
$ret .= '<img src="'.h($amaitem->MediumImage->URL) .'"><a href="'. h($amaitem->DetailPageURL).'" target="_blank"></a></div>';
if (isset($amaitem->ItemAttributes->Artist)) {
$ret .= 'アーティスト：<a href="'.$vcpagepage.'artist='. urlencode(h($amaitem->ItemAttributes->Artist)).'">'. h($amaitem->ItemAttributes->Artist).'</a><br />';
}
if (is_array($amaitem->ItemAttributes->Creator)) {
$ret .= 'クリエイター：';
foreach ($amaitem->ItemAttributes->Creator as $hit) {
$ret .= $hit.",";
}
}
$ret .= '<br />';
if (isset($amaitem->ItemAttributes->ListPrice->Amount)) {
$ret .= '参考価格：'. number_format(intval($amaitem->ItemAttributes->ListPrice->Amount)).'円　';
}
if (isset($amaitem->OfferSummary->LowestNewPrice->Amount)) {
$ret .= '販売価格：<span class="price">'.number_format(intval($amaitem->OfferSummary->LowestNewPrice->Amount)).'</span>円<br />';
}
$ret .= 'セールスランキング：'.h($amaitem->SalesRank).'<br />';
$ret .= 'リリース日：'.h($amaitem->ItemAttributes->ReleaseDate).'<br />';
if (isset($amaitem->ItemAttributes->Label)) {
$ret .= 'レーベル：'.h($amaitem->ItemAttributes->Label).'<br />';
}
if (isset($amaitem->ItemAttributes->Manufacturer)) {
$ret .= h($amaitem->ItemAttributes->Manufacturer).'<br />';
}
if (isset($amaitem->ItemAttributes->Publisher)) {
$ret .= 'パブリッシャー：'.h($amaitem->ItemAttributes->Publisher).'<br />';
}
if (isset($amaitem->ItemAttributes->NumberOfDiscs)) {
$ret .= '<!--CD枚数：'.h($amaitem->ItemAttributes->NumberOfDiscs).'<br />-->';
}
$ret .= 'プロダクトグループ：'.h($amaitem->ItemAttributes->ProductGroup);
$ret .= 'EANコード：'.h($amaitem->ItemAttributes->EAN).'　ASIN:'.h($amaitem->ASIN); 
$ret .= '<br />';

if (isset($amaitem->Tracks->Disc)) {
$ret .= '<h3>トラック情報</h3>';
foreach ($amaitem->Tracks->Disc as $disc) {
	$ret .= "<ol>";
	foreach ($disc->Track as $track) {
$ret .= "<li>".h($track)."</li>";
	}
$ret .= "</ol>";
}
}

$ret .= "<h3>この商品を買った人はこんな商品も買っています</h3>";

foreach ($amaitem->SimilarProducts->SimilarProduct as $hit) {
$ret .= '<a href="'.$vcpagepage.'pagetype=asin&asin='.h($hit->ASIN).'">';
$ret .= h($hit->Title)."(".h($hit->ASIN).")<br />";
$ret .='</a>';
}
$ret .= "<br />";

$ret .= "<h3>カスタマレビュー</h3>";
$ret .= "平均点　". h($amaitem->CustomerReviews->AverageRating)."　件数　".h($amaitem->CustomerReviews->TotalReviews)."件<br />";
$ret .= "<br />";

foreach ($amaitem->CustomerReviews->Review as $hit) {
$ret .= "<strong>" . h($hit->Summary) . "</strong>　評価：" . h($hit->Rating) . "<br />";
$ret .= $hit->Content."<br /><br />";
}


$ret .="<h3>この商品を他のお店で買う</h3>";
$i=0;// カウンタとして$iを使用。$iを0にセット
$ret .="<p><ul>";
foreach ($price as $key => $value) {
$ret .= '<li><a href="'.$linkurl[$key].'" target="_blank">'.$shopname[$key].'</a>';
$ret .= '税込価格：<span class="price">'.number_format($price[$key]).'円</span>　';
if (strlen($souryou[$key])) {$ret .= "（".$souryou[$key]."）"; } 
$ret .="</li>";
$i=$i+1;// カウンタの値をプラス1する
 //if ($i==10) {break;}
}
$ret .= "</ul>";

$ret .="<h3>「".urldecode($yacquery)."」をヤフオクで物色する</h3>";
$i=0;// カウンタとして$iを使用。$iを0にセット
$ret .="<p>";
foreach ($yaitems as $hit) {
$linkurl = "http://ck.jp.ap.valuecommerce.com/servlet/referral?sid=$yaucsid&pid=$yaucpid&vc_url=" . urlencode(h($hit->url));
if (strlen($hit->img)) {
	$imgurl = h($hit->img);
} else {
	$imgurl = "c_img/noimage.gif";
}
$pricebuff = h($hit->price);
$pricebuff = str_replace(' 円', '', $pricebuff);
$pricebuff = str_replace(',', '', $pricebuff);
$price = intval($pricebuff);

$ret .= "<h4>".h($hit->title)."</h4>";
$ret .= '<div class="vc-itempic" style="background: transparent url('.$imgurl.') no-repeat scroll center center; -moz-background-clip: -moz-initial; -moz-background-origin: -moz-initial; -moz-background-inline-policy: -moz-initial;"><a href="'.$linkurl.'" target="_blank"><img src="'.WP_PLUGIN_URL.'/vc-search/c_img/spacer.gif" class="vc-line-height"/></a></div>';
$ret .= '現在価格：<span class="vc-price">'.number_format($price).'円</span><br />';
$ret .= '<a href="'.$linkurl.'" target="_blank">この商品の詳細をヤフオクで確認する</a>';

$ret .= '<div class="vc-pic">&nbsp;</div>';
$i=$i+1;// カウンタの値をプラス1する
//if ($i==10) {break;}
}

return $ret;

// ASIN検索end
} else if ($_GET["pagetype"]=="actr") {
// アクセストレードなら


$attoken= get_option('attoken');
if ($attoken=="") {$attoken=ATTOKEN;}
$vcpagepage= get_option('vc_search_page');
if ($vcpagepage=="") {$vcpagepage=VCPAGEPAGE;}

// フォームからGETで送られて受け取った値を変数へ格納
$v_category =$_GET["category"];
$v_keyword =$_GET["keyword"];
$v_page =$_GET["page"];
$v_sort_by =$_GET["sort_by"];
$v_sort_order =$_GET["sort_order"];
$v_sort_type =$_GET["sort_type"];
$v_sort_rank=$_GET["rank"];
$v_jancode=$_GET["jancode"];

$keyword = $v_keyword; //表示用
$v_keyword = urlencode(trim($v_keyword)); 

// デフォルト値の設定
if(!isset($v_page)) $v_page = "";
if(!isset($v_sort_by)) $v_sort_by = "";
if(!isset($v_sort_order)) $v_sort_order = "";
if(!isset($v_sort_type)) $v_sort_type = 0;
if(!isset($v_page) || $v_page == "") $v_page = 1;
if(!isset($v_sort_rank)) $v_sort_rank = "";
if(!isset($v_jancode)) $v_jancode = "";

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

// アクトレリクエストURL組み立て
$aturl = "http://xml.accesstrade.net/at/ws.html?ws_type=searchgoods&ws_ver=1&ws_id=$attoken&search=$v_keyword&row=10&sort1=3";

// 改ページ用パラメータ
$params = $vcpagepage . "pagetype=actr&keyword=$v_keyword";

$actrBuff = file_get_contents($aturl) ;
$xml = simplexml_load_string($actrBuff);
$resultcount = h($xml->TotalCount);
$totalpage = h($xml->TotalPage);

if (!$resultcount==0) {
$hits = $xml->Goods;
$hithairetsu=new HitsHitHairetsu;
$hithairetsu->actritemhit($hits,$itemname,$aflinkurl,$imgurl,$price,$description,$shopname,$vcpvimg,$guid,$jancode,$souryou,$reviewnum,$reviewavr,$reviewurl,$faviconurl);
} // if


// アクセストレードならend
} else if ($_GET["pagetype"]=="rakuten") {
// 楽天市場なら

// フォームからGETで送られて受け取った値を変数へ格納

$rakuten_category =$_GET["category"];
$rakuten_keyword =$_GET["keyword"];
$v_page =$_GET["page"];
$rakuten_sort_by =$_GET["sort_by"];
$rakuten_sort_order =$_GET["sort_order"];
$rakuten_sort_type =$_GET["sort_type"];
$rakuten_sort_rank=$_GET["rank"];
$rakuten_jancode=$_GET["jancode"];
$keyword = urlencode($rakuten_keyword);

// デフォルト値の設定
if(!isset($v_page )) $v_page  = "1";
if(!isset($rakuten_category)) $rakuten_category= "0";
if(!isset($rakuten_sort_by)) $rakuten_sort_by = "";
if(!isset($rakuten_sort_order)) $rakuten_sort_order = "";
if(!isset($rakuten_sort_type)) $rakuten_sort_type = 0;
if(!isset($v_page ) || $v_page  == "") $v_page  = 1;
if(!isset($rakuten_sort_rank)) $rakuten_sort_rank = "";
if(!isset($rakuten_jancode)) $rakuten_jancode = "";

$rakutenichibaapi = new rakutenichibaapi();
$arr_sorts = $rakutenichibaapi->arr_sorts;
$arr_categories =$rakutenichibaapi->arr_categories;

$rakutenichibaapi ->rakutensort ($rakuten_sort_type,$rakuten_sort_order);

if ((! function_exists('is_mobile') || ! is_mobile()) && (! function_exists('is_ktai')   || ! is_ktai())) {
// PCであれば・・・
$rwsurl = "http://api.rakuten.co.jp/rws/3.0/rest?developerId=$rakutentoken&affiliateId=$rakutenaffid&operation=ItemSearch&version=2009-04-15&keyword=$keyword&hits=10&availability=1&page=$v_page&genreId=$rakuten_category&sort=".urlencode($rakuten_sort_order);
} else {
// 携帯であれば・・・
$rwsurl = "http://api.rakuten.co.jp/rws/3.0/rest?developerId=$rakutentoken&affiliateId=$rakutenaffid&operation=ItemSearch&version=2009-04-15&keyword=$keyword&hits=10&availability=1&page=$v_page&genreId=$rakuten_category&carrier=1&sort=".urlencode($rakuten_sort_order);
}

// 改ページ用パラメータ
$params = $vcpagepage . "pagetype=rakuten&keyword=$keyword&category=".$rakuten_category."&sort=".urlencode($rakuten_sort_order);

$rwsBuff  = file_get_contents($rwsurl );
$rwsBuff = str_replace('header:Header', 'headerHeader', $rwsBuff);
$rwsBuff = str_replace('itemSearch:ItemSearch', 'itemSearchItemSearch', $rwsBuff);

$xml = simplexml_load_string ($rwsBuff);

$resultcount = h($xml->Body->itemSearchItemSearch->count);
$totalpage = h($xml->Body->itemSearchItemSearch->pageCount);

if (!$resultcount==0) {
$hits = $xml->Body->itemSearchItemSearch->Items->Item;
$hithairetsu=new HitsHitHairetsu;
$hithairetsu->rakutenichibaitemhit($hits,$itemname,$aflinkurl,$imgurl,$price,$description,$shopname,$vcpvimg,$guid,$jancode,$souryou,$reviewnum,$reviewavr,$reviewurl,$faviconurl);
}

}

// php end 
?>

<?php
if ($_GET["pagetype"]=="jalan") {
// page_idを使用している場合（デフォルト設定）
if (isset($_GET["page_id"])) {$formadds =$_GET["page_id"]; }
?>
<script type="text/javascript" src="<?php echo WP_PLUGIN_URL; ?>/vc-search/area_data.js"></script>
<script type="text/javascript" src="<?php echo WP_PLUGIN_URL; ?>/vc-search/area.js"></script>
<form action="<?php echo $vcpagepage; ?>" method="get">
<input type="hidden" name="pagetype" value="<?php echo $_GET["pagetype"]; ?>" />
<?php
// page_idを使用している場合（デフォルト設定）
if (isset($_GET["page_id"])) {
?>
<input type="hidden" name="page_id" value="<?php echo $_GET["page_id"]; ?>" />
<?php
 }
?>
<select class="area_pd" name="pref" id="pref" onChange="changeLargeArea(this)"><option value="" selected>都道府県</option></select>
<select class="area_pd" name="l_area" id="l_area" onChange="changeSmallArea(this)"><option value="" selected>大エリア</option></select>
<select class="area_pd" name="s_area" id="s_area"><option value="" selected>小エリア</option></select>
<script type="text/javascript">
initAreaPulldown();
</script> 
<input type="submit" value="エリアで検索" />
 </form>
<?php
} else {
$vcpagepage= get_option('vc_search_page');
if ($vcpagepage=="") {$vcpagepage=VCPAGEPAGE;}
// pagetype判別
$pagetype=$_GET["pagetype"];
if ($_GET["pagetype"]=="") {$pagetype="vc";}
// page_idを使用している場合（デフォルト設定）
//バグ　if (isset($_GET["page_id"])) {$params .="&page_id=".$_GET["page_id"]; }
/***------------------------------------------
　検索結果画面描画
------------------------------------------***/
?>

<form action="<?php echo $vcpagepage; ?>" method="get">
<input type="hidden" name="pagetype" value="<?php echo $pagetype; ?>" />
<input type="text" name="keyword" value="<?php echo urldecode($keyword); ?>" />&nbsp;<input type="submit" value="商品検索" /><br />
<?php
if (isset($_GET["page_id"])) {
?>
<input type="hidden" name="page_id" value="<?php echo $_GET["page_id"]; ?>" />
<?php
}
?>
<?php 
if (isset($arr_categories)) {
DrawSelectMenu("category", $arr_categories, $v_category,"");
}
if (isset($arr_sorts)) {
DrawSelectMenu("sort_type", $arr_sorts, $v_sort_type,"");
}
?>
<br />

</form>

<?php
}
?>

<?php if (!urldecode($keyword)=="") { ?>
<h2><?php 
echo urldecode($keyword); ?>の検索結果</h2>
<?php } ?>

<p><?php echo pagenavilink($v_page, $totalpage, $params,$resultcount); ?></p><!-- ページ切り替えボタン -->

<?php
if (!$resultcount == 0) {
foreach ($price as $key => $value) {

?>

<?php echo DrawPageItem($itemname[$key],$imgurl[$key],$aflinkurl[$key],$price[$key],$jancode[$key],$description[$key],$vcpvimg[$key],$guid[$key],$shopname[$key],$reviewnum[$key],$reviewavr[$key],$reviewurl[$key],$faviconurl[$key]); ?>

<?php
} //foreach

} else {
?>
<?php if (!urldecode($keyword)=="") { ?>
<p>検索した結果、見つかりませんでした。今YAHOO!SHOPPINGで人気の急上昇キーワードで検索してみませんか？</p>
<?php } ?>

<p>急上昇キーワード：<?php

$kyujoshohits=kyujosho();
foreach ($kyujoshohits as $hit) {
// page_idを使用している場合（デフォルト設定）
if (isset($_GET["page_id"])) {
?>
<a href="<?php echo $vcpagepage; ?>&pagetype=yshopping&keyword=<?php echo urlencode(h($hit->Query)); ?>"><?php echo h($hit->Query); ?></a>
<?php
} else {
?>
<a href="<?php echo $vcpagepage; ?>pagetype=yshopping&keyword=<?php echo urlencode(h($hit->Query)); ?>"><?php echo h($hit->Query); ?></a>
<?php
}
}
 ?>
</p>

<p><?php echo vc_category(); ?></p>
<?php
}
?>

<p><?php echo pagenavilink($v_page, $totalpage, $params,$resultcount); ?></p><!-- ページ切り替えボタン -->

<?php yahoocredit(); ?>

<?php

}


/***------------------------------------------
　ブログエントリ内アイテム検索表示
------------------------------------------***/

// バリューコマース商品単品表示
function vcitem_func( $atts, $content = null ) {

$vctoken= get_option('vc_search_token');
if ($vctoken=="") {$vctoken=VCTOKEN;}
$vcpagepage= get_option('vc_search_page');
if ($vcpagepage=="") {$vcpagepage=VCPAGEPAGE;}

// [vcitem]属性情報取得
extract(shortcode_atts(array(
'keyword' => null,
'jancode' => null,
'category' => null,
'sort_type' => null, ), $atts));

$keyword = str_replace("　", " ",$keyword);// 全角スペース半角変換
$keyword = str_replace(" ", "+", trim($keyword)); //検索する場合は、トリムをかけて空白は「＋」で繋ぐ（AND検索）

if (isset($keyword)) {
// 自由テキストリンクの場合
$v_keyword= urlencode($keyword);
$linkurl = $vcpagepage.'pagetype=vc&keyword='.$keyword;
} else if (isset($jancode)) {
// JANコード指定の場合※現時点ではAPIで対応していないので機能しない
$linkurl = $vcpagepage.'jancode='.$jancode;
} else {
// それ以外の[vc]で挟まれたキーワードでの検索リンクを作成する場合
$v_keyword= urlencode($content);
$linkurl = $vcpagepage.'pagetype=vc&keyword='.$keyword;
}



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


// バリューコマースリクエストURL組み立て
$vcurl = "http://webservice.valuecommerce.ne.jp/productdb/search?token=$vctoken&keyword=$v_keyword&category=$v_category&sort_by=$v_sort_by&sort_order=$v_sort_order&results_per_page=1&rank=$v_sort_rank";

// バリュコマsimpleXMLデータ取り出し配列変数に代入
$vcBuff = file_get_contents($vcurl);
$vcBuff = str_replace('vc:', 'vc', $vcBuff);
$vcBuff = str_replace('&', '&amp;', $vcBuff);
$xml = simplexml_load_string ($vcBuff);
$resultcount = h($xml->channel->vcresultcount);

 if ($resultcount != 0) {//検索件数が0件でない場合,変数$hitsに検索結果を格納します。
$hits = $xml->channel->item;
$hithairetsu=new HitsHitHairetsu;
$hithairetsu->valuecommerceitemhit($hits,$itemname,$aflinkurl,$imgurl,$price,$description,$shopname,$vcpvimg,$guid,$jancode,$souryou,$reviewnum,$reviewavr,$reviewurl,$faviconurl);
}

// 商品表示部分
// php end 
?>

<?php
if (!number_format($resultcount) == 0) {
foreach ($price as $key => $value) {
$ret ="";
$ret =DrawPageItem($itemname[$key],$imgurl[$key],$aflinkurl[$key],$price[$key],$jancode[$key],$description[$key],$vcpvimg[$key],$guid[$key],$shopname[$key],$reviewnum[$key],$reviewavr[$key],$reviewurl[$key],$faviconurl[$key]);
$ret =$ret .'<p><a href="'.$vcpagepage.'pagetype=vc&keyword='.$keyword.'">＞ 他のショップでも探す</a></p>';

} //foreach

} else {

$ret ='<p>&nbsp;</p>';

}
?>
<?php
return $ret;
}


// リンクシェア単品表示
function lsitem_func( $atts, $content = null ) {

$lstoken= get_option('ls_search_token');
if ($lstoken=="") {$lstoken=LSTOKEN;}
$ls_yahoo_appid= get_option('vc_yahoo_appid');
if ($vc_yahoo_appid=="") {$vc_yahoo_appid=VC_YAHOO_APPID;}
$vcpagepage= get_option('vc_search_page');
if ($vcpagepage=="") {$vcpagepage=VCPAGEPAGE;}

// [lsitem]属性情報取得
extract(shortcode_atts(array(
'keyword' => null,
'jancode' => null,
'category' => null,
'mid' => null,
'sort_type' => null, ), $atts));

$midtext ='';
if (isset($mid)) {
$midtext ='&mid='.$mid;
}
$ls_sort_type = $sort_type;
$ls_keyword = urlencode('"'.trim($keyword).'"'); //検索する場合は、トリムをかける

// デフォルト値の設定
if(!isset($ls_page)) $ls_page = "1";
if(!isset($ls_sort_by)) $ls_sort_by = "";
if(!isset($ls_sort_order)) $ls_sort_order = "";
if(!isset($ls_sort_type)) $ls_sort_type = 0;
if(!isset($ls_page) || $ls_page == "") $ls_page = 1;
if(!isset($ls_sort_rank)) $ls_sort_rank = "";
if(!isset($ls_jancode)) $ls_jancode = "";

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


// リンクシェアリクエストURL組み立て
if ($mid=="0" | $mid=="") {
$lsurl = "http://productsearch.linksynergy.com/productsearch?token=$lstoken&keyword=$ls_keyword&max=1&pagenumber=$ls_page&sort=retailprice&sorttype=$ls_sort_order";
} else {
$lsurl = "http://productsearch.linksynergy.com/productsearch?token=$lstoken&keyword=$ls_keyword&max=1&pagenumber=$ls_page&sort=retailprice&sorttype=$ls_sort_order&mid=$mid";
}

// リンクシェアsimpleXML,データ取り出し配列変数に代入
$lsBuff = file_get_contents($lsurl);
$xml = simplexml_load_string ($lsBuff);
$resultcount = h($xml->TotalMatches);
$totalpage = h($xml->TotalPages);

if ($resultcount != 0) {//検索件数が0件でない場合,変数$hitsに検索結果を格納します。
$hits = $xml->item;
$hithairetsu=new HitsHitHairetsu;
$hithairetsu->linkshareitemhit($hits,$itemname,$aflinkurl,$imgurl,$price,$description,$shopname,$vcpvimg,$guid,$jancode,$souryou,$reviewnum,$reviewavr,$reviewurl,$faviconurl);
} // if $resultcoundt


// 商品表示部分
// php end 
?>

<?php
if (!number_format($resultcount) == 0) {
foreach ($price as $key => $value) {
$ret ="";
$ret =DrawPageItem($itemname[$key],$imgurl[$key],$aflinkurl[$key],$price[$key],$jancode[$key],$description[$key],$vcpvimg[$key],$guid[$key],$shopname[$key],$reviewnum[$key],$reviewavr[$key],$reviewurl[$key],$faviconurl[$key]);
$ret =$ret .'<p><a href="'.$vcpagepage.'pagetype=ls&keyword='.$keyword.$midtext.'&sort_type='.$ls_sort_type.'">＞ 他のショップでも探す</a></p>';

} //foreach

} else {
$ret ='<p>&nbsp;</p>';

}
?>
<?php
return $ret;
}


// 楽天市場単品表示
function rakutenitem_func( $atts, $content = null ) {

$rakutentoken= get_option('rakuten_search_token');
if ($rakutentoken=="") {$rakutentoken=RAKUTENTOKEN;}
$rakutenaffid= get_option('rakuten_affiliate_id');
if ($rakutenaffid=="") {$rakutenaffid=RAKUTENAFFID;}
$vcpagepage= get_option('vc_search_page');
if ($vcpagepage=="") {$vcpagepage=VCPAGEPAGE;}

// [rakutenitem]属性情報取得
extract(shortcode_atts(array(
'keyword' => null,
'jancode' => null,
'category' => null,
'sort_by' => null,
'sort_order' => null,
'sort_type' => null, 
'rank' => null, ), $atts));

$rakuten_category =$category;
$rakuten_keyword =$keyword;
$rakuten_sort_by =$sort_by;
$rakuten_sort_order =$sort_order;
$rakuten_sort_type =$sort_type;
$rakuten_sort_rank=$rank;
$rakuten_jancode=$jancode;
$keyword = urlencode($rakuten_keyword);

// デフォルト値の設定
if(!isset($v_page )) $v_page  = "1";
if(!isset($rakuten_category)) $rakuten_category= "0";
if(!isset($rakuten_sort_by)) $rakuten_sort_by = "";
if(!isset($rakuten_sort_order)) $rakuten_sort_order = "";
if(!isset($rakuten_sort_type)) $rakuten_sort_type = 0;
if(!isset($v_page ) || $v_page  == "") $v_page  = 1;
if(!isset($rakuten_sort_rank)) $rakuten_sort_rank = "";
if(!isset($rakuten_jancode)) $rakuten_jancode = "";

$rakutenichibaapi = new rakutenichibaapi();
$arr_sorts = $rakutenichibaapi->arr_sorts;
$arr_categories =$rakutenichibaapi->arr_categories;

$rakutenichibaapi ->rakutensort ($rakuten_sort_type,$rakuten_sort_order);

if ((! function_exists('is_mobile') || ! is_mobile()) && (! function_exists('is_ktai')   || ! is_ktai())) {
// PCであれば・・・
$rwsurl = "http://api.rakuten.co.jp/rws/3.0/rest?developerId=$rakutentoken&affiliateId=$rakutenaffid&operation=ItemSearch&version=2009-04-15&keyword=$keyword&hits=10&availability=1&page=$v_page&genreId=$rakuten_category&sort=".urlencode($rakuten_sort_order);
} else {
// 携帯であれば・・・
$rwsurl = "http://api.rakuten.co.jp/rws/3.0/rest?developerId=$rakutentoken&affiliateId=$rakutenaffid&operation=ItemSearch&version=2009-04-15&keyword=$keyword&hits=10&availability=1&page=$v_page&genreId=$rakuten_category&carrier=1&sort=".urlencode($rakuten_sort_order);
}

$rwsBuff  = file_get_contents($rwsurl );
$rwsBuff = str_replace('header:Header', 'headerHeader', $rwsBuff);
$rwsBuff = str_replace('itemSearch:ItemSearch', 'itemSearchItemSearch', $rwsBuff);

$xml = simplexml_load_string ($rwsBuff);

$resultcount = h($xml->Body->itemSearchItemSearch->count);
$totalpage = h($xml->Body->itemSearchItemSearch->pageCount);

if (!$resultcount==0) {
$hits = $xml->Body->itemSearchItemSearch->Items->Item;
$hithairetsu=new HitsHitHairetsu;
$hithairetsu->rakutenichibaitemhit($hits,$itemname,$aflinkurl,$imgurl,$price,$description,$shopname,$vcpvimg,$guid,$jancode,$souryou,$reviewnum,$reviewavr,$reviewurl,$faviconurl);
}

// php end  商品表示部分
?>

<?php
if (!number_format($resultcount) == 0) {
foreach ($price as $key => $value) {
$ret ="";
$ret =DrawPageItem($itemname[$key],$imgurl[$key],$aflinkurl[$key],$price[$key],$jancode[$key],$description[$key],$vcpvimg[$key],$guid[$key],$shopname[$key],$reviewnum[$key],$reviewavr[$key],$reviewurl[$key],$faviconurl[$key]);
$ret =$ret .'<p><a href="'.$vcpagepage.'pagetype=rakuten&keyword='.$keyword.'&category='.$rakuten_category.'&sort_type='.$rakuten_sort_type.'">＞ 他のショップでも探す</a></p>';

} //foreach

} else {
$ret ='<p>&nbsp;</p>';

}
?>
<?php
return $ret;
}


// Amazon単品表示[amazon_vcitem]
function amazon_vcitem_func( $atts, $content = null ) {

// [amazon_vcitem]属性情報取得
extract(shortcode_atts(array(
'keyword' => null,
'category' => null,
'sort_type' => null, ), $atts));

$v_category=$category;
$v_keyword=$keyword;
$v_sort_type=$sort_type;

$vcpagepage= get_option('vc_search_page');
if ($vcpagepage=="") {$vcpagepage=VCPAGEPAGE;}

$Amazonitemsearchtapi= new Amazonitemsearchtapi();
$arr_categories = $Amazonitemsearchtapi->arr_categories;
$arr_sorts =$Amazonitemsearchtapi->arr_sorts;

// デフォルト値の設定
if(!isset($v_page)) $v_page = "";
if(!isset($v_sort_by)) $v_sort_by = "";
if(!isset($v_sort_order)) $v_sort_order = "";
if(!isset($v_sort_type)) $v_sort_type = 0;
if(!isset($v_page) || $v_page == "") $v_page = 1;
if(!isset($v_sort_rank)) $v_sort_rank = "";
if(!isset($v_jancode)) $v_jancode = "";
if(!isset($v_category)) $v_category= "All";

// ソート順設定
$Amazonitemsearchtapi->amazonsort($v_sort_type,$v_sort_order,$v_category);

// AmazonリクエストURL組み立て
$awsurl = $Amazonitemsearchtapi->awsrequesturl($v_category,$v_keyword,$v_sort_order,$v_page);

// 改ページ用パラメータ
$params = $vcpagepage . "pagetype=amazon_vc&keyword=$v_keyword&category=$v_category&sort_type=$v_sort_type";

$vcBuff = file_get_contents($awsurl);
$xml = simplexml_load_string ($vcBuff);
$resultcount = h($xml->Items->TotalResults);
$totalpage = h($xml->Items->TotalPages);

if ($resultcount != 0) {//検索件数が0件でない場合,変数$hitsに検索結果を格納します。
$hits = $xml->Items->Item;
$hithairetsu=new HitsHitHairetsu;
$hithairetsu->amazonitemhit($hits,$itemname,$aflinkurl,$imgurl,$price,$description,$shopname,$vcpvimg,$guid,$jancode,$souryou,$reviewnum,$reviewavr,$reviewurl,$faviconurl);
}
// php end  商品表示部分
?>

<?php
if (!number_format($resultcount) == 0) {
foreach ($price as $key => $value) {
$ret ="";
$ret =DrawPageItem($itemname[$key],$imgurl[$key],$aflinkurl[$key],$price[$key],$jancode[$key],$description[$key],$vcpvimg[$key],$guid[$key],$shopname[$key],$reviewnum[$key],$reviewavr[$key],$reviewurl[$key],$faviconurl[$key]);
$ret =$ret .'<p><a href="'.$params.'">＞ 他のショップでも探す</a></p>';

} //foreach

} else {
$ret ='<p>&nbsp;</p>';

}
?>
<?php
return $ret;
}



/***------------------------------------------
　検索リンク作成
------------------------------------------***/

// 商品検索リンク生成（バリューコマース）
function vc_func( $atts, $content = null ) {

// [vc]属性情報取得
extract(shortcode_atts(array(
'keyword' => null,
'jancode' => null,
'category' => null,
'sort_type' => null, ), $atts));

$vcpagepage= get_option('vc_search_page');
if ($vcpagepage=="") {$vcpagepage=VCPAGEPAGE;}
$linktext ="";


if (isset($keyword)) {
// 自由テキストリンクの場合
$keyword4url = urlencode($keyword);
$linkurl = $vcpagepage.'pagetype=vc&keyword='.$keyword4url;
} else if (isset($jancode)) {
// JANコード指定の場合※現時点ではAPIで対応していないので機能しない
$linkurl = $vcpagepage.'jancode='.$jancode;
} else {
// それ以外の[vc]で挟まれたキーワードでの検索リンクを作成する場合
$keyword4url= urlencode($content);
$linkurl = $vcpagepage.'pagetype=vc&keyword='.$keyword4url;
}

// カテゴリー指定
if (isset($category)) {
$linkurl = $linkurl."&category=". $category;
}

// ソート指定
if (isset($sort_type)) {
$linkurl = $linkurl."&sort_type=". $sort_type;
}

$linktext = '<a href="'.$linkurl.'">'.$content.'</a>';

// リンクとコンテンツを返す
return $linktext;
}


// 商品検索リンク生成(リンクシェア)
function ls_func( $atts, $content = null ) {

// [ls]属性情報取得
extract(shortcode_atts(array(
'keyword' => null,
'jancode' => null,
'mid' => null,
'category' => null,
'sort_type' => null, ), $atts));

$vcpagepage= get_option('vc_search_page');
if ($vcpagepage=="") {$vcpagepage=VCPAGEPAGE;}
$linktext ="";

if (isset($keyword)) {
// 自由テキストリンクの場合
$keyword4url = urlencode($keyword);
$linkurl = $vcpagepage.'pagetype=ls&keyword='.$keyword4url.'&mid='.$mid;
} else if (isset($jancode)) {
// JANコード指定の場合※現時点ではAPIで対応しているか調べるのは後まわし
$linkurl = $vcpagepage.'jancode='.$jancode.'&mid='.$mid;
} else {
// それ以外の[ls]で挟まれたキーワードでの検索リンクを作成する場合
$keyword4url = urlencode($content);
$linkurl = $vcpagepage.'pagetype=ls&keyword='.$keyword4url.'&mid='.$mid;
}

// カテゴリー指定
if (isset($category)) {
$linkurl = $linkurl."&category=". $category;
}

// ソート指定
if (isset($sort_type)) {
$linkurl = $linkurl."&sort_type=". $sort_type;
}

$linktext = '<a href="'.$linkurl.'">'.$content.'</a>';

// リンクとコンテンツを返す
return $linktext;
}


// 商品検索リンク生成(じゃらん)
function jalan_func( $atts, $content = null ) {

// [jalan]属性情報取得
extract(shortcode_atts(array(
'keyword' => null,
'category' => null,
'sort_type' => null, ), $atts));

$vcpagepage= get_option('vc_search_page');
if ($vcpagepage=="") {$vcpagepage=VCPAGEPAGE;}
$linktext ="";

if (isset($keyword)) {
// 自由テキストリンクの場合
$keyword= urlencode($keyword);
$linkurl = $vcpagepage.'pagetype=jalan&keyword='.$keyword;
} else {
// それ以外の[jalan]で挟まれたキーワードでの検索リンクを作成する場合
$keyword= urlencode($content);
$linkurl = $vcpagepage.'pagetype=jalan&keyword='.$keyword;
}

// ソート指定（未実装）
if (isset($sort_type)) {
$linkurl = $linkurl."&sort_type=". $sort_type;
}

$linktext = '<a href="'.$linkurl.'">'.$content.'</a>';

// リンクとコンテンツを返す
return $linktext;
}


// 検索リンク生成(Googleカスタム)
function googleco_func( $atts, $content = null ) {

// [googleco]属性情報取得
extract(shortcode_atts(array(
'keyword' => null ), $atts));

$vcpagepage= get_option('vc_search_page');
if ($vcpagepage=="") {$vcpagepage=VCPAGEPAGE;}
$linktext ="";

if (isset($keyword)) {
// 自由テキストリンクの場合
$content=$keyword;
$query4url= urlencode($keyword);
$linkurl = $vcpagepage.'pagetype=google&keyword='.$query4url;
} else {
// それ以外の[googleco]で挟まれたキーワードでの検索リンクを作成する場合
$keyword= $content;
$query4url =  urlencode($content);
$linkurl = $vcpagepage.'pagetype=google&keyword='.$query4url;
}

$linktext = '<a href="'.$linkurl.'">'.$content.'</a>';

// リンクとコンテンツを返す
return $linktext;
}




// 商品検索リンク生成(楽天市場)
function rakuten_func( $atts, $content = null ) {

// [rakuten]属性情報取得
extract(shortcode_atts(array(
'keyword' => null,
'category' => null,
'sort_type' => null, ), $atts));

$vcpagepage= get_option('vc_search_page');
if ($vcpagepage=="") {$vcpagepage=VCPAGEPAGE;}
$linktext ="";

if (isset($keyword)) {
// 自由テキストリンクの場合
$keyword4url = urlencode($keyword);
$linkurl = $vcpagepage.'pagetype=rakuten&keyword='.$keyword4url;
} else {
// それ以外の[rakuten]で挟まれたキーワードでの検索リンクを作成する場合
$keyword4url= urlencode($content);
$linkurl = $vcpagepage.'pagetype=rakuten&keyword='.$keyword4url;
}

// カテゴリー指定
if (isset($category)) {
$linkurl = $linkurl."&category=". $category;
}

// ソート指定
if (isset($sort_type)) {
$linkurl = $linkurl."&sort_type=". $sort_type;
}

$linktext = '<a href="'.$linkurl.'">'.$content.'</a>';

// リンクとコンテンツを返す
return $linktext;
}


// 商品検索リンク生成(ヤフーショッピング)
function yshopping_func( $atts, $content = null ) {

// [yshopping]属性情報取得
extract(shortcode_atts(array(
'keyword' => null,
'category' => null,
'sort_type' => null, ), $atts));

$vcpagepage= get_option('vc_search_page');
if ($vcpagepage=="") {$vcpagepage=VCPAGEPAGE;}
$linktext ="";

if (isset($keyword)) {
// 自由テキストリンクの場合
$keyword4url = urlencode($keyword);
$linkurl = $vcpagepage.'pagetype=yshopping&keyword='.$keyword4url;
} else {
// それ以外の[rakuten]で挟まれたキーワードでの検索リンクを作成する場合
$keyword4url = urlencode($content);
$linkurl = $vcpagepage.'pagetype=yshopping&keyword='.$keyword4url;
}

// カテゴリー指定
if (isset($category)) {
$linkurl = $linkurl."&category=". $category;
}

// ソート指定
if (isset($sort_type)) {
$linkurl = $linkurl."&sort_type=". $sort_type;
}

$linktext = '<a href="'.$linkurl.'">'.$content.'</a>';

// リンクとコンテンツを返す
return $linktext;
}


// 商品検索リンク生成(ヤフーオークション)
function yauction_func( $atts, $content = null ) {

// [yauction]属性情報取得
extract(shortcode_atts(array(
'keyword' => null,
'category' => null,
'sort_type' => null, ), $atts));

$vcpagepage= get_option('vc_search_page');
if ($vcpagepage=="") {$vcpagepage=VCPAGEPAGE;}
$linktext ="";

if (isset($keyword)) {
// 自由テキストリンクの場合
$keyword4url = urlencode($keyword);
$linkurl = $vcpagepage.'pagetype=yauction&keyword='.$keyword4url;
} else {
// それ以外の[rakuten]で挟まれたキーワードでの検索リンクを作成する場合
$keyword4url = urlencode($content);
$linkurl = $vcpagepage.'pagetype=yauction&keyword='.$keyword4url;
}

// カテゴリー指定
if (isset($category)) {
$linkurl = $linkurl."&category=". $category;
}

// ソート指定
if (isset($sort_type)) {
$linkurl = $linkurl."&sort_type=". $sort_type;
}

$linktext = '<a href="'.$linkurl.'">'.$content.'</a>';

// リンクとコンテンツを返す
return $linktext;
}


// 商品検索リンク生成(アクセストレード)
function actr_func( $atts, $content = null ) {

// [actr]属性情報取得
extract(shortcode_atts(array(
'keyword' => null,
'category' => null,
'sort_type' => null, ), $atts));

$vcpagepage= get_option('vc_search_page');
if ($vcpagepage=="") {$vcpagepage=VCPAGEPAGE;}
$linktext ="";

if (isset($keyword)) {
// 自由テキストリンクの場合
$keyword= urlencode($keyword);
$linkurl = $vcpagepage.'pagetype=actr&keyword='.$keyword;
} else {
// それ以外の[rakuten]で挟まれたキーワードでの検索リンクを作成する場合
$keyword= urlencode($content);
$linkurl = $vcpagepage.'pagetype=actr&keyword='.$keyword;
}

// カテゴリー指定
if (isset($category)) {
$linkurl = $linkurl."&category=". $category;
}

// ソート指定
if (isset($sort_type)) {
$linkurl = $linkurl."&sort_type=". $sort_type;
}

$linktext = '<a href="'.$linkurl.'">'.$content.'</a>';

// リンクとコンテンツを返す
return $linktext;
}


// 商品検索リンク生成(Amazon)
function amazon_vc_func( $atts, $content = null ) {

// [amazon_vc]属性情報取得
extract(shortcode_atts(array(
'keyword' => null,
'category' => null,
'sort_type' => null, ), $atts));

$vcpagepage= get_option('vc_search_page');
if ($vcpagepage=="") {$vcpagepage=VCPAGEPAGE;}
$linktext ="";

if (isset($keyword)) {
// 自由テキストリンクの場合
$keyword= urlencode($keyword);
$linkurl = $vcpagepage.'pagetype=amazon_vc&keyword='.$keyword;
} else {
// それ以外の[rakuten]で挟まれたキーワードでの検索リンクを作成する場合
$keyword= urlencode($content);
$linkurl = $vcpagepage.'pagetype=amazon_vc&keyword='.$keyword;
}

// カテゴリー指定
if (isset($category)) {
$linkurl = $linkurl."&category=". $category;
}

// ソート指定
if (isset($sort_type)) {
$linkurl = $linkurl."&sort_type=". $sort_type;
}

$linktext = '<a href="'.$linkurl.'">'.$content.'</a>';

// リンクとコンテンツを返す
return $linktext;
}

// 商品検索リンク生成(じゃらん検索リンク生成)
function jalanareasearch_func( $atts, $content = null ) {
$linktext ="";
$vcpagepage= get_option('vc_search_page');
if ($vcpagepage=="") {$vcpagepage=VCPAGEPAGE;}
$linktext ='<script type="text/javascript" src="'.WP_PLUGIN_URL.'/vc-search/area_data.js"></script>';
$linktext .='<script type="text/javascript" src="'.WP_PLUGIN_URL.'/vc-search/area.js"></script>';
//$linktext .='<form action="http://wplocaltest/?page_id=3" method="get">';
if (stristr($vcpagepage,"&")) {

$linktext .='<form action="'.$vcpagepage.'" method="get">';
$linktext .='<input type="hidden" name="page_id" value="3" />';
} else {
$linktext .='<form action="'.$vcpagepage.'" method="get">';
}
$linktext .='<input type="hidden" name="pagetype" value="jalan" />';
$linktext .='<select class="area_pd" name="pref" id="pref" onChange="changeLargeArea(this)"><option value="" selected>都道府県</option></select>';
$linktext .='<select class="area_pd" name="l_area" id="l_area" onChange="changeSmallArea(this)"><option value="" selected>大エリア</option></select>';
$linktext .='<select class="area_pd" name="s_area" id="s_area"><option value="" selected>小エリア</option></select>';
$linktext .='<script type="text/javascript">';
$linktext .='initAreaPulldown();';
$linktext .='</script> ';
$linktext .='<input type="submit" value="エリアで検索" />';
$linktext .='</form>';


// コンテンツを返す
return $linktext;
}

// 知恵袋chiebukuro
function chiebukuro_search_func( $atts, $content = null ) {
$vc_yahoo_appid= get_option('vc_yahoo_appid');
if ($vc_yahoo_appid=="") {$vc_yahoo_appid=VC_YAHOO_APPID;}
// [chiebukuros]属性情報取得
extract(shortcode_atts(array(
'keyword' => null,
'results' => null,
'charnum' => null,
 ), $atts));

$keyword4url=urlencode($keyword);
$url="http://chiebukuro.yahooapis.jp/Chiebukuro/V1/questionSearch?appid=$vc_yahoo_appid&query=$keyword4url&condition=solved&results=$results";

$xml=simplexml_load_file($url);
$hits=$xml->Result->Question;
$ret="";
foreach ($hits as $hit) {
$ret.="<p>";
$ret.='<div class="vcchiebukuroq">Q.'.nl2br($hit->Content).'</div>';

$answer = nl2br($hit->BestAnswer);
switch ($charnum) {
    case "1":
        $answer = mb_substr ($answer,0,100,"utf-8")."...";
        break;
    case "2":
        $answer = mb_substr ($answer,0,200,"utf-8")."...";
        break;
    case "3":
        $answer = mb_substr ($answer,0,300,"utf-8")."...";
        break;
}

$answer = str_replace("。","。<br>",$answer);

$ret.='<div class="vcchiebukuroa">A.'.$answer.'<br>';
$ret.='<a href="'.h($hit->Url).'">詳しくはこちら</a></div>';

}

$ret.= <<<EOF
<p>
<!-- Begin Yahoo! JAPAN Web Services Attribution Snippet -->
<a href="http://developer.yahoo.co.jp/about">
<img src="http://i.yimg.jp/images/yjdn/yjdn_attbtn1_125_17.gif" title="Webサービス by Yahoo! JAPAN" alt="Web Services by Yahoo! JAPAN" width="125" height="17" border="0" style="margin:15px 15px 15px 15px"></a>
<!-- End Yahoo! JAPAN Web Services Attribution Snippet -->
</p>
EOF;



// コンテンツを返す
return $ret;
}


// Amazon to Jan
function amazonjan_func( $atts, $content = null ) {

// データベースから設定情報を読み込む
$vcpagepage= get_option('vc_search_page');
if ($vcpagepage=="") {$vcpagepage=VCPAGEPAGE;}
$amzacckey=get_option('amzacckey');
if ($amzacckey==="") {$amzacckey==AMZACCKEY;}
$amzseckey=get_option('amzseckey');
if ($amzseckey==="") {$amzseckey==AMZSECKEY;}
$amzassid=get_option('amzassid');
if ($amzassid==="") {$amzassid==AMZASSID;}
$vc_yahoo_appid= get_option('vc_yahoo_appid');
if ($vc_yahoo_appid=="") {$vc_yahoo_appid=VC_YAHOO_APPID;}
$yauc_sid=get_option('yauc_sid');
if ($yauc_sid=="") {$yauc_sid=YAUC_SID;}
$yauc_pid=get_option('yauc_pid');
if ($yauc_pid=="") {$yauc_pid=YAUC_PID;}

// 配列変数の初期化
$hits = array();
$itemname = array();
$aflinkurl = array();
$imgurl = array();
$price = array();
$description = array();
$shopname = array();
$vcpvimg = array();
$guid = array();
$jancode = array(); //重要。上記で変数に入れているが下記からは配列変数
$souryou = array();
$reviewnum = array();
$reviewavr = array();
$reviewurl = array();
$faviconurl = array();

// [amazonjan]属性情報取得
extract(shortcode_atts(array(
'keyword' => null,
'asin' => null,), $atts));

// 最低価格と最高価格の設定
$minprice = "100";
$maxprice = "1000000";

// フォームに入力されたキーワードを取り出してURLエンコードする
$query = $keyword;
$asinno = $asin;
$query4url = urlencode($query); // URLエンコード


// ■Amazon.co.jpの処理■

$awsitem=new Amazonitemsearchtapi;
$awsurl = $awsitem->Awsitemlookupurl($asinno);

$xml = simplexml_load_file ($awsurl);
$amaitem = $xml->Items->Item;
$jancode = $amaitem->ItemAttributes->EAN;

$ngword="";
$heiretsuapi= new heiretsuapi();
$keyword=$query4url;
$heiretsuapi->heiretsuget($keyword,$ngword,$jancode,$xml_ywsurl,$xml_rwsurl,$xml_lsurl,$xml_vcurl,$xml_aturl,$xml_awsurl,$xml_yacurl);


// ■各社データを配列変数へ格納■
$hithairetsu=new HitsHitHairetsu;

// ■YAHOO!ショッピングの処理■

$xml = simplexml_load_string ($xml_ywsurl);
$resultcount = h($xml["totalResultsAvailable"]);
$totalpage = h($xml["totalResultsAvailable"] / 10);

if ($resultcount!= 0) {
$hits = $xml->Result->Hit;
$hithairetsu->yahooshoppingitemhit($hits,$itemname,$aflinkurl,$imgurl,$price,$description,$shopname,$vcpvimg,$guid,$jancode,$souryou,$reviewnum,$reviewavr,$reviewurl,$faviconurl);
}


// ■楽天市場の処理■
$rwsBuff = str_replace('header:Header', 'headerHeader', $xml_rwsurl);//置換
$rwsBuff = str_replace('itemSearch:ItemSearch', 'itemSearchItemSearch', $rwsBuff);//置換
$xml = simplexml_load_string ($rwsBuff);//置換されたXMLデータを処理

$resultcount = h($xml->Body->itemSearchItemSearch->count);
$totalpage = h($xml->Body->itemSearchItemSearch->pageCount);

if (!$resultcount==0) {
$hits = $xml->Body->itemSearchItemSearch->Items->Item;
$hithairetsu->rakutenichibaitemhit($hits,$itemname,$aflinkurl,$imgurl,$price,$description,$shopname,$vcpvimg,$guid,$jancode,$souryou,$reviewnum,$reviewavr,$reviewurl,$faviconurl);
}


// ■リンクシェアの処理■
$xml = simplexml_load_string ($xml_lsurl);

$resultcount = h($xml->TotalMatches);
$totalpage = h($xml->TotalPages);

if ($resultcount != 0) {//検索件数が0件でない場合,変数$hitsに検索結果を格納します。
$hits = $xml->item;
$hithairetsu->linkshareitemhit($hits,$itemname,$aflinkurl,$imgurl,$price,$description,$shopname,$vcpvimg,$guid,$jancode,$souryou,$reviewnum,$reviewavr,$reviewurl,$faviconurl);
} // if $resultcoundt



// ■バリューコマースの処理■
$vcBuff = str_replace('vc:', 'vc', $xml_vcurl);
$xml = simplexml_load_string ($vcBuff);

$resultcount = h($xml->channel->vcresultcount);
$totalpage = h($xml->channel->vcpagecount);

 if ($resultcount != 0) {//検索件数が0件でない場合,変数$hitsに検索結果を格納します。
$hits = $xml->channel->item;
$hithairetsu->valuecommerceitemhit($hits,$itemname,$aflinkurl,$imgurl,$price,$description,$shopname,$vcpvimg,$guid,$jancode,$souryou,$reviewnum,$reviewavr,$reviewurl,$faviconurl);
}


// ■アクセストレードの処理■
$xml = simplexml_load_string ($xml_aturl);
$resultcount = h($xml->TotalCount);
$totalpage = h($xml->TotalPage);
if (!$resultcount==0) {
$hits = $xml->Goods;
$hithairetsu->actritemhit($hits,$itemname,$aflinkurl,$imgurl,$price,$description,$shopname,$vcpvimg,$guid,$jancode,$souryou,$reviewnum,$reviewavr,$reviewurl,$faviconurl);
} // if


// ■ヤフオクの処理■
// ヤフオクリクエストURL組み立て
$yacquery= $query4url . urlencode(" ") . h($amaitem->ItemAttributes->Artist);
//V1
//$yacurl = "http://auctions.yahooapis.jp/AuctionWebService/V1/Search?appid=$vc_yahoo_appid&query=$yacquery&aucminprice=$minprice&aucmaxprice=$maxprice&sort=cbids&order=a";
$yacurl = "http://auctions.yahooapis.jp/AuctionWebService/V2/search?appid=$vc_yahoo_appid&query=$yacquery&aucminprice=$minprice&aucmaxprice=$maxprice&sort=cbids&order=a";

$yacBuff = file_get_contents($yacurl);
$xml = simplexml_load_string ($yacBuff);
$yaitems = $xml->Result->Item;

// 値段安い順番に並び替える（全部）
asort($price); 

$ret = '<p>amazon.co.jpでの商品名：<a href="'.h($amaitem->DetailPageURL).'" target="_blank">'.h($amaitem->ItemAttributes->Title).'</a></p>';
$ret .= '<img src="'.h($amaitem->MediumImage->URL) .'"><a href="'. h($amaitem->DetailPageURL).'" target="_blank"></a>';
if (isset($amaitem->ItemAttributes->Artist)) {
$ret .= 'アーティスト：<a href="'.$vcpagepage.'artist='. urlencode(h($amaitem->ItemAttributes->Artist)).'">'. h($amaitem->ItemAttributes->Artist).'</a><br />';
}
if (is_array($amaitem->ItemAttributes->Creator)) {
$ret .= 'クリエイター：';
foreach ($amaitem->ItemAttributes->Creator as $hit) {
$ret .= $hit.",";
}
}
$ret .= '<br />';
if (isset($amaitem->ItemAttributes->ListPrice->Amount)) {
$ret .= '参考価格：'. number_format(intval($amaitem->ItemAttributes->ListPrice->Amount)).'円　';
}
if (isset($amaitem->OfferSummary->LowestNewPrice->Amount)) {
$ret .= '販売価格：<span class="price">'.number_format(intval($amaitem->OfferSummary->LowestNewPrice->Amount)).'</span>円<br />';
}
$ret .= 'セールスランキング：'.h($amaitem->SalesRank).'<br />';
$ret .= 'リリース日：'.h($amaitem->ItemAttributes->ReleaseDate).'<br />';
if (isset($amaitem->ItemAttributes->Label)) {
$ret .= 'レーベル：'.h($amaitem->ItemAttributes->Label).'<br />';
}
if (isset($amaitem->ItemAttributes->Manufacturer)) {
$ret .= h($amaitem->ItemAttributes->Manufacturer).'<br />';
}
if (isset($amaitem->ItemAttributes->Publisher)) {
$ret .= 'パブリッシャー：'.h($amaitem->ItemAttributes->Publisher).'<br />';
}
if (isset($amaitem->ItemAttributes->NumberOfDiscs)) {
$ret .= '<!--CD枚数：'.h($amaitem->ItemAttributes->NumberOfDiscs).'<br />-->';
}
$ret .= 'プロダクトグループ：'.h($amaitem->ItemAttributes->ProductGroup).'<br />';
$ret .= 'EANコード：'.h($amaitem->ItemAttributes->EAN).'　ASIN:'.h($amaitem->ASIN); 
$ret .= '<br />';

if (isset($amaitem->Tracks->Disc)) {
$ret .= '<h3>トラック情報</h3>';
foreach ($amaitem->Tracks->Disc as $disc) {
	$ret .= "<ol>";
	foreach ($disc->Track as $track) {
$ret .= "<li>".h($track)."</li>";
	}
$ret .= "</ol>";
}
}

$ret .= "<h3>この商品を買った人はこんな商品も買っています</h3>";

foreach ($amaitem->SimilarProducts->SimilarProduct as $hit) {
$ret .= '<a href="'.$vcpagepage.'pagetype=asin&asin='.h($hit->ASIN).'">';
$ret .= h($hit->Title)."(".h($hit->ASIN).")<br />";
$ret .='</a>';
}
$ret .= "<br />";

if ($amaitem->CustomerReviews->TotalReviews) {
$ret .= "<h3>カスタマレビュー</h3>";
$ret .= "平均点　". h($amaitem->CustomerReviews->AverageRating)."　件数　".h($amaitem->CustomerReviews->TotalReviews)."件<br />";
$ret .= "<br />";
}

if (is_array($amaitem->CustomerReviews->Review)) {
foreach ($amaitem->CustomerReviews->Review as $hit) {
$ret .= "<strong>" . h($hit->Summary) . "</strong>　評価：" . h($hit->Rating) . "<br />";
$ret .= $hit->Content."<br /><br />";
}
}

$ret .="<h3>この商品を他のお店で買う</h3>";
$i=0;// カウンタとして$iを使用。$iを0にセット
$ret .="<p><ul>";
foreach ($price as $key => $value) {
$ret .= '<li><a href="'.$linkurl[$key].'" target="_blank">'.$shopname[$key].'</a>';
$ret .= '税込価格：<span class="price">'.number_format($price[$key]).'円</span>　';
if (strlen($souryou[$key])) {$ret .= "（".$souryou[$key]."）"; } 
$ret .="</li>";
$i=$i+1;// カウンタの値をプラス1する
 //if ($i==10) {break;}
}
$ret .= "</ul>";

$ret .="<h3>「".urldecode($yacquery)."」をヤフオクで物色する</h3>";
$i=0;// カウンタとして$iを使用。$iを0にセット
$ret .="<p>";
foreach ($yaitems as $hit) {
$linkurl = "http://ck.jp.ap.valuecommerce.com/servlet/referral?sid=$yauc_sid&pid=$yauc_pid&vc_url=" . urlencode(h($hit->AuctionItemUrl));
if (strlen($hit->Image)) {
	$imgurl = h($hit->Image);
} else {
	$imgurl = "c_img/noimage.gif";
}
$pricebuff = h($hit->CurrentPrice);
$pricebuff = str_replace('.00', '', $pricebuff);
$pricebuff = str_replace(',', '', $pricebuff);
$price = intval($pricebuff);

$ret .= "<h4>".h($hit->title)."</h4>";
$ret .= '<div class="vc-itempic" style="background: transparent url('.$imgurl.') no-repeat scroll center center; -moz-background-clip: -moz-initial; -moz-background-origin: -moz-initial; -moz-background-inline-policy: -moz-initial;"><a href="'.$linkurl.'" target="_blank"><img src="'.WP_PLUGIN_URL.'/vc-search/c_img/spacer.gif" class="vc-line-height"/></a></div>';
$ret .= '現在価格：<span class="vc-price">'.number_format($price).'円</span><br />';
$ret .= '<a href="'.$linkurl.'" target="_blank">この商品の詳細をヤフオクで確認する</a>';

$ret .= '<div class="vc-pic">&nbsp;</div>';
$i=$i+1;// カウンタの値をプラス1する
//if ($i==10) {break;}
}

return $ret;

}

// 最安値検索
function saiyasune_func( $atts, $content = null ) {

// データベースから設定情報を読み込む
$vcpagepage= get_option('vc_search_page');
if ($vcpagepage=="") {$vcpagepage=VCPAGEPAGE;}

// [saiyasune]属性情報取得
extract(shortcode_atts(array(
'keyword' => null,
'ngword' => null,
'jancode' => null, ), $atts));

$heiretsuapi= new heiretsuapi();
$heiretsuapi->heiretsuget($keyword,$ngword,$jancode,$xml_ywsurl,$xml_rwsurl,$xml_lsurl,$xml_vcurl,$xml_aturl,$xml_awsurl,$xml_yacurl);

// 配列変数の初期化
$hits = array();
$itemname = array();
$aflinkurl = array();
$imgurl = array();
$price = array();
$description = array();
$shopname = array();
$vcpvimg = array();
$guid = array();
$jancode = array(); //重要。上記で変数に入れているが下記からは配列変数
$souryou = array();
$reviewnum = array();
$reviewavr = array();
$reviewurl = array();
$faviconurl = array();

// ■各社データを配列変数へ格納■
// ■YAHOO!ショッピングの処理■
$xml = simplexml_load_string ($xml_ywsurl);
if ($xml["totalResultsReturned"] != 0) {
	$hits = $xml->Result->Hit;
}

foreach ($hits as $hit) {
$itemname[] = h($hit->Name);
$aflinkurl[] = h($hit->Url);
if ($hit->Store->Id == "engei" or $hit->Store->Id == "dinos" or $hit->Store->Id == "fobcoop" or $hit->Store->Id == "ottojapan") {
	$imgurl[] = "c_img/linksakidegazo.gif";
} else {
	$imgurl[] = h($hit->Image->Medium);
}
$price[] = h($hit->Price);
$description[] = h($hit->Description);
$shopname[] = h($hit->Store->Name);
$vcpvimg[] = "";
$guid[] = "";
$jancode[] = "";
$souryou[] = h($hit->Shipping->Name);
$reviewnum[] = h($hit->Review->Count);
$reviewavr[] = h($hit->Review->Rate);
$reviewurl[] = h($hit->Review->Url);
$faviconurl[] = "http://shopping.yahoo.co.jp/";
}


// ■楽天市場の処理■
$rwsBuff = str_replace('header:Header', 'headerHeader', $xml_rwsurl);//置換
$rwsBuff = str_replace('itemSearch:ItemSearch', 'itemSearchItemSearch', $rwsBuff);//置換
$xml = simplexml_load_string ($rwsBuff);//置換されたXMLデータを処理

$resultcount = h($xml->Body->itemSearchItemSearch->count);
$totalpage = h($xml->Body->itemSearchItemSearch->pageCount);

if (!$resultcount==0) {
$hits = $xml->Body->itemSearchItemSearch->Items->Item;
$hithairetsu=new HitsHitHairetsu;
$hithairetsu->rakutenichibaitemhit($hits,$itemname,$aflinkurl,$imgurl,$price,$description,$shopname,$vcpvimg,$guid,$jancode,$souryou,$reviewnum,$reviewavr,$reviewurl,$faviconurl);
}



// ■リンクシェアの処理■
$xml = simplexml_load_string ($xml_lsurl);

$resultcount = h($xml->TotalMatches);
$totalpage = h($xml->TotalPages);

if ($resultcount != 0) {//検索件数が0件でない場合,変数$hitsに検索結果を格納します。
$hits = $xml->item;
$hithairetsu=new HitsHitHairetsu;
$hithairetsu->linkshareitemhit($hits,$itemname,$aflinkurl,$imgurl,$price,$description,$shopname,$vcpvimg,$guid,$jancode,$souryou,$reviewnum,$reviewavr,$reviewurl,$faviconurl);
} // if $resultcoundt



// ■バリューコマースの処理■
$vcBuff = str_replace('vc:', 'vc', $xml_vcurl);
$xml = simplexml_load_string ($vcBuff);
$resultcount = h($xml->channel->vcresultcount);

 if ($resultcount != 0) {//検索件数が0件でない場合,変数$hitsに検索結果を格納します。
$hits = $xml->channel->item;
$hithairetsu=new HitsHitHairetsu;
$hithairetsu->valuecommerceitemhit($hits,$itemname,$aflinkurl,$imgurl,$price,$description,$shopname,$vcpvimg,$guid,$jancode,$souryou,$reviewnum,$reviewavr,$reviewurl,$faviconurl);
}



// ■アクセストレードの処理■
$xml = simplexml_load_string ($xml_aturl);
$resultcount = h($xml->TotalCount);
$totalpage = h($xml->TotalPage);
if (!$resultcount==0) {
$hits = $xml->Goods;
$hithairetsu=new HitsHitHairetsu;
$hithairetsu->actritemhit($hits,$itemname,$aflinkurl,$imgurl,$price,$description,$shopname,$vcpvimg,$guid,$jancode,$souryou,$reviewnum,$reviewavr,$reviewurl,$faviconurl);
} // if


// ■Amazon.co.jpの処理■
$xml = simplexml_load_string ($xml_awsurl);
$resultcount = h($xml->Items->TotalResults);
$totalpage = h($xml->Items->TotalPages);

if ($resultcount != 0) {//検索件数が0件でない場合,変数$hitsに検索結果を格納します。
$hits = $xml->Items->Item;
$hithairetsu=new HitsHitHairetsu;
$hithairetsu->amazonitemhit($hits,$itemname,$aflinkurl,$imgurl,$price,$description,$shopname,$vcpvimg,$guid,$jancode,$souryou,$reviewnum,$reviewavr,$reviewurl,$faviconurl);
}


// ■ヤフオクの処理■
$xml = simplexml_load_string ($xml_yacurl);
$resultcount = h($xml["totalResultsAvailable"] );
$totalpage = h($xml["totalResultsAvailable"] /50);

if ($resultcount!= 0) {//検索件数が0件でない場合,変数$hitsに検索結果を格納します。
$hits = $xml->Result->Item;
$hithairetsu=new HitsHitHairetsu;
$hithairetsu->yahooauctionitemhit($hits,$itemname,$aflinkurl,$imgurl,$price,$description,$shopname,$vcpvimg,$guid,$jancode,$souryou,$reviewnum,$reviewavr,$reviewurl,$faviconurl);
}

// 値段安い順番に並び替える（全部）
asort($price);

$i=0;// カウンタとして$iを使用。$iを0にセット
$ret ="<p>";
foreach ($price as $key => $value) {
$ret .= DrawPageItem($itemname[$key],$imgurl[$key],$aflinkurl[$key],$price[$key],$jancode[$key],$description[$key],$vcpvimg[$key],$guid[$key],$shopname[$key],$reviewnum[$key],$reviewavr[$key],$reviewurl[$key],$faviconurl[$key]);

	$i=$i+1;// カウンタの値をプラス1する
	if ($i==25) {break;}
	}
$ret .="</p>";
// コンテンツを返す

return $ret;


}


// その他関数

// ■Item描画：商品や施設などアイテムを１アイテムごとにパラメータを受け取り表示する
function DrawPageItem($itemname,$imgurl,$linkurl,$price,$jancode,$description,$vcpvimg,$guid,$shopname,$reviewnum,$reviewavr,$reviewurl,$favicon) {
$custum_draw_on=get_option('custum_draw_on');
$custum_draw_template=get_option('custum_draw_template');
$ret ="";

// 携帯・PC振り分け（ktai Styleがインストールされていて携帯表示しているかで判別）

if ((! function_exists('is_mobile') || ! is_mobile()) && (! function_exists('is_ktai')   || ! is_ktai())) {

// PCであれば・・・
if ($custum_draw_on==0) {
// 通常テンプレートの場合
$ret ="<h3>$itemname</h3>";
$ret .= '<div class="vc-itempic" style="background: transparent url(\''.$imgurl.'\') no-repeat scroll center center; -moz-background-clip: -moz-initial; -moz-background-origin: -moz-initial; -moz-background-inline-policy: -moz-initial;"><a href="'. $linkurl.'" target="_blank"><img src="'.WP_PLUGIN_URL.'/vc-search/c_img/spacer.gif" class="vc-line-height" alt="" /></a></div>';
 if (!$price == 0) { 
$ret .= '参考価格：<span class="vc-price">'. number_format($price).'円</span><br />';
}
$ret .=  mb_substr ($description,0,200,"utf-8");
$ret .=  "...<br />";
if (!$reviewnum=="") {
$ret .=  "レビュー件数".$reviewnum."件　";
}
if (!$reviewavr=="") {
$ret .=  "レビュー平均点".$reviewavr."点　";
}

$ret .=  "<br />";
//$ret .=  $jancode;
$ret .=  '<a href="'. $linkurl.'" target="_blank">この商品の詳細はこちら'.$vcpvimg.'</a><br />';
$ret .=  '<img src="http://favicon.hatena.ne.jp/?url='.urlencode($favicon).'" />'.$shopname; 
$ret .=  '<div class="vc-pic">&nbsp;</div>';
} else if ($custum_draw_on==1) {
// カスタムテンプレートの場合
$custum_draw_template=str_replace('\\','',$custum_draw_template);
$custum_draw_template=str_replace('【商品名】',$itemname,$custum_draw_template);
$custum_draw_template=str_replace('【商品リンク】',$linkurl,$custum_draw_template);
$custum_draw_template=str_replace('【商品画像】',$imgurl,$custum_draw_template);
// 0円の場合の処理を後日考える
$custum_draw_template=str_replace('【参考価格】',number_format($price),$custum_draw_template);
$custum_draw_template=str_replace('【商品説明】',mb_substr ($description,0,200,"utf-8")."...",$custum_draw_template);
$custum_draw_template=str_replace('【計測イメージタグ】',$vcpvimg,$custum_draw_template);
$ret = $custum_draw_template;
} else {
// ショーウィンドウ風
$ret ='<div class="vcitemwindow">';
$ret .= '<!--<div class="vcitemicon">SALE</div>';
$ret .= '<div class="vcitemicon">送料無料</div>-->';
$ret .= '<div class="vcitemimage" align="center"><div class="vc-itempic2" style="background: transparent url(\''.$imgurl.'\') no-repeat scroll center center; -moz-background-clip: -moz-initial; -moz-background-origin: -moz-initial; -moz-background-inline-policy: -moz-initial;"><a href="'. $linkurl.'" target="_blank"><img src="'.WP_PLUGIN_URL.'/vc-search/c_img/spacer.gif" class="vc-line-height2" alt="" /></a></div></div>';
$ret .= '<div class="vcitemname"><a href="'.$linkurl.'">'.mb_substr ($itemname,0,26,"utf-8").'...</a></div>';
$ret .= '<div class="vcitemdisc">'.mb_substr ($description,0,50,"utf-8").'...</div>';

if (!$reviewnum=="") {
$ret .= '<div class="vcitemreview">レビュー件数'.$reviewnum.'件</div>';
}
if (!$reviewavr=="") {
$ret .= '<div class="vcitemreview">レビュー平均点'.$reviewavr.'点</div>';
}
$ret .= '<div class="vcitemprice">'.number_format($price).'円</div>';
$ret .= '</div>';
} // if else

} else {

// 携帯であれば
$ret ="<h3>$itemname</h3>";
$ret .=  '<a href="'. $linkurl.'" target="_blank"><img src="'.$imgurl.'" /></a><br />';
 if (!$price == 0) { 
$ret .= '参考価格：'. number_format($price).'円<br />';
}
$ret .=  mb_substr ($description,0,100,"utf-8");
$ret .=  "...<br />";
$ret .=  '<a href="'. $linkurl.'" target="_blank">詳細はこちら'.$vcpvimg.'</a><br />';
$ret .=  $jancode;
$ret .= $shopname; 


} // 携帯分岐のelse

// Javascript modeがonならば
$javascript_draw_mode=get_option('javascript_draw_mode');
if ($javascript_draw_mode==1) {
	$ret = str_replace("transparent url('", "transparent url(\'", $ret);
	$ret = str_replace("') no-repeat scroll center center", "\') no-repeat scroll center center", $ret);
	$ret = "<script type=\"text/javascript\">
	document.open();
	document.write('".$ret."');
	document.close();
	</script>";

	return $ret;
} else {
	return $ret;
}// if javascript
}



// ■YAHOO!SHOPPING 急上昇キーワード抽出
function kyujosho() {
$vcpagepage= get_option('vc_search_page');
if ($vcpagepage=="") {$vcpagepage=VCPAGEPAGE;}
$vc_yahoo_appid= get_option('vc_yahoo_appid');
if ($vc_yahoo_appid=="") {$vc_yahoo_appid=VC_YAHOO_APPID;}

// YAHOO!ショッピングリクエストURL組み立て
$ywsurl = "http://shopping.yahooapis.jp/ShoppingWebService/V1/queryRanking?appid=$vc_yahoo_appid&type=up&hits=10";
$xml = simplexml_load_file ($ywsurl);
if (!$xml[totalResultsReturned]==0) {
$kyujoshohits = $xml->Result->QueryRankingData;
}
return $kyujoshohits;
}


// ■バリューコマースカテゴリ検索
function vc_category() {
$vctoken= get_option('vc_search_token');
if ($vctoken=="") {$vctoken=VCTOKEN;}
$vcpagepage= get_option('vc_search_page');
if ($vcpagepage=="") {$vcpagepage=VCPAGEPAGE;}

$vccurl = "http://webservice.valuecommerce.ne.jp/productdb/category?token=$vctoken&category_level=1";

// バリュコマsimpleXML,データ取り出し配列変数に代入
$vcBuff = file_get_contents($vccurl);
$vcBuff = str_replace('vc:', 'vc', $vcBuff);
$vcBuff = str_replace('&', '&amp;', $vcBuff);
$xml = simplexml_load_string ($vcBuff);
$items = $xml->channel->item;

foreach ($items as $item) {
$categoryname = h($item->title);
$categorymei = h($item->description);
echo '<h3><a href="'.$vcpagepage.'pagetype=vc&category='.$categoryname.'">' .$categorymei.'</a></h3>';
$childs = $item->vcchildCategory;
foreach ($childs as $child) {
$categoryname = h($child->title);
$categorymeic = str_replace($categorymei.',','',h($child->description));
echo '<a href="'.$vcpagepage.'pagetype=vc&category='.$categoryname.'">' .$categorymeic .'</a>&nbsp;';
}

}

}

// ■Yahoo Creditクレジット表示：関数を呼び出すだけでYahoo!クレジットを呼び出す。ヤフーAPIを利用している時に使う
function yahoocredit() {
echo  <<<EOF
<p>
<!-- Begin Yahoo! JAPAN Web Services Attribution Snippet -->
<a href="http://developer.yahoo.co.jp/about">
<img src="http://i.yimg.jp/images/yjdn/yjdn_attbtn1_125_17.gif" title="Webサービス by Yahoo! JAPAN" alt="Web Services by Yahoo! JAPAN" width="125" height="17" border="0" style="margin:15px 15px 15px 15px"></a>
<!-- End Yahoo! JAPAN Web Services Attribution Snippet -->
</p>
EOF;
}

/**
　参考：http://akabeko.sakura.ne.jp/blog/2009/12/wordpress-%E3%83%97%E3%83%A9%E3%82%B0%E3%82%A4%E3%83%B3%E3%81%A7%E3%82%A8%E3%83%87%E3%82%A3%E3%82%BF%E3%81%AB%E3%83%9C%E3%82%BF%E3%83%B3%E3%82%92%E8%BF%BD%E5%8A%A0%E3%81%99%E3%82%8B-2/
 * MCE ツールバーが初期化される時に発生します。
 */
function onMceInitButtons()
{
	// 編集権限のチェック
	if( !current_user_can( "edit_posts" ) && !current_user_can( "edit_pages" ) ) { return; }

	// ビジュアル エディタ時のみ追加
	if( get_user_option( "rich_editing" ) == "true" )
	{
		add_filter( "mce_buttons",          "onMceButtons"         );
		add_filter( "mce_external_plugins", "onMceExternalPlugins" );
		
//	} else {
	$pluginDirUrl = WP_PLUGIN_URL . "/" . array_pop( explode( DIRECTORY_SEPARATOR, dirname( __FILE__ ) ) ) . "/";
	// echo '<script type="text/javascript" src="' . $pluginDirUrl . '/quicktag.js"></script>';
	}
}

/**
 * MCE ツールバーにボタンが追加される時に発生します。
 *
 * @param	$buttons	ボタンのコレクション。
 */
function onMceButtons( $buttons )
{
	array_push( $buttons, "separator", "VC");
	return $buttons;
}

/**
 * MCE ツールバーのボタン処理が登録される時に発生します。
 *
 * @param	$plugins	ボタンの処理のコレクション。
 */
function onMceExternalPlugins( $plugins )
{
	$pluginDirUrl = WP_PLUGIN_URL . "/" . array_pop( explode( DIRECTORY_SEPARATOR, dirname( __FILE__ ) ) ) . "/";
	$plugins[ "VCSearchButtons" ] = "{$pluginDirUrl}mce.js";
	return $plugins;
}



// WordPressプラグインとして登録するもの（ショートコードなど）

// TinyMCEアクションの登録
if( is_admin() ) {add_action('init', "onMceInitButtons" );}

// ヘッダにJavascript登録
function add_vc_gajax() {
$google_ajax_apikey=get_option('google_ajax_apikey');
if ($google_ajax_apikey=="") {$google_ajax_apikey==GOOGLE_AJAX_APIKEY;}
$google_custom_id=get_option('google_custom_id');
if ($google_custom_id=="") {$google_ajax_apikey==GOOGLE_CUSTOM_ID;}
$google_custom_name=get_option('google_custom_name');
if ($google_custom_name=="") {$google_ajax_apikey==GOOGLE_CUSTOM_NAME;}
$v_keyword =$_GET["keyword"];
$keyword=h($v_keyword);
echo '<script type="text/javascript" src="http://www.google.com/jsapi?key='.$google_ajax_apikey.'"></script>
    <script type="text/javascript">
      google.load("search", "1");

      // Call this function when the page has been loaded
      function initialize() {
        var searchControl = new google.search.SearchControl()
		;';

if (!$google_custom_id=="") {

echo '
		// カスタム検索
		searcher = new google.search.WebSearch();
        options = new  google.search.SearcherOptions();
        searcher.setSiteRestriction("'.$google_custom_id.'");
        searcher.setUserDefinedLabel("'.$google_custom_name.'");
        searchControl.addSearcher(searcher, options);';
}

echo'        searchControl.addSearcher(new google.search.WebSearch());
        searchControl.addSearcher(new google.search.NewsSearch());
		searchControl.addSearcher(new google.search.VideoSearch());
		searchControl.addSearcher(new google.search.BlogSearch());
		searchControl.addSearcher(new google.search.ImageSearch());
		searchControl.addSearcher(new google.search.BookSearch());
		searchControl.addSearcher(new google.search.PatentSearch());

		searchControl.draw(document.getElementById("searchcontrol"));
		searchControl.execute("'.$keyword.'");

		// create a drawOptions object
		//var drawOptions = new google.search.DrawOptions();
		
		// tell the searcher to draw itself in linear mode
       // drawOptions.setDrawMode(google.search.SearchControl.DRAW_MODE_TABBED);
        //searchControl.draw(element, drawOptions);

      }
      google.setOnLoadCallback(initialize);
    </script>';
}

// Javascriptをヘッダーに挿入
add_action('wp_head','add_vc_gajax');

// CSSをヘッダーに挿入
add_action('wp_head','add_vc_css');

// アイテム描画ページ（全API共通）
add_shortcode( 'vcpage', 'vcpage_func' );

// 検索リンク作成
add_shortcode( 'vc', 'vc_func' );
add_shortcode( 'ls', 'ls_func' );
add_shortcode( 'jalan', 'jalan_func' );
add_shortcode( 'googleco', 'googleco_func' );
add_shortcode( 'rakuten', 'rakuten_func' );
add_shortcode( 'yshopping', 'yshopping_func' );
add_shortcode( 'yauction', 'yauction_func' );
add_shortcode( 'actr', 'actr_func' );
add_shortcode( 'amazon_vc', 'amazon_vc_func' );

// ブログエントリ内アイテム検索表示
add_shortcode( 'vcitem', 'vcitem_func' );
add_shortcode( 'lsitem', 'lsitem_func' );
add_shortcode( 'jalantem', 'jalanitem_func' );
add_shortcode( 'rakutenitem', 'rakutenitem_func' );
add_shortcode( 'yshoppingitem', 'yshoppingitem_func' );
add_shortcode( 'yauctionitem', 'yauctionitem_func' );
add_shortcode( 'actritem', 'actritem_func' );
add_shortcode( 'amazon_vcitem', 'amazon_vcitem_func' );
add_shortcode( 'saiyasune', 'saiyasune_func' );
add_shortcode( 'amazonjan', 'amazonjan_func' );
add_shortcode( 'chiebukuro_search', 'chiebukuro_search_func' );

//検索用プルダウン表示
add_shortcode( 'jalanareasearch', 'jalanareasearch_func' );

// 管理画面、管理用
add_action('admin_menu', 'vc_search_menu');

// add_action('deactivate_vc_search/vc_search.php', 'remove_vc_search');
register_deactivation_hook(__FILE__, 'remove_vc_search');

/***------------------------------------------
　管理画面
------------------------------------------***/

// 管理画面メニュー作成関数
function vc_search_menu() {
//add_options_page('VC Search Options', 'VC Search', 8, __FILE__, 'vc_search_options');
add_menu_page('VC Search', 'VC Search', 8,__FILE__, 'vc_search_options', 'http://localhost/wplocaltest/wp-content/plugins/vc-search/icon16.png');
add_submenu_page(__FILE__, '主要一括設定', '主要一括設定', 8, __FILE__, 'vc_search_options');
add_submenu_page(__FILE__, '必須設定', '必須設定', 8, "admin_must", 'vc_search_must');
add_submenu_page(__FILE__, 'リンクシェア', 'リンクシェア', 8, "admin_linkshare", 'vc_search_linkshare');
add_submenu_page(__FILE__, 'バリューコマース', 'バリューコマース', 8, "admin_valuecommerce", 'vc_search_valuecommerce');
add_submenu_page(__FILE__, '楽天ウェブサービス', '楽天ウェブサービス', 8, "admin_rakuten", 'vc_search_rws');
add_submenu_page(__FILE__, 'Amazon.co.jp', 'Amazon.co.jp', 8, "admin_amazon", 'vc_search_amazon');
add_submenu_page(__FILE__, 'もしも', 'もしも', 8, "admin_moshimo", 'vc_search_moshimo');
}



// 管理画面描画
function vc_search_options() {
// ポストされた値の入力チェックと書き込み
if (isset($_POST['update_option'])) {
check_admin_referer('vc_search-options');
update_option('vc_search_token', $_POST['vc_search_token']);
update_option('vc_search_page', $_POST['vc_search_page']);
update_option('vc_yahoo_appid', $_POST['vc_yahoo_appid']);
update_option('ls_search_token', $_POST['ls_search_token']);
update_option('jalan_search_token', $_POST['jalan_search_token']);
update_option('jalan_pid', $_POST['jalan_pid']);
update_option('jalan_sid', $_POST['jalan_sid']);
update_option('rakuten_search_token', $_POST['rakuten_search_token']);
update_option('rakuten_affiliate_id', $_POST['rakuten_affiliate_id']);
update_option('ysh_sid', $_POST['ysh_sid']);
update_option('ysh_pid', $_POST['ysh_pid']);
update_option('yauc_sid', $_POST['yauc_sid']);
update_option('yauc_pid', $_POST['yauc_pid']);
update_option('attoken', $_POST['attoken']);
update_option('amzacckey', $_POST['amzacckey']);
update_option('amzseckey', $_POST['amzseckey']);
update_option('amzassid', $_POST['amzassid']);
update_option('google_ajax_apikey', $_POST['google_ajax_apikey']);
update_option('google_custom_id', $_POST['google_custom_id']);
update_option('google_custom_name', $_POST['google_custom_name']);

update_option('custum_draw_on', $_POST['custum_draw_on']);
update_option('custum_draw_template', $_POST['custum_draw_template']);

update_option('javascript_draw_mode', $_POST['javascript_draw_mode']);
//$this->upate_options(); ?>
<div class="updated fade"><p><strong><?php _e('Options saved.'); ?></strong></p>
</div> <?php }
$vctoken= get_option('vc_search_token');
$vcpagepage= get_option('vc_search_page');
$vc_yahoo_appid= get_option('vc_yahoo_appid');
$lstoken= get_option('ls_search_token');
$jalantoken= get_option('jalan_search_token');
$jalan_pid= get_option('jalan_pid');
$jalan_sid= get_option('jalan_sid');
$rakutentoken= get_option('rakuten_search_token');
$rakutenaffid= get_option('rakuten_affiliate_id');
$ysh_sid=get_option('ysh_sid');
$ysh_pid=get_option('ysh_pid');
$yauc_sid=get_option('yauc_sid');
$yauc_pid=get_option('yauc_pid');
$attoken=get_option('attoken');
$amzacckey=get_option('amzacckey');
$amzseckey=get_option('amzseckey');
$amzassid=get_option('amzassid');
$google_ajax_apikey=get_option('google_ajax_apikey');
$google_custom_id=get_option('google_custom_id');
$google_custom_name=get_option('google_custom_name');

$custum_draw_on=get_option('custum_draw_on');
$custum_draw_template=get_option('custum_draw_template');

$javascript_draw_mode=get_option('javascript_draw_mode');

?>

<div class="wrap">
<h2>VC Searchプラグイン管理画面</h2>
<p>API提供事業者やアフィリエイトASPから与えられたトークン、キー、パラメータなどを入力してください。<br />
使用するAPIやアフィリエイトのキーを入れないと動作しません。</p>
<form name="form" method="post" action="">
<input type="hidden" name="action" value="update" />
<?php wp_nonce_field('vc_search-options'); ?>

<table class="form-table"><tbody>

<tr>
<th><label for="vc_search_page"><?php
_e('[vcpage]設置ページ', 'vc_search_page'); ?></label></th> <td><input type="text" name="vc_search_page"
id="vc_search_page" value="<?php
echo attribute_escape($vcpagepage); ?>" /><br />
各種商品検索結果表示やカテゴリ一覧を表示するためのページを1ページ作成し、本文部分に“[vcpage]”（半角）を記入してください。<br />
またURLの末尾に必ず「?」（半角）を付けてください。<br />
すでに「?」がついているURLの場合はURLの末尾に「?」ではなく「&」(半角)を必ず付けてください。※必須</td>
</tr>

<tr>
<th><label for="vc_search_token"><?php
_e('バリューコマーストークン（token）', 'vc_search'); ?></label></th> <td><input size="36" type="text" name="vc_search_token"
id="vc_search_token" value="<?php
echo attribute_escape($vctoken); ?>" /></td>
</tr>

<tr>
<th><label for="vc_yahoo_appid"><?php
_e('YAHOO!JAPANアプリケーションID', 'vc_yahoo_appid'); ?></label></th> <td><input size="80" type="text" name="vc_yahoo_appid"
id="vc_search_page" value="<?php
echo attribute_escape($vc_yahoo_appid); ?>" /><br />
※必須</td>
</tr>

<tr>
<th><label for="ls_search_token"><?php
_e('リンクシェアトークン（token）', 'ls_search'); ?></label></th> <td><input size="70" type="text" name="ls_search_token"
id="ls_search_token" value="<?php
echo attribute_escape($lstoken); ?>" /></td>
</tr>

<tr>
<th><label for="jalan_search_token"><?php
_e('じゃらんWebサービスAPIキー', 'jalan_search'); ?></label></th> <td><input type="text" name="jalan_search_token"
id="jalan_search_token" value="<?php
echo attribute_escape($jalantoken); ?>" /></td>
</tr>

<tr>
<th><label for="jalan_sid"><?php
_e('じゃらんのsid', 'jalan_sid'); ?></label></th> <td><input type="text" name="jalan_sid"
id="jalan_sid" value="<?php
echo attribute_escape($jalan_sid); ?>" /></td>
</tr>

<tr>
<th><label for="jalan_pid"><?php
_e('じゃらんのpid', 'jalan_pid'); ?></label></th> <td><input type="text" name="jalan_pid"
id="jalan_pid" value="<?php
echo attribute_escape($jalan_pid); ?>" /></td>
</tr>

<tr>
<th><label for="rakuten_affiliate_id"><?php
_e('楽天アフィリエイトID', 'rakuten_affiliate_id'); ?></label></th> <td><input size="36" type="text" name="rakuten_affiliate_id"
id="rakuten_affiliate_id" value="<?php
echo attribute_escape($rakutenaffid); ?>" /></td>
</tr>

<tr>
<th><label for="rakuten_search_token"><?php
_e('楽天デベロッパーID', 'rakuten_search_token'); ?></label></th> <td><input size="36" type="text" name="rakuten_search_token"
id="rakuten_search_token" value="<?php
echo attribute_escape($rakutentoken); ?>" /></td>
</tr>

<tr>
<th><label for="ysh_sid"><?php
_e('YAHOO!ショッピングのsid', 'ysh_sid'); ?></label></th> <td><input type="text" name="ysh_sid"
id="ysh_sid" value="<?php
echo attribute_escape($ysh_sid); ?>" /></td>
</tr>

<tr>
<th><label for="ysh_pid"><?php
_e('YAHOO!ショッピングのpid', 'ysh_pid'); ?></label></th> <td><input type="text" name="ysh_pid"
id="ysh_pid" value="<?php
echo attribute_escape($ysh_pid); ?>" /></td>
</tr>

<tr>
<th><label for="yauc_sid"><?php
_e('YAHOO!オークションのsid', 'yauc_sid'); ?></label></th> <td><input type="text" name="yauc_sid"
id="yauc_sid" value="<?php
echo attribute_escape($yauc_sid); ?>" /></td>
</tr>

<tr>
<th><label for="yauc_pid"><?php
_e('YAHOO!オークションのpid', 'yauc_pid'); ?></label></th> <td><input type="text" name="yauc_pid"
id="yauc_pid" value="<?php
echo attribute_escape($yauc_pid); ?>" /></td>
</tr>

<tr>
<th><label for="attoken"><?php
_e('アクセストレード　ws_id', 'attoken'); ?></label></th> <td><input type="text" name="attoken"
id="attoken" value="<?php
echo attribute_escape($attoken); ?>" /></td>
</tr>

<tr>
<th><label for="amzacckey"><?php
_e('Amazon Access Key ID', 'amzacckey'); ?></label></th> <td><input type="text" name="amzacckey"
id="amzacckey" value="<?php
echo attribute_escape($amzacckey); ?>" /></td>
</tr>

<tr>
<th><label for="amzseckey"><?php
_e('Amazon Secret Access Key','amzseckey'); ?></label></th> <td><input type="text" name="amzseckey"
id="amzseckey" value="<?php
echo attribute_escape($amzseckey); ?>" /></td>
</tr>

<tr>
<th><label for="amzassid"><?php
_e('Amazon　アソシエイトトラッキングID', 'amzassid'); ?></label></th> <td><input type="text" name="amzassid"
id="amzassid" value="<?php
echo attribute_escape($amzassid); ?>" /></td>
</tr>

<tr>
<th><label for="google_ajax_apikey"><?php
_e('Google AJAX API key', 'google_ajax_apikey'); ?></label></th> <td><input type="text" name="google_ajax_apikey"
id="google_ajax_apikey" value="<?php
echo attribute_escape($google_ajax_apikey); ?>" /></td>
</tr>

<tr>
<th><label for="google_custom_id"><?php
_e('Googleカスタム検索の検索エンジン ID', 'google_custom_id'); ?></label></th> <td><input type="text" name="google_custom_id"
id="google_custom_id" value="<?php
echo attribute_escape($google_custom_id); ?>" /></td>
</tr>

<tr>
<th><label for="google_custom_name"><?php
_e('Googleカスタム検索の内容を表すラベル名', 'google_custom_name'); ?></label></th> <td><input type="text" name="google_custom_name"
id="google_custom_name" value="<?php
echo attribute_escape($google_custom_name); ?>" /></td>
</tr>


<tr>
<th><label for="custum_draw_on"><?php
_e('表示形式', 'custum_draw_on'); ?></label></th> <td>
<input type="radio" name="custum_draw_on" id="custum_draw_on" value="0" <?php if ($custum_draw_on==0) {echo "checked ";} ?> />通常テンプレート
<input type="radio" name="custum_draw_on" id="custum_draw_on" value="1" <?php if ($custum_draw_on==1) {echo "checked ";} ?> />カスタムデザイン
<input type="radio" name="custum_draw_on" id="custum_draw_on" value="2" <?php if ($custum_draw_on==2) {echo "checked ";} ?> />ショーウィンドウ型
</td>
</tr>

<tr>
<th><label for="custum_draw_template"><?php
_e('カスタムデザインテンプレート', 'custum_draw_template'); ?></label></th> <td>
<textarea cols="80" rows="10" name="custum_draw_template" id="custum_draw_template">
<?php echo str_replace('\\','',$custum_draw_template); ?>
</textarea> <br />
カスタムデザインでAPIから得られた値や文字を出力させる場所に、下記記号を指定してください。<br />
【商品名】 【商品リンク】 【商品画像】【参考価格】【商品説明】【計測イメージタグ】
</td>
</tr>

<tr>
<th><label for="javascript_draw_mode"><?php
_e('Javascript Draw モード', 'javascript_draw_mode'); ?></label></th> <td>
<input type="checkbox" name="javascript_draw_mode" id="javascript_draw_mode" value="1" <?php if ($javascript_draw_mode==1) {echo "checked ";} ?> /><br />
APIで取得した情報を直接HTMLではなくJavascriptで書き出す形にします。
</td>
</tr>

</tbody></table>

<p class="submit">
<input type="submit" name="update_option" class="button- primary" value="<?php _e('Save Changes'); ?>" />
</p>

</form>
</div>

<?php
}


// プラグイン停止時にフィールドを削除
function remove_vc_search()
{
	delete_option('vc_search_token');
	delete_option('vc_search_page');
	delete_option('vc_yahoo_appid');
	delete_option('ls_search_token');
	delete_option('jalan_search_token');
	delete_option('jalan_sid');
	delete_option('jalan_pid');
	delete_option('ysh_sid');
	delete_option('ysh_pid');
	delete_option('yauc_sid');
	delete_option('yauc_pid');
	delete_option('attoken');
	delete_option('amzacckey');
	delete_option('amzseckey');
	delete_option('amzassid');
	delete_option('google_ajax_apikey');
	delete_option('google_custom_id');
	delete_option('google_custom_name');
	delete_option('rakuten_affiliate_id');
	delete_option('rakuten_search_token');
	delete_option('custum_draw_on');
	delete_option('custum_draw_template');
	delete_option('javascript_draw_mode');
}

?>