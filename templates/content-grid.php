
<?php global $NHP_Options;

    if (!have_posts()) : ?>

  <div class="alert">
    <?php _e('Sorry, no results were found.', 'crum'); ?>
  </div>
  <?php get_search_form(); ?>
<?php endif; ?>

<div id="grid-posts">

<?php while (have_posts()) : the_post();

    $postid = get_the_ID();

    ?>


<article class="hnews hentry small-news four columns post-<?php echo $postid; ?>">

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

    <div class="hover-bg">
        <time datetime="<?php echo get_the_time('c'); ?>">
            <span class="day"><?php echo get_the_date('d'); ?></span>
            <span class="month"><?php echo get_the_date('M'); ?>.</span>
        </time>

        <?php get_template_part('templates/dopinfo'); ?>

        <div class="entry-title">
            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></div>

        <div class="entry-summary">
            <p><?php
				$excerpt = get_the_excerpt();
				echo ($excerpt);
				?>
			</p>
        </div>
    </div>
</article>

<?php endwhile; ?>

</div>

<?php crum_select_pagination();?>
