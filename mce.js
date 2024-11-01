/**
 * MCE ツールバーにボタンを追加します。
 */
( function()
{
	tinymce.create( "tinymce.plugins.VCSearchButtons",
	{
		getInfo : function()
		{
			return { longname:"VC Search", author: "wackey", authorurl: "http://musilog.net/", infourl: "http://review.web-service-api.jp/", version: "1.2" };
		},

		init : function( ed, url )
		{
			var t = this;
			t.editor = ed;

			ed.addCommand('VC', function() {
				ed.windowManager.open({
					file : url + '/ext_mce/panel.php',
					width : 640 + parseInt(ed.getLang('ls.delta_width', 0)),
					height : 400+ parseInt(ed.getLang('ls.delta_height', 0)),
					inline : 1
				}, {
					plugin_url : url
				});
			});
			


			ed.addButton( 'VC', { title: "VC", cmd: 'VC', image : url + "/mce_img/vc.gif" });



		},

	});

	tinymce.PluginManager.add( "VCSearchButtons", tinymce.plugins.VCSearchButtons );
} )();
