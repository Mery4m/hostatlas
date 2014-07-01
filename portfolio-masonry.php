<?php
/*
Template Name: Portfolio grid
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

            $number_per_page = get_post_meta($post->ID, 'folio_number_to_display', true);
            $number_per_page = ($number_per_page) ? $number_per_page : '16';



            $selected_custom_categories = wp_get_object_terms($post->ID, 'my-product_category');
            if(!empty($selected_custom_categories)){
                if(!is_wp_error( $selected_custom_categories )){
                    foreach($selected_custom_categories as $term){
                        $blog_cut_array[] = $term->term_id;
                    }
                }
            }

            $folio_custom_categories = ( get_post_meta(get_the_ID(), 'folio_sort_category',true)) ?  $blog_cut_array : '';




            ?>

            <?php global $NHP_Options; ?>

            <div id="grid-folio" class="col-3 row">

                <?php


                if ($folio_custom_categories) {
                    $args = array(
                        'post_type' => 'my-product',
                        'posts_per_page' => $number_per_page,
                        'paged' => $paged,
                        'tax_query' => array(
                            array(
                                'taxonomy' => 'my-product_category',
                                'field' => 'id',
                                'terms' => $folio_custom_categories
                            )
                        )
                    );
                } else {
                    $args = array(
                        'post_type' => 'my-product',
                        'posts_per_page' => $number_per_page,
                        'paged' => $paged
                    );
                }


                $wp_query = new WP_Query($args);

                while ($wp_query->have_posts()) : $wp_query->the_post();

                if (has_post_thumbnail()) {
                    $thumb = get_post_thumbnail_id();
                    $img_url = wp_get_attachment_url($thumb, 'full'); //get img URL
                } else {
                    $img_url = get_template_directory_uri() . '/img/no-image-large.jpg';
                }
                $article_image = aq_resize($img_url, 400, 999, false); //resize & crop img

                $folio_video = false;

                if (get_post_meta($post->ID, 'folio_vimeo_video_url', true) || get_post_meta($post->ID, 'folio_youtube_video_url', true) ||
                    (get_post_meta($post->ID, 'folio_self_hosted_mp4', true) != '') || (get_post_meta($post->ID, 'folio_self_hosted_webm', true) != '')){
                    $folio_video = true;
                }
                ?>

                <div class="four columns project">
                    <div class="entry-thumb <?php if($folio_video){ echo 'video-link'; } else { echo ''; } ?>">
                        <a href="<?php the_permalink();?>" class="more-link">
                            <img src="<?php echo $article_image ?>" style="margin:0 0;" alt="<?php the_title();?>" title="<?php the_title();?>">
                        </a>
                    </div>
                    <h6 class="project-info">
                        <?php if ($NHP_Options->get("folio_date") != ''){
                        echo '<time>'. get_the_date() .'</time>';
                    } ?>
                        <span class="project-cat">
        <?php get_template_part('templates/folio','terms'); ?>
		</span>

                    </h6>
                    <h3 class="project-title"><a href="<?php the_permalink();?>"><?php the_title();?></a></h3>
                </div>

                <?php endwhile; ?>



            </div>
            <?php
			crum_select_pagination();

            wp_reset_query();
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
        setColumns = function() { columns = jQuery( window ).width() > 640 ? 3 : jQuery( window ).width() > 320 ? 2 : 1; };

        setColumns();
        jQuery( window ).resize( setColumns );

        jQuery( '#grid-folio' ).masonry(
                {
                    itemSelector : '.project',
                    isAnimated: true,
                    columnWidth:  function( containerWidth ) { return containerWidth / columns; }
                });
    });
</script>