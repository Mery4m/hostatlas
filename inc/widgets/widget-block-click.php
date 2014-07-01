<?php

class crum_block_click_widget extends WP_Widget {

    public function __construct() {
        parent::__construct(
            'crum_block_click_widget', // Base ID
            'Theme: Clickable promo block', // Name
            array( 'description' => __( 'Promo block with link itself', 'crum' ), ) // Args
        );
    }


    public function widget( $args, $instance ) {
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

    /**
     * Sanitize widget form values as they are saved.
     */
    public function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['title'] = strip_tags( $new_instance['title'] );
        $instance['subtitle'] = strip_tags( $new_instance['subtitle'] );

        $instance['html'] = $new_instance['html'];
        $instance['link'] = $new_instance['link'];

        $instance['image_uri'] = esc_url($instance['image_uri']);
        $instance['image_uri_hov'] = esc_url($instance['image_uri_hov']);


        return $instance;
    }

    /**
     * Back-end widget form.
     */
    public function form( $instance ) {
        if ( isset( $instance[ 'title' ] ) ) {
            $title = $instance[ 'title' ];
        }
        if ( isset( $instance[ 'subtitle' ] ) ) {
            $subtitle = $instance[ 'subtitle' ];
        }
        if ( isset( $instance[ 'html' ] ) ) {
            $html = $instance[ 'html' ];
        }
        if ( isset( $instance[ 'link' ] ) ) {
            $link = $instance[ 'link' ];
        }
        if ( isset( $instance[ 'image_uri' ] ) ) {
            $image_uri = esc_url($instance['image_uri']);
        }
        if ( isset( $instance[ 'image_uri_hov' ] ) ) {
            $image_uri_hov = esc_url($instance['image_uri_hov']);
        }


        ?>
    <p>
        <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'crum' ); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
    </p>
    <p>
        <label for="<?php echo $this->get_field_id('subtitle'); ?>"><?php _e('Subtitle:'); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id('subtitle'); ?>" name="<?php echo $this->get_field_name('subtitle'); ?>" type="text" value="<?php echo esc_attr($subtitle); ?>"/>
    </p>
    <p>
        <label for="<?php echo $this->get_field_id( 'html' ); ?>"><?php _e( 'Text', 'crum' ); ?>:</label>
        <textarea  class="widefat" cols="40" rows="20" id="<?php echo $this->get_field_id( 'html' ); ?>" name="<?php echo $this->get_field_name( 'html' ); ?>"><?php echo esc_attr( $html ); ?></textarea>
    </p>

    <p>
        <label for="<?php echo $this->get_field_id( 'link' ); ?>"><?php _e( 'Link', 'crum' ); ?>:</label>
        <input class="widefat" id="<?php echo $this->get_field_id( 'link' ); ?>" name="<?php echo $this->get_field_name( 'link' ); ?>" type="text" value="<?php echo esc_attr( $link ); ?>" />
    </p>

    <p>
        <label for="<?php echo $this->get_field_id('image_uri'); ?>"><?php _e( 'Image', 'crum' ); ?></label><br />
        <input type="text" class="img" name="<?php echo $this->get_field_name('image_uri'); ?>" id="<?php echo $this->get_field_id('image_uri'); ?>" value="<?php echo $instance['image_uri']; ?>" />
        <input type="button" class="select-img" value="<?php _e( 'Select Image', 'crum' ); ?>" />
    </p>

    <p>
        <label for="<?php echo $this->get_field_id('image_uri_hov'); ?>"><?php _e( 'Hover image', 'crum' ); ?></label><br />
        <input type="text" class="img" name="<?php echo $this->get_field_name('image_uri_hov'); ?>" id="<?php echo $this->get_field_id('image_uri_hov'); ?>" value="<?php echo $instance['image_uri_hov']; ?>" />
        <input type="button" class="select-img" value="<?php _e( 'Select Image', 'crum' ); ?>" />
    </p>


    <?php
    }

}

function hrw_enqueue()
{
    wp_enqueue_style('thickbox');
    wp_enqueue_script('media-upload');
    wp_enqueue_script('thickbox');

    wp_enqueue_script('hrw', get_template_directory_uri() . '/assets/js/widget-image2.js', null, null, true);
};

add_action('admin_enqueue_scripts', 'hrw_enqueue');