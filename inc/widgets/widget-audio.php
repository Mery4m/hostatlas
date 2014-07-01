<?php

class crum_widgets_audio extends WP_Widget {

    /**
     * Register widget with WordPress.
     */
    public function __construct() {
        parent::__construct(
            'crum_widgets_audio', // Base ID
            'Cr: oEmbed Audio', // Name
            array(
                'description'	=> __( 'Include audio with oEmbed', 'crum' )
            ) // Args
        );
    }

    /**
     * Helper function that holds widget fields
     * Array is used in update and form functions
     */
    private function widget_fields() {
        $fields = array(
            // Title
            'widget_title' => array(
                'ts_widgets_name'			=> 'widget_title',
                'ts_widgets_title'			=> __( 'Title:', 'crum' ),
                'ts_widgets_field_type'		=> 'text'
            ),
            'subtitle' => array(
                'ts_widgets_name'			=> 'subtitle',
                'ts_widgets_title'			=> __( 'Subtitle:', 'crum' ),
                'ts_widgets_field_type'		=> 'text'
            ),

            // Other fields
            'embed_url' => array (
                'ts_widgets_name'			=> 'embed_url',
                'ts_widgets_title'			=> __( 'Embed URL', 'crum' ),
                'ts_widgets_field_type'		=> 'text'
            ),
            'embed_width' => array (
                'ts_widgets_name'			=> 'embed_width',
                'ts_widgets_title'			=> __( 'Embed width in pixels', 'crum' ),
                'ts_widgets_field_type'		=> 'number'
            ),
            'embed_description' => array (
                'ts_widgets_name'			=> 'embed_description',
                'ts_widgets_title'			=> __( 'Description', 'crum' ),
                'ts_widgets_field_type'		=> 'textarea',
                'ts_widgets_allowed_tags'		=> '<strong>'
            ),
        );

        return $fields;
    }


    /**
     * Front-end display of widget.
     *
     * @see WP_Widget::widget()
     *
     * @param array $args     Widget arguments.
     * @param array $instance Saved values from database.
     */
    public function widget( $args, $instance ) {
        extract( $args );

        $title		= apply_filters( 'title', $instance['title'] );
        $subtitle		= apply_filters( 'subtitle', $instance['subtitle'] );
        $embed_url 			= $instance['embed_url'];
        $embed_width		= $instance['embed_width'];
        $embed_description	= $instance['embed_description'];

        echo $before_widget; ?>


        <?php
        // Show title
        if ($title) {

            if ( $subtitle ) {
                echo '<div class="subtitle">';
                echo $subtitle;
                echo '</div>';
            }

            echo $before_title;
            echo $title;
            echo $after_title;

        }
        ?>
    <div class="widget-oembed">
        <?php
        // Check if embed URL is entered
        if( isset( $embed_url ) ) {
            // Check if user entered embed width
            if( isset( $embed_width ) && $embed_width > 0 ) {
                echo wp_oembed_get( $embed_url, array( 'width' => $embed_width ) );
            } else {
                echo wp_oembed_get( $embed_url );
            }
        } // end if embed URL

        if( isset( $embed_description ) ) {
            echo '<div class="oembed-description">' . $embed_description . '</div>';
        } // end if embed description
        ?>
    </div><!-- .ts-widgets-oembed -->

    <?php
        echo $after_widget;
    }

    /**
     * Sanitize widget form values as they are saved.
     *
     * @see WP_Widget::update()
     *
     * @param	array	$new_instance	Values just sent to be saved.
     * @param	array	$old_instance	Previously saved values from database.
     *
     * @uses	ts_widgets_show_widget_field()		defined in ts-widgets-fields.php
     *
     * @return	array Updated safe values to be saved.
     */
    function update($new, $old)
    {
        $new = wp_parse_args($new, array(
            'title'   => '',
            'subtitle'      => '',
            'embed_url'         => '',
            'embed_width'      => '',
            'embed_description' => '',
        ));
        return $new;
    }

    /**
     * Back-end widget form.
     *
     * @see WP_Widget::form()
     *
     * @param array $instance Previously saved values from database.
     *
     * @uses	ts_widgets_show_widget_field()		defined in ts-widgets-fields.php
     */
    public function form( $instance ) {

        $instance = wp_parse_args($instance, array(
            'title'   => '',
            'subtitle'      => '',
            'embed_url'         => '',
            'embed_width'      => '',
            'embed_description' => '',
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
        <label for="<?php echo $this->get_field_id( 'embed_url' ); ?>"><?php _e( 'Embed URL:', 'crum' ); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id( 'embed_url' ); ?>" name="<?php echo $this->get_field_name( 'embed_url' ); ?>" type="text" value="<?php echo esc_attr($instance['embed_url']) ?>" />
    </p>
    <p>
        <label for="<?php echo $this->get_field_id('embed_width'); ?>"><?php _e('Embed width:', 'crum'); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id('embed_width'); ?>" name="<?php echo $this->get_field_name('embed_width'); ?>" type="text" value="<?php echo esc_attr($instance['embed_width']) ?>"/>
    </p>
    <p>
        <label for="<?php echo $this->get_field_id('embed_description'); ?>"><?php _e('Embed Description:', 'crum'); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id('embed_description'); ?>" name="<?php echo $this->get_field_name('embed_description'); ?>" type="text" value="<?php echo esc_attr($instance['embed_description']) ?>"/>
    </p>





    <?php

    }

} // class Foo_Widget