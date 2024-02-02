<?php

if ( !defined( 'ABSPATH' ) ) {
    exit;
}
// Exit if accessed directly
//define( 'ELEMENTOR_PANDO__FILE__', __FILE__ );
/**
 * Load Hello World
 *
 * Load the plugin after Elementor (and other plugins) are loaded.
 *
 * @since 1.0.0
 */
function elpt_load()
{
    // Notice if the Elementor is not active
    if ( !did_action( 'elementor/loaded' ) ) {
        //add_action( 'admin_notices', 'elpt_fail_load' );
        return;
    }
    // Check required version
    $elementor_version_required = '1.8.0';
    
    if ( !version_compare( ELEMENTOR_VERSION, $elementor_version_required, '>=' ) ) {
        add_action( 'admin_notices', 'elpt_fail_load_out_of_date' );
        return;
    }
    
    // Require the main plugin file
    require __DIR__ . '/plugin.php';
}

add_action( 'plugins_loaded', 'elpt_load' );
function elpt_fail_load_out_of_date()
{
    if ( !current_user_can( 'update_plugins' ) ) {
        return;
    }
    $file_path = 'elementor/elementor.php';
    $upgrade_link = wp_nonce_url( self_admin_url( 'update.php?action=upgrade-plugin&plugin=' ) . $file_path, 'upgrade-plugin_' . $file_path );
    $message = '<p>' . esc_html( 'Powerfolio + Elementor is not working because you are using an old version of Elementor.', 'powerfolio' ) . '</p>';
    $message .= '<p>' . sprintf( '<a href="%s" class="button-primary">%s</a>', $upgrade_link, __( 'Update Elementor Now', 'powerfolio' ) ) . '</p>';
    echo  '<div class="error">' . wp_kses_post( $message ) . '</div>' ;
}

// Powerfolio - Get hover options for Elementor Widget
function elpt_get_hover_options_for_widget()
{
    $grid_options = array();
    $grid_options = array(
        'simple'  => __( 'Simple', 'powerfolio' ),
        'hover1'  => __( 'From Bottom', 'powerfolio' ),
        'hover2'  => __( 'From Top', 'powerfolio' ),
        'hover17' => __( 'Content Visible 1', 'powerfolio' ),
        'hover16' => __( 'Content Visible 2', 'powerfolio' ),
    );
    return $grid_options;
}
