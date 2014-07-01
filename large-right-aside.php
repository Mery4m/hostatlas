<?php
/*
Template Name: Large right sidebar
*/
?>


<section id="layout">
    <div class="row">
        <div class="eight columns">
        <?php get_template_part('templates/content', 'page'); ?>
        </div>
        <div class="four columns" style="overflow-x: hidden">
            <?php
            global $post_id;
            if( !isset($post_id))
                $post_id = $post->ID;
            if( !add_user_sidebar( $post_id, 'sidebar_2' ) )
                dynamic_sidebar('sidebar-right');?>
        </div>
    </div>
</section>