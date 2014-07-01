<?php

class crum_list_widget extends WP_Widget {

    public function __construct() {
        parent::__construct(
            'list_widget', // Base ID
            'Theme: Styled list widget', // Name
            array( 'description' => __( 'List of ', 'crum' ), ) // Args
        );
    }


    public function widget( $args, $instance ) {
        extract( $args );
        $title = apply_filters( 'widget_title', $instance['title'] );
        $subtitle = apply_filters( 'widget_title', $instance['subtitle'] );

        $html = $instance['html'];
        $link = $instance['link'];
        $link_label = $instance['link_label'];

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

        }
        echo '<ul class="styled-list">';
        echo $html;
        echo '</ul>
        <span class="extra-links"><a href="'.$link.'">'.$link_label.'</a></span>'; ?>

        <?php echo $after_widget;
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
        else {
            $title = __( 'Styled list', 'crum' );
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
        if ( isset( $instance[ 'link_label' ] ) ) {
            $link_label = $instance[ 'link_label' ];
        }

        ?>
    <p>
        <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'crum' ); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
    </p>
    <p>
        <label for="<?php echo $this->get_field_id( 'subtitle' ); ?>"><?php _e( 'Subitle:', 'crum' ); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id( 'subtitle' ); ?>" name="<?php echo $this->get_field_name( 'subtitle' ); ?>" type="text" value="<?php echo esc_attr( $subtitle ); ?>" />
    </p>

    <p>
        <label for="<?php echo $this->get_field_id( 'html' ); ?>"><?php _e( 'Items wrapped in: li HTML tags', 'crum' ); ?>:</label>
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