<?php

class crum_tabwidget extends WP_Widget {
/** constructor */
function __construct() {
parent::WP_Widget( /* Base ID */'crumina_tabwidget', /* Name */'Theme: Tabs', array( 'description' => 'Tab Panel block' ) );
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

        echo '<div class="title">';
        if ( $subtitle ) {
            echo '<div class="subtitle">';
            echo $subtitle;
            echo '</div>';
        }

        echo $before_title;
        echo $block_title;
        echo $after_title;

        echo'</div>';
    }
?>
<dl class="tabs horisontal">

        <?php
        if($title){
            $cnt=1;
            foreach($title as $key=>$val){
                ?>
                <dd  class="<?php if($cnt==1)echo 'active';?>"><a href="#tab-crum-<?php echo $cnt;?>"><?php echo $val;?></a></dd>
                <?php ++$cnt;
            }
        }
        ?>
</dl>


    <ul class="tabs-content">
        <?php
        if($title){
            $cntt=1;
            foreach($content as $key=>$val){
                ?>
                <li class="<?php if($cntt==1)echo 'active';?>" id="tab-crum-<?php echo $cntt;?>Tab"><?php echo $val;?></li>

                <?php ++$cntt;
            }
        }
        ?>
    </ul>


<?php
echo $after_widget;
}

/** @see WP_Widget::update */
function update( $new_instance, $old_instance ) {
    $instance = $new_instance;

    return $instance;
}

/** @see WP_Widget::form */
function form( $instance ) {
    if ( $instance ) {
        $block_title =  $instance['block_title'];
        $subtitle =  $instance['subtitle'];
        $title =  $instance['title'];
        $content=  $instance['content'] ;
    }
    ?>


<p>
    <label for="<?php echo $this->get_field_id( 'block_title' ); ?>"><?php _e( 'Title:', 'crum' ); ?></label>
    <input class="widefat" id="<?php echo $this->get_field_id( 'block_title' ); ?>" name="<?php echo $this->get_field_name( 'block_title' ); ?>" type="text" value="<?php echo esc_attr( $block_title ); ?>" />
</p>
<p>
    <label for="<?php echo $this->get_field_id( 'subtitle' ); ?>"><?php _e( 'Subitle:', 'crum' ); ?></label>
    <input class="widefat" id="<?php echo $this->get_field_id( 'subtitle' ); ?>" name="<?php echo $this->get_field_name( 'subtitle' ); ?>" type="text" value="<?php echo esc_attr( $subtitle ); ?>" />
</p>


<div id="tabpane">
    <?php
    if($title){
        for($i=0;$i<count($title);$i++ ){
            ?>
            <p>
                <label for="<?php echo $this->get_field_id('title1'); ?>"><?php _e('Title for Tab:', 'crum'); ?></label>
                <input class="widefat" id="<?php echo $this->get_field_id('title1'); ?>" name="<?php echo $this->get_field_name('title'); ?>[]" type="text" value="<?php echo $title[$i]; ?>" />
            </p>
            <p>
                <label for="<?php echo $this->get_field_id('content1'); ?>"><?php _e('Content for Tab:', 'crum'); ?></label>
                <textarea class="widefat" id="<?php echo $this->get_field_id('content1'); ?>" name="<?php echo $this->get_field_name('content'); ?>[]" ><?php echo $content[$i]; ?></textarea>
            </p>
            <?php
        }
    }else{
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title1'); ?>"><?php _e('Title for Tab:', 'crum'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title1'); ?>" name="<?php echo $this->get_field_name('title'); ?>[]" type="text" value="" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('content1'); ?>"><?php _e('Content for Tab:', 'crum'); ?></label>
            <textarea class="widefat" id="<?php echo $this->get_field_id('content1'); ?>" name="<?php echo $this->get_field_name('content'); ?>[]" ></textarea>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('title1'); ?>"><?php _e('Title for Tab:', 'crum'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title1'); ?>" name="<?php echo $this->get_field_name('title'); ?>[]" type="text" value="" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('content1'); ?>"><?php _e('Content for Tab:', 'crum'); ?></label>
            <textarea class="widefat" id="<?php echo $this->get_field_id('content1'); ?>" name="<?php echo $this->get_field_name('content'); ?>[]" ></textarea>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('title1'); ?>"><?php _e('Title for Tab:', 'crum'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title1'); ?>" name="<?php echo $this->get_field_name('title'); ?>[]" type="text" value="" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('content1'); ?>"><?php _e('Content for Tab:', 'crum'); ?></label>
            <textarea class="widefat" id="<?php echo $this->get_field_id('content1'); ?>" name="<?php echo $this->get_field_name('content'); ?>[]" ></textarea>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('title1'); ?>"><?php _e('Title for Tab:', 'crum'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title1'); ?>" name="<?php echo $this->get_field_name('title'); ?>[]" type="text" value="" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('content1'); ?>"><?php _e('Content for Tab:', 'crum'); ?></label>
            <textarea class="widefat" id="<?php echo $this->get_field_id('content1'); ?>" name="<?php echo $this->get_field_name('content'); ?>[]" ></textarea>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('title1'); ?>"><?php _e('Title for Tab:', 'crum'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title1'); ?>" name="<?php echo $this->get_field_name('title'); ?>[]" type="text" value="" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('content1'); ?>"><?php _e('Content for Tab:', 'crum'); ?></label>
            <textarea class="widefat" id="<?php echo $this->get_field_id('content1'); ?>" name="<?php echo $this->get_field_name('content'); ?>[]" ></textarea>
        </p>
        <?php
    }
    ?>

</div>
<input type="button" id="addtab_" value="Add More Tab" class="button">
<script type="text/javascript">
    //TODO: make JS for adding new sections
</script>
<?php
}

} // class Foo_Widget
