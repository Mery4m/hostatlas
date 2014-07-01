<?php
/**
 * Duplicated and tweaked WP core Categories widget class
 */
class crum_icon_categories extends WP_Widget {

    function __construct() {
        $widget_ops = array( 'classname' => 'category-widget', 'description' => __( "A list of categories, with slightly tweaked output.", 'crum'  ) );
        parent::__construct( 'categories_custom', __( 'Theme: Categories list with icons', 'crum' ), $widget_ops );
    }

    function widget( $args, $instance ) {
        extract( $args );

        $title = apply_filters( 'widget_title', empty( $instance['title'] ) ? __( 'Blog categories', 'crum'  ) : $instance['title'], $instance, $this->id_base);

        if ( isset( $instance[ 'subtitle' ] ) ) {

            $subtitle = $instance[ 'subtitle' ];
        }

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

        } ?>

    <ul>

        <?php

        $cat_selected = json_decode($instance['cat_sel']);
        if(count($cat_selected)>0)
            $categ = implode(',', $cat_selected);

        $args = array(
            'type'      => 'post',
            'orderby'   => 'id',
            'hierarchical'   => 'false',
            'taxonomy'       => $categ,
        );
        $categories = get_categories( $args );

            foreach($categories as $category){

                $saved_data = get_tax_meta($term_id,'crum_cat_ico_img');

                ?>

            <li>
                <a href="<?php echo $category_link = get_category_link( $category->cat_ID ); ?>">
                    <span class="styled-icon" style="background: url('<?php echo '<img src="'.$saved_data['src'].'" alt="">'; ?>')"></span>
                    <span class="category-border"><?php echo $category->name; ?> (<?php echo $category->count; ?>)</span>
                </a>
            </li>


    </ul>
    <?php
        echo $after_widget;
    }
    }

    function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $instance['title'] = strip_tags( $new_instance['title'] );
        $instance['subtitle'] = strip_tags( $new_instance['subtitle'] );
        $instance['count'] = 1;
        $instance['cat_sel'] = json_encode($new_instance['cat_sel'], true);

        return $instance;
    }

    function form( $instance ) {
        //Defaults
        $instance = wp_parse_args( (array) $instance, array( 'title' => '') );
        $title = esc_attr( $instance['title'] );
        $subtitle = $instance['subtitle'];
        $count = true;
        $cat_selected = json_decode($instance['cat_sel']);
        ?>
    <p>
      <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'crum' ); ?></label>
      <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>"/>
    </p>
    <p>
      <label for="<?php echo $this->get_field_id('subtitle'); ?>"><?php _e('Subtitle:', 'crum' ); ?></label>
      <input class="widefat" id="<?php echo $this->get_field_id('subtitle'); ?>" name="<?php echo $this->get_field_name('subtitle'); ?>" type="text" value="<?php echo esc_attr($subtitle); ?>"/>
    </p>

    <input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id('count'); ?>" name="<?php echo $this->get_field_name('count'); ?>"<?php checked( $count ); ?> disabled="disabled" />
    <label for="<?php echo $this->get_field_id('count'); ?>"><?php _e( 'Show post counts', 'crum'  ); ?></label>

    <label for="<?php echo $this->get_field_id( 'cat_sel' ); ?>"><?php _e( 'Select Taxonomy', 'crum' ); ?></label>
    <select class="widefat" id="<?php echo $this->get_field_id( 'cat_sel' ); ?>" name="<?php echo $this->get_field_name( 'cat_sel' );?>[ <?php $cat_sel ?>]" multiple="multiple"  >

        <?php

        $taxonomies=get_taxonomies();
        foreach ($taxonomies as $taxonomy ) {

            $cat_sel = (is_array($cat_selected) && in_array($taxonomy->label, $cat_selected))?' selected="selected"':'';
            echo '<option class="widefat" value="'.$taxonomy->label.'"'.$cat_sel.'>'.$taxonomy->name.'</option>';
        }?>

    </select>
    <?php
    }


}