tinyMCEPopup.requireLangPack();

// リンクシェア
var PasteLSDialog = {
	init : function() {
		this.resize();
	},

	insert : function() {
		var linktext = tinyMCEPopup.dom.encode(document.getElementById('linktext').value), lines;
		var keyword = tinyMCEPopup.dom.encode(document.getElementById('keyword').value), lines;
		var mid = tinyMCEPopup.dom.encode(document.getElementById('mid').value), lines;
		var sort_type = tinyMCEPopup.dom.encode(document.getElementById('sort_type').value), lines;
		var searchlink = document.getElementById('searchlink').checked;
		var entryitem = document.getElementById('entryitem').checked;
		
	if (searchlink == true) {
		var shortcode = "[ls keyword='"+keyword +"' mid='"+mid+"' sort_type='"+sort_type+"']"+linktext+"[/ls]";
		} else if (entryitem == true) {
		var shortcode = "[lsitem keyword='"+keyword +"' mid='"+mid+"' sort_type='"+sort_type+"']"+linktext+"[/lsitem]";
	}
		
		tinyMCEPopup.editor.execCommand('mceInsertClipboardContent', false,{content : shortcode});
		tinyMCEPopup.close();
	},

	resize : function() {
		var vp = tinyMCEPopup.dom.getViewPort(window), el;

		el = document.getElementById('linktext');
		kl = document.getElementById('keyword');

		el.style.width  = (vp.w - 120) + 'px';
		kl.style.width  = (vp.w - 120) + 'px';
		//el.style.height = (vp.h - 90) + 'px';
	}
};

tinyMCEPopup.onInit.add(PasteLSDialog.init, PasteLSDialog);


// Amazon
var PasteAMDialog = {
	init : function() {
		this.resize();
	},

	insert : function() {
		var linktext = tinyMCEPopup.dom.encode(document.getElementById('amlinktext').value), lines;
		var keyword = tinyMCEPopup.dom.encode(document.getElementById('amkeyword').value), lines;
//		var sort_type = tinyMCEPopup.dom.encode(document.getElementsByName('amsort_type').value), lines;
//		var category = tinyMCEPopup.dom.encode(document.getElementsByName('amcategory').value), lines;
		var searchlink = document.getElementById('amazonsearchlink').checked;
		var entryitem = document.getElementById('amazonentryitem').checked;
		if (searchlink == true) {
//			var shortcode = "[amazon_vc keyword='"+keyword +"' sort_type='"+sort_type+"' category='"+category+"']"+linktext+"[/amazon_vc]";
			var shortcode = "[amazon_vc keyword='"+keyword +"']"+linktext+"[/amazon_vc]";
		} else if (entryitem == true) {
//			var shortcode = "[amazon_vcitem keyword='"+keyword +"' sort_type='"+sort_type+"' category='"+category+"']"+linktext+"[/amazon_vcitem]";
			var shortcode = "[amazon_vcitem keyword='"+keyword +"']"+linktext+"[/amazon_vcitem]";
		}
		tinyMCEPopup.editor.execCommand('mceInsertClipboardContent', false,{content : shortcode});
		tinyMCEPopup.close();
	},

	resize : function() {
		var vp = tinyMCEPopup.dom.getViewPort(window), el;

		el = document.getElementById('linktext');
		kl = document.getElementById('keyword');

		el.style.width  = (vp.w - 120) + 'px';
		kl.style.width  = (vp.w - 120) + 'px';
		//el.style.height = (vp.h - 90) + 'px';
	}
};

tinyMCEPopup.onInit.add(PasteAMDialog.init, PasteAMDialog);


// アクセストレード
var PasteATDialog = {
	init : function() {
		this.resize();
	},

	insert : function() {
		var linktext = tinyMCEPopup.dom.encode(document.getElementById('atlinktext').value), lines;
		var keyword = tinyMCEPopup.dom.encode(document.getElementById('atkeyword').value), lines;
		var sort_type = tinyMCEPopup.dom.encode(document.getElementById('atsort_type').value), lines;
		var shortcode = "[actr keyword='"+keyword +"' sort_type='"+sort_type+"']"+linktext+"[/actr]";
		tinyMCEPopup.editor.execCommand('mceInsertClipboardContent', false,{content : shortcode});
		tinyMCEPopup.close();
	},

	resize : function() {
		var vp = tinyMCEPopup.dom.getViewPort(window), el;

		el = document.getElementById('linktext');
		kl = document.getElementById('keyword');

		el.style.width  = (vp.w - 120) + 'px';
		kl.style.width  = (vp.w - 120) + 'px';
		//el.style.height = (vp.h - 90) + 'px';
	}
};

tinyMCEPopup.onInit.add(PasteATDialog.init, PasteATDialog);


// 楽天市場
var PasteRKDialog = {
	init : function() {
		this.resize();
	},

	insert : function() {
		var linktext = tinyMCEPopup.dom.encode(document.getElementById('rklinktext').value), lines;
		var keyword = tinyMCEPopup.dom.encode(document.getElementById('rkkeyword').value), lines;
		var sort_type = tinyMCEPopup.dom.encode(document.getElementById('rksort_type').value), lines;
		var category = tinyMCEPopup.dom.encode(document.getElementById('rkcategory').value), lines;
		var searchlink = document.getElementById('rakutensearchlink').checked;
		var entryitem = document.getElementById('rakutenentryitem').checked;
	if (searchlink == true) {
		var shortcode = "[rakuten keyword='"+keyword +"' sort_type='"+sort_type+"' category='"+category+"']"+linktext+"[/rakuten]";
		} else if (entryitem == true) {
		var shortcode = "[rakutenitem keyword='"+keyword +"' sort_type='"+sort_type+"' category='"+category+"']"+linktext+"[/rakutenitem]";
	}
		
		tinyMCEPopup.editor.execCommand('mceInsertClipboardContent', false,{content : shortcode});
		tinyMCEPopup.close();
	},

	resize : function() {
		var vp = tinyMCEPopup.dom.getViewPort(window), el;

		el = document.getElementById('linktext');
		kl = document.getElementById('keyword');

		el.style.width  = (vp.w - 120) + 'px';
		kl.style.width  = (vp.w - 120) + 'px';
		//el.style.height = (vp.h - 90) + 'px';
	}
};

tinyMCEPopup.onInit.add(PasteRKDialog.init, PasteRKDialog);


// バリューコマース
var PasteVCDialog = {
	init : function() {
		this.resize();
	},

	insert : function() {
		var linktext = tinyMCEPopup.dom.encode(document.getElementById('vclinktext').value), lines;
		var keyword = tinyMCEPopup.dom.encode(document.getElementById('vckeyword').value), lines;
		var sort_type = tinyMCEPopup.dom.encode(document.getElementById('vcsort_type').value), lines;
		var category = tinyMCEPopup.dom.encode(document.getElementById('vccategory').value), lines;
		var searchlink = document.getElementById('vcsearchlink').checked;
		var entryitem = document.getElementById('vcentryitem').checked;
			if (searchlink == true) {
		var shortcode = "[vc keyword='"+keyword +"' sort_type='"+sort_type+"' category='"+category+"']"+linktext+"[/vc]";
		} else if (entryitem == true) {
		var shortcode = "[vcitem keyword='"+keyword +"' sort_type='"+sort_type+"' category='"+category+"']"+linktext+"[/vcitem]";
	}
		tinyMCEPopup.editor.execCommand('mceInsertClipboardContent', false,{content : shortcode});
		tinyMCEPopup.close();
	},

	resize : function() {
		var vp = tinyMCEPopup.dom.getViewPort(window), el;

		el = document.getElementById('linktext');
		kl = document.getElementById('keyword');

		el.style.width  = (vp.w - 120) + 'px';
		kl.style.width  = (vp.w - 120) + 'px';
		//el.style.height = (vp.h - 90) + 'px';
	}
};

tinyMCEPopup.onInit.add(PasteVCDialog.init, PasteVCDialog);


// ヤフーオークション
var PasteYADialog = {
	init : function() {
		this.resize();
	},

	insert : function() {
		var linktext = tinyMCEPopup.dom.encode(document.getElementById('yalinktext').value), lines;
		var keyword = tinyMCEPopup.dom.encode(document.getElementById('yakeyword').value), lines;
		var sort_type = tinyMCEPopup.dom.encode(document.getElementById('yasort_type').value), lines;
		var shortcode = "[yauction keyword='"+keyword +"' sort_type='"+sort_type+"']"+linktext+"[/yauction]";
		tinyMCEPopup.editor.execCommand('mceInsertClipboardContent', false,{content : shortcode});
		tinyMCEPopup.close();
	},

	resize : function() {
		var vp = tinyMCEPopup.dom.getViewPort(window), el;

		el = document.getElementById('linktext');
		kl = document.getElementById('keyword');

		el.style.width  = (vp.w - 120) + 'px';
		kl.style.width  = (vp.w - 120) + 'px';
		//el.style.height = (vp.h - 90) + 'px';
	}
};

tinyMCEPopup.onInit.add(PasteYADialog.init, PasteYADialog);


// ヤフーショッピング
var PasteYSDialog = {
	init : function() {
		this.resize();
	},

	insert : function() {
		var linktext = tinyMCEPopup.dom.encode(document.getElementById('yslinktext').value), lines;
		var keyword = tinyMCEPopup.dom.encode(document.getElementById('yskeyword').value), lines;
		var sort_type = tinyMCEPopup.dom.encode(document.getElementById('yssort_type').value), lines;
		var shortcode = "[yshopping keyword='"+keyword +"' sort_type='"+sort_type+"']"+linktext+"[/yshopping]";
		tinyMCEPopup.editor.execCommand('mceInsertClipboardContent', false,{content : shortcode});
		tinyMCEPopup.close();
	},

	resize : function() {
		var vp = tinyMCEPopup.dom.getViewPort(window), el;

		el = document.getElementById('linktext');
		kl = document.getElementById('keyword');

		el.style.width  = (vp.w - 120) + 'px';
		kl.style.width  = (vp.w - 120) + 'px';
		//el.style.height = (vp.h - 90) + 'px';
	}
};

tinyMCEPopup.onInit.add(PasteYSDialog.init, PasteYSDialog);


// 最安値
var PasteSaiyasuneDialog = {
	init : function() {
		this.resize();
	},

	insert : function() {
		var keyword = tinyMCEPopup.dom.encode(document.getElementById('saiyasunekeyword').value), lines;
		var ngword = tinyMCEPopup.dom.encode(document.getElementById('saiyasunengkeyword').value), lines;
		var jancode = tinyMCEPopup.dom.encode(document.getElementById('saiyasunejancode').value), lines;
		var shortcode = "[saiyasune keyword='"+keyword +"' ngword='"+ngword+"' jancode='"+jancode+"']";
		tinyMCEPopup.editor.execCommand('mceInsertClipboardContent', false,{content : shortcode});
		tinyMCEPopup.close();
	},

	resize : function() {
		var vp = tinyMCEPopup.dom.getViewPort(window), el;

		el.style.width  = (vp.w - 120) + 'px';
		kl.style.width  = (vp.w - 120) + 'px';
		//el.style.height = (vp.h - 90) + 'px';
	}
};

tinyMCEPopup.onInit.add(PasteSaiyasuneDialog.init, PasteSaiyasuneDialog);

// Amazon jan
var PasteAsinjanDialog = {
	init : function() {
		this.resize();
	},

	insert : function() {
		var asincode = tinyMCEPopup.dom.encode(document.getElementById('asincode').value), lines;
		var keyword = tinyMCEPopup.dom.encode(document.getElementById('asinkeyword').value), lines;
		var shortcode = "[amazonjan asin='"+asincode +"' keyword='"+keyword+"']";
		tinyMCEPopup.editor.execCommand('mceInsertClipboardContent', false,{content : shortcode});
		tinyMCEPopup.close();
	},

	resize : function() {
		var vp = tinyMCEPopup.dom.getViewPort(window), el;

		el.style.width  = (vp.w - 120) + 'px';
		kl.style.width  = (vp.w - 120) + 'px';
		//el.style.height = (vp.h - 90) + 'px';
	}
};

tinyMCEPopup.onInit.add(PasteAsinjanDialog.init, PasteAsinjanDialog);

// Googleカスタム検索
var PastegooglecoDialog= {
	init : function() {
		this.resize();
	},

	insert : function() {
		var keyword = tinyMCEPopup.dom.encode(document.getElementById('googlecokeyword').value), lines;
		var shortcode = "[googleco keyword='"+keyword+"']";
		tinyMCEPopup.editor.execCommand('mceInsertClipboardContent', false,{content : shortcode});
		tinyMCEPopup.close();
	},

	resize : function() {
		var vp = tinyMCEPopup.dom.getViewPort(window), el;

		el.style.width  = (vp.w - 120) + 'px';
		kl.style.width  = (vp.w - 120) + 'px';
		//el.style.height = (vp.h - 90) + 'px';
	}
};

tinyMCEPopup.onInit.add(PastegooglecoDialog.init, PastegooglecoDialog);

// YAHOO!知恵袋検索
var PastechiebukurosDialog= {
	init : function() {
		this.resize();
	},

	insert : function() {
		var keyword = tinyMCEPopup.dom.encode(document.getElementById('chiebukuroskeyword').value), lines;
		var results = tinyMCEPopup.dom.encode(document.getElementById('chiebukurosresults').value), lines;
		var charnum = tinyMCEPopup.dom.encode(document.getElementById('charnum').value), lines;
		var shortcode = "[chiebukuro_search keyword='"+keyword+"' results='"+results+"' charnum='"+charnum+"']";
		tinyMCEPopup.editor.execCommand('mceInsertClipboardContent', false,{content : shortcode});
		tinyMCEPopup.close();
	},

	resize : function() {
		var vp = tinyMCEPopup.dom.getViewPort(window), el;

		el.style.width  = (vp.w - 120) + 'px';
		kl.style.width  = (vp.w - 120) + 'px';
		//el.style.height = (vp.h - 90) + 'px';
	}
};

tinyMCEPopup.onInit.add(PastechiebukurosDialog.init, PastechiebukurosDialog);


// じゃらん
var PasteJalanDialog = {
	init : function() {
		this.resize();
	},

	insert : function() {
		var shortcode = "[jalanareasearch]";
		tinyMCEPopup.editor.execCommand('mceInsertClipboardContent', false,{content : shortcode});
		tinyMCEPopup.close();
	},

	resize : function() {
		var vp = tinyMCEPopup.dom.getViewPort(window), el;

		el = document.getElementById('linktext');
		kl = document.getElementById('keyword');

		el.style.width  = (vp.w - 120) + 'px';
		kl.style.width  = (vp.w - 120) + 'px';
		//el.style.height = (vp.h - 90) + 'px';
	}
};

tinyMCEPopup.onInit.add(PasteJalanDialog.init, PasteJalanDialog);


// 初期設定用
var PastesyokiDialog = {
	init : function() {
		this.resize();
	},

	insert : function() {
		var shortcode = "[vcpage]";
		tinyMCEPopup.editor.execCommand('mceInsertClipboardContent', false,{content : shortcode});
		tinyMCEPopup.close();
	},

	resize : function() {
		var vp = tinyMCEPopup.dom.getViewPort(window), el;

		el = document.getElementById('linktext');
		kl = document.getElementById('keyword');

		el.style.width  = (vp.w - 120) + 'px';
		kl.style.width  = (vp.w - 120) + 'px';
		//el.style.height = (vp.h - 90) + 'px';
	}
};

tinyMCEPopup.onInit.add(PastesyokiDialog.init, PastesyokiDialog);
