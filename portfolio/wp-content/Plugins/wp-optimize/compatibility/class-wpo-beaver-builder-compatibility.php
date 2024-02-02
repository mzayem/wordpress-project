<?php
if (!defined('ABSPATH')) {
	die('No direct access allowed');
}

/**
 * Adds compatibility for Beaver Builder plugin.
 */
class WPO_Beaver_Builder_Compatibility {

	/**
	 * Instance of this class
	 *
	 * @var WPO_Beaver_Builder_Compatibility|null
	 */
	protected static $instance = null;
	
	/**
	 * Constructor.
	 */
	private function __construct() {
		$this->disable_webp_alter_html_in_edit_mode();
	}

	/**
	 * Returns singleton instance.
	 *
	 * @return WPO_Beaver_Builder_Compatibility
	 */
	public static function instance() {
		if (null == self::$instance) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	/**
	 * Checks if current page is in Beaver Builder edit mode.
	 *
	 * @return bool
	 */
	public static function is_edit_mode() {
		return isset($_GET['fl_builder']);
	}

	/**
	 * Disables altering HTML for WebP when current page is in edit mode.
	 */
	public function disable_webp_alter_html_in_edit_mode() {
		if (self::is_edit_mode()) {
			add_filter('wpo_disable_webp_alter_html', '__return_true');
		}
	}
}
