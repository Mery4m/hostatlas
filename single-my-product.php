
<?php
global $NHP_Options;
global $data;
$is_full = ($NHP_Options->get("portfolio_single_style") == 'full');

get_template_part('templates/top','folio'); ?>

<section id="layout">

<div class="row">
    <div class="project one-photo clearing-container">


    <div class="<?php echo ($is_full) ? 'twelve' : 'eight'; ?> columns">

    <?php

    $folio_video = false;

        if (!post_password_required(get_the_id())) {
        $custom = get_post_custom($post->ID);

        if (get_post_meta($post->ID, 'folio_vimeo_video_url', true)): ?>

            <div class="flex-video widescreen vimeo">
                <iframe src='https://player.vimeo.com/video/<?php echo get_post_meta($post->ID, 'folio_vimeo_video_url', true); ?>?portrait=0' width='640' height='460' frameborder='0'></iframe>
            </div>

        <?php $folio_video = true; endif;

        if (get_post_meta($post->ID, 'folio_youtube_video_url', true)): ?>

            <div class="flex-video  widescreen">
                <iframe width="640" height="460" src="https://www.youtube.com/embed/<?php echo get_post_meta($post->ID, 'folio_youtube_video_url', true); ?>?wmode=opaque" frameborder="0" class="youtube-video" allowfullscreen></iframe>
            </div>

            <?php $folio_video = true; endif;

        if ((get_post_meta($post->ID, 'folio_self_hosted_mp4', true) != '') || (get_post_meta($post->ID, 'folio_self_hosted_webm', true) != '')) {

                if (has_post_thumbnail()) {
                    $thumb = get_post_thumbnail_id();
                    $img_url = wp_get_attachment_url($thumb, 'full'); //get img URL
                    $article_image = aq_resize($img_url, 640, 460, true); ?>

                    <?php } ?>

                <link href="https://vjs.zencdn.net/c/video-js.css" rel="stylesheet">
                <script src="https://vjs.zencdn.net/c/video.js"></script>


                <video id="video-post<?php the_ID();?>" class="video-js vjs-default-skin" controls
                       preload="auto"
                       width="640"
                       height="460"
                       poster="<?php echo $article_image ?>"
                       data-setup="{}">


                    <?php if (get_post_meta($post->ID, 'folio_self_hosted_mp4', true)): ?>
                    <source src="<?php echo get_post_meta($post->ID, 'folio_self_hosted_mp4', true) ?>" type='video/mp4'>
                    <?php endif;?>
                    <?php if (get_post_meta($post->ID, 'folio_self_hosted_webm"', true)): ?>
                    <source src="<?php echo get_post_meta($post->ID, 'folio_self_hosted_webm"', true)  ?>" type='video/webm'>
                    <?php endif;?>
                </video>


            <?php
            $folio_video = true;

            }   echo '<div id="work-slider">';


            if (has_post_thumbnail()) {
                $thumb = get_post_thumbnail_id();
                $img_url = wp_get_attachment_url($thumb, 'full'); //get img URL
                $img_width = $is_full ? 1200 : 940;
                $img_height = $is_full ? 1200 : 999;
                $article_image = aq_resize($img_url, $img_width, $img_height, false); //resize & crop img
            }

            if ($NHP_Options->get("portfolio_single_featured")) {
                if ((has_post_thumbnail()) && !$folio_video) { ?>

                    <img src="<?php echo $article_image ?>" alt="<?php the_title(); ?>" class="thumbnail"/>

                    <?php
            }}


            $args = array(
                'order' => $NHP_Options->get("sort_order_folio_images"),
                'orderby' => $NHP_Options->get("order_folio_images"),
                'exclude' => get_post_thumbnail_id($post->ID),
                'post_type' => 'attachment',
                'post_parent' => $post->ID,
                'post_mime_type' => 'image',
                'post_status' => null,
                'numberposts' => -1,
            );
            $attachments = get_posts($args);
            $attachments_count = '0';
            if ($attachments) {
                foreach ($attachments as $attachment) {
                    $img_url = wp_get_attachment_url($attachment->ID); //get img URL

                    if ($NHP_Options->get("portfolio_single_slider") == 'full') {
                        $img_height = 9999;
                    } else {
                        $img_height = 1200;
                    }

                    $img_width = 1200;

                    $article_image = aq_resize($img_url, $img_width, $img_height, false); //resize & crop img
                    $attachments_count++;
                    ?>

                    <img src="<?php echo $article_image ?>" alt="<?php the_title(); ?>" class="thumb1"/>


                    <?php }   } ?>

</div></div>

    <div  class="folio-info <?php echo $is_full?'twelve':'four'; ?> columns">

        <?php while (have_posts()) : the_post(); ?>

        <h6 class="project-info">
            <?php if ($NHP_Options->get("folio_date") != '') {
                echo '<time>' . get_the_date() . '</time>';
            } ?>

            <span class="project-cat">

                <?php get_template_part('templates/folio', 'terms'); ?>

                <?php the_tags('<span class="delim">&nbsp;</span> <span class="tags">', ', ', '</span>'); ?>

			</span>
        </h6>

        <div class="entry-content">
            <?php the_content(); ?>
        </div>

        <ul class="person-list">

            <?php
            if(function_exists('get_field_object')){

                $fields = get_post_custom_keys( get_the_id() );
                foreach( $fields as $key=>$field ){
                    substr( $field, 0, 1);
                    if(substr( $field, 0, 1) == '_')
                        unset($fields[$key]);
                }

                $fields = array_flip($fields);
                foreach($fields as $key=>$field){
                    $fields[$key] = get_post_meta($post->ID,$key, true);
                }

                if( $fields ) {
                    foreach( $fields as $field_name => $value ) {

                        $field = get_field_object($field_name, false, array('load_value' => false));

                        if ($value) {

                            if ($field_name == 'website_link') {

                                echo '<li class="field-link"><a href="http://' . $value . '">';
                                echo $value;
                                echo '</a></li>';

                            } else {

                            }
                            if ($field['label'] != '') {
                                echo '<li><strong>';
                                echo $field['label'] . ':</strong> ';
                                echo $value;
                                echo '</li>';
                            }
                        }
                    }
                }} ?>
        </ul>
        <?php endwhile; ?>

        <?php

        if( $NHP_Options->get("post_share_button") ) { ; ?>

            <!--social share buttons start-->
            <?php get_template_part('templates/project','social'); ?>
            <!--social share ends-->
            <?php } ?>
        
    </div>


</div>


<?php } else the_content(); ?>


<div class="row">

    <?php get_template_part('templates/block','recent'); ?>

</div>

</section>

<?php if (has_post_thumbnail()&&($NHP_Options->get("portfolio_single_slider") != 'full')&&($attachments_count > 1)){ ?>

<script type="text/javascript">
    jQuery(window).load(function() {
        jQuery("#work-slider").orbit();
    });

</script>
<?php
}