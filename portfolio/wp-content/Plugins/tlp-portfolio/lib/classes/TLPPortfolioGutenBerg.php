<?php
/**
 * Gutenberg class.
 *
 * @package RT_Portfolio
 */

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This script cannot be accessed directly.' );
}

if ( ! class_exists( 'TLPPortfolioGutenBerg' ) && ! class_exists( 'TLPPortfolioGutenBurg' ) ) :
	/**
	 * Gutenberg class.
	 */
	class TLPPortfolioGutenBerg {
		protected $version;

		public function __construct() {
			$this->version = ( defined( 'WP_DEBUG' ) && WP_DEBUG ) ? time() : TLP_PORTFOLIO_VERSION;

			add_action( 'enqueue_block_assets', [ $this, 'block_assets' ] );
			add_action( 'enqueue_block_editor_assets', [ $this, 'block_editor_assets' ] );

			if ( function_exists( 'register_block_type' ) ) {
				register_block_type(
					'rt-portfolio/tlp-portfolio-pro',
					[
						'render_callback' => [ $this, 'render_shortcode_pro' ],
					]
				);
			}
		}

		public static function render_shortcode_pro( $atts ) {
			if ( ! empty( $atts['gridId'] ) ) {
				return do_shortcode( '[tlpportfolio id="' . absint( $atts['gridId'] ) . '"]' );
			}
		}

		public function block_assets() {
			wp_enqueue_style( 'wp-blocks' );
		}

		public function block_editor_assets() {
			// Scripts.
			wp_enqueue_script(
				'rt-tlp-portfolio-gb-block-js',
				TLPportfolio()->assetsUrl . 'js/tlp-portfolio-blocks.min.js',
				[ 'wp-blocks', 'wp-i18n', 'wp-element' ],
				$this->version,
				true
			);

			wp_localize_script(
				'rt-tlp-portfolio-gb-block-js',
				'rtPortfolio',
				[
					'layout'      => TLPportfolio()->oldScLayouts(),
					'column'      => TLPportfolio()->scColumns(),
					'orderby'     => TLPportfolio()->scOrderBy(),
					'order'       => TLPportfolio()->scOrder(),
					'alignments'  => TLPportfolio()->scAlignment(),
					'fontWeights' => TLPportfolio()->scTextWeight(),
					'fontSizes'   => TLPportfolio()->scFontSize(),
					'cats'        => TLPportfolio()->getAllPortFolioCategoryList(),
					'short_codes' => TLPportfolio()->get_shortCode_list(),
					'icon'        => TLPportfolio()->assetsUrl . 'images/portfolio.png',
				]
			);

			wp_enqueue_style( 'wp-edit-blocks' );
		}
	}
endif;
