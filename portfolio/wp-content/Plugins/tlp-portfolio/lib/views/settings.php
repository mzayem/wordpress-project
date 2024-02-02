<?php
/**
 * Settings Page.
 *
 * @package RT_Portfolio
 */

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This script cannot be accessed directly.' );
}

global $TLPportfolio;

$settings = get_option( $TLPportfolio->options['settings'] );
?>
<div class="wrap">
	<h2><?php esc_html_e( 'TLP Portfolio Settings', 'tlp-portfolio' ); ?></h2>
	<div class="rt-settings-container">
		<div class="rt-setting-content">
			<form id="tlp-portfolio-settings">
				<h3><?php esc_html_e( 'General settings', 'tlp-portfolio' ); ?></h3>
				<table class="form-table">
					<tr>
						<th scope="row"><label for="primary-color"><?php esc_html_e( 'Primary Color', 'tlp-portfolio' ); ?></label>
						</th>
						<td class="">
							<input name="primary_color" id="primary_color" type="text" value="<?php echo( isset( $settings['primary_color'] ) ? ( $settings['primary_color'] ? esc_attr( $settings['primary_color'] ) : '#0367bf' ) : '#0367bf' ); ?>" class="tlp-color">
						</td>
					</tr>

					<tr>
						<th scope="row"><label for="slug"><?php esc_html_e( 'Slug', 'tlp-portfolio' ); ?></label></th>
						<td class="">
							<input name="slug" id="slug" type="text"value="<?php echo( isset( $settings['slug'] ) ? ( $settings['slug'] ? sanitize_title_with_dashes( $settings['slug'] ) : 'portfolio' ) : 'portfolio' ); ?>" size="8" class="">
							<p class="description"><?php esc_html_e( 'Slug configuration', 'tlp-portfolio' ); ?></p>
						</td>
					</tr>

					<tr>
						<th scope="row"><label for="link_detail_page"><?php esc_html_e( 'Link To Detail Page', 'tlp-portfolio' ); ?></label>
						</th>
						<td class="">
							<fieldset>
								<legend class="screen-reader-text"><span>Link To Detail Page</span></legend>
								<?php
								$opt = [
									'yes' => 'Yes',
									'no'  => 'No',
								];
								$i   = 0;
								$pds = ( isset( $settings['link_detail_page'] ) ? ( $settings['link_detail_page'] ? $settings['link_detail_page'] : 'yes' ) : 'yes' );

								foreach ( $opt as $key => $value ) {
									$select = ( ( $pds == $key ) ? 'checked="checked"' : null );
									echo "<label title='" . esc_attr( $value ) . "'><input type='radio' $select name='link_detail_page' value='" . esc_attr( $key ) . "' >" . esc_html( $value ) . '</label>';

									if ( $i == 0 ) {
										echo '<br>';
									}

									$i++;
								}
								?>
							</fieldset>
						</td>
					</tr>
					<tr>
						<th scope="row"><label for="css"><?php esc_html_e( 'Social Share To Detail Page', 'tlp-portfolio' ); ?></label>
						</th>
						<td>
							<fieldset>
								<legend class="screen-reader-text"><span>Social Share</span></legend>
								<label for="social_share_enable">
									<input name="social_share_enable" type="checkbox" id="social_share_enable" value="1" <?php checked( 1, isset( $settings['social_share_enable'] ) ? 1 : 0 ); ?> /> <?php esc_html_e( 'Enable', 'tlp-portfolio' ); ?></label>
							</fieldset>
						</td>
					</tr>
					<tr>
						<th scope="row"><label for="css"><?php esc_html_e( 'Custom Css', 'tlp-portfolio' ); ?></label>
						</th>
						<td>
							<textarea name="custom_css" cols="40" rows="6"><?php echo( isset( $settings['custom_css'] ) ? ( $settings['custom_css'] ? stripslashes_deep( $settings['custom_css'] ) : null ) : null ); ?></textarea>
						</td>
					</tr>

				</table>
				<p class="submit"><input type="submit" name="submit" id="tlpSaveButton" class="rt-admin-btn button button-primary" value="<?php esc_attr_e( 'Save Changes', 'tlp-portfolio' ); ?>"></p>

				<?php wp_nonce_field( $TLPportfolio->nonceText(), 'tlp_nonce' ); ?>
			</form>
			<div id="response" class="updated"></div>
		</div>
		<div class="rt-pro-feature-content">
			<?php $TLPportfolio->rt_plugin_portfolio_sc_pro_information( 'settings' ); ?>
		</div>
	</div>
</div>
