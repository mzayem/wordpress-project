<?php

//Upgrade message
function pwgd_get_upgrade_message() {
	return '';
}

//limit content on excerpt
function pwgd_get_the_content($length = 100){
	$text = get_the_content();
	
    if(strlen($text)<$length+10) {
		return strip_tags($text); //don't cut if too shortx'x'Z
	} 
	
    $break_pos = strpos($text, ' ', $length); //find next space after desired length

    $visible = substr($text, 0, $break_pos);
    
	return strip_tags($visible). " […]";
} 

/**
 * Elementor Functions
 *
 */
add_action( 'plugins_loaded', 'pwgd_elemenload' );
function pwgd_elemenload() {
	// Load localization file
	load_plugin_textdomain( 'pwrgrids' );

	// Notice if the Elementor is not active
	if ( ! did_action( 'elementor/loaded' ) ) {
		//add_action( 'admin_notices', 'pwgd_fail_load' );
		return;
	}

	// Check required version
	$elementor_version_required = '1.8.0';
	if ( ! version_compare( ELEMENTOR_VERSION, $elementor_version_required, '>=' ) ) {
		add_action( 'admin_notices', 'pwgd_fail_load_out_of_date' );
		return;
	}
}



function pwgd_fail_load_out_of_date() {
	if ( ! current_user_can( 'update_plugins' ) ) {
		return;
	}

	$file_path = 'elementor/elementor.php';

	$upgrade_link = wp_nonce_url( self_admin_url( 'update.php?action=upgrade-plugin&plugin=' ) . $file_path, 'upgrade-plugin_' . $file_path );
	$message = '<p>' . esc_html( 'Powerfolio + Elementor is not working because you are using an old version of Elementor.', 'powerfolio' ) . '</p>';
	$message .= '<p>' . sprintf( '<a href="%s" class="button-primary">%s</a>', $upgrade_link, __( 'Update Elementor Now', 'powerfolio' ) ) . '</p>';

	echo '<div class="error">' . wp_kses_post($message) . '</div>';
}