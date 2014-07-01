<?php
//Function parses header styles

global $NHP_Options;


/*
 * Menu align
 */

if ($NHP_Options->get("main_menu_position") == 'left'){
 echo '#top-menu{float:left;}';
}


/*
 * Backgrounds
 */
if ($NHP_Options->get("wrapper_bg_color")){
    echo '#change_wrap_div{ background-color: '.$NHP_Options->get("wrapper_bg_color").'}  ';
}
if ($NHP_Options->get("wrapper_bg_image")){
    echo '#change_wrap_div{ background-image: url("'.$NHP_Options->get("wrapper_bg_image").'")} ';
}
if ($NHP_Options->get("wrapper_custom_repeat")){
    echo '#change_wrap_div{ background-repeat: '.$NHP_Options->get("wrapper_custom_repeat").'} ';
}

if ($NHP_Options->get("body_bg_color")){
    echo 'body{ background-color: '.$NHP_Options->get("body_bg_color").'} ';
}
if ($NHP_Options->get("body_bg_image")){
    echo 'body{ background-image: url("'.$NHP_Options->get("body_bg_image").'")} ';
}
if ($NHP_Options->get("body_custom_repeat")){
    echo 'body{ background-repeat: '.$NHP_Options->get("body_custom_repeat").'} ';
}
if ($NHP_Options->get("body_bg_fixed")){
    echo 'body{ background-attachment: fixed;} ';
}

if ($NHP_Options->get("footer_font_color")){
    echo '#footer, #footer .contacts-widget p{ color: '.$NHP_Options->get("footer_font_color").'} ';
}
if ($NHP_Options->get("footer_bg_color")){
    echo '#footer{ background-color: '.$NHP_Options->get("footer_bg_color").'} ';
}
if ($NHP_Options->get("footer_bg_image")){
    echo '#footer{ background-image: url("'.$NHP_Options->get("footer_bg_image").'")} ';
}
if ($NHP_Options->get("footer_custom_repeat")){
    echo '#footer{ background-repeat: '.$NHP_Options->get("footer_custom_repeat").'} ';
}


/*
 * Main theme color
 */

if (($NHP_Options->get("main_site_color")) && ($NHP_Options->get("main_site_color") != "#50b4e6")){ ?>

#top-menu > ul > li >ul>li:hover>.menu-item-wrap>a, #top-menu> ul > li > ul > li >ul>li:hover>.menu-item-wrap>a, #top-menu > ul > li>ul>li.current-menu-item>.menu-item-wrap>a,
.info-item.clickable:hover, .folio-item .description, .hover-bg:hover, .twitter-row .icon, .twitter-row .nav a:hover, .widget_nav_menu li a:hover, .category-widget li a:hover,
.button, #open-top-panel, #top-panel, div.progress .meter, .pricing-table .title, #layout .tags-widget a:hover, .tags-widget  a:hover, .breaking-news-block .blocks-label, .page-nav .older a,
.page-nav .newer a:hover, .comment-reply-link:hover, .quantity .plus, #content .quantity .plus:hover, .quantity .minus, #content .quantity .minus,
.dark-skin .twitter-row .nav a:hover, .tags-widget a:hover,#top-menu>ul>li:hover>.under,.crum_stiky_news .blocks-label,
#top-menu>ul>li.current-menu-item>.menu-item-wrap
{ background-color:<?php $NHP_Options->show("main_site_color") ?>}

.h3 span, a, .extra-links a:hover, .post header > h2 a:hover, article .dopinfo a.comments, article .dopinfo a:hover,
#footer h3, .project-title a:hover, .summary .price,
.dark-skin ul.accordion > li.active > div.title h5,.dark-skin .post header > h2 a:hover,.dark-skin .project-title a:hover,
.bbp-topic-meta a
{ color:<?php $NHP_Options->show("main_site_color") ?>}

#top-menu>ul>li>ul:before
{ border-bottom-color:<?php $NHP_Options->show("main_site_color") ?>}

#top-menu>ul>li>ul>li:first-child,  .tabs dd.active, .tabs li.active, .filter li.active,
.ui-tabs .ui-tabs-nav li.ui-tabs-active, .wpb_accordion .ui-accordion .ui-accordion-header-active,
#bbpress-forums ul.bbp-forums, #bbpress-forums ul.bbp-topics, #bbpress-forums ul.bbp-replies,
#top-menu>ul>li>ul>li>ul>li:first-child
{ border-top-color:<?php $NHP_Options->show("main_site_color") ?>}

.to-action-block,.tabs.vertical dd.active, .tabs.vertical li.active, .tabs.vertical dd:first-child.active, .tabs.vertical li:first-child.active,
.widget_nav_menu li a:hover:before,.category-widget li a:hover:before, ul.accordion > li.active .title,
.dark-skin .tabs.vertical dd.active, .dark-skin .tabs.vertical li.active, .dark-skin .to-action-block
{ border-left-color:<?php $NHP_Options->show("main_site_color") ?>}
<?php }

if (($NHP_Options->get("secondary_site_color")) && ($NHP_Options->get("secondary_site_color") != "#f36f5f")){ ?>
div.bbp-template-notice,.bbp-topics-front ul.super-sticky, .bbp-topics ul.super-sticky, .bbp-topics ul.sticky, .bbp-forum-content ul.sticky

{ border-left-color:<?php $NHP_Options->show("secondary_site_color")  ?> !important}


.hover-plus,.instagram-widget a span,.button:hover, #layout .tags-widget a, #footer .tags-widget a:hover, .page-nav .older a:hover,.page-nav .newer a,
.comment-reply-link,.onsale,.quantity .plus, #content .quantity .plus,.quantity .minus, #content .quantity .minus:hover,.dark-skin .tags-widget .widget-inner a:hover,
.imghover
{ background-color:<?php $NHP_Options->show("secondary_site_color") ?>}

a:hover,.footer-menu a:hover,.widget_shopping_cart .amount, ul.products li.product .price,
ul.products li.product .amount
{ color:<?php $NHP_Options->show("secondary_site_color") ?>}
<?php }

/*
 * Block icons
 */
if ($NHP_Options->get("default_widget_icon")){ ?>
.widget-title{ background:url(<?php $NHP_Options->show("default_widget_icon") ?>) 0 0 no-repeat;
}
<?php
}
if ($NHP_Options->get("search-widget_icon")){ ?>
.widget_search-widget .widget-title, .search-widget .widget-title{ background:url(<?php $NHP_Options->show("search-widget_icon") ?>) 0 0 no-repeat;
}
<?php
}
if ($NHP_Options->get("vertical_accordion_icon")){ ?>
.widget_crum_widget_v_accordion .widget-title, .crum_widget_v_accordion .widget-title{ background:url(<?php $NHP_Options->show("vertical_accordion_icon") ?>) 0 0 no-repeat;
}
<?php
}
if ($NHP_Options->get("crum_news_cat_icon")){ ?>
.widget_crum_news_cat .widget-title, .crum_news_cat .widget-title { background:url(<?php $NHP_Options->show("crum_news_cat_icon") ?>) 0 0 no-repeat;
}
<?php
}
if ($NHP_Options->get("crum_testimonial_icon")){ ?>
.widget_crum_testimonial_widget .widget-title, .crum_testimonial_widget .widget-title { background:url(<?php $NHP_Options->show("crum_testimonial_icon") ?>) 0 0 no-repeat;
}
<?php
}
if ($NHP_Options->get("list_widget_icon")){ ?>
.list_widget .widget-title, .widget_list_widget .widget-title { background:url(<?php $NHP_Options->show("list_widget_icon") ?>) 0 0 no-repeat;
}
<?php
}
if ($NHP_Options->get("crum_partners_widget_icon")){ ?>
.widget_crum_partners_widget .widget-title, .crum_partners_widget .widget-title { background:url(<?php $NHP_Options->show("crum_partners_widget_icon") ?>) 0 0 no-repeat;
}
<?php
}
if ($NHP_Options->get("instagram-widget_icon")){ ?>
.widget_instagram-widget .widget-title, .instagram-widget .widget-title { background:url(<?php $NHP_Options->show("instagram-widget_icon") ?>) 0 0 no-repeat;
}
<?php
}
if ($NHP_Options->get("widget_crum-text-widget_icon")){ ?>
.widget_crum-text-widget .widget-title, .crum-text-widget .widget-title { background:url(<?php $NHP_Options->show("widget_crum-text-widget_icon") ?>) 0 0 no-repeat;
}
<?php
}
if ($NHP_Options->get("contacts-widget_icon")){ ?>
.widget_contacts-widget .widget-title, .contacts-widget .widget-title { background:url(<?php $NHP_Options->show("contacts-widget_icon") ?>) 0 0 no-repeat;
}
<?php
}
if ($NHP_Options->get("tags-widget_icon")){ ?>
.widget_tags-widget .widget-title, .tags-widget .widget-title { background:url(<?php $NHP_Options->show("tags-widget_icon") ?>) 0 0 no-repeat;
}
<?php
}
if ($NHP_Options->get("tabs-widget_icon")){ ?>
.widget_tabs-widget .widget-title, .aq_tabs .widget-title { background:url(<?php $NHP_Options->show("tabs-widget_icon") ?>) 0 0 no-repeat;
}
<?php
}
if ($NHP_Options->get("widget_gallery_widget_icon")){ ?>
.widget_gallery_widget .widget-title, .gallery_widget .widget-title { background:url(<?php $NHP_Options->show("widget_gallery_widget_icon") ?>) 0 0 no-repeat;
}
<?php
}
if ($NHP_Options->get("widget_twitter-widget_icon")){ ?>
.widget_twitter-widget .widget-title, .twitter-widget .widget-title { background:url(<?php $NHP_Options->show("widget_twitter-widget_icon") ?>) 0 0 no-repeat;
}
<?php
}
if ($NHP_Options->get("category-widget_icon")){ ?>
.widget_category-widget .widget-title, .category-widget .widget-title { background:url(<?php $NHP_Options->show("category-widget_icon") ?>) 0 0 no-repeat;
}
<?php
}
if ($NHP_Options->get("widget_facebook_widget_icon")){ ?>
.widget_facebook_widget .widget-title, .facebook_widget .widget-title { background:url(<?php $NHP_Options->show("widget_facebook_widget_icon") ?>) 0 0 no-repeat;
}
<?php
}
if ($NHP_Options->get("widget_crum_widgets_video_icon")){ ?>
.widget_crum_widgets_video .widget-title, .crum_widgets_video .widget-title { background:url(<?php $NHP_Options->show("widget_crum_widgets_video_icon") ?>) 0 0 no-repeat;
}
<?php
}
if ($NHP_Options->get("crum_widget_v_accordion_icon")){ ?>
.widget_crum_widget_v_accordion .widget-title, .crum_widget_v_accordion .widget-title { background:url(<?php $NHP_Options->show("crum_widget_v_accordion_icon") ?>) 0 0 no-repeat;
}
<?php
}
if ($NHP_Options->get("crum_latest_3_news_icon")){ ?>
.widget_crum_latest_3_news .widget-title, .crum_latest_3_news .widget-title { background:url(<?php $NHP_Options->show("crum_latest_3_news_icon") ?>) 0 0 no-repeat;
}
<?php
}
if ($NHP_Options->get("crum_galleries_widget_icon")){ ?>
.widget_crum_galleries_widget .widget-title, .crum_galleries_widget .widget-title { background:url(<?php $NHP_Options->show("crum_galleries_widget_icon") ?>) 0 0 no-repeat;
}
<?php
}
if ($NHP_Options->get("crum_news_row_icon")){ ?>
.widget_crum_news_row .widget-title, .crum_news_row .widget-title { background:url(<?php $NHP_Options->show("crum_news_row_icon") ?>) 0 0 no-repeat;
}
<?php
}
if ($NHP_Options->get("about_author_widget_icon")){ ?>
.widget_about_author_widget .widget-title, .about_author_widget .widget-title { background:url(<?php $NHP_Options->show("about_author_widget_icon") ?>) 0 0 no-repeat;
}
<?php
}
if ($NHP_Options->get("skills_widget_icon")){ ?>
.widget_skills_widget .widget-title, .skills_widget .widget-title { background:url(<?php $NHP_Options->show("skills_widget_icon") ?>) 0 0 no-repeat;
}
<?php
}
if ($NHP_Options->get("crum_widget_features_icon")){ ?>
.widget_crum_widget_features .widget-title, .crum_widget_features .widget-title { background:url(<?php $NHP_Options->show("crum_widget_features_icon") ?>) 0 0 no-repeat;
}
<?php
}
if ($NHP_Options->get("widget_wp_sidebarlogin_icon")){ ?>
.widget_wp_sidebarlogin .widget-title, .wp_sidebarlogin .widget-title { background:url(<?php $NHP_Options->show("widget_wp_sidebarlogin_icon") ?>) 0 0 no-repeat;
}
<?php
}
if ($NHP_Options->get("widget_shopping_cart_icon")){ ?>
.widget_shopping_cart .widget-title, .shopping_cart .widget-title { background:url(<?php $NHP_Options->show("widget_shopping_cart_icon") ?>) 0 0 no-repeat;
}
<?php
}
if ($NHP_Options->get("crum_widget_accordion_icon")){ ?>
.widget_crum_widget_accordion .widget-title, .crum_widget_accordion .widget-title { background:url(<?php $NHP_Options->show("crum_widget_accordion_icon") ?>) 0 0 no-repeat;
}
<?php
}
if ($NHP_Options->get("crum_shortcode_widget_icon")){ ?>
.widget_crum_shortcode_widget>.widget-title, .crum_shortcode_widget>.widget-title { background:url(<?php $NHP_Options->show("crum_shortcode_widget_icon") ?>) 0 0 no-repeat;
}
<?php
}
if ($NHP_Options->get("cont-map_icon")){ ?>
.widget_cont-map .page-block-title, .cont-map .page-block-title { background:url(<?php $NHP_Options->show("cont-map_icon") ?>) 0 4px no-repeat;
}
<?php
}
/*
 * Retina icons
 */
?>
@media all and (-webkit-min-device-pixel-ratio: 1.5) {
    <?php if ($NHP_Options->get("default_widget_icon")){
        echo ".widget-title{ background:url('". preg_replace('/(.png)/', '@2x.png', ''.$NHP_Options->get("default_widget_icon").'')."') 0 0 no-repeat;} \n";
    } if ($NHP_Options->get("crum_shortcode_widget_icon")){
        echo ".widget_crum_shortcode_widget .widget-title, .crum_shortcode_widget .widget-title{ background:url('". preg_replace('/(.png)/', '@2x.png', ''.$NHP_Options->get("crum_shortcode_widget_icon").'')."') 0 0 no-repeat;} \n";
    } if ($NHP_Options->get("crum_widget_v_accordion_icon")){
        echo ".widget_crum_widget_v_accordion .widget-title, .crum_widget_v_accordion .widget-title{ background:url('". preg_replace('/(.png)/', '@2x.png', ''.$NHP_Options->get("crum_widget_v_accordion_icon").'')."') 0 0 no-repeat;}\n";
    }if ($NHP_Options->get("crum_news_cat_icon")){
        echo ".widget_crum_news_cat .widget-title, .crum_news_cat .widget-title{ background:url('". preg_replace('/(.png)/', '@2x.png', ''.$NHP_Options->get("crum_news_cat_icon").'')."') 0 0 no-repeat;}\n";
    }if ($NHP_Options->get("crum_testimonial_icon")){
        echo ".widget_crum_testimonial_widget .widget-title, .crum_testimonial_widget .widget-title{ background:url('". preg_replace('/(.png)/', '@2x.png', ''.$NHP_Options->get("crum_testimonial_icon").'')."') 0 0 no-repeat;}\n";
    }if ($NHP_Options->get("list_widget_icon")){
        echo ".widget_list_widget .widget-title, .list_widget .widget-title{ background:url('". preg_replace('/(.png)/', '@2x.png', ''.$NHP_Options->get("list_widget_icon").'')."') 0 0 no-repeat;}\n";
    }if ($NHP_Options->get("crum_partners_widget_icon")){
        echo ".widget_crum_partners_widget .widget-title, .crum_partners_widget .widget-title{ background:url('". preg_replace('/(.png)/', '@2x.png', ''.$NHP_Options->get("crum_partners_widget_icon").'')."') 0 0 no-repeat;}\n";
    }if ($NHP_Options->get("instagram-widget_icon")){
        echo ".widget_instagram-widget .widget-title, .instagram-widget .widget-title{ background:url('". preg_replace('/(.png)/', '@2x.png', ''.$NHP_Options->get("instagram-widget_icon").'')."') 0 0 no-repeat;}\n";
    }if ($NHP_Options->get("widget_crum-text-widget_icon")){
        echo ".widget_widget_crum-text-widget .widget-title, .widget_crum-text-widget .widget-title{ background:url('". preg_replace('/(.png)/', '@2x.png', ''.$NHP_Options->get("widget_crum-text-widget_icon").'')."') 0 0 no-repeat;}\n";
    }if ($NHP_Options->get("contacts-widget_icon")){
        echo ".widget_contacts-widget .widget-title, .contacts-widget .widget-title{ background:url('". preg_replace('/(.png)/', '@2x.png', ''.$NHP_Options->get("contacts-widget_icon").'')."') 0 0 no-repeat;}\n";
    }if ($NHP_Options->get("tags-widget_icon")){
        echo ".widget_tags-widget .widget-title, .tags-widget .widget-title{ background:url('". preg_replace('/(.png)/', '@2x.png', ''.$NHP_Options->get("tags-widget_icon").'')."') 0 0 no-repeat;}\n";
    }if ($NHP_Options->get("tabs-widget_icon")){
        echo ".widget_tabs-widget .widget-title, .tabs-widget .widget-title{ background:url('". preg_replace('/(.png)/', '@2x.png', ''.$NHP_Options->get("tabs-widget_icon").'')."') 0 0 no-repeat;}\n";
    }if ($NHP_Options->get("widget_gallery_widget_icon")){
        echo ".widget_gallery_widget .widget-title, .gallery_widget .widget-title{ background:url('". preg_replace('/(.png)/', '@2x.png', ''.$NHP_Options->get("widget_gallery_widget_icon").'')."') 0 0 no-repeat;}\n";
    }if ($NHP_Options->get("widget_twitter-widget_icon")){
        echo ".widget_twitter-widget .widget-title, .twitter-widget .widget-title{ background:url('". preg_replace('/(.png)/', '@2x.png', ''.$NHP_Options->get("widget_twitter-widget_icon").'')."') 0 0 no-repeat;}\n";
    }if ($NHP_Options->get("category-widget_icon")){
        echo ".widget_category-widget .widget-title, .category-widget .widget-title{ background:url('". preg_replace('/(.png)/', '@2x.png', ''.$NHP_Options->get("category-widget_icon").'')."') 0 0 no-repeat;}\n";
    }if ($NHP_Options->get("widget_facebook_widget_icon")){
        echo ".widget_facebook_widget .widget-title, .facebook_widget .widget-title{ background:url('". preg_replace('/(.png)/', '@2x.png', ''.$NHP_Options->get("widget_facebook_widget_icon").'')."') 0 0 no-repeat;}\n";
    }if ($NHP_Options->get("widget_crum_widgets_video_icon")){
        echo ".widget_crum_widgets_video .widget-title, .crum_widgets_video .widget-title{ background:url('". preg_replace('/(.png)/', '@2x.png', ''.$NHP_Options->get("widget_crum_widgets_video_icon").'')."') 0 0 no-repeat;}\n";
    }if ($NHP_Options->get("crum_news_row_icon")){
        echo ".widget_crum_news_row .widget-title, .crum_news_row .widget-title{ background:url('". preg_replace('/(.png)/', '@2x.png', ''.$NHP_Options->get("crum_news_row_icon").'')."') 0 0 no-repeat;}\n";
    }if ($NHP_Options->get("crum_galleries_widget_icon")){
        echo ".widget_crum_galleries_widget .widget-title, .crum_galleries_widget .widget-title{ background:url('". preg_replace('/(.png)/', '@2x.png', ''.$NHP_Options->get("crum_galleries_widget_icon").'')."') 0 0 no-repeat;}\n";
    }if ($NHP_Options->get("about_author_widget_icon")){
        echo ".widget_about_author_widget .widget-title, .about_author_widget .widget-title{ background:url('". preg_replace('/(.png)/', '@2x.png', ''.$NHP_Options->get("about_author_widget_icon").'')."') 0 0 no-repeat;}\n";
    }if ($NHP_Options->get("skills_widget_icon")){
        echo ".widget_skills_widget .widget-title, .skills_widget .widget-title{ background:url('". preg_replace('/(.png)/', '@2x.png', ''.$NHP_Options->get("skills_widget_icon").'')."') 0 0 no-repeat;}\n";
    }if ($NHP_Options->get("crum_widget_features_icon")){
        echo ".widget_crum_widget_features .widget-title, .crum_widget_features .widget-title{ background:url('". preg_replace('/(.png)/', '@2x.png', ''.$NHP_Options->get("crum_widget_features_icon").'')."') 0 0 no-repeat;}\n";
    }if ($NHP_Options->get("widget_wp_sidebarlogin_icon")){
        echo ".widget_wp_sidebarlogin .widget-title, .wp_sidebarlogin .widget-title{ background:url('". preg_replace('/(.png)/', '@2x.png', ''.$NHP_Options->get("widget_wp_sidebarlogin_icon").'')."') 0 0 no-repeat;}\n";
    }if ($NHP_Options->get("widget_shopping_cart_icon")){
        echo ".widget_shopping_cart .widget-title, .shopping_cart .widget-title{ background:url('". preg_replace('/(.png)/', '@2x.png', ''.$NHP_Options->get("widget_shopping_cart_icon").'')."') 0 0 no-repeat;}\n";
    }if ($NHP_Options->get("crum_widget_accordion_icon")){
        echo ".widget_crum_widget_accordion .widget-title, .crum_widget_accordion .widget-title{ background:url('". preg_replace('/(.png)/', '@2x.png', ''.$NHP_Options->get("crum_widget_accordion_icon").'')."') 0 0 no-repeat;}\n";
    }if ($NHP_Options->get("cont-map_icon")){
        echo ".widget_cont-map .page-block-widget-title, .cont-map .page-block-widget-title{ background:url('". preg_replace('/(.png)/', '@2x.png', ''.$NHP_Options->get("cont-map_icon").'')."') 0 4px no-repeat;}\n";
    }if ($NHP_Options->get("search-widget_icon")){
        echo ".widget_search-widget .widget-title, .search-widget .widget-title{ background:url('". preg_replace('/(.png)/', '@2x.png', ''.$NHP_Options->get("search-widget_icon").'')."') 0 4px no-repeat;}\n";
    }
?>

}

<?php


if ($NHP_Options->get("body_font_color")){
    echo 'body{ color:' . $NHP_Options->get("body_font_color") . '} ';
}
if (($NHP_Options->get("body_font_size")) && ($NHP_Options->get("body_font_size") !='.')){
    echo 'body,p,div{ font-size:' . $NHP_Options->get("body_font_size") . 'px} ';
}

$NHP_Options->show("custom_css"); ?>









