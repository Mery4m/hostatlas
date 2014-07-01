<?php

// Add the Meta Box
function post_audio_custom_fields() {
    add_meta_box(
        'post_audio_custom_fields', // $id
        'Post Format audio fields', // $title
        'show_post_audio_custom_fields', // $callback
        'post', // $page
        'normal', // $context
        'high'); // $priority
}
add_action('add_meta_boxes', 'post_audio_custom_fields');

// Field Array
$prefix = 'post_custom_';
$post_audio_meta_custom_fields = array(
    array(
        'label' => 'Audio file link',
        'desc'	=> '',
        'id'	=> 'audio_link',
        'type'	=> 'text'
    ),
);

function show_post_audio_custom_fields() {
    global $post_audio_meta_custom_fields, $post;
    CF_print_metabox( $post_audio_meta_custom_fields, $post, basename(__FILE__) );
}