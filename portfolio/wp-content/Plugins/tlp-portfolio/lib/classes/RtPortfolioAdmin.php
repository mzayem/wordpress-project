<?php
/**
 * Admin class.
 *
 * @package RT_Portfolio
 */

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This script cannot be accessed directly.' );
}

if ( ! class_exists( 'RtPortfolioAdmin' ) ) :
	/**
	 * Admin class.
	 */
	class RtPortfolioAdmin {
		public function __construct() {
			add_action(
				'admin_init',
				function () {
					$current = time();
					if ( mktime( 0, 0, 0, 11, 22, 2021 ) <= $current && $current <= mktime( 0, 0, 0, 12, 6, 2021 ) ) {
						if ( get_option( 'rtportfolio_bf_2021' ) != '1' ) {
							if ( ! isset( $GLOBALS['rt_bf_2021_notice'] ) ) {
								$GLOBALS['rt_bf_2021_notice'] = 'rtportfolio_bf_2021';
								self::notice();
							}
						}
					}
				}
			);
		}

		public static function notice() {
			add_action(
				'admin_enqueue_scripts',
				function () {
					wp_enqueue_script( 'jquery' );
				}
			);

			add_action(
				'admin_notices',
				function () {
					$plugin_name   = 'Portfolio Pro';
					$download_link = TLPPortfolio()->pro_version_link();
					?>
					<div class="notice notice-info is-dismissible" data-rtportfoliodismissable="rtportfolio_bf_2021"
						style="display:grid;grid-template-columns: 100px auto;padding-top: 25px; padding-bottom: 22px;">
						<img alt="<?php echo esc_attr( $plugin_name ); ?>"
							src="<?php echo esc_url( TLPPortfolio()->assetsUrl . 'images/notice.png' ); ?>" width="74px"
							height="74px" style="grid-row: 1 / 4; align-self: center;justify-self: center"/>
						<h3 style="margin:0;"><?php echo sprintf( '%s Black Friday Deal!!', esc_html( $plugin_name ) ); ?></h3>

						<p style="margin:0 0 2px;">
							<?php echo esc_html__( "Don't miss out on our biggest sale of the year! Get your.", 'tlp-portfolio' ); ?>
							<b><?php echo esc_html( $plugin_name ); ?> plan</b> with <b>UP TO 50% OFF</b>! Limited time offer expires on December 5.
						</p>

						<p style="margin:0;">
							<a class="button button-primary" href="<?php echo esc_url( $download_link ); ?>" target="_blank">Buy Now</a>
							<a class="button button-dismiss" href="#">Dismiss</a>
						</p>
					</div>
					<?php
				}
			);

			add_action(
				'admin_footer',
				function () {
					?>
				<script type="text/javascript">
					(function ($) {
						$(function () {
							setTimeout(function () {
								$('div[data-rtportfoliodismissable] .notice-dismiss, div[data-rtportfoliodismissable] .button-dismiss')
									.on('click', function (e) {
										e.preventDefault();
										$.post(ajaxurl, {
											'action': 'rtportfolio_dismiss_admin_notice',
											'nonce': <?php echo json_encode( wp_create_nonce( 'rtportfolio-dismissible-notice' ) ); ?>
										});
										$(e.target).closest('.is-dismissible').remove();
									});
							}, 1000);
						});
					})(jQuery);
				</script>
					<?php
				}
			);

			add_action(
				'wp_ajax_rtportfolio_dismiss_admin_notice',
				function () {
					check_ajax_referer( 'rtportfolio-dismissible-notice', 'nonce' );

					update_option( 'rtportfolio_bf_2021', '1' );
					wp_die();
				}
			);
		}
	}
endif;
