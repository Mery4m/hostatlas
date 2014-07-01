<?php

class crum_tags_widget extends WP_Widget {

	function crum_tags_widget(  ) {

		/* Widget settings. */

		$widget_ops = array( 'classname' => 'tags-widget', 'description' => __( 'Tags block with subtitle','crum') );

		/* Widget control settings. */

		$control_ops = array( 'id_base' => 'crum_tags_widget' );

		/* Create the widget. */

		$this->WP_Widget( 'crum_tags_widget', 'Theme: Tags block with subtitle', $widget_ops, $control_ops );

	}

	function widget( $args, $instance ) {

		//get theme options

        if ( isset( $instance[ 'title' ] ) ) {

            $title = $instance[ 'title' ];

        } else {

            $title = __( 'Text block', 'roots' );

        }
        if ( isset( $instance[ 'subtitle' ] ) ) {

            $subtitle = $instance[ 'subtitle' ];
        }
        if ( isset( $instance[ 'number' ] ) ) {

            $number = $instance[ 'number' ];
        }

		extract( $args );

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
<div class="clearing-container">

        <?php

            wp_tag_cloud('smallest=10&largest=10&number='.$number. '');

        ?>
</div>

    <?php echo $after_widget;
    }

	function update( $new_instance, $old_instance ) {

		$instance = $old_instance;

        $instance['title'] = strip_tags( $new_instance['title'] );

        $instance['subtitle'] = strip_tags( $new_instance['subtitle'] );

        $instance['number'] = strip_tags( $new_instance['number'] );

		return $instance;

	}

	function form( $instance ) {

        $title = apply_filters( 'widget_title', $instance['title'] );

        $subtitle = $instance['subtitle'];

        $number = $instance['number'];
		/* Set up some default widget settings. */

		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

    <p>
      <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:','crum'); ?></label>
      <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>"/>
    </p>
    <p>
      <label for="<?php echo $this->get_field_id('subtitle'); ?>"><?php _e('Subtitle:','crum'); ?></label>
      <input class="widefat" id="<?php echo $this->get_field_id('subtitle'); ?>" name="<?php echo $this->get_field_name('subtitle'); ?>" type="text" value="<?php echo esc_attr($subtitle); ?>"/>
    </p>
    <p>
        <label for="<?php echo $this->get_field_id('number'); ?>"><?php _e('Number tags:','crum'); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="text" value="<?php echo esc_attr($number); ?>"/>
    </p>

        <?php

	}

}