<?php
class crum_one_testimonial extends WP_Widget {


    function __construct() {
        parent::__construct(
            'crum_one_testimonial',
            __( 'Box: One Testimonial', 'crum' ), // Name
            array( 'classname' => 'block-otzuv', 'description' => __( 'Display One testimonial','crum') )
        );
    }

    function widget( $args, $instance ) {

        //get theme options

        if ( isset( $instance[ 'title' ] ) ) {

            $title = $instance[ 'title' ];

        } else {

            $title = __( 'Testimonial', 'crum' );

        }
        if ( isset( $instance[ 'subtitle' ] ) ) {

            $subtitle = $instance[ 'subtitle' ];
        }

        extract( $args );

        $link = $instance['link'];
        $link_label = $instance['link_label'];

        $post_id = $instance['testimonial_sel'];


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

        $query_args = array(

            'post_type' => 'testimonial',
            'post__in' => array( $post_id )

        );


        $the_query = new WP_Query($query_args);

        global $post;

        while ( $the_query->have_posts() ) :  $the_query->the_post(); ?>

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

        $instance['link'] = strip_tags( $new_instance['link'] );

        $instance['link_label'] = strip_tags( $new_instance['link_label'] );

        $instance['testimonial_sel'] = strip_tags( $new_instance['testimonial_sel'] );

        return $instance;

    }

    function form( $instance ) {

        $title = apply_filters( 'widget_title', $instance['title'] );

        $subtitle = $instance['subtitle'];

        $link = $instance['link'];

        $post_id = $instance['testimonial_sel'];

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
        <label for="<?php echo $this->get_field_id( 'testimonial_sel' ); ?>"><?php _e( 'Select item', 'crum' ); ?></label>
        <select class="widefat" id="<?php echo $this->get_field_id( 'testimonial_sel' ); ?>" name="<?php echo $this->get_field_name( 'testimonial_sel' );?>"  >

            <?php
            $args = array( 'post_type' => 'testimonial');
            $testimonials = get_posts( $args );
            foreach( $testimonials as $post ) : ?>
                <option class="widefat" <?php if( esc_attr( $post_id ) == $post->ID ) echo 'selected'; ?> value="<?php echo $post->ID; ?>"><?php echo get_the_title( $post->ID ) ?></option>
            <?php endforeach; ?>


        </select>
    </p>


    <?php

    }

}

add_action( 'widgets_init', create_function( '', 'register_widget("crum_one_testimonial");' ) );