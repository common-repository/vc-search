/**
 * クイックタグツールバーにボタンを追加します。
 */
function WpMyPluginInsertShortCode()
{
edInsertContent( edCanvas, "" );
}


/**
 * クイック タグ ボタンを登録します。
 */
function WpMyPluginRegisterQtButton()
{
	jQuery( "#ed_toolbar" ).each( function()
	{
		var button       = document.createElement( "input" );
		button.type      = "button";
		button.value     = "VC";
		button.onclick   = WpMyPluginInsertShortCode();
		button.className = "ed_VCSearch";
		button.title     = "VC";
		button.id        = "ed_VCSearch";

		jQuery( this ).append( button );
	} );
}

WpMyPluginRegisterQtButton();


