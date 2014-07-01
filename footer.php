<?php global $NHP_Options;

if ($NHP_Options->get("footer_tw_disp")){
get_template_part('templates/section','top-footer');
}



get_template_part('templates/section','footer');

get_template_part('templates/section','bott-footer'); ?>




<a href="#" id="linkTop" class="backtotop"></a>

</div>

<?php
if( $NHP_Options->get("custom_js")) {
    $NHP_Options->show("custom_js");
}

wp_footer();?>