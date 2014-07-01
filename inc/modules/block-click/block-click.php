<?php

class crum_block_click_box extends WP_Widget {
    function __construct() {
        parent::__construct(
            'crum-block-click-box',
            __( 'Box: Clickable promo block', 'crum' ), // Name
            array( 'description' => __( 'Promo block with link itself', 'crum' ),
            )
        );
    }

    /**
     * @param array $args
     * @param array $instance
     */
    function widget( $args, $instance ) {
        extract( $args );
        $title = $instance['title'];
        $subtitle = $instance[ 'subtitle' ];
        $html = $instance['html'];
        $link = $instance['link'];

        $image_uri = esc_url($instance['image_uri']);
        $image_uri_hov = esc_url($instance['image_uri_hov']);

        echo $before_widget;

        ?>

    <div class="clickable info-item al-center">
        <div class="pic al-center">
            <img src="<?php echo $image_uri ?>" class="normal" alt="">
            <img src="<?php echo $image_uri_hov ?>" class="hovered" alt="">
        </div>

        <h6><?php echo $subtitle ?></h6>

        <h3><?php echo $title ?></h3>

        <p><?php echo $html ?></p>

        <a class="link" href="<?php echo $link ?>"></a>
    </div>

    <?php
        echo $after_widget;
    }


    function update($new, $old){
        $new = wp_parse_args($new, array(
            'title' => '',
            'subtitle' => '',
            'html' => '',
            'link' => '',
            'image_uri' => '',
            'image_uri_hov' => '',
        ));
        return $new;
    }

    function form( $instance ) {
        $instance = wp_parse_args($instance, array(
            'title' => '',
            'subtitle' => '',
            'html' => '',
            'link' => '',
            'image_uri' => '',
            'image_uri_hov' => '',
        ));

        ?>

    <p>
        <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'crum' ); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr($instance['title']) ?>" />
    </p>
    <p>
        <label for="<?php echo $this->get_field_id('subtitle'); ?>"><?php _e('Subtitle:', 'crum'); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id('subtitle'); ?>" name="<?php echo $this->get_field_name('subtitle'); ?>" type="text" value="<?php echo esc_attr($instance['subtitle']) ?>"/>
    </p>
    <p>
        <label for="<?php echo $this->get_field_id( 'html' ); ?>"><?php _e( 'Text', 'crum' ); ?>:</label>
        <textarea  class="widefat" cols="40" rows="20" id="<?php echo $this->get_field_id( 'html' ); ?>" name="<?php echo $this->get_field_name( 'html' ); ?>"><?php echo esc_attr($instance['html']) ?></textarea>
    </p>

    <p>
        <label for="<?php echo $this->get_field_id( 'link' ); ?>"><?php _e( 'Link', 'crum' ); ?>:</label>
        <input class="widefat" id="<?php echo $this->get_field_id( 'link' ); ?>" name="<?php echo $this->get_field_name( 'link' ); ?>" type="text" value="<?php echo esc_attr($instance['link']) ?>" />
    </p>

    <p>
        <label for="<?php echo $this->get_field_id('image_uri'); ?>"><?php _e( 'Image', 'crum' ); ?></label><br />
        <input type="text" class="img" name="<?php echo $this->get_field_name('image_uri'); ?>" id="<?php echo $this->get_field_id('image_uri'); ?>" value="<?php echo esc_url($instance['image_uri']) ?>" />
        <input type="button" class="select-img" value="<?php _e( 'Select Image', 'crum' ); ?>" />
    </p>

    <p>
        <label for="<?php echo $this->get_field_id('image_uri_hov'); ?>"><?php _e( 'Hover image', 'crum' ); ?></label><br />
        <input type="text" class="img" name="<?php echo $this->get_field_name('image_uri_hov'); ?>" id="<?php echo $this->get_field_id('image_uri_hov'); ?>" value="<?php echo esc_url($instance['image_uri_hov']) ?>" />
        <input type="button" class="select-img" value="<?php _e( 'Select Image', 'crum' ); ?>" />
    </p>

    <?php
    }
}


function hrw_enqueue()
{
        wp_enqueue_media();
        wp_enqueue_script('hrw', get_template_directory_uri() . '/assets/js/widget-image2.js', null, null, true);
};

add_action('admin_enqueue_scripts', 'hrw_enqueue');


add_action( 'widgets_init', create_function( '', 'register_widget("crum_block_click_box");' ) );