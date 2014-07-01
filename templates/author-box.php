<?php
/**
 * Author Box
 *
 * Displays author box with author description and thumbnail on single posts
 *
 * @package WordPress
 * @subpackage OneTouch theme, for WordPress
 * @since OneTouch theme 1.9
 */

global $NHP_Options;
?>

<div class="about-author">
    <figure class="author-photo">
        <?php echo get_avatar( get_the_author_meta('ID') , 80 ); ?>
    </figure>
    <div class="ovh">
        <div class="author-description">
            <h6><?php the_author_posts_link(); ?></h6>
            <p><?php the_author_meta('description'); ?></p>
        </div>

        <?php if ($NHP_Options->get("links_box_disp")) {?>

        <div class="post-links">
            <ul>
                <li><a href="<?php echo get_author_posts_url(get_the_author_meta( 'ID' )); ?>"><?php _e('All posts', 'crum'); ?></a></li>
                <li><a href="<?php the_author_meta('user_url'); ?>" rel="author" ><?php _e('Website', 'crum'); ?></a></li>
                <li><a href="mailto:<?php echo antispambot(get_the_author_email()); ?>" title="E-mail"><?php _e('Email', 'crum');?></a></li>
            </ul>
        </div>

        <?php } ?>

        <div class="share-icons">
            <?php if (get_the_author_meta('twitter')) {  echo '<a class="tw" href="',the_author_meta('twitter'),'"></a>';  } ?>
            <?php if (get_the_author_meta('facebook')) {  echo '<a class="fb" href="',the_author_meta('facebook'),'"></a>';  } ?>
            <?php if (get_the_author_meta('googleplus')) {  echo '<a class="gp" href="',the_author_meta('googleplus'),'"></a>';  } ?>
            <?php if (get_the_author_meta('linkedin')) {  echo '<a class="li" href="',the_author_meta('linkedin'),'"></a>';  } ?>
            <?php if (get_the_author_meta('flickr')) {  echo '<a class="fl" href="',the_author_meta('flickr'),'"></a>';  } ?>
        </div>
    </div>
</div>