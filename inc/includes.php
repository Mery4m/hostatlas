<?php

/*
 * List of included into theme files
 */

require_once locate_template('/inc/cleanup.php');                // Cleanup - remove unused HTML and functions

require_once locate_template('/inc/actions.php');               // Add Framework additional functions

require_once locate_template('/admin/nhp-options.php');         // Theme options panel

require_once locate_template('/inc/scripts.php');                // Scripts and stylesheets

require_once locate_template('/inc/post-type.php');              //  Pre-defined post types

require_once locate_template('/inc/menu.php');              //  Pre-defined post types

require_once locate_template('/inc/custom-post-type.php');       // Custom post types

require_once locate_template('/inc/widgets.php');                // Widgets & Sidebars

require_once locate_template('/inc/aq_resizer.php');             // Resize images on the fly

require_once locate_template('/inc/custom_fields/custom_fields.php');  // Custom fields

require_once locate_template('/inc/custom_metabox/include-boxes.php');  // Custom boxes

//include the main class file
require_once locate_template("/inc/category_extend/tax-meta-class.php"); // Custom fields for categories
require_once locate_template('/inc/category_extend/crum-cat-tax.php');

require_once locate_template('/inc/shortcodes/shortcodes.php');  // Shortcodes


require_once locate_template('/inc/lib/plugins.php');




