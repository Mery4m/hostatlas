<?php
/**
 * Crumina themes functions
 */

/*Including other theme components*/

require_once locate_template('/inc/includes.php');


/**
 * Theme Wrapper
 *
 * @link http://scribu.net/wordpress/theme-wrappers.html
 */

function crum_template_path() {
	return Crum_Wrapping::$main_template;
}

function crum_template_base() {
	return Crum_Wrapping::$base;
}


class Crum_Wrapping {

	/**
     * Stores the full path to the main template file
     */
	static $main_template;

	/**
     * Stores the base name of the template file; e.g. 'page' for 'page.php' etc.
     */
	static $base;

	static function wrap( $template ) {
		self::$main_template = $template;

		self::$base = substr( basename( self::$main_template ), 0, -4 );

		if ( 'index' == self::$base )
		self::$base = false;

		$templates = array( 'base.php' );

		if ( self::$base )
		array_unshift( $templates, sprintf( 'base-%s.php', self::$base ) );

		return locate_template( $templates );
	}
}

add_filter( 'template_include', array( 'Crum_Wrapping', 'wrap' ), 99 );

// returns WordPress subdirectory if applicable

function wp_base_dir()
{
	preg_match('!(https?://[^/|"]+)([^"]+)?!', site_url(), $matches);
	if (count($matches) === 3) {
		return end($matches);
	} else {
		return '';
	}
}

// opposite of built in WP functions for trailing slashes

function leadingslashit($string)
{
	return '/' . unleadingslashit($string);
}

function unleadingslashit($string)
{
	return ltrim($string, '/');
}

function add_filters($tags, $function)
{
	foreach ($tags as $tag) {
		add_filter($tag, $function);
	}
}

function is_element_empty($element)
{
	$element = trim($element);
	return empty($element) ? false : true;
}

// Limit content function

function content($num)
{
    $theContent = get_the_excerpt();

    if ($theContent == ''){
	    $theContent = get_the_content();
    }

	$output = preg_replace('/<img[^>]+./', '', $theContent);
	$output = preg_replace('/<blockquote>.*<\/blockquote>/', '', $output);
	$output = preg_replace('|\[(.+?)\](.+?\[/\\1\])?|s', '', $output);
	$output = strip_tags($output);
	$limit = $num + 1;
	$content = explode(' ', $output, $limit);
	array_pop($content);
	$content = implode(" ", $content) . "...";
	echo $content;
}

/* Theme setup options*/


// Make theme available for translation
load_theme_textdomain('crum', get_template_directory() . '/lang');

// Register wp_nav_menu() menus (http://codex.wordpress.org/Function_Reference/register_nav_menus)
register_nav_menus(array(
'primary_navigation' => __('Primary Navigation', 'crum'),
'footer_menu' => __('Footer navigation', 'crum'),
));

// Add post thumbnails (http://codex.wordpress.org/Post_Thumbnails)
add_theme_support('post-thumbnails');


// Add post formats (http://codex.wordpress.org/Post_Formats)
add_theme_support('post-formats', array('gallery', 'video'));

// Tell the TinyMCE editor to use a custom stylesheet
add_editor_style('assets/css/editor-style.css');

add_filter('widget_text', 'do_shortcode');

add_post_type_support('page', 'excerpt');

// Change number or products per row to 3
add_filter('loop_shop_columns', 'loop_columns');
if (!function_exists('loop_columns')) {
    function loop_columns() {
        return 3; // 3 products per row
    }
}

if ( ! isset( $content_width ) ) $content_width = 900;

/**
 * Enqueue the Roboto Condensed font.
 */
function maestro_fonts() {
    $protocol = is_ssl() ? 'https' : 'http';

        wp_enqueue_style( 'maestro_roboto', "$protocol://fonts.googleapis.com/css?family=Roboto+Condensed:400,300,700&subset=latin,cyrillic-ext,greek-ext,greek,latin-ext,cyrillic,vietnamese");
}

add_action( 'wp_enqueue_scripts', 'maestro_fonts' );

add_action('wp_enqueue_scripts', 'maestro_fonts');


function woocommerce_subcats_from_parentcat_by_ID($parent_cat_ID) {
    $args = array(
        'hierarchical' => 1,
        'show_option_none' => '',
        'hide_empty' => 0,
        'parent' => $parent_cat_ID,
        'taxonomy' => 'product_cat'
    );
    $subcats = get_categories($args);
    echo '<ul class="wooc_sclist">';
    foreach ($subcats as $sc) {
        $link = get_term_link( $sc->slug, $sc->taxonomy );
        echo '<li><a href="'. $link .'">'.$sc->name.'</a></li>';
    }
    echo '</ul>';
}

function crum_z_index(){
	if (is_admin()){
	echo '<style type="text/css">';
	echo '#TB_window{z-index:999999 !important;}';
	echo '</style>';
	}
}


add_action ('admin_head', 'crum_z_index', 99);

/*add_filter( 'wp_get_attachment_link', 'sant_prettyadd');

function sant_prettyadd ($content) {
	$content = preg_replace("/<a/","<a rel=\"prettyPhoto[slides]\"",$content,1);
	return $content;
}*/


add_filter('wp_get_attachment_link', 'crum_addlightboxrel');
function crum_addlightboxrel($content) {
	global $post;
	$pattern ="/<a(.*?)href=('|\")(.*?).(bmp|gif|jpeg|jpg|png)('|\")(.*?)>/i";
	$replacement = '<a$1href=$2$3.$4$5 rel="prettyPhoto[pp_gal'.$post->ID.']" title="'.$post->post_title.'"$6>';
	$content = preg_replace($pattern, $replacement, $content);
	return $content;
}