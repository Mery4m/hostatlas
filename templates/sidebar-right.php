<aside class="three columns" id="right-sidebar">

<?php
wp_reset_query();
	if(is_single()){
        global $post;
        $page_id = $post->ID;
    }else {
        $page_id = get_queried_object_id();
    }

	$sidebar = get_post_meta($page_id , 'sidebar_2', $single = true);

    if ( ( $sidebar ) &&  ($sidebar != 'none') ){
        dynamic_sidebar($sidebar);
    } else {
        dynamic_sidebar('sidebar-right');
    }

?>

  </aside>
