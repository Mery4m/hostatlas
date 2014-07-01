<?php
/**
 * Foo_Widget Class
 */
class crum_widget_accordion extends WP_Widget {
    /** constructor */
    function __construct() {
        parent::WP_Widget(
        /* Base ID */'crum_widget_accordion',
        /* Name */'Theme: Accordion widget', array( 'description' => 'Accordion Widget' )
        );
    }

    /** @see WP_Widget::widget */
    function widget( $args, $instance ) {
        extract( $args );
        $title =  $instance['title'];
        $content=  $instance['content'] ;

        $block_title =  $instance['block_title'] ;
        $subtitle =  $instance['subtitle'] ;


        echo $before_widget;
        if ($block_title) {

            echo '<div class="title">';
            if ( $subtitle ) {
                echo '<div class="subtitle">';
                echo $subtitle;
                echo '</div>';
            }

            echo $before_title;
            echo $block_title;
            echo $after_title;

            echo'</div>';
        }

        if($title){
            echo '<ul class="accordion">';
            $cnt=1;
            foreach($title as $key=>$val){
                if($val!='')  {
                    ?>

                    <li <?php if ($cnt == '1') {echo 'class="active"';} $cnt++ ?> >
                        <div class="title">
                            <h5><?php echo $val;?></h5>
                        </div>
                        <div class="content">
                            <p><?php echo htmlspecialchars_decode(stripcslashes($content[$key]));?></p>
                        </div>
                    </li>

                <?php

                }

            }
            echo '</ul>';
        }

        echo $after_widget;
    }

    /** @see WP_Widget::update */
    function update( $new_instance, $old_instance ) {
        $instance = $new_instance;

        return $instance;
    }

    /** @see WP_Widget::form */
    function form( $instance ) {
        if ( $instance ) {
            $block_title =  $instance['block_title'];
            $subtitle =  $instance['subtitle'];
            $title =  $instance['title'];
            $content=  $instance['content'] ;
        }

        ?>

    <p>
        <label for="<?php echo $this->get_field_id( 'block_title' ); ?>"><?php _e( 'Title:', 'crum' ); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id( 'block_title' ); ?>" name="<?php echo $this->get_field_name( 'block_title' ); ?>" type="text" value="<?php echo esc_attr( $block_title ); ?>" />
    </p>
    <p>
        <label for="<?php echo $this->get_field_id( 'subtitle' ); ?>"><?php _e( 'Subitle:', 'crum' ); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id( 'subtitle' ); ?>" name="<?php echo $this->get_field_name( 'subtitle' ); ?>" type="text" value="<?php echo esc_attr( $subtitle ); ?>" />
    </p>

    <div id="tabpane">
        <?php
        if($title){
            for($i=0;$i<count($title);$i++ ){
                ?>

                <p>
                    <label for="<?php echo $this->get_field_id('title1'); ?>"><?php _e('Section Title:', 'crum'); ?></label>
                    <input class="widefat" id="<?php echo $this->get_field_id('title1'); ?>" name="<?php echo $this->get_field_name('title'); ?>[]" type="text" value="<?php echo htmlspecialchars(stripcslashes($title[$i])); ?>" />
                </p>
                <p>
                    <label for="<?php echo $this->get_field_id('content1'); ?>"><?php _e('Section Content:', 'crum'); ?></label>
                    <textarea class="widefat" id="<?php echo $this->get_field_id('content1'); ?>" name="<?php echo $this->get_field_name('content'); ?>[]" ><?php echo htmlspecialchars(stripcslashes($content[$i])); ?></textarea>
                </p>
                <?php
            }
        }else{
            ?>
            <p>
                <label for="<?php echo $this->get_field_id('title1'); ?>"><?php _e('Section Title:', 'crum'); ?></label>
                <input class="widefat" id="<?php echo $this->get_field_id('title1'); ?>" name="<?php echo $this->get_field_name('title'); ?>[]" type="text" value="" />
            </p>
            <p>
                <label for="<?php echo $this->get_field_id('content1'); ?>"><?php _e('Section Content:', 'crum'); ?></label>
                <textarea class="widefat" id="<?php echo $this->get_field_id('content1'); ?>" name="<?php echo $this->get_field_name('content'); ?>[]" ></textarea>
            </p>
            <p>
                <label for="<?php echo $this->get_field_id('title1'); ?>"><?php _e('Section Title:', 'crum'); ?></label>
                <input class="widefat" id="<?php echo $this->get_field_id('title1'); ?>" name="<?php echo $this->get_field_name('title'); ?>[]" type="text" value="" />
            </p>
            <p>
                <label for="<?php echo $this->get_field_id('content1'); ?>"><?php _e('Section Content:', 'crum'); ?></label>
                <textarea class="widefat" id="<?php echo $this->get_field_id('content1'); ?>" name="<?php echo $this->get_field_name('content'); ?>[]" ></textarea>
            </p>
            <p>
                <label for="<?php echo $this->get_field_id('title1'); ?>"><?php _e('Section Title:', 'crum'); ?></label>
                <input class="widefat" id="<?php echo $this->get_field_id('title1'); ?>" name="<?php echo $this->get_field_name('title'); ?>[]" type="text" value="" />
            </p>
            <p>
                <label for="<?php echo $this->get_field_id('content1'); ?>"><?php _e('Section Content:', 'crum'); ?></label>
                <textarea class="widefat" id="<?php echo $this->get_field_id('content1'); ?>" name="<?php echo $this->get_field_name('content'); ?>[]" ></textarea>
            </p>
            <p>
                <label for="<?php echo $this->get_field_id('title1'); ?>"><?php _e('Section Title:', 'crum'); ?></label>
                <input class="widefat" id="<?php echo $this->get_field_id('title1'); ?>" name="<?php echo $this->get_field_name('title'); ?>[]" type="text" value="" />
            </p>
            <p>
                <label for="<?php echo $this->get_field_id('content1'); ?>"><?php _e('Section Content:', 'crum'); ?></label>
                <textarea class="widefat" id="<?php echo $this->get_field_id('content1'); ?>" name="<?php echo $this->get_field_name('content'); ?>[]" ></textarea>
            </p>
            <p>
                <label for="<?php echo $this->get_field_id('title1'); ?>"><?php _e('Section Title:', 'crum'); ?></label>
                <input class="widefat" id="<?php echo $this->get_field_id('title1'); ?>" name="<?php echo $this->get_field_name('title'); ?>[]" type="text" value="" />
            </p>
            <p>
                <label for="<?php echo $this->get_field_id('content1'); ?>"><?php _e('Section Content:', 'crum'); ?></label>
                <textarea class="widefat" id="<?php echo $this->get_field_id('content1'); ?>" name="<?php echo $this->get_field_name('content'); ?>[]" ></textarea>
            </p>
            <?php
        }
        ?>

    </div>
    <input type="button" id="addtab_" value="Add Another Accordion" class="button">
    <script type="text/javascript">
        //TODO: make JS for adding new sections
    </script>


<?php
    }

}
