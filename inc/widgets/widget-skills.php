<?php

class crum_skills_widget extends WP_Widget {

    public function __construct() {
        parent::__construct(
            'skills_widget', // Base ID
            'Theme: My skills widget', // Name
            array( 'description' => __( 'My slills widget', 'crum' ), ) // Args
        );
    }


    public function widget( $args, $instance ) {
        extract( $args );
        $title = apply_filters( 'widget_title', $instance['title'] );
        $subtitle = apply_filters( 'widget_title', $instance['subtitle'] );


        $skill_1 = $instance['skill_1'];
        $skill_2 = $instance['skill_2'];
        $skill_3 = $instance['skill_3'];
        $skill_4 = $instance['skill_4'];

        $skill_1_p = $instance['skill_1_p'];
        $skill_2_p = $instance['skill_2_p'];
        $skill_3_p = $instance['skill_3_p'];
        $skill_4_p = $instance['skill_4_p'];

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


        if ($skill_1){
             echo '<label>'. $skill_1 .'</label>';
             echo '<div class="progress twelve"><span class="meter" style="width: '.$skill_1_p.'%"> '.$skill_1_p.'%</span></div>';
        }
        if ($skill_2){
            echo '<label>'. $skill_2 .'</label>';
            echo '<div class="progress twelve"><span class="meter" style="width: '.$skill_2_p.'%"> '.$skill_2_p.'%</span></div>';
        }
        if ($skill_3){
            echo '<label>'. $skill_3 .'</label>';
            echo '<div class="progress twelve"><span class="meter" style="width: '.$skill_3_p.'%"> '.$skill_3_p.'%</span></div>';
        }
        if ($skill_4){
            echo '<label>'. $skill_4 .'</label>';
            echo '<div class="progress twelve"><span class="meter" style="width: '.$skill_4_p.'%"> '.$skill_4_p.'%</span></div>';
        }


        ?>

        <?php echo $after_widget;
    }

    /**
     * Sanitize widget form values as they are saved.
     */
    public function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['title'] = strip_tags( $new_instance['title'] );
        $instance['subtitle'] = strip_tags( $new_instance['subtitle'] );

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
            $title = __( 'My skills', 'crum' );
        }
        if ( isset( $instance[ 'subtitle' ] ) ) {
            $subtitle = $instance[ 'subtitle' ];
        }
        if ( isset( $instance[ 'skill_1' ] ) ) {
            $skill_1 = $instance[ 'skill_1' ];
        }
        if ( isset( $instance[ 'skill_2' ] ) ) {
            $skill_2 = $instance[ 'skill_2' ];
        }
        if ( isset( $instance[ 'skill_3' ] ) ) {
            $skill_3 = $instance[ 'skill_3' ];
        }
        if ( isset( $instance[ 'skill_4' ] ) ) {
            $skill_4 = $instance[ 'skill_4' ];
        }
        if ( isset( $instance[ 'skill_1_p' ] ) ) {
            $skill_1_p = $instance[ 'skill_1_p' ];
        }
        if ( isset( $instance[ 'skill_2_p' ] ) ) {
            $skill_2_p = $instance[ 'skill_2_p' ];
        }
        if ( isset( $instance[ 'skill_3_p' ] ) ) {
            $skill_3_p = $instance[ 'skill_3_p' ];
        }
        if ( isset( $instance[ 'skill_4_p' ] ) ) {
            $skill_4_p = $instance[ 'skill_4_p' ];
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
        <label for="<?php echo $this->get_field_id( 'skill_1' ); ?>"><?php _e( 'Skill', 'crum' ); ?>:</label>
        <input class="widefat" id="<?php echo $this->get_field_id( 'skill_1' ); ?>" name="<?php echo $this->get_field_name( 'skill_1' ); ?>" type="text" value="<?php echo esc_attr( $skill_1 ); ?>" />
    </p>

    <p>
        <label for="<?php echo $this->get_field_id( 'skill_1_p' ); ?>"><?php _e( 'Skill percent', 'crum' ); ?>:</label>
        <input class="widefat" id="<?php echo $this->get_field_id( 'skill_1_p' ); ?>" name="<?php echo $this->get_field_name( 'skill_1_p' ); ?>" type="text" value="<?php echo esc_attr( $skill_1_p ); ?>" />
    </p>

    <p>
        <label for="<?php echo $this->get_field_id( 'skill_2' ); ?>"><?php _e( 'Skill', 'crum' ); ?>:</label>
        <input class="widefat" id="<?php echo $this->get_field_id( 'skill_2' ); ?>" name="<?php echo $this->get_field_name( 'skill_2' ); ?>" type="text" value="<?php echo esc_attr( $skill_2 ); ?>" />
    </p>
    <p>
        <label for="<?php echo $this->get_field_id( 'skill_2_p' ); ?>"><?php _e( 'Skill percent', 'crum' ); ?>:</label>
        <input class="widefat" id="<?php echo $this->get_field_id( 'skill_2_p' ); ?>" name="<?php echo $this->get_field_name( 'skill_2_p' ); ?>" type="text" value="<?php echo esc_attr( $skill_2_p ); ?>" />
    </p>

    <p>
        <label for="<?php echo $this->get_field_id( 'skill_3' ); ?>"><?php _e( 'Skill', 'crum' ); ?>:</label>
        <input class="widefat" id="<?php echo $this->get_field_id( 'skill_3' ); ?>" name="<?php echo $this->get_field_name( 'skill_3' ); ?>" type="text" value="<?php echo esc_attr( $skill_3 ); ?>" />
    </p>
    <p>
        <label for="<?php echo $this->get_field_id( 'skill_3_p' ); ?>"><?php _e( 'Skill percent', 'crum' ); ?>:</label>
        <input class="widefat" id="<?php echo $this->get_field_id( 'skill_3_p' ); ?>" name="<?php echo $this->get_field_name( 'skill_3_p' ); ?>" type="text" value="<?php echo esc_attr( $skill_3_p ); ?>" />
    </p>

    <p>
        <label for="<?php echo $this->get_field_id( 'skill_4' ); ?>"><?php _e( 'Skill', 'crum' ); ?>:</label>
        <input class="widefat" id="<?php echo $this->get_field_id( 'skill_4' ); ?>" name="<?php echo $this->get_field_name( 'skill_4' ); ?>" type="text" value="<?php echo esc_attr( $skill_4 ); ?>" />
    </p>
    <p>
        <label for="<?php echo $this->get_field_id( 'skill_4_p' ); ?>"><?php _e( 'Skill percent', 'crum' ); ?>:</label>
        <input class="widefat" id="<?php echo $this->get_field_id( 'skill_4_p' ); ?>" name="<?php echo $this->get_field_name( 'skill_4_p' ); ?>" type="text" value="<?php echo esc_attr( $skill_4_p ); ?>" />
    </p>



    <?php
    }

}