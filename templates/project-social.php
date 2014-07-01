<div class="project-social">
    <div>
        <div class="g-plusone" data-size="medium"></div>
        <script type="text/javascript">
            (function () {
                var po = document.createElement('script'),
                        s = document.getElementsByTagName('script')[0];

                po.type = 'text/javascript';
                po.async = true;
                po.src = 'https://apis.google.com/js/plusone.js';

                s.parentNode.insertBefore(po, s);
            } )();
        </script>
    </div>
    <div>
        <a href="https://twitter.com/share" class="twitter-share-button" data-lang="en">Tweet</a>
        <script type="text/javascript">
            !function (d, s, id) {
                var js = undefined,
                        fjs = d.getElementsByTagName(s)[0];

                if (!d.getElementById(id)) {
                    js = d.createElement(s);
                    js.id = id;
                    js.src = '//platform.twitter.com/widgets.js';

                    fjs.parentNode.insertBefore(js, fjs);
                }
            } (document, 'script', 'twitter-wjs');
        </script>
    </div>
    <div style="width: 70px">
		<?php
		$encoded_thumb ='';
		global $post;
		$encoded_url = urlencode(get_permalink($post -> ID));
		$encoded_excerpt = urlencode(get_the_excerpt());
		if (has_post_thumbnail()){
			$encoded_thumb = urlencode(wp_get_attachment_url(get_post_thumbnail_id($post -> ID)));
		}?>



		<a href="http://www.pinterest.com/pin/create/button/
        ?url=<?php echo($encoded_url);?>
        &media=<?php echo($encoded_thumb);?>
        &description=<?php echo($encoded_excerpt);?>"
		   data-pin-do="buttonPin" >
			<img border="0" title="Pin It" src="//assets.pinterest.com/images/pidgets/pin_it_button.png" />
		</a>



		<script type="text/javascript">
			(function(d){
				var f = d.getElementsByTagName('SCRIPT')[0], p = d.createElement('SCRIPT');
				p.type = 'text/javascript';
				p.async = true;
				p.src = '//assets.pinterest.com/js/pinit.js';
				f.parentNode.insertBefore(p, f);
			}(document));
		</script>




    </div>
    <div>
        <div class="fb-like" data-send="false" data-layout="button_count" data-width="200" data-show-faces="false" data-font="arial"></div>
        <script type="text/javascript">
            (function (d, s, id) {
                var js = undefined,
                        fjs = d.getElementsByTagName(s)[0];

                if (d.getElementById(id)) {
                    return;
                }

                js = d.createElement(s);
                js.id = id;
                js.src = '//connect.facebook.net/en_US/all.js#xfbml=1';

                fjs.parentNode.insertBefore(js, fjs);
            } (document, 'script', 'facebook-jssdk'));
        </script>
    </div>
</div>