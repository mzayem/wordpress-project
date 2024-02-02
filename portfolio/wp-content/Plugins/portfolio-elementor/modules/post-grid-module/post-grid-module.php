<?php
if ( !defined( 'ABSPATH' ) ) {
    exit;
}


function elpt_load_post_grid_module() {
    /*
    * Plugin Functions
    */
    require 'includes/functions.php';
    /*
    * Elementor
    */
    require 'includes/extend-elementor.php';
}


add_action( 'plugins_loaded', 'elpt_load_post_grid_module' );
/*
* Plugin Directory
*/
function pwgd_get_plugin_directory_url() {
    return plugin_dir_url(__FILE__);
}

