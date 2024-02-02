<?php
/**
 * Elementor class.
 *
 * @package RT_Portfolio
 */

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This script cannot be accessed directly.' );
}

if ( ! class_exists( 'TLPPortfolioElementor' ) ) :
	/**
	 * Elementor class.
	 */
	class TLPPortfolioElementor {
		public function __construct() {
			if ( did_action( 'elementor/loaded' ) ) {
				add_action( 'elementor/widgets/register', [ $this, 'init' ] );
			}
		}

		public function init( $widgets_manager ) {
			global $TLPportfolio;

			require_once $TLPportfolio->incPath . '/vendor/TlpPortfolioElementorWidget.php';

			// Register widget.
			$widgets_manager->register( new TlpPortfolioElementorWidget() );
		}
	}
endif;
