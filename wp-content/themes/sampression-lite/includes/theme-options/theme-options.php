<?php

/**
 * Sampression Lite Theme Options
 *
 * @package Sampression-Lite
 * @since Sampression Lite 1.0
 */
 
// Bringing up Sampression Theme Option page after install
if ( is_admin() && isset($_GET['activated'] ) && $pagenow == "themes.php" ) {
	wp_redirect( 'themes.php?page=sampression-options' );
}

/*=======================================================================
 * Function to build theme options
 *=======================================================================*/
add_action('admin_menu', 'sampression_theme_options');
function sampression_theme_options() {
	$samp_menu = add_theme_page(__('Sampression Theme Option', 'sampression'), __('Theme Options','sampression'), 'edit_theme_options', 'sampression-options', 'sampression_build_options');
	//$samp_menu = add_menu_page(__("Sampression Theme Options",'sampression'), __("Sampression",'sampression'), 'edit_theme_options', 'sampression-options', 'sampression_build_options');
	add_action( 'admin_print_scripts-'.$samp_menu, 'sampression_admin_enqueue_scripts' );
	add_action('admin_print_styles-'.$samp_menu, 'sampression_admin_enqueue_styles');
	}
/*=======================================================================
 * Getting js and css files for theme options
 *=======================================================================*/
function sampression_admin_enqueue_scripts() {
	/* register */
	wp_register_script( 'jquery-cookies', get_template_directory_uri() . '/includes/theme-options/jquery.cookies.js', array( 'jquery' ), '1.0' );
	wp_register_script( 'sampression-theme-options-js', get_template_directory_uri() . '/includes/theme-options/theme-options.js', array( 'jquery' ), '1.0' );
	/* enqueue */
	wp_enqueue_script('media-upload');
	wp_enqueue_script( 'jquery-cookies');
	wp_enqueue_script( 'sampression-theme-options-js');
	}

function sampression_admin_enqueue_styles() {
	/* register */
	wp_register_style( 'sampression-theme-options-css', get_template_directory_uri() . '/includes/theme-options/theme-options.css', array(), '1.4', 'screen' );
	/* enqueue */
	wp_enqueue_style('sampression-theme-options-css');
}

/*=======================================================================
 * Building tabs for Theme Options
 *=======================================================================*/
function sampression_build_options() {
	?>
	<div id="icon-themes" class="icon32"></div>
	<div class="container">
	<h1><?php _e('Sampression Lite Options','sampression'); ?></h1>
	<?php
	if ( isset($_POST['sampression_theme_action']) && $_POST['sampression_theme_action'] == 'submit' ) {
		$options = array ( 'sam_logo', 'sam_use_logo', 'sam_favicons', 'sam_use_favicon16x16',  'sam_apple_icons_57', 'sam_use_appletouch57x57', 'sam_apple_icons_72', 'sam_use_appletouch72x72', 'sam_apple_icons_114', 'sam_use_appletouch114x114', 'sam_apple_icons_144', 'sam_use_appletouch144x144', 'sam_header', 'sam_footer', 'get_facebook', 'get_twitter', 'get_gplus','get_youtube' );
		foreach ( $options as $opt ) {
			if(isset($_POST[$opt])) {
				delete_option ( 'opt_'.$opt, $_POST[$opt] );
				add_option ( 'opt_'.$opt, trim($_POST[$opt]) );
			}
		}
		// Theme Options setting message
		sampression_showMessage('Theme options have been successfully updated.', $errormsg = false);
	} else if ( isset($_POST['sampression_theme_action']) && $_POST['sampression_theme_action'] == 'restore' ) {
		$options = array ('sam_logo', 'sam_use_logo', 'sam_favicons', 'sam_use_favicon16x16',  'sam_apple_icons_57', 'sam_use_appletouch57x57', 'sam_apple_icons_72', 'sam_use_appletouch72x72', 'sam_apple_icons_114', 'sam_use_appletouch114x114', 'sam_apple_icons_144', 'sam_use_appletouch144x144' );
		foreach ( $options as $opt ) {
			if(isset($_POST[$opt])) {
				delete_option ( 'opt_'.$opt, $_POST[$opt] );
			}
		}
		// Theme Options setting message: successfully restored.
		sampression_showMessage('Theme options have been successfully restored.', $errormsg = false);
		// Getting support form
	} else if ( isset($_POST['sampression_theme_action']) && $_POST['sampression_theme_action'] == 'support' ) {
		$fullname = $_POST['fullname'];
		$emailadd = $_POST['emailadd'];
		$userip = $_POST['userip'];
		$emailsubj = $_POST['emailsubj'];
		$emailmsg = $_POST['emailmsg'];
		$toemail = "themes@sampression.com";
		$text_message = "Dear Admin,<p>Support message have been received from ".get_bloginfo('wpurl').". Client IP address: $userip.</p><p>Message Body:</p><p>$emailmsg</p>";
		$headers='MIME-Version: 1.0' . "\r\n";
		$headers.='Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers.='From: '.$fullname.' <'.$emailadd.'>' . "\r\n";
		
		if(wp_mail($toemail, $emailsubj, $text_message, $headers)) {
			sampression_showMessage('Your message have been successfully sent to Sampression Support Team.', $errormsg = false);
		} else {
			sampression_showMessage('Your message could not be sent at the moment. Please try again later.', $errormsg = true);
		}
	}
	sampression_options_tabs();
}

/*=======================================================================
 * Display extra codes on header and footer
 *=======================================================================*/

// Display Extra codes in Header
function sampression_header_code() {
    if (get_option('opt_sam_header')) {
		echo stripslashes(get_option('opt_sam_header')) . "\n";
	}
}
add_action('wp_head', 'sampression_header_code');

// Display Extra codes in Footer
function sampression_footer_code() {
    if (get_option('opt_sam_footer')) {
		echo stripslashes(get_option('opt_sam_footer')) . "\n";
	}
}
add_action('wp_footer', 'sampression_footer_code');



/*=======================================================================
 * Buiding different tabs cotent for Theme Options
 *=======================================================================*/
function sampression_options_tabs() { ?>
    <form method="post" name="frm_theme_option" class="options-tab" action="<?php admin_url( 'themes.php?page=sampression-options' ); ?>">
    <ul class="tabs">
        <li><a href="#tab1"><?php _e('Logo &amp; Icons','sampression'); ?></a></li>
        <li><a href="#tab2"><?php _e('Social Media','sampression'); ?></a></li>
        <li><a href="#tab3"><?php _e('Advanced','sampression'); ?></a></li>
        <li><a href="#tab4"><?php _e('Get Support','sampression'); ?></a></li>
    </ul>

        <div class="tab_container">
        <!-- Tab: Logo & Icons -->
        <div style="display: none;" id="tab1" class="tab_content">
        
        <fieldset class="fieldset-1">
        	<legend><?php echo _e('Site Logo','sampression'); ?></legend>
            <div class="group logo-section">
			<!-- Site Logo -->
            <div class="col col-1">
                <label><?php echo _e('Browse or enter logo URL','sampression'); ?></label>
                <input type="text" name="sam_logo" class="upload_image text-box" value="<?php echo get_option('opt_sam_logo'); ?>" />
                <input class= "upload_image_button button" type="button" value="Browse" />
                
                <p>
                	<input type="checkbox" id="logo_front_end" value="yes" <?php echo sampression_check('opt_sam_use_logo'); ?> onclick="check_frontend_logo()"/>
                    <input type="hidden" name="sam_use_logo" id="sam_use_logo" value="<?php if(get_option('opt_sam_use_logo')) { echo get_option('opt_sam_use_logo'); } else { echo _e('no','sampression'); } ?>" />
                    <label for="logo_front_end" class="inline"><?php echo _e('I dont want to use Logo.','sampression'); ?></label>
                </p>
                <div class="image-block image-holder">
                	<?php if(get_option('opt_sam_logo')) { ?>
                    <img src="<?php echo get_option('opt_sam_logo'); ?>" alt="<?php echo _e('Logo','sampression'); ?>" />
                    <?php }?>
                </div>
            </div>
			<!-- Site Logo  Preview-->
            <div class="col col-2">
            <p class="title"><?php echo _e('Logo Preview', 'sampression'); ?></p>
            <?php  if(!get_option('opt_sam_use_logo')  || get_option('opt_sam_use_logo') == 'no') { ?>
                <div class="col image-block image-holder logo-img">
                	
                	<?php if(get_option('opt_sam_logo')) { ?>
                    <img src="<?php echo get_option('opt_sam_logo'); ?>" alt="Logo" />
                    <?php } ?>
                </div>
                <?php }  ?>
				
                <!-- .logo-img -->
                <div class="logo-txt">
                <h1 id="site-title"><?php bloginfo( 'name' ); ?></h1>
          		<h2 id="site-description"><?php bloginfo( 'description' ); ?></h2>
                </div>
                <!-- .logo-txt -->
             </div>
            </div>
        </fieldset>
        <fieldset class="fieldset-1">
        	<legend><?php echo _e('Favicon and apple touch icons','sampression'); ?></legend>
			<!-- Favicon  -->
            <div class="group">
                <label><?php echo _e('Favicon','sampression'); ?></label>
                <input type="text" class="upload_image text-box" name="sam_favicons" value="<?php echo get_option('opt_sam_favicons'); ?>" />
                <input class= "upload_image_button button" type="button" value="Browse" />
				 <p>
                	<input type="checkbox" id="sam_favicon16x16" value="yes" <?php echo (get_option('opt_sam_use_favicon16x16')=='yes')? 'checked="checked"':' '; ?> onclick="check_frontend_logo()"/>
                    <input type="hidden" name="sam_use_favicon16x16" id="sam_use_favicon16x16" value="
					<?php if(get_option('opt_sam_use_favicon16x16')) { echo get_option('opt_sam_use_favicon16x16'); } else { echo _e('no','sampression'); } ?>" />
                    <label for="sam_favicon16x16" class="inline"><?php echo _e('I dont want to use favicon.','sampression'); ?></label>
                </p>
                <div class="image-block image-holder">
                	<?php if(get_option('opt_sam_favicons')) { ?>
                    <img src="<?php echo get_option('opt_sam_favicons'); ?>" alt="<?php echo _e('Favicon','sampression'); ?>" width="16" />
                    <?php } ?>
                    <p class="note"><?php _e('File dimension should be 16x16.', 'sampression'); ?></p>
                </div>
            </div>
			<!-- Apple Touch Icon (57x57)  -->
            <div class="group">
                <label><?php echo _e('Apple Touch Icon (57x57)','sampression'); ?></label>
                <input type="text" class="upload_image text-box" name="sam_apple_icons_57" value="<?php echo get_option('opt_sam_apple_icons_57'); ?>" />
                <input class= "upload_image_button button" type="button" value="Browse" />
				
				<p>
                	<input type="checkbox" id="sam_appletouch57x57" value="yes" <?php echo (get_option('opt_sam_use_appletouch57x57')=='yes')? 'checked="checked"':' '; ?> onclick="check_frontend_logo()"/>
                    <input type="hidden" name="sam_use_appletouch57x57" id="sam_use_appletouch57x57" value="
					<?php if(get_option('opt_sam_use_appletouch57x57')) { echo get_option('opt_sam_use_appletouch57x57'); } else { echo _e('no','sampression'); } ?>" />
                    <label for="sam_appletouch57x57" class="inline"><?php echo _e('I dont want to use apple touch icon.','sampression'); ?></label>
                </p>
				
                <div class="image-block image-holder">
                	<?php if(get_option('opt_sam_apple_icons_57')) { ?>
                    <img src="<?php echo get_option('opt_sam_apple_icons_57'); ?>" alt="Apple Icon 57 x 57" width="57" />
                    <?php } ?>
                </div>
            </div>
			<!-- Apple Touch Icon for first and second generation iPad (72x72)  -->
            <div class="group">
                <label><?php echo _e('Apple Touch Icon for first and second generation iPad (72x72)','sampression'); ?></label>
                <input type="text" class="upload_image text-box" name="sam_apple_icons_72" value="<?php echo get_option('opt_sam_apple_icons_72'); ?>" />
                <input class= "upload_image_button button" type="button" value="Browse" />
				
				<p>
                	<input type="checkbox" id="sam_appletouch72x72" value="yes" <?php echo (get_option('opt_sam_use_appletouch72x72')=='yes')? 'checked="checked"':' '; ?> onclick="check_frontend_logo()"/>
                    <input type="hidden" name="sam_use_appletouch72x72" id="sam_use_appletouch57x57" value="
					<?php if(get_option('opt_sam_use_appletouch72x72')) { echo get_option('opt_sam_use_appletouch72x72'); } else { echo _e('no','sampression'); } ?>" />
                    <label for="sam_appletouch72x72" class="inline"><?php echo _e('I dont want to use apple touch icon.','sampression'); ?></label>
                </p>
				
                <div class="image-block image-holder">
                	<?php if(get_option('opt_sam_apple_icons_72')) { ?>
                    <img src="<?php echo get_option('opt_sam_apple_icons_72'); ?>" alt="Apple Icon 72 x 72" width="72" />
                    <?php } ?>
                </div>
            </div>
			<!-- Apple Touch Icon for first and second generation iPad (114x114)  -->
            <div class="group">
                <label><?php echo _e('Apple Touch Icon for for high-resolution iPad and iPhone Retina displays (114x114)','sampression'); ?></label>
                <input type="text" class="upload_image text-box" name="sam_apple_icons_114" value="<?php echo get_option('opt_sam_apple_icons_114'); ?>" />
                <input class= "upload_image_button button" type="button" value="Browse" />
				
				<p>
                	<input type="checkbox" id="sam_appletouch114x114" value="yes" <?php echo (get_option('opt_sam_use_appletouch114x114')=='yes')? 'checked="checked"':' '; ?> onclick="check_frontend_logo()"/>
                    <input type="hidden" name="sam_use_appletouch114x114" id="sam_use_appletouch114x114" value="
					<?php if(get_option('opt_sam_use_appletouch114x114')) { echo get_option('opt_sam_use_appletouch114x114'); } else { echo _e('no','sampression'); } ?>" />
                    <label for="sam_appletouch114x114" class="inline"><?php echo _e('I dont want to use apple touch icon.','sampression'); ?></label>
                </p>
				
                <div class="image-block image-holder">
                	<?php if(get_option('opt_sam_apple_icons_114')) { ?>
                    <img src="<?php echo get_option('opt_sam_apple_icons_114'); ?>" alt="Apple Icon 114 x 114" width="114" />
                    <?php } ?>
                </div>
            </div>
			<!-- Apple Touch Icon for first and second generation iPad (144x144)  -->
			<div class="group">
                <label><?php echo _e('Apple Touch Icon for for high-resolution iPad and iPhone Retina displays (144x144)','sampression'); ?></label>
                <input type="text" class="upload_image text-box" name="sam_apple_icons_144" value="<?php echo get_option('opt_sam_apple_icons_144'); ?>" />
                <input class= "upload_image_button button" type="button" value="Browse" />
				
				<p>
                	<input type="checkbox" id="sam_appletouch144x144" value="yes" <?php echo (get_option('opt_sam_use_appletouch144x144')=='yes')? 'checked="checked"':' '; ?> onclick="check_frontend_logo()"/>
                    <input type="hidden" name="sam_use_appletouch144x144" id="sam_use_appletouch144x144" value="
					<?php if(get_option('opt_sam_use_appletouch144x144')) { echo get_option('opt_sam_use_appletouch144x144'); } else { echo _e('no','sampression'); } ?>" />
                    <label for="sam_appletouch144x144" class="inline"><?php echo _e('I dont want to use apple touch icon.','sampression'); ?></label>
                </p>
				
                <div class="image-block image-holder">
                	<?php if(get_option('opt_sam_apple_icons_144')) { ?>
                    <img src="<?php echo get_option('opt_sam_apple_icons_144'); ?>" alt="Apple Icon 144 x 144" width="144" />
                    <?php } ?>
                </div>
            </div>
        </fieldset>
        <input type="hidden" name="sampression_theme_action" id="sampression_theme_action" value="" />
        <input class="button-primary" type="button" onclick="load_theme_action('submit')" value="Save" />
        <input class="button-primary" type="button" onclick="load_theme_action('restore')" value="Re-store Default" />
       </div>
       <!-- Tab: Social Media -->
        <div style="display: none;" id="tab2" class="tab_content">
        <ul class="admin-style-1 social-media">
        	<li class="group">
            <label for="get_facebook"><?php _e('Facebook','sampression'); ?></label>
            <input type="text" name="get_facebook" id="get_facebook" class="input-text" value="<?php echo stripslashes(get_option('opt_get_facebook')); ?>" />
            <p class="note"><em><?php _e('Insert your Facebook ID only, For eg. <strong>xyz</strong> from http://facebook.com/<strong>xyz</strong>', 'sampression'); ?></em></p>
        	</li>
            
            <li class="group">
            <label for="get_twitter"><?php _e('Twitter','sampression'); ?></label>
            <input type="text" name="get_twitter" id="get_twitter" class="input-text" value="<?php echo stripslashes(get_option('opt_get_twitter')); ?>" />
            <p class="note"><em><?php _e('Insert your Twitter ID only, For eg. <strong>xyz</strong> from http://twitter.com/<strong>xyz</strong>', 'sampression'); ?></em></p>
        	</li>
            
            <li class="group">
            <label for="get_gplus"><?php _e('Google Plus','sampression'); ?></label>
            <input type="text" name="get_gplus" id="get_gplus" class="input-text" value="<?php echo stripslashes(get_option('opt_get_gplus')); ?>" />
            <p class="note"><em><?php _e('Insert the full URL of your Google Plus ID, For eg. https://plus.google.com/u/0/123456789/posts', 'sampression'); ?></em></p>
        	</li>
            
			<li class="group">
            <label for="get_youtube"><?php _e('YouTube','sampression'); ?></label>
            <input type="text" name="get_youtube" id="get_youtube" class="input-text" value="<?php echo stripslashes(get_option('opt_get_youtube')); ?>" />
            <p class="note"><em><?php _e('Insert the full URL of your YouTube Channel, For eg. https://www.youtube.com/user/<strong>xyz</strong>', 'sampression'); ?></em></p>
        	</li>
			
            <li class="group">
				<input class="button-primary" type="button" onclick="load_theme_action('submit')" value="Save" />
            </li>
        </ul>
        </div>
        <!-- Tab: Advanced -->
        <div style="display: none;" id="tab3" class="tab_content">
        <fieldset class="fieldset-1">
        	<legend><?php _e('Custom code to insert into Header','sampression'); ?></legend>
            <textarea name="sam_header" class="text-area" rows="10" cols="100"><?php echo stripslashes(get_option('opt_sam_header')); ?></textarea>
            <p class="note">
			<?php _e('Write/Paste the codes which you want to insert in Header.','sampression'); ?> 
			<?php _e('This will be inserted before the  &#060;/head&#062; tag in the header of the document.','sampression'); ?>
			</p>
        </fieldset>
        <fieldset class="fieldset-1">
        	<legend><?php _e('Custom code to insert into Footer','sampression'); ?></legend>
            <textarea name="sam_footer" class="text-area" rows="10" cols="100"><?php echo stripslashes(get_option('opt_sam_footer')); ?></textarea>
			<p class="note">
			<?php _e('Write/Paste the codes which you want to insert in Footer. For eg. custom styles, scripts, etc.','sampression'); ?>
			<?php _e('This will be inserted before the  &#060;/body&#062; tag in the footer of the document.','sampression'); ?>
			</p>
        </fieldset>
        <input class="button-primary" type="button" onclick="load_theme_action('submit')" value="Save" />
        </div>
        <!-- Tab: Get Support -->
        <div style="display: none;" id="tab4" class="tab_content">
        <h2><?php _e('Any comments/feedback/questions?','sampression'); ?></h2>
        <div class="note support-note">
        <p><?php _e('Get support from Sampression Support Team!','sampression'); ?></p>
        </div>
        <!-- .support-note -->
			<ul class="admin-style-1 support-form">
                <li class="group">
                    <label for="fullname"><?php _e('Name','sampression'); ?></label>
                    <input type="text" name="fullname" id="fullname" class="input-text" />
                </li>
                <li class="group">
                    <label for="emailadd"><?php _e('Email','sampression'); ?></label>
                    <input type="text" name="emailadd" id="emailadd" class="input-text" />
                </li>
                <li class="group">
                    <label for="emailsubj"><?php _e('Subject','sampression'); ?></label>
                    <input type="text" name="emailsubj" id="emailsubj" class="input-text" />
                </li>
                <li class="group">
                    <label for="emailmsg"><?php _e('Message','sampression'); ?></label>
                    <textarea cols="100" rows="10" id="emailmsg" name="emailmsg" class="text-area"></textarea>
                </li>
                <li class="group">
                <input type="hidden" name="userip" value="<?php echo sampression_get_ip(); ?>" />
                	<input class="button-primary btn-send-support" type="button" onclick="load_theme_action('support')" value="<?php _e('Send Message','sampression'); ?>" />
                    <span id="support_error_msg"></span>
                </li>
            </ul>
        </div>
        </div>
    </form>
    </div>
    <?php
}
?>