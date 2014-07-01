<?php
global $NHP_Options;
?>

<div class="twelve columns recent-block">
    <div class="page-block-title">
        <div class="icon"><img src="<?php $NHP_Options->show("recent_block_icon");?>" alt=""></div>
        <div class="subtitle"><?php $NHP_Options->show("recent_block_subtitle");?></div>
        <h2><?php $NHP_Options->show("recent_block_title");?></h2>
    </div>

    <dl class="tabs contained horisontal">

        <dd class="active"><a href="#recent-all"><?php echo __('All','crum') ?></a></dd>

        <?php
        global $NHP_Options;

        $taxonomy = 'my-product_category';
        $categories = get_terms($taxonomy);

        $first = true;
        foreach ($categories as $category) {

            echo '<dd><a href="#recent' . $category->term_id . '">' . $category->name . '</a></dd>';
        }

        $page = $NHP_Options->get("portfolio_page_select");
        $title = get_the_title($page);

 ?>
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


            echo '<li id="recent' . $category->term_id . 'Tab" >';

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