<?php
/**
 * Portfolio Single class.
 *
 * @package RT_Portfolio
 */

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This script cannot be accessed directly.' );
}

if ( ! class_exists( 'TLPPortfolioSingleItem' ) ) :
	/**
	 * Portfolio Single class.
	 */
	class TLPPortfolioSingleItem {

		public function __construct() {
			add_filter( 'template_include', [ $this, 'add_posttype_slug_template' ] );
			add_action( 'wp_enqueue_scripts', [ __CLASS__, 'single_portfolio_script' ] );
			add_filter( 'body_class', [ __CLASS__, 'portfolio_body_classes' ] );

		}

		public static function portfolio_body_classes( $classes ) {
			if ( is_singular( TLPPortfolio()->post_type ) || is_post_type_archive( TLPPortfolio()->post_type ) ) {
				$classes[] = 'tlp-portfolio';
			}

			return $classes;
		}

		/**
		 * TODO : Need to remove this unused
		 */
		public static function single_portfolio_script() {
			if ( is_singular( TLPPortfolio()->post_type ) || is_post_type_archive( TLPPortfolio()->post_type ) ) {
				// wp_enqueue_style( 'tlp-fontawsome' );
			}
		}

		public function add_posttype_slug_template( $single_template ) {
			$single_portfolio_template = locate_template( 'single-portfolio.php' );

			// TODO: Need use TLPPortfolio()->render( 'layouts/' . $layout, $arg, true );
			if ( is_singular( TLPPortfolio()->post_type ) && is_main_query() ) {
				if ( ! file_exists( $single_portfolio_template ) ) {
					return TLP_PORTFOLIO_PLUGIN_PATH . '/lib/templates/single-portfolio.php';
				}
			}

			return $single_template;
		}
	}
endif;
