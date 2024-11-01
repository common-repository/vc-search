<?php
// 必須設定項目：リンクシェアトークンとSITE.CODE
function vc_search_linkshare() {
// ポストされた値の入力チェックと書き込み
if (isset($_POST['update_option'])) {
check_admin_referer('vc_search-options');
update_option('ls_search_token', $_POST['ls_search_token']);
update_option('ls_siteid', $_POST['ls_siteid']);
?>
<div class="updated fade"><p><strong><?php _e('Options saved.'); ?></strong></p>
</div>
<?php }
$lstoken= get_option('ls_search_token');
$ls_siteid= get_option('ls_siteid');
?>

<div class="wrap">
<h2>VC Searchプラグインリンクシェア関連設定</h2>
<p>クロスオーバーサーチなどリンクシェアWebサービス利用するための設定です</p>
<form name="form" method="post" action="">
<input type="hidden" name="action" value="update" />
<?php wp_nonce_field('vc_search-options'); ?>

<table class="form-table"><tbody>

<tr>
<th><label for="ls_search_token"><?php
_e('リンクシェアトークン（token）', 'ls_search'); ?></label></th> <td><input size="70" type="text" name="ls_search_token"
id="ls_search_token" value="<?php
echo attribute_escape($lstoken); ?>" /><br />
トークンはリンクシェア管理画面の「リンク」の「Webサービス」で取得できます。
</td>
</tr>

<tr>
<th><label for="ls_siteid"><?php
_e('サイトID（token）', 'ls_siteid'); ?></label></th> <td><input size="70" type="text" name="ls_siteid"
id="ls_siteid" value="<?php
echo attribute_escape($ls_siteid); ?>" /><br />
サイトコードの取得の仕方は<a href="http://linkshare.okweb3.jp/EokpControl?&amp;tid=87584&amp;event=FE0006" target="_blank">リンクシェア お問い合わせ</a>に掲載されています。現時点ではこれを使った機能はありませんが近日中に機能追加される予定です。
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
?>