<?php


if (get_post_meta($post->ID, 'post_custom_post_audio_url', true)){ ?>

    <audio src="<?php echo get_post_meta($post->ID, 'post_custom_post_audio_url', true); ?>" preload="auto" />

<?php
}


wp_enqueue_style('js_audio', get_template_directory_uri() . '/assets/css/audioplayer.css', false, null);

wp_register_script('js-audio', ''.get_template_directory_uri().'/assets/js/audioplayer.min.js', false, null, false);
wp_enqueue_script('js-audio');

?>



<script>jQuery( function() { jQuery( 'audio' ).audioPlayer(); } );</script>