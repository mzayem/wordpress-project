<?php
/**
 * Shortcode Meta class.
 *
 * @package RT_Portfolio
 */

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This script cannot be accessed directly.' );
}

if ( ! class_exists( 'TLPPortfolioSCMeta' ) ) :
	/**
	 * Shortcode Meta class.
	 */
	class TLPPortfolioSCMeta {
		public function __construct() {
			add_action( 'add_meta_boxes', [ $this, 'tlp_portfolio_sc_meta_boxes' ] );
			add_action( 'save_post', [ $this, 'save_tlp_portfolio_sc_meta_data' ], 10, 2 );
			add_action( 'admin_enqueue_scripts', [ $this, 'admin_enqueue_scripts_sc' ] );
			add_action( 'admin_enqueue_scripts', [ $this, 'admin_enqueue_scripts_settings' ] );
			add_action( 'edit_form_after_title', [ $this, 'portfolio_sc_after_title' ] );
			add_action( 'admin_init', [ $this, 'remove_all_meta_box' ] );
		}

		public function remove_all_meta_box() {
			if ( is_admin() ) {
				add_filter(
					'get_user_option_meta-box-order_{TLPPortfolio()->shortCodePT}',
					[ $this, 'remove_all_meta_boxes_portfolio_sc' ]
				);
			}
		}

		public function remove_all_meta_boxes_portfolio_sc() {
			global $wp_meta_boxes;

			$publishBox   = $wp_meta_boxes[ TLPPortfolio()->getScPostType() ]['side']['core']['submitdiv'];
			$scBox        = $wp_meta_boxes[ TLPPortfolio()->getScPostType() ]['normal']['high']['pfp_sc_settings_meta'];
			$scPreviewBox = $wp_meta_boxes[ TLPPortfolio()->getScPostType() ]['normal']['high']['pfp_sc_preview_meta'];
			$wp_meta_boxes[ TLPPortfolio()->getScPostType() ] = [
				'side'   => [ 'core' => [ 'submitdiv' => $publishBox ] ],
				'normal' => [
					'high' => [
						'pfp_sc_settings_meta' => $scBox,
						'pfp_sc_preview_meta'  => $scPreviewBox,
					],
				],
			];

			return [];
		}

		public function portfolio_sc_after_title( $post ) {
			if ( TLPPortfolio()->getScPostType() !== $post->post_type ) {
				return;
			}
			?>
			<div class="postbox" style="margin-bottom: 0;">
				<div class="inside">
					<p>
						<input type="text" onfocus="this.select();" readonly="readonly" value="[tlpportfolio id=&quot;<?php echo absint( $post->ID ); ?>&quot; title=&quot;<?php echo esc_attr( $post->post_title ); ?>&quot;]" class="large-text code tlp-code-sc">
						<input type="text" onfocus="this.select();" readonly="readonly" value="&#60;&#63;php echo do_shortcode( &#39;[tlpportfolio id=&quot;<?php echo absint( $post->ID ); ?>&quot; title=&quot;<?php echo esc_attr( $post->post_title ); ?>&quot;]&#39; ) &#63;&#62;" class="large-text code tlp-code-sc">
					</p>
				</div>
			</div>

			<?php
		}

		public function tlp_portfolio_sc_meta_boxes() {
			add_meta_box(
				'tlp_portfolio_sc_settings_meta',
				esc_html__( 'Short Code Generator', 'tlp-portfolio' ),
				[ $this, 'tlp_portfolio_sc_settings_selection' ],
				TLPPortfolio()->getScPostType(),
				'normal',
				'high'
			);

			add_meta_box(
				'pfp_sc_preview_meta',
				esc_html__( 'Layout Preview', 'tlp-portfolio' ),
				[ $this, 'pfp_sc_preview_selection' ],
				TLPPortfolio()->getScPostType(),
				'normal',
				'high'
			);
			add_meta_box(
				'rt_plugin_portfolio_sc_pro_information',
				esc_html__( 'Pro Documentation', 'tlp-portfolio' ),
				[ $this, 'rt_plugin_portfolio_sc_pro_information' ],
				TLPPortfolio()->getScPostType(),
				'side'
			);
		}

		public function rt_plugin_portfolio_sc_pro_information( $post ) {
			$doc     = 'https://radiustheme.com/how-to-setup-and-configure-tlp-portfolio-free-version-for-wordpress/';
			$contact = 'https://www.radiustheme.com/contact/';
			$fb      = 'https://www.facebook.com/groups/234799147426640/';
			$rt      = 'https://www.radiustheme.com/';
			if ( $post === 'settings' ) {
				?>
				<div class="rt-document-box rt-update-pro-btn-wrap">
					<a href="<?php echo esc_url( TLPPortfolio()->pro_version_link() ); ?>" target="_blank" class="rt-update-pro-btn">Update Pro To Get More Features</a>
				</div>
			<?php } ?>
			<div class="rt-document-box">
				<div class="rt-box-icon"><i class="dashicons dashicons-media-document"></i></div>
				<div class="rt-box-content">
					<h3 class="rt-box-title">Documentation</h3>
						<p>Get started by spending some time with the documentation we included step by step process with screenshots with video.</p>
						<a href="<?php echo esc_url( $doc ); ?>" target="_blank" class="rt-admin-btn">Documentation</a>
				</div>
			</div>

			<div class="rt-document-box">
				<div class="rt-box-icon"><i class="dashicons dashicons-sos"></i></div>
				<div class="rt-box-content">
					<h3 class="rt-box-title">Need Help?</h3>
					<p>Stuck with something? Please create a
					<a href="<?php echo esc_url( $contact ); ?>">ticket here</a> or post on <a href="<?php echo esc_url( $fb ); ?>">facebook group</a>. For emergency case join our <a href="<?php echo esc_url( $rt ); ?>">live chat</a>.</p>
					<a href="<?php echo esc_url( $contact ); ?>" target="_blank" class="rt-admin-btn">Get Support</a>
				</div>
			</div>
			<?php if ( $post !== 'settings' ) { ?>
				<div class="rt-document-box rt-update-pro-btn-wrap">
					<a href="<?php echo esc_url( TLPPortfolio()->pro_version_link() ); ?>" target="_blank" class="rt-update-pro-btn">Update Pro To Get More Features</a>
				</div>
			<?php } ?>

			<?php

		}

		public function tlp_portfolio_sc_settings_selection() {
			wp_nonce_field( TLPPortfolio()->nonceText(), TLPPortfolio()->nonceId() );

			?>
			<div id="sc-tabs" class="rt-tabs rt-tab-container">
				<ul class="tab-nav rt-tab-nav">
					<li class="active">
						<a href="#sc-layout-settings">
							<i class="dashicons dashicons-layout"></i>
							<?php esc_html_e( 'Layout', 'tlp-portfolio' ); ?>
						</a>
					</li>
					<li>
						<a href="#sc-filtering">
							<i class="dashicons dashicons-filter"></i>
							<?php esc_html_e( 'Filtering', 'tlp-portfolio' ); ?>
						</a>
					</li>
					<li>
						<a href="#sc-field-selection">
							<i class="dashicons dashicons-editor-table"></i> <?php esc_html_e( 'Field Selection', 'tlp-portfolio' ); ?>
						</a>
					</li>
					<li>
						<a href="#sc-style">
							<i class="dashicons dashicons-admin-customizer"></i>
							<?php esc_html_e( 'Styling', 'tlp-portfolio' ); ?>
						</a>
					</li>
				</ul>

				<div id="sc-layout-settings" class="rt-tab-content" style="display: block">
					<div class="tab-content">
						<?php TLPPortfolio()->print_html( TLPPortfolio()->rtFieldGenerator( TLPPortfolio()->scLayoutMetaFields() ), true ); ?>
					</div>
				</div>

				<div id="sc-filtering" class="rt-tab-content">
					<div class="tab-content">
						<?php TLPPortfolio()->print_html( TLPPortfolio()->rtFieldGenerator( TLPPortfolio()->scFilterMetaFields() ), true ); ?>
					</div>
				</div>

				<div id="sc-field-selection" class="rt-tab-content">
					<div class="tab-content">
						<?php TLPPortfolio()->print_html( TLPPortfolio()->rtFieldGenerator( TLPPortfolio()->scItemMetaFields() ), true ); ?>
					</div>
				</div>

				<div id="sc-style" class="rt-tab-content">
					<div class="tab-content">
						<?php TLPPortfolio()->print_html( TLPPortfolio()->rtFieldGenerator( TLPPortfolio()->scStyleFields() ), true ); ?>
					</div>
				</div>
			</div>
			<?php
		}

		public function pfp_sc_preview_selection() {
			?>
			<div id='pfp-response'>
				<span class='spinner'></span>
			</div>
			<div id='pfp-preview-container'></div>
			<?php
		}

		public function save_tlp_portfolio_sc_meta_data( $post_id, $post ) {
			if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
				return;
			}

			if ( ! TLPPortfolio()->verifyNonce() ) {
				return $post_id;
			}

			if ( TLPPortfolio()->getScPostType() != $post->post_type ) {
				return $post_id;
			}

			$mates = TLPPortfolio()->pfpScMetaFields();

			foreach ( $mates as $metaKey => $field ) {
				$rValue = ! empty( $_REQUEST[ $metaKey ] ) ? $_REQUEST[ $metaKey ] : null;
				$value  = TLPPortfolio()->sanitize( $field, $rValue );

				if ( empty( $field['multiple'] ) ) {
					update_post_meta( $post_id, $metaKey, $value );
				} else {
					delete_post_meta( $post_id, $metaKey );

					if ( is_array( $value ) && ! empty( $value ) ) {
						foreach ( $value as $item ) {
							add_post_meta( $post_id, $metaKey, $item );
						}
					} else {
						update_post_meta( $post_id, $metaKey, '' );
					}
				}
			}

			$this->generatorShortCodeCss( $post_id );
		}

		public function generatorShortCodeCss( $scID ) {
			global $wp_filesystem;

			// Initialize the WP filesystem, no more using 'file-put-contents' function.
			if ( empty( $wp_filesystem ) ) {
				require_once ABSPATH . '/wp-admin/includes/file.php';
				WP_Filesystem();
			}

			$upload_dir     = wp_upload_dir();
			$upload_basedir = $upload_dir['basedir'];
			$cssFile        = $upload_basedir . '/tlp-portfolio/portfolio-sc.css';

			if ( $css = TLPPortfolio()->render( 'portfolio-sc-css', compact( 'scID' ), true ) ) {
				$css = sprintf( '/*sc-%2$d-start*/%1$s/*sc-%2$d-end*/', $css, $scID );

				if ( file_exists( $cssFile ) && ( $oldCss = $wp_filesystem->get_contents( $cssFile ) ) ) {
					if ( strpos( $oldCss, '/*sc-' . $scID . '-start' ) !== false ) {
						$oldCss = preg_replace( '/\/\*sc-' . $scID . '-start[\s\S]+?sc-' . $scID . '-end\*\//', '', $oldCss );
						$oldCss = preg_replace( "/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/", '', $oldCss );
					}

					$css = $oldCss . $css;
				} elseif ( ! file_exists( $cssFile ) ) {
					$upload_basedir_trailingslashit = trailingslashit( $upload_basedir );
					$wp_filesystem->mkdir( $upload_basedir_trailingslashit . 'tlp-portfolio' );
				}

				if ( ! $wp_filesystem->put_contents( $cssFile, $css ) ) {
					error_log( print_r( 'Error Generated css file ', true ) );
				}
			}
		}

		public function admin_enqueue_scripts_settings() {
			global $typenow;

			if ( $typenow != TLPPortfolio()->post_type || ! isset( $_GET['page'] ) || $_GET['page'] !== 'tlp_portfolio_settings' ) {
				return;
			}

			wp_enqueue_script( [ 'wp-color-picker', 'tlp-portfolio-admin' ] );
			wp_enqueue_style( [ 'tlp-portfolio-admin', 'wp-color-picker' ] );
		}

		public function admin_enqueue_scripts_sc() {
			global $pagenow, $typenow;

			// validate page.
			if ( ! in_array( $pagenow, [ 'post.php', 'post-new.php', 'edit.php' ] ) ) {
				return;
			}

			if ( $typenow != TLPPortfolio()->getScPostType() ) {
				return;
			}

			// scripts.
			wp_enqueue_script(
				[
					'jquery',
					'wp-color-picker-alpha',
					'tlp-magnific',
					TLPPortfolio()->getSelect2JsId(),
					'tlp-owl-carousel',
					'tlp-isotope',
					'tlp-portfolio',
					'tlp-portfolio-admin',
				]
			);

			// styles.
			wp_enqueue_style(
				[
					'wp-color-picker',
					'tlp-select2',
					'tlp-owl-carousel',
					'tlp-owl-carousel-theme',
					'tlp-portfolio',
					'tlp-portfolio-admin',
				]
			);
		}
	}
endif;
