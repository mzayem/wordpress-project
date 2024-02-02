<?php
	
require get_template_directory() . '/core/includes/class-tgm-plugin-activation.php';

/**
 * Recommended plugins.
 */
function gaming_lite_register_recommended_plugins() {
	$plugins = array(
		array(
			'name'             => __( 'Kirki Customizer Framework', 'gaming-lite' ),
			'slug'             => 'kirki',
			'required'         => false,
			'force_activation' => false,
		),
	);
	$config = array();
	gaming_lite_tgmpa( $plugins, $config );
}
add_action( 'tgmpa_register', 'gaming_lite_register_recommended_plugins' );