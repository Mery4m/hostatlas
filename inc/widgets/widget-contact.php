<?php
//CONTACT FORM

class crum_contact extends WP_Widget {

	function crum_contact() {

		/* Widget settings. */

		$widget_ops = array( 'classname' => 'contact-form-widget', 'description' => __( 'Displays sample Contact form','theory') );

		/* Widget control settings. */

		$control_ops = array( 'width' => 200, 'height' => 350, 'id_base' => 'crum_contact' );

		/* Create the widget. */

		$this->WP_Widget( 'crum_contact', 'Theme: Contact form', $widget_ops, $control_ops );

	}

	function widget( $args, $instance ) {

		extract( $args );

		/* User-selected settings. */

		$title = $instance['title'];

        $subtitle = $instance['subtitle'];

		$admin_email = $instance['admin_email'];

		$question = $instance['question'];

		$answer = $instance['answer'];

  /* Before widget (defined by themes). */

        echo $before_widget;

        if ( $subtitle ) {
            echo '<div class="subtitle">';
            echo $subtitle;
            echo '</div>';
        }

		/* Title of widget (before and after defined by themes). */
	  if ( $title ) {

        	 echo $before_title;
                echo $title;
             echo $after_title;

        }

		/* Display Latest Tweets */

	?>
           <?php
            if(isset($_POST['sender_name'])){

              if( $answer == $_POST['captcha']){
                if( wp_mail($admin_email , "Subject: ".$_POST['letter_subject']."\tAuthor: ".$_POST['sender_name']."/".$_POST['sender_email'], $_POST['letter_text']) )
                    echo _e('<h2>Thank you for your message!</h2>', 'roots') ."</h3>";
                else
                    echo _e('<h2>Unknown error, during message sending.</h2>', 'roots') ."</h3>";
              }else {
                  echo _e('<h2>Wrong answer for the question!</h2>', 'roots') ."</h3>";
              }

            } else {
          ?>

            <form action="" method="POST" name="widget_feedback" id="widget_feedback" class="write-form">
                <div class="row">
                    <div class="five columns">
                        <label for="sender_name"><?php _e('Name', 'roots'); ?></label>
                        <input type="text" class="text" name="sender_name" id="sender_name" />
                    </div>
                    <div class="five columns">
                        <label for="sender_email"><?php _e('E-mail', 'roots'); ?></label>
                        <input id="sender_email" name="sender_email" class="text" type="text" />
                    </div>
                    <div class="five columns">
                        <label><?php _e('Topic:', 'roots');?></label>
                        <input class="text" type="text" name="letter_subject" id="letter_subject" />
                    </div>
                </div>
                <label><?php _e('Comment', 'roots'); ?></label>
                <textarea name="letter_text" id="letter_text" cols="30" rows="3" placeholder=""></textarea>

                <div class="row">
                    <div class="ten columns">
                        <?php echo $question; ?>&nbsp;&nbsp;
                    </div>
                    <div class="five columns">
                        <input type="text" name="captcha" class="text" id="captcha">
                    </div>

                    <input type="submit" class="button right" tabindex="5" value="<?php _e('Send message', 'roots'); ?>" />

                    <input type="checkbox" id="captcha_checkbox" style="display:none;">
            </form>
            <?php
                wp_register_script('validate', ''.get_template_directory_uri().'/assets/js/jquery.validate.min.js', false, array('jquery'), true);
                wp_enqueue_script('validate');
            ?>
            <script type="text/javascript">
                jQuery(document).ready(function($){

                    $("#sender_email,#sender_name,#letter_subject,#letter_text, #captcha").on("keydown", function(){
                        if( $(this).css("color") == "rgb(255, 0, 0)" )
                            $(this).css("color","#000000").val("");
                    });

                    $("#widget_feedback input[type=submit]").on("click", function(){
                        if( $("#sender_email").css("color") == "rgb(255, 0, 0)") $("#sender_email").val("");
                        if( $("#sender_name").css("color") == "rgb(255, 0, 0)") $("#sender_name").val("");
                        if( $("#letter_subject").css("color") == "rgb(255, 0, 0)") $("#letter_subject").val("");
                        if ($("#letter_text").css("color") == "rgb(255, 0, 0)") $("#letter_text").val("");
                        if ($("#captcha").css("color") == "rgb(255, 0, 0)") $("#captcha").val("");
                    });

                    $("#widget_feedback").validate({
                        submitHandler: function(form) {
                            form.submit();
                        },
                        rules: {
                            sender_email: {
                                required: true,
                                email: true
                            },
                            sender_name: {
                                required:true
                            },
                            letter_subject: {
                                required:true
                            },
                            letter_text: {
                                required:true
                            },
                            captcha: {
                                required:true,
                                equal:"<?php echo $answer; ?>"
                            }
                        },
                        messages: {
                            sender_email: {
                                required: "<?php _e('Type your email!', 'roots'); ?>",
                                email: "<?php _e('Email is incorect', 'roots'); ?>"
                            },
                            sender_name: {
                                required:"<?php _e('Type your name!', 'roots'); ?>"
                            },
                            letter_subject: {
                                required:"<?php _e('Type the subject!', 'roots'); ?>"
                            },
                            letter_text: {
                                required:"<?php _e('Type the message!', 'roots'); ?>"
                            },
                            captcha: {
                                required:"<?php _e('Type the answer!', 'roots'); ?>",
                                equal: "<?php _e('Wrong  answer!', 'roots'); ?>"
                            }
                        },
                        errorPlacement: function(error, element) {
                            //element.css("color","red").val(error.html());
                        },
                        invalidHandler: function(form, validator) {
                            for(z in validator['errorList'] ){
                                var element = validator['errorList'][z]['element'];
                                var message = validator['errorList'][z]['message'];
                                jQuery(element).css("color","red").val(message);
                            }
                        }
                    });
                });
            </script>

          

          <?php }

		/* After widget (defined by themes). */

		echo $after_widget;

	}

	function update( $new_instance, $old_instance ) {

		$instance = $old_instance;



		/* Strip tags (if needed) and update the widget settings. */

		$instance['title'] = $new_instance['title'];

        $instance['subtitle'] = strip_tags( $new_instance['subtitle'] );

		$instance['admin_email'] = strip_tags( $new_instance['admin_email'] );

		$instance['question'] = strip_tags( $new_instance['question'] );

		$instance['answer'] = strip_tags( $new_instance['answer'] );

		return $instance;

	}

	function form( $instance ) {



		/* Set up some default widget settings. */

		$defaults = array( 'title' => 'Contact us',  'admin_email'=>get_option('admin_email'),

            "question" => " If you are not a spammer, then say how many legs does elephant have?", "answer" => 4 );

		$instance = wp_parse_args( (array) $instance, $defaults ); ?>
   

         <p>

			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:','theory'); ?></label>

			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:215px" />

		</p>

    <p>
      <label for="<?php echo $this->get_field_id( 'subtitle' ); ?>"><?php _e( 'Subtitle:','theory'); ?></label>
      <input class="widefat" id="<?php echo $this->get_field_id( 'subtitle' ); ?>" name="<?php echo $this->get_field_name( 'subtitle' ); ?>" value="<?php echo $instance['subtitle']; ?>" style="width:160px" />
    </p>

        <p>

			<label for="<?php echo $this->get_field_id( 'admin_email' ); ?>"><?php _e( 'E-mail:','theory'); ?></label>

			<input id="<?php echo $this->get_field_id( 'admin_email' ); ?>" name="<?php echo $this->get_field_name( 'admin_email' ); ?>" value="<?php echo $instance['admin_email']; ?>" style="width:215px" />

		</p>

        <p>

            <label for="<?php echo $this->get_field_id( 'question' ); ?>"><?php _e( 'Anti-spam question:','theory'); ?></label>

            <input id="<?php echo $this->get_field_id( 'question' ); ?>" name="<?php echo $this->get_field_name( 'question' ); ?>" value="<?php echo $instance['question']; ?>" style="width:215px" />

        </p>

        <p>

            <label for="<?php echo $this->get_field_id( 'answer' ); ?>"><?php _e( 'Answer for the anti-spam question:','theory'); ?></label>

            <input id="<?php echo $this->get_field_id( 'answer' ); ?>" name="<?php echo $this->get_field_name( 'answer' ); ?>" value="<?php echo $instance['answer']; ?>" style="width:215px" />

        </p>

        <?php

	}

}

?>