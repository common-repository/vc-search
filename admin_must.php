<?php
// 必須設定項目：[vcpage]設置ページ、YAHOO!JAPANアプリケーションID
function vc_search_must() {
// ポストされた値の入力チェックと書き込み
if (isset($_POST['update_option'])) {
check_admin_referer('vc_search-options');
update_option('vc_search_page', $_POST['vc_search_page']);
update_option('vc_yahoo_appid', $_POST['vc_yahoo_appid']);
?>
<div class="updated fade"><p><strong><?php _e('Options saved.'); ?></strong></p>
</div>
<?php }
$vcpagepage= get_option('vc_search_page');
$vc_yahoo_appid= get_option('vc_yahoo_appid');

?>

<div class="wrap">
<h2>VC Searchプラグイン必須設定</h2>
<p>このプラグインを動作させるための必要最低限の設定です。ここの入力が無いと中心となる機能が使えません。</p>
<form name="form" method="post" action="">
<input type="hidden" name="action" value="update" />
<?php wp_nonce_field('vc_search-options'); ?>

<table class="form-table"><tbody>

<tr>
<th><label for="vc_search_page"><?php
_e('[vcpage]設置ページ', 'vc_search_page'); ?></label></th> <td><input type="text" name="vc_search_page"
id="vc_search_page" value="<?php
echo attribute_escape($vcpagepage); ?>" /><br />
各種商品検索結果表示やカテゴリ一覧を表示するためのページをブログの「固定ページ」で1ページ作成し、本文部分に“[vcpage]”（半角）を記入してください。<br />
またURLの末尾に必ず「?」（半角）を付けてください。<br />
すでに「?」がついているURLの場合はURLの末尾に「?」ではなく「&」(半角)を必ず付けてください。※必須</td>
</tr>

<tr>
<th><label for="vc_yahoo_appid"><?php
_e('YAHOO!JAPANアプリケーションID', 'vc_yahoo_appid'); ?></label></th> <td><input size="80" type="text" name="vc_yahoo_appid"
id="vc_search_page" value="<?php
echo attribute_escape($vc_yahoo_appid); ?>" /><br />
※必須<br />
YAHOO!JAPANアプリケーションIDは下記URLで次の設定で取得してください。<br />
<a href="https://e.developer.yahoo.co.jp/webservices/register_application" blank="_target">Yahoo!デベロッパーネットワーク - 新しいアプリケーションを開発</a><br />
・認証を必要としないAPIを使ったアプリケーション<br />
・アプリケーション名、サイトURLは任意（実際に公開する予定のものを入力）<br />
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