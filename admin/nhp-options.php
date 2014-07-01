<?php

/*
 * 
 * Require the framework class before doing anything else, so we can use the defined urls and dirs
 * Also if running on windows you may have url problems, which can be fixed by defining the framework url first
 *
 */
//define('NHP_OPTIONS_URL', site_url('path the options folder'));

$theme_version = '';

if( function_exists( 'wp_get_theme' ) ) {
    if( is_child_theme() ) {
        $temp_obj = wp_get_theme();
        $theme_obj = wp_get_theme( $temp_obj->get('Template') );
    } else {
        $theme_obj = wp_get_theme();
    }

    $theme_version = $theme_obj->get('Version');
    $theme_name = $theme_obj->get('Name');
    $theme_uri = $theme_obj->get('ThemeURI');
    $author_uri = $theme_obj->get('AuthorURI');
} else {
    $theme_data = get_theme_data(get_stylesheet_directory_uri().'/style.css' );
    $theme_version = $theme_data['Version'];
    $theme_name = $theme_data['Name'];
    $theme_uri = $theme_data['ThemeURI'];
    $author_uri = $theme_data['AuthorURI'];
}

define( 'NHPOPTIONS', $theme_name.'_hhp-options' );

if(!class_exists('NHP_Options')){
    require_once( dirname( __FILE__ ) . '/options/options.php' );
    require_once( dirname( __FILE__ ) . '/function.ajax.php' );
    require_once( dirname( __FILE__ ) . '/function.get.options.php' );
}


/*
 * 
 * Custom function for filtering the sections array given by theme, good for child themes to override or add to the sections.
 * Simply include this function in the child themes functions.php file.
 *
 * NOTE: the defined constansts for urls, and dir will NOT be available at this point in a child theme, so you must use
 * get_template_directory_uri() if you want to use any of the built in icons
 *
 */
function add_another_section($sections){

    //$sections = array();
    $sections[] = array(
        'title' => __('A Section added by hook', 'crum'),
        'desc' => __('<p class="description">This is a section created by adding a filter to the sections array, great to allow child themes, to add/remove sections from the options.</p>', 'crum'),
        //all the glyphicons are included in the options folder, so you can hook into them, or link to your own custom ones.
        //You dont have to though, leave it blank for default.
        'icon' => trailingslashit(get_template_directory_uri()).'options/img/glyphicons/glyphicons_062_attach.png',
        //Lets leave this as a blank section, no options just some intro text set above.
        'fields' => array()
    );

    return $sections;

}//function
//add_filter('nhp-opts-sections-twenty_eleven', 'add_another_section');


/*
 * 
 * Custom function for filtering the args array given by theme, good for child themes to override or add to the args array.
 *
 */
function change_framework_args($args){

    //$args['dev_mode'] = false;

    return $args;

}//function
//add_filter('nhp-opts-args-twenty_eleven', 'change_framework_args');

/*
 * This is the meat of creating the optons page
 *
 * Override some of the default values, uncomment the args and change the values
 * - no $args are required, but there there to be over ridden if needed.
 *
 *
 */

function setup_framework_options(){
    $args = array();

//Set it to dev mode to view the class settings/info in the form - default is false
    $args['dev_mode'] = false;

//google api key MUST BE DEFINED IF YOU WANT TO USE GOOGLE WEBFONTS
//$args['google_api_key'] = '***';

//Remove the default stylesheet? make sure you enqueue another one all the page will look whack!
//$args['stylesheet_override'] = true;

//Add HTML before the form
    $args['intro_text'] = __('<p>Panel to configure theme options. If you have any questions or suggestions, please write on our forum <a href="http://support.crumina.net"/>support.crumina.net</a></p>', 'crum');

//Setup custom links in the footer for share icons
    $args['share_icons']['twitter'] = array(
        'link' => 'http://twitter.com/Crumina',
        'title' => 'Folow me on Twitter',
        'img' => NHP_OPTIONS_URL.'img/glyphicons/glyphicons_322_twitter.png'
    );
    $args['share_icons']['linked_in'] = array(
        'link' => 'http://support.crumina.net/',
        'title' => 'Support forum',
        'img' => NHP_OPTIONS_URL.'img/glyphicons/glyphicons_049_star.png'
    );

//Choose to disable the import/export feature
//$args['show_import_export'] = false;

//Choose a custom option name for your theme options, the default is the theme name in lowercase with spaces replaced by underscores
    $args['opt_name'] = 'maestro';

    define('NHP_OPT_NAME', $args['opt_name']);

//Custom menu icon
//$args['menu_icon'] = '';

//Custom menu title for options page - default is "Options"
    $args['menu_title'] = __('Theme Options', 'crum');

//Custom Page Title for options page - default is "Options"
    $args['page_title'] = __('Crumina Theme Options panel', 'crum');

//Custom page slug for options page (wp-admin/themes.php?page=***) - default is "nhp_theme_options"
    $args['page_slug'] = 'nhp_theme_options';

//Custom page capability - default is set to "manage_options"
//$args['page_cap'] = 'manage_options';

//page type - "menu" (adds a top menu section) or "submenu" (adds a submenu) - default is set to "menu"
//$args['page_type'] = 'submenu';

//parent menu - default is set to "themes.php" (Appearance)
//the list of available parent menus is available here: http://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters
//$args['page_parent'] = 'themes.php';

//custom page location - default 100 - must be unique or will override other items
    $args['page_position'] = 4;

//Custom page icon class (used to override the page icon next to heading)
//$args['page_icon'] = 'icon-themes';

//Want to disable the sections showing as a submenu in the admin? uncomment this line
//$args['allow_sub_menu'] = false;

//Set ANY custom page help tabs - displayed using the new help tab API, show in order of definition		
    $args['help_tabs'][] = array(
        'id' => 'nhp-opts-1',
        'title' => __('Theme Information 1', 'crum'),
        'content' => __('<p>This is the tab content, HTML is allowed.</p>', 'crum')
    );
    $args['help_tabs'][] = array(
        'id' => 'nhp-opts-2',
        'title' => __('Theme Information 2', 'crum'),
        'content' => __('<p>This is the tab content, HTML is allowed.</p>', 'crum')
    );

    $font_size_options = array(
        '.' => '',
        '9' => '9px',
        '10' => '10px',
        '11' => '11px',
        '12' => '12px',
        '13' => '13px',
        '14' => '14px',
        '16' => '16px',
        '18' => '18px',
        '20' => '20px',
        '22' => '22px',
        '24' => '24px',
        '32' => '32px',
        '40' => '40px',
    );

//Set the Help Sidebar for the options page - no sidebar by default										
    $args['help_sidebar'] = __('<p>This is the sidebar content, HTML is allowed.</p>', 'crum');

    $assets_folder = get_template_directory_uri() .'/assets/';

    $sections = array();


    /*
     *
     * Options will be here
     *
     */


    $sections[] = array(
        'title' => __('Main Options', 'crum'),
        'desc' => __('<p class="description">Main options of site</p>', 'crum'),
        //all the glyphicons are included in the options folder, so you can hook into them, or link to your own custom ones.
        //You dont have to though, leave it blank for default.
        'icon' => NHP_OPTIONS_URL.'img/glyphicons/glyphicons_023_cogwheels.png',
        //Lets leave this as a blank section, no options just some intro text set above.
        'fields' => array(
            array(
                'id' => 'custom_favicon',
                'type' => 'upload',
                'title' => __('Favicon', 'crum'),
                'sub_desc' => __('', 'crum'),
                'desc' => __('Select a 16px X 16px image from the file location on your computer and upload it as a favicon of your site', 'crum')
            ),
            array(
                'id' => 'custom_logo_image',
                'type' => 'upload',
                'title' => __('Header Logotype image', 'crum'),
                'sub_desc' => __('', 'crum'),
                'desc' => __('Select an image from the file location on your computer and upload it as a header logotype', 'crum'),
                'std'  => $assets_folder.'img/logo.png',
            ),
            array(
                'id' => 'custom_logo_text',
                'type' => 'text',
                'title' => __('Logotype text', 'crum'),
                'sub_desc' => __('', 'crum'),
                'desc' => __('If you do not use logo image - you can type text here', 'crum'),
                'std'  => 'Maestro',
            ),

            array(
                'id' => 'logotype_style',
                'type' => 'button_set',
                'title' => __('Logotype style', 'crum'),
                'sub_desc' => __('', 'crum'),
                'desc' => __('Select what type of logo you want.', 'crum'),
                'options' => array('img' => 'Image','txt' => 'Text','no' => 'No logo'),//Must provide key => value pairs for radio options
                'std' => 'img',
            ),
            array(
                'id' => 'top_adress_block',
                'type' => 'button_set',
                'title' => __('Top block with address', 'crum'),
                'sub_desc' => __('', 'crum'),
                'desc' => __('Enable or disable address block', 'crum'),
                'options' => array('off' => 'Off', 'on' => 'On'),
                'std' => 'on'
            ),
            array(
                'id' => 'top_adress_field',
                'type' => 'textarea',
                'title' => __('Top adress panel', 'crum'),
                'sub_desc' => __('Please do not use single qoute here', 'crum'),
                'desc' => __('This is top adress info block.', 'crum'),
                'validate' => 'html',
                'std' => '<span class="mail"><a href="mailto:info@crumina.name">info@crumina.name</a></span> <span class="delim"></span> <span class="phone">+6 948-456-2354</span>
                <div class="lang-sel">
                    <a href="#"><img src="'.$assets_folder.'img/flag/gb.png" alt="GB"></a>
                </div>'
            ),
            array(
                'id' => 'lang_shortcode',
                'type' => 'text',
                'title' => __('Language selection shortcode', 'crum'),
                'sub_desc' => __('', 'crum'),
                'desc' => __('You can type shortcode of language select tht your translating plugin provide', 'crum'),
                'std'  => '',
            ),

            array(
                'id' => 'wpml_lang_show',
                'type' => 'button_set',
                'title' => __('WPML language switcher', 'crum'),
                'sub_desc' => __('', 'crum'),
                'desc' => __('WPML plugin must be installed. It is not packed with theme. You can find it here: http://wpml.org/', 'crum'),
                'options' => array('0' => 'Off', '1' => 'On'),
                'std' => '0'
            ),

            array(
                'id' => 'header_variant',
                'type' => 'button_set',
                'title' => __('Header variant', 'crum'),
                'sub_desc' => __('', 'crum'),
                'desc' => __('', 'crum'),
                'options' => array('v1' => 'Variant 1', 'v2' => 'Variant 2'),
                'std' => 'v2'
            ),
            array(
                'id' => 'custom_js',
                'type' => 'textarea',
                'title' => __('Custom JS', 'crum'),
                'sub_desc' => __('', 'crum'),
                'desc' => __('Generate your tracking code at Google Analytics Service and insert it here.', 'crum'),
            ),
            array(
                'id' => 'custom_css',
                'type' => 'textarea',
                'title' => __('Custom CSS', 'crum'),
                'sub_desc' => __('', 'crum'),
                'desc' => __('You may add any other styles for your theme to this field.', 'crum'),
            ),
        ),

    );
    $sections[] = array(
        'title' => __('Top panel Options', 'crum'),
        'desc' => __('', 'crum'),
        //all the glyphicons are included in the options folder, so you can hook into them, or link to your own custom ones.
        //You dont have to though, leave it blank for default.
        'icon' => NHP_OPTIONS_URL.'img/glyphicons/glyphicons_023_cogwheels.png',
        //Lets leave this as a blank section, no options just some intro text set above.
        'fields' => array(
            array(
                'id' => 'top_panel',
                'type' => 'button_set',
                'title' => __('Display top panel', 'crum'),
                'sub_desc' => __('', 'crum'),
                'desc' => __('Enable or disable top slidin', 'crum'),
                'options' => array('0' => 'Off', '1' => 'On'),
                'std' => '1'
            ),
            array(
                'id' => 'top_panel_login',
                'type' => 'button_set',
                'title' => __('Display login panel', 'crum'),
                'sub_desc' => __('', 'crum'),
                'desc' => __('Enable or disable login form', 'crum'),
                'options' => array('off' => 'Off', 'on' => 'On'),
                'std' => 'on'
            ),
            array(
                'id' => 'top_panel_icon',
                'type' => 'upload',
                'title' => __('Icon for panel text', 'crum'),
                'sub_desc' => __('', 'crum'),
                'desc' => __('You can upload own icon here', 'crum'),
                'std' =>  $assets_folder.'img/icons/top-panel-icon.png'
            ),
            array(
                'id' => 'top_panel_title',
                'type' => 'text',
                'title' => __('Title top panel', 'crum'),
                'sub_desc' => __('', 'crum'),
                'desc' => __('Title of right column', 'crum'),
                'std' => 'A few words about anything'
            ),
            array(
                'id' => 'top_panel_sub_title',
                'type' => 'text',
                'title' => __('Subtitle top panel', 'crum'),
                'sub_desc' => __('', 'crum'),
                'desc' => __('Subtitle of right column', 'crum'),
                'std' => 'And a small subtitle for typography'
            ),
            array(
                'id' => 'top_panel_text',
                'type' => 'editor',
                'title' => __('Text for top panel', 'crum'),
                'sub_desc' => __('', 'crum'),
                'desc' => __('Text, that will displayed in top panel', 'crum'),
                'std' => '<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim qui blandit praesent luptatum zzril delenit augue duis dolore te feugait nulla facilisi. Nam liber tempor cum </p>'
            ),
            ),
        );
    $sections[] = array(
        'title' => __('Social accounts', 'crum'),
        'desc' => __('<p class="description">Type links for social accounts</p>', 'crum'),
        //all the glyphicons are included in the options folder, so you can hook into them, or link to your own custom ones.
        //You dont have to though, leave it blank for default.
        'icon' => NHP_OPTIONS_URL.'img/glyphicons/glyphicons_088_adress_book.png',
        //Lets leave this as a blank section, no options just some intro text set above.
        'fields' => array(
            array(
                'id' => 'fb_link',
                'type' => 'text',
                'title' => __('Facebook link', 'crum'),
                'sub_desc' => __('', 'crum'),
                'desc' => __('Paste link to your account', 'crum'),
                'std' => 'http://facebook.com'
            ),
            array(
                'id' => 'fb_show',
                'type' => 'checkbox',
                'title' => __('Show in header', 'crum'),
                'sub_desc' => __('If checked - will be display in header of theme ', 'crum'),
                'desc' => __('', 'crum'),
                'std' => '1'// 1 = on | 0 = off
            ),
            array(
                'id' => 'tw_link',
                'type' => 'text',
                'title' => __('Twitter link', 'crum'),
                'sub_desc' => __('', 'crum'),
                'desc' => __('Paste link to your account', 'crum'),
                'std' => 'http://twitter.com'
            ),
            array(
                'id' => 'tw_show',
                'type' => 'checkbox',
                'title' => __('Show in header', 'crum'),
                'sub_desc' => __('If checked - will be display in header of theme ', 'crum'),
                'desc' => __('', 'crum'),
                'std' => '1'// 1 = on | 0 = off
            ),
            array(
                'id' => 'fl_link',
                'type' => 'text',
                'title' => __('Flickr link', 'crum'),
                'sub_desc' => __('', 'crum'),
                'desc' => __('Paste link to your account', 'crum'),
                'std' => 'http://flickr.com'
            ),
            array(
                'id' => 'fl_show',
                'type' => 'checkbox',
                'title' => __('Show in header', 'crum'),
                'sub_desc' => __('If checked - will be display in header of theme ', 'crum'),
                'desc' => __('', 'crum'),
                'std' => '0'// 1 = on | 0 = off
            ),
            array(
                'id' => 'vi_link',
                'type' => 'text',
                'title' => __('Vimeo link', 'crum'),
                'sub_desc' => __('', 'crum'),
                'desc' => __('Paste link to your account', 'crum'),
                'std' => 'http://vimeo.com'
            ),
            array(
                'id' => 'vi_show',
                'type' => 'checkbox',
                'title' => __('Show in header', 'crum'),
                'sub_desc' => __('If checked - will be display in header of theme ', 'crum'),
                'desc' => __('', 'crum'),
                'std' => '0'// 1 = on | 0 = off
            ),
            array(
                'id' => 'lf_link',
                'type' => 'text',
                'title' => __('Last FM link', 'crum'),
                'sub_desc' => __('', 'crum'),
                'desc' => __('Paste link to your account', 'crum'),
                'std' => 'http://lastfm.com'
            ),
            array(
                'id' => 'lf_show',
                'type' => 'checkbox',
                'title' => __('Show in header', 'crum'),
                'sub_desc' => __('If checked - will be display in header of theme ', 'crum'),
                'desc' => __('', 'crum'),
                'std' => '0'// 1 = on | 0 = off
            ),
            array(
                'id' => 'dr_link',
                'type' => 'text',
                'title' => __('Dribble link', 'crum'),
                'sub_desc' => __('', 'crum'),
                'desc' => __('Paste link to your account', 'crum'),
                'std' => 'http://dribble.com'
            ),
            array(
                'id' => 'dr_show',
                'type' => 'checkbox',
                'title' => __('Show in header', 'crum'),
                'sub_desc' => __('If checked - will be display in header of theme ', 'crum'),
                'desc' => __('', 'crum'),
                'std' => '1'// 1 = on | 0 = off
            ),
            array(
                'id' => 'yt_link',
                'type' => 'text',
                'title' => __('YouTube', 'crum'),
                'sub_desc' => __('', 'crum'),
                'desc' => __('Paste link to your account', 'crum'),
                'std' => 'http://youtube.com'
            ),
            array(
                'id' => 'yt_show',
                'type' => 'checkbox',
                'title' => __('Show in header', 'crum'),
                'sub_desc' => __('If checked - will be display in header of theme ', 'crum'),
                'desc' => __('', 'crum'),
                'std' => '0'// 1 = on | 0 = off
            ),
            array(
                'id' => 'ms_link',
                'type' => 'text',
                'title' => __('Microsoft ID', 'crum'),
                'sub_desc' => __('', 'crum'),
                'desc' => __('Paste link to your account', 'crum'),
                'std' => 'https://accountservices.passport.net/'
            ),
            array(
                'id' => 'ms_show',
                'type' => 'checkbox',
                'title' => __('Show in header', 'crum'),
                'sub_desc' => __('If checked - will be display in header of theme ', 'crum'),
                'desc' => __('', 'crum'),
                'std' => '0'// 1 = on | 0 = off
            ),
            array(
                'id' => 'li_link',
                'type' => 'text',
                'title' => __('LinkedIN', 'crum'),
                'sub_desc' => __('', 'crum'),
                'desc' => __('Paste link to your account', 'crum'),
                'std' => 'http://linkedin.com'
            ),
            array(
                'id' => 'li_show',
                'type' => 'checkbox',
                'title' => __('Show in header', 'crum'),
                'sub_desc' => __('If checked - will be display in header of theme ', 'crum'),
                'desc' => __('', 'crum'),
                'std' => '1'// 1 = on | 0 = off
            ),
            array(
                'id' => 'gp_link',
                'type' => 'text',
                'title' => __('Google +', 'crum'),
                'sub_desc' => __('', 'crum'),
                'desc' => __('Paste link to your account', 'crum'),
                'std' => 'https://accounts.google.com/'
            ),
            array(
                'id' => 'gp_show',
                'type' => 'checkbox',
                'title' => __('Show in header', 'crum'),
                'sub_desc' => __('If checked - will be display in header of theme ', 'crum'),
                'desc' => __('', 'crum'),
                'std' => '1'// 1 = on | 0 = off
            ),
            array(
                'id' => 'pi_link',
                'type' => 'text',
                'title' => __('Picasa', 'crum'),
                'sub_desc' => __('', 'crum'),
                'desc' => __('Paste link to your account', 'crum'),
                'std' => 'http://picasa.com'
            ),
            array(
                'id' => 'pi_show',
                'type' => 'checkbox',
                'title' => __('Show in header', 'crum'),
                'sub_desc' => __('If checked - will be display in header of theme ', 'crum'),
                'desc' => __('', 'crum'),
                'std' => '0'// 1 = on | 0 = off
            ),
            array(
                'id' => 'pt_link',
                'type' => 'text',
                'title' => __('Pinterest', 'crum'),
                'sub_desc' => __('', 'crum'),
                'desc' => __('Paste link to your account', 'crum'),
                'std' => 'http://pinterest.com'
            ),
            array(
                'id' => 'pt_show',
                'type' => 'checkbox',
                'title' => __('Show in header', 'crum'),
                'sub_desc' => __('If checked - will be display in header of theme ', 'crum'),
                'desc' => __('', 'crum'),
                'std' => '0'// 1 = on | 0 = off
            ),
            array(
                'id' => 'wp_link',
                'type' => 'text',
                'title' => __('Wordpress', 'crum'),
                'sub_desc' => __('', 'crum'),
                'desc' => __('Paste link to your account', 'crum'),
                'std' => 'http://wordpress.com'
            ),
            array(
                'id' => 'wp_show',
                'type' => 'checkbox',
                'title' => __('Show in header', 'crum'),
                'sub_desc' => __('If checked - will be display in header of theme ', 'crum'),
                'desc' => __('', 'crum'),
                'std' => '0'// 1 = on | 0 = off
            ),
            array(
                'id' => 'db_link',
                'type' => 'text',
                'title' => __('Dropbox', 'crum'),
                'sub_desc' => __('', 'crum'),
                'desc' => __('Paste link to your account', 'crum'),
                'std' => 'http://dropbox.com'
            ),
            array(
                'id' => 'db_show',
                'type' => 'checkbox',
                'title' => __('Show in header', 'crum'),
                'sub_desc' => __('If checked - will be display in header of theme ', 'crum'),
                'desc' => __('', 'crum'),
                'std' => '0'// 1 = on | 0 = off
            ),
            array(
                'id' => 'rss_link',
                'type' => 'text',
                'title' => __('RSS', 'crum'),
                'sub_desc' => __('', 'crum'),
                'desc' => __('Paste alternative link to Rss', 'crum'),
                'std' => ''
            ),
            array(
                'id' => 'rss_show',
                'type' => 'checkbox',
                'title' => __('Show in header', 'crum'),
                'sub_desc' => __('If checked - will be display in header of theme ', 'crum'),
                'desc' => __('', 'crum'),
                'std' => '0'// 1 = on | 0 = off
            ),
        ),
    );

    $sections[] = array(
        'title' => __('Posts list options', 'crum'),
        'desc' => __('<p class="description">Parameters for posts and archives (social share etc)</p>', 'crum'),
        //all the glyphicons are included in the options folder, so you can hook into them, or link to your own custom ones.
        //You dont have to though, leave it blank for default.
        'icon' => NHP_OPTIONS_URL . 'img/glyphicons/glyphicons_144_folder_open.png',
        //Lets leave this as a blank section, no options just some intro text set above.
        'fields' => array(

            array(
                'id' => 'post_format',
                'type' => 'select',
                'title' => __('Select format for posts displaying', 'crum'),
                'sub_desc' => __('', 'crum'),
                'desc' => __('', 'crum'),
                'options' => array('thumb-left' => 'Thumbnail on left','thumb-right' => 'Thumbnail on right','thumb-center' => 'Default',),
                'std' => 'thumb-center'// 1 = on | 0 = off
            ),

            array(
                'id' => 'post_share_button',
                'type' => 'button_set',
                'title' => __('Social share buttons', 'crum'),
                'sub_desc' => __('', 'crum'),
                'desc' => __('With this option you may activate or deactivate social share buttons.', 'crum'),
                'options' => array('0' => 'Off','1' => 'On'),
                'std' => '1'// 1 = on | 0 = off
            ),
            array(
                'id' => 'custom_share_code',
                'type' => 'textarea',
                'title' => __('Custom share code', 'crum'),
                'sub_desc' => __('', 'crum'),
                'desc' => __('You may add any other social share buttons to this field.', 'crum'),
            ),

            array(
                'id' => 'autor_box_disp',
                'type' => 'button_set',
                'title' => __('Author Info', 'crum'),
                'sub_desc' => __('', 'crum'),
                'desc' => __('This option enables you to insert information about the author of the post.', 'crum'),
                'options' => array('0' => 'Off','1' => 'On'),
                'std' => '1'// 1 = on | 0 = off
            ),
            array(
                'id' => 'links_box_disp',
                'type' => 'button_set',
                'title' => __('Links in author info', 'crum'),
                'sub_desc' => __('', 'crum'),
                'desc' => __('Enable or disable additional links in author box', 'crum'),
                'options' => array('0' => 'Off','1' => 'On'),
                'std' => '1'// 1 = on | 0 = off
            ),

            array(
                'id' => 'pagination_style',
                'type' => 'button_set', //the field type
                'title' => __('Pagination type', 'crum'),
                'sub_desc' => __('', 'crum'),
                'desc' => __('This option enables you to choose pagination type.', 'crum'),
                'options' => array('1' => __('Prev/next butt.', 'crum'), '2' => __('Pages list', 'crum')),
                'std' => '1'//this should be the key as defined above
            ),

            array(
                'id' => 'thumb_inner_disp',
                'type' => 'button_set', //the field type
                'title' => __('Thumbnail on inner page', 'crum'),
                'sub_desc' => __('', 'crum'),
                'desc' => __('Display featured image on single post', 'crum'),
                'options' => array('1' => __('On', 'crum'), '0' => __('Off', 'crum')),
                'std' => '0'//this should be the key as defined above
            ),

            array(
                'id' => 'post_thumbnails_width',
                'type' => 'text',
                'title' => __('Post thumbnail width (in px)', 'crum'),
                'sub_desc' => __('', 'crum'),
                'desc' => __('', 'crum'),
                'validate' => 'numeric',
                'std' => '1200'
            ),
            array(
                'id' => 'post_thumbnails_height',
                'type' => 'text',
                'title' => __('Post  thumbnail height (in px)', 'crum'),
                'sub_desc' => __('', 'crum'),
                'desc' => __('', 'crum'),
                'validate' => 'numeric',
                'std' => '300',
            ),
            
            /*array(
                'id' => 'post_inner_header',
                'type' => 'button_set',
                'title' => __('Post info', 'crum'),
                'sub_desc' => __('', 'crum'),
                'desc' => __('It is information about the post (time and date of creation, author, comments on the post).', 'crum'),
                'options' => array('1' => __('On', 'crum'), '0' => __('Off', 'crum')),
                'std' => '0'//this should be the key as defined above
            ),
*/

        ),
    );

    $sections[] = array(
        'title' => __('Portfolio Options', 'crum'),
        'desc' => __('', 'crum'),
        //all the glyphicons are included in the options folder, so you can hook into them, or link to your own custom ones.
        //You dont have to though, leave it blank for default.
        'icon' => NHP_OPTIONS_URL.'img/glyphicons/glyphicons_234_brush.png',
        //Lets leave this as a blank section, no options just some intro text set above.
        'fields' => array(
            array(
                'id' => 'portfolio_page_select',
                'type' => 'pages_select',
                'title' => __('Portfolio page', 'crum'),
                'sub_desc' => __('', 'crum'),
                'desc' => __('Please select main portfolio page (for proper urls)', 'crum'),
                'args' => array()//uses get_pages
            ),
            array(
                'id' => 'folio_sorting',
                'type' => 'button_set',
                'title' => __('Sorting items', 'crum'),
                'sub_desc' => __('', 'crum'),
                'desc' => __('', 'crum'),
                'options' => array('1' => __('On', 'crum'), '0' => __('Off', 'crum')),
                'std' => '1'//this should be the key as defined above
            ),
            array(
                'id' => 'portfolio_columns',
                'type' => 'select_hide_below',
                'title' => __('Portfolio columns', 'crum'),
                'sub_desc' => __('', 'crum'),
                'desc' => __('', 'crum'),
                'options' => array(
                    '1column' => array( 'name' => 'Single row', 'allow' => 'false'),
                    '2column' => array( 'name' => 'Two Columns', 'allow' => 'false'),
                    '3column' => array( 'name' => 'Three Columns', 'allow' => 'false'),
                    '4column' => array( 'name' => 'Four columns', 'allow' => 'true')
                ),
                'std' => '2column'
            ),

            array(
                'id' => 'portfolio_style',
                'type' => 'button_set',
                'title' => __('Portfolio style', 'crum'),
                'sub_desc' => __('', 'crum'),
                'desc' => __('', 'crum'),
                'options' => array('square' => __('Square', 'crum'), 'round' => __('Round', 'crum')),
                'std' => 'square'//this should be the key as defined above
            ),

            array(
                'id' => 'folio_date',
                'type' => 'button_set',
                'title' => __('Date in portfolio', 'crum'),
                'sub_desc' => __('', 'crum'),
                'desc' => __('', 'crum'),
                'options' => array('1' => __('On', 'crum'), '0' => __('Off', 'crum')),
                'std' => '1'//this should be the key as defined above
            ),

            array(
                'id' => 'portfolio_single_style',
                'type' => 'button_set', //the field type
                'title' => __('Portfolio text location', 'crum'),
                'sub_desc' => __('', 'crum'),
                'desc' => __('', 'crum'),
                'options' =>array(
                    'left'=>'To the right',
                    'full'=>'Full width',
                ),
                'std' => 'left',
            ),
            array(
                'id' => 'portfolio_single_featured',
                'type' => 'button_set', //the field type
                'title' => __('Featured image', 'crum'),
                'sub_desc' => __('', 'crum'),
                'desc' => __('', 'crum'),
                'options' => array('1' => __('On', 'crum'), '0' => __('Off', 'crum')),
                'std' => '1'//this should be the key as defined above
            ),
            array(
                'id' => 'portfolio_single_slider',
                'type' => 'button_set', //the field type
                'title' => __('Portfolio image display', 'crum'),
                'sub_desc' => __('', 'crum'),
                'desc' => __('', 'crum'),
                'options' =>array(
                    'slider'=>'Slider',
                    'full'=>'Items',
                ),
                'std' => 'slider',
            ),
            array(
                'id' => 'order_folio_images',
                'type' => 'select',
                'title' => __('Sort images in portfolio single', 'crum'),
                'sub_desc' => __('', 'crum'),
                'desc' => __('', 'crum'),
                'options' => array('post_date'=>'Date of publication','title' => 'Title','rand' => 'Display random','menu_order' => 'As in gallery'),
                'std' => 'menu_order'
            ),
            array(
                'id' => 'sort_order_folio_images',
                'type' => 'button_set', //the field type
                'title' => __('Images order', 'crum'),
                'sub_desc' => __('', 'crum'),
                'desc' => __('', 'crum'),
                'options' =>array(
                    'ASC'=>'Sort ascending',
                    'DESC'=>'Sort descending',
                ),
                'std' => 'DESC',
            ),
            array(
                'id' => 'recent_block_title',
                'type' => 'text',
                'title' => __('Recent block title', 'crum'),
                'sub_desc' => __('', 'crum'),
                'desc' => __('', 'crum'),
                'std' => 'Recent works',
            ),
            array(
                'id' => 'recent_block_subtitle',
                'type' => 'text',
                'title' => __('Recent block subtitle', 'crum'),
                'sub_desc' => __('', 'crum'),
                'desc' => __('', 'crum'),
                'std' => 'Small subtitle here',
            ),
			array(
				'id' => 'custom_portfolio_slug',
				'type' => 'text',
				'title' => __('Custom slug for portfolio items', 'crum'),
				'desc' => __('<p>After change please go to <a href="options-permalink.php">Settings -> Permalinks</a> and press "Save changes" button to Save New permalinks</p>', 'crum'),
				'sub_desc' => __('<p>Please write on latin without spaces</p>', 'crum'),
				'std' => ''
			),


        ),
    );
    $sections[] = array(
        'title' => __('Unlimited sidebars', 'crum'),
        'desc' => __('<p class="description">Add or delete your own sidebars</p>', 'crum'),
        //all the glyphicons are included in the options folder, so you can hook into them, or link to your own custom ones.
        //You dont have to though, leave it blank for default.
        'icon' => NHP_OPTIONS_URL.'img/glyphicons/glyphicons_154_show_big_thumbnails.png',
        //Lets leave this as a blank section, no options just some intro text set above.
        'fields' => array(
            array(
                'id' => 'custom_sidebars',
                'type' => 'custom_sidebars',
                'title' => __('Custom sidebar name', 'crum'),
                'sub_desc' => __('', 'crum'),
                'desc' => __('You may create a custom sidebar to be displayed on a single page.', 'crum'),
                'validate' => 'html', //see http://codex.wordpress.org/Function_Reference/wp_kses_post
                'std' => ''
            ),
        ),
    );

    $sections[] = array(
        'title' => __('Styling Options', 'crum'),
        'desc' => __('<p class="description">Style parameters of body and footer</p>', 'crum'),
        //all the glyphicons are included in the options folder, so you can hook into them, or link to your own custom ones.
        //You dont have to though, leave it blank for default.
        'icon' => NHP_OPTIONS_URL.'img/glyphicons/glyphicons_234_brush.png',
        //Lets leave this as a blank section, no options just some intro text set above.
        'fields' => array(


            array(
                'id' => 'color_version_site',
                'type' => 'button_set',
                'title' => __('Site color version', 'crum'),
                'sub_desc' => __('', 'crum'),
                'desc' => __('', 'crum'),
                'options' => array('white-skin' => 'White','dark-skin' => 'Dark'),
                'std' => 'white-skin'// 1 = on | 0 = off
            ),

            array(
                'id' => 'main_menu_position',
                'type' => 'button_set', //the field type
                'title' => __('Main menu alignment', 'crum'),
                'sub_desc' => __('', 'crum'),
                'desc' => __('', 'crum'),
                'options' =>array(
                    'left'=>'Left',
                    'right'=>'Right',
                ),
                'std' => 'right',
            ),

            array(
                'id' => 'main_site_color',
                'type' => 'color',
                'title' => __('Main site color', 'crum'),
                'sub_desc' => __('', 'crum'),
                'desc' => __('Color of buttons, tabs, links, borders etc.', 'crum'),
                'std' => '#50b4e6'
            ),
            array(
                'id' => 'secondary_site_color',
                'type' => 'color',
                'title' => __('Secondary site color', 'crum'),
                'sub_desc' => __('', 'crum'),
                'desc' => __('Color of inactive or hovered elements', 'crum'),
                'std' => '#f36f5f'
            ),

            array(
                'id' => 'site_boxed',
                'type' => 'select_hide_show_opts',
                'title' => __('Body layout', 'crum'),
                'sub_desc' => __('', 'crum'),
                'desc' => __('', 'crum'),
                'options' => array('0' => 'Full width', '1' => 'Boxed'),
                'std' => '0',// 1 = on | 0 = off,
                'options_to_show' => array(
                    '1'=>"wrapper_bg_color,wrapper_bg_image,wrapper_custom_repeat",
                    "0"=>""
                ),
            ),

            //Body wrapper
            array(
                'id' => 'wrapper_bg_color',
                'type' => 'color',
                'title' => __('Content background color', 'crum'),
                'sub_desc' => __('', 'crum'),
                'desc' => __('Select background color.', 'crum'),
                'std' => ''
            ),
            array(
                'id' => 'wrapper_bg_image',
                'type' => 'upload',
                'title' => __('Content background image', 'crum'),
                'sub_desc' => __('', 'crum'),
                'desc' => __('Upload your own background image or pattern.', 'crum')
            ),
            array(
                'id' => 'wrapper_custom_repeat',
                'type' => 'select',
                'title' => __('Content bg image repeat', 'crum'),
                'sub_desc' => __('', 'crum'),
                'desc' => __('Select type background image repeat', 'crum'),
                'options' => array('repeat-y' => 'vertically','repeat-x' => 'horizontally','no-repeat' => 'no-repeat', 'repeat' => 'both vertically and horizontally', ),//Must provide key => value pairs for select options
                'std' => 'repeat'
            ),


            //Body wrapper
            array(
                'id' => 'body_bg_color',
                'type' => 'color',
                'title' => __('Body background color', 'crum'),
                'sub_desc' => __('', 'crum'),
                'desc' => __('Select background color.', 'crum'),
                'std' => ''
            ),
            array(
                'id' => 'body_bg_image',
                'type' => 'upload',
                'title' => __('Custom background image', 'crum'),
                'sub_desc' => __('', 'crum'),
                'desc' => __('Upload your own background image or pattern.', 'crum')
            ),
            array(
                'id' => 'body_custom_repeat',
                'type' => 'select',
                'title' => __('Background image repeat', 'crum'),
                'sub_desc' => __('', 'crum'),
                'desc' => __('Select type background image repeat', 'crum'),
                'options' => array('repeat-y' => 'vertically','repeat-x' => 'horizontally','no-repeat' => 'no-repeat', 'repeat' => 'both vertically and horizontally', ),//Must provide key => value pairs for select options
                'std' => ''
            ),
            array(
                'id' => 'body_bg_fixed',
                'type' => 'button_set',
                'title' => __('Fixed body background', 'crum'),
                'sub_desc' => __('', 'crum'),
                'desc' => __('', 'crum'),
                'options' => array('0' => 'Off','1' => 'On'),
                'std' => '0'// 1 = on | 0 = off
            ),
            array(
                'id' => 'footer_bg_color',
                'type' => 'color',
                'title' => __('Footer background color', 'crum'),
                'sub_desc' => __('', 'crum'),
                'desc' => __('Select footer background color. ', 'crum'),
                'std' => ''
            ),
            array(
                'id' => 'footer_font_color',
                'type' => 'color',
                'title' => __('Footer font color', 'crum'),
                'sub_desc' => __('', 'crum'),
                'desc' => __('Select footer font color.', 'crum'),
                'std' => ''
            ),
            array(
                'id' => 'footer_bg_image',
                'type' => 'upload',
                'title' => __('Custom footer background image', 'crum'),
                'sub_desc' => __('', 'crum'),
                'desc' => __('Upload your own footer background image or pattern.', 'crum')
            ),
            array(
                'id' => 'footer_custom_repeat',
                'type' => 'select',
                'title' => __('Footer background image repeat', 'crum'),
                'sub_desc' => __('', 'crum'),
                'desc' => __('Select type background image repeat', 'crum'),
                'options' => array('repeat-y' => 'vertically','repeat-x' => 'horizontally','no-repeat' => 'no-repeat', 'repeat' => 'both vertically and horizontally', ),//Must provide key => value pairs for select options
                'std' => ''
            ),



        ),
    );

    $sections[] = array(
        'title' => __('Contact page options', 'crum'),
        'desc' => __('<p class="description">Contact page options</p>', 'crum'),
        //all the glyphicons are included in the options folder, so you can hook into them, or link to your own custom ones.
        //You dont have to though, leave it blank for default.
        'icon' => NHP_OPTIONS_URL.'img/glyphicons/glyphicons_024_parents.png',
        //Lets leave this as a blank section, no options just some intro text set above.
        'fields' => array(
            array(
                'id' => 'text_contact_page',
                'type' => 'editor',
                'title' => __('Text on top', 'crum'),
                'sub_desc' => __('', 'crum'),
                'desc' => __('This is the description field, again good for additional info.', 'crum'),
                'std' => '<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Nam cursus. Morbi ut mi. Nullam enim leo, egestas id, condimentum at, laoreet mattis, massa. Sed eleifend nonummy diam. Praesent mauris ante, elementum et, bibendum at, posuere sit amet, nibh. Duis tincidunt lectus quis dui viverra vestibulum. Suspendisse vulputate aliquam dui. Nulla elementum dui ut augue. Aliquam vehicula mi at mauris. Maecenas placerat, nisl at consequat rhoncus, sem nunc gravida justo, quis eleifend arcu velit quis lacus. Morbi magna magna, tincidunt a, mattis non, imperdiet vitae, tellus. Sed odio est, auctor ac, sollicitudin in, consequat vitae, orci. Fusce id felis. Vivamus sollicitudin metus eget eros.</p>',
            ),
            array(
                'id' => 'adress_contact_page',
                'type' => 'textarea',
                'title' => __('Adress in contact page', 'crum'),
                'std' => '<div class="contact-info">
				<div class="page-block-title">
					<h2>Contact info</h2>
				</div>
				<div class="contact-desc">
					<small><b>Address:</b></small> Street 9890, New Something 1234, Country <br />
					<small><b>Telephone:</b></small> 1234 5678<br />
					<small><b>Fax:</b></small> 9876 5432<br />
				</div>
			</div>
			<div class="contact-info">
				<div class="page-block-title">
					<h2>Support info</h2>
				</div>
				<div class="contact-desc">
					<small><b>Telephone:</b></small> 1234 5678 <br />
					<small><b>Fax:</b></small> 9876 5432<br />
					<small><b>Email:</b></small> <a href="#">ouremail@planetearth.com</a><br />
				</div>
			</div>',

            ),
            array(
                'id' => 'other_contact_page',
                'type' => 'textarea',
                'title' => __('Additional text ', 'crum'),
                'std' => '<div class="page-block-title">
				<h2>Director says</h2>
			</div>
			<p>Phasellus felis dolor, scelerisque a, tempus eget, lobortis id, libero. Donec scelerisque leo ac risus. Praesent sit amet est. In dictum, dolor eu dictum porttitor, enim felis viverra mi, eget luctus massa purus quis odio. Etiam nulla massa, pharetra facilisis, volutpat in, imperdiet sit amet, sem. Aliquam nec erat at purus cursus interdum. Vestibulum ligula augue, bibendum accumsan, vestibulum ut, commodo a, mi. Morbi ornare gravida elit. Integer congue, augue et malesuada iaculis, ipsum dui aliquet felis, at cursus magna nisl nec elit. Donec iaculis diam a nisi accumsan viverra. Duis sed tellus </p>',
            ),
            array(
                'id' => 'custom_form_shortcode',
                'type' => 'text',
                'title' => __('Custom Form Shortcode', 'crum'),
                'sub_desc' => __('', 'crum'),
                'desc' => __('You can paste your shorcode custom form', 'crum'),
                'std' =>''
            ),
			array(
				'id' => 'cont_m_disp',
				'type' => 'button_set',
				'title' => __('Display map on contacts page?', 'crum'),
				'options' => array('1' => __('On', 'crum'), '0' => __('Off', 'crum')),
				'std' => '1'// 1 = on | 0 = off
			),
			array(
				'id' => 'map_title',
				'type' => 'text',
				'title' => __('Map title','crum'),
				'std' => ''
			),
			array(
				'id' => 'map_subtitle',
				'type' => 'text',
				'title' => __('Map subtitle','crum'),
				'std' => ''
			),
			array(
				'id' => 'cont_m_height',
				'type' => 'text',
				'title' => __('Height of Google Map (in px)', 'crum'),

				'std' =>''
			),
			array(
				'id' => 'cont_m_zoom',
				'type' => 'text',
				'title' => __('Zoom Level', 'crum'),
				'std' =>'14'
			),
			array(
				'id' => 'map_address',
				'type' => 'multi_text',
				'title' => __('Address on Google Map ', 'crum'),
				'desc' => __('Fill in your address to be shown on Google map.', 'crum'),
				'std' =>'London, Downing street, 10'
			),
            array(
                'id' => 'contacts_form_mail',
                'type' => 'text',
                'title' => __('Form address', 'crum'),
                'sub_desc' => __('', 'crum'),
                'desc' => __('Email address for contact form', 'crum'),
                'std' => get_option('admin_email')
            ),

        ),
    );

    $sections[] = array(
        'title' => __('Footer section options', 'crum'),
        'desc' => __('<p class="description">Footer section options</p>', 'crum'),
        //all the glyphicons are included in the options folder, so you can hook into them, or link to your own custom ones.
        //You dont have to though, leave it blank for default.
        'icon' => NHP_OPTIONS_URL.'img/glyphicons/glyphicons_024_parents.png',
        //Lets leave this as a blank section, no options just some intro text set above.
        'fields' => array(

            array(
                'id' => 'copyright_footer',
                'type' => 'text',
                'title' => __('Show copyright', 'crum'),
                'sub_desc' => __('', 'crum'),
                'desc' => __('Fill in the copyright text.', 'crum'),
                'validate' => 'html', //see http://codex.wordpress.org/Function_Reference/wp_kses_post
                'std' => 'My copyright info 2013'
            ),

),
    );


    $sections[] = array(
        'icon' => NHP_OPTIONS_URL.'img/glyphicons/glyphicons_157_show_lines.png',
        'title' => __('Layouts Settings', 'crum'),
        'desc' => __('<p class="description">Configure layouts of different pages</p>', 'crum'),
        'fields' => array(
            array(
                'id' => 'pages_layout',
                'type' => 'radio_img',
                'title' => __('Single pages layout', 'crum'),
                'sub_desc' => __('Select one type of layout for single pages', 'crum'),
                'desc' => __('', 'crum'),
                'options' => array(
                    '1col-fixed' => array('title' => 'No sidebars', 'img' => NHP_OPTIONS_URL.'img/1col.png'),
                    '2c-l-fixed' => array('title' => 'Sidebar on left', 'img' => NHP_OPTIONS_URL.'img/2cl.png'),
                    '2c-r-fixed' => array('title' => 'Sidebar on right', 'img' => NHP_OPTIONS_URL.'img/2cr.png'),
                    '3c-l-fixed' => array('title' => '2 left sidebars', 'img' => NHP_OPTIONS_URL.'img/3cl.png'),
                    '3c-fixed' => array('title' => 'Sidebar on either side', 'img' => NHP_OPTIONS_URL.'img/3cc.png'),
                    '3c-r-fixed' => array('title' => '2 right sidebars', 'img' => NHP_OPTIONS_URL.'img/3cr.png'),
                ),//Must provide key => value(array:title|img) pairs for radio options
                'std' => '1col-fixed'
            ),
            array(
                'id' => 'archive_layout',
                'type' => 'radio_img',
                'title' => __('Archive Pages Layout', 'crum'),
                'sub_desc' => __('Select one type of layout for archive pages', 'crum'),
                'desc' => __('', 'crum'),
                'options' => array(
                    '1col-fixed' => array('title' => 'No sidebars', 'img' => NHP_OPTIONS_URL.'img/1col.png'),
                    '2c-l-fixed' => array('title' => 'Sidebar on left', 'img' => NHP_OPTIONS_URL.'img/2cl.png'),
                    '2c-r-fixed' => array('title' => 'Sidebar on right', 'img' => NHP_OPTIONS_URL.'img/2cr.png'),
                    '3c-l-fixed' => array('title' => '2 left sidebars', 'img' => NHP_OPTIONS_URL.'img/3cl.png'),
                    '3c-fixed' => array('title' => 'Sidebar on either side', 'img' => NHP_OPTIONS_URL.'img/3cc.png'),
                    '3c-r-fixed' => array('title' => '2 right sidebars', 'img' => NHP_OPTIONS_URL.'img/3cr.png'),
                ),//Must provide key => value(array:title|img) pairs for radio options
                'std' => '2c-l-fixed'
            ),
            array(
                'id' => 'single_layout',
                'type' => 'radio_img',
                'title' => __('Single posts layout', 'crum'),
                'sub_desc' => __('Select one type of layout for single posts', 'crum'),
                'desc' => __('', 'crum'),
                'options' => array(
                    '1col-fixed' => array('title' => 'No sidebars', 'img' => NHP_OPTIONS_URL.'img/1col.png'),
                    '2c-l-fixed' => array('title' => 'Sidebar on left', 'img' => NHP_OPTIONS_URL.'img/2cl.png'),
                    '2c-r-fixed' => array('title' => 'Sidebar on right', 'img' => NHP_OPTIONS_URL.'img/2cr.png'),
                    '3c-l-fixed' => array('title' => '2 left sidebars', 'img' => NHP_OPTIONS_URL.'img/3cl.png'),
                    '3c-fixed' => array('title' => 'Sidebar on either side', 'img' => NHP_OPTIONS_URL.'img/3cc.png'),
                    '3c-r-fixed' => array('title' => '2 right sidebars', 'img' => NHP_OPTIONS_URL.'img/3cr.png'),
                ),//Must provide key => value(array:title|img) pairs for radio options
                'std' => '2c-l-fixed'
            ),
            array(
                'id' => 'search_layout',
                'type' => 'radio_img',
                'title' => __('Search results layout', 'crum'),
                'sub_desc' => __('Select one type of layout for search results', 'crum'),
                'desc' => __('', 'crum'),
                'options' => array(
                    '1col-fixed' => array('title' => 'No sidebars', 'img' => NHP_OPTIONS_URL.'img/1col.png'),
                    '2c-l-fixed' => array('title' => 'Sidebar on left', 'img' => NHP_OPTIONS_URL.'img/2cl.png'),
                    '2c-r-fixed' => array('title' => 'Sidebar on right', 'img' => NHP_OPTIONS_URL.'img/2cr.png'),
                    '3c-l-fixed' => array('title' => '2 left sidebars', 'img' => NHP_OPTIONS_URL.'img/3cl.png'),
                    '3c-fixed' => array('title' => 'Sidebar on either side', 'img' => NHP_OPTIONS_URL.'img/3cc.png'),
                    '3c-r-fixed' => array('title' => '2 right sidebars', 'img' => NHP_OPTIONS_URL.'img/3cr.png'),
                ),//Must provide key => value(array:title|img) pairs for radio options
                'std' => '2c-l-fixed'
            ),
            array(
                'id' => '404_layout',
                'type' => 'radio_img',
                'title' => __('404 Page Layout', 'crum'),
                'sub_desc' => __('Select one of layouts for 404 page', 'crum'),
                'desc' => __('', 'crum'),
                'options' => array(
                    '1col-fixed' => array('title' => 'No sidebars', 'img' => NHP_OPTIONS_URL.'img/1col.png'),
                    '2c-l-fixed' => array('title' => 'Sidebar on left', 'img' => NHP_OPTIONS_URL.'img/2cl.png'),
                    '2c-r-fixed' => array('title' => 'Sidebar on right', 'img' => NHP_OPTIONS_URL.'img/2cr.png'),
                    '3c-l-fixed' => array('title' => '2 left sidebars', 'img' => NHP_OPTIONS_URL.'img/3cl.png'),
                    '3c-fixed' => array('title' => 'Sidebar on either side', 'img' => NHP_OPTIONS_URL.'img/3cc.png'),
                    '3c-r-fixed' => array('title' => '2 right sidebars', 'img' => NHP_OPTIONS_URL.'img/3cr.png'),
                ),//Must provide key => value(array:title|img) pairs for radio options
                'std' => '2c-l-fixed'
            )
        ),
    );

    $sections[] = array(
        'title' => __('Icons customization', 'crum'),
        'desc' => __('', 'crum'),
        //all the glyphicons are included in the options folder, so you can hook into them, or link to your own custom ones.
        //You dont have to though, leave it blank for default.
        'icon' => NHP_OPTIONS_URL.'img/glyphicons/glyphicons_234_brush.png',
        //Lets leave this as a blank section, no options just some intro text set above.
        'fields' => array(
            array(
                'id' => 'default_widget_icon',
                'type' => 'upload',
                'title' => __('Default widget icon', 'crum'),
                'std'  => $assets_folder.'img/icons/tags1.png',
            ),
            array(
                'id' => 'search-widget_icon',
                'type' => 'upload',
                'title' => __('Search widget', 'crum'),
                'sub_desc' => __('', 'crum'),
                'desc' => __('', 'crum'),
            ),
            array(
                'id' => 'recent_block_icon',
                'type' => 'upload',
                'title' => __('Recent from portfolio block', 'crum'),
                'sub_desc' => __('', 'crum'),
                'desc' => __('', 'crum'),
                'std'  => $assets_folder.'img/icons/rfp1.png',
            ),
            array(
                'id' => 'crum_news_cat_icon',
                'type' => 'upload',
                'title' => __('News from category block', 'crum'),
                'sub_desc' => __('', 'crum'),
                'desc' => __('', 'crum'),
                'std'  => $assets_folder.'img/icons/nfc.png',
            ),
            array(
                'id' => 'list_widget_icon',
                'type' => 'upload',
                'title' => __('Styled list widget', 'crum'),
                'sub_desc' => __('', 'crum'),
                'desc' => __('', 'crum'),
                'std'  => $assets_folder.'img/icons/rtb.png',
            ),
            array(
                'id' => 'crum_testimonial_icon',
                'type' => 'upload',
                'title' => __('Testimonial block', 'crum'),
                'sub_desc' => __('', 'crum'),
                'desc' => __('', 'crum'),
                'std'  => $assets_folder.'img/icons/test1.png',
            ),
            array(
                'id' => 'crum_partners_widget_icon',
                'type' => 'upload',
                'title' => __('Partners logo block', 'crum'),
                'sub_desc' => __('', 'crum'),
                'desc' => __('', 'crum'),
                'std'  => $assets_folder.'img/icons/part1.png',
            ),
            array(
                'id' => 'instagram-widget_icon',
                'type' => 'upload',
                'title' => __('Flickr widget', 'crum'),
                'sub_desc' => __('', 'crum'),
                'desc' => __('', 'crum'),
                'std'  => $assets_folder.'img/icons/flickr.png',
            ),
            array(
                'id' => 'widget_crum-text-widget_icon',
                'type' => 'upload',
                'title' => __('Text widget', 'crum'),
                'sub_desc' => __('', 'crum'),
                'desc' => __('', 'crum'),
                'std'  => $assets_folder.'img/icons/tb.png',
            ),
            array(
                'id' => 'contacts-widget_icon',
                'type' => 'upload',
                'title' => __('VCard widget', 'crum'),
                'sub_desc' => __('', 'crum'),
                'desc' => __('', 'crum'),
                'std'  => $assets_folder.'img/icons/cont2.png',
            ),
            array(
                'id' => 'tags-widget_icon',
                'type' => 'upload',
                'title' => __('Tags widget', 'crum'),
                'sub_desc' => __('', 'crum'),
                'desc' => __('', 'crum'),
                'std'  => $assets_folder.'img/icons/tags1.png',
            ),
            array(
                'id' => 'tabs-widget_icon',
                'type' => 'upload',
                'title' => __('Tabs-posts widget', 'crum'),
                'sub_desc' => __('', 'crum'),
                'desc' => __('', 'crum'),
                'std'  => $assets_folder.'img/icons/tabs.png',
            ),
            array(
                'id' => 'widget_gallery_widget_icon',
                'type' => 'upload',
                'title' => __('From portfolio widget', 'crum'),
                'sub_desc' => __('', 'crum'),
                'desc' => __('', 'crum'),
                'std'  => $assets_folder.'img/icons/rand.png',
            ),
            array(
                'id' => 'widget_twitter-widget_icon',
                'type' => 'upload',
                'title' => __('Twitter widget', 'crum'),
                'sub_desc' => __('', 'crum'),
                'desc' => __('', 'crum'),
                'std'  => $assets_folder.'img/icons/twit.png',
            ),
            array(
                'id' => 'category-widget_icon',
                'type' => 'upload',
                'title' => __('Category widget', 'crum'),
                'sub_desc' => __('', 'crum'),
                'desc' => __('', 'crum'),
                'std'  => $assets_folder.'img/icons/cats.png',
            ),
            array(
                'id' => 'widget_facebook_widget_icon',
                'type' => 'upload',
                'title' => __('Facebook widget', 'crum'),
                'sub_desc' => __('', 'crum'),
                'desc' => __('', 'crum'),
                'std'  => $assets_folder.'img/icons/face.png',
            ),
            array(
                'id' => 'widget_crum_widgets_video_icon',
                'type' => 'upload',
                'title' => __('oEmbed widget', 'crum'),
                'sub_desc' => __('', 'crum'),
                'desc' => __('', 'crum'),
                'std'  => $assets_folder.'img/icons/vid.png',
            ),
            array(
                'id' => 'crum_widget_v_accordion_icon',
                'type' => 'upload',
                'title' => __('Vertical tabs block', 'crum'),
                'sub_desc' => __('', 'crum'),
                'desc' => __('', 'crum'),
                'std'  => $assets_folder.'img/icons/vt2.png',
            ),
            array(
                'id' => 'crum_news_row_icon',
                'type' => 'upload',
                'title' => __('News row box', 'crum'),
                'sub_desc' => __('', 'crum'),
                'desc' => __('', 'crum'),
                'std'  => $assets_folder.'img/icons/news.png',
            ),
            array(
                'id' => 'crum_galleries_widget_icon',
                'type' => 'upload',
                'title' => __('Galleries block', 'crum'),
                'sub_desc' => __('', 'crum'),
                'desc' => __('', 'crum'),
                'std'  => $assets_folder.'img/icons/gal.png',
            ),
            array(
                'id' => 'about_author_widget_icon',
                'type' => 'upload',
                'title' => __('About author block', 'crum'),
                'sub_desc' => __('', 'crum'),
                'desc' => __('', 'crum'),
                'std'  => $assets_folder.'img/icons/abau.png',
            ),
            array(
                'id' => 'skills_widget_icon',
                'type' => 'upload',
                'title' => __('Skills block', 'crum'),
                'sub_desc' => __('', 'crum'),
                'desc' => __('', 'crum'),
                'std'  => $assets_folder.'img/icons/skills.png',
            ),
            array(
                'id' => 'crum_shortcode_widget_icon',
                'type' => 'upload',
                'title' => __('Shortcode block', 'crum'),
                'sub_desc' => __('', 'crum'),
                'desc' => __('', 'crum'),
                'std'  => $assets_folder.'img/icons/tabl.png',
            ),
            array(
                'id' => 'crum_widget_features_icon',
                'type' => 'upload',
                'title' => __('Features list block', 'crum'),
                'sub_desc' => __('', 'crum'),
                'desc' => __('', 'crum'),
                'std'  => $assets_folder.'img/icons/why.png',
            ),
            array(
                'id' => 'widget_wp_sidebarlogin_icon',
                'type' => 'upload',
                'title' => __('Login widget', 'crum'),
                'sub_desc' => __('', 'crum'),
                'desc' => __('', 'crum'),
                'std'  => $assets_folder.'img/icons/log.png',
            ),
            array(
                'id' => 'widget_shopping_cart_icon',
                'type' => 'upload',
                'title' => __('Shopping cart widget', 'crum'),
                'sub_desc' => __('', 'crum'),
                'desc' => __('', 'crum'),
                'std'  => $assets_folder.'img/icons/cart1.png',
            ),
            array(
                'id' => 'crum_widget_accordion_icon',
                'type' => 'upload',
                'title' => __('Accordion block', 'crum'),
                'sub_desc' => __('', 'crum'),
                'desc' => __('', 'crum'),
                'std'  => '',
            ),array(
                'id' => 'cont-map_icon',
                'type' => 'upload',
                'title' => __('Map block', 'crum'),
                'sub_desc' => __('', 'crum'),
                'desc' => __('', 'crum'),
                'std'  => $assets_folder.'img/icons/map1.png',
            ),

        ),
    );
    $sections[] = array(
        'title' => __('Twitter panel options', 'crum'),
        'desc' => __('<p class="description">More information about api kays and how to get it you can find in that tutorial <a href="http://crumina.net/how-do-i-get-consumer-key-for-sign-in-with-twitter/">http://crumina.net/how-do-i-get-consumer-key-for-sign-in-with-twitter/</a></a></p>', 'crum'),
        //all the glyphicons are included in the options folder, so you can hook into them, or link to your own custom ones.
        //You dont have to though, leave it blank for default.
        'icon' => NHP_OPTIONS_URL.'img/glyphicons/glyphicons_024_parents.png',
        //Lets leave this as a blank section, no options just some intro text set above.
        'fields' => array(

            array(
                'id' => 'footer_tw_disp',
                'type' => 'button_set',
                'title' => __('Display twitter statuses before footer', 'crum'),
                'options' => array('0' => 'Off','1' => 'On'),
                'std' => '0'// 1 = on | 0 = off
            ),

            array(
                'id' => 'cachetime',
                'type' => 'text',
                'title' => __('Cache Tweets in every:', 'crum'),
                'sub_desc' => __('In minutes', 'crum'),
                'std' => '60'
            ),
            array(
                'id' => 'numb_lat_tw',
                'type' => 'text',
                'title' => __('Number of latest tweets display:', 'crum'),
                'sub_desc' => __('', 'crum'),
                'std' => '10'
            ),
            array(
                'id' => 'username',
                'type' => 'text',
                'title' => __('Username:', 'crum'),
                'std' => ''
            ),

            array(
                'id' => 'twiiter_consumer',
                'type' => 'text',
                'title' => __('Consumer key:', 'crum'),
                'std' => '',

            ),
            array(
                'id' => 'twiiter_con_s',
                'type' => 'text',
                'title' => __('Consumer secret:', 'crum'),
                'std' => '',
            ),
            array(
                'id' => 'twiiter_acc_t',
                'type' => 'text',
                'title' => __('Access token:', 'crum'),
                'sub_desc' => __('', 'crum'),
                'std' => '',
            ),
            array(
                'id' => 'twiiter_acc_t_s',
                'type' => 'text',
                'title' => __('Access token secret:', 'crum'),
                'std' => '',
            ),
        ),
    );




    $tabs = array();

    if (function_exists('wp_get_theme')){
        $theme_data = wp_get_theme();
        $theme_uri = $theme_data->get('ThemeURI');
        $description = $theme_data->get('Description');
        $author = $theme_data->get('Author');
        $version = $theme_data->get('Version');
        $tags = $theme_data->get('Tags');
    }else{
        $theme_data = get_theme_data(trailingslashit(get_stylesheet_directory()).'style.css');
        $theme_uri = $theme_data['URI'];
        $description = $theme_data['Description'];
        $author = $theme_data['Author'];
        $version = $theme_data['Version'];
        $tags = $theme_data['Tags'];
    }

    $theme_info = '<div class="nhp-opts-section-desc">';
    $theme_info .= '<p class="nhp-opts-theme-data description theme-uri">'.__('<strong>Theme URL:</strong> ', 'crum').'<a href="'.$theme_uri.'" target="_blank">'.$theme_uri.'</a></p>';
    $theme_info .= '<p class="nhp-opts-theme-data description theme-author">'.__('<strong>Author:</strong> ', 'crum').$author.'</p>';
    $theme_info .= '<p class="nhp-opts-theme-data description theme-version">'.__('<strong>Version:</strong> ', 'crum').$version.'</p>';
    $theme_info .= '<p class="nhp-opts-theme-data description theme-description">'.$description.'</p>';
    $theme_info .= '<p class="nhp-opts-theme-data description theme-tags">'.__('<strong>Tags:</strong> ', 'crum').implode(', ', (array)$tags).'</p>';
    $theme_info .= '</div>';



    $tabs['theme_info'] = array(
        'icon' => NHP_OPTIONS_URL.'img/glyphicons/glyphicons_195_circle_info.png',
        'title' => __('Theme Information', 'crum'),
        'content' => $theme_info
    );

    if(file_exists(trailingslashit(get_stylesheet_directory()).'README.html')){
        $tabs['theme_docs'] = array(
            'icon' => NHP_OPTIONS_URL.'img/glyphicons/glyphicons_071_book.png',
            'title' => __('Documentation', 'crum'),
            'content' => nl2br(file_get_contents(trailingslashit(get_stylesheet_directory()).'README.html'))
        );
    }//if

    global $NHP_Options;
    $NHP_Options = new NHP_Options($sections, $args, $tabs);

}//function
add_action('init', 'setup_framework_options', 0);

