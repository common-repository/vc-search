<?php
// バリューコマーストークンと関連API用のsid、pid
function vc_search_valuecommerce() {
// ポストされた値の入力チェックと書き込み
if (isset($_POST['update_option'])) {
check_admin_referer('vc_search-options');
update_option('vc_search_token', $_POST['vc_search_token']);
update_option('ysh_sid', $_POST['ysh_sid']);
update_option('ysh_pid', $_POST['ysh_pid']);
update_option('yauc_sid', $_POST['yauc_sid']);
update_option('yauc_pid', $_POST['yauc_pid']);
?>
<div class="updated fade"><p><strong><?php _e('Options saved.'); ?></strong></p>
</div>
<?php }
$vctoken= get_option('vc_search_token');
$ysh_sid=get_option('ysh_sid');
$ysh_pid=get_option('ysh_pid');
$yauc_sid=get_option('yauc_sid');
$yauc_pid=get_option('yauc_pid');
?>

<div class="wrap">
<h2>VC SearchプラグインバリューコマースWeb Services関連設定</h2>
<p>商品などバリューコマースWebサービス利用するための設定です。Yahoo!のAPIからショッピングとオークションについてはバリューコマースのアフィリエイトリンクを組み立てるオプションもここで入力できるようになっています。</p>
<form name="form" method="post" action="">
<input type="hidden" name="action" value="update" />
<?php wp_nonce_field('vc_search-options'); ?>

<table class="form-table"><tbody>

<tr>
<th><label for="vc_search_token"><?php
_e('バリューコマーストークン（token）', 'vc_search'); ?></label></th> <td><input size="36" type="text" name="vc_search_token"
id="vc_search_token" value="<?php
echo attribute_escape($vctoken); ?>" /></td>
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

</tbody></table>

<p class="submit">
<input type="submit" name="update_option" class="button- primary" value="<?php _e('Save Changes'); ?>" />
</p>

</form>
</div>

<?php
}
?>