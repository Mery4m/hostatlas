<section id="sub-footer">
    <div class="row">
        <div class="six mobile-two columns copyr">
            <?php
                global $NHP_Options;
                echo $NHP_Options->get("copyright_footer");
             ?>
        </div>
        <div class="six mobile-two columns">

            <?php wp_nav_menu(array('theme_location' => 'footer_menu', 'container' => 'nav', 'fallback_cb' => 'false', 'menu_class' => 'footer-menu')); ?>

        </div>
    </div>
</section>