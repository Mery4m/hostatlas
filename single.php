<?php get_template_part('templates/top', 'page'); ?>

<section id="layout">
    <div class="row">

        <?php

        $single_laysel = get_post_meta($post->ID, 'full_width_post', true);

        if (!$single_laysel || $single_laysel == 'default') {

            set_layout('single', true);

            get_template_part('templates/content', 'single');

            set_layout('single', false);

        } else {

            if ($single_laysel == "1col-fixed") {
                $cr_layout = '';
                $cr_width = 'twelve';
            }
            if ($single_laysel == "3c-l-fixed") {
                $cr_layout = 'sidebar-left2';
                $cr_width = 'six';
            }
            if ($single_laysel == "3c-r-fixed") {
                $cr_layout = 'sidebar-right2';
                $cr_width = 'six';
            }
            if ($single_laysel == "2c-l-fixed") {
                $cr_layout = 'sidebar-left';
                $cr_width = 'nine';
            }
            if ($single_laysel == "2c-r-fixed") {
                $cr_layout = 'sidebar-right';
                $cr_width = 'nine';
            }
            if ($single_laysel == "3c-fixed") {
                $cr_layout = 'sidebar-both';
                $cr_width = 'six';
            }

            echo '<div class="blog-section ' . $cr_layout . '">';
            echo '<section id="main-content" role="main" class="' . $cr_width . ' columns">';


            get_template_part('templates/content', 'single');


            echo ' </section>';


            if (($single_laysel == "2c-l-fixed") || ($single_laysel == "3c-fixed")) {

                get_template_part('templates/sidebar', 'left');

                echo ' </div>';
            }

            if (($single_laysel == "3c-l-fixed")) {

                get_template_part('templates/sidebar', 'right');

                echo ' </div>';

                get_template_part('templates/sidebar', 'left');

            }

            if ($single_laysel == "3c-r-fixed") {

                get_template_part('templates/sidebar', 'left');

                echo ' </div>';

            }

            if (($single_laysel == "2c-r-fixed") || ($single_laysel == "3c-fixed") || ($single_laysel == "3c-r-fixed")) {
                get_template_part('templates/sidebar', 'right');

            }
        }

        ?>

    </div>
</section>

