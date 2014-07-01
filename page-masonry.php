<?php
/*
Template Name: Grid of posts
*/
?>

<?php get_template_part('templates/top', 'page'); ?>

<section id="layout">
    <div class="row">
        <div class="twelve columns">
            <?php while (have_posts()) : the_post(); ?>
            <?php the_content(); ?>
            <?php endwhile; ?>

            <?php

            if (is_front_page()) {
                $paged = (get_query_var('page')) ? get_query_var('page') : 1;
            } else {
                $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
            }

            $number_per_page = get_post_meta($post->ID, 'blog_number_to_display', true);
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
						  'cat' => $blog_custom_categories
			);

            query_posts($args);

            get_template_part('templates/content','grid');
            ?>

        </div>
    </div>
</section>

<?php
wp_enqueue_script('cr-masonry');
?>


<script type="text/javascript">
    jQuery(window).load(function(){


        var columns    = 3,
                setColumns = function() {
                    columns = jQuery( window ).width() > 768 ? 3 : jQuery( window ).width() > 460 ? 2 : 1;
                    console.log(columns);
                };

        setColumns();
        jQuery( window ).resize( setColumns );

        jQuery( '#grid-posts' ).masonry(
                {
                    itemSelector : 'article.small-news',
                    isAnimated: true,
                    columnWidth:  function( containerWidth ) { return containerWidth / columns; }
                });
    });
</script>