<?php

/*
 * Portfolio taxonomy
 */
function my_custom_post_product() {
	$labels = array(
		'name'               => __( 'Portfolios' , 'crum' ),
		'singular_name'      => __( 'Portfolio' , 'crum' ),
		'add_new'            => __( 'Add New' , 'crum' ),
		'add_new_item'       => __( 'Add New Portfolio item' , 'crum' ),
		'edit_item'          => __( 'Edit Portfolio item' , 'crum' ),
		'new_item'           => __( 'New Portfolio item' , 'crum' ),
		'all_items'          => __( 'All Portfolio items' , 'crum' ),
		'view_item'          => __( 'View Portfolio item' , 'crum' ),
		'search_items'       => __( 'Search Portfolios item' , 'crum' ),
		'not_found'          => __( 'No products found' , 'crum' ),
		'not_found_in_trash' => __( 'No products found in the Trash' , 'crum' ),
		'parent_item_colon'  => '',
		'menu_name'          => 'Portfolios'
	);
	global $NHP_Options;

	$slug = $NHP_Options -> get("custom_portfolio_slug");
	if (isset($slug) && $slug){
		$args = array(
			'labels'        => $labels,
			'description'   => 'Holds our products and product specific data',
			'public'        => true,
			'supports'      => array( 'title', 'editor', 'author', 'thumbnail', 'tags', 'sticky' ),
			'has_archive'   => true,
			'menu_icon'     => 'dashicons-images-alt2', /* the icon for the custom post type menu */
			'taxonomies'    => array('post_tag'),
			'rewrite'       => array(
				'slug'      => $slug,
			)
		);
	}else{
		$args = array(
			'labels'        => $labels,
			'description'   => 'Holds our products and product specific data',
			'public'        => true,
			'supports'      => array( 'title', 'editor', 'author', 'thumbnail', 'tags', 'sticky' ),
			'has_archive'   => true,
			'menu_icon'     => 'dashicons-images-alt2', /* the icon for the custom post type menu */
			'taxonomies'    => array('post_tag')
		);
	}

	register_post_type( 'my-product', $args );
}
add_action( 'init', 'my_custom_post_product' );

function my_updated_messages( $messages ) {
	global $post, $post_ID;

	global $NHP_Options;

	$slug = $NHP_Options -> get("custom_portfolio_slug") ? $NHP_Options -> get("custom_portfolio_slug") : 'my-product';

	$messages[$slug] = array(
		0 => '',
		1 => sprintf( __('Portfolio updated. <a href="%s">View product</a>', 'crum'), esc_url( get_permalink($post_ID) ) ),
		2 => __('Custom field updated.', 'crum'),
		3 => __('Custom field deleted.', 'crum'),
		4 => __('Portfolio updated.', 'crum'),
		5 => isset($_GET['revision']) ? sprintf( __('Portfolio restored to revision from %s', 'crum'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
		6 => sprintf( __('Portfolio published. <a href="%s">View product</a>', 'crum'), esc_url( get_permalink($post_ID) ) ),
		7 => __('Portfolio saved.', 'crum'),
		8 => sprintf( __('Portfolio submitted. <a target="_blank" href="%s">Preview product</a>', 'crum'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
		9 => sprintf( __('Portfolio scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview product</a>', 'crum'), date_i18n( __( 'M j, Y @ G:i', 'crum' ), strtotime( $post->post_date ) ), esc_url( get_permalink($post_ID) ) ),
		10 => sprintf( __('Portfolio draft updated. <a target="_blank" href="%s">Preview product</a>', 'crum'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
	);
	return $messages;
}
add_filter( 'post_updated_messages', 'my_updated_messages' );

function my_contextual_help( $contextual_help, $screen_id, $screen ) {

	global $NHP_Options;

	$slug = $NHP_Options -> get("custom_portfolio_slug") ? $NHP_Options -> get("custom_portfolio_slug") : 'my-product';

	if ( $slug == $screen->id ) {

		$contextual_help = '<h2>Portfolios</h2>
		<p>Portfolios show the details of the items that we sell on the website. You can see a list of them on this page in reverse chronological order - the latest one we added is first.</p>
		<p>You can view/edit the details of each product by clicking on its name, or you can perform bulk actions using the dropdown menu and selecting multiple items.</p>';

	} elseif ( 'edit-product' == $screen->id ) {

		$contextual_help = '<h2>Editing products</h2>
		<p>This page allows you to view/modify product details. Please make sure to fill out the available boxes with the appropriate details (product image, price, brand) and <strong>not</strong> add these details to the product description.</p>';

	}
	return $contextual_help;
}
add_action( 'contextual_help', 'my_contextual_help', 10, 3 );

function my_taxonomies_product() {
	$labels = array(
		'name'              => __( 'Portfolio Categories', 'crum' ),
		'singular_name'     => __( 'Portfolio Category', 'crum' ),
		'search_items'      => __( 'Search Portfolio Categories', 'crum' ),
		'all_items'         => __( 'All Portfolio Categories', 'crum' ),
		'parent_item'       => __( 'Parent Portfolio Category', 'crum' ),
		'parent_item_colon' => __( 'Parent Portfolio Category:', 'crum' ),
		'edit_item'         => __( 'Edit Portfolio Category', 'crum' ),
		'update_item'       => __( 'Update Portfolio Category', 'crum' ),
		'add_new_item'      => __( 'Add New Portfolio Category', 'crum' ),
		'new_item_name'     => __( 'New Portfolio Category', 'crum' ),
		'menu_name'         => __( 'Portfolio Categories', 'crum' ),
	);

	global $NHP_Options;

	$slug = $NHP_Options -> get("custom_portfolio_slug");

	if (isset($slug) && $slug){
		$args = array(
			'labels' => $labels,
			'hierarchical' => true,
			'rewrite' => array(
				'slug' => $slug . '-category',
			),

		);
	}else{
		$args = array(
			'labels' => $labels,
			'hierarchical' => true,
		);
	}



	register_taxonomy( 'my-product_category', 'my-product', $args );
}
add_action( 'init', 'my_taxonomies_product', 0 );


/*
 * Testimonials taxonomy
 */

function crum_testimonials() {
	$labels = array(
		'name'               => __( 'Testimonials', 'crum' ),
		'singular_name'      => __( 'Testimonial', 'crum' ),
		'add_new_item'       => __( 'Add New Testimonial', 'crum' ),
		'edit_item'          => __( 'Edit Testimonial', 'crum' ),
		'new_item'           => __( 'New Testimonial', 'crum' ),
		'all_items'          => __( 'All Testimonials', 'crum' ),
		'view_item'          => __( 'View Testimonial', 'crum' ),
		'search_items'       => __( 'Search Testimonial', 'crum' ),
		'not_found'          => __( 'No testimonial found', 'crum' ),
		'not_found_in_trash' => __( 'No testimonial found in the Trash', 'crum' ),
		'parent_item_colon'  => '',
		'menu_name'          => 'Testimonials'
	);
	$args = array(
		'labels'        => $labels,
		'description'   => 'Holds our clients and partners testimonials',
		'public'        => true,
		'supports'      => array( 'title', 'editor', 'thumbnail' ),
		'menu_icon' => 'dashicons-testimonial', /* the icon for the custom post type menu */
		'has_archive'   => false
	);
	register_post_type( 'testimonial', $args );
}
add_action( 'init', 'crum_testimonials' );

/*
 * Clients taxonomy
 */

function crum_clients() {
	$labels = array(
		'name'               => __( 'Clients / Partners', 'crum' ),
		'singular_name'      => __( 'Client / Partner', 'crum' ),
		'add_new_item'       => __( 'Add New Client / Partner', 'crum' ),
		'edit_item'          => __( 'Edit Client / Partner', 'crum' ),
		'new_item'           => __( 'New Client / Partner', 'crum' ),
		'all_items'          => __( 'All Clients / Partners', 'crum' ),
		'view_item'          => __( 'View Client / Partner', 'crum' ),
		'search_items'       => __( 'Search Client / Partner', 'crum' ),
		'not_found'          => __( 'No Client / Partner found', 'crum' ),
		'not_found_in_trash' => __( 'No Client / Partner found in the Trash', 'crum' ),
		'parent_item_colon'  => '',
		'menu_name'          => 'Clients / Partners'
	);
	$args = array(
		'labels'        => $labels,
		'description'   => 'Holds our clients logotypes',
		'public'        => true,
		'supports'      => array( 'title', 'editor', 'thumbnail' ),
		'menu_icon' => 'dashicons-groups', /* the icon for the custom post type menu */
		'has_archive'   => false
	);
	register_post_type( 'clients', $args );
}
add_action( 'init', 'crum_clients' );

/*
 * Clients taxonomy
 */

function crum_features() {
	$labels = array(
		'name'               => __( 'Features', 'crum' ),
		'singular_name'      => __( 'Feature', 'crum' ),
		'add_new_item'       => __( 'Add New Feature', 'crum' ),
		'edit_item'          => __( 'Edit Feature', 'crum' ),
		'new_item'           => __( 'New Feature', 'crum' ),
		'all_items'          => __( 'All Features', 'crum' ),
		'view_item'          => __( 'View Feature', 'crum' ),
		'search_items'       => __( 'Search Feature', 'crum' ),
		'not_found'          => __( 'No Feature found', 'crum' ),
		'not_found_in_trash' => __( 'No Feature found in the Trash', 'crum' ),
		'parent_item_colon'  => '',
		'menu_name'          => 'Features blocks'
	);
	$args = array(
		'labels'        => $labels,
		'description'   => 'Features blocks',
		'public'        => true,
		'supports'      => array( 'title', 'editor', 'thumbnail' ),
		'menu_icon' => 'dashicons-list-view', /* the icon for the custom post type menu */
		'has_archive'   => false
	);
	register_post_type( 'features', $args );
}
add_action( 'init', 'crum_features' );

/*
 * Galleries
 */

function crum_galleries() {
	$labels = array(
		'name'               => __( 'Galleries', 'crum' ),
		'singular_name'      => __( 'Gallery', 'crum' ),
		'add_new_item'       => __( 'Add New Gallery', 'crum' ),
		'edit_item'          => __( 'Edit Gallery', 'crum' ),
		'new_item'           => __( 'New Gallery', 'crum' ),
		'all_items'          => __( 'All Galleries', 'crum' ),
		'view_item'          => __( 'View Gallery', 'crum' ),
		'search_items'       => __( 'Search Gallery', 'crum' ),
		'not_found'          => __( 'No Gallery found', 'crum' ),
		'not_found_in_trash' => __( 'No Gallery found in the Trash', 'crum' ),
		'parent_item_colon'  => '',
		'menu_name'          => 'Galleries'
	);
	$args = array(
		'labels'        => $labels,
		'description'   => 'Galleries',
		'public'        => true,
		'supports'      => array( 'title', 'editor', 'thumbnail' ),
		'menu_icon' => 'dashicons-format-gallery', /* the icon for the custom post type menu */
		'has_archive'   => false
	);
	register_post_type( 'galleries', $args );
}
add_action( 'init', 'crum_galleries' );


function crumina_mega_menu() {
	$labels = array(
		'name' => __('Mega menu', 'crum'),
		'singular_name' => __('Crumina Mega Menu', 'crum'),
		'add_new_item' => __('Add New Menu Item', 'crum'),
		'edit_item' => __('Edit Menu Item', 'crum'),
		'search_items' => __('Search Menu Items', 'crum'),
		'not_found' => __('Sorry: Menu Item Not Found', 'crum'),
		'not_found_in_trash' => __('Sorry: Menu Item Not Found In Trash', 'crum'),

	);
	$args = array(
		'labels'        => $labels,
		'rewrite' => false,
		'public' => true,
		'hierarchical' => 'false',
		'capability_type' => 'page',
		'supports' => array('title', 'editor'),
		'menu_icon' => 'dashicons-editor-kitchensink', /* the icon for the custom post type menu */
		'has_archive'   => false
	);
	register_post_type( 'crumina_mega_menu', $args );
}
add_action( 'init', 'crumina_mega_menu' );
