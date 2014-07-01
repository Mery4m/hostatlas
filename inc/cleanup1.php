<?php

/**
 * Clean up wp_head()
 *
 * Remove unnecessary <link>'s
 * Remove inline CSS used by Recent Comments widget
 * Remove inline CSS used by posts with galleries
 * Remove self-closing tag and change ''s to "'s on rel_canonical()
 */
function crum_head_cleanup()
{
    // Originally from http://wpengineer.com/1438/wordpress-header/
    remove_action('wp_head', 'feed_links', 2);
    remove_action('wp_head', 'feed_links_extra', 3);
    remove_action('wp_head', 'rsd_link');
    remove_action('wp_head', 'wlwmanifest_link');
    remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
    remove_action('wp_head', 'wp_generator');
    remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);


    add_filter('use_default_gallery_style', '__return_null');


}

function crum_rel_canonical()
{
    global $wp_the_query;

    if (!is_singular()) {
        return;
    }

    if (!$id = $wp_the_query->get_queried_object_id()) {
        return;
    }

    $link = get_permalink($id);
    echo "\t<link rel=\"canonical\" href=\"$link\">\n";
}

add_action('init', 'crum_head_cleanup');

/**
 * Remove the WordPress version from RSS feeds
 */
add_filter('the_generator', '__return_false');

/**
 * Clean up output of stylesheet <link> tags
 */
function crum_clean_style_tag($input)
{
    preg_match_all("!<link rel='stylesheet'\s?(id='[^']+')?\s+href='(.*)' type='text/css' media='(.*)' />!", $input, $matches);
    // Only display media if it's print
    $media = $matches[3][0] === 'print' ? ' media="print"' : '';
    return '<link rel="stylesheet" href="' . $matches[2][0] . '"' . $media . '>' . "\n";
}

add_filter('style_loader_tag', 'crum_clean_style_tag');

/**
 * Add and remove body_class() classes
 */
function crum_body_class($classes)
{

    // Add post/page slug

    if (is_single() || is_page() && !is_front_page()) {
        $classes[] = basename(get_permalink());
    }

    // Remove unnecessary classes
    $home_id_class = 'page-id-' . get_option('page_on_front');
    $remove_classes = array(
    'page-template-default',
    $home_id_class
    );
    $classes = array_diff($classes, $remove_classes);

    return $classes;
}

add_filter('body_class', 'crum_body_class');

/**
 * Relative URLs
 *
 * WordPress likes to use absolute URLs on everything - let's clean that up.
 * Inspired by http://www.456bereastreet.com/archive/201010/how_to_make_wordpress_urls_root_relative/
 *
 * You can enable/disable this feature in config.php:
 * current_theme_supports('root-relative-urls');
 *
 * @author Scott Walkinshaw <scott.walkinshaw@gmail.com>
 */
function crum_root_relative_url($input)
{
    $output = preg_replace_callback(
    '!(https?://[^/|"]+)([^"]+)?!',
    create_function(
    '$matches',
    // If full URL is home_url("/") and this isn't a subdir install, return a slash for relative root
    'if (isset($matches[0]) && $matches[0] === home_url("/") && str_replace("http://", "", home_url("/", "http"))==$_SERVER["HTTP_HOST"]) { return "/";' .
    // If domain is equal to home_url("/"), then make URL relative
    '} elseif (isset($matches[0]) && strpos($matches[0], home_url("/")) !== false) { return $matches[2];' .
    // If domain is not equal to home_url("/"), do not make external link relative
    '} else { return $matches[0]; };'
    ),
    $input
    );

    return $output;
}

/**
 * Terrible workaround to remove the duplicate subfolder in the src of <script> and <link> tags
 * Example: /subfolder/subfolder/css/style.css
 */
function crum_fix_duplicate_subfolder_urls($input)
{
    $output = crum_root_relative_url($input);
    preg_match_all('!([^/]+)/([^/]+)!', $output, $matches);

    if (isset($matches[1][0]) && isset($matches[2][0])) {
        if ($matches[1][0] === $matches[2][0]) {
            $output = substr($output, strlen($matches[1][0]) + 1);
        }
    }

    return $output;
}

function crum_enable_root_relative_urls()
{
    return !(is_admin() && in_array($GLOBALS['pagenow'], array('wp-login.php', 'wp-register.php'))) && current_theme_supports('root-relative-urls');
}

if (crum_enable_root_relative_urls()) {
    $root_rel_filters = array(
    'bloginfo_url',
    'theme_root_uri',
    'stylesheet_directory_uri',
    'template_directory_uri',
    'plugins_url',
    'the_permalink',
    'wp_list_pages',
    'wp_list_categories',
    'wp_nav_menu',
    'the_content_more_link',
    'the_tags',
    'get_pagenum_link',
    'get_comment_link',
    'month_link',
    'day_link',
    'year_link',
    'tag_link',
    'the_author_posts_link'
    );

    add_filters($root_rel_filters, 'roots_root_relative_url');

    add_filter('script_loader_src', 'crum_fix_duplicate_subfolder_urls');
    add_filter('style_loader_src', 'crum_fix_duplicate_subfolder_urls');
}

/**
 * Wrap embedded media as suggested by Readability
 *
 * @link https://gist.github.com/965956
 * @link http://www.readability.com/publishers/guidelines#publisher
 */
function crum_embed_wrap($cache, $url, $attr = '', $post_ID = '')
{
    return '<div class="entry-content-asset">' . $cache . '</div>';
}

add_filter('embed_oembed_html', 'crum_embed_wrap', 10, 4);
add_filter('embed_googlevideo', 'crum_embed_wrap', 10, 2);

/**
 * Add class="thumbnail" to attachment items
 */
function crum_attachment_link_class($html)
{
    $postid = get_the_ID();
    $html = str_replace('<a', '<a class="thumbnail"', $html);
    return $html;
}

add_filter('wp_get_attachment_link', 'crum_attachment_link_class', 10, 1);

/**
 * Add Bootstrap thumbnail styling to images with captions
 * Use <figure> and <figcaption>
 *
 * @link http://justintadlock.com/archives/2011/07/01/captions-in-wordpress
 */
function crum_caption($output, $attr, $content)
{
    if (is_feed()) {
        return $output;
    }

    $defaults = array(
    'id' => '',
    'align' => 'alignnone',
    'width' => '',
    'caption' => ''
    );

    $attr = shortcode_atts($defaults, $attr);

    // If the width is less than 1 or there is no caption, return the content wrapped between the [caption] tags
    if ($attr['width'] < 1 || empty($attr['caption'])) {
        return $content;
    }

    // Set up the attributes for the caption <figure>
    $attributes = (!empty($attr['id']) ? ' id="' . esc_attr($attr['id']) . '"' : '');
    $attributes .= ' class="thumbnail wp-caption ' . esc_attr($attr['align']) . '"';
    $attributes .= ' style="width: ' . esc_attr($attr['width']) . 'px"';

    $output = '<figure' . $attributes . '>';
    $output .= do_shortcode($content);
    $output .= '<figcaption class="caption wp-caption-text">' . $attr['caption'] . '</figcaption>';
    $output .= '</figure>';

    return $output;
}

add_filter('img_caption_shortcode', 'crum_caption', 10, 3);

/**
 * Remove unnecessary dashboard widgets
 *
 * @link http://www.deluxeblogtips.com/2011/01/remove-dashboard-widgets-in-wordpress.html
 */
function roots_remove_dashboard_widgets()
{
    remove_meta_box('dashboard_incoming_links', 'dashboard', 'normal');
    remove_meta_box('dashboard_plugins', 'dashboard', 'normal');
    remove_meta_box('dashboard_primary', 'dashboard', 'normal');
    remove_meta_box('dashboard_secondary', 'dashboard', 'normal');
}

add_action('admin_init', 'roots_remove_dashboard_widgets');

/**
 * Clean up the_excerpt()
 */


function crum_excerpt_more($more)
{
    return ' &hellip; <a href="' . get_permalink() . '">' . __('Continue reading &#187;', 'crum') . '</a>';
}

add_filter('excerpt_more', 'crum_excerpt_more');

/**
 * Allow more tags in TinyMCE including <iframe> and <script>
 */
function crum_change_mce_options($options)
{
    $ext = 'pre[id|name|class|style],iframe[align|longdesc|name|width|height|frameborder|scrolling|marginheight|marginwidth|src],script[charset|defer|language|src|type]';

    if (isset($initArray['extended_valid_elements'])) {
        $options['extended_valid_elements'] .= ',' . $ext;
    } else {
        $options['extended_valid_elements'] = $ext;
    }

    return $options;
}

add_filter('tiny_mce_before_init', 'crum_change_mce_options');


/**
 * Fix for get_search_query() returning +'s between search terms
 */
function crum_search_query($escaped = true)
{
    $query = apply_filters('crum_search_query', get_query_var('s'));

    if ($escaped) {
        $query = esc_attr($query);
    }

    return urldecode($query);
}

add_filter('get_search_query', 'crum_search_query');

/**
 * Fix for empty search queries redirecting to home page
 *
 * @link http://wordpress.org/support/topic/blank-search-sends-you-to-the-homepage#post-1772565
 * @link http://core.trac.wordpress.org/ticket/11330
 */
function crum_request_filter($query_vars)
{
    if (isset($_GET['s']) && empty($_GET['s'])) {
        $query_vars['s'] = 'Empty';
    }

    return $query_vars;
}

add_filter('request', 'crum_request_filter');

/**
 * Tell WordPress to use searchform.php from the templates/ directory
 */
function crum_get_search_form()
{
    locate_template('/templates/searchform.php', true, true);
}

add_filter('get_search_form', 'crum_get_search_form');


class Roots_Alt_Walker extends Walker_Nav_Menu
{
    static protected $menu_lvl;
    static protected $active_mega_menu;
    static protected $mega_menu_item;
    static protected $only_first = false;

    private $mega_menu_settings;
    private $is_hover;

    public function __construct()
    {
        $this->mega_menu_settings = get_option("crumina_menu_data");
        $crumina_menu = get_option("crumina_menu");
        $this->is_hover = (isset($crumina_menu['menu_active_icon_hover']) && !empty($crumina_menu['menu_active_icon_hover'])) ? true : false;
    }

    public function start_lvl(&$output, $depth = 0, $args = array())
    {
        if ($depth == 0 && isset($args->mega_menu_width) && $args->mega_menu_active == 1) {
            $output .= "\n<ul style='width: " . $args->mega_menu_width . "px;'>\n";
        } else {
            $output .= "\n<ul>\n";
        }

    }

    public function end_lvl(&$output, $depth = 0, $args = array())
    {
        $output .= "</ul>\n";
    }

    public function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0)
    {
        static $menu_slug = '';

        $class_names = $value = $item_output = $no_icon_class = $hover_css = '';


        if (empty($menu_slug)) {
            $menus = wp_get_nav_menus();

            $nav_menu_locations = get_nav_menu_locations();

            if(is_array($nav_menu_locations))
            {
                $menu_locations = array_values(get_nav_menu_locations());
            }


            if (!empty($menu_locations)) {
                foreach ($menus as $menu) {
                    if ($menu->term_id == current($menu_locations)) {
                        $menu_slug = $menu->slug;
                        break;
                    }
                }
            }
        }

        if(empty($menu_slug)) return false;


        $slug = sanitize_title($item->title);

        $styles = $this->mega_menu_settings;

        if ($depth == 0) {
            $active_mega_menu = (isset($styles[$menu_slug][$slug]['mega_menu_active']) && $styles[$menu_slug][$slug]['mega_menu_active'] == 'on') ? 1 : 0;
            $mega_menu_item = (!empty($styles[$menu_slug][$slug]['mega_menu_item'])) ? $styles[$menu_slug][$slug]['mega_menu_item'] : '';
            self::$active_mega_menu = $active_mega_menu;
            self::$mega_menu_item = $mega_menu_item;
        }


        $li_classes = array();

        //active page class
        if ($depth == 0 && $item->current) $li_classes[] = 'current-menu-item';
        if (self::$active_mega_menu == 1 || $args->has_children) $li_classes[] = 'has-submenu';


        $li_id = "id='$menu_slug-$slug'";


        if (count($li_classes) > 0)
        $output .= '<li class="' . implode(' ', $li_classes) . '" ' . $li_id . '>';
        else
        $output .= '<li ' . $li_id . '>';

        if (!empty($menu_slug) && $depth == 0) {

            $tmp_css_style = array();
            $active_css_style = '';
            $contact_icons = '';
            $no_icon_class = '';

            if (!empty($styles[$menu_slug][$slug]['active_icon'])) {

                if($this->is_hover && $item->current)
                {
                    $active_icon = $styles[$menu_slug][$slug]['hover_icon'];
                }
                else
                {
                    $active_icon = $styles[$menu_slug][$slug]['active_icon'];
                }

                $contact_icons .= '<img src="' . aq_resize($active_icon, 32, 32, true) . '" class="normal-icon" alt="">';
            }
            else
            {
                $no_icon_class = 'no_icon';
            }

            if($this->is_hover && !$item->current)
            {
                $hover_css = 'style="display:none;"';
            }

            if (!empty($styles[$menu_slug][$slug]['hover_icon'])) {
                $hover_icon = $styles[$menu_slug][$slug]['hover_icon'];
                $contact_icons .= '<img src="' . aq_resize($hover_icon, 32, 32, true) . '" ' . $hover_css . ' class="active-icon" alt="">';
            }


        }

        if ($depth == 0) {
            self::$only_first = false;
            $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
            $output .= '<span class="menu-item-wrap ' . $no_icon_class . '">';
        }

        $attributes = !empty($item->attr_title) ? ' title="' . esc_attr($item->attr_title) . '"' : '';
        $attributes .= !empty($item->url) ? ' href="' . esc_attr($item->url) . '"' : '';

        $item_output = $args->before;

        if ($depth != 0) {
            $item_output .= '<span class="menu-item-wrap">';
        }


        if (self::$active_mega_menu == 1 && $depth != 0) {
            if (self::$only_first == false) {


                //$post_data = get_post(self::$mega_menu_item);

                /*global $post;
                $tmp_post = $post;
                $args_posts = array( 'include' => self::$mega_menu_item, 'post_type'=>'any');*/

                global $post;
                $tmp_post = $post;

                $args_posts = array( 'p' => self::$mega_menu_item, 'post_type'=>'any');

                $myposts = query_posts($args_posts);

                //$myposts = get_posts( $args_posts );

                foreach( $myposts as $post ) : setup_postdata($post);

                /*ob_start();
                the_content();
                $menu_content = ob_get_clean();*/

                    $menu_content = do_shortcode( apply_filters( 'the_content', $post->post_content ) );


                $item_output .= '<span class="menu-item-wrap" style="padding:9px 10px 8px 20px;">';
                $item_output .= '<div class="mega-text">' . $menu_content . '</div>';

                $item_output .= '</span>' . $args->after;
                self::$only_first = true;
                
                endforeach;

                wp_reset_query();
                
                $post = $tmp_post;
            }

        } elseif (self::$active_mega_menu == 1 && $depth == 0 && !$args->has_children) {



            if (!empty($styles[$menu_slug][$slug]['mega_menu_width'])) $parent_mega_menu_width = $styles[$menu_slug][$slug]['mega_menu_width'];

            $menu_content = '';

            global $post;
            $tmp_post = $post;

            $args_posts = array( 'p' => self::$mega_menu_item, 'post_type'=>'any');

            $myposts = query_posts($args_posts);

            foreach( $myposts as $post) :

            setup_postdata($post);

            $menu_content = do_shortcode( apply_filters( 'the_content', $post->post_content ) );

            $item_output .= '<a ' . $attributes . ' style="">';
            $item_output .= !empty($contact_icons) ? "<span class='tile-icon'>" . $contact_icons . '</span>' : '';
            $item_output .= '<span class="link-text">' . apply_filters('the_title', $item->title, $item->ID) . '</span>';
            $item_output .= '</a>';
            $item_output .= '</span>' . $args->after;
            $item_output .= '<ul style="width: ' . $parent_mega_menu_width . 'px; display: none;">
            <li class="has-submenu">
            <div class="menu-item-wrap" style="padding:9px 10px 8px 20px;">
            <div class="mega-text">' . $menu_content . '</div></div></li>
            </ul>';

            endforeach;

            wp_reset_query();

            $post = $tmp_post;

        } else {

            $item_output .= '<a ' . $attributes . ' style="">';
            $item_output .= !empty($contact_icons) ? "<span class='tile-icon'>" . $contact_icons . '</span>' : '';
            $item_output .= '<span class="link-text">' . apply_filters('the_title', $item->title, $item->ID) . '</span>';
            $item_output .= '</a>';

            $item_output .= '</span>' . $args->after;
        }


        if ($depth == 0) {
            $item_output .= "";
            $item_output .= "<div class='under'></div>";
        }


        if (!empty($styles[$menu_slug][$slug]['mega_menu_width'])) {
            $args->mega_menu_width = $styles[$menu_slug][$slug]['mega_menu_width'];
        } else {
            $args->mega_menu_width = '';
        }

        if(isset($active_mega_menu))
        $args->mega_menu_active = $active_mega_menu;


        $output .= apply_filters('roots_alt_walker_start_el', $item_output, $item, $depth, $args);

    }

    function end_el(&$output, $item, $depth = 0, $args = array())
    {
        $output .= "</li>\n";
    }


    function display_element($element, &$children_elements, $max_depth, $depth = 0, $args, &$output)
    {
        if (!$element) {
            return;
        }

        $id_field = $this->db_fields['id'];

        if (is_array($args[0])) {
            $args[0]['has_children'] = !empty($children_elements[$element->$id_field]);
        } elseif (is_object($args[0])) {
            $args[0]->has_children = !empty($children_elements[$element->$id_field]);
        }

        $cb_args = array_merge(array(&$output, $element, $depth), $args);
        call_user_func_array(array(&$this, 'start_el'), $cb_args);

        $id = $element->$id_field;

        if (($max_depth == 0 || $max_depth > $depth + 1) && isset($children_elements[$id])) {
            foreach ($children_elements[$id] as $child) {
                if (!isset($newlevel)) {
                    $newlevel = true;
                    $cb_args = array_merge(array(&$output, $depth), $args);
                    //call_user_func_array(array(&$this, 'start_lvl'), $cb_args);
                    call_user_func_array(array(&$this, 'start_lvl'), $cb_args);
                }
                $this->display_element($child, $children_elements, $max_depth, $depth + 1, $args, $output);
            }
            unset($children_elements[$id]);
        }

        if (isset($newlevel) && $newlevel) {
            $cb_args = array_merge(array(&$output, $depth), $args);
            call_user_func_array(array(&$this, 'end_lvl'), $cb_args);
        }

        $cb_args = array_merge(array(&$output, $element, $depth), $args);
        call_user_func_array(array(&$this, 'end_el'), $cb_args);
    }
}


/**
 * REQ_Clearing Shortcode Class
 *
 * @version 0.1.0
 */
class REQ_Clearing {

    /**
     * Sets up our actions/filters.
     *
     * @since 0.1.0
     * @access public
     * @return void
     */
    public function __construct() {

        /* Register shortcodes on 'init'. */


        add_action( 'init', array( &$this, 'register_shortcode' ) );

        add_action( 'wp_head', array( &$this, 'admin_bar_fix' ), 5);
    }

    /**
     * Registers the [clearing] shortcode.
     *
     * @since  0.1.0
     * @access public
     * @return void
     */
    public function register_shortcode() {
        remove_shortcode('gallery');
        add_shortcode( 'gallery', array( &$this, 'do_shortcode' ) );
    }

    /**
     * Returns the content of the clearing shortcode.
     *
     * @since  0.1.0
     * @access public
     * @param  array  $attr The user-inputted arguments.
     * @param  string $content The content to wrap in a shortcode.
     * @return string
     */
    public function do_shortcode( $attr ) {

        global $post;

        // We're trusting author input, so let's at least make sure it looks like a valid orderby statement
        if ( isset( $attr['orderby'] ) ) {
            $attr['orderby'] = sanitize_sql_orderby( $attr['orderby'] );
            if ( !$attr['orderby'] )
            unset( $attr['orderby'] );
        }

        /* Set up the default variables. */
        $output = '';
        $column_classes = '';
        $fearued_class = '';

        /* Set up the default arguments. */
        $defaults = apply_filters(
        'req_clearing_defaults',
        array(
        'order'      => 'ASC',
        'orderby'    => 'menu_order ID',
        'id'         => $post->ID,
        'columns'    => 3,
        'size'       => 'thumbnail',
        'include'    => '',
        'exclude'    => '',
        'featured'   => ''
        )
        );

        $attr = shortcode_atts( $defaults, $attr );

        /* Allow devs to filter the arguments. */
        $attr = apply_filters( 'req_clearing_args', $attr );

        /* Parse the arguments. */
        extract( $attr );

        $id = intval( $id );

        if ( 'RAND' == $order )
        $orderby = 'none';

        if ( !empty( $include ) ) {
            $include = preg_replace( '/[^0-9,]+/', '', $include );
            $_attachments = get_posts( array( 'include' => $include, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby ) );

            $attachments = array();
            foreach ( $_attachments as $key => $val ) {
                $attachments[$val->ID] = $_attachments[$key];
            }
        } elseif ( !empty( $exclude ) ) {
            $exclude = preg_replace( '/[^0-9,]+/', '', $exclude );
            $attachments = get_children( array( 'post_parent' => $id, 'exclude' => $exclude, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby ) );
        } else {
            $attachments = get_children( array( 'post_parent' => $id, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby ) );
        }

        if ( empty($attachments) )
        return '';

        if ( is_feed() ) {
            $output = "\n";
            foreach ( $attachments as $att_id => $attachment )
            $output .= wp_get_attachment_link($att_id, $size, true) . "\n";
            return $output;
        }

        /* Assign correct classes */
        $columns = intval($columns);
        switch ( $columns ) {
            case 1:
                $column_classes = '';
                break;
            case 2:
                $column_classes = 'block-grid two-up mobile-two-up';
                break;
            case 4:
                $column_classes = 'block-grid four-up mobile-two-up';
                break;
            case 5:
                $column_classes = 'block-grid five-up mobile-two-up';
                break;
            case 6:
                $column_classes = 'block-grid six-up mobile-two-up';
                break;
            case 3:
            default:
                $column_classes = 'block-grid three-up mobile-two-up';
                break;
        }

        /* Check for featured image and remove column_classes if there is a match */
        $featured = intval( $featured );
        if ( $featured != '' ) {
            $column_classes = '';
            $fearued_class = ' has-featured';
            $size = 'large';
        }

        /* Let the magic happen */
        $output = '<div class="req-clearing-container"><ul class="' . $column_classes . $fearued_class . '" data-clearing>';

        foreach ( $attachments as $id => $attachment ) {

            /* Image source for the thumbnail image */
            $img_src = wp_get_attachment_image_src( $id, $size );

            /* Image source for the full image to show on the plate */
            $img_src_full = wp_get_attachment_image_src( $id, 'full' );

            /* Check for a caption */
            $caption = '';
            if ( trim($attachment->post_excerpt) ) {
                $caption = ' data-caption="' . strip_tags( $attachment->post_excerpt ) . '"';
            }

            /* Check if we have a featured image for this clearing */
            $item_classes = '';
            if ( $featured == $id ) {
                $item_classes = ' class="clearing-feature"';
            }

            /* Generate final item output */
            $output .= '<li' . $item_classes . '><a class="th" href="' . esc_url( $img_src_full[0] ) . '"><img src="' . esc_url( $img_src[0] ) . '"' . $caption . ' /></a></li>';
        }

        $output .= '</ul></div>';

        /* Return the output of the column. */
        return apply_filters( 'req_clearing', $output );
    }
    /**
     * Helper to fix the admin bar positioning issue
     * @return string css
     */
    public function admin_bar_fix() {
        if( !is_admin() && is_admin_bar_showing() ) {
            remove_action( 'wp_head', '_admin_bar_bump_cb' );
            $output  = '<style type="text/css">'."\n\t";
            $output .= 'body.admin-bar .clearing-close { top: 28px; }'."\n";
            $output .= '</style>'."\n";
            echo $output;
        }
    }

}

new REQ_Clearing();
