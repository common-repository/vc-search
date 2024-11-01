<?php
// 楽天ウェブサービス
function vc_search_rws() {
// ポストされた値の入力チェックと書き込み
if (isset($_POST['update_option'])) {
check_admin_referer('vc_search-options');
update_option('rakuten_search_token', $_POST['rakuten_search_token']);
update_option('rakuten_affiliate_id', $_POST['rakuten_affiliate_id']);
?>
<div class="updated fade"><p><strong><?php _e('Options saved.'); ?></strong></p>
</div>
<?php }
$rakutentoken= get_option('rakuten_search_token');
$rakutenaffid= get_option('rakuten_affiliate_id');
?>

<div class="wrap">
<h2>VC Searchプラグイン楽天ウェブサービス関連設定</h2>
<p>楽天ウェブサービス利用するための設定です</p>
<form name="form" method="post" action="">
<input type="hidden" name="action" value="update" />
<?php wp_nonce_field('vc_search-options'); ?>

<table class="form-table"><tbody>

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

</tbody></table>

<p class="submit">
<input type="submit" name="update_option" class="button- primary" value="<?php _e('Save Changes'); ?>" />
</p>

</form>
</div>

<?php
}
?>