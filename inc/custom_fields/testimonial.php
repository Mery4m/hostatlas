<?php

// Add the Meta Box
function testimonial_custom_fields() {
    add_meta_box(
        'testimonial_custom_fields', // $id
        'Testimonial info', // $title
        'show_testimonial_custom_fields', // $callback
        'testimonial', // $page
        'normal', // $context
        'high'); // $priority
}

add_action('add_meta_boxes', 'testimonial_custom_fields');

// Field Array
$prefix = 'testimonial_custom_';
$testimonial_meta_custom_fields = array(
    array(
        'label' => 'Author of testimonial',
        'desc'	=> '',
        'id'	=> 'crum_testimonial_autor',
        'type'	=> 'text'
    ),
    array(
        'label' => 'Author additional',
        'desc'	=> '',
        'id'	=> 'crum_testimonial_additional',
        'type'	=> 'text'
    )

);


function show_testimonial_custom_fields() {
    global $testimonial_meta_custom_fields, $post;
    CF_print_metabox( $testimonial_meta_custom_fields, $post, basename(__FILE__) );
}

// Save the Data
function save_testimonial_custom_meta($post_id) {
    global $testimonial_meta_custom_fields;
    CF_save_metabox( $testimonial_meta_custom_fields, $post_id, basename(__FILE__) );
}
add_action('save_post', 'save_testimonial_custom_meta');