=== VC Search ===
Contributors: wackey
Tags: ad , affiliate
Requires at least: 3.3
Tested up to: 3.32
Stable tag: 1.89a

VC Search is a affiliate and contents generater from API.Shortcode Add,Tine MCE Extension.For Japanese Affiliate,API.

== Description ==

[日本語の説明を読む](http://web-service-api.jp/vcsearch/)

VC Search is a affiliate and contents generater from API.Shortcode Add,Tine MCE Extension.For Japanese Affiliate,API.

Plug-in that used shortcode API of WordPress in entering blog.
It is possible to display it by accessing API of EC site,API of affiliate ASP, and API of the hotel retrieval etc. and acquiring information.
the miscellaneous function in which a short code can be input only by adding the button with TinyMCE so that for a user not familiar to use it easily for a short code, and inputting it to the dialog is attached though various search conditions can be specified by a short code. 

affiliate, API:

*  Linkshare Crossover Search.
*  Value Commerce Item Search.
*  Yahoo! Japn shopping API.
*  Yahoo! Japn auction API.
*  Yahoo! Japn chiebukuro API.
*  Rakuten Item Serach API
*  Amazon Product Advertising API.
*  Access Trade Item Search API.
*  Jalan Area Search API.
*  Google Ajax Search.

== Requirements ==

* WordPress 3.6 or later
* PHP 5.2 or later


== Installation ==

1. Unzip the plugin archive and put `vc-search` folder into your plugins directory (`wp-content/plugins/`) of the server. 
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Make Page, and `[vcpage]`
1. Configure the plugin at "VC Search" menu at the WordPress admin panel. Please input API key, Affiliate ID.
1. Please input page-url as descliption.

== Changelog ==

= 1.89a=
* Delete Yahoo! kanren search.
= 1.89=
* Bug fix
= 1.88=
* VC button add.
= 1.87=
* chiebukuro a little modify.
= 1.85=
* removing options on a deactivation hook,use a register_deactivation_hook() function
= 1.84=
* retry.
= 1.83=
* admin_must.php upload.
= 1.82=
* Administration Menus renew.
= 1.81=
* Linkshare Web Service URL changed(merchant at panel)
= 1.8=
* Linkshare Web Service URL changed,Bug fix(Amazon)
= 1.73=
* Bug fix(Amazon enabled,Rakuten favicon)
= 1.72=
* Bug fix(menu function)
= 1.71=
* apifunc.php modify.Linkshare 4000over hit, -1 to 4000.
= 1.70=
* Bug fix(Yahoo auction link)
= 1.67=
* Bug fix
= 1.66=
* Bug fix
= 1.65=
* Bug fix at apifunc.php
= 1.64=
* apifunc.php modify,new vc-search support website url.But the site is opening at 2011/02.
= 1.63=
* Valuecommerce API item view in entry,Bugfix.
= 1.62=
* Search result show-window mode added.
= 1.61=
* Javascript Draw mode add, Bug fix(Amazon Item Draw)
= 1.60=
* Bug fix(Yahoo! sort)
= 1.59=
* Bug fix(rakuten entry input)
= 1.57=
* Bug fix(linkshare sort)
= 1.56=
* Bug fix
= 1.55=
* Bug fix,Google Custom Search link generate,excute command add
= 1.54=
* Bug fix,linkshare EC site selectable
= 1.52=
* Rakuten web service API version change.
= 1.51=
* Google Custom Search add.
= 1.50=
* Google AJAX Search add.
= 1.46=
* Bug fix.
= 1.45=
* Bug fix,add Amazon item view in entry,add Amazon category,sort option,amazon ranking search.
= 1.44=
* Bug fix,add hairetsu class,Rakuten Ichiba Item view in blogentry,and othier modify.
= 1.43=
* Bug fix,code rebuild.
= 1.42=
* Bug fix.
= 1.41=
* Bug fix,apiclassphp include.
= 1.40=
* Bug fix,Amazon Search API version up,VC Button alt define.
= 1.39 =
* Bug fix,Amazon detail page and, Jancode Oudan Search,Yahoo! JAPAN Auction Search.
= 1.38 =
* Bug fix.
= 1.37 =
* Bug fix.
= 1.36 =
* Bug fix.
= 1.35 =
* Bug fix.
= 1.34 =
* Amazon ASIN to Jan,product `oudan` search.
= 1.33 =
* stylesheat bugfix
= 1.32 =
* stylesheat bugfix
= 1.31 =
* stylesheat bugfix
= 1.31 =
* bugfix,Linkshare Contest
= 1.30 =
* bugfix,Linkshare Contest
= 1.29 =
* bugfix
= 1.28 =
* Rakuten Item Search link bag fix.

`<?php code(); // goes in backticks ?>`
