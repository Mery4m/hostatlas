<?php
/*
Plugin Name: Demo Tax meta class
Plugin URI: http://en.bainternet.info
Description: Tax meta class usage demo
Version: 1.9.8
Author: Bainternet, Ohad Raz
Author URI: http://en.bainternet.info
*/


if (is_admin()){
  /* 
   * prefix of meta keys, optional
   */
  $prefix = 'crum_';
  /* 
   * configure your meta box
   */
  $config = array(
    'id' => 'add_icon_meta_box',          // meta box id, unique per meta box
    'title' => 'Add custom icons',          // meta box title
    'pages' => array('category'),        // taxonomy name, accept categories, post_tag and custom taxonomies
    'context' => 'normal',            // where the meta box appear: normal (default), advanced, side; optional
    'fields' => array(),            // list of meta fields (can be added by field arrays)
    'local_images' => false,          // Use local or hosted images (meta box images for add/remove)
    'use_with_theme' => true          //change path if used with theme set to true, false for a plugin or anything else for a custom path(default false).
  );
  
  
  /*
   * Initiate your meta box
   */
  $my_meta =  new Tax_Meta_Class($config);
  
  /*
   * Add fields to your meta box
   */

  //Image field
  $my_meta->addImage($prefix.'cat_ico_img',array('name'=> __('Category icon','crum')));


    /*
   * Don't Forget to Close up the meta box decleration
   */
  //Finish Meta Box Decleration
  $my_meta->Finish();
}
