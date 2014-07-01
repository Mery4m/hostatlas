<?php
/*
Template Name: TMP portfolio 1
*/

global $NHP_Options;

$portfolio_columns =  '1column';

?>

<?php get_template_part('templates/top','page'); ?>

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
if(!empty($selected_custom_categories)){
    if(!is_wp_error( $selected_custom_categories )){
        foreach($selected_custom_categories as $term){
            $blog_cut_array[] = $term->term_id;
        }
    }
}

$folio_custom_categories = ( get_post_meta(get_the_ID(), 'folio_sort_category',true)) ?  $blog_cut_array : '';


$taxonomy = 'my-product_category';
$categories = get_terms($taxonomy);
?>

<div class="row">


<div id="portfolio-page">


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

        while ($wp_query->have_posts()) : $wp_query->the_post();

                get_template_part('templates/portfolio', 'item');

        endwhile;?>

        <?php

		crum_select_pagination();

        wp_reset_query();
        ?>

</div>
</div>
</section>
