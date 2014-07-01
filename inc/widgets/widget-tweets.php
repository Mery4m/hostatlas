<?php
/*
* Latest tweets with PHP widget
*/
class crum_latest_tweets extends WP_Widget
{

    /**
     * Register widget with WordPress.
     */
    public function __construct()
    {
        parent::__construct(
            'twitter-widget', // Base ID
            'Cr: Latest Tweets', // Name
            array('description' => __('Displays your latest Tweets', 'crum'),) // Args
        );
    }

    //widget output
    public function widget($args, $instance) {
        extract($args);

        echo $before_widget;

        if ( isset( $instance[ 'title' ] ) ) {

            $title = $instance[ 'title' ];

        }
        if ( isset( $instance[ 'subtitle' ] ) ) {

            $subtitle = $instance[ 'subtitle' ];
        }


        if ($title) {

            if ( $subtitle ) {
                echo '<div class="subtitle">';
                echo $subtitle;
                echo '</div>';
            }

            echo $before_title;
            echo $title;
            echo $after_title;

        }


        $numTweets      = $instance['tweetstoshow'];               // Number of tweets to display.
        $tweet_name     = $instance['username'];  // Username to display tweets from.
        $excludeReplies = true;             // Leave out @replies
        $transName      = 'crum-widget-tweets';    // Name of value in database.
        $cacheTime      = $instance['cachetime'];                // Time in minutes between updates.
        $backupName = $transName . '-backup';

        if(false === ($tweets = get_transient($transName) ) ) :

            // Get the tweets from Twitter.

            require_once locate_template('/inc/lib/twitteroauth.php');

            if ( !function_exists('getConnectionWithAccessToken')){

                function getConnectionWithAccessToken($cons_key, $cons_secret, $oauth_token, $oauth_token_secret) {
                    $connection = new TwitterOAuth($cons_key, $cons_secret, $oauth_token, $oauth_token_secret);
                    return $connection;
                }
            }

            //check settings and die if not set
            if(empty($instance['consumerkey']) || empty($instance['consumersecret']) || empty($instance['accesstoken']) || empty($instance['accesstokensecret']) || empty($instance['cachetime']) || empty($instance['username'])){
                echo '<strong>Please fill all widget settings!</strong>' . $after_widget;
                return;
            }

            $connection = getConnectionWithAccessToken($instance['consumerkey'], $instance['consumersecret'], $instance['accesstoken'], $instance['accesstokensecret']);

            // If excluding replies, we need to fetch more than requested as the
            // total is fetched first, and then replies removed.

            $totalToFetch = ($excludeReplies) ? max(50, $numTweets * 3) : $numTweets;

            $fetchedTweets = $connection->get(
                'statuses/user_timeline',
                array(
                    'screen_name'     => $tweet_name,
                    'count'           => $totalToFetch,
                    'exclude_replies' => $excludeReplies
                )
            );

            // Did the fetch fail?
            if($connection->http_code != 200) :
                $tweets = get_option($backupName); // False if there has never been data saved.

            else :
                // Fetch succeeded.
                // Now update the array to store just what we need.
                // (Done here instead of PHP doing this for every page load)
                $limitToDisplay = min($numTweets, count($fetchedTweets));

                for($i = 0; $i < $limitToDisplay; $i++) :
                    $tweet = $fetchedTweets[$i];

                    // Core info.
                    $name = $tweet->user->name;
                    $permalink = 'http://twitter.com/'. $name .'/status/'. $tweet->id_str;

                    /* Alternative image sizes method: http://dev.twitter.com/doc/get/users/profile_image/:screen_name */
                    $image = $tweet->user->profile_image_url;

                    // Message. Convert links to real links.
                    $pattern = '/http:(\S)+/';
                    $replace = '<a href="${0}" target="_blank" rel="nofollow">${0}</a>';
                    $text = preg_replace($pattern, $replace, $tweet->text);

                    // Need to get time in Unix format.
                    $time = $tweet->created_at;
                    $time = date_parse($time);
                    $uTime = mktime($time['hour'], $time['minute'], $time['second'], $time['month'], $time['day'], $time['year']);

                    // Now make the new array.
                    $tweets[] = array(
                        'text' => $text,
                        'name' => $name,
                        'permalink' => $permalink,
                        'image' => $image,
                        'time' => $uTime
                    );
                endfor;

                // Save our new transient, and update the backup.
                set_transient($transName, $tweets, 60 * $cacheTime);
                update_option($backupName, $tweets);
            endif;
        endif;

        // Now display the tweets.


foreach($tweets as $t) : ?>
<div class="tweet">
        <?php echo $t['text']; ?>
        <div class="time"><?php echo human_time_diff($t['time'], current_time('timestamp')); ?> <?php _e('ago','crum') ?></div>

    </div>
<?php endforeach;

        echo $after_widget;
    }


    //save widget settings
    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] = strip_tags( $new_instance['title'] );
        $instance['subtitle'] = strip_tags( $new_instance['subtitle'] );
        $instance['consumerkey'] = strip_tags( $new_instance['consumerkey'] );
        $instance['consumersecret'] = strip_tags( $new_instance['consumersecret'] );
        $instance['accesstoken'] = strip_tags( $new_instance['accesstoken'] );
        $instance['accesstokensecret'] = strip_tags( $new_instance['accesstokensecret'] );
        $instance['cachetime'] = strip_tags( $new_instance['cachetime'] );
        $instance['username'] = strip_tags( $new_instance['username'] );
        $instance['tweetstoshow'] = strip_tags( $new_instance['tweetstoshow'] );

        if($old_instance['username'] != $new_instance['username']){
            delete_option('cr_twitter_widget_last_cache_time');
        }

        return $instance;
    }


    //widget settings form
    public function form($instance) {
        $defaults = array( 'title' => '', 'consumerkey' => '', 'consumersecret' => '', 'accesstoken' => '', 'accesstokensecret' => '', 'cachetime' => '', 'username' => '', 'tweetstoshow' => '' );
        $instance = wp_parse_args( (array) $instance, $defaults );

        echo '
				<p><label>Title:</label>
					<input type="text" name="'.$this->get_field_name( 'title' ).'" id="'.$this->get_field_id( 'title' ).'" value="'.esc_attr($instance['title']).'" class="widefat" /></p>

				<p><label>Subtile:</label>
					<input type="text" name="'.$this->get_field_name( 'subtitle' ).'" id="'.$this->get_field_id( 'subtitle' ).'" value="'.esc_attr($instance['subtitle']).'" class="widefat" /></p>

				<p><label>Consumer Key:</label>
					<input type="text" name="'.$this->get_field_name( 'consumerkey' ).'" id="'.$this->get_field_id( 'consumerkey' ).'" value="'.esc_attr($instance['consumerkey']).'" class="widefat" /></p>
				<p><label>Consumer Secret:</label>
					<input type="text" name="'.$this->get_field_name( 'consumersecret' ).'" id="'.$this->get_field_id( 'consumersecret' ).'" value="'.esc_attr($instance['consumersecret']).'" class="widefat" /></p>
				<p><label>Access Token:</label>
					<input type="text" name="'.$this->get_field_name( 'accesstoken' ).'" id="'.$this->get_field_id( 'accesstoken' ).'" value="'.esc_attr($instance['accesstoken']).'" class="widefat" /></p>
				<p><label>Access Token Secret:</label>
					<input type="text" name="'.$this->get_field_name( 'accesstokensecret' ).'" id="'.$this->get_field_id( 'accesstokensecret' ).'" value="'.esc_attr($instance['accesstokensecret']).'" class="widefat" /></p>
				<p><label>Cache Tweets in every:</label>
					<input type="text" name="'.$this->get_field_name( 'cachetime' ).'" id="'.$this->get_field_id( 'cachetime' ).'" value="'.esc_attr($instance['cachetime']).'" class="small-text" /> minutes</p>
				<p><label>Twitter Username:</label>
					<input type="text" name="'.$this->get_field_name( 'username' ).'" id="'.$this->get_field_id( 'username' ).'" value="'.esc_attr($instance['username']).'" class="widefat" /></p>
				<p><label>Tweets to display:</label>
					<select type="text" name="'.$this->get_field_name( 'tweetstoshow' ).'" id="'.$this->get_field_id( 'tweetstoshow' ).'">';
        $i = 1;
        for(i; $i <= 10; $i++){
            echo '<option value="'.$i.'"'; if($instance['tweetstoshow'] == $i){ echo ' selected="selected"'; } echo '>'.$i.'</option>';
        }
        echo '
					</select></p>';
    }
}
