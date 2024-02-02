<?php

add_action( 'admin_menu', 'gaming_lite_getting_started' );
function gaming_lite_getting_started() {
	add_theme_page( esc_html__('Get Started', 'gaming-lite'), esc_html__('Get Started', 'gaming-lite'), 'edit_theme_options', 'gaming-lite-guide-page', 'gaming_lite_test_guide');
}

function gaming_lite_admin_enqueue_scripts() {
	wp_enqueue_style( 'gaming-lite-admin-style', esc_url( get_template_directory_uri() ).'/css/main.css' );
}
add_action( 'admin_enqueue_scripts', 'gaming_lite_admin_enqueue_scripts' );

if ( ! defined( 'GAMING_LITE_DOCS_FREE' ) ) {
define('GAMING_LITE_DOCS_FREE',__('https://www.misbahwp.com/docs/gaming-free-docs/','gaming-lite'));
}
if ( ! defined( 'GAMING_LITE_DOCS_PRO' ) ) {
define('GAMING_LITE_DOCS_PRO',__('https://www.misbahwp.com/docs/gaming-pro-docs/','gaming-lite'));
}
if ( ! defined( 'GAMING_LITE_BUY_NOW' ) ) {
define('GAMING_LITE_BUY_NOW',__('https://www.misbahwp.com/themes/gaming-wordpress-theme/','gaming-lite'));
}
if ( ! defined( 'GAMING_LITE_SUPPORT_FREE' ) ) {
define('GAMING_LITE_SUPPORT_FREE',__('https://wordpress.org/support/theme/gaming-lite','gaming-lite'));
}
if ( ! defined( 'GAMING_LITE_REVIEW_FREE' ) ) {
define('GAMING_LITE_REVIEW_FREE',__('https://wordpress.org/support/theme/gaming-lite/reviews/#new-post','gaming-lite'));
}
if ( ! defined( 'GAMING_LITE_DEMO_PRO' ) ) {
define('GAMING_LITE_DEMO_PRO',__('https://misbahwp.com/demo/gaming-pro/','gaming-lite'));
}

function gaming_lite_test_guide() { ?>
	<?php $gaming_lite_theme = wp_get_theme(); ?>
	<div class="wrap" id="main-page">
		<div id="lefty">
			<div id="admin_links">
				<a href="<?php echo esc_url( GAMING_LITE_DOCS_FREE ); ?>" target="_blank" class="blue-button-1"><?php esc_html_e( 'Documentation', 'gaming-lite' ) ?></a>
				<a href="<?php echo esc_url( admin_url('customize.php') ); ?>" id="customizer" target="_blank"><?php esc_html_e( 'Customize', 'gaming-lite' ); ?> </a>
				<a class="blue-button-1" href="<?php echo esc_url( GAMING_LITE_SUPPORT_FREE ); ?>" target="_blank" class="btn3"><?php esc_html_e( 'Support', 'gaming-lite' ) ?></a>
				<a class="blue-button-2" href="<?php echo esc_url( GAMING_LITE_REVIEW_FREE ); ?>" target="_blank" class="btn4"><?php esc_html_e( 'Review', 'gaming-lite' ) ?></a>
			</div>
			<div id="description">
				<h3><?php esc_html_e('Welcome! Thank you for choosing ','gaming-lite'); ?><?php echo esc_html( $gaming_lite_theme ); ?>  <span><?php esc_html_e('Version: ', 'gaming-lite'); ?><?php echo esc_html($gaming_lite_theme['Version']);?></span></h3>
				<img class="img_responsive" style="width:100%;" src="<?php echo esc_url( get_template_directory_uri() ); ?>/screenshot.png">
				<div id="description-inside">
					<?php
						$gaming_lite_theme = wp_get_theme();
						echo wp_kses_post( apply_filters( 'misbah_theme_description', esc_html( $gaming_lite_theme->get( 'Description' ) ) ) );
					?>
				</div>
			</div>
		</div>
		<div id="righty">
			<div class="postbox donate">
				<div class="d-table">
			    <ul class="d-column">
			      <li class="feature"><?php esc_html_e('Features','gaming-lite'); ?></li>
			      <li class="free"><?php esc_html_e('Pro','gaming-lite'); ?></li>
			      <li class="plus"><?php esc_html_e('Free','gaming-lite'); ?></li>
			    </ul>
			    <ul class="d-row">
			      <li class="points"><?php esc_html_e('24hrs Priority Support','gaming-lite'); ?></li>
			      <li class="right"><span class="dashicons dashicons-yes"></span></li>
			      <li class="wrong"><span class="dashicons dashicons-yes"></span></li>
			    </ul>
			    <ul class="d-row">
			      <li class="points"><?php esc_html_e('Kirki Framework','gaming-lite'); ?></li>
			      <li class="right"><span class="dashicons dashicons-yes"></span></li>
			      <li class="wrong"><span class="dashicons dashicons-yes"></span></li>
			    </ul>
			    <ul class="d-row">
			      <li class="points"><?php esc_html_e('Advance Posttype','gaming-lite'); ?></li>
			      <li class="right"><span class="dashicons dashicons-yes"></span></li>
			      <li class="wrong"><span class="dashicons dashicons-no"></span></li>
			    </ul>
			    <ul class="d-row">
			      <li class="points"><?php esc_html_e('One Click Demo Import','gaming-lite'); ?></li>
			      <li class="right"><span class="dashicons dashicons-yes"></span></li>
			      <li class="wrong"><span class="dashicons dashicons-no"></span></li>
			    </ul>
			    <ul class="d-row">
			      <li class="points"><?php esc_html_e('Section Reordering','gaming-lite'); ?></li>
			      <li class="right"><span class="dashicons dashicons-yes"></span></li>
			      <li class="wrong"><span class="dashicons dashicons-no"></span></li>
			    </ul>
			    <ul class="d-row">
			      <li class="points"><?php esc_html_e('Enable / Disable Option','gaming-lite'); ?></li>
			      <li class="right"><span class="dashicons dashicons-yes"></span></li>
			      <li class="wrong"><span class="dashicons dashicons-yes"></span></li>
			    </ul>
			    <ul class="d-row">
			      <li class="points"><?php esc_html_e('Multiple Sections','gaming-lite'); ?></li>
			      <li class="right"><span class="dashicons dashicons-yes"></span></li>
			      <li class="wrong"><span class="dashicons dashicons-no"></span></li>
			    </ul>
			    <ul class="d-row">
			      <li class="points"><?php esc_html_e('Advance Color Pallete','gaming-lite'); ?></li>
			      <li class="right"><span class="dashicons dashicons-yes"></span></li>
			      <li class="wrong"><span class="dashicons dashicons-no"></span></li>
			    </ul>
			    <ul class="d-row">
			      <li class="points"><?php esc_html_e('Advance Widgets','gaming-lite'); ?></li>
			      <li class="right"><span class="dashicons dashicons-yes"></span></li>
			      <li class="wrong"><span class="dashicons dashicons-yes"></span></li>
			    </ul>
			    <ul class="d-row">
			      <li class="points"><?php esc_html_e('Page Templates','gaming-lite'); ?></li>
			      <li class="right"><span class="dashicons dashicons-yes"></span></li>
			      <li class="wrong"><span class="dashicons dashicons-no"></span></li>
			    </ul>
			    <ul class="d-row">
			      <li class="points"><?php esc_html_e('Advance Typography','gaming-lite'); ?></li>
			      <li class="right"><span class="dashicons dashicons-yes"></span></li>
			      <li class="wrong"><span class="dashicons dashicons-no"></span></li>
			    </ul>
			    <ul class="d-row">
			      <li class="points"><?php esc_html_e('Section Background Image / Color ','gaming-lite'); ?></li>
			      <li class="right"><span class="dashicons dashicons-yes"></span></li>
			      <li class="wrong"><span class="dashicons dashicons-no"></span></li>
			    </ul>
	  		</div>
				<h3 class="hndle"><?php esc_html_e( 'Upgrade to Premium', 'gaming-lite' ); ?></h3>
				<div class="inside">
					<p><?php esc_html_e('Discover upgraded pro features with premium version click to upgrade.','gaming-lite'); ?></p>
					<div id="admin_pro_links">
						<a class="blue-button-2" href="<?php echo esc_url( GAMING_LITE_BUY_NOW ); ?>" target="_blank"><?php esc_html_e( 'Go Pro', 'gaming-lite' ); ?></a>
						<a class="blue-button-1" href="<?php echo esc_url( GAMING_LITE_DEMO_PRO ); ?>" target="_blank"><?php esc_html_e( 'Live Demo', 'gaming-lite' ) ?></a>
						<a class="blue-button-2" href="<?php echo esc_url( GAMING_LITE_DOCS_PRO ); ?>" target="_blank"><?php esc_html_e( 'Pro Docs', 'gaming-lite' ) ?></a>
					</div>
				</div>
			</div>
		</div>
	</div>

<?php } ?>
