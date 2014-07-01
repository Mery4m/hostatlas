<?php
/**
 * Include and setup custom metaboxes and fields.
 *
 * @category YourThemeOrPlugin
 * @package  Metaboxes
 * @license  http://www.opensource.org/licenses/gpl-license.php GPL v2.0 (or later)
 * @link     https://github.com/jaredatch/Custom-Metaboxes-and-Fields-for-WordPress
 */

add_filter( 'cmb_meta_boxes', 'cmb_sample_metaboxes' );
/**
 * Define the metabox and field configurations.
 *
 * @param  array $meta_boxes
 * @return array
 */
function cmb_sample_metaboxes( array $meta_boxes ) {

	// Start with an underscore to hide fields from custom fields list
	$prefix = 'crum_page_custom_';

	$meta_boxes[] = array(
		'id'         => 'page_bg_metabox',
		'title'      => 'Boxed Page background options',
		'pages'      => array( 'page', ), // Post type
		'context'    => 'normal',
		'priority'   => 'high',
		'show_names' => true, // Show field names on the left
		'fields'     => array(
			array(
	            'name' => 'Background color',
	            'desc' => 'Color of body of page (page will be set to boxed)',
	            'id'   => $prefix . 'bg_color',
	            'type' => 'colorpicker',
				'std'  => '#ffffff'
	        ),
            array(
                'name' => 'Fixed backrgound',
                'desc' => 'Check if you want to bg will be fixed on page scroll',
                'id'   => $prefix . 'bg_fixed',
                'type' => 'checkbox',
            ),
			array(
				'name' => 'Background image',
				'desc' => 'Upload an image or enter an URL.',
				'id'   => $prefix . 'bg_image',
				'type' => 'file',
			),
            array(
                'name'    => 'Background image repeat',
                'desc'    => '',
                'id'      => $prefix . 'bg_repeat',
                'type'    => 'select',
                'options' => array(
                    array( 'name' => 'Repeat All', 'value' => 'repeat', ),
                    array( 'name' => 'Repeat Horizontally', 'value' => 'repeat-x', ),
                    array( 'name' => 'Repeat Vertically', 'value' => 'repeat-y', ),
                    array( 'name' => 'No-repeat', 'value' => 'no-repeat', ),
                ),
            ),
		),
	);


    $meta_boxes[] = array(
        'id'         => 'blog_params',
        'title'      => __('Select Blog parameters','crum'),
        'pages'      => array( 'page', ), // Post type
        'context'    => 'normal',
        'priority'   => 'high',
        'show_on' => array( 'key' => 'page-template', 'value' => array( 'tmp-posts.php', 'posts-sidebar-sel.php', 'tmp-archive-left-img.php', 'tmp-archive-right-img.php', 'tmp-page-masonry-2-side.php', 'tmp-page-masonry-2.php', 'page-masonry.php' ) ),
        'show_names' => true, // Show field names on the left
        'fields'     => array(
            array(
                'name' => 'Display posts of certain category?',
                'desc' => 'Check, if you want to display posts from a certain category',
                'id'   => 'blog_sort_category',
                'type' => 'checkbox'
            ),
            array(
                'name' => 'Blog Category',
                'desc'	=> 'Select blog category',
                'id'	=> 'blog_category',
                'taxonomy' => 'category',
                'type' => 'taxonomy_multicheck',
            ),
            array (
                'name' => 'Number of posts ot display',
                'desc'	=> '',
                'id'	=> 'blog_number_to_display',
                'type'	=> 'text'
            ),
        ),
    );


	// Add other metaboxes as needed

	return $meta_boxes;
}
