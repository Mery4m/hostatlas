<?php
/**
 * Include and setup custom metaboxes and fields.
 *
 * @category YourThemeOrPlugin
 * @package  Metaboxes
 * @license  http://www.opensource.org/licenses/gpl-license.php GPL v2.0 (or later)
 * @link     https://github.com/jaredatch/Custom-Metaboxes-and-Fields-for-WordPress
 */

add_filter( 'cmb_meta_boxes', 'cmb_portfolio_metaboxes' );
/**
 * Define the metabox and field configurations.
 *
 * @param  array $meta_boxes
 * @return array
 */
function cmb_portfolio_metaboxes( array $meta_boxes ) {

	// Start with an underscore to hide fields from custom fields list

    $meta_boxes[] = array(
        'id'         => 'portfolio_params',
        'title'      => __('Select Portfolio parameters','crum'),
        'pages'      => array( 'page', ), // Post type
        'context'    => 'normal',
        'priority'   => 'high',
        'show_on' => array( 'key' => 'page-template', 'value' => array( 'portfolio-template-1.php', 'portfolio-masonry.php', 'portfolio-masonry-sidebar.php', 'tmp-portfolio-template-1.php', 'tmp-portfolio-template-2.php', 'tmp-portfolio-template-3.php', 'tmp-portfolio-template-4.php', 'tmp-portfolio-template-4-r.php', 'tmp-portfolio-d-template-4.php' ) ),
        'show_names' => true, // Show field names on the left
        'fields'     => array(
            array(
                'name' => 'Display  of certain category?',
                'desc' => 'Check, if you want to display items from a certain category',
                'id'   => 'folio_sort_category',
                'type' => 'checkbox'
            ),
            array(
                'name' => 'Portfolio Category',
                'desc'	=> 'Select portfolio items category',
                'id'	=> 'folio_category',
                'taxonomy' => 'my-product_category',
                'type' => 'taxonomy_multicheck',
            ),
            array (
                'name' => 'Number of items ot display',
                'desc'	=> '',
                'id'	=> 'folio_number_to_display',
                'type'	=> 'text'
            ),
        ),
    );


	// Add other metaboxes as needed

	return $meta_boxes;
}
