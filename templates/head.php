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

    <?php
        for($i = 1; $i<=6; $i++){
            $font = parse_typo($NHP_Options->get("h" . $i . "_typo"));
            if( $font['family'] != '' && $font['family'] != '.')
                echo "<link href='//fonts.googleapis.com/css?family=".str_replace(" ", "+", $font['family']).":200,300,400,600,700,200italic,300italic,400italic,600italic,700italic&subset=latin,cyrillic' rel='stylesheet' type='text/css'>";
    }
    ?>

    <?php wp_head(); ?>

    <?php  if(is_page()){
        global $post;
        $p_bg_color = get_post_meta( $post->ID, 'crum_page_custom_bg_color', true );
        $p_bg_image = get_post_meta( $post->ID, 'crum_page_custom_bg_image', true );
        $p_bg_fixed = get_post_meta( $post->ID, 'crum_page_custom_bg_fixed', true );
        $p_bg_repeat = get_post_meta( $post->ID, 'crum_page_custom_bg_repeat', true );
    ?>
        <style type="text/css">
            body{
                background: <?php echo $p_bg_color; if ($p_bg_image){ echo ' url('.$p_bg_image.') center 0 '.$p_bg_repeat.';';} ?>
                <?php if ($p_bg_fixed) echo 'background-attachment: fixed;' ?>
            }
            <?php if ($p_bg_image || ($p_bg_color && ($p_bg_color) !='#ffffff')){ ?>#change_wrap_div.white-skin {background:#fff; max-width: 1220px; margin: 0 auto; box-shadow: 0 0 6px 0 rgba(0, 0, 0, 0.2); <?php } ?>
        </style>
    <?php } ?>
</head>

