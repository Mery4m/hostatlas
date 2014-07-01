<?php

class crum_tabwidget extends WP_Widget {
    /** constructor */
    function __construct() {
        parent::WP_Widget( /* Base ID */'crumina_tabwidget', /* Name */'Box: Tabs', array( 'description' => 'Tab Panel block' ) );
    }

    /** @see WP_Widget::widget */
    function widget( $args, $instance ) {
        extract( $args );

        $title =  $instance['title'] ;
        $content =  $instance['content'] ;

        $block_title =  $instance['block_title'] ;
        $subtitle =  $instance['subtitle'] ;


        echo $before_widget;
        if ($block_title) {

            if ( $subtitle ) {
                echo '<div class="subtitle">';
                echo $subtitle;
                echo '</div>';
            }

            echo $before_title;
            echo $block_title;
            echo $after_title;

        }
        ?>
    <dl class="tabs horisontal">

        <dd class="active">
            <a href="#tab-crum-1"><?php echo esc_attr($instance['title1']);?></a>
        </dd>
        <?php if ($instance['title2']) {
        echo '<dd><a href="#tab-crum-2">'. esc_attr($instance['title2']).'</a></dd>';
    }if ($instance['title3']) {
        echo '<dd><a href="#tab-crum-3">'. esc_attr($instance['title3']).'</a></dd>';
    }if ($instance['title4']) {
        echo '<dd><a href="#tab-crum-4">'. esc_attr($instance['title4']).'</a></dd>';
	}if ($instance['title5']) {
        echo '<dd><a href="#tab-crum-5">'. esc_attr($instance['title5']).'</a></dd>';
	}if ($instance['title6']) {
        echo '<dd><a href="#tab-crum-6">'. esc_attr($instance['title6']).'</a></dd>';
	}if ($instance['title7']) {
        echo '<dd><a href="#tab-crum-7">'. esc_attr($instance['title7']).'</a></dd>';
	}if ($instance['title8']) {
        echo '<dd><a href="#tab-crum-8">'. esc_attr($instance['title8']).'</a></dd>';
	}if ($instance['title9']) {
        echo '<dd><a href="#tab-crum-9">'. esc_attr($instance['title9']).'</a></dd>';
	}if ($instance['title10']) {
        echo '<dd><a href="#tab-crum-10">'. esc_attr($instance['title10']).'</a></dd>';
    } ?>
    </dl>


    <ul class="tabs-content">
        <ul class="tabs-content">

            <li class="active" id="tab-crum-1Tab">
                <?php echo ($instance['content1']);?>
            </li>

            <?php if ($instance['content2']) {
            echo '<li id="tab-crum-2Tab">'. $instance['content2'].'</li>';
        }if ($instance['content3']) {
            echo '<li id="tab-crum-3Tab">'. $instance['content3'].'</li>';
        }if ($instance['content4']) {
            echo '<li id="tab-crum-4Tab">'. $instance['content4'].'</li>';
		}if ($instance['content5']) {
            echo '<li id="tab-crum-5Tab">'. $instance['content5'].'</li>';
		}if ($instance['content6']) {
            echo '<li id="tab-crum-6Tab">'. $instance['content6'].'</li>';
		}if ($instance['content7']) {
            echo '<li id="tab-crum-7Tab">'. $instance['content7'].'</li>';
		}if ($instance['content8']) {
            echo '<li id="tab-crum-8Tab">'. $instance['content8'].'</li>';
		}if ($instance['content9']) {
            echo '<li id="tab-crum-9Tab">'. $instance['content9'].'</li>';
		}if ($instance['content10']) {
            echo '<li id="tab-crum-10Tab">'. $instance['content10'].'</li>';
        }?>

        </ul>
    </ul>


    <?php
        echo $after_widget;
    }

    function update($new, $old)
    {
        $new = wp_parse_args($new, array(
            'block_title'   => '',
            'subtitle'      => '',
            'title1'         => '',
            'content1'      => '',
            'title2'         => '',
            'content2'      => '',
            'title3'         => '',
            'content3'      => '',
            'title4'         => '',
            'content4'      => '',
			'title5'         => '',
            'content5'      => '',
			'title6'         => '',
            'content6'      => '',
			'title7'         => '',
            'content7'      => '',
			'title8'         => '',
            'content8'      => '',
			'title9'         => '',
            'content9'      => '',
			'title10'         => '',
            'content10'      => '',
        ));
        return $new;
    }

    function form($instance)
    {
        $instance = wp_parse_args($instance, array(
            'block_title'   => '',
            'subtitle'      => '',
            'title1'         => '',
            'content1'      => '',
            'title2'         => '',
            'content2'      => '',
            'title3'         => '',
            'content3'      => '',
            'title4'         => '',
            'content4'      => '',
			'title5'         => '',
            'content5'      => '',
			'title6'         => '',
            'content6'      => '',
			'title7'         => '',
            'content7'      => '',
			'title8'         => '',
            'content8'      => '',
			'title9'         => '',
            'content9'      => '',
			'title10'         => '',
            'content10'      => '',
        ));
        ?>

    <div id="tabpane">

        <p>
            <label for="<?php echo $this->get_field_id( 'block_title' ); ?>"><?php _e( 'Title:', 'crum' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'block_title' ); ?>" name="<?php echo $this->get_field_name( 'block_title' ); ?>" type="text" value="<?php echo esc_attr($instance['block_title']) ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('subtitle'); ?>"><?php _e('Subtitle:', 'crum'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('subtitle'); ?>" name="<?php echo $this->get_field_name('subtitle'); ?>" type="text" value="<?php echo esc_attr($instance['subtitle']) ?>"/>
        </p>

        <p>
            <label for="<?php echo $this->get_field_id('title1'); ?>"><?php _e('Section Title:', 'crum'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title1'); ?>" name="<?php echo $this->get_field_name('title1'); ?>" type="text" value="<?php echo esc_attr($instance['title1']) ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('content1'); ?>"><?php _e('Content:', 'crum'); ?></label>
            <textarea class="widefat" id="<?php echo $this->get_field_id('content1'); ?>" name="<?php echo $this->get_field_name('content1'); ?>" ><?php echo esc_attr($instance['content1']) ?></textarea>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('title2'); ?>"><?php _e('Section Title:', 'crum'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title2'); ?>" name="<?php echo $this->get_field_name('title2'); ?>" type="text" value="<?php echo esc_attr($instance['title2']) ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('content2'); ?>"><?php _e('Content:', 'crum'); ?></label>
            <textarea class="widefat" id="<?php echo $this->get_field_id('content2'); ?>" name="<?php echo $this->get_field_name('content2'); ?>" ><?php echo esc_attr($instance['content2']) ?></textarea>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('title3'); ?>"><?php _e('Section Title:', 'crum'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title3'); ?>" name="<?php echo $this->get_field_name('title3'); ?>" type="text" value="<?php echo esc_attr($instance['title3']) ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('content3'); ?>"><?php _e('Content:', 'crum'); ?></label>
            <textarea class="widefat" id="<?php echo $this->get_field_id('content3'); ?>" name="<?php echo $this->get_field_name('content3'); ?>" ><?php echo esc_attr($instance['content3']) ?></textarea>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('title4'); ?>"><?php _e('Section Title:', 'crum'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title4'); ?>" name="<?php echo $this->get_field_name('title4'); ?>" type="text" value="<?php echo esc_attr($instance['title4']) ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('content4'); ?>"><?php _e('Content:', 'crum'); ?></label>
            <textarea class="widefat" id="<?php echo $this->get_field_id('content4'); ?>" name="<?php echo $this->get_field_name('content4'); ?>" ><?php echo esc_attr($instance['content4']) ?></textarea>
        </p>
		<p>
            <label for="<?php echo $this->get_field_id('title5'); ?>"><?php _e('Section Title:', 'crum'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title5'); ?>" name="<?php echo $this->get_field_name('title5'); ?>" type="text" value="<?php echo esc_attr($instance['title5']) ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('content5'); ?>"><?php _e('Content:', 'crum'); ?></label>
            <textarea class="widefat" id="<?php echo $this->get_field_id('content5'); ?>" name="<?php echo $this->get_field_name('content5'); ?>" ><?php echo esc_attr($instance['content5']) ?></textarea>
        </p>
		<p>
            <label for="<?php echo $this->get_field_id('title6'); ?>"><?php _e('Section Title:', 'crum'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title6'); ?>" name="<?php echo $this->get_field_name('title6'); ?>" type="text" value="<?php echo esc_attr($instance['title6']) ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('content6'); ?>"><?php _e('Content:', 'crum'); ?></label>
            <textarea class="widefat" id="<?php echo $this->get_field_id('content6'); ?>" name="<?php echo $this->get_field_name('content6'); ?>" ><?php echo esc_attr($instance['content6']) ?></textarea>
        </p>
		<p>
            <label for="<?php echo $this->get_field_id('title7'); ?>"><?php _e('Section Title:', 'crum'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title7'); ?>" name="<?php echo $this->get_field_name('title7'); ?>" type="text" value="<?php echo esc_attr($instance['title7']) ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('content7'); ?>"><?php _e('Content:', 'crum'); ?></label>
            <textarea class="widefat" id="<?php echo $this->get_field_id('content7'); ?>" name="<?php echo $this->get_field_name('content7'); ?>" ><?php echo esc_attr($instance['content7']) ?></textarea>
        </p>
		<p>
            <label for="<?php echo $this->get_field_id('title8'); ?>"><?php _e('Section Title:', 'crum'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title8'); ?>" name="<?php echo $this->get_field_name('title8'); ?>" type="text" value="<?php echo esc_attr($instance['title8']) ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('content8'); ?>"><?php _e('Content:', 'crum'); ?></label>
            <textarea class="widefat" id="<?php echo $this->get_field_id('content8'); ?>" name="<?php echo $this->get_field_name('content8'); ?>" ><?php echo esc_attr($instance['content8']) ?></textarea>
        </p>
		<p>
            <label for="<?php echo $this->get_field_id('title9'); ?>"><?php _e('Section Title:', 'crum'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title9'); ?>" name="<?php echo $this->get_field_name('title9'); ?>" type="text" value="<?php echo esc_attr($instance['title9']) ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('content9'); ?>"><?php _e('Content:', 'crum'); ?></label>
            <textarea class="widefat" id="<?php echo $this->get_field_id('content9'); ?>" name="<?php echo $this->get_field_name('content9'); ?>" ><?php echo esc_attr($instance['content9']) ?></textarea>
        </p>
		<p>
            <label for="<?php echo $this->get_field_id('title10'); ?>"><?php _e('Section Title:', 'crum'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title10'); ?>" name="<?php echo $this->get_field_name('title10'); ?>" type="text" value="<?php echo esc_attr($instance['title10']) ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('content10'); ?>"><?php _e('Content:', 'crum'); ?></label>
            <textarea class="widefat" id="<?php echo $this->get_field_id('content10'); ?>" name="<?php echo $this->get_field_name('content10'); ?>" ><?php echo esc_attr($instance['content10']) ?></textarea>
        </p>

    </div>
    <?php
    }

} // class Foo_Widget

add_action( 'widgets_init', create_function( '', 'register_widget("crum_tabwidget");' ) );