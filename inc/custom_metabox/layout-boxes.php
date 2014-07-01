<?php


add_filter( 'cmb_meta_boxes', 'crum_portfolio_metaboxes' );
/**
 * Define the metabox and field configurations.
 *
 * @param  array $meta_boxes
 *
 * @return array
 */

function crum_portfolio_metaboxes( array $meta_boxes ) {
	$meta_boxes[] = array(
		'id'         => 'page_layout_params',
		'title'      => __( 'Select Layout parameters', 'crum' ),
		'pages'      => array( 'page' ), // Post type
		'context'    => 'normal',
		'priority'   => 'high',
		'show_names' => true, // Show field names on the left
		'show_on'    => array( 'key' => 'page-template', 'value' => 'posts-sidebar-sel.php'),
		'fields'     => array(
			array(
				'name'    => __( 'Select page layout', 'crum' ),
				'desc'    => __( 'You can select layout for current page', 'crum' ),
				'id'      => '_page_layout_select',
				'type'    => 'radio_inline',
				'options' => array(
					array( 'name' => 'Default', 'value' => '', ),
					array( 'name' => 'No sidebars', 'value' => '1col-fixed', ),
					array( 'name' => 'Sidebar on left', 'value' => '2c-l-fixed', ),
					array( 'name' => 'Sidebar on right', 'value' => '2c-r-fixed', ),
					array( 'name' => '2 left sidebars', 'value' => '3c-l-fixed', ),
					array( 'name' => '2 right sidebars', 'value' => '3c-r-fixed', ),
					array( 'name' => 'Sidebar on either side', 'value' => '3c-fixed', ),
				),
			),
		),
	);


	return $meta_boxes;
}