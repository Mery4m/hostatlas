<?php

class crum_shortcode_widget extends WP_Widget {

	function crum_shortcode_widget() {

		/* Widget settings. */

		$widget_ops = array( 'classname' => 'shortcode-widget', 'description' => __( 'Any shortcode can be added here','crum') );

		/* Widget control settings. */

		$control_ops = array( 'id_base' => 'crum_shortcode_widget' );

		/* Create the widget. */

		$this->WP_Widget( 'crum_shortcode_widget', 'Theme: do Shortcode', $widget_ops, $control_ops );

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



		/* show the widget content without any headers or wrappers */

        echo $before_widget;

        if ($title) {

            echo '<div class="title">';
            if ( $subtitle ) {
                echo '<div class="subtitle">';
                echo $subtitle;
                echo '</div>';
            }

            echo $before_title;
            echo $title;
            echo $after_title;

            echo'</div>';

        }

        echo do_shortcode(''.$text.'');

        echo $after_widget;

	}

	function update( $new_instance, $old_instance ) {

		$instance = $old_instance;

        $instance['title'] = strip_tags( $new_instance['title'] );

        $instance['subtitle'] = strip_tags( $new_instance['subtitle'] );

		$instance['text'] = $new_instance['text'];


		return $instance;

	}

	function form( $instance ) {

        $title = apply_filters( 'widget_title', $instance['title'] );

        $subtitle = $instance['subtitle'];

		/* Set up some default widget settings. */

		$defaults = array( 'text' => '' );

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
      <label for="<?php echo $this->get_field_id('text'); ?>"><?php _e('Shortcode', 'crum'); ?></label><br/>
      <textarea class="widefat" rows="10" id="<?php echo $this->get_field_id('text'); ?>" name="<?php echo $this->get_field_name('text'); ?>"><?php echo stripcslashes($instance['text']); ?></textarea>
    </p>


        <?php

	}

}