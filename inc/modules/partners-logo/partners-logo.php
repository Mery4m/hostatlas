<?php

/*
Plugin Name: Partners logos
Plugin URI: #
Description: Block with partners / clients logos
Author: Crumina
Version: 1
Author URI: #
*/



class crum_partners_widget extends WP_Widget {

    function crum_partners_widget() {

        /* Widget settings. */

        $widget_ops = array( 'classname' => 'block-partners', 'description' => __( 'Display clients / partners logo','crum') );

        /* Widget control settings. */

        $control_ops = array( 'id_base' => 'crum_partners_widget' );

        /* Create the widget. */

        $this->WP_Widget( 'crum_partners_widget', 'Theme: Partners / Clients list', $widget_ops, $control_ops );

    }

    function widget( $args, $instance ) {

        //get theme options

        if ( isset( $instance[ 'title' ] ) ) {

            $title = $instance[ 'title' ];

        } else {

            $title = __( 'Latest articles', 'crum' );

        }
        if ( isset( $instance[ 'subtitle' ] ) ) {

            $subtitle = $instance[ 'subtitle' ];
        }

        extract( $args );

        $link = $instance['link'];
        $link_label = $instance['link_label'];
        $limit_number = $instance['limit_number'];
        $display_link = $instance['display_link'];
        $post_order_by = (isset($instance['post_order_by'])) ? $instance['post_order_by'] : '';



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
            if ($link) { echo '<span class="extra-links"><a href="'.$link.'">'.$link_label.'</a></span>';}
            echo $after_title;

        }


        echo '<div class="clients-list">';

        global $post;

        $post_order = (isset($post_order)) ? $post_order : '';
        $limit_number = (isset($limit_number)) ? $limit_number : '-1';
        $the_query = new WP_Query( 'posts_per_page= '.$limit_number.'&post_type= clients&orderby='.$post_order_by.'&order='.$post_order.'' );

        while ( $the_query->have_posts() ) :
            $the_query->the_post();

            if ($display_link == 'yes') {
                echo '<a href="'.get_permalink().'" class="">';
            }

            if( has_post_thumbnail() ){
                $thumb = get_post_thumbnail_id();
                $img_url = wp_get_attachment_url($thumb, 'medium'); //get img URL
                $article_image = aq_resize($img_url, 120, 150, false);
                ?>

            <img  src="<?php echo $article_image ?>" alt="<?php the_title(); ?>" class="client-item">

            <?php }

            if ($display_link == 'yes') {
                echo '</a>';
            }

        endwhile;

        echo '</div>';

        /* Restore original Post Data
        */
        wp_reset_postdata();

        echo $after_widget;

    }

    function update( $new_instance, $old_instance ) {

        $instance = $old_instance;

        $instance['title'] = strip_tags( $new_instance['title'] );

        $instance['subtitle'] = strip_tags( $new_instance['subtitle'] );


        $instance['link'] = $new_instance['link'];

        $instance['link_label'] = $new_instance['link_label'];

        $instance['limit_number'] = $new_instance['limit_number'];

        $instance['display_link'] = $new_instance['display_link'];

        $instance['post_order_by'] = $new_instance['post_order_by'];

        return $instance;

    }

    function form( $instance ) {

        $title = apply_filters( 'widget_title', $instance['title'] );

        $subtitle = $instance['subtitle'];


        /* Set up some default widget settings. */

        $link = $instance['link'];

        $link_label = $instance['link_label'];

        $limit_number = $instance['limit_number'];

        $display_link = $instance['display_link'];

        $post_order_by = $instance['post_order_by'];


        ?>


    <p>
        <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'crum'); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>"/>
    </p>
    <p>
        <label for="<?php echo $this->get_field_id('subtitle'); ?>"><?php _e('Subtitle:', 'crum'); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id('subtitle'); ?>" name="<?php echo $this->get_field_name('subtitle'); ?>" type="text" value="<?php echo esc_attr($subtitle); ?>"/>
    </p>
    <p>
        <label for="<?php echo $this->get_field_id( 'link' ); ?>"><?php _e( 'Link to full page', 'crum' ); ?>:</label>
        <input class="widefat" id="<?php echo $this->get_field_id( 'link' ); ?>" name="<?php echo $this->get_field_name( 'link' ); ?>" type="text" value="<?php echo esc_attr( $link ); ?>" />
    </p>

    <p>
        <label for="<?php echo $this->get_field_id( 'link_label' ); ?>"><?php _e( 'Link label', 'crum' ); ?>:</label>
        <input class="widefat" id="<?php echo $this->get_field_id( 'link_label' ); ?>" name="<?php echo $this->get_field_name( 'link_label' ); ?>" type="text" value="<?php echo esc_attr( $link_label ); ?>" />
    </p>


    <p>
        <label for="<?php echo $this->get_field_id( 'display_link' ); ?>"><?php _e( 'Link for details page', 'crum' ); ?></label>
        <select class="widefat" id="<?php echo $this->get_field_id( 'display_link' ); ?>" name="<?php echo $this->get_field_name( 'display_link' );?>"  >

            <option class="widefat" <?php if( esc_attr( $display_link ) == 'yes' ) echo 'selected'; ?> value="yes"><?php _e('Yes','crum'); ?></option>
            <option class="widefat" <?php if( esc_attr( $display_link ) == 'no' ) echo 'selected'; ?> value="no"><?php _e('No','crum'); ?></option>

        </select>
    </p>
    <p>
        <label for="<?php echo $this->get_field_id( 'post_order_by' ); ?>"><?php _e( 'Order posts by', 'crum' ); ?></label>
        <select class="widefat" id="<?php echo $this->get_field_id( 'post_order_by' ); ?>" name="<?php echo $this->get_field_name( 'post_order_by' );?>"  >

            <option class="widefat"  value="none" <?php if( esc_attr( $post_order_by ) == 'none' ) echo 'selected'; ?>><?php _e('No order','crum'); ?></option>
            <option class="widefat"  value="ID" <?php if( esc_attr( $post_order_by ) == 'ID' ) echo 'selected'; ?>><?php _e('Order by post id','crum'); ?></option>
            <option class="widefat"  value="title" <?php if( esc_attr( $post_order_by ) == 'title' ) echo 'selected'; ?>><?php _e('Order by title','crum'); ?></option>
            <option class="widefat"  value="name" <?php if( esc_attr( $post_order_by ) == 'name' ) echo 'selected'; ?>><?php _e('Order by post name (post slug)','crum'); ?></option>
            <option class="widefat"  value="date" <?php if( esc_attr( $post_order_by ) == 'date' ) echo 'selected'; ?>><?php _e('Order by date','crum'); ?></option>
            <option class="widefat"  value="modified" <?php if( esc_attr( $post_order_by ) == 'modified' ) echo 'selected'; ?>><?php _e('Order by last modified date','crum'); ?></option>
            <option class="widefat"  value="rand" <?php if( esc_attr( $post_order_by ) == 'rand' ) echo 'selected'; ?>><?php _e('Random order','crum'); ?></option>
            <option class="widefat"  value="comment_count" <?php if( esc_attr( $post_order_by ) == 'comment_count' ) echo 'selected'; ?>><?php _e('Order by number of comments','crum'); ?></option>

        </select>

    </p>
    <p>
        <label for="<?php echo $this->get_field_id( 'limit_number' ); ?>"><?php _e( 'Limit number of items', 'crum' ); ?>:</label>
        <input class="widefat" id="<?php echo $this->get_field_id( 'limit_number' ); ?>" name="<?php echo $this->get_field_name( 'limit_number' ); ?>" type="text" value="<?php echo esc_attr( $limit_number ); ?>" />
    </p>






    <?php

    }

}

add_action( 'widgets_init', create_function( '', 'register_widget("crum_partners_widget");' ) );