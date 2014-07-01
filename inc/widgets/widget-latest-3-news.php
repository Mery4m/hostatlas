<?php

class crum_latest_3_news extends WP_Widget {

	function crum_latest_3_news() {

		/* Widget settings. */

		$widget_ops = array( 'classname' => 'block-news-feature', 'description' => __( 'Display 3 articles row from some category','crum') );

		/* Widget control settings. */

		$control_ops = array( 'id_base' => 'crum_latest_3_news' );

		/* Create the widget. */

		$this->WP_Widget( 'crum_latest_3_news', 'Theme: Latest 3 news from category', $widget_ops, $control_ops );

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
        $post_order = $instance['post_order'];
        $post_order_by = $instance['post_order_by'];
        $align = $instance['align'];


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

       /*
        * Number of columns
        */

        if ($align == 'horizontal'){
            $class='six';
        } else {
            $class='twelve';
        }

        $cat_selected = json_decode($instance['cat_sel']);
        if(count($cat_selected)>0)
         $categ = implode(',', $cat_selected);

        global $post;

        echo '<div class="row">';

        $the_query = new WP_Query( 'cat = '.$categ.'&posts_per_page=1&ignore_sticky_posts=1&orderby='.$post_order_by.'&order='.$post_order.'' );
        while ( $the_query->have_posts() ) :
            $the_query->the_post(); ?>

            <div class="<?php echo $class ?> columns featured-news">

                <article class="hnews hentry small-news">

                    <?php
                    if( has_post_thumbnail() ){
                        $thumb = get_post_thumbnail_id();
                        $img_url = wp_get_attachment_url($thumb, 'medium'); //get img URL
                        $article_image = aq_resize($img_url, 380, 125, true);
                        ?>


                        <div class="entry-thumb">
                            <a href="<?php the_permalink();?>" class="more-link">
                                <img src="<?php echo $article_image ?>" style="margin:0 0;" alt="<?php the_title();?>" title="<?php the_title();?>">
                            </a>
                        </div>

                        <?php } ?>

                    <div class="hover-bg">
                        <time datetime="<?php echo get_the_time('c'); ?>">
                            <span class="day"><?php echo get_the_date('d'); ?></span>
                            <span class="month"><?php echo get_the_date('M'); ?>.</span>
                        </time>

                        <?php get_template_part('templates/dopinfo'); ?>

                        <div class="entry-title">
                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></div>

                        <div class="entry-summary">
                            <p><?php content(20) ?></p>
                        </div>
                    </div>
                </article>

            </div>

            <?php
        endwhile;
        wp_reset_postdata();?>
        <div class="<?php echo $class ?> columns other-news">

        <?php
        $the_query = new WP_Query( 'cat = '.$categ.'&posts_per_page=2&ignore_sticky_posts=1&offset=1&orderby='.$post_order_by.'&order='.$post_order.'' );
        while ( $the_query->have_posts() ) :
            $the_query->the_post(); ?>

            <article class="hentry mini-news">


                <?php if( has_post_thumbnail() ){
                $thumb = get_post_thumbnail_id();
                $img_url = wp_get_attachment_url($thumb, 'thumb'); //get img URL
                $article_image = aq_resize($img_url, 80, 80, true);
                ?>
                <div class="entry-thumb ">
                    <a href="<?php the_permalink() ;?>" class="more">
                        <img src="<?php echo $article_image ?>" alt="<?php the_title(); ?>"/>
                    </a>
                </div>

                <?php
            } else { ?>
                <div class="tabs-date">
                    <time datetime="<?php echo get_the_time('c'); ?>">
                        <span class="day"><?php echo get_the_date('d'); ?></span>
                        <span class="month"><?php echo get_the_date('M'); ?>.</span>
                    </time>
                </div>

                <?php } ?>


                <?php get_template_part('templates/dopinfo'); ?>

                <div class="entry-title">
                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></div>

                <div class="entry-summary">
                    <p><?php content(20) ?></p>
                </div>

            </article>

        <?php
        endwhile;

        echo '</div></div>';

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

        $instance['post_order'] = $new_instance['post_order'];

        $instance['align'] = $new_instance['align'];

		$instance['cat_sel'] = json_encode($new_instance['cat_sel'], true);

		return $instance;

	}

	function form( $instance ) {

        $title = apply_filters( 'widget_title', $instance['title'] );

        $subtitle = $instance['subtitle'];

        $cat_selected = json_decode($instance['cat_sel']);


		/* Set up some default widget settings. */

        $link = $instance['link'];

        $link_label = $instance['link_label'];

        $post_order = $instance['post_order'];

        $post_order_by = $instance['post_order_by'];

        $align = $instance['align'];


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
    <p>
        <label for="<?php echo $this->get_field_id( 'align' ); ?>"><?php _e( 'Select news alignment', 'crum' ); ?></label>
        <select class="widefat" id="<?php echo $this->get_field_id( 'align' ); ?>" name="<?php echo $this->get_field_name( 'align' );?>"  >

            <option class="widefat"  value="horizontal" <?php if( esc_attr( $align ) == 'horizontal' ) echo 'selected'; ?>><?php _e('Horizontal','crum'); ?></option>
            <option class="widefat"  value="vertical" <?php if( esc_attr( $align ) == 'vertical' ) echo 'selected'; ?>><?php _e('Vertical','crum'); ?></option>

        </select>

    </p>






<?php

	}

}