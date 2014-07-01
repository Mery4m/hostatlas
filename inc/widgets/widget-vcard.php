<?php

class roots_vcard_widget extends WP_Widget {

private $fields = array(
'title'          => 'Title',
'subtitle'       => 'Subitle',
'street_address' => 'Street Address',
'locality'       => 'City/Locality',
'region'         => 'State/Region',
'postal_code'    => 'Zipcode/Postal Code',
'tel'            => 'Telephone',
'twitter'        => 'Twitter',
'email'          => 'Email'
);

function __construct() {
$widget_ops = array('classname' => 'contacts-widget', 'description' => __('Use this widget to add a vCard', 'crum'));

$this->WP_Widget('roots_vcard_widget', __('Theme: vCard', 'crum'), $widget_ops);
$this->alt_option_name = 'roots_vcard_widget';

add_action('save_post', array(&$this, 'flush_widget_cache'));
add_action('deleted_post', array(&$this, 'flush_widget_cache'));
add_action('switch_theme', array(&$this, 'flush_widget_cache'));
}

function widget($args, $instance) {
$cache = wp_cache_get('widget_roots_vcard', 'widget');

if (!is_array($cache)) {
$cache = array();
}

if (!isset($args['widget_id'])) {
$args['widget_id'] = null;
}

if (isset($cache[$args['widget_id']])) {
echo $cache[$args['widget_id']];
return;
}

ob_start();
extract($args, EXTR_SKIP);

$title = apply_filters('widget_title', empty($instance['title']) ? __('vCard', 'crum') : $instance['title'], $instance, $this->id_base);
$subtitle = apply_filters('widget_title', empty($instance['subtitle']) ? __('vCard', 'crum') : $instance['subtitle'], $instance, $this->id_base);

foreach($this->fields as $name => $label) {
if (!isset($instance[$name])) { $instance[$name] = ''; }
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

    }
?>
<div class="vcard">
    <p class="adress">
        <span class="adr">
            <?php if($instance['street_address']) { ?> <span class="street-address"><?php echo $instance['street_address']; ?></span>
            <?php } if($instance['locality']){ ?> <span class="locality"><?php echo $instance['locality']; ?></span>,
            <?php } if($instance['region']) { ?> <span class="region"><?php echo $instance['region']; ?></span>
            <?php } if($instance['postal_code']){ ?> <span class="postal-code"><?php echo $instance['postal_code']; ?></span> <?php } ?>
      </span>
    </p>
    <?php if($instance['tel']) { ?> <p class="phone"><?php echo $instance['tel']; ?></p>
    <?php } if($instance['email']) { ?> <p class="mail"><?php _e('E-Mail', 'crum'); ?>: <a class="email" href="mailto:<?php echo $instance['email']; ?>"><?php echo $instance['email']; ?></a></p> <?php } ?>
    <p class="other"><?php _e('Web', 'crum'); ?>: <a class="fn org url" href="<?php echo home_url('/'); ?>"><?php echo home_url(''); ?></a></p>
    <?php if ($instance['twitter']) { ?> <p class="twitter"><?php _e('Twitter', 'crum'); ?>: <a class="fn org url" href="<?php echo $instance['twitter']; ?>"><?php echo $instance['twitter'];?></a></p> <?php } ?>
</div>
    
<?php
echo $after_widget;

$cache[$args['widget_id']] = ob_get_flush();
wp_cache_set('widget_roots_vcard', $cache, 'widget');
}

function update($new_instance, $old_instance) {
    $instance = array_map('strip_tags', $new_instance);

    $this->flush_widget_cache();

    $alloptions = wp_cache_get('alloptions', 'options');

    if (isset($alloptions['widget_roots_vcard'])) {
        delete_option('widget_roots_vcard');
    }

    return $instance;
}

function flush_widget_cache() {
    wp_cache_delete('widget_roots_vcard', 'widget');
}

function form($instance) {
    foreach($this->fields as $name => $label) {
        ${$name} = isset($instance[$name]) ? esc_attr($instance[$name]) : '';
        ?>
    <p>
        <label for="<?php echo esc_attr($this->get_field_id($name)); ?>"><?php _e("{$label}:", 'crum'); ?></label>
        <input class="widefat" id="<?php echo esc_attr($this->get_field_id($name)); ?>" name="<?php echo esc_attr($this->get_field_name($name)); ?>" type="text" value="<?php echo ${$name}; ?>">
    </p>


    <?php
    }
}
}