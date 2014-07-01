<?php
/*-----------------------------------------------------------------------------------*/
/* Tabbed Widget
/*-----------------------------------------------------------------------------------*/

class crum_widget_tabs extends WP_Widget {

    public function __construct() {
        parent::__construct(
            'aq_tabs', // Base ID
            'Widget: Tabbed Widget', // Name
            array( 'classname' => 'tabs-widget', 'description' => __( 'Tabbed widget containing Popular posts, and Recent Posts', 'crum' ) ) // Args
        );
    }

    function widget($args, $instance) {
        extract( $args );

        $title = apply_filters('widget_title', $instance['title'] );
        $header_format = $instance['header_format'];
        $thumb_sel = $instance['thumb_sel'];
        $number = $instance['number'];
        $days = $instance['days'];

        echo $before_widget;

        if ($title) {

            if ( $subtitle ) {
                echo '<div class="subtitle">';
                echo $subtitle;
                echo '</div>';
            }

            echo $before_title;
            echo $title;
            echo $after_title;


        } ?>

        <dl class="tabs contained horisontal">
            <?php if ( $header_format == 'popular-recent'): ?>

                <dd class="active"><a href="#popular-p-tab"><?php _e( 'Popular', 'crum' ) ?></a></dd>
                <dd><a href="#recent-p-tab"><?php _e( 'Recent', 'crum' ) ?></a></dd>
                <dd><a href="#comments-p-tab"><?php _e( 'Comments', 'crum' ) ?></a></dd>

            <?php else : ?>

                <dd class="active"><a href="#recent-p-tab"><?php _e( 'Recent', 'crum' ) ?></a></dd>
                <dd><a href="#popular-p-tab"><?php _e( 'Popular', 'crum' ) ?></a></dd>
                <dd><a href="#comments-p-tab"><?php _e( 'Comments', 'crum' ) ?></a></dd>


            <?php endif; ?>
        </dl>
        <ul class="tabs-content contained folio-wrap clearing-container">
            <li id="popular-p-tabTab" <?php echo ( ( $header_format == 'popular-recent') ) ? 'class="active"' : '';   ?>>
                <?php if (function_exists('aq_widget_tabs_popular')) aq_widget_tabs_popular($thumb_sel,$number, $days); ?>
            </li>
            <li id="recent-p-tabTab" <?php echo ( ( $header_format != 'popular-recent') ) ? 'class="active"' : '';   ?>>
                <?php if (function_exists('aq_widget_tabs_latest')) aq_widget_tabs_latest($thumb_sel,$number); ?>
            </li>
            <li id="comments-p-tabTab">
                <?php if (function_exists('aq_widget_tabs_comments')) aq_widget_tabs_comments($number); ?>
            </li>
        </ul>

        <?php  echo $after_widget; }

    /*----------------------------------------
       update()
       ----------------------------------------

     * Function to update the settings from
     * the form() function.

     * Params:
     * - Array $new_instance
     * - Array $old_instance
     ----------------------------------------*/

    function update ( $new_instance, $old_instance ) {
        $instance = array();
        $instance['title'] = strip_tags( $new_instance['title'] );
        $instance['subtitle'] = strip_tags( $new_instance['subtitle'] );
        $instance['thumb_sel'] = $new_instance['thumb_sel'] ;
        $instance['number'] = $new_instance['number'] ;
        $instance['header_format'] = $new_instance['header_format'] ;

        return $instance;
    }

    /*----------------------------------------
      form()
      ----------------------------------------

       * The form on the widget control in the
       * widget administration area.

       * Make use of the get_field_id() and
       * get_field_name() function when creating
       * your form elements. This handles the confusing stuff.

       * Params:
       * - Array $instance
     ----------------------------------------*/

    function form( $instance ) {
        $header_format = $instance['header_format'];
        $thumb_sel = $instance['thumb_sel'];

        ?>
        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:','crum'); ?></label>
            <input type="text" class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'subtitle' ); ?>"><?php _e( 'Subtitle:','crum'); ?></label>
            <input type="text" class="widefat" id="<?php echo $this->get_field_id( 'subtitle' ); ?>" name="<?php echo $this->get_field_name( 'subtitle' ); ?>" value="<?php echo $instance['subtitle']; ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php _e( 'Number of posts:', 'crum' ); ?></label>
            <input type="text" class="widefat" id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" value="<?php echo esc_attr( $instance['number'] ); ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'days' ); ?>"><?php _e( 'Popular limit (days):', 'crum' ); ?></label>
            <input type="text" class="widefat" id="<?php echo $this->get_field_id( 'days' ); ?>" name="<?php echo $this->get_field_name( 'days' ); ?>" type="text" value="<?php echo esc_attr( $instance['days'] ); ?>" />

        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'header_format' ); ?>"><?php _e( 'Select header format:', 'crum' ); ?></label>

            <select  class="widefat"  id="<?php echo $this->get_field_id( 'header_format' ); ?>" name="<?php echo $this->get_field_name( 'header_format' );?>" >
            <option value = 'popular-recent' <?php if(  $instance['header_format']  == 'popular-recent' ) echo 'selected="selected"'; ?>><?php _e( 'Popular-Recent', 'crum' ); ?></option>
            <option value = 'recent-popular' <?php if(  $instance['header_format']  == 'recent-popular' ) echo 'selected="selected"'; ?>><?php _e( 'Recent-Popular', 'crum' ); ?></option>
            </select>

        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'thumb_sel' ); ?>"><?php _e( 'Display date or thumb:', 'crum' ); ?></label>

            <select class="widefat" id="<?php echo $this->get_field_id('thumb_sel'); ?>" name="<?php echo $this->get_field_name('thumb_sel'); ?>" >
                <option value='thumb' <?php if ($instance['thumb_sel'] == 'thumb') echo 'selected="selected"'; ?>><?php _e('Thumbnail', 'crum'); ?></option>
                <option value='date'  <?php if ($instance['thumb_sel'] == 'date') echo 'selected="selected"'; ?>><?php _e('Date', 'crum'); ?></option>
                <option value='both'  <?php if ($instance['thumb_sel'] == 'both') echo 'selected="selected"'; ?>><?php _e('Date & Thumb', 'crum'); ?></option>
            </select>

        </p>
    <?php
    } // End form()

} // End Class

/*-----------------------------------------------------------------------------------*/
/*  Popular Posts */
/*-----------------------------------------------------------------------------------*/
if (!function_exists( 'aq_widget_tabs_popular')) {
    function aq_widget_tabs_popular( $thumb_sel ,$posts = 5, $days = null ) {
        global $post;

        if ( $days ) {
            global $popular_days;
            $popular_days = $days;

            // Register the filtering function
            add_filter('posts_where', 'filter_where');
        }

        $popular = get_posts( array( 'suppress_filters' => false, 'ignore_sticky_posts' => 1, 'orderby' => 'comment_count', 'numberposts' => $posts) );

        foreach($popular as $post) :
            setup_postdata($post); ?>

            <article class="hentry mini-news clearing-container">
                <?php

                if(esc_attr( $thumb_sel ) == 'both') { ?>

                    <div class="tabs-date">
                        <time datetime="<?php echo get_the_time('c'); ?>">
                            <span class="day"><?php echo get_the_date('d'); ?></span>
                            <span class="month"><?php echo get_the_date('M'); ?>.</span>
                        </time>
                    </div>

                <?php
                }
                if( ((esc_attr( $thumb_sel ) == 'thumb') || (esc_attr( $thumb_sel ) == 'both')) && has_post_thumbnail() ){
                    $thumb = get_post_thumbnail_id();
                    $img_url = wp_get_attachment_url($thumb, 'thumb'); //get img URL
                    $article_image = aq_resize($img_url, 80, 80, true);
                    ?>
                    <div class="entry-thumb ">
                        <a href="<?php the_permalink() ;?>" class="more">
                            <img src="<?php echo $article_image ?>" alt="<?php the_title(); ?>"/>
                        </a>
                    </div>

                <?php
                } else { ?>
                    <div class="tabs-date">
                        <time datetime="<?php echo get_the_time('c'); ?>">
                            <span class="day"><?php echo get_the_date('d'); ?></span>
                            <span class="month"><?php echo get_the_date('M'); ?>.</span>
                        </time>
                    </div>

                <?php } ?>


                <div class="entry-title">
                    <a href='<?php the_permalink() ;?>'><?php the_title(); ?></a>
                </div>

                <div class="entry-summary">
                    <p><?php content(12) ?></p>
                </div>

            </article>

        <?php endforeach;
        wp_reset_query();
    }
}

//Create a new filtering function that will add our where clause to the query
function filter_where($where = '') {
    global $popular_days;
    //posts in the last X days
    $where .= " AND post_date > '" . date('Y-m-d', strtotime('-'.$popular_days.' days')) . "'";
    return $where;
}

/*-----------------------------------------------------------------------------------*/
/*  Latest Posts */
/*-----------------------------------------------------------------------------------*/
if (!function_exists( 'aq_widget_tabs_latest')) {
    function aq_widget_tabs_latest( $thumb_sel, $posts = 5) {
        global $post;
        $latest = get_posts( 'ignore_sticky_posts=1&numberposts='. $posts .'&orderby=post_date&order=desc' );
        foreach($latest as $post) :
            setup_postdata($post); ?>

            <article class="hentry mini-news clearing-container">
                <?php

                if(esc_attr( $thumb_sel ) == 'both') { ?>

                    <div class="tabs-date">
                        <time datetime="<?php echo get_the_time('c'); ?>">
                            <span class="day"><?php echo get_the_date('d'); ?></span>
                            <span class="month"><?php echo get_the_date('M'); ?>.</span>
                        </time>
                    </div>

                <?php
                }
                if( ((esc_attr( $thumb_sel ) == 'thumb') || (esc_attr( $thumb_sel ) == 'both')) && has_post_thumbnail() ){
                    $thumb = get_post_thumbnail_id();
                    $img_url = wp_get_attachment_url($thumb, 'thumb'); //get img URL
                    $article_image = aq_resize($img_url, 80, 80, true);
                    ?>
                    <div class="entry-thumb ">
                        <a href="<?php the_permalink() ;?>" class="more">
                            <img src="<?php echo $article_image ?>" alt="<?php the_title(); ?>"/>
                        </a>
                    </div>

                <?php
                } else { ?>
                    <div class="tabs-date">
                        <time datetime="<?php echo get_the_time('c'); ?>">
                            <span class="day"><?php echo get_the_date('d'); ?></span>
                            <span class="month"><?php echo get_the_date('M'); ?>.</span>
                        </time>
                    </div>

                <?php } ?>


                <div class="entry-title">
                    <a href='<?php the_permalink() ;?>'><?php the_title(); ?></a>
                </div>

                <div class="entry-summary">
                    <p><?php content(12) ?></p>
                </div>

            </article>

        <?php endforeach;
        wp_reset_query();
    }
}
/*-----------------------------------------------------------------------------------*/
/*  Latest Comments */
/*-----------------------------------------------------------------------------------*/
if (!function_exists( 'aq_widget_tabs_comments')) {
    function aq_widget_tabs_comments( $posts = 5) {
        global $wpdb;

        $comments = get_comments( array( 'number' => $posts, 'status' => 'approve' ) );
        if ( $comments ) {
            foreach ( (array) $comments as $comment) {
                $post = get_post( $comment->comment_post_ID );
                ?>

                <article class="hentry mini-news clearing-container">

                    <div class="tabs-date">
                        <time datetime="<?php echo get_the_time('c'); ?>">
                            <span class="day"><?php echo comment_date('j',$comment->comment_ID ); ?></span>
                            <span class="month"><?php echo comment_date('M',$comment->comment_ID ); ?>.</span>
                        </time>
                    </div>


                    <div class="entry-title">
                        <a href="<?php echo htmlspecialchars(get_comment_link($comment->comment_ID)) ?>"><?php echo $post->post_title; ?></a>
                    </div>

                    <div class="entry-summary">
                        <p><?php echo wp_trim_words(($comment->comment_content), 10); ?></p>
                        <p> <a href="<?php echo htmlspecialchars(get_comment_link($comment->comment_ID)) ?>"><?php _e( 'Leave a comment', 'crum' );?></a></p>
                    </div>

                </article>


            <?php
            }
        }
    }
    wp_reset_query();
}