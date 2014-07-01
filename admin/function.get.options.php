<?php

global $NHP_Options;



function set_layout($page, $open = true)
{

    global $NHP_Options;
    $page = $NHP_Options->get($page . "_layout");

    if ($page == "1col-fixed") {
        $cr_layout = '';
        $cr_width = 'twelve';
    }
    if ($page == "3c-l-fixed") {
        $cr_layout = 'sidebar-left2';
        $cr_width = 'six';
    }
    if ($page == "3c-r-fixed") {
        $cr_layout = 'sidebar-right2';
        $cr_width = 'six';
    }
    if ($page == "2c-l-fixed") {
        $cr_layout = 'sidebar-left';
        $cr_width = 'nine';
    }
    if ($page == "2c-r-fixed") {
        $cr_layout = 'sidebar-right';
        $cr_width = 'nine';
    }
    if ($page == "3c-fixed") {
        $cr_layout = 'sidebar-both';
        $cr_width = 'six';
    }


    if ($open) {

     // Open content wrapper


        echo '<div class="blog-section ' . $cr_layout . '">';
        echo '<section id="main-content" role="main" class="' . $cr_width . ' columns">';


    } else {

         // Close content wrapper

        echo ' </section>';

        if (($page == "2c-l-fixed") || ($page == "3c-fixed")) {
            get_template_part('templates/sidebar', 'left');
            echo ' </div>';
        }
        if (($page == "3c-l-fixed")){
            get_template_part('templates/sidebar', 'right');
            echo ' </div>';
            get_template_part('templates/sidebar', 'left');
        }
       if ($page == "3c-r-fixed"){
            get_template_part('templates/sidebar', 'left');
            echo ' </div>';
        }
        if (($page == "2c-r-fixed") || ($page == "3c-fixed") || ($page == "3c-r-fixed") ) {
            get_template_part('templates/sidebar', 'right');
        }
    }
}
