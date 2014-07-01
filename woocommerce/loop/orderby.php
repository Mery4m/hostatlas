<?php
/**
 * Show options for ordering
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $woocommerce, $wp_query;

if ( 1 == $wp_query->found_posts || ! woocommerce_products_will_display() )
	return;
?>

<div class="product-ordering">
    <?php _e('Sort by:','crum')?>
    <a href="?orderby=popularity"><?php echo __( 'Sort by popularity', 'woocommerce' ) ?></a>
    <a href="?orderby=date"><?php echo __( 'Sort by newness', 'woocommerce' ) ?></a>
    <a href="?orderby=price"><?php echo __( 'Sort by price: low to high', 'woocommerce' ) ?></a>
    <a href="?orderby=price-desc"><?php echo __( 'Sort by price: high to low', 'woocommerce' ) ?></a>

</div>

