<?php
/*
Template Name: TMP portfolio 4 round
*/

global $NHP_Options;

?>

<?php get_template_part('templates/top', 'page'); ?>

    <section id="layout">

        <div class="row">
            <div class="twelve rows">
                <?php while (have_posts()) : the_post(); ?>
                    <?php the_content(); ?>
                <?php endwhile; ?>
            </div>
        </div>

        <?php // Portffolio options from page metadata

        if (is_front_page()) {
            $paged = (get_query_var('page')) ? get_query_var('page') : 1;
        } else {
            $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
        }

        $number_per_page = get_post_meta($post->ID, 'folio_number_to_display', true);
        $number_per_page = ($number_per_page) ? $number_per_page : '16';


        $selected_custom_categories = wp_get_object_terms($post->ID, 'my-product_category');
        if (!empty($selected_custom_categories)) {
            if (!is_wp_error($selected_custom_categories)) {
                foreach ($selected_custom_categories as $term) {
                    $blog_cut_array[] = $term->term_id;
                }
            }
        }

        $folio_custom_categories = (get_post_meta(get_the_ID(), 'folio_sort_category', true)) ? $blog_cut_array : '';

        $taxonomy = 'my-product_category';
        $categories = get_terms($taxonomy);

        ?>

        <div class="row">


            <div id="portfolio-page">

                <?php if (($NHP_Options->get("folio_sorting") != '') ) {
                    ?>

                    <div class="sort-panel twelve columns">
                        <ul class="filter">
							<?php
							if ( !$folio_custom_categories ) { ?>
							<li class="active"><a data-filter=".project" href="#"><?php echo __('All', 'crum'); ?></a>
								<?php foreach ( $categories as $category ) {
									echo '<li><a href="#"  data-filter=".project[data-category~=\'' . strtolower( preg_replace( '/\s+/', '-', $category->slug ) ) . '\']">' . $category->name . '</a></li>';
								}
								} elseif(count($folio_custom_categories)>1) {?>
							<li class="active"><a data-filter=".project" href="#"><?php echo __('All', 'crum'); ?></a>
								<?php foreach($folio_custom_categories as $cat_id){
									$category = get_term_by('id',$cat_id,'my-product_category' );
									echo '<li><a href="#"  data-filter=".project[data-category~=\'' . strtolower( preg_replace( '/\s+/', '-', $category->slug ) ) . '\']">' . $category->name . '</a></li>';
								}
								} ?>

                        </ul>
                    </div>

                <?php } ?>

                <div class="works-list">

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

                    ?>

                    <?php while (have_posts()) : the_post();

                        $terms = get_the_terms(get_the_ID(), 'my-product_category');


                        if (has_post_thumbnail()) {
                            $thumb = get_post_thumbnail_id();
                            $img_url = wp_get_attachment_url($thumb, 'full'); //get img URL
                        } else {
                            $img_url = get_template_directory_uri() . '/img/no-image-large.jpg';
                        }


                        $article_image = aq_resize($img_url, 280, 280, true); //resize & crop img
                        $class_col = 'three';

                        $portfolio_style = 'round';

                        $folio_video = false;

                        if (get_post_meta($post->ID, 'folio_vimeo_video_url', true) || get_post_meta($post->ID, 'folio_youtube_video_url', true) ||
                            (get_post_meta($post->ID, 'folio_self_hosted_mp4', true) != '') || (get_post_meta($post->ID, 'folio_self_hosted_webm', true) != '')
                        ) {
                            $folio_video = true;
                        }

                        ?>


                        <div class="<?php echo $class_col; ?> columns project <?php echo $portfolio_style; ?>" data-category="<?php foreach ($terms as $term) {
                            echo strtolower(preg_replace('/\s+/', '-', $term->slug)) . ' ';
                        } ?>">
                            <div class="entry-thumb <?php if ($folio_video) {
                                echo 'video-link';
                            } else {
                                echo '';
                            } ?>">
                                <a href="<?php the_permalink(); ?>" class="more-link">
                                    <img src="<?php echo $article_image ?>" style="margin:0 0;" alt="<?php the_title(); ?>" title="<?php the_title(); ?>">
                                </a>
                            </div>
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
/*
 *  Enquene styles and scripts
 */
if (($NHP_Options->get("folio_sorting") != '')) {

    wp_enqueue_script('isotope');
    wp_enqueue_script('isotope-run');
}