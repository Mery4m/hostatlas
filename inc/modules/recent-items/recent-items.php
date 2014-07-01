<?php

/*
Plugin Name: Recent works
Plugin URI: #
Description: Recent works from portfolio
Author: Crumina
Version: 1
Author URI: #
*/



class crum_recent_works extends WP_Widget {

    function  crum_recent_works() {

        /* Widget settings. */

        $widget_ops = array( 'classname' => 'recent-block', 'description' => __( 'Must be placed in 1 column row','crum') );

        /* Widget control settings. */

        $control_ops = array( 'id_base' => 'crum_recent_works' );

        /* Create the widget. */

        $this->WP_Widget( 'crum_recent_works', 'Box: Recent from portfolio', $widget_ops, $control_ops );

    }

    function widget( $args, $instance ) {

        //get theme options

        if ( isset( $instance[ 'title' ] ) ) {

            $title = $instance[ 'title' ];

        } else {

            $title = __( 'Recent items', 'crum' );

        }
        if ( isset( $instance[ 'subtitle' ] ) ) {

            $subtitle = $instance[ 'subtitle' ];
        }

        extract( $args );



global $NHP_Options;
?>

<div class="twelve columns recent-block">
    <?php if ($title) { ?>
    <div class="page-block-title">
        <div class="icon"><img src="<?php $NHP_Options->show("recent_block_icon");?>" alt=""></div>
        <?php  if ( $subtitle ) {
            echo '<div class="subtitle">';
            echo $subtitle;
            echo '</div>';
        }

            echo '<h2>';
            echo $title;
            echo '</h2>';

        ?>
    </div>
<?php } ?>
    <dl class="tabs contained horisontal">

        <dd class="active"><a href="#recent-all"><?php _e('All','crum') ?></a></dd>

        <?php

        $taxonomy = 'my-product_category';
        $categories = get_terms($taxonomy);

        $first = true;
        foreach ($categories as $category) {

            echo '<dd><a href="#recent-' . $category->term_id . '">' . $category->name . '</a></dd>';
        }

        $page = $NHP_Options->get("portfolio_page_select");
        $title = get_the_title($page);

        ?>

        <dt>

            <span class="extra-links"><a href="<?php echo  get_page_link($page); ?>/"><?php echo $title . ' ' . __('full page', 'crum'); ?></a></span>

        </dt>

    </dl>


    <ul class="tabs-content contained folio-wrap clearing-container">

        <li id="recent-allTab" class="active">

            <?php
            $args = array(
                'post_type'      => 'my-product',
                'posts_per_page' => '4'
            );
            $the_query = new WP_Query($args);
            while ($the_query->have_posts()) : $the_query->the_post();

                if (has_post_thumbnail()) {
                    $thumb = get_post_thumbnail_id();
                    $img_url = wp_get_attachment_url($thumb, 'full'); //get img URL
                } else {
                    $img_url = get_template_directory_uri() . '/img/no-image-large.jpg';
                }

                $article_image = aq_resize($img_url, 371, 253, true);
                $terms = get_the_terms(get_the_ID(), 'my-product_category');

                ?>

                <div class="folio-item">
                    <div class="hover">
                        <img src="<?php echo $article_image ?>" style="margin:0 0;" alt="<?php the_title();?>"
                             title="<?php the_title();?>">

                        <div class="description">
                            <div class="icon">
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/img/icons/folio-mini-image.png" alt="Image icon">
                            </div>
                            <div class="info">
                                <?php if ($NHP_Options->get("folio_date") != '') {
                                echo ' <span class="date">' . get_the_date() . '</span>';
                            } ?>
                                <span class="tags"><?php get_template_part('templates/folio', 'terms'); ?></span>
                            </div>
                            <div class="title"><?php the_title(); ?></div>
                        </div>
                        <a href="<?php the_permalink();?>" class="more"></a>
                    </div>
                </div>



                <?php endwhile; // END the Wordpress Loop ?>

        </li>

        <?php

        $first = true;
        // List the Portfolio Categories
        foreach ($categories as $category) {


            echo '<li id="recent-' . $category->term_id . 'Tab" >';

            $args = array(
                'tax_query'      => array(

                    array(
                        'taxonomy' => 'my-product_category',
                        'field'    => 'slug',
                        'terms'    => $category->slug
                    )
                ),
                'post_type'      => 'my-product',
                'posts_per_page' => '4'
            );
            $the_query = new WP_Query($args);
            while ($the_query->have_posts()) : $the_query->the_post();

                if (has_post_thumbnail()) {
                    $thumb = get_post_thumbnail_id();
                    $img_url = wp_get_attachment_url($thumb, 'full'); //get img URL
                } else {
                    $img_url = get_template_directory_uri() . '/img/no-image-large.jpg';
                }

                $article_image = aq_resize($img_url, 371, 253, true);
                $terms = get_the_terms(get_the_ID(), 'my-product_category');

                ?>

                <div class="folio-item"> <div class="hover">

                    <img src="<?php echo $article_image ?>" style="margin:0 0;" alt="<?php the_title();?>"
                         title="<?php the_title();?>">


                    <div class="description">
                        <div class="icon">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/icons/folio-mini-image.png" alt="Image icon">
                        </div>
                        <div class="info">
                            <?php if ($NHP_Options->get("folio_date") != '') {
                            echo ' <span class="date">' . get_the_date() . '</span>';
                        } ?>
                            <span class="tags"><?php get_template_part('templates/folio', 'terms'); ?></span>
                        </div>
                        <div class="title"><?php the_title(); ?></div>
                    </div>

                    <a href="<?php the_permalink();?>" class="more"></a>
                </div>

                </div>



                <?php endwhile; // END the Wordpress Loop


            echo '</li>';
            wp_reset_query(); // Reset the Query Loop
        }
        ?>

    </ul>
</div>
  <?php  }

    function update( $new_instance, $old_instance ) {

        $instance = $old_instance;

        $instance['title'] = strip_tags( $new_instance['title'] );

        $instance['subtitle'] = strip_tags( $new_instance['subtitle'] );

        $instance['text'] = $new_instance['text'];


        return $instance;

    }

    function form( $instance ) {

        $title = apply_filters( 'widget_title', $instance['title'] );

        $subtitle = $instance['subtitle'];

        /* Set up some default widget settings. */

        $defaults = array( 'text' => '' );

        $instance = wp_parse_args( (array) $instance, $defaults ); ?>


    <p>
      <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'crum'); ?></label>
      <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>"/>
    </p>
    <p>
      <label for="<?php echo $this->get_field_id('subtitle'); ?>"><?php _e('Subtitle:', 'crum'); ?></label>
      <input class="widefat" id="<?php echo $this->get_field_id('subtitle'); ?>" name="<?php echo $this->get_field_name('subtitle'); ?>" type="text" value="<?php echo esc_attr($subtitle); ?>"/>
    </p>



        <?php

    }

}

add_action( 'widgets_init', create_function( '', 'register_widget("crum_recent_works");' ) );