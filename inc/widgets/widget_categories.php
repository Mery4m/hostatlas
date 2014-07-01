<?php
/**
 * Duplicated and tweaked WP core Categories widget class
 */
class crum_icon_categories extends WP_Widget {

	public function __construct() {
		$widget_ops = array( 'classname' => 'category-widget', 'description' => __( 'A list of categories', 'crum'  ) );
		parent::__construct( 'categories_custom', __( 'Cr: Categories with icons', 'crum' ), $widget_ops );
	}

	function menu_list($cat_name, $cat, $img, $data){
		?>
		<li>

			<a href="<?php echo $category_link = get_term_link($cat->slug, $cat_name); ?>">

				<?php if ($cat_name == 'product_cat'){ ?>
					<span class="styled-icon" style="background: url('<?php echo $img; ?>')"></span>
				<?php } else{ ?>
					<span class="styled-icon" style="background: url('<?php echo $data['src']; ?>')"></span>
				<?php } ?>
				<span class="category-border"><?php echo $cat->name; ?></span>
			</a>
		</li>
	<?php
	}

	public function widget( $args, $instance ) {
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

			$categ = $instance['cat_sel'];

			$categ = str_replace(array('["', '"]'),'',$categ);

			$selection = $instance['custom_cat_sel'];

			if ($categ == 'category' && !($selection == '')){

				foreach($selection as $cat_slug){
					$category = get_term_by('slug',$cat_slug, $categ);
					if ($categ == 'product_cat'){
						$image 			= '';

						$thumbnail_id 	= absint( get_woocommerce_term_meta( $category->term_id, 'thumbnail_id', true ) );
						if ($thumbnail_id) :
							$image = wp_get_attachment_url( $thumbnail_id );
						else :
							$image = woocommerce_placeholder_img_src();
						endif;
					}
					$saved_data = get_tax_meta($category-> term_id, 'crum_cat_ico_img');

					$this ->menu_list($categ, $category, $image, $saved_data);
				}
			}else{
				$args = array(
					'orderby'   => 'id',
					'hierarchical'   => 'false',
					'taxonomy'       => $categ
				);
				$categories = get_terms($categ, $args );
				foreach($categories as $category){
					if ($categ == 'product_cat'){
						$image 			= '';
						$thumbnail_id 	= absint( get_woocommerce_term_meta( $category->term_id, 'thumbnail_id', true ) );
						if ($thumbnail_id) :
							$image = wp_get_attachment_url( $thumbnail_id );
						else :
							$image = woocommerce_placeholder_img_src();
						endif;
					}
					$saved_data = get_tax_meta($category->term_id, 'crum_cat_ico_img');

					$this ->menu_list($categ, $category, $image, $saved_data);

				}
			}
			?>
		</ul>
		<?php

		echo $after_widget;

	}

	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = ( $new_instance['title'] );
		$instance['subtitle'] = ( $new_instance['subtitle'] );
		$instance['cat_sel'] = $new_instance['cat_sel'];
		$instance['custom_cat_sel'] = esc_sql($new_instance['custom_cat_sel']);

		return $instance;
	}

	public function form( $instance ) {
		//Defaults
		$instance = wp_parse_args( (array) $instance, array( 'title' => '') );
		$title = esc_attr( $instance['title'] );
		$subtitle = $instance['subtitle'];
		$cat_selected = $instance['cat_sel'];
		$custom_select = $instance['custom_cat_sel'];

		?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'crum' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>"/>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('subtitle'); ?>"><?php _e('Subtitle:', 'crum' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('subtitle'); ?>" name="<?php echo $this->get_field_name('subtitle'); ?>" type="text" value="<?php echo esc_attr($subtitle); ?>"/>
		</p>

		<?php

		$args=array(
		);

		$output = 'objects'; // or objects
		$taxonomies=get_taxonomies($args,$output);
		if  ($taxonomies) { ?>

			<label for="<?php echo $this->get_field_id( 'cat_sel' ); ?>"><?php _e( 'Select Taxonomy', 'crum' ); ?></label>
			<select class="widefat" id="<?php echo esc_attr($this->get_field_id( 'cat_sel' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'cat_sel' ));?>"  >

				<?php
				foreach ($taxonomies as $taxonomy ) {
					if($cat_selected == $taxonomy->name){$cat_sel =' selected="selected"';} else { $cat_sel ='';}
					echo '<option class="widefat" value="'.esc_attr($taxonomy->name).'"'.esc_attr($cat_sel).'>'.esc_attr($taxonomy->label).'</option>';
				}?>

			</select>

			<?php
			if ($cat_selected == 'category'): ?>
			<?php
			$args = array(
				'orderby' => 'name',
				'hide_empty' => '1',
				'parent' => '0',
			);
			$categories = get_categories($args);

			if ( $categories ) {
				printf(
					'<select class="widefat" multiple="multiple" name="%s[]" id="%s" class="widefat">',
					$this->get_field_name('custom_cat_sel'),
					$this->get_field_id('custom_cat_sel')
				);

				foreach ( $categories as $list ) {

					printf(
						'<option class="widefat" value="%s" %s >%s</option>',
						$list->slug,
						in_array( $list->slug, $custom_select) ? 'selected="selected"' : '',
						$list->name
					);

				}
				echo '</select>';
			}
			 endif;
		}
	}

}