<?php

class Roots_Alt_Walker extends Walker_Nav_Menu
{
    static protected $menu_lvl;
    static protected $active_mega_menu;
    static protected $mega_menu_item;
    static protected $only_first = false;

    private $mega_menu_settings;
    private $is_hover;
    private $is_migration;

    public function __construct()
    {
        $this->mega_menu_settings = get_option("crumina_menu_data");
        $crumina_menu = get_option("crumina_menu");
        $this->is_hover = (isset($crumina_menu['menu_active_icon_hover']) && !empty($crumina_menu['menu_active_icon_hover'])) ? true : false;
        $this->is_migration = get_option("crumina_menu_migration");
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

            if (is_array($nav_menu_locations)) {
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

        if (empty($menu_slug)) return false;

        if ($this->is_migration === false) {

            $menu_migration = array();

            $menu_items = wp_get_nav_menu_items($menu_slug);
            $menu_settings = $this->mega_menu_settings;


            foreach ($menu_items as $key => $object) {
                $menu_migration[sanitize_title($object->title)] = $object->ID;
            }

            if (is_array($menu_settings)) {
                foreach ($menu_settings as $menu_nav => $slug_menu_info) {
                    foreach ($slug_menu_info as $slug => $info) {
                        if (!is_numeric($slug)) {
                            $slug = sanitize_title($slug);

                            if (isset($menu_migration[$slug])) {
                                $menu_settings[$menu_nav][$menu_migration[$slug]] = $menu_settings[$menu_nav][$slug];
                                unset($menu_settings[$menu_nav][$slug]);
                            }

                        }
                    }
                }

            }

           $this->mega_menu_settings = $menu_settings;

        update_option("crumina_menu_migration", 1);
        update_option('crumina_menu_data', $menu_settings);
        }

        $slug = sanitize_title($item->ID);

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

                if ($this->is_hover && $item->current) {
                    $active_icon = $styles[$menu_slug][$slug]['hover_icon'];
                } else {
                    $active_icon = $styles[$menu_slug][$slug]['active_icon'];
                }

                $contact_icons .= '<img src="' . aq_resize($active_icon, 32, 32, true) . '" class="normal-icon" alt="">';
            } else {
                $no_icon_class = 'no_icon';
            }

            if ($this->is_hover && !$item->current) {
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

                $args_posts = array('p' => self::$mega_menu_item, 'post_type' => 'any');

                $myposts = query_posts($args_posts);

                //$myposts = get_posts( $args_posts );

                foreach ($myposts as $post) : setup_postdata($post);

                    /*ob_start();
                    the_content();
                    $menu_content = ob_get_clean();*/

                    $menu_content = do_shortcode(apply_filters('the_content', $post->post_content));


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

            $args_posts = array('p' => self::$mega_menu_item, 'post_type' => 'any');

            $myposts = query_posts($args_posts);

            foreach ($myposts as $post) :

                setup_postdata($post);

                $menu_content = do_shortcode(apply_filters('the_content', $post->post_content));

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

        if (isset($active_mega_menu))
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
