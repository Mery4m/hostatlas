<?php
/**
 * Pagination - Show numbered pagination for catalog pages.
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $wp_query;
global $NHP_Options;


if ( $wp_query->max_num_pages <= 1 )
	return;
?>
<?php if($NHP_Options -> get("pagination_style") == '1'):?>
    <nav class="page-nav">
        <?php if (get_next_posts_link()) : ?>
        <span class="older"><?php next_posts_link(__('Older', 'crum')); ?></span>
        <?php endif; ?>
        <?php if (get_previous_posts_link()) : ?>
        <span class="newer"><?php previous_posts_link(__('Newer', 'crum')); ?></span>
        <?php endif; ?>

    </nav>
<?php else : crumin_pagination();
	endif;
?>