
<?php global $NHP_Options; ?>

<section id="header" <?php if ($NHP_Options->get("header_variant") != 'v2') { echo 'class="horizontal"'; } ?> >

<div class="row">

    <div class="twelve columns">

        <?php if ($NHP_Options->get("logotype_style") != 'no') {

            echo '<div id="logo">';

        if ($NHP_Options->get("logotype_style") == 'txt') {
            ?>
            <h1><a href="<?php echo home_url(); ?>/"><?php $NHP_Options->show("custom_logo_text"); ?></a></h1>
            <?php } else { ?>
            <a href="<?php echo home_url(); ?>/"><img src="<?php $NHP_Options->show("custom_logo_image"); ?>" alt="<?php bloginfo('name'); ?>"></a>
            <?php
        }
        echo'</div>';

    } ?>

        <a href="#" class="top-menu-button"></a>

        <?php
        wp_nav_menu(array('theme_location' => 'primary_navigation', 'container' => 'nav', 'container_id' => 'top-menu', 'container_class' => 'fake', 'walker' => new Roots_Alt_Walker));

        if ($NHP_Options->get("top_adress_block") != 'off') { ?>
            <div id="top-info">
                <address>
                    <?php $NHP_Options->show("top_adress_field"); ?>
                </address>

                <?php  if ($NHP_Options->get("lang_shortcode")) { ?>
                    <?php echo do_shortcode($NHP_Options->get("lang_shortcode")) ; ?>
                <?php } ?>
                <?php  if ($NHP_Options->get("wpml_lang_show")) { ?>
                    <?php do_action('icl_language_selector'); ?>
                <?php } ?>


            </div>
            <?php }
        ?>


        <form role="search" method="get" id="searchform" class="form-search" action="<?php echo home_url(); ?>/">
            <label class="hide" for="s">Search for:</label>
            <input type="text" value="" name="s" id="s" class="s-field" placeholder="Enter request...">
            <input type="submit" id="searchsubmit" value=" " class="s-submit">
        </form>

        </div>

        <div class="twelve columns ">
            <div class="head-bott">

                <div class="soc-head-icons">

                    <?php
                    $social_networks = array(
                        "fb"=>"Facebook",
                        "gp"=>"Google +",
                        "tw"=>"Twitter",
                        "pt"=>"Pinterest",
                        "tu"=>"Tumblr",
                        "dr"=>"Dribble",
                        "li"=>"LinkedIN",
                        "fl"=>"Flickr",
                        "vi"=>"Vimeo",
                        "lf"=>"Last FM",
                        "yt"=>"YouTube",
                        "ms"=>"Microsoft ID",
                        "wp"=>"Wordpress",
                        "db"=>"Dropbox",
                        "rss"=>"RSS",
                    );
                    foreach($social_networks as $short=>$original){
                        $link = $NHP_Options->get($short."_link");
                        $show = $NHP_Options->get($short."_show");
                        if( $link  !='' && $link  !='http://' && $show =='1' )
                            echo '<a href="'.$link .'" class="'.$short.'" title="'.$original.'">'.$original.'</a>';
                    }
                    ?>
                </div>
            </div>
        </div>

    </div>

</section>