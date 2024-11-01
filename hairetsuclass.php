<?php
/*
VC Search Hairetsu class by wackey
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
　商品データを配列データに一元化する
----------------------------------------------------***/

// ■配列に格納された商品データを一個ずつ配列に取り出す

class HitsHitHairetsu {

/*
共通的に使う配列について

$hits・・・商品情報の配列全体
$itemname・・・商品名
$aflinkurl・・・アフィリエイトリンク
$imgurl・・・画像URL
$price・・・値段、参考価格
$description・・・商品説明
$shopname・・・ECサイト名
$vcpvimg・・・バリューコマースPV計測用用タグ
$guid・・・商品ページの URL
$jancode・・・JANコード
$souryou・・・送料情報
$reviewnum・・・レビュー数
$reviewavr・・・レビュー平均点
$reviewurl・・・レビューURL
$faviconurl・・・ファビコンURL
*/

// バリューコマース商品データを配列変数に格納
function valuecommerceitemhit($hits,&$itemname,&$aflinkurl,&$imgurl,&$price,&$description,&$shopname,&$vcpvimg,&$guid,&$jancode,&$souryou,&$reviewnum,&$reviewavr,&$reviewurl,&$faviconurl) {
foreach ($hits as $hit) {
$itemname[] = h($hit->title);
$aflinkurl[] = str_replace('&amp;', '&' ,h($hit->link));

// 画像URL取り出し
$img = array();
foreach($hit->vcimage as $vcimg) {
    $img[]=$vcimg["url"];
}

if (strlen($img[1])) {
	$imgurl[] = h($img[1]);
} else {
	if (strlen($img[2])) {
		$imgurl[] = h($img[2]);
	} else {
	$imgurl[] = WP_PLUGIN_URL."/vc_search/c_img/noimage.gif";
	}
}
$price[] = h($hit->vcprice);
$description[] = h($hit->description);
// ストア名とサブストア名が一緒ならサブストア名は使わない（ビッダーズとか）
if ($hit->vcmerchantName == $hit->vcsubStoreName) {
$shopname[]=h($hit->vcmerchantName);
} else {
$shopname[] = h($hit->vcmerchantName) . h($hit->vcsubStoreName);
}
$vcpvimg[] = $hit->vcpvImg;
$guid[] = h($hit->guid);
$jancode[] = h($hit->vcjanCode);
$souryou[]="";
$reviewnum[]="";
$reviewavr[]="";
$reviewurl[]="";
$faviconurl[]=h($hit->guid);
}//foreach

return;
}// function valuecommerceitemhit

// ヤフーショッピング商品データを配列変数に格納
function yahooshoppingitemhit($hits,&$itemname,&$aflinkurl,&$imgurl,&$price,&$description,&$shopname,&$vcpvimg,&$guid,&$jancode,&$souryou,&$reviewnum,&$reviewavr,&$reviewurl,&$faviconurl) {
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
$vcpvimg[]="";
$guid[]="";
$jancode[] = "";//あとで
$souryou[] = h($hit->Shipping->Name);
$reviewnum[] = h($hit->Review->Count);
$reviewavr[] = h($hit->Review->Rate);
$reviewurl[] = h($hit->Review->Url);
$faviconurl[] = "http://shopping.yahoo.co.jp/";
}// foreach
}// function yahooshoppingitemhit

// ヤフーオークション検索データを配列変数に格納
function yahooauctionitemhit($hits,&$itemname,&$aflinkurl,&$imgurl,&$price,&$description,&$shopname,&$vcpvimg,&$guid,&$jancode,&$souryou,&$reviewnum,&$reviewavr,&$reviewurl,&$faviconurl) {
$yauc_sid=get_option('yauc_sid');
if ($yauc_sid=="") {$yauc_sid=YAUC_SID;}
$yauc_pid=get_option('yauc_pid');
if ($yauc_pid=="") {$yauc_pid=YAUC_PID;}
$i=0;
foreach ($hits as $hit) {
$itemname[] = h($hit->Title);
$aflinkurl[] = "http://ck.jp.ap.valuecommerce.com/servlet/referral?sid=$yauc_sid&pid=$yauc_pid&vc_url=" . urlencode(h($hit->AuctionItemUrl));
$img = array();
// 画像情報取り出し
if (strlen($hit->Image)) {
	$imgurl[] = h($hit->Image);
} else {
	$imgurl[] = "c_img/noimage.gif";
}
$pricebuff = h($hit->CurrentPrice);
$pricebuff = str_replace(' .00', '', $pricebuff);
$pricebuff = str_replace(',', '', $pricebuff);
$price[] = intval($pricebuff);
$description[] = "落札終了予定時間" . h($hit->EndTime);
$shopname[] = "Yahoo!オークション　出品者（ストア）：" . h($hit->Seller->Id);
$vcpvimg[]="";
$guid[]="";
$jancode[]="";
$souryou[] = "";
$reviewnum[] = "";
$reviewavr[] = "";
$reviewurl[] = "";
$faviconurl[] = "http://auctions.yahoo.co.jp/jp/";
$i=$i+10;
if ($i==5) {break;}
}// foreach
}// function yahooauctionitemhit


// Amazon商品検索データを配列変数に格納
function amazonitemhit($hits,&$itemname,&$aflinkurl,&$imgurl,&$price,&$description,&$shopname,&$vcpvimg,&$guid,&$jancode,&$souryou,&$reviewnum,&$reviewavr,&$reviewurl,&$faviconurl) {
foreach ($hits as $hit) {
$itemname[] = h($hit->ItemAttributes->Title);
$aflinkurl[] = h($hit->DetailPageURL);
$imgurl[] = h($hit->MediumImage->URL);
$price[] = h($hit->OfferSummary->LowestNewPrice->Amount);
$description[] = h($hit->EditorialReviews->EditorialReview->Content);
$shopname[] = "Amazon.co.jp";
$vcpvimg[]="";
$guid[]="";
$jancode[]="";
$souryou[] = "";
$reviewnum[] = h($hit->CustomerReviews->TotalReviews);
$reviewavr[] = h($hit->CustomerReviews->AverageRating);
$reviewurl[] = "";
$faviconurl[] = "http://www.amazon.co.jp/";
}// foreach
}// function amazonitemhit


// リンクシェア商品検索データを配列変数に格納
function linkshareitemhit($hits,&$itemname,&$aflinkurl,&$imgurl,&$price,&$description,&$shopname,&$vcpvimg,&$guid,&$jancode,&$souryou,&$reviewnum,&$reviewavr,&$reviewurl,&$faviconurl) {
foreach ($hits as $hit) {
if (!is_numeric(mb_strpos($hit->merchantname,"携帯"))) {
$itemname[] = h($hit->productname);
$aflinkurl[] = $hit->linkurl;
if (strlen($hit->imageurl)) {
	$imgurl[] = h($hit->imageurl);
} else {
	$imgurl[] = "c_img/noimage.gif";
}

$price[] = h($hit->price);
$description[] = h($hit->description->long);
$shopname[] = h($hit->merchantname).'<img border="0" width="1" height="1" src="http://ad.linksynergy.com/fs-bin/show?id=Dk8JKvDVYwE&bids=186984.200060&type=3&subid=0">';// Linkshareコンテスト用タグ
$vcpvimg[]="";
$guid[]="";
$jancode[]="";
$souryou[] = "";
$reviewnum[] = "";
$reviewavr[] = "";
$reviewurl[] = "";
$faviconurl[] = h($hit->imageurl);

}// 携帯除外
}// foreach
}// function linkshareitemhit


// 楽天市場商品検索データを配列変数に格納
function rakutenichibaitemhit($hits,&$itemname,&$aflinkurl,&$imgurl,&$price,&$description,&$shopname,&$vcpvimg,&$guid,&$jancode,&$souryou,&$reviewnum,&$reviewavr,&$reviewurl,&$faviconurl) {
foreach ($hits as $hit) {
$itemname[] = h($hit->itemName);
$aflinkurl[] = h($hit->affiliateUrl);
if (strlen($hit->mediumImageUrl)) {
	$imgurl[] = h($hit->mediumImageUrl);
} else {
	$imgurl[] = "c_img/noimage.gif";
}
$price[] = h($hit->itemPrice);
$description[] = h($hit->itemCaption);
$shopname[] = h($hit->shopName);
$vcpvimg[]="";
$guid[]="";
$jancode[]="";
//送料フラグ 	postageFlag 	0：送料込
//1：送料別
if ($hit->postageFlag == 0) {
	$souryou[] = "送料無料";
} else {
	$souryou[] = "送料別";
}
$reviewnum[] = h($hit->reviewCount);
$reviewavr[] = h($hit->reviewAverage);
$reviewurl[] = "";
$faviconurl[] = "http://www.rakuten.co.jp/";
}// foreach
}// function rakutenichibaitemhit


// アクセストレード商品検索データを配列変数に格納
function actritemhit($hits,&$itemname,&$aflinkurl,&$imgurl,&$price,&$description,&$shopname,&$vcpvimg,&$guid,&$jancode,&$souryou,&$reviewnum,&$reviewavr,&$reviewurl,&$faviconurl) {
foreach ($hits as $hit) {

$itemname[] = h($hit->GoodsName);

$aflinkurl[] = h($hit->LinkCode);
$img = array();
// 画像情報取り出し
if (strlen($hit->ImageUrl)) {
	$imgurl[] = h($hit->ImageUrl);
} else {
	$imgurl[] = "c_img/noimage.gif";
}

$price[] = h($hit->Price);
$description[] = h($hit->Explanation);
$shopname[] = h($hit->ShopName);
$vcpvimg[]="";
$guid[]="";
$jancode[]="";
$souryou[] = "";
$reviewnum[] = "";
$reviewavr[] = "";
$reviewurl[] = "";
$faviconurl[] = h($hit->ImageUrl);

}// foreach
}// function actritemhit


}// HitsHitHairetsu



?>
