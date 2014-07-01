<?php
global $NHP_Options;
?>



<div class="twelve columns recent-product-block">
    <div class="page-block-title">
        <div class="icon"><img src="<?php $NHP_Options->show("shop_block_icon");?>" alt=""></div>
        <div class="ovh">
            <div class="subtitle">Small subtitle here</div>
            <h2>Recent items</h2>
        </div>
    </div>

    <dl class="tabs contained horisontal">
        <dd class="active"><a href="#simpleContained1">Must have</a></dd>
        <dd class=""><a href="#simpleContained2">Best sellres  </a></dd>
        <dd class=""><a href="#simpleContained3">special offer</a></dd>
    </dl>
    <ul class="tabs-content contained clearing-container">
        <li class="active" id="simpleContained1Tab">
            <ul class="products">
                <li class="product">
                    <a href="#">
                        <img src="pic/product_01.jpg" alt="">
                        <h3>Great dianomd shoes </h3>
                        <span class="price">320$</span>
                        <span class="hover-plus"><img alt="zoom" src="img/big-plus.gif"></span>
                    </a>
                    <a href="#" class="button">buy this item</a>
                </li>
                <li class="product">
                    <a href="#">
                        <img src="pic/product_02.jpg" alt="">
                        <h3>Great dianomd shoes </h3>
                        <span class="price">320$</span>
                        <span class="hover-plus"><img alt="zoom" src="img/big-plus.gif"></span>
                    </a>
                    <a href="#" class="button">buy this item</a>
                </li>
                <li class="product">
                    <a href="#">
                        <img src="pic/product_03.jpg" alt="">
                        <h3>Great dianomd shoes </h3>
                        <span class="price">320$</span>
                        <span class="hover-plus"><img alt="zoom" src="img/big-plus.gif"></span>
                    </a>
                    <a href="#" class="button">buy this item</a>
                </li>
            </ul>
        </li>
        <li id="simpleContained2Tab">
            <ul class="products">
                <li class="product">
                    <a href="#">
                        <img src="pic/product_02.jpg" alt="">
                        <h3>Great dianomd shoes </h3>
                        <span class="price">320$</span>
                        <span class="hover-plus"><img alt="zoom" src="img/big-plus.gif"></span>
                    </a>
                    <a href="#" class="button">buy this item</a>
                </li>
                <li class="product">
                    <a href="#">
                        <img src="pic/product_03.jpg" alt="">
                        <h3>Great dianomd shoes </h3>
                        <span class="price">320$</span>
                        <span class="hover-plus"><img alt="zoom" src="img/big-plus.gif"></span>
                    </a>
                    <a href="#" class="button">buy this item</a>
                </li>
                <li class="product">
                    <a href="#">
                        <img src="pic/product_01.jpg" alt="">
                        <h3>Great dianomd shoes </h3>
                        <span class="price">320$</span>
                        <span class="hover-plus"><img alt="zoom" src="img/big-plus.gif"></span>
                    </a>
                    <a href="#" class="button">buy this item</a>
                </li>
            </ul>
        </li>
        <li id="simpleContained3Tab">
            <ul class="products">
                <li class="product">
                    <a href="#">
                        <img src="pic/product_03.jpg" alt="">
                        <h3>Great dianomd shoes </h3>
                        <span class="price">320$</span>
                        <span class="hover-plus"><img alt="zoom" src="img/big-plus.gif"></span>
                    </a>
                    <a href="#" class="button">buy this item</a>
                </li>
                <li class="product">
                    <a href="#">
                        <img src="pic/product_01.jpg" alt="">
                        <h3>Great dianomd shoes </h3>
                        <span class="price">320$</span>
                        <span class="hover-plus"><img alt="zoom" src="img/big-plus.gif"></span>
                    </a>
                    <a href="#" class="button">buy this item</a>
                </li>
                <li class="product">
                    <a href="#">
                        <img src="pic/product_02.jpg" alt="">
                        <h3>Great dianomd shoes </h3>
                        <span class="price">320$</span>
                        <span class="hover-plus"><img alt="zoom" src="img/big-plus.gif"></span>
                    </a>
                    <a href="#" class="button">buy this item</a>
                </li>
            </ul>
        </li>
    </ul>
</div>


<div class="twelve columns recent-block">
    <div class="page-block-title">
        <div class="icon"><img src="<?php $NHP_Options->show("recent_block_icon");?>" alt=""></div>
        <div class="subtitle">Small subtitle here</div>
        <h2>Recent works</h2>
    </div>

    <dl class="tabs contained horisontal">

        <?php
        global $NHP_Options;

        $taxonomy = 'my-product_category';
        $categories = get_terms($taxonomy);

        $first = true;
        foreach ($categories as $category) {
            if ( $first )
            {
                $active='class="active"';
                $first = false;
            }
            else
            {
                $active='';
            }
            echo '<dd '.$active.'><a href="#' . str_replace('-', '', $category->slug) . '">' . $category->name . '</a></dd>';
        }

        $page = $NHP_Options->get("portfolio_page_select");
        $title = get_the_title($page);

        ?>

        <dt>
            <span class="extra-links"><a href="<?php echo home_url() . '/' . the_slug($page); ?>/"><?php echo $title . ' ' . __('full page', 'crum'); ?></a></span>
        </dt>
    </dl>


    <ul class="tabs-content contained folio-wrap clearing-container">

        <?php

        $first = true;
        // List the Portfolio Categories
        foreach ($categories as $category) {

            if ( $first )
            {
                $active='class="active"';
                $first = false;
            }
            else
            {
                $active='';
            }


            echo '<li '.$active.' id="' . str_replace('-', '', $category->slug) . 'Tab" >';

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

                $article_image = aq_resize($img_url, 291, 206, true);
                $terms = get_the_terms(get_the_ID(), 'my-product_category');

                ?>

                <div class="folio-item">
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
                    <a href="<?php the_permalink();?>" class="more more-link"> <span> <img
                            src="<?php echo get_template_directory_uri(); ?>/assets/img/big-plus.gif" alt="zoom"> </span> </a>
                </div>



                <?php endwhile; // END the Wordpress Loop


            echo '</li>';
            wp_reset_query(); // Reset the Query Loop
        }
        ?>

    </ul>
</div>