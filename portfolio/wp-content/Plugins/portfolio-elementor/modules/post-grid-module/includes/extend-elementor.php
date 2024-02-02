<?php
namespace Pwrgrids;
use Pwrgrids\Widgets\PWGD_Post_Grid_Widget;
use Pwrgrids\Widgets\PWGD_Product_Grid_Widget;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class PWGD_Register_PwrGrids_Elementor {

	/**
	 * Constructor
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function __construct() {
		$this->add_actions();
	}

	/**
	 * Add Actions
	 *
	 * @since 1.0.0
	 *
	 * @access private
	 */
	private function add_actions() {
		add_action( 'elementor/widgets/widgets_registered', [ $this, 'on_widgets_registered' ] );

		add_action( 'elementor/frontend/before_register_scripts', function() {			
			//Styles
			wp_enqueue_style( 'pwrgrids-css', plugin_dir_url( __FILE__ ) .  '../css/pwrgrids_css.css' );
			wp_enqueue_style( 'font-awesome-free', 'https://use.fontawesome.com/releases/v5.5.0/css/all.css' );
		
			//JS
			wp_enqueue_script( 'jquery');
			wp_enqueue_script( 'jquery-isotope', plugin_dir_url( __FILE__ ) . '../../../vendor/isotope/js/isotope.pkgd.min.js', array('jquery', 'imagesloaded'), '3.0.6', true );
			wp_enqueue_script( 'jquery-packery', plugin_dir_url( __FILE__ ) . '../../../vendor/isotope/js/packery-mode.pkgd.min.js', array('jquery','jquery-isotope', 'imagesloaded'), '2.0.1', true );		
			wp_enqueue_script( 'pwgd-custom-js', plugin_dir_url( __FILE__ ) . '../js/pwrgrids-custom-js.js', array('jquery','jquery-isotope','jquery-packery'), '20151215', true );				
		} );

		add_action( 'elementor/frontend/element_ready/widget', function() {	
					
		} );

		add_action( 'elementor/editor/before_enqueue_scripts', function() {			
			wp_enqueue_script( 'jquery-isotope', plugin_dir_url( __FILE__ ) . '../../../vendor/isotope/js/isotope.pkgd.min.js', array('jquery', 'imagesloaded'), '3.0.6', true );
			wp_enqueue_script( 'jquery-packery', plugin_dir_url( __FILE__ ) . '../../../vendor/isotope/js/packery-mode.pkgd.min.js', array('jquery', 'jquery-isotope'), '2.0.1', true );
			
			wp_enqueue_script( 'pwgd-custom-js-elementor', plugin_dir_url( __FILE__ ) . '../js/pwrgrids-custom-js-elementor.js', array('jquery', 'jquery-isotope'), '99999999', true );	
		} );		
	}

	/**
	 * On Widgets Registered
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function on_widgets_registered() {
		$this->includes();
		$this->register_widget();
	}

	/**
	 * Includes
	 *
	 * @since 1.0.0
	 *
	 * @access private
	 */
	private function includes() {
		require __DIR__ . '/../widgets/post_grid_widget.php';
		//Woocommerce
		if ( class_exists( 'WooCommerce' ) ) {
			require __DIR__ . '/../widgets/product_grid_widget.php';
		}
	}

	/**
	 * Register Widget
	 *
	 * @since 1.0.0
	 *
	 * @access private
	 */
	private function register_widget() {
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new PWGD_Post_Grid_Widget() );
		if ( class_exists( 'WooCommerce' ) ) {
			\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new PWGD_Product_Grid_Widget() );		
		}	
	}
}

new PWGD_Register_PwrGrids_Elementor();