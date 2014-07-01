<?php function crum_comment($comment, $args, $depth)
{
    $GLOBALS['comment'] = $comment; ?>

<li <?php comment_class(); ?>>
    <div class="clearing-container">
        <?php echo get_avatar($comment, $size = '60'); ?>

        <div class="ovh">
            <header class="comment-author vcard">
                <span class="fn"><?php printf(__('<cite class="fn">%s</cite>', 'crum'), get_comment_author_link()); ?></span>,
                <time datetime="<?php echo comment_date('c'); ?>">
                    <a href="<?php echo htmlspecialchars(get_comment_link($comment->comment_ID)); ?>"><?php printf(__('%1$s', 'crum'), get_comment_date(), get_comment_time()); ?></a>
                </time>
                <?php echo comment_reply_link(array('depth' => $depth, 'max_depth' => $args['max_depth'])); ?>
                <?php edit_comment_link(__('(Edit)', 'crum'), '', ''); ?>
            </header>

            <section class="comment-content">

                <?php if ($comment->comment_approved == '0') : ?>

                <div class="alert-box">
                    <?php _e('Your comment is awaiting moderation.', 'crum'); ?>
                </div>

                <?php endif; ?>

                <?php comment_text(); ?>

            </section>
        </div>
    </div>

    <?php } ?>

<?php if (post_password_required()) : ?>
    <section id="comments">
        <div class="alert-box alert">
            <?php _e('This post is password protected. Enter the password to view comments.', 'crum'); ?>
        </div>
    </section><!-- /#comments -->
    <?php endif; ?>


<?php if (have_comments()) : ?>
    <section id="comments">
        <h3><?php printf(_n('One Response to &ldquo;%2$s&rdquo;', '%1$s Responses to &ldquo;%2$s&rdquo;', get_comments_number(), 'crum'), number_format_i18n(get_comments_number()), get_the_title()); ?></h3>

        <ol class="commentlist">
            <?php wp_list_comments(array('callback' => 'crum_comment')); ?>
        </ol>

        <?php if (get_comment_pages_count() > 1 && get_option('page_comments')) : // are there comments to navigate through ?>

      	<?php
			if($NHP_Options -> get("pagination_style") == '1'):
				echo '<nav class="page-nav">';
				if (get_next_posts_link()) :
					echo '<span class="older"> ';
					next_posts_link(__('Older', 'crum'));
					echo ' </span>';
				endif;
				if (get_previous_posts_link()) :
					echo '<span class="newer">';
					previous_posts_link(__('Newer', 'crum'));
					echo '</span>';
				endif;

				echo '</nav>';
			else : crumin_pagination();
			endif;
		?>

        <?php endif; // check for comment navigation ?>

        <?php if (!comments_open() && !is_page() && post_type_supports(get_post_type(), 'comments')) : ?>
        <?php endif; ?>

    </section><!-- /#comments -->

    <?php endif; ?>

<?php if (!have_comments() && !comments_open() && !is_page() && post_type_supports(get_post_type(), 'comments')) : ?>
    <?php endif; ?>


<?php if (comments_open()) : ?>
<div id="fb-root"></div>  
<script src="http://connect.facebook.net/en_US/all.js#xfbml=1"></script>  
<fb:comments href="<?php the_permalink(); ?>" width="880"></fb:comments> 
    <section id="respond">

        <h3><?php comment_form_title(__('Leave a Reply', 'crum'), __('Leave a Reply to %s', 'crum')); ?></h3>

        <p class="cancel-comment-reply"><?php cancel_comment_reply_link(); ?></p>
        <?php if (get_option('comment_registration') && !is_user_logged_in()) : ?>

        <p><?php printf(__('You must be <a href="%s">logged in</a> to post a comment.', 'roots'), wp_login_url(get_permalink())); ?></p>

        <?php else : ?>

        <form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">

            <?php if (is_user_logged_in()) : ?>
            <p><?php printf(__('Logged in as <a href="%s/wp-admin/profile.php">%s</a>.', 'crum'), get_option('siteurl'), $user_identity); ?>
                <a href="<?php echo wp_logout_url(get_permalink()); ?>" title="<?php __('Log out of this account', 'crum'); ?>"><?php _e('Log out &raquo;', 'crum'); ?></a>
            </p>
            <?php else : ?>

            <div class="commentform-inner">
                <input type="text" placeholder="<?php _e('Name', 'crum'); if ($req) _e(' (required)', 'crum'); ?>" class="text" name="author" id="author" value="<?php echo esc_attr($comment_author); ?>" size="22" tabindex="1" <?php if ($req) echo "aria-required='true'"; ?>>
                <input type="email" placeholder="<?php _e('Email (will not be published)', 'crum'); if ($req) _e(' (required)', 'crum'); ?>" class="text" name="email" id="email" value="<?php echo esc_attr($comment_author_email); ?>" size="22" tabindex="2" <?php if ($req) echo "aria-required='true'"; ?>>
                <input type="url" placeholder="<?php _e('Website', 'crum'); ?>" class="text" name="url" id="url" value="<?php echo esc_attr($comment_author_url); ?>" size="22" tabindex="3">
            </div>
            <?php endif; ?>
            <textarea name="comment" id="comment" tabindex="4"></textarea>

            <p>
                <button name="submit" class="button" tabindex="5"><?php _e('Submit Comment', 'crum'); ?></button>
            </p>

            <?php comment_id_fields(); ?>
            <?php do_action('comment_form', $post->ID); ?>
        </form>
        <?php endif; // If registration required and not logged in ?>
    </section>
<?php endif; // if you delete this the sky will fall on your head ?>