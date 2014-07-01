<?php

//UNWRAPPED TEXT

class crum_unwrapped extends WP_Widget {

	function crum_unwrapped() {

		/* Widget settings. */

		$widget_ops = array( 'classname' => 'Theme:Unwrapped Text', 'description' => __( 'Displays arbritrary text of HTML just like the standard Text widget, but this one does not include the header bar and wrapper style - just a blank canvas for content','theory') );

		/* Widget control settings. */

		$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'crum_unwrapped' );

		/* Create the widget. */

		$this->WP_Widget( 'crum_unwrapped', 'Theme:Unwrapped Text', $widget_ops, $control_ops );

	}

	function widget( $args, $instance ) {

		//get theme options

		global $crum_front, $crum_layout, $crum_feed, $crum_reviews, $crum_ads, $crum_misc, $crumPostTypes;



		extract( $args );

		$text = $instance['text'];



		/* show the widget content without any headers or wrappers */

    echo $before_widget;

		echo '<div class="unwrapped">'.$text.'</div>';

    echo $after_widget;

	}

	function update( $new_instance, $old_instance ) {

		$instance = $old_instance;



		/* Strip tags (if needed) and update the widget settings. */

		$instance['text'] = $new_instance['text'];



		return $instance;

	}

	function form( $instance ) {



		/* Set up some default widget settings. */

		$defaults = array( 'text' => '' );

		$instance = wp_parse_args( (array) $instance, $defaults ); ?>



        <p>

			<label for="<?php echo $this->get_field_id( 'text' ); ?>"><?php _e( 'Text/HTML','theory'); ?></label><br />

            <textarea rows="20" cols="75" id="<?php echo $this->get_field_id( 'text' ); ?>" name="<?php echo $this->get_field_name( 'text' ); ?>"><?php echo $instance['text']; ?></textarea>

		</p>



        <?php

	}

}

?>

