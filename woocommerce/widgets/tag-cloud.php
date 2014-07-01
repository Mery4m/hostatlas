<?php
/**
 * Tag Cloud Widget
 *
 * @author 		WooThemes
 * @category 	Widgets
 * @package 	WooCommerce/Widgets
 * @version 	1.6.4
 * @extends 	WP_Widget
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class crum_WC_Widget_Product_Tag_Cloud extends WP_Widget {

    var $woo_widget_cssclass;
    var $woo_widget_description;
    var $woo_widget_idbase;
    var $woo_widget_name;

    /**
     * constructor
     *
     * @access public
     * @return void
     */
    function crum_WC_Widget_Product_Tag_Cloud() {

        /* Widget variable settings. */
        $this->woo_widget_cssclass = 'tags-widget';
        $this->woo_widget_description = __( 'Your most used product tags in cloud format.', 'woocommerce' );
        $this->woo_widget_idbase = 'crum_woocommerce_product_tag_cloud';
        $this->woo_widget_name = __( 'WooCommerce Product Tags', 'woocommerce' );

        /* Widget settings. */
        $widget_ops = array( 'classname' => $this->woo_widget_cssclass, 'description' => $this->woo_widget_description );

        /* Create the widget. */
        $this->WP_Widget('product_tag_cloud', $this->woo_widget_name, $widget_ops);
    }

    /**
     * widget function.
     *
     * @see WP_Widget
     * @access public
     * @param array $args
     * @param array $instance
     * @return void
     */
    function widget( $args, $instance ) {
        extract($args);
        $current_taxonomy = $this->_get_current_taxonomy($instance);
        if ( !empty($instance['title']) ) {
            $title = $instance['title'];
        }
        if ( isset( $instance[ 'subtitle' ] ) ) {

            $subtitle = $instance[ 'subtitle' ];
        }

        else {
            if ( 'product_tag' == $current_taxonomy ) {
                $title = __('Product Tags', 'woocommerce' );
            } else {
                $tax = get_taxonomy($current_taxonomy);
                $title = $tax->labels->name;
            }
        }
        $title = apply_filters('widget_title', $title, $instance, $this->id_base);


        echo $before_widget;

        if ($title) {

            if ( $subtitle ) {
                echo '<div class="subtitle">';
                echo $subtitle;
                echo '</div>';
            }

            echo $before_title;
            echo $title;
            echo $after_title;

        }

        echo '<div class="tagcloud">';
        wp_tag_cloud( apply_filters('woocommerce_product_tag_cloud_widget_args', array('taxonomy' => $current_taxonomy, 'smallest'=>'10', 'largest'=>'10') ) );
        echo "</div>\n";
        echo $after_widget;
    }

    /**
     * update function.
     *
     * @see WP_Widget->update
     * @access public
     * @param array $new_instance
     * @param array $old_instance
     * @return array
     */
    function update( $new_instance, $old_instance ) {
        $instance['title'] = isset( $new_instance['title'] ) ? strip_tags( stripslashes( $new_instance['title'] ) ) : '';
        $instance['taxonomy'] = isset( $new_instance['taxonomy'] ) ? stripslashes( $new_instance['taxonomy'] ) : '';
        $instance['subtitle'] = strip_tags( $new_instance['subtitle'] );
        return $instance;
    }

    /**
     * form function.
     *
     * @see WP_Widget->form
     * @access public
     * @param array $instance
     * @return void
     */
    function form( $instance ) {
        $current_taxonomy = $this->_get_current_taxonomy($instance);
        ?>

    <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e( 'Title:', 'crum' ) ?></label>
        <input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id('title') ); ?>" name="<?php echo esc_attr( $this->get_field_name('title') ); ?>" value="<?php if (isset ( $instance['title'])) {echo esc_attr( $instance['title'] );} ?>" /></p>

    <p><label for="<?php echo $this->get_field_id('subtitle'); ?>"><?php _e( 'Subtitle:', 'crum' ) ?></label>
        <input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id('subtitle') ); ?>" name="<?php echo esc_attr( $this->get_field_name('subtitle') ); ?>" value="<?php if (isset ( $instance['subtitle'])) {echo esc_attr( $instance['subtitle'] );} ?>" /></p>
    <?php
    }

    function _get_current_taxonomy($instance) {
        return 'product_tag';
    }
}