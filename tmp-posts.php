<?php
/*
Template Name: Blog posts
*/
?>
<?php get_template_part('templates/top', 'page'); ?>

<section id="layout">
    <div class="row">

        <?php
        set_layout('archive');

        global $NHP_Options;

        if (is_front_page()) {
            $paged = (get_query_var('page')) ? get_query_var('page') : 1;
        } else {
            $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
        }

        $number_per_page = get_post_meta(get_the_ID(), 'blog_number_to_display', true);
        $number_per_page = ($number_per_page) ? $number_per_page : '12';

        $selected_custom_categories = wp_get_object_terms($post->ID, 'category');
        if(!empty($selected_custom_categories)){
            if(!is_wp_error( $selected_custom_categories )){
                foreach($selected_custom_categories as $term){
                    $blog_cut_array[] = $term->term_id;
                }
            }
        }

        $blog_custom_categories = ( get_post_meta(get_the_ID(), 'blog_sort_category',true)) ?  $blog_cut_array : '';

        if ($blog_custom_categories){$blog_custom_categories = implode(",", $blog_custom_categories);}

        $args = array('post_type' => 'post',
            'posts_per_page' => $number_per_page,
            'paged' => $paged,
            'orderby' => 'author',
            'cat' => $blog_custom_categories
        );

        $temp = $wp_query;
        $wp_query = null;
        $wp_query = new WP_Query($args);

        ?>

        <?php while ($wp_query->have_posts()) : $wp_query->the_post(); ?>

            <article <?php post_class(); ?>>

                <div class="post-media">
                    <?php

                    if (has_post_format('video')) {
                        get_template_part('templates/post', 'video');
                    } elseif (has_post_format('audio')) {
                        get_template_part('templates/post', 'audio');
                    } elseif (has_post_format('gallery')) {
                        get_template_part('templates/post', 'gallery');
                    } else {

                        if (has_post_thumbnail()) {
                            $thumb = get_post_thumbnail_id();
                            $img_url = wp_get_attachment_url($thumb, 'full'); //get img URL
                            if ($NHP_Options->get('post_thumbnails_width') != '' && $NHP_Options->get('post_thumbnails_height') != '') {
                                $article_image = aq_resize($img_url, $NHP_Options->get('post_thumbnails_width'), $NHP_Options->get('post_thumbnails_height'), true);
                            } else {
                                $article_image = aq_resize($img_url, 1200, 500, true);
                            }

                            ?>

                            <div class="entry-thumb">
                                <a href="<?php the_permalink(); ?>" class="more-link">
                                    <img src="<?php echo $article_image ?>" style="margin:0 0;"
                                         alt="<?php the_title(); ?>" title="<?php the_title(); ?>">
                                </a>
                            </div>

                        <?php
                        }
                    } ?>

                </div>

                <time class="updated" datetime="<?php echo get_the_time('c'); ?>">
                    <span class="day"><?php echo get_the_date('d'); ?></span>
                    <span class="month"><?php echo get_the_date('M'); ?></span>
                </time>

                <div class="ovh">
                    <header>
                        <?php get_template_part('templates/entry-meta'); ?>

                        <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                    </header>
                    <div class="entry-content">
                        <?php
						$excerpt = get_the_excerpt();
						echo ($excerpt);
                        ?>
                    </div>
                </div>
            </article>

        <?php endwhile; ?>

        <?php crum_select_pagination();?>

        <?php
            $wp_query = null;
            $wp_query = $temp;
            wp_reset_query();
        ?>


        <?php   set_layout('archive', false);

        ?>

    </div>
</section>