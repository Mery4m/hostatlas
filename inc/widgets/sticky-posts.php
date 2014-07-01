<?php

class crum_stiky_news extends WP_Widget {

    function crum_stiky_news() {

        /* Widget settings. */

        $widget_ops = array( 'classname' => 'breaking-news-block', 'description' => __( 'Display stiky articles from some category','crum') );

        /* Widget control settings. */

        $control_ops = array( 'id_base' => 'crum_stiky_news' );

        /* Create the widget. */

        $this->WP_Widget( 'crum_stiky_news', 'Theme: Sticky Articles', $widget_ops, $control_ops );

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

        $number = $instance['number'];
        $link = $instance['link'];
        $link_label = $instance['link_label'];
        $post_order = $instance['post_order'];
        $post_order_by = $instance['post_order_by'];



        /* show the widget content without any headers or wrappers */

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
            echo '<span class="extra-links"><a href="'.$link.'">'.$link_label.'</a></span>';


            echo'</div>';

        }


        $cat_selected = json_decode($instance['cat_sel']);
        if(count($cat_selected)>0)
            $categ = implode(',', $cat_selected);

        global $post;

        $args = array(
            'cat' => $categ,
            'orderby' => $post_order_by,
            'order' => $post_order,
            'posts_per_page' => $number,
            'post__in'  => get_option( 'sticky_posts' ),
            'ignore_sticky_posts' => 1
        );

        $the_query = new WP_Query( $args );

        while ( $the_query->have_posts() ) :
            $the_query->the_post(); ?>

            <div class="blocks-label">
                <?php if ($link){
                    echo '<a href="'.$link.'"> '.$link_label .' </a>';
                } else {
                    echo $link_label;
                } ?>
            </div>

            <div class="blocks-text">
                <p><?php content(20); ?><a href="<?php the_permalink(); ?>"> <?php _e('Read more','crum') ?> </a></p>
            </div>

        <?php
        endwhile;

        /* Restore original Post Data
        */
        wp_reset_postdata();

        echo $after_widget;

    }

    function update( $new_instance, $old_instance ) {

        $instance = $old_instance;

        $instance['title'] = strip_tags( $new_instance['title'] );

        $instance['subtitle'] = strip_tags( $new_instance['subtitle'] );


        $instance['number'] = $new_instance['number'];

        $instance['link'] = $new_instance['link'];

        $instance['link_label'] = $new_instance['link_label'];

        $instance['post_order'] = $new_instance['post_order'];

        $instance['cat_sel'] = json_encode($new_instance['cat_sel'], true);

        return $instance;

    }

    function form( $instance ) {

        $title = apply_filters( 'widget_title', $instance['title'] );

        $subtitle = $instance['subtitle'];

        $cat_selected = json_decode($instance['cat_sel']);


        /* Set up some default widget settings. */

        $link = $instance['link'];

        $number = $instance['number'];

        $link_label = $instance['link_label'];

        $post_order = $instance['post_order'];

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
        <label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php _e( 'Number of posts', 'crum' ); ?>:</label>
        <input class="widefat" id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="text" value="<?php echo esc_attr( $number ); ?>" />
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
        <label for="<?php echo $this->get_field_id( 'cat_sel' ); ?>"><?php _e( 'Select category', 'crum' ); ?></label>
        <select class="widefat" id="<?php echo $this->get_field_id( 'cat_sel' ); ?>" name="<?php echo $this->get_field_name( 'cat_sel' );?>[ <?php $cat_sel ?>]" multiple="multiple"  >

            <?php
            $cats = get_categories();

            foreach ( $cats as $cat ) {

                $cat_sel = (is_array($cat_selected) && in_array($cat->term_id, $cat_selected))?' selected="selected"':'';
                echo '<option class="widefat" value="'.$cat->term_id.'"'.$cat_sel.'>'.$cat->name.'</option>';
            }?>

        </select>

    </p>

    <p>
        <label for="<?php echo $this->get_field_id( 'post_order' ); ?>"><?php _e( 'Order posts', 'crum' ); ?></label>
        <select class="widefat" id="<?php echo $this->get_field_id( 'post_order' ); ?>" name="<?php echo $this->get_field_name( 'post_order' );?>"  >

            <option class="widefat" <?php if( esc_attr( $post_order ) == 'DESC' ) echo 'selected'; ?> value="DESC"><?php _e('Descending','crum'); ?></option>
            <option class="widefat" <?php if( esc_attr( $post_order ) == 'ASC' ) echo 'selected'; ?> value="ASC"><?php _e('Ascending','crum'); ?></option>

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






    <?php

    }

}