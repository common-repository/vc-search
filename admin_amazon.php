<?php
// Amazon
function vc_search_amazon() {
// ポストされた値の入力チェックと書き込み
if (isset($_POST['update_option'])) {
check_admin_referer('vc_search-options');
update_option('amzacckey', $_POST['amzacckey']);
update_option('amzseckey', $_POST['amzseckey']);
update_option('amzassid', $_POST['amzassid']);
?>
<div class="updated fade"><p><strong><?php _e('Options saved.'); ?></strong></p>
</div>
<?php }
$amzacckey=get_option('amzacckey');
$amzseckey=get_option('amzseckey');
$amzassid=get_option('amzassid');
?>

<div class="wrap">
<h2>VC SearchプラグインAmazon.co.jp関連設定</h2>
<p>AmazonのAPIを利用するための設定です</p>
<form name="form" method="post" action="">
<input type="hidden" name="action" value="update" />
<?php wp_nonce_field('vc_search-options'); ?>

<table class="form-table"><tbody>

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

</tbody></table>

<p class="submit">
<input type="submit" name="update_option" class="button- primary" value="<?php _e('Save Changes'); ?>" />
</p>

</form>
</div>

<?php
}
?>