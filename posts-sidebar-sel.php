<?php
/*
Template Name: Blogs with user layout selection
*/
?>

<?php
global $layout;
global $page_lay;
global $NHP_Options;

$default = get_post_meta($post->ID, '_page_layout_select', true);
$sidebar_option = get_post_meta($post->ID, 'sidebar_option', true);

if ( $default == '' ) {
	$page_lay = $NHP_Options->get( "archive_layout" );
}else{
	$page_lay = $default;
}

get_template_part('templates/top', 'page'); ?>



<section id="layout">
	<div class="row">

<?php if ($page_lay == "1col-fixed") {
    $cr_layout = '';
    $cr_width = 'twelve';
}
if ($page_lay == "3c-l-fixed") {
    $cr_layout = 'sidebar-left2';
    $cr_width = 'six';
}
if ($page_lay == "3c-r-fixed") {
    $cr_layout = 'sidebar-right2';
    $cr_width = 'six';
}
if ($page_lay == "2c-l-fixed") {
    $cr_layout = 'sidebar-left';
    $cr_width = 'nine';
}
if ($page_lay == "2c-r-fixed") {
    $cr_layout = 'sidebar-right';
    $cr_width = 'nine';
}
if ($page_lay == "3c-fixed") {
    $cr_layout = 'sidebar-both';
    $cr_width = 'six';
}


echo '<div class="blog-section ' . $cr_layout . '">';
echo '<section id="main-content" role="main" class="' . $cr_width . ' columns">';


if (is_front_page()) {
    $paged = (get_query_var('page')) ? get_query_var('page') : 1;
} else {
    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
}

$number_per_page = get_post_meta($post->ID, 'blog_number_to_display', true);
$number_per_page = ($number_per_page) ? $number_per_page : '12';


$blog_custom_categories = ( get_post_meta($post->ID, 'blog_sort_category',true)) ?  get_post_meta($post->ID, 'blog_category',true) : '';
if ($blog_custom_categories){$blog_custom_categories = implode(",", $blog_custom_categories);}

$args = array('post_type' => 'post',
    'posts_per_page' => $number_per_page,
    'paged' => $paged,
    'cat' => $blog_custom_categories
);


query_posts($args);


get_template_part('templates/content', '');

echo ' </section>';

if (($page_lay == "2c-l-fixed") || ($page_lay == "3c-fixed")) {
    get_template_part('templates/sidebar', 'left');
    echo ' </div>';
}
if (($page_lay == "3c-l-fixed")) {
    get_template_part('templates/sidebar', 'right');
    echo ' </div>';
    get_template_part('templates/sidebar', 'left');
}
if ($page_lay == "3c-r-fixed") {
    get_template_part('templates/sidebar', 'left');
    echo ' </div>';
}
if (($page_lay == "2c-r-fixed") || ($page_lay == "3c-fixed") || ($page_lay == "3c-r-fixed")) {
    get_template_part('templates/sidebar', 'right');
}
?>

	</div>
</section>