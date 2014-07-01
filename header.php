<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" <?php language_attributes(); ?>> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" <?php language_attributes(); ?>> <!--<![endif]-->
<head>

    <?php global $NHP_Options; ?>

    <meta charset="utf-8">

    <title>
        <?php if (is_home() || is_front_page()) {
            bloginfo('name');
        } else {
            wp_title('');
        }?>
    </title>
    <?php  if($NHP_Options->get("custom_favicon")){ ?>
        <link rel="icon" type="image/png" href="<?php $NHP_Options->show("custom_favicon") ?>">
    <?php } ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!--[if lte IE 9]>
    <script src="https://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <link rel="alternate" type="application/rss+xml" title="<?php echo get_bloginfo('name'); ?> Feed" href="<?php echo home_url(); ?>/feed/">

    <?php wp_head(); ?>

    <?php  if (is_page()) {

        global $post;
        $p_bg_color = get_post_meta($post->ID, 'crum_page_custom_bg_color', true);
        $p_bg_image = get_post_meta($post->ID, 'crum_page_custom_bg_image', true);
        $p_bg_fixed = get_post_meta($post->ID, 'crum_page_custom_bg_fixed', true);
        $p_bg_repeat = get_post_meta($post->ID, 'crum_page_custom_bg_repeat', true);
        ?>

        <style type="text/css">
            body {
            <?php if ($p_bg_color && ($p_bg_color !='#ffffff') && ($p_bg_color !='#')){ ?> background-color: <?php echo $p_bg_color; ?>; <?php } ?>
            <?php if ($p_bg_image) { ?> background-image: <?php echo 'url("'.$p_bg_image.'") !important'?>;
                background-position: center 0  !important;
                background-repeat: <?php echo $p_bg_repeat; ?>  !important;
            <?php } if ($p_bg_fixed) { echo 'background-attachment: fixed  !important;'; } ?>
            }

            <?php if ($p_bg_color && $p_bg_image) { ?>
            #change_wrap_div {
                background: #fff;
                max-width: 1220px;
                margin: 0 auto;
                box-shadow: 0 0 6px 0 rgba(0, 0, 0, 0.2);
            }
            <?php } ?>

        </style>
    <?php } ?>
</head>