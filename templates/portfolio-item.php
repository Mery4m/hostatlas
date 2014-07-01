<?php global $NHP_Options;

if (has_post_thumbnail()) {
    $thumb = get_post_thumbnail_id();
    $img_url = wp_get_attachment_url($thumb, 'full'); //get img URL
} else {
    $img_url = get_template_directory_uri() . '/img/no-image-large.jpg';
}
$article_image = aq_resize($img_url, 780, 320, true); //resize & crop img

$folio_video = false;

if (get_post_meta($post->ID, 'folio_vimeo_video_url', true) || get_post_meta($post->ID, 'folio_youtube_video_url', true) ||
    (get_post_meta($post->ID, 'folio_self_hosted_mp4', true) != '') || (get_post_meta($post->ID, 'folio_self_hosted_webm', true) != '')
) {
    $folio_video = true;
}
?>

<div class="project one-photo clearing-container">
    <div class="eight columns">
        <div class="entry-thumb <?php if ($folio_video) {
            echo 'video-link';
        } else {
            echo '';
        } ?>">
            <a href="<?php the_permalink(); ?>" class="more-link">
                <img src="<?php echo $article_image ?>" alt="<?php the_title(); ?>" title="<?php the_title(); ?>">
            </a>
        </div>
    </div>
    <div class="four columns">
        <h6 class="project-info">
            <?php if ($NHP_Options->get("folio_date") != '') {
                echo '<time>' . get_the_date() . '</time>';
            } ?>
            <span class="project-cat">

                                <?php get_template_part('templates/folio', 'terms'); ?>

							</span>
        </h6>

        <h3 class="project-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>

        <div class="entry-content">
            <?php
			$excerpt = get_the_excerpt();
			echo ($excerpt);
			?>
        </div>
        <ul class="person-list">

            <?php
            if (function_exists('get_field_object')){

            $fields = get_post_custom_keys(get_the_id());
            foreach ($fields as $key => $field) {
                substr($field, 0, 1);
                if (substr($field, 0, 1) == '_')
                    unset($fields[$key]);
            }

            $fields = array_flip($fields);
            foreach ($fields as $key => $field) {
                $fields[$key] = get_post_meta($post->ID, $key, true);
            }

            if ($fields) {
                foreach ($fields as $field_name => $value) {

                    $field = get_field_object($field_name, false, array('load_value' => false));

                    if ($value !='') {

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
                }
            } ?>
        </ul>
        <a href="<?php the_permalink(); ?>" class="button"><?php echo __('Read details', 'crum'); ?></a>
    </div>
</div>
