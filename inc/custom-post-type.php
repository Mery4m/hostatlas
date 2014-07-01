<?php

// let's create the function for the custom type
function custom_post_example() {
    // creating (registering) the custom type
    register_post_type( 'custom_type', /* (http://codex.wordpress.org/Function_Reference/register_post_type) */
        // let's now add all the options for this post type
        array('labels' => array(
            'name' => __('Custom Types', 'post type general name', 'crum'), /* This is the Title of the Group */
            'singular_name' => __('Custom Post', 'post type singular name', 'crum'), /* This is the individual type */
            'add_new' => __('Add New', 'custom post type item', 'crum'), /* The add new menu item */
            'add_new_item' => __('Add New Custom Type', 'crum'), /* Add New Display Title */
            'edit' => __( 'Edit' , 'crum'), /* Edit Dialog */
            'edit_item' => __('Edit Post Types', 'crum'), /* Edit Display Title */
            'new_item' => __('New Post Type', 'crum'), /* New Display Title */
            'view_item' => __('View Post Type', 'crum'), /* View Display Title */
            'search_items' => __('Search Post Type', 'crum'), /* Search Custom Type Title */
            'not_found' =>  __('Nothing found in the Database.', 'crum'), /* This displays if there are no entries yet */
            'not_found_in_trash' => __('Nothing found in Trash', 'crum'), /* This displays if there is nothing in the trash */
            'parent_item_colon' => ''
        ), /* end of arrays */
            'description' => __( 'This is the example custom post type' , 'crum'), /* Custom Type Description */
            'public' => true,
            'publicly_queryable' => true,
            'exclude_from_search' => false,
            'show_ui' => true,
            'query_var' => true,
            'menu_position' => 8, /* this is what order you want it to appear in on the left hand side menu */
            'menu_icon' => 'dashicons-editor-ul', /* the icon for the custom post type menu */
            'rewrite' => true,
            'capability_type' => 'post',
            'hierarchical' => false,
            /* the next one is important, it tells what's enabled in the post editor */
            'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'trackbacks', 'custom-fields',  'revisions', 'sticky')
        ) /* end of options */
    ); /* end of register post type */

    /* this ads your post categories to your custom post type */
    register_taxonomy_for_object_type('category', 'custom_type');
    /* this ads your post tags to your custom post type */
    register_taxonomy_for_object_type('post_tag', 'custom_type');

}

// adding the function to the Wordpress init
add_action( 'init', 'custom_post_example');

/*
for more information on taxonomies, go here:
http://codex.wordpress.org/Function_Reference/register_taxonomy
*/

// now let's add custom categories (these act like categories)
register_taxonomy( 'custom_cat',
    array('custom_type'), /* if you change the name of register_post_type( 'custom_type', then you have to change this */
    array('hierarchical' => true,     /* if this is true it acts like categories  */
        'labels' => array(
            'name' => __( 'Custom Categories', 'crum' ), /* name of the custom taxonomy */
            'singular_name' => __( 'Custom Category', 'crum' ), /* single taxonomy name */
            'search_items' =>  __( 'Search Custom Categories', 'crum' ), /* search title for taxomony */
            'all_items' => __( 'All Custom Categories', 'crum' ), /* all title for taxonomies */
            'parent_item' => __( 'Parent Custom Category', 'crum' ), /* parent title for taxonomy */
            'parent_item_colon' => __( 'Parent Custom Category:', 'crum' ), /* parent taxonomy title */
            'edit_item' => __( 'Edit Custom Category', 'crum' ), /* edit custom taxonomy title */
            'update_item' => __( 'Update Custom Category', 'crum' ), /* update title for taxonomy */
            'add_new_item' => __( 'Add New Custom Category', 'crum' ), /* add new title for taxonomy */
            'new_item_name' => __( 'New Custom Category Name', 'crum' ) /* name title for taxonomy */
        ),
        'show_ui' => true,
        'query_var' => true,
    )
);

// now let's add custom tags (these act like categories)
register_taxonomy( 'custom_tag',
    array('custom_type'), /* if you change the name of register_post_type( 'custom_type', then you have to change this */
    array('hierarchical' => false,    /* if this is false, it acts like tags */
        'labels' => array(
            'name' => __( 'Custom Tags', 'crum' ), /* name of the custom taxonomy */
            'singular_name' => __( 'Custom Tag', 'crum' ), /* single taxonomy name */
            'search_items' =>  __( 'Search Custom Tags', 'crum' ), /* search title for taxomony */
            'all_items' => __( 'All Custom Tags', 'crum' ), /* all title for taxonomies */
            'parent_item' => __( 'Parent Custom Tag', 'crum' ), /* parent title for taxonomy */
            'parent_item_colon' => __( 'Parent Custom Tag:', 'crum' ), /* parent taxonomy title */
            'edit_item' => __( 'Edit Custom Tag', 'crum' ), /* edit custom taxonomy title */
            'update_item' => __( 'Update Custom Tag', 'crum' ), /* update title for taxonomy */
            'add_new_item' => __( 'Add New Custom Tag', 'crum' ), /* add new title for taxonomy */
            'new_item_name' => __( 'New Custom Tag Name', 'crum' ) /* name title for taxonomy */
        ),
        'show_ui' => true,
        'query_var' => true,
    )
);


?>