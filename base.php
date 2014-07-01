<?php

if (!(isset($_SESSION) &&  is_array($_SESSION))) {
    session_start();
}

get_header(); ?>

<?php global $NHP_Options;?>

<body <?php body_class(''); ?> >


<div id="change_wrap_div" class="  <?php
if ($NHP_Options->get("color_version_site")=='dark-skin') {echo ' dark-skin'; } else {echo ' white-skin';}
if ($NHP_Options->get("site_boxed")) {echo ' boxed_lay'; }
?>">


    <?php
    if ($NHP_Options->get("top_panel")) {
        get_template_part('templates/section','panel');
    } ?>

    <?php get_template_part('templates/section','header'); ?>

        <?php include crum_template_path(); ?>

    <?php

    get_footer();
?>

</body>
</html>
