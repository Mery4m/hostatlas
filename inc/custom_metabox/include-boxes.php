<?php
add_action( 'init', 'cmb_initialize_cmb_meta_boxes', 9999 );
/**
 * Initialize the metabox class.
 */
function cmb_initialize_cmb_meta_boxes() {
    if ( ! class_exists( 'cmb_Meta_Box' ) )
        require_once locate_template('/inc/lib/metabox/init.php');
}

require_once 'page-boxes.php';
require_once 'portfolio-boxes.php';
require_once 'layout-boxes.php';
