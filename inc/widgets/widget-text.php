<?php

class crum_text_subtitle extends WP_Widget {

    function __construct() {
        parent::__construct(
            'crum-text-widget',
            __( 'Cr: Text block', 'crum' ), // Name
            array( 'description' =>  __( 'Text block with subtitle','crum'), 'width' => 300, 'height' => 350,
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
        echo $before_widget;


        if ( $subtitle ) {
            echo '<div class="subtitle">';
            echo $subtitle;
            echo '</div>';
        }
        $text = apply_filters('widget_text', empty($instance['text']) ? '' : $instance['text'], $instance);

		
        if (!empty($title)) {
            echo $before_title . $title . $after_title;
        } ?>

        <div class="textwidget"> <?php echo !empty($instance['filter']) ? wpautop($text) : $text; ?> </div>

        <?php
        echo $after_widget;
    }


    function update($new, $old){
        $new = wp_parse_args($new, array(
            'title' => '',
            'subtitle' => '',
            'text' => '',
        ));
        return $new;
    }

    function form( $instance ) {
        $instance = wp_parse_args($instance, array(
            'title' => '',
            'subtitle' => '',
            'text' => '',
        ));
        $text = apply_filters('widget_text', empty($instance['text']) ? '' : $instance['text'], $instance);
?>
    <p>
        <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'crum'); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($instance['title']); ?>"/>
    </p>
    <p>
        <label for="<?php echo $this->get_field_id('subtitle'); ?>"><?php _e('Subtitle:', 'crum'); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id('subtitle'); ?>" name="<?php echo $this->get_field_name('subtitle'); ?>" type="text" value="<?php echo esc_attr($instance['subtitle']); ?>"/>
    </p>
    <p>
        <textarea class="widefat" rows="20" cols="40" id="<?php echo $this->get_field_id('text'); ?>" name="<?php echo $this->get_field_name('text'); ?>"><?php echo $text; ?></textarea>
    </p>


    <?php
    }
}


