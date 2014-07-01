<?php

class crum_block_button_widget extends WP_Widget {

    public function __construct() {
        parent::__construct(
            'crum_block_button_widget', // Base ID
            'Theme: Text block + button', // Name
            array( 'description' => __( 'Text block with tiltle + desc + butt', 'crum' ), ) // Args
        );
    }


    public function widget( $args, $instance ) {
        extract( $args );
        $title = $instance['title'];
        $html = $instance['html'];
        $link = $instance['link'];
        $link_label = $instance['link_label'];

        echo $before_widget;


        echo '<div class="al-center info-butt">';
        echo '<h2>'.$title.'</h2>';
        echo '<p>'.$html.'</p>';
        echo '<a class="button" href="'.$link.'">'.$link_label.'</a>';
        echo '</div>';

        echo $after_widget;
    }

    /**
     * Sanitize widget form values as they are saved.
     */
    public function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['title'] = strip_tags( $new_instance['title'] );


        $instance['html'] = $new_instance['html'];
        $instance['link'] = $new_instance['link'];
        $instance['link_label'] = $new_instance['link_label'];

        return $instance;
    }

    /**
     * Back-end widget form.
     */
    public function form( $instance ) {
        if ( isset( $instance[ 'title' ] ) ) {
            $title = $instance[ 'title' ];
        }
        if ( isset( $instance[ 'html' ] ) ) {
            $html = $instance[ 'html' ];
        }
        if ( isset( $instance[ 'link' ] ) ) {
            $link = $instance[ 'link' ];
        }
        if ( isset( $instance[ 'link_label' ] ) ) {
            $link_label = $instance[ 'link_label' ];
        }

        ?>
    <p>
        <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'crum' ); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
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
        <label for="<?php echo $this->get_field_id( 'link_label' ); ?>"><?php _e( 'Link label', 'crum' ); ?>:</label>
        <input class="widefat" id="<?php echo $this->get_field_id( 'link_label' ); ?>" name="<?php echo $this->get_field_name( 'link_label' ); ?>" type="text" value="<?php echo esc_attr( $link_label ); ?>" />
    </p>


    <?php
    }

}