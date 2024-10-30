<?php 

function cref_options()
{
    add_submenu_page('edit.php?post_type=refcontact', 'Contact Referal Options', 'Options', 'manage_options', 'croptions','cref_global_custom_options');
}
add_action('admin_menu', 'cref_options');

function cref_global_custom_options()
{
?>
    <div class="wrap">
        <h2><?php _e('Contact Referal Options Page', 'contact-reference') ?></h2>

        <?php if($_REQUEST['settings-updated'] == TRUE): ?>
        	<div id="message" class="updated"><p><?php _e('Contact Referal Options Saved.', 'contact-reference' ); ?></p></div>
    	<?php endif; ?>

        <form method="post" action="options.php">
            <?php wp_nonce_field('update-options') ?>
            <h3><?php _e('Global Options', 'contact-reference'); ?></h3>
            <table class="form-table">
				<tr valign="top">
					<th scope="row"><label for="wphub_use_api"><?php _e('Default Contact ID', 'contact-reference'); ?></label></th>
					<td>
						<fieldset>
							<input type="text" name="cref_default" size="45" class="regular-text code" value="<?php echo get_option('cref_default'); ?>" />
							<p class="description"><?php _e('Default ID if not defined. Leave blank to display latest contact.', 'contact-reference'); ?></p>
						</fieldset>
					</td>
				</tr>
			</table>

            <p><input type="submit" name="Submit" value="<?php _e('Save Options','contact-reference'); ?>" class="button button-primary" /></p>
            <input type="hidden" name="action" value="update" />
            <input type="hidden" name="page_options" value="cref_default,cref_hide,cref_widget_style,cref_shortcode_style" />
        </form>
    </div>
<?php
}
