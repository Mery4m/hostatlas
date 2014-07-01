<?php

class crum_text_subtitle extends WP_Widget {

	function crum_text_subtitle() {

		/* Widget settings. */

		$widget_ops = array( 'classname' => 'text-widget', 'description' => __( 'Text block with subtitle','crum') );

		/* Widget control settings. */

		$control_ops = array( 'width' => 800, 'height' => 350, 'id_base' => 'crum_text_subtitle' );

		/* Create the widget. */

		$this->WP_Widget( 'crum_text_subtitle', 'Cr:Text block with subtitle', $widget_ops, $control_ops );

	}

	function widget( $args, $instance ) {

		//get theme options

        if ( isset( $instance[ 'title' ] ) ) {

            $title = $instance[ 'title' ];

        } else {

            $title = __( 'Text block', 'crum' );

        }
        if ( isset( $instance[ 'subtitle' ] ) ) {

            $subtitle = $instance[ 'subtitle' ];
        }


        if ( get_option('embed_autourls') ) {
            $wp_embed = $GLOBALS['wp_embed'];
            add_filter( 'widget_text', array( $wp_embed, 'run_shortcode' ), 8 );
            add_filter( 'widget_text', array( $wp_embed, 'autoembed' ), 8 );
        }
        extract( $args );

        $text = apply_filters( 'widget_text', $instance['text'], $instance );
        $text = do_shortcode( $text );



		/* show the widget content without any headers or wrappers */

        echo $before_widget;

        if ( $subtitle ) {
            echo '<div class="subtitle">';
            echo $subtitle;
            echo '</div>';
        }

        if ( ! empty( $title ) )

            echo $before_title . $title . $after_title; ?>

        <div class="unwrapped"><?php echo $text; ?></div>

    <?php echo $after_widget;

	}

	function update( $new_instance, $old_instance ) {

		$instance = $old_instance;

        $instance['title'] = strip_tags( $new_instance['title'] );

        $instance['subtitle'] = strip_tags( $new_instance['subtitle'] );

		/* Strip tags (if needed) and update the widget settings. */

        if ( current_user_can('unfiltered_html') )
            $instance['text'] =  $new_instance['text'];
        else
            $instance['text'] = stripslashes( wp_filter_post_kses( addslashes($new_instance['text']) ) ); // wp_filter_post_kses() expects slashed
            $instance['type'] = strip_tags($new_instance['type']);



		return $instance;

	}

	function form( $instance ) {

        $subtitle = $instance['subtitle'];

		/* Set up some default widget settings. */

        $instance = wp_parse_args( (array) $instance, array( 'title' => '', 'text' => '', 'type' => 'visual' ) );
        $title = strip_tags($instance['title']);
        if (function_exists('esc_textarea')) {
            $text = esc_textarea($instance['text']);
        }
        else {
            $text = stripslashes( wp_filter_post_kses( addslashes( $instance['text'] ) ) );
        }
        $type = esc_attr($instance['type']);

         $toggle_buttons_extra_class = "wp-toggle-buttons";
         $media_buttons_extra_class = "wp-media-buttons";


		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

    <input id="<?php echo $this->get_field_id('type'); ?>" name="<?php echo $this->get_field_name('type'); ?>" type="hidden" value="<?php echo esc_attr($type); ?>" />
    <p>
      <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'crum'); ?></label>
      <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>"/>
    </p>
    <p>
      <label for="<?php echo $this->get_field_id('subtitle'); ?>"><?php _e('Subtitle:', 'crum'); ?></label>
      <input class="widefat" id="<?php echo $this->get_field_id('subtitle'); ?>" name="<?php echo $this->get_field_name('subtitle'); ?>" type="text" value="<?php echo esc_attr($subtitle); ?>"/>
    </p>

    <div class="editor_toggle_buttons hide-if-no-js <?php echo $toggle_buttons_extra_class; ?>">
        <a id="widget-<?php echo $this->id_base; ?>-<?php echo $this->number; ?>-html"<?php if ($type == 'html') {?> class="active"<?php }?>><?php _e('HTML'); ?></a>
        <a id="widget-<?php echo $this->id_base; ?>-<?php echo $this->number; ?>-visual"<?php if($type == 'visual') {?> class="active"<?php }?>><?php _e('Visual'); ?></a>
    </div>
    <div class="editor_media_buttons hide-if-no-js <?php echo $media_buttons_extra_class; ?>">
        <?php do_action( 'media_buttons' ); ?>
    </div>
    <div class="editor_container">
        <textarea class="widefat" rows="20" cols="40" id="<?php echo $this->get_field_id('text'); ?>" name="<?php echo $this->get_field_name('text'); ?>"><?php echo $text; ?></textarea>
    </div>



        <?php

	}

}


/* Add actions and filters (only in widgets admin page) */
add_action('admin_init', 'black_studio_tinymce_admin_init');

function black_studio_tinymce_admin_init() {
    global $pagenow;
    $load_editor = false;
    if ($pagenow == "widgets.php") {
        $load_editor = true;
    }
    // Compatibility for WP Page Widget plugin
    if ( $pagenow == "post-new.php" ||  $pagenow == "post.php" ) {
        $load_editor = true;
    }
    if ($load_editor) {
        add_action( 'admin_head', 'black_studio_tinymce_load_tiny_mce');
        add_filter( 'tiny_mce_before_init', 'black_studio_tinymce_init_editor', 20);
        add_action( 'admin_print_scripts', 'black_studio_tinymce_scripts');
        add_action( 'admin_print_styles', 'black_studio_tinymce_styles');
        add_action( 'admin_print_footer_scripts', 'black_studio_tinymce_footer_scripts');
    }
}

/* Instantiate tinyMCE editor */
function black_studio_tinymce_load_tiny_mce() {
        wp_enqueue_media();
}

/* TinyMCE setup customization */
function black_studio_tinymce_init_editor($initArray) {
    // Remove the "More" toolbar button
    $initArray['theme_advanced_buttons1'] = str_replace(',wp_more', '', $initArray['theme_advanced_buttons1']);
    // Do not remove linebreaks
    $initArray['remove_linebreaks'] = false;
    // Convert newline characters to BR tags
    $initArray['convert_newlines_to_brs'] = false;
    // Force P newlines
    $initArray['force_p_newlines'] = true;
    // Force P newlines
    $initArray['force_br_newlines'] = false;
    // Do not remove redundant BR tags
    $initArray['remove_redundant_brs'] = false;
    // Force p block
    $initArray['forced_root_block'] = 'p';
    // Apply source formatting
    $initArray['apply_source_formatting '] = true;
    // Return modified settings
    return $initArray;
}

/* Widget js loading */
function black_studio_tinymce_scripts() {

    wp_enqueue_script('media-upload');
    wp_enqueue_script('crum-tinymce-widget-legacy', get_template_directory() .'/assets/js/widget-tinymce.js', array('jquery'));

}

/* Widget css loading */
function black_studio_tinymce_styles() {

    wp_enqueue_style('wp-jquery-ui-dialog');
    wp_print_styles('editor-buttons');


    wp_enqueue_style('crum-tinymce-widget', get_template_directory() .'/assets/css/widget-tinymce.css');
}


/* Footer script */
function black_studio_tinymce_footer_scripts() {
        wp_editor('', 'widget-crum_text_subtitle-2-text');
}

/* Hack needed to enable full media options when adding content form media library */
/* (this is done excluding post_id parameter in Thickbox iframe url) */
add_filter('_upload_iframe_src', 'black_studio_tinymce_upload_iframe_src');

function black_studio_tinymce_upload_iframe_src ($upload_iframe_src) {
    global $pagenow;
    if ($pagenow == "widgets.php" || ($pagenow == "admin-ajax.php" && isset ($_POST['id_base']) && $_POST['id_base'] == "crum_text_subtitle") ) {
        $upload_iframe_src = str_replace('post_id=0', '', $upload_iframe_src);
    }
    return $upload_iframe_src;
}