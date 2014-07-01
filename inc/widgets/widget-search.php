<?php

class crum_search_widget extends WP_Widget {

	function crum_search_widget() {

		/* Widget settings. */

		$widget_ops = array( 'classname' => 'search-widget', 'description' => __( 'Search widget with subtitle','crum') );

		/* Widget control settings. */

		$control_ops = array( 'id_base' => 'crum_search_widget' );

		/* Create the widget. */

		$this->WP_Widget( 'crum_search_widget', 'Cr: Search widget', $widget_ops, $control_ops );

	}

	function widget( $args, $instance ) {

		//get theme options

        if ( isset( $instance[ 'title' ] ) ) {

            $title = $instance[ 'title' ];

        }
        if ( isset( $instance[ 'subtitle' ] ) ) {

            $subtitle = $instance[ 'subtitle' ];
        }
        if ( isset( $instance[ 'text' ] ) ) {

            $text = $instance[ 'text' ];
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

    <form role="search" method="get" id="searchform" class="form-search" action="<?php echo home_url('/'); ?>">
        <label class="hide" for="s"><?php _e('Search for:', 'crum'); ?></label>
        <input type="text" value="" name="s" id="s" class="s-field" placeholder="<?php echo $text; ?>">
        <input type="submit" id="searchsubmit" value=" " class="s-submit">
    </form>

    <?php echo $after_widget;

	}

	function update( $new_instance, $old_instance ) {

		$instance = $old_instance;

        $instance['title'] = strip_tags( $new_instance['title'] );

        $instance['subtitle'] = strip_tags( $new_instance['subtitle'] );

		/* Strip tags (if needed) and update the widget settings. */

		$instance['text'] = strip_tags( $new_instance['text'] );


		return $instance;

	}

	function form( $instance ) {

        $title = apply_filters( 'widget_title', $instance['title'] );

        $subtitle = $instance['subtitle'];

        $text = $instance['text'];

		/* Set up some default widget settings. */

		$defaults = array( 'text' => 'Enter request...' );

		$instance = wp_parse_args( (array) $instance, $defaults ); ?>


    <p>
        <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'crum' ); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
    </p>
    <p>
        <label for="<?php echo $this->get_field_id( 'subtitle' ); ?>"><?php _e( 'Subtitle:', 'crum' ); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id( 'subtitle' ); ?>" name="<?php echo $this->get_field_name( 'subtitle' ); ?>" type="text" value="<?php echo esc_attr( $subtitle ); ?>" />
    </p>

    <p>
      <label for="<?php echo $this->get_field_id('text'); ?>"><?php _e('Placeholder', 'crum'); ?></label><br/>
      <input class="widefat" id="<?php echo $this->get_field_id('text'); ?>" name="<?php echo $this->get_field_name('text'); ?>" type="text" value="<?php echo esc_attr($text); ?>"/>
    </p>

        <?php

	}

}