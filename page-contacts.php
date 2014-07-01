<?php
/*
Template Name: Contacts page
*/


global $NHP_Options;

?>

<?php get_template_part('templates/top','page'); ?>

<section id="layout">

<script type="text/javascript" src="//maps.google.com/maps/api/js?sensor=false"></script>

<div class="row">

 <?php
 $mypages = get_pages( array( 'child_of' => $post->ID, 'sort_column' => 'post_date', 'sort_order' => 'asc' ) );
    foreach( $mypages as $page ) {

        $imgs = get_the_post_thumbnail($page->ID, 'post-thumbnails');
        $output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $imgs, $matches);
        $img_url = $matches [1] [0];
        $article_image = aq_resize($img_url, 80, 80, true); ?>

        <div class="team-brick four columns">

            <div class="team-photo">
                <a href="<?php echo get_page_link( $page->ID ); ?>">
                    <img src="<?php echo $article_image ?>" alt="<?php echo $page->post_title; ?>"/>
                </a>

                <h4><a href="<?php echo get_page_link( $page->ID ); ?>"><?php echo $page->post_title; ?></a></h4>
                <?php /*<span class="team-value">web designer</span>
                <span class="team-value">junior developer</span>
                */ ?>
            </div>

            <div class="ovh">
                <div class="team-desc">
                    <p><?php echo $page->post_excerpt; ?></p>
                </div>
            </div>

        </div>

        <?php    }     ?>

</div>

<div class="row">
<?php if ($NHP_Options->get("text_contact_page")){?>

    <div class="twelve columns cont-text">
        <p>
            <?php $NHP_Options->show("text_contact_page"); ?>
        </p>
    </div>
    <?php } ?>
</div>

<?php

$map_title = ($NHP_Options -> get("map_title")) ;
$map_subtitle = ( $NHP_Options -> get("map_subtitle")) ;

?>

<?php if (!($map_title == '') || !($map_subtitle == '')):?>
	<div class="row">
		<div class="twelve columns cont-map">
			<div class="page-block-title">
				<div class="subtitle"><?php echo ($map_subtitle)?></div>
				<h2><?php echo ($map_title)?></h2>
			</div>
		</div>
	</div>

<?php endif;?>

	<?php
	$opt = $NHP_Options->get("map_address");
	$zoom_level = ($NHP_Options->get("cont_m_zoom")) ? $NHP_Options->get("cont_m_zoom") : '14';
	?>

<div id="map"></div>

	<script type="text/javascript">
		jQuery(document).ready(function () {
			jQuery("#map")<?php if ($NHP_Options->get("cont_m_height")) echo '.height("' . $NHP_Options->get("cont_m_height") . 'px")'; ?>.gmap3({

				marker: {
					values: [
						<?php
						foreach ($opt as $k => $val) {
								$opt[$k] = $val;
								echo '{address: " '. $opt[$k] .'" , data:"'. $opt[$k] .'"},';
						} ?>
					],
					events:{
						mouseover: function(marker, event, context){
							var map = jQuery(this).gmap3("get"),
								infowindow = jQuery(this).gmap3({get:{name:"infowindow"}});
							if (infowindow){
								infowindow.open(map, marker);
								infowindow.setContent(context.data);
							} else {
								jQuery(this).gmap3({
									infowindow:{
										anchor:marker,
										options:{content: context.data}
									}
								});
							}
						},
						mouseout: function(){
							var infowindow = jQuery(this).gmap3({get:{name:"infowindow"}});
							if (infowindow){
								infowindow.close();
							}
						}
					}
				},
				map: {
					options: {
						zoom: <?php echo $zoom_level; ?>,
						navigationControl: true,
						mapTypeControl: false,
						scrollwheel: false,
						streetViewControl: true
					}
				}
			});

		});
	</script>


<div class="row">
    <div class="three columns">
        <?php $NHP_Options->show("adress_contact_page"); ?>
    </div>

    <div class="three columns">
        <?php $NHP_Options->show("other_contact_page"); ?>
    </div>

    <div class="six columns">

        <div class="page-block-title">
            <h2><?php _e('Leave reply', 'crum'); ?></h2>
        </div>

<?php

    if ($NHP_Options->get("custom_form_shortcode")){

        echo do_shortcode($NHP_Options->get("custom_form_shortcode"));

    } else {
        $admin_email = $NHP_Options->get("contacts_form_mail");

    if(empty($admin_email))
    {
        echo __('You need enter email in options panel', 'crum');
    }
else
{
if(isset($_POST['sender_name']))
{
    if($_POST['captcha'])
    {
        $headers = 'From: '.$_POST['sender_name'].' <'.$_POST['sender_email'].'>' . "\r\n";
        if(wp_mail($admin_email , "Subject: ".$_POST['letter_subject'] . "\tAuthor: " . $_POST['sender_name'] . "/" . $_POST['sender_email'], $_POST['letter_text'], $headers) )
            echo '<h2>' . __('Thank you for your message!' .'</h2>', 'crum');
        else
            echo '<h2>' . __('Unknown error, during message sending' .'</h2>', 'crum');
    }
    else
    {
        echo '<h2>' . __('Wrong check code. Please try again' .'</h2>', 'crum');
    }

    unset($_SESSION['key']);

} else {
    ?>
    <form action="" method="POST" name="page_feedback" id="page_feedback">
            <div class="commentform-inner">
                <input id="sender_name" name="sender_name" type="text" required= "required" placeholder="<?php _e('Enter your name', 'crum'); ?>">
                <input id="sender_email" name="sender_email" type="email" required= "required" placeholder="<?php _e('Your email', 'crum'); ?>">
                <input id="letter_subject" name="letter_subject" type="text" required= "required" placeholder="<?php _e('Mail subject', 'crum'); ?>">
            </div>
            <textarea  required= "required"  id="letter_text" name="letter_text"></textarea>
        <div class="row">
            <div class="three columns">
                <img src="<?php echo get_template_directory_uri() . '/inc/captcha/image.php'; ?>" border="0" />
            </div>
            <div class="four columns">
                <input type="text" name="captcha"  required= "required" class="text" id="captcha">
            </div>
            <div class="five columns" style="text-align: right">
                <button  class="button" name="submit"><?php _e('Leave reply', 'crum'); ?></button>
            </div>
        </div>
        </form>
<?php }}} ?>

    </div>

</div>
</section>


