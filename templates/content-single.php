<?php global $NHP_Options;
    while (have_posts()) : the_post(); ?>

<article <?php post_class(); ?>>

    <?php get_template_part('templates/single','social'); ?>

    <div class="ovh">

            <?php
            if ($NHP_Options->get("thumb_inner_disp")) {
                if (has_post_thumbnail()) {
                    $thumb = get_post_thumbnail_id();
                    $img_url = wp_get_attachment_url($thumb, 'full'); //get img URL
                    if ($NHP_Options->get('post_thumbnails_width') != '' && $NHP_Options->get('post_thumbnails_height') != '') {
                        $article_image = aq_resize($img_url, $NHP_Options->get('post_thumbnails_width'), $NHP_Options->get('post_thumbnails_height'), true);
                    } else {
                        $article_image = aq_resize($img_url, 1200, 500, true);
                    }
                    ?>
                <div class="post-media">
                    <div class="entry-thumb">
                        <img src="<?php echo $article_image ?>" alt="<?php the_title(); ?>"/>
                    </div>
                </div>
                    <?php
                }
            }
            ?>

        <div class="entry-content">

         <?php  if (has_post_format('video')) {

            get_template_part('templates/post', 'video');

        }elseif ( has_post_format( 'gallery' )) {
            get_template_part('templates/post', 'gallery');
        }
            if (has_post_format('audio')) {
            get_template_part('templates/post', 'audio');

        }
            the_content(); ?>
        </div>
        <?php get_template_part('templates/entry-meta'); ?>
        <div class="divider"></div>
    </div>

    <?php wp_link_pages(array('before' => '<nav class="page-nav"><p>' . __('Pages:', 'crum'), 'after' => '</p></nav>')); ?>

</article>

<?php endwhile; ?>

<?php    if( $NHP_Options->get("autor_box_disp") =='1'){

    get_template_part('templates/author-box');

}

comments_template('/templates/comments.php');

