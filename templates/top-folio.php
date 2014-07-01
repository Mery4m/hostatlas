<div class="row">
    <div class="twelve columns">
        <div id="page-title">
            <a href="javascript:history.back()" class="back"></a>
            <div class="page-title-inner">

                <h1 class="page-title">
                    <?php $term = get_term_by('slug', get_query_var('term'), get_query_var('taxonomy'));

                    global $NHP_Options;
                    $page = $NHP_Options->get("portfolio_page_select");
                    $title = get_the_title($page);

                    if ($term) {
                        echo $term->name;
                    } elseif (is_post_type_archive()) {
                        echo get_queried_object()->labels->name;
                    } else {
                        the_title();
                    } ?>
                    </h1>

                <div class="breadcrumbs">
                    <nav id="crumbs" xmlns:v="http://rdf.data-vocabulary.org/#"><span typeof="v:Breadcrumb"><a rel="v:url" property="v:title"  href="<?php echo home_url(); ?>/"><?php _e('Home', 'crum') ?></a></span> <span class="del">·</span> <span typeof="v:Breadcrumb"><a rel="v:url" property="v:title" href="<?php echo home_url() . '/' . the_slug($page); ?>/"><?php echo $title; ?></a></span> <span class="del">·</span> <?php the_title(); ?></nav>

                </div>
            </div>

                <?php while (have_posts()) : the_post(); ?>
                <?php
					if($NHP_Options -> get("pagination_style") == '1'):
						echo '<nav class="page-nav">';
						if (get_next_posts_link()) :
							echo '<span class="older"> ';
							next_posts_link(__('Older', 'crum'));
							echo ' </span>';
						endif;
						if (get_previous_posts_link()) :
							echo '<span class="newer">';
							previous_posts_link(__('Newer', 'crum'));
							echo '</span>';
						endif;

						echo '</nav>';
					else : crumin_pagination();
					endif;
				?>
                <?php endwhile; ?>
        </div>
    </div>
</div>