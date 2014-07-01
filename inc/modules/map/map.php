<?php

class crum_map_widget extends WP_Widget {

    function crum_map_widget() {

        /* Widget settings. */

        $widget_ops = array( 'classname' => 'shortcode-widget', 'description' => __( 'Google map','crum') );

        /* Widget control settings. */

        $control_ops = array( 'id_base' => 'crum_map_widget' );

        /* Create the widget. */

        $this->WP_Widget( 'crum_shortcode_widget', 'Box: Google Map', $widget_ops, $control_ops );

    }

    function widget( $args, $instance ) {

        //get theme options

        if ( isset( $instance[ 'title' ] ) ) {

            $title = $instance[ 'title' ];

        } else {

            $title = __( 'Some shortcode', 'crum' );

        }
        if ( isset( $instance[ 'subtitle' ] ) ) {

            $subtitle = $instance[ 'subtitle' ];
        }

        extract( $args );

        $text = stripcslashes($instance['text']);

        $height = $instance['height'];

        $fullwidth = $instance['fullwidth'];


        /* show the widget content without any headers or wrappers */

        echo $before_widget;

        if ($title) {

            if ( $subtitle ) {
                echo '<div class="subtitle">';
                echo $subtitle;
                echo '</div>';
            }

            echo $before_title;
            echo $title;
            echo $after_title;

        } ?>


 <script type="text/javascript" src="https://maps.google.com/maps/api/js?sensor=false"></script>

     <?php if ($fullwidth) {
            echo'</div></div></div></section></div></div>';
        } ?>

        <div id="map-<?php echo $args['widget_id']; ?>" style="height: <?php echo $height; ?>px;"></div>

        <script type="text/javascript">
            jQuery(document).ready(function () {
                jQuery("#map-<?php echo $args['widget_id']; ?>").gmap3({

                    marker: {
                        address: "<?php echo $text; ?>"
                    },
                    map: {
                        options: {
                            zoom: 14,
                            navigationControl: true,
                            scrollwheel: false,
                            streetViewControl: true
                        }
                    }
                });
            });
        </script>

    <?php if ($fullwidth) {
           /* echo'<div class="row"><div><div><section><div><div>';*/
        } ?>




        <?php
        echo $after_widget;

    }

    function update( $new_instance, $old_instance ) {

        $instance = $old_instance;

        $instance['title'] = strip_tags( $new_instance['title'] );

        $instance['subtitle'] = strip_tags( $new_instance['subtitle'] );

        $instance['text'] = $new_instance['text'];

        $instance['height'] = $new_instance['height'];

        $instance['fullwidth'] = $new_instance['fullwidth'];


        return $instance;

    }

    function form( $instance ) {

        $title = apply_filters( 'widget_title', $instance['title'] );

        $subtitle = $instance['subtitle'];

        /* Set up some default widget settings. */

        $defaults = array( 'text' => '', 'height' => '350' );

        $instance = wp_parse_args( (array) $instance, $defaults ); ?>


    <p>
        <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'crum'); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>"/>
    </p>
    <p>
        <label for="<?php echo $this->get_field_id('subtitle'); ?>"><?php _e('Subtitle:', 'crum'); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id('subtitle'); ?>" name="<?php echo $this->get_field_name('subtitle'); ?>" type="text" value="<?php echo esc_attr($subtitle); ?>"/>
    </p>

    <p>
        <label for="<?php echo $this->get_field_id('text'); ?>"><?php _e('Address', 'crum'); ?></label><br/>
        <input class="widefat" id="<?php echo $this->get_field_id('text'); ?>" name="<?php echo $this->get_field_name('text'); ?>" type="text" value="<?php echo stripcslashes($instance['text']); ?>"/>
    </p>
    <p>
        <label for="<?php echo $this->get_field_id('height'); ?>"><?php _e('Height (in px)', 'crum'); ?></label><br/>
        <input class="widefat" id="<?php echo $this->get_field_id('height'); ?>" name="<?php echo $this->get_field_name('height'); ?>" type="text" value="<?php echo $instance['height']; ?>"/>
    </p>

    <p>
        <label for="<?php echo $this->get_field_id('fullwidth'); ?>"><?php _e('Full width?', 'crum'); ?></label><br/>
        <input id="<?php echo $this->get_field_id('fullwidth'); ?>" name="<?php echo $this->get_field_name('fullwidth'); ?>" type="checkbox" <?php checked(isset($instance['fullwidth']) ? $instance['fullwidth'] : 0); ?> />
    </p>


    <?php

    }

}

add_action( 'widgets_init', create_function( '', 'register_widget("crum_map_widget");' ) );

