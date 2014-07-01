<?php

class crum_testimonial_widget extends WP_Widget {

	function crum_testimonial_widget() {

		/* Widget settings. */

		$widget_ops = array( 'classname' => 'block-otzuv', 'description' => __( 'Display clients / partners testimonials','crum') );

		/* Widget control settings. */

		$control_ops = array( 'id_base' => 'crum_testimonial_widget' );

		/* Create the widget. */

		$this->WP_Widget( 'crum_testimonial_widget', 'Theme: Testimonial display', $widget_ops, $control_ops );

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


        global $post;

        $the_query = new WP_Query( 'posts_per_page='. $number .'&post_type=testimonial&orderby='.$post_order_by.'&order='.$post_order.'' );

        while ( $the_query->have_posts() ) :
            $the_query->the_post(); ?>



        <blockquote cite="http://a.uri.com/">
            <div class="quote"><?php the_content(); ?></div>

            <p class="quoteCite">

                <?php
            if( has_post_thumbnail() ){
                $thumb = get_post_thumbnail_id();
                $img_url = wp_get_attachment_url($thumb, 'medium'); //get img URL
                $article_image = aq_resize($img_url, 380, 125, true);
                ?>

                <img class="avatar" src="<?php echo $article_image ?>" alt="">

            <?php }

            if (get_post_meta($post->ID, 'crum_testimonial_autor', true)): ?>

                <span class="quote-author"><?php echo get_post_meta($post->ID, 'crum_testimonial_autor', true); ?></span>

            <?php endif;

                if (get_post_meta($post->ID, 'crum_testimonial_additional', true)): ?>

                    <span class="quote-sub"><?php echo get_post_meta($post->ID, 'crum_testimonial_additional', true); ?></span>

                    <?php endif;

                ?>
            </p>
        </blockquote>


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

		return $instance;

	}

	function form( $instance ) {

        $title = apply_filters( 'widget_title', $instance['title'] );

        $subtitle = $instance['subtitle'];


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