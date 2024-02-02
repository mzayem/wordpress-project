<?php
/**
 * Frontend class.
 *
 * @package RT_Portfolio
 */

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This script cannot be accessed directly.' );
}

if ( ! class_exists( 'TPLportFrontEnd' ) ) :
	/**
	 * Frontend class.
	 */
	class TPLportFrontEnd {

		public function __construct() {
			add_action( 'wp_head', [ $this, 'custom_css' ] );
			add_action( 'wp_enqueue_scripts', [ $this, 'tlp_portfolio_wp_enqueue_scripts' ] );
		}

		public function custom_css() {
			global $TLPportfolio;

			$html     = null;
			$settings = get_option( $TLPportfolio->options['settings'] );
			$pc       = ( isset( $settings['primary_color'] ) ? ( $settings['primary_color'] ? $settings['primary_color'] : '#0367bf' ) : '#0367bf' );
			$cCss     = ( isset( $settings['custom_css'] ) ? ( $settings['custom_css'] ? $settings['custom_css'] : null ) : null );

			if ( $cCss || $pc ) { ?>
				<style>
					.tlp-team .short-desc, .tlp-team .tlp-team-isotope .tlp-content, .tlp-team .button-group .selected, .tlp-team .layout1 .tlp-content, .tlp-team .tpl-social a, .tlp-team .tpl-social li a.fa,.tlp-portfolio button.selected,.tlp-portfolio .layoutisotope .tlp-portfolio-item .tlp-content,.tlp-portfolio button:hover {
						background: <?php echo esc_html( $pc ); ?> ;
					}
					.tlp-portfolio .layoutisotope .tlp-overlay,.tlp-portfolio .layout1 .tlp-overlay,.tlp-portfolio .layout2 .tlp-overlay,.tlp-portfolio .layout3 .tlp-overlay, .tlp-portfolio .slider .tlp-overlay {
						background: <?php echo esc_html( $TLPportfolio->TLPhex2rgba( $pc, .8 ) ); ?>;
					}
					<?php echo esc_html( $cCss ); ?>
				</style>
				<?php
			}
		}

		public function tlp_portfolio_wp_enqueue_scripts() {
			global $TLPportfolio;

			wp_enqueue_style( 'tlpportfolio-css', $TLPportfolio->assetsUrl . 'css/tlpportfolio.css' );

			$version    = '';
			$upload_dir = wp_upload_dir();
			$cssFile    = $upload_dir['basedir'] . '/tlp-portfolio/portfolio-sc.css';

			if ( file_exists( $cssFile ) ) {
				$version = filemtime( $cssFile );
				wp_enqueue_style( 'portfolio-sc', set_url_scheme( $upload_dir['baseurl'] ) . '/tlp-portfolio/portfolio-sc.css', '', $version );
			}
		}
	}
endif;
