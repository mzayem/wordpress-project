<?php
/**
 * Notice class.
 *
 * @package RT_Portfolio
 */

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This script cannot be accessed directly.' );
}

if ( ! class_exists( 'TLPPortfolioNotice' ) ):
	/**
	 * Notice class.
	 */
	class TLPPortfolioNotice {
		public function __construct() {
			register_activation_hook( TLP_PORTFOLIO_PLUGIN_ACTIVE_FILE_NAME, [ $this, 'rtport_activation_time' ] );
			add_action( 'admin_init', [ $this, 'rtport_check_installation_time' ] );
			add_action( 'admin_init', [ __CLASS__, 'rtport_spare_me' ], 5 );

			// Black Friday.
			add_action(
				'admin_init',
				function () {
					$current = time();
					if ( mktime( 0, 0, 0, 11, 18, 2022 ) <= $current && $current <= mktime( 0, 0, 0, 1, 15, 2023 ) ) {
						if ( '1' !== get_option( 'rtpf_ny_2023' ) ) {
							if ( ! isset( $GLOBALS['rt_pf_ny_2023_notice'] ) ) {
								$GLOBALS['rt_pf_ny_2023_notice'] = 'rtpf_ny_2023';
								self::bf_notice();
							}
						}
					}
				}
			);
		}

		// add plugin activation time
		public static function rtport_activation_time() {
			$get_activation_time = strtotime( "now" );
			add_option( 'rtport_plugin_activation_time', $get_activation_time );
		}

		//check if review notice should be shown or not.
		public static function rtport_check_installation_time() {
			// Added Lines Start.
			$nobug = get_option( 'rtport_spare_me', "0");

			if ($nobug == "1" || $nobug == "3") {
				return;
			}

			$install_date = get_option( 'rtport_plugin_activation_time' );
			$past_date    = strtotime( '-10 days' );

			$remind_time = get_option( 'rtport_remind_me' );
			$remind_due  = strtotime( '+15 days', $remind_time );
			$now         = strtotime( "now" );

			if ( $now >= $remind_due ) {
				add_action( 'admin_notices', [__CLASS__, 'rtport_display_admin_notice']);
			} else if (($past_date >= $install_date) &&  $nobug !== "2") {
				add_action( 'admin_notices', [__CLASS__, 'rtport_display_admin_notice']);
			}
		}

		/**
		 * Display Admin Notice, asking for a review
		 **/
		public static function rtport_display_admin_notice() {
			// wordpress global variable
			global $pagenow;

			$exclude = [ 'themes.php', 'users.php', 'tools.php', 'options-general.php', 'options-writing.php', 'options-reading.php', 'options-discussion.php', 'options-media.php', 'options-permalink.php', 'options-privacy.php', 'edit-comments.php', 'upload.php', 'media-new.php', 'admin.php', 'import.php', 'export.php', 'site-health.php', 'export-personal-data.php', 'erase-personal-data.php' ];

			if ( ! in_array( $pagenow, $exclude ) ) {
				$args         = [ '_wpnonce' => wp_create_nonce( 'rtport_notice_nonce' ) ];
				$dont_disturb = add_query_arg( $args + [ 'rtport_spare_me' => '1' ], self::rtport_current_admin_url() );
				$remind_me    = add_query_arg( $args + [ 'rtport_remind_me' => '1' ], self::rtport_current_admin_url() );
				$rated        = add_query_arg( $args + [ 'rtport_rated' => '1' ], self::rtport_current_admin_url() );
				$reviewurl    = 'https://wordpress.org/support/plugin/tlp-portfolio/reviews/?filter=5#new-post';

				printf(
					__( '<div class="notice rtport-review-notice rtport-review-notice--extended">
							<div class="rtport-review-notice_content">
								<h3>Enjoying Portfolio Plugin?</h3>
								<p>Thank you for choosing Portfolio Plugin. If you have found our plugin useful and makes you smile, please consider giving us a 5-star rating on WordPress.org. It will help us to grow.</p>
								<div class="rtport-review-notice_actions">
									<a href="%s" class="rtport-review-button rtport-review-button--cta" target="_blank"><span>⭐ Yes, You Deserve It!</span></a>
									<a href="%s" class="rtport-review-button rtport-review-button--cta rtport-review-button--outline"><span>😀 Already Rated!</span></a>
									<a href="%s" class="rtport-review-button rtport-review-button--cta rtport-review-button--outline"><span>🔔 Remind Me Later</span></a>
									<a href="%s" class="rtport-review-button rtport-review-button--cta rtport-review-button--error rtport-review-button--outline"><span>😐 No Thanks</span></a>
								</div>
							</div>
						</div>' ),
					esc_url( $reviewurl ),
					esc_url( $rated ),
					esc_url( $remind_me ),
					esc_url( $dont_disturb )
				);

				echo '<style>
				.rtport-review-button--cta {
					--e-button-context-color: #4C6FFF;
					--e-button-context-color-dark: #4C6FFF;
					--e-button-context-tint: rgb(75 47 157/4%);
					--e-focus-color: rgb(75 47 157/40%);
				}
				.rtport-review-notice {
					position: relative;
					margin: 5px 20px 5px 2px;
					border: 1px solid #ccd0d4;
					background: #fff;
					box-shadow: 0 1px 4px rgba(0,0,0,0.15);
					font-family: Roboto, Arial, Helvetica, Verdana, sans-serif;
					border-inline-start-width: 4px;
				}
				.rtport-review-notice.notice {
					padding: 0;
				}
				.rtport-review-notice:before {
					position: absolute;
					top: -1px;
					bottom: -1px;
					left: -4px;
					display: block;
					width: 4px;
					background: -webkit-linear-gradient(bottom, #4C6FFF 0%, #6939c6 100%);
					background: linear-gradient(0deg, #4C6FFF 0%, #6939c6 100%);
					content: "";
				}
				.rtport-review-notice_content {
					padding: 20px;
				}
				.rtport-review-notice_actions > * + * {
					margin-inline-start: 8px;
					-webkit-margin-start: 8px;
					-moz-margin-start: 8px;
				}
				.rtport-review-notice p {
					margin: 0;
					padding: 0;
					line-height: 1.5;
				}
				p + .rtport-review-notice_actions {
					margin-top: 1rem;
				}
				.rtport-review-notice h3 {
					margin: 0;
					font-size: 1.0625rem;
					line-height: 1.2;
				}
				.rtport-review-notice h3 + p {
					margin-top: 8px;
				}
				.rtport-review-button {
					display: inline-block;
					padding: 0.4375rem 0.75rem;
					border: 0;
					border-radius: 3px;;
					background: var(--e-button-context-color);
					color: #fff;
					vertical-align: middle;
					text-align: center;
					text-decoration: none;
					white-space: nowrap;
				}
				.rtport-review-button:active {
					background: var(--e-button-context-color-dark);
					color: #fff;
					text-decoration: none;
				}
				.rtport-review-button:focus {
					outline: 0;
					background: var(--e-button-context-color-dark);
					box-shadow: 0 0 0 2px var(--e-focus-color);
					color: #fff;
					text-decoration: none;
				}
				.rtport-review-button:hover {
					background: var(--e-button-context-color-dark);
					color: #fff;
					text-decoration: none;
				}
				.rtport-review-button.focus {
					outline: 0;
					box-shadow: 0 0 0 2px var(--e-focus-color);
				}
				.rtport-review-button--error {
					--e-button-context-color: #d72b3f;
					--e-button-context-color-dark: #ae2131;
					--e-button-context-tint: rgba(215,43,63,0.04);
					--e-focus-color: rgba(215,43,63,0.4);
				}
				.rtport-review-button.rtport-review-button--outline {
					border: 1px solid;
					background: 0 0;
					color: var(--e-button-context-color);
				}
				.rtport-review-button.rtport-review-button--outline:focus {
					background: var(--e-button-context-tint);
					color: var(--e-button-context-color-dark);
				}
				.rtport-review-button.rtport-review-button--outline:hover {
					background: var(--e-button-context-tint);
					color: var(--e-button-context-color-dark);
				}
			</style>';
			}
		}

		protected static function rtport_current_admin_url() {
			$uri = isset( $_SERVER['REQUEST_URI'] ) ? esc_url_raw( wp_unslash( $_SERVER['REQUEST_URI'] ) ) : '';
			$uri = preg_replace( '|^.*/wp-admin/|i', '', $uri );

			if ( ! $uri ) {
				return '';
			}
			return remove_query_arg( [ '_wpnonce', '_wc_notice_nonce', 'wc_db_update', 'wc_db_update_nonce', 'wc-hide-notice' ], admin_url( $uri ) );
		}

		// remove the notice for the user if review already done or if the user does not want to.
		public static function rtport_spare_me() {
			if ( ! isset( $_REQUEST['_wpnonce'] ) || ! wp_verify_nonce( $_REQUEST['_wpnonce'], 'rtport_notice_nonce' ) ) {
				return;
			}

			if ( isset( $_GET['rtport_spare_me'] ) && ! empty( $_GET['rtport_spare_me'] ) ) {
				$spare_me = absint( $_GET['rtport_spare_me'] );

				if ( 1 == $spare_me ) {
					update_option( 'rtport_spare_me', "1" );
				}
			}

			if ( isset( $_GET['rtport_remind_me'] ) && ! empty( $_GET['rtport_remind_me'] ) ) {
				$remind_me = absint( $_GET['rtport_remind_me'] );

				if ( 1 == $remind_me ) {
					$get_activation_time = strtotime( "now" );
					update_option( 'rtport_remind_me', $get_activation_time );
					update_option( 'rtport_spare_me', "2" );
				}
			}

			if ( isset( $_GET['rtport_rated'] ) && ! empty( $_GET['rtport_rated'] ) ) {
				$rtport_rated = absint( $_GET['rtport_rated'] );

				if ( 1 == $rtport_rated ) {
					update_option( 'rtport_rated', 'yes' );
					update_option( 'rtport_spare_me', "3" );
				}
			}
		}

		/**
		 * Black Friday Notice
		 *
		 * @return void
		 */
		public static function bf_notice() {
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
					<div class="notice notice-info is-dismissible" data-rtpfdismissable="rtpf_ny_2023"
					     style="display:grid;grid-template-columns: 100px auto;padding-top: 25px; padding-bottom: 22px;">
						<img alt="<?php echo esc_attr( $plugin_name ); ?>" src="<?php echo esc_url( TLPPortfolio()->assetsUrl ) . 'images/portfolio-gif.gif'; ?>" width="74px" height="74px" style="grid-row: 1 / 4; align-self: center;justify-self: center"/>
						<h3 style="margin:0;"><?php echo sprintf( '%s New Year Deal!!', esc_html( $plugin_name ) ); ?></h3>

						<p style="margin:0 0 2px;">
							<?php echo esc_html__( "Don't miss out on our biggest sale of the year! Get yours.", 'testimonial-slider-showcase' ); ?>
							<b><?php echo esc_html( $plugin_name ); ?> plan</b> with <b>UP TO 50% OFF</b>! Limited time offer!!
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
                                    $('div[data-rtpfdismissable] .notice-dismiss, div[data-rtpfdismissable] .button-dismiss')
                                        .on('click', function (e) {
                                            e.preventDefault();
                                            $.post(ajaxurl, {
                                                'action': 'rtpf_dismiss_admin_notice',
                                                'nonce': <?php echo wp_json_encode( wp_create_nonce( 'rtpf-dismissible-notice' ) ); ?>
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
				'wp_ajax_rtpf_dismiss_admin_notice',
				function () {
					check_ajax_referer( 'rtpf-dismissible-notice', 'nonce' );

					update_option( 'rtpf_ny_2023', '1' );
					wp_die();
				}
			);
		}
	}
endif;
