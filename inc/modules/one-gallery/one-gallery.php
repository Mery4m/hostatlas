<?php

/*
Plugin Name: Galleries block
Plugin URI: #
Description: Display Galleries thumbnails
Author: Crumina
Version: 1
Author URI: #
*/


/**
 * Accordion
 */
class crum_one_gallery_widget extends WP_Widget {

	public function __construct() {
		parent::__construct(
			  'crum_one_gallery_widget', // Base ID
				  'Box: One gallery', // Name
				  array( 'description' => __( 'Display Gallery thumbnails', 'crum' ), 'classname' => 'recent-projects-block' ) // Args
		);
	}


    public function widget( $args, $instance ) {

        //get theme options

        if ( isset( $instance[ 'title' ] ) ) {

            $title = $instance[ 'title' ];

        } else {

            $title = __( 'Latest articles', 'crum' );

        }
        if ( isset( $instance[ 'subtitle' ] ) ) {

            $subtitle = $instance[ 'subtitle' ];
        }

        extract( $args );

        $link = $instance['link'];
        $link_label = $instance['link_label'];
        $post_order = $instance['post_order'];
        $numb_col = $instance['numb_col'];
		$item = $instance['item'];


        /* show the widget content without any headers or wrappers */

        echo $before_widget;

        if ($title) {

            if ( $subtitle ) {
                echo '<div class="subtitle">';
                echo $subtitle;
                echo '</div>';
            }

            echo $before_title;
            echo $title;
            if ($link) { echo '<span class="extra-links"><a href="'.$link.'">'.$link_label.'</a></span>';}
            echo $after_title;

        }

        /*
         * Number of columns
         */

        if ($numb_col == '1'){
            $class="twelve";
        }if ($numb_col == '2'){
            $class="six";
        }if ($numb_col == '3'){
            $class="four";
        }if ($numb_col == '4'){
            $class="three";
        }


        echo '<div class="row"><ul>';

        $args = array(
            'order' => $post_order,
            'post_type' => 'attachment',
            'post_parent' => $item,
            'post_mime_type' => 'image',
            'post_status' => 'inherit',
            'numberposts' => $numb_col,
        );
        $attachments = get_posts($args);

        if ($attachments) {
            foreach ($attachments as $attachment) {
                $img_url =  wp_get_attachment_url($attachment->ID); //get img URL

				if ($numb_col == '1'){
					$article_image = aq_resize($img_url, 1200, 295, true);
				}if ($numb_col == '2'){
					$article_image = aq_resize($img_url, 570, 295, true);
				}if ($numb_col == '3'){
					$article_image = aq_resize($img_url, 400, 195, true);
				}if ($numb_col == '4'){
					$article_image = aq_resize($img_url, 280, 195, true);
				}

                ?>


                <li class="<?php echo $class ?> columns" style="position: relative"> <div class="hover">

                    <a href="<?php echo $img_url; ?>" title="<?php the_title(); ?>" class="more-link zoom" rel="prettyPhoto[pp_gal]">

                    <img src="<?php echo $article_image ?>" alt="<?php the_title(); ?>"/>

                    </a>
                </div>

                </li>


            <?php  }
        }
        echo '</ul></div>';

        echo $after_widget;

    }

    public function update( $new_instance, $old_instance ) {

        $instance = $old_instance;

        $instance['title'] = strip_tags( $new_instance['title'] );

        $instance['subtitle'] = strip_tags( $new_instance['subtitle'] );


        $instance['link'] = $new_instance['link'];

        $instance['link_label'] = $new_instance['link_label'];

        $instance['post_order'] = $new_instance['post_order'];

        $instance['numb_col'] = $new_instance['numb_col'];

		$instance['item'] = $new_instance['item'];


        return $instance;

    }

    public function form( $instance ) {

        $title = apply_filters( 'widget_title', $instance['title'] );

        $subtitle = $instance['subtitle'];



        /* Set up some default widget settings. */

        $link = $instance['link'];

        $link_label = $instance['link_label'];

        $post_order = $instance['post_order'];

        $numb_col = $instance['numb_col'];

        $cat_selected = $instance['item'];

        //$opts = '';
        ?>


    <p>
        <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'crum'); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>"/>
    </p>
    <p>
        <label for="<?php echo $this->get_field_id('subtitle'); ?>"><?php _e('Subtitle:', 'crum'); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id('subtitle'); ?>" name="<?php echo $this->get_field_name('subtitle'); ?>" type="text" value="<?php echo esc_attr($subtitle); ?>"/>
    </p>
    <p>
        <label for="<?php echo $this->get_field_id( 'link' ); ?>"><?php _e( 'Link to full page', 'crum' ); ?>:</label>
        <input class="widefat" id="<?php echo $this->get_field_id( 'link' ); ?>" name="<?php echo $this->get_field_name( 'link' ); ?>" type="text" value="<?php echo esc_attr( $link ); ?>" />
    </p>

    <p>
        <label for="<?php echo $this->get_field_id( 'link_label' ); ?>"><?php _e( 'Link label', 'crum' ); ?>:</label>
        <input class="widefat" id="<?php echo $this->get_field_id( 'link_label' ); ?>" name="<?php echo $this->get_field_name( 'link_label' ); ?>" type="text" value="<?php echo esc_attr( $link_label ); ?>" />
    </p>

    <p>
        <label for="<?php echo $this->get_field_id( 'post_order' ); ?>"><?php _e( 'Order posts', 'crum' ); ?></label>
        <select class="widefat" id="<?php echo $this->get_field_id( 'post_order' ); ?>" name="<?php echo $this->get_field_name( 'post_order' );?>"  >

            <option class="widefat" <?php if( esc_attr( $post_order ) == 'DESC' ) echo 'selected'; ?> value="DESC"><?php _e('Descending','crum'); ?></option>
            <option class="widefat" <?php if( esc_attr( $post_order ) == 'ASC' ) echo 'selected'; ?> value="ASC"><?php _e('Ascending','crum'); ?></option>

        </select>
    </p>
    <p>
        <label for="<?php echo $this->get_field_id( 'numb_col' ); ?>"><?php _e( 'Number of columns', 'crum' ); ?></label>
        <select class="widefat" id="<?php echo $this->get_field_id( 'numb_col' ); ?>" name="<?php echo $this->get_field_name( 'numb_col' );?>"  >

            <option class="widefat"  value="1" <?php if( esc_attr( $numb_col ) == '1' ) echo 'selected'; ?>><?php _e('1 column','crum'); ?></option>
            <option class="widefat"  value="2" <?php if( esc_attr( $numb_col ) == '2' ) echo 'selected'; ?>><?php _e('2 columns','crum'); ?></option>
            <option class="widefat"  value="3" <?php if( esc_attr( $numb_col ) == '3' ) echo 'selected'; ?>><?php _e('3 columns','crum'); ?></option>
            <option class="widefat"  value="4" <?php if( esc_attr( $numb_col ) == '4' ) echo 'selected'; ?>><?php _e('4 columns','crum'); ?></option>

        </select>

    </p>

    <p>
        <label for="<?php echo $this->get_field_id( 'item' ); ?>"><?php _e( 'Select gallery', 'crum' ); ?></label>

		<select class="widefat" id="<?php echo $this->get_field_id( 'item' ); ?>" name="<?php echo $this->get_field_name( 'item' );?>"  >

			<option class="widefat" value=""><?php _e('Select', 'crum'); ?></option>


			<?php

            $args = array(
				'post_type' => 'galleries',
				'post_status' => 'publish',
				'posts_per_page' => -1
			);

			$gallery_posts = get_posts($args);

			foreach ($gallery_posts as $galery_post){

				$sel = ((int)$cat_selected ==  $galery_post -> ID) ? 'selected = "selected" ' : '';

				echo '<option class="widefat" '.$sel.' value="'.$galery_post -> ID.'">'.$galery_post -> post_title.'</option>';

			}
            ?>

        </select>

    </p>

   <?php

    }

}

add_action( 'widgets_init', create_function( '', 'register_widget("crum_one_gallery_widget");' ) );