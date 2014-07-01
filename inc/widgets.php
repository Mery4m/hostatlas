<?php

function crum_widgets_init() {
    
  // Register Sidebars

    register_sidebar(array(
        'name' => __('Left Sidebar', 'crum'),
        'id' => 'sidebar-left',
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget' => '</section>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ));
    register_sidebar(array(
        'name' => __('Right Sidebar', 'crum'),
        'id' => 'sidebar-right',
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget' => '</section>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ));


    register_sidebar(array(
        'name' => __('Footer column 1', 'crum'),
        'id' => 'sidebar-footer-col1',
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget' => '</section>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ));
    register_sidebar(array(
        'name' => __('Footer column 2', 'crum'),
        'id' => 'sidebar-footer-col2',
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget' => '</section>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ));
    register_sidebar(array(
        'name' => __('Footer column 3', 'crum'),
        'id' => 'sidebar-footer-col3',
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget' => '</section>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ));

    register_sidebar(array(
        'name' => __('Sidebar for shop', 'crum'),
        'id' => 'shop-sidebar',
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget' => '</section>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ));

    $sidebars = get_option(NHPOPTIONS.'sidebars');
    
    if( is_array( $sidebars ) )
        foreach( $sidebars as $name => $position )
            register_sidebar(array(
                'name' => __( $name , 'crum'),
                'id' =>str_replace(' ', '-', strtolower($name)),
                'before_widget' => '<section id="%1$s" class="widget %2$s widget_%2$s">',
                'after_widget' => '</section>',
                'before_title' => '<h3 class="widget-title">',
                'after_title' => '</h3>',
            ));

}
/*
 * Include widgets
 */
require( get_template_directory() . '/inc/widgets/widget-tweets.php' );
require( get_template_directory() . '/inc/widgets/widget-tabs.php' );
require( get_template_directory() . '/inc/widgets/widget-gallery.php' );
require( get_template_directory() . '/inc/widgets/widget-search.php' );
require( get_template_directory() . '/inc/widgets/widget_categories.php' );
require( get_template_directory() . '/inc/widgets/widget-facebook.php' );
require( get_template_directory() . '/inc/widgets/widget-tags.php' );
require( get_template_directory() . '/inc/widgets/widget-video.php' );
require( get_template_directory() . '/inc/widgets/widget-audio.php' );
require( get_template_directory() . '/inc/widgets/widget-flickr.php' );
require( get_template_directory() . '/inc/widgets/widget-text.php' );
require( get_template_directory() . '/inc/widgets/widget-vcard.php' );
require( get_template_directory() . '/inc/widgets/widget-styled-list.php' );
require( get_template_directory() . '/inc/widgets/widget-count.php' );


/**
 * Register the widgets
 */

$module_dir = get_template_directory() . '/inc/modules/';

$modules = scandir($module_dir);

foreach($modules as $module){
    if(file_exists("$module_dir/$module/$module.php"))
        include("$module_dir/$module/$module.php");
}





/*
 * Register widgets
 */
register_widget( 'crum_latest_tweets' );
register_widget( 'crum_widget_tabs' );
register_widget( 'crum_gallery_widget' );
register_widget( 'crum_search_widget' );
register_widget( 'crum_icon_categories' );
register_widget( 'crum_widget_facebook' );
register_widget( 'crum_tags_widget' );
register_widget( 'crum_video_widget' );
register_widget( 'crum_widget_flickr' );
register_widget( 'crum_list_widget' );
register_widget( 'crum_text_subtitle' );
register_widget( 'roots_vcard_widget' );
register_widget( 'counter_widget' );
register_widget( 'crum_widgets_audio' );


add_action('widgets_init', 'crum_widgets_init');



/*
 * Custom sidebar function including
 */

function add_user_sidebar( $id, $meta ){
    $sidebar = get_post_meta($id, $meta, $single = true);
    if ( ( $sidebar ) &&  function_exists('dynamic_sidebar') )
        return  dynamic_sidebar( $sidebar );
}

function unregister_default_wp_widgets() {

    unregister_widget('WP_Widget_Text');

    unregister_widget('WP_Widget_Tag_Cloud');

    unregister_widget('WP_Widget_Search');

    unregister_widget('WP_Widget_Meta');

    unregister_widget('WP_Widget_Categories');

    unregister_widget('WP_Widget_Recent_Comments');


}

add_action('widgets_init', 'unregister_default_wp_widgets', 1);


/*
 * Woocommerce support
 */

add_action( 'after_setup_theme', 'woocommerce_support' );
function woocommerce_support() {
    add_theme_support( 'woocommerce' );
}



function override_woocommerce_widgets() {
    // Ensure our parent class exists to avoid fatal error (thanks Wilgert!)
    if ( class_exists( 'WC_Widget_Cart' ) ) {

        unregister_widget( 'WC_Widget_Cart' );
        unregister_widget( 'WC_Widget_Product_Categories' );
        unregister_widget( 'WC_Widget_Product_Tag_Cloud' );


        require( get_template_directory() . '/woocommerce/widgets/cart.php' );
        require( get_template_directory() . '/woocommerce/widgets/tag-cloud.php' );
        //require( get_template_directory() . '/woocommerce/widgets/login.php' );

        register_widget( 'crum_WC_Widget_Cart' );
        register_widget( 'crum_WC_Widget_Product_Tag_Cloud' );
        //register_widget( 'crum_Widget_Login' );

    }
}
add_action( 'widgets_init', 'override_woocommerce_widgets', 15 );

