<?php
/**
 * Widget Init class.
 *
 * @package RT_Portfolio
 */

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This script cannot be accessed directly.' );
}

if ( ! class_exists( 'TLPportInitWidget' ) ) :
	/**
	 * Widget Init class.
	 */
	class TLPportInitWidget {
		public function __construct() {
			add_action( 'widgets_init', [ $this, 'initWidget' ] );
		}


		public function initWidget() {
			global $TLPportfolio;

			$TLPportfolio->loadWidget( $TLPportfolio->widgetsPath );
		}
	}
endif;
