<?php


class counter_widget extends WP_Widget {

    function counter_widget() {
        $widget_ops = array( 'classname' => 'counter-widget', 'description' => ''  );
        $control_ops = array( 'width' => 250, 'height' => 350, 'id_base' => 'counter-widget' );
        $this->WP_Widget( 'counter-widget','Cr: Social Counter', $widget_ops, $control_ops );
    }

    function widget( $args, $instance ) {

        $facebook_page = $instance['facebook'] ;
        $rss_id = $instance['rss'] ;
        $twitter_id =  $instance['twitter'];
        $youtube_url = $instance['youtube'] ;
        $vimeo_url = $instance['vimeo'] ;
        $dribbble_url = $instance['dribbble'];
        $new_window = $instance['new_window'];

        if( $new_window ) $new_window =' target="_blank" ';
        else $new_window ='';


        ?>

<section class="widget">
    <div class="follow-widget">

        <?php if( $rss_id ): ?>
            <a href="<?php echo $rss_id ?>"<?php echo $new_window ?>  class="rss">
                <img class="icon" src="<?php echo get_template_directory_uri();?>/assets/img/share/rss.png" alt="ico">
                <span class="number"><?php _e('Subscribe' , 'crum' ) ?><?php __('Subscribers' , 'crum' ) ?></span>
                <span class="text"><?php _e('To RSS Feed' , 'crum' ) ?></span>
            </a>
        <?php endif; ?>



        <?php if( $twitter_id ):
        $twitter = tie_followers_count(); ?>
        <a href="<?php echo $twitter['page_url'] ?>"<?php echo $new_window ?> class="tw">
            <img class="icon" src="<?php echo get_template_directory_uri();?>/assets/img/share/twitter.png" alt="ico">

            <span class="number"><?php echo @number_format($twitter['followers_count']) ?></span>
            <span class="text"><?php _e('followers' , 'crum' ) ?></span>
        </a>
        <?php endif; ?>

        <?php if( $facebook_page ):
        $facebook = tie_facebook_fans( $facebook_page ); ?>
        <a href="<?php echo $facebook_page ?>"<?php echo $new_window ?> class="fb">
            <img class="icon" src="<?php echo get_template_directory_uri();?>/assets/img/share/fb.png" alt="ico">

            <span class="number"><?php echo @number_format( $facebook ) ?></span>
            <span class="text"><?php _e('fans' , 'crum' ) ?></span>
        </a>
        <?php endif; ?>

        <?php if( $youtube_url ):
        $youtube = tie_youtube_subs( $youtube_url ); ?>
        <a href="<?php echo $youtube_url ?>"<?php echo $new_window ?> class="yt">
            <img class="icon" src="<?php echo get_template_directory_uri();?>/assets/img/share/youtube.png" alt="ico">

            <span class="number"><?php echo @number_format( $youtube ) ?></span>
            <span class="text"><?php _e('followers' , 'crum' ) ?></span>
        </a>
        <?php endif; ?>
        <?php if( $vimeo_url ):
        $vimeo = tie_vimeo_count( $vimeo_url ); ?>
        <a href="<?php echo $vimeo_url ?>"<?php echo $new_window ?> class="vi">
            <img class="icon" src="<?php echo get_template_directory_uri();?>/assets/img/share/vimeo.png" alt="ico">

            <span class="number"><?php echo @number_format( $vimeo ) ?></span>
            <span class="text"><?php _e('subscribers' , 'crum' ) ?></span>
        </a>
        <?php endif; ?>
        <?php if( $dribbble_url ):
        $dribbble = tie_dribbble_count( $dribbble_url ); ?>

        <a href="<?php echo $dribbble_url ?>"<?php echo $new_window ?> class="dr">
            <img class="icon" src="<?php echo get_template_directory_uri();?>/assets/img/share/dribble.png" alt="ico">

            <span class="number"><?php echo @number_format( $dribbble ) ?></span>
            <span class="text"><?php _e('followers' , 'crum' ) ?></span>
        </a>
        <?php endif; ?>

    </div>

        </section>

    <?php
    }

    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['new_window'] = strip_tags( $new_instance['new_window'] );
        $instance['facebook'] = $new_instance['facebook'] ;
        $instance['twitter'] =  $new_instance['twitter'] ;
        $instance['rss'] =  $new_instance['rss'] ;
        $instance['youtube'] = $new_instance['youtube'] ;
        $instance['vimeo'] =  $new_instance['vimeo'] ;
        $instance['dribbble'] =  $new_instance['dribbble'] ;
        return $instance;
    }

    function form( $instance ) { ?>
    <p>
        <label for="<?php echo $this->get_field_id( 'new_window' ); ?>">Open links in a new window:</label>
        <input id="<?php echo $this->get_field_id( 'new_window' ); ?>" name="<?php echo $this->get_field_name( 'new_window' ); ?>" value="true" <?php if( $instance['new_window'] ) echo 'checked="checked"'; ?> type="checkbox" />
    </p>
    <p>
        <label for="<?php echo $this->get_field_id( 'rss' ); ?>">Feed URL : </label>
        <input id="<?php echo $this->get_field_id( 'rss' ); ?>" name="<?php echo $this->get_field_name( 'rss' ); ?>" value="<?php echo $instance['rss']; ?>" class="widefat" type="text" />
    </p>
    <p>
        <label for="<?php echo $this->get_field_id( 'facebook' ); ?>">Facebook Page URL : </label>
        <input id="<?php echo $this->get_field_id( 'facebook' ); ?>" name="<?php echo $this->get_field_name( 'facebook' ); ?>" value="<?php echo $instance['facebook']; ?>" class="widefat" type="text" />
        <small>Link must be like http://www.facebook.com/username/ or http://www.facebook.com/PageID/</small>

    </p>
    <p>
        <label for="<?php echo $this->get_field_id( 'twitter' ); ?>">Enable Twitter : </label>
        <input id="<?php echo $this->get_field_id( 'twitter' ); ?>" name="<?php echo $this->get_field_name( 'twitter' ); ?>"  value="true" <?php if( $instance['twitter'] ) echo 'checked="checked"'; ?> type="checkbox"  />
        <small><em style="color:red;">Make sure you Setup Twitter API OAuth settings under Theme options > Advanced </em></small>
    </p>
    <p>
        <label for="<?php echo $this->get_field_id( 'youtube' ); ?>">Youtube Channel URL : </label>
        <input id="<?php echo $this->get_field_id( 'youtube' ); ?>" name="<?php echo $this->get_field_name( 'youtube' ); ?>" value="<?php echo $instance['youtube']; ?>" class="widefat" type="text" />
        <small>Link must be like http://www.youtube.com/user/username </small>

    </p>
    <p>
        <label for="<?php echo $this->get_field_id( 'vimeo' ); ?>">Vimeo Channel URL : </label>
        <input id="<?php echo $this->get_field_id( 'vimeo' ); ?>" name="<?php echo $this->get_field_name( 'vimeo' ); ?>" value="<?php echo $instance['vimeo']; ?>" class="widefat" type="text" />
        <small>Link must be like http://vimeo.com/channels/username </small>

    </p>
    <p>
        <label for="<?php echo $this->get_field_id( 'dribbble' ); ?>">dribbble Page URL : </label>
        <input id="<?php echo $this->get_field_id( 'dribbble' ); ?>" name="<?php echo $this->get_field_name( 'dribbble' ); ?>" value="<?php echo $instance['dribbble']; ?>" class="widefat" type="text" />
        <small>Link must be like http://dribbble.com/username</small>

    </p>


    <?php
    }
}
