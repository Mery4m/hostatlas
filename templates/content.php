<?php global $NHP_Options;

    if (!have_posts()) : ?>

    <article id="post-0" class="post no-results not-found">
        <header class="entry-header">
            <h1><?php _e( 'Nothing Found', 'crum' ); ?></h1>
        </header><!-- .entry-header -->

        <div class="entry-content">
            <p><?php _e( 'Sorry, but nothing matched your search criteria. Please try again with some different keywords.', 'crum' ); ?></p>
            <?php get_search_form(); ?>
        </div><!-- .entry-content -->


        <header class="entry-header">
            <h2><?php _e('Tags also can be used', 'crum'); ?></h2>
        </header><!-- .entry-header -->

        <div class="tags-widget">
            <?php wp_tag_cloud('smallest=10&largest=10&number=30'); ?>
        </div>

    </article><!-- #post-0 -->
    <?php endif; ?>

<?php while (have_posts()) : the_post(); ?>

<article <?php post_class(); ?>>

<?php
    $post_align = $NHP_Options->get('post_format');
    if (isset($post_align) && $post_align=='thumb-left'){ ?>
<div class="row some-aligned-post left-thumbed">
    <div class="post-media six columns">
        <?php

        if ( has_post_format( 'video' )) {
                get_template_part('templates/post', 'video');
        }elseif ( has_post_format( 'audio' )) {
            get_template_part('templates/post', 'audio');
        }elseif ( has_post_format( 'gallery' )) {
            get_template_part('templates/post', 'gallery');
        } else {

            if (has_post_thumbnail()) {
                $thumb = get_post_thumbnail_id();
                $img_url = wp_get_attachment_url($thumb, 'full'); //get img URL
                if ($NHP_Options->get('post_thumbnails_width') !='' && $NHP_Options->get('post_thumbnails_height') !=''){
                    $article_image = aq_resize($img_url, $NHP_Options->get('post_thumbnails_width'), $NHP_Options->get('post_thumbnails_height'), true);
                } else {
                    $article_image = aq_resize($img_url, 1200, 500, true);
                }

                ?>

                <div class="entry-thumb">
                    <a href="<?php the_permalink();?>" class="more-link">
                        <img src="<?php echo $article_image ?>" style="margin:0 0;" alt="<?php the_title();?>" title="<?php the_title();?>">
                    </a>
                </div>

                <?php }
            } ?>

    </div>
    <div class="six columns">

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
    if ( has_post_format( 'link' )) {
        get_template_part('templates/post', 'link');
    }if ( has_post_format( 'image' )) {
        get_template_part('templates/post', 'image');
    }if ( has_post_format( 'quote' )) {
        get_template_part('templates/post', 'quote');
    }else {
		$excerpt = get_the_excerpt();
		echo ($excerpt);
    }
            ?>
        </div>
    </div>
    </div>
</div>
<?php } elseif (isset($post_align) && $post_align=='thumb-right'){ ?>
    <div class="row some-aligned-post right-thumbed">

        <div class="six columns">

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
                    if ( has_post_format( 'link' )) {
                        get_template_part('templates/post', 'link');
                    }if ( has_post_format( 'image' )) {
                    get_template_part('templates/post', 'image');
                }if ( has_post_format( 'quote' )) {
                    get_template_part('templates/post', 'quote');
                }else {
					$excerpt = get_the_excerpt();
					echo ($excerpt);
                }
                    ?>
                </div>
            </div>
        </div>

        <div class="post-media six columns">
            <?php

            if ( has_post_format( 'video' )) {
                get_template_part('templates/post', 'video');
            }elseif ( has_post_format( 'audio' )) {
                get_template_part('templates/post', 'audio');
            }elseif ( has_post_format( 'gallery' )) {
                get_template_part('templates/post', 'gallery');
            } else {

                if (has_post_thumbnail()) {
                    $thumb = get_post_thumbnail_id();
                    $img_url = wp_get_attachment_url($thumb, 'full'); //get img URL
                    if ($NHP_Options->get('post_thumbnails_width') !='' && $NHP_Options->get('post_thumbnails_height') !=''){
                        $article_image = aq_resize($img_url, $NHP_Options->get('post_thumbnails_width'), $NHP_Options->get('post_thumbnails_height'), true);
                    } else {
                        $article_image = aq_resize($img_url, 1200, 500, true);
                    }

                    ?>

                    <div class="entry-thumb">
                        <a href="<?php the_permalink(); ?>" class="more-link">
                            <img src="<?php echo $article_image ?>" alt="<?php the_title(); ?>"/>
                        </a>
                    </div>

                    <?php }
            } ?>

        </div>

    </div>
    <?php }else { ?>
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
                    <a href="<?php the_permalink();?>" class="more-link">
                        <img src="<?php echo $article_image ?>" style="margin:0 0;" alt="<?php the_title();?>" title="<?php the_title();?>">
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
            if (has_post_format('link')) {
                get_template_part('templates/post', 'link');
            }if (has_post_format('image')) {
            get_template_part('templates/post', 'image');
        }if (has_post_format('quote')) {
            get_template_part('templates/post', 'quote');
        } else {
			$excerpt = get_the_excerpt();
			echo ($excerpt);
        }
            ?>
        </div>
    </div>


    <?php } ?>
</article>

<?php endwhile; ?>

<?php crum_select_pagination();?>
