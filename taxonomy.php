
<?php get_template_part('templates/top','page'); ?>

<section id="layout">
    <div class="row">

<?php global $NHP_Options;

    if (!have_posts()) : ?>

        <div class="alert">
            <?php _e('Sorry, no results were found.', 'crum'); ?>
        </div>
        <?php get_search_form(); ?>
        <?php endif; ?>

<?php while (have_posts()) : the_post();

        get_template_part('templates/portfolio', 'item');

      endwhile;

crum_select_pagination();
?>



    </div>
</section>