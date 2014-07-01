<?php
/*
Plugin Name: Call to Action
Plugin URI: #
Description: Call to Action block
Author: Crumina
Version: 1
Author URI: #
*/ 
/**
 * Notice Class
 */
class crum_callinaction extends WP_Widget {
    /** constructor */
    function __construct() {
        parent::WP_Widget('crum_callinaction', 'Box: Call to Action', array( 'description' => 'Call to Action' ) );
    }

    /** @see WP_Widget::widget */
    function widget( $args, $instance ) {

        extract( $args );

        $title = apply_filters( 'widget_title', $instance['title'] );
        ?>

    <div class="to-action-block al-<?php echo $instance['alignment'];?>">
        <?php
        if(!empty($instance['button_label'])){
            echo '<a style="width:'.$instance['button_width'].';height:'.$instance['button_height'].';line-height:'.$instance['button_height'].';font-size:'.$instance['button_fontsize'].'" class="button" href="'.$instance['button_url'].'"> <span class="icon"><img src="'.get_template_directory_uri().'/assets/img/cart-icon.png" alt=""></span> '.$instance["button_label"].'</a>';
        }?>

        <div class="ovh">
            <h5><?php echo $instance['desc']; ?></h5>
            <?php if ( !empty( $title ) ) { echo "<".$instance['title_tag'].">" .  html_entity_decode($title) . "</".$instance['title_tag'].">"; } ?>
        </div>
    </div>

    <?php

    }

    /** @see WP_Widget::update */
    function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['title_tag'] = strip_tags($new_instance['title_tag']);
        $instance['desc'] = strip_tags($new_instance['desc']);
        $instance[ 'alignment' ] =  $new_instance[ 'alignment' ] ;
        $instance[ 'button_label' ] =  $new_instance[ 'button_label' ] ;
        $instance[ 'button_url' ] =  $new_instance[ 'button_url' ] ;
        $instance[ 'button_height' ] =  $new_instance[ 'button_height' ];
        $instance[ 'button_width' ] =  $new_instance[ 'button_width' ];
        $instance[ 'button_fontsize' ] =  $new_instance[ 'button_fontsize' ];

        return $instance;
    }

    /** @see WP_Widget::form */
    function form( $instance ) {

            $title = esc_attr( $instance[ 'title' ] );
            $title_tag = esc_attr( $instance[ 'title_tag' ] );
            $desc =  $instance[ 'desc' ] ;
            $alignment =  $instance[ 'alignment' ] ;
            $button_label =  $instance[ 'button_label' ];
            $button_url =  $instance[ 'button_url' ];
            $button_height =  $instance[ 'button_height' ];
            $button_width =  $instance[ 'button_width' ];
            $button_fontsize =  $instance[ 'button_fontsize' ];

        ?>
    <p>
        <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'crum'); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
        <label for="<?php echo $this->get_field_id('title-tag'); ?>"><?php _e('Title Tag:', 'crum'); ?></label>
        <select class="widefat" id="<?php echo $this->get_field_id('title_tag'); ?>" name="<?php echo $this->get_field_name('title_tag'); ?>">
            <option value="h1" <?php if($title_tag=='h1') echo 'selected=selected'; ?>>h1</option>
            <option value="h2" <?php if($title_tag=='h2') echo 'selected=selected'; ?>>h2</option>
            <option value="h3" <?php if($title_tag=='h3') echo 'selected=selected'; ?>>h3</option>
            <option value="h4" <?php if($title_tag=='h4') echo 'selected=selected'; ?>>h4</option>
        </select>
        <label for="<?php echo $this->get_field_id('desc_label'); ?>"><?php _e('Description:', 'crum'); ?></label>
        <textarea id="<?php echo $this->get_field_id('desc'); ?>" name="<?php echo $this->get_field_name('desc'); ?>" cols="20" rows="4" style="width: 100%"><?php echo $desc; ?></textarea>

        <label for="<?php echo $this->get_field_id('alignment-label'); ?>"><?php _e('Alignment:', 'crum'); ?></label>
        <select class="widefat" id="<?php echo $this->get_field_id('alignment'); ?>" name="<?php echo $this->get_field_name('alignment'); ?>">
            <option value="left" <?php if($alignment == 'left'){ echo 'selected="selected"';} ?>>Left</option>
            <option value="right" <?php if($alignment == 'right'){ echo 'selected="selected"';} ?>>Right</option>
            <option value="center" <?php if($alignment == 'center'){ echo 'selected="selected"';} ?>>Center</option>
        </select>

        <label for="<?php echo $this->get_field_id('button-label'); ?>"><?php _e('Button Label:', 'crum'); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id('button_label'); ?>" name="<?php echo $this->get_field_name('button_label'); ?>" type="text" value="<?php echo $button_label; ?>" />

        <label for="<?php echo $this->get_field_id('button-url'); ?>"><?php _e('Button URL:', 'crum'); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id('button_url'); ?>" name="<?php echo $this->get_field_name('button_url'); ?>" type="text" value="<?php echo $button_url; ?>" />

        <label for="<?php echo $this->get_field_id('button-height'); ?>"><?php _e('Button Height:', 'crum'); ?></label>
        <input class="mytext" id="<?php echo $this->get_field_id('button_height'); ?>" name="<?php echo $this->get_field_name('button_height'); ?>" type="text" value="<?php echo $button_height; ?>" />
        <label for="<?php echo $this->get_field_id('button-width'); ?>"><?php _e('Button Width:', 'crum'); ?></label>
        <input class="mytext" id="<?php echo $this->get_field_id('button_width'); ?>" name="<?php echo $this->get_field_name('button_width'); ?>" type="text" value="<?php echo $button_width; ?>" />
        <label for="<?php echo $this->get_field_id('button-font-size'); ?>"><?php _e('Button Font Size:', 'crum'); ?></label>
        <input class="mytext" id="<?php echo $this->get_field_id('button_fontsize'); ?>" name="<?php echo $this->get_field_name('button_fontsize'); ?>" type="text" value="<?php echo $button_fontsize; ?>" />


    </p>
    <?php
    }

}

add_action( 'widgets_init', create_function( '', 'register_widget("crum_callinaction");' ) );