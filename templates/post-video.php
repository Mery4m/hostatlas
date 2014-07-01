<?php $post_id =  get_the_ID();


   if (get_post_meta($post->ID, 'post_vimeo_video_url', true)){ ?>

    <div class="flex-video widescreen vimeo">
        <iframe src='https://player.vimeo.com/video/<?php echo get_post_meta($post->ID, 'post_vimeo_video_url', true); ?>?portrait=0' width='640' height='460' frameborder='0'></iframe>
    </div>

    <?php
   }if (get_post_meta($post->ID, 'post_youtube_video_url', true)){ ?>

    <div class="flex-video  widescreen">
        <iframe width="640" height="460" src="https://www.youtube.com/embed/<?php echo get_post_meta($post->ID, 'post_youtube_video_url', true); ?>?wmode=opaque" frameborder="0" class="youtube-video" allowfullscreen></iframe>
     </div>
<?php }

if( get_post_meta($post_id, "self_hosted_videos",true ) ) {

if (has_post_thumbnail()) {
    $thumb = get_post_thumbnail_id();
    $img_url = wp_get_attachment_url($thumb, 'full'); //get img URL
    $article_image = aq_resize($img_url, 500, 300, true); ?>

<?php } ?>

<link href="https://vjs.zencdn.net/c/video-js.css" rel="stylesheet">
<script src="https://vjs.zencdn.net/c/video.js"></script>



<video id="video-post<?php the_ID();?>" class="video-js vjs-default-skin" controls
       preload="auto"
       width="500"
       height="281"
       poster="<?php echo $article_image ?>"
       data-setup="{}" >


    <?php if( get_post_meta($post_id, "post_video_mp4",true ) ): ?>
        <source src="<?php echo get_post_meta($post_id, "post_video_mp4",true ) ?>" type='video/mp4'>
    <?php endif;?>
    <?php if( get_post_meta($post_id, "post_video_webm", true ) ): ?>
        <source src="<?php echo get_post_meta($post_id, "post_video_webm", true ) ?>" type='video/webm'>
    <?php endif;?>
</video>


<?php }