<?php global $NHP_Options; ?>

<div id="top-panel" class="open">
    <div class="row">
        <div class="top-panel-inner">

            <?php if ($NHP_Options->get("top_panel_login") !='off') {?>

            <div class="three columns">
                <div class="top-login">

                    <?php
                    if ( is_user_logged_in() ) {
                        global $user_login;
                        get_currentuserinfo();
                        $current_user = wp_get_current_user(); ?>

                        <h3><?php _e('Welcome', 'crum'); echo ', ' . $user_login . '!'; ?></h3>
                        <div class="top-avatar">
                            <?php if (($current_user instanceof WP_User)) {
                            echo get_avatar($current_user->user_email, 80);
                        }
                            ?>
                        </div>

                        <div class="links">
                            <?php wp_loginout(); ?>
                        </div>

                    <?php } else { ?>

                        <h3><?php _e('login site', 'crum'); ?></h3>
                        <form name="loginform" id="loginform" action="<?php echo esc_url(site_url('wp-login.php', 'login_post')); ?>" method="post">

                            <input type="text" name="log" id="user_login" class="input" value="" size="20" tabindex="10" placeholder="<?php _e('Enter your login', 'crum'); ?>"/>
                            <input type="password" name="pwd" id="user_pass" class="input" value="" size="20" tabindex="20" placeholder="<?php _e('Enter your password', 'crum'); ?>"/>

                            <div class="links">
                                <?php if (get_option('users_can_register')) { ?>
                                    <a class="reg" href="<?php echo get_option('siteurl'); ?>/wp-login.php?action=register" tabindex="100"><?php _e('Registration', 'crum'); ?></a>
                                <?php } ?>
                                <a class="submit" href="#" name="wp-submit"><?php _e('Press ENTER to login', 'crum'); ?></a>
                                <input type="submit" style="width:0; height: 0; overflow: hidden; padding: 0; border: none" hidden="hidden">
                            </div>
                        </form>

                        <?php } ?>
                </div>
            </div>
            <div class="eight columns offset-by-one top-text">
                <?php } else { ?>
            <div class="twelve columns top-text">
                <?php } ?>

                <div class="icon">
                    <img src="<?php
                    if ($NHP_Options->get("top_panel_icon")) {
                        $NHP_Options->show("top_panel_icon");
                    } else {
                        echo get_template_directory_uri().'/assets/img/icons/top-panel-icon.png';
                    } ?>" alt="">
                </div>

                <div class="subtitle"><?php $NHP_Options->show("top_panel_sub_title"); ?></div>
                <div class="title"><?php $NHP_Options->show("top_panel_title"); ?></div>
                <?php $NHP_Options->show("top_panel_text"); ?>
                <div class="soc-icons">
                    <?php
                    $social_networks = array(
                        "tw"=>"Twitter",
                        "fb"=>"Facebook",
                        "fl"=>"Flickr",
                        "vi"=>"Vimeo",
                        "dr"=>"Dribble",
                        "lf"=>"Last FM",
                        "yt"=>"YouTube",
                        "ms"=>"Microsoft ID",
                        "li"=>"LinkedIN",
                        "gp"=>"Google +",
                        "pi"=>"Picasa",
                        "pt"=>"Pinterest",
                        "wp"=>"Wordpress",
                        "db"=>"Dropbox",
                        "rss"=>"RSS",
                    );
                    foreach($social_networks as $short=>$original){
                        $link = $NHP_Options->get($short."_link");
                        if( $link  !='' && $link  !='http://' )
                            echo '<a href="'.$link .'" class="'.$short.'" title="'.$original.'">'.$original.'</a>';
                    }

                    ?>

                </div>
            </div>
        </div>
        <a id="open-top-panel" href="#">
            <img class="top-panel-closed" src="<?php echo get_template_directory_uri(); ?>/assets/img/plus.gif" alt="open">
            <img class="top-panel-opened" src="<?php echo get_template_directory_uri(); ?>/assets/img/minus.gif" alt="close">
        </a>
    </div>
</div>