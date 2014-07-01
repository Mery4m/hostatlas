<div class="entry-meta post-info">

    <span class="byline author vcard"><?php echo __('By', 'crum'); ?> <a href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>" rel="author" class="fn"><?php echo get_the_author(); ?></a>,</span>

    <?php the_tags('<span class="post-tags">',', ',',</span>'); ?>


    <?php if ( ! is_single() )
    comments_popup_link(__('Leave a comment', 'crum'), __('1 Comment', 'crum'), __('% Comments', 'crum')); ?>

</div>

