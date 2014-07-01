<?php global $NHP_Options;

if($NHP_Options->get("footer_tw_disp")){ ?>

<section id="top-footer">
    <div class="row">
        <div class="twitter-row">
            <div class="eight columns">
                <div class="icon"></div>

            <?php

            $numTweets      = $NHP_Options->get("numb_lat_tw");               // Number of tweets to display.
            $tweet_name     = $NHP_Options->get("username");  // Username to display tweets from.
            $excludeReplies = true;             // Leave out @replies
            $transName      = 'crum-foot-tweets';    // Name of value in database.
            $cacheTime      = $NHP_Options->get("cachetime");                // Time in minutes between updates.
            $backupName = $transName . '-backup';

            // Do we already have saved tweet data? If not, lets get it.
            if(false === ($tweets = get_transient($transName) ) ) :

                // Get the tweets from Twitter.

                require_once locate_template('/inc/lib/twitteroauth.php');

                if ( !function_exists('getConnectionWithAccessToken')){

                        function getConnectionWithAccessToken($cons_key, $cons_secret, $oauth_token, $oauth_token_secret) {
                        $connection = new TwitterOAuth($cons_key, $cons_secret, $oauth_token, $oauth_token_secret);
                        return $connection;
                    }
                }

                $connection = getConnectionWithAccessToken(
                    $NHP_Options->get("twiiter_consumer"),	// Consumer Key
                    $NHP_Options->get("twiiter_con_s"),   	// Consumer secret
                    $NHP_Options->get("twiiter_acc_t"),       // Access token
                    $NHP_Options->get("twiiter_acc_t_s")    	// Access token secret
                );


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



            ?>
            <div class="tw-slider">
                <ul class="twitter_box slides">
                    <?php foreach($tweets as $t) : ?>
                        <li class="twitter-item">
                            <?php echo $t['text']; ?>
                            <div class="date"><?php echo human_time_diff($t['time'], current_time('timestamp')); ?> <?php _e('ago','crum') ?></div>

                        </li>
                    <?php endforeach; ?>

                </ul>
            </div>



            </div>
            <div class="four columns nav">

                <a href="https://twitter.com/<?php $NHP_Options->show("username") ?>" class="twitter-follow-button" data-show-count="false" data-lang="en">Follow @<?php $NHP_Options->show("username") ?></a>
                <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
                
            </div>
        </div>
    </div>
</section>

<script type="text/javascript">
    jQuery(window).load(function() {
        jQuery('#top-footer .tw-slider').flexslider({
            animation: "slide",
            namespace: "twitt-",
            controlsContainer: "#top-footer .columns.nav",
            controlNav: false,               //Boolean: Create navigation for paging control of each clide? Note: Leave true for manualControls usage
            directionNav: true,             //Boolean: Create navigation for previous/next navigation? (true/false)
            prevText: "",           //String: Set the text for the "previous" directionNav item
            nextText: ""
        });
    });
</script>

<?php } ?>