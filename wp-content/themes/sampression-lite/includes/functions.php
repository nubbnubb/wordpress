<?php

// Exit if accessed directly
if ( !defined('ABSPATH')) exit;

/**
 * Sampression Lite functions and definitions
 *
 * Sets up the theme and provides some helper functions. Some helper functions
 * are used in the theme as custom template tags. Others are attached to action and
 * filter hooks in WordPress to change core functionality.
 *
 * The first function, sampression_setup(), sets up the theme by registering support
 * for various features in WordPress, such as post thumbnails, navigation menus, and the like.
 *
 * @package Sampression-Lite
 * @since Sampression Lite 1.0
 */

/*=======================================================================
 * Fire up the engines to start theme setup.
 *=======================================================================*/

add_action('after_setup_theme', 'sampression_setup');

if (!function_exists('sampression_setup')):

    function sampression_setup() {

        global $content_width;

        /**
         * Global content width.
         */
        if (!isset($content_width))
            $content_width = 650;
        /**
         * Sampression is now available for translations.
         */
		load_theme_textdomain('sampression', get_template_directory() . '/languages');
				
        /**
         * Add callback for custom TinyMCE editor stylesheets. (editor-style.css)
         * @see http://codex.wordpress.org/Function_Reference/add_editor_style
         */
        add_editor_style();

        /**
         * This feature enables post and comment RSS feed links to head.
         * @see http://codex.wordpress.org/Function_Reference/add_theme_support#Feed_Links
         */
        add_theme_support('automatic-feed-links');

        /**
         * This feature enables post-thumbnail support for a theme.
         * @see http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
         */
        add_theme_support('post-thumbnails');
		// Custom image sizes
		add_image_size( 'featured', 700, 400, true); // Set the size of Featured Image
		add_image_size( 'featured-thumbnail', 220); // Set the size of Featured Image Thumbnail
		
		/**
		 * This feature enables custom background color and image support for a theme
		 */
		add_theme_support( 'custom-background', array(
			'default-color' => '',
		) );
		
		/**
		 * This feature enables custom header color and image support for a theme
		 */
		add_theme_support( 'custom-header', array(
			// Text color and image (empty to use none).
			'default-text-color'     => 'FE6E41',
			'default-image'          => '',

			// Set height and width, with a maximum value for the width.
			'height'                 => 152,
			'width'                  => 960,
			'max-width'              => 2000,

			// Support flexible height and width.
			'flex-height'            => true,
			'flex-width'             => true
		) ); 
		
		/**
		 * remove wordpress version from header 
		 */
		remove_action( 'wp_head', 'wp_generator' );
		
        /**
         * This feature enables custom-menus support for a theme.
         * @see http://codex.wordpress.org/Function_Reference/register_nav_menus
         */	
        register_nav_menus(array(
			'top-menu'         => __('Top Menu', 'sampression')
		    )
	    );

    }

endif;

/*=======================================================================
 * Shows footer credits
 *=======================================================================*/
function sampression_footer() {
?>

<div class="alignleft powered-wp">
<?php _e('Proudly powered by:', 'sampression'); ?> <a href="<?php echo esc_url( __( 'http://wordpress.org/', 'sampression' ) ); ?>" title="<?php esc_attr_e( 'WordPress', 'sampression' ); ?>" target="_blank" ><?php _e( 'WordPress', 'sampression' ); ?></a>
</div>

<div class="alignright credit">
	<?php _e( 'Theme by:', 'sampression');?> <a href="<?php echo esc_url( __( 'http://sampression.com/', 'sampression' ) ); ?>" target="_blank" title="<?php esc_attr_e( 'Sampression', 'sampression' ); ?>"><?php _e( 'Sampression', 'sampression' ); ?></a>
</div>
<?php
}
add_filter( 'sampression_credits', 'sampression_footer' );

/*=======================================================================
 * A safe way of adding JavaScripts to a WordPress generated page.
 *=======================================================================*/
if (!is_admin())
	add_action('wp_enqueue_scripts', 'sampression_js');
	

if (!function_exists('sampression_js')) {

	function sampression_js() {
		wp_enqueue_script("jquery");
		// JS at the bottom for fast page loading. 
		wp_enqueue_script('sampression-modernizer', get_template_directory_uri() . '/lib/js/modernizr.js', array('jquery'), '2.6.1', false);
		wp_enqueue_script('sampression-jquery-isotope', get_template_directory_uri() . '/lib/js/jquery.isotope.min.js', array('jquery'), '1.5.19', true);
		wp_enqueue_script('sampression-custom-script', get_template_directory_uri() . '/lib/js/scripts.js', array('jquery'), '1.1', true);
	}

}

/*=======================================================================
 * Comment Reply
 *=======================================================================*/
function sampression_enqueue_comment_reply() {
if ( is_singular() && comments_open() && get_option('thread_comments')) { 
		wp_enqueue_script('comment-reply'); 
	}
}
add_action( 'wp_enqueue_scripts', 'sampression_enqueue_comment_reply' );

/*=======================================================================
 * Remove rel attribute from the category list
 *=======================================================================*/
function sampression_remove_category_list_rel($output)
{
  $output = str_replace(' rel="category"', '', $output);
  return $output;
}
add_filter('wp_list_categories', 'sampression_remove_category_list_rel');
add_filter('the_category', 'sampression_remove_category_list_rel');


/*=======================================================================
 * Display navigation to next/previous pages when applicable
 *=======================================================================*/

if ( ! function_exists( 'sampression_content_nav' ) ) :

function sampression_content_nav( $nav_id ) {
	global $wp_query;
	if ( $wp_query->max_num_pages > 1 ) : ?>
		<nav id="<?php echo $nav_id; ?>" class="post-navigation clearfix">
        	<?php
			// Enable the Page Navigation features for wp-pagenavi plugin
			if(function_exists('wp_pagenavi')) {
				wp_pagenavi();
			} else {
			?>
                <div class="nav-previous alignleft"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'sampression' ) ); ?></div>
                <div class="nav-next alignright"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'sampression' ) ); ?></div>
            <?php
			}
			?>
		</nav>
	<?php endif;
}
endif; 


/*=======================================================================
 * Filter 'get_comments_number'
 * 
 * Filter 'get_comments_number' to display correct 
 * number of comments (count only comments, not 
 * trackbacks/pingbacks)
 *
 * Courtesy of Chip Bennett
 *=======================================================================*/
function sampression_comment_count( $count ) {  
	if ( ! is_admin() ) {
		global $id;
		$comments_by_type = &separate_comments(get_comments('status=approve&post_id=' . $id));
		return count($comments_by_type['comment']);
	} else {
		return $count;
	}
}
add_filter('get_comments_number', 'sampression_comment_count', 0);

/**
 * wp_list_comments() Pings Callback
 * 
 * wp_list_comments() Callback function for 
 * Pings (Trackbacks/Pingbacks)
 */
function sampression_comment_list_pings( $comment ) {
	$GLOBALS['comment'] = $comment;
?>
	 <li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>"><?php echo comment_author_link(); ?></li>
<?php }


/*=======================================================================
 * Sets the post excerpt length to 40 characters.
 * Next few lines are adopted from Coraline
 *=======================================================================*/
function sampression_excerpt_length($length) {
    return 40;
}

add_filter('excerpt_length', 'sampression_excerpt_length');

/**
 * Returns a "Read more" link for excerpts
 */
function sampression_read_more() {
    return ' <span class="read-more"><a href="' . get_permalink() . '">' . __('Read more &#8250;', 'sampression') . '</a></span>';
}
/**
 * Replaces "[...]" (appended to automatically generated excerpts) with an ellipsis and sampression_read_more_link().
 */
function sampression_auto_excerpt_more($more) {
    return '<span class="ellipsis">&hellip;</span>' . sampression_read_more();
}
add_filter('excerpt_more', 'sampression_auto_excerpt_more');

/**
 * Adds a pretty "Read more" link to custom post excerpts.
 */
function sampression_custom_excerpt_more($output) {
    if (has_excerpt() && !is_attachment()) {
        $output .= sampression_read_more();
    }
    return $output;
}

add_filter('get_the_excerpt', 'sampression_custom_excerpt_more');

/*=======================================================================
 * Get Category Slugs
 *=======================================================================*/
function sampression_cat_slug() {
    $cats = array();
	foreach((get_the_category()) as $category) { 
		$cats[] = $category->slug;
	} 
	$slug = implode(' ', $cats);
	return $slug;
}

/*=======================================================================
 * Run function during a themes initialization. It clear all widgets
 *=======================================================================*/
add_action( 'setup_theme', 'sampression_widget_reset' );
function sampression_widget_reset() {
    if(isset( $_GET['activated'] )) {
        add_filter( 'sidebars_widgets', 'disable_all_widgets' );
        function disable_all_widgets( $sidebars_widgets ) {
            $sidebars_widgets = array( false );
            return $sidebars_widgets;    
        }
    }
}

/*=======================================================================
 * WordPress Widgets start right here.
 *=======================================================================*/
 
 function sampression_widgets_init() {
	
	register_sidebar(array(
		'name' => __('Bottom Widget 1', 'sampression'),
		'description' => __('Appears on bottom of the Page - First Widget - Please insert only one widget for better appearance.', 'sampression'),
		'id' => 'bottom-widget-1',
		'before_title' => '<header class="widget-title">',
		'after_title' => '</header>',
		'before_widget' => '<section id="%1$s" class="column one-third widget %2$s">',
		'after_widget' => '</section>'
	));
	
	register_sidebar(array(
		'name' => __('Bottom Widget 2', 'sampression'),
		'description' => __('Appears on bottom of the Page - Second Widget - Please insert only one widget for better appearance.', 'sampression'),
		'id' => 'bottom-widget-2',
		'before_title' => '<header class="widget-title">',
		'after_title' => '</header>',
		'before_widget' => '<section id="%1$s" class="column one-third widget %2$s">',
		'after_widget' => '</section>'
	));
	
	register_sidebar(array(
		'name' => __('Bottom Widget 3', 'sampression'),
		'description' => __('Appears on bottom of the Page - Third Widget - Please insert only one widget for better appearance.', 'sampression'),
		'id' => 'bottom-widget-3',
		'before_title' => '<header class="widget-title">',
		'after_title' => '</header>',
		'before_widget' => '<section id="%1$s" class="column one-third widget %2$s">',
		'after_widget' => '</section>'
	));
	
	register_sidebar(array(
		'name' => __('Inner Sidebar', 'sampression'),
		'description' => __('Appears on right of the Interior Pages - Can use as much widgets as you wish.', 'sampression'),
		'id' => 'right-sidebar',
		'before_title' => '<header class="widget-title">',
		'after_title' => '</header><div class="widget-entry">',
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget' => '</div></section>'
	));
}
add_action('widgets_init', 'sampression_widgets_init'); 

function sampression_default_widgets() {
	 $sidebars_widgets = get_option( 'sidebars_widgets' );
	 if(!get_option('samp_auto_widget_installed',false)){
		 
		if( empty($sidebars_widgets['bottom-widget-3']) ){	//if there are no widgets on the 'bottom-widget-3'
		 
				$id = count( $sidebars_widgets ) + 1;
				$sidebars_widgets['bottom-widget-3'] = array( "text-" . $id );

				$ops = get_option( 'widget_text' );
				$ops[$id] = array(
					'title' => 'About me automatic widget',
					'text' => 'This is an automatic widget added on Third Bottom Widget box (Bottom Widget 3). To edit please go to Appearance > Widgets and choose 3rd widget from the top in area second called Bottom Widget 3. Title is also manageable from widgets as well.', 
				);
				update_option( 'widget_text', $ops ); 
				update_option( 'sidebars_widgets', $sidebars_widgets );	
		}
		update_option('samp_auto_widget_installed', true);
		
	 } 
}
add_action('widgets_init', 'sampression_default_widgets', 11);

/*=======================================================================
 * Template for comments and pingbacks.
 *
 * To override this walker in a child theme without modifying the comments template
 * simply create your own sampression_comment(), and that function will be used instead.
 *
 * Used as a callback by wp_list_comments() for displaying the comments.
 *
 * @since Twenty Eleven 1.0
 *=======================================================================*/

if ( ! function_exists( 'sampression_comment' ) ) :

function sampression_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case 'pingback' :
		case 'trackback' :
	?>
	<li class="post pingback">
		<p><?php _e( 'Pingback:', 'sampression' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __( 'Edit','sampression' ), '<span class="edit-link">', '</span>' ); ?></p>
	<?php
			break;
		default :
	?>
	<li <?php comment_class('clearfix'); ?> id="li-comment-<?php comment_ID(); ?>">
		<article id="comment-<?php comment_ID(); ?>" class="comment">
        <div class="avatar-wrapper">
        <span class="pointer"></span>
        <div class="avatar">
		<?php // Get Avatar
        $avatar_size = 80;
        if ( '0' != $comment->comment_parent )
            $avatar_size = 80;
        
        echo get_avatar( $comment, $avatar_size );
        ?>
        </div>
        <!-- .avatar -->
        </div>
        <!-- .col-2 -->
        <div class="comment-wrapper">
        <div class="comment-entry">
			<header class="comment-meta clearfix">
				<div class="comment-author">
					<?php
					
						/* translators: 1: comment author, 2: date and time */
						printf( __( '%1$s on %2$s', 'sampression' ),
							sprintf( '<span class="fn">%s</span>', get_comment_author_link()),
							sprintf( '<a href="%1$s"><time pubdate datetime="%2$s">%3$s</time></a>',
								esc_url( get_comment_link( $comment->comment_ID ) ),
								get_comment_time( 'c' ),
								/* translators: 1: date, 2: time */
								sprintf( __( '<span class="date-details">%1$s</span>' ), get_comment_date(), get_comment_time() )
							)
						);
					?>

					<?php edit_comment_link( __( 'Edit', 'sampression' ), '<span class="edit-link">', '</span>' ); ?>
				</div><!-- .comment-author  -->
                
                <div class="reply">
				<?php comment_reply_link( array_merge( $args, array( 'reply_text' => __( 'Reply <span>&darr;</span>', 'sampression' ), 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
			</div><!-- .reply -->

				

			</header>
            
            <?php if ( $comment->comment_approved == '0' ) : ?>
					<div class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'sampression' ); ?></div>
			<?php endif; ?>
            
            

			<div class="comment-content"><?php comment_text(); ?></div>
            </div>
            </div>
            <!-- .col-2 -->

			
		</article><!-- #comment-## -->

	<?php
			break;
	endswitch;
}
endif; // ends check for sampression_comment()

/*=======================================================================
 * Function to get favicon and different sizes of apple touch icons
 *=======================================================================*/
 
function sampression_favicon() {

	//apple touch icon 16x16
	if(!get_option('opt_sam_use_favicon16x16') || trim(get_option('opt_sam_use_favicon16x16')) == 'no') {
		if(get_option('opt_sam_favicons')) { 
		?>
			<link rel="shortcut icon" href="<?php echo get_option('opt_sam_favicons'); ?>">
		<?php
		}
	}
	
	//apple touch icon 57x57
	if(!get_option('opt_sam_use_appletouch57x57') || trim(get_option('opt_sam_use_appletouch57x57')) == 'no') {
		if(get_option('opt_sam_apple_icons_57')) {
		?>
			<link rel="apple-touch-icon" sizes="57x57" href="<?php echo get_option('opt_sam_apple_icons_57'); ?>">
		<?php
		} 
	}
	
	//apple touch icon 72x72
	if(!get_option('opt_sam_use_appletouch72x72') || trim(get_option('opt_sam_use_appletouch72x72')) == 'no') {
		if(get_option('opt_sam_apple_icons_72')) {
		?>
			<link rel="apple-touch-icon" sizes="72x72" href="<?php echo get_option('opt_sam_apple_icons_72'); ?>">
		<?php
		} 
	}
	
	//apple touch icon 114x114
	if(!get_option('opt_sam_use_appletouch114x114') || trim(get_option('opt_sam_use_appletouch114x114')) == 'no') {	
		if(get_option('opt_sam_apple_icons_114')) {
		?>
			
			<link rel="apple-touch-icon" sizes="114x114" href="<?php echo get_option('opt_sam_apple_icons_114'); ?>">
		<?php
		}
	}
	
	// apple touch icon 144x144
	if(!get_option('opt_sam_use_appletouch144x144') || trim(get_option('opt_sam_use_appletouch144x144')) == 'no') {	
		if(get_option('opt_sam_apple_icons_144')) {
		?>
			
			<link rel="apple-touch-icon" sizes="144x144" href="<?php echo get_option('opt_sam_apple_icons_144'); ?>">
		<?php
		}
	}
}
/*=======================================================================
 * Function to get default logo by Sampression theme
 *=======================================================================*/
add_action('sampression_logo', 'sampression_show_logo');
function sampression_show_logo() {
	if(get_option('opt_sam_logo')) {
	?>
		<a href="<?php echo home_url( '/' ); ?>" title="<?php echo esc_attr( ucwords(get_bloginfo( 'name', 'display' )) ); ?>" rel="home" id="logo-area">
			<img class="logo-img" src="<?php echo get_option('opt_sam_logo'); ?>" alt="<?php bloginfo('name'); ?>">
		</a>
    <?php
	}
}


/*=======================================================================
* embed the javascript file that makes the AJAX request to filter category in Primary Navigation
*=======================================================================*/

if (!is_admin())
	add_action('wp_enqueue_scripts', 'sampression_ajax');
	

if (!function_exists('sampression_ajax')) {

	function sampression_ajax() {
		wp_enqueue_script("jquery");
		
		 wp_enqueue_script( 'my-ajax-request', get_template_directory_uri() . '/lib/js/load_content.js', '' , '1.1', true );
		 wp_localize_script( 'my-ajax-request', 'MyAjax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );
	}

}

/*=======================================================================
* declare the URL to the file that handles the AJAX request (wp-admin/admin-ajax.php)
*=======================================================================*/

add_action( 'wp_ajax_nopriv_filter-cat-data', 'sampression_filter_cat_callback' );
add_action( 'wp_ajax_filter-cat-data', 'sampression_filter_cat_callback' );
 
function sampression_filter_cat_callback() {
   $slug = $_POST['category'];
   $exc = $_POST['exclude'];
   $exclude = explode('~', $exc);
   query_posts(array ( 'category_name' => $slug, 'post__not_in' => $exclude, 'post_status' => 'publish' ) );
   while (have_posts()) : the_post();
   ?>
   <article id="post-<?php the_ID(); ?>" class="post item columns four <?php echo sampression_cat_slug(); ?> ">
      <h3 class="post-title"><a href="<?php the_permalink() ?>" title="<?php echo esc_attr( get_the_title() ); ?>" rel="bookmark" ><?php the_title(); ?></a></h3>
      
      <?php if ( has_post_thumbnail() ) { ?>
        <div class="featured-img">
        <a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( the_title_attribute( 'echo=0' ) ); ?>" ><?php the_post_thumbnail( 'large' ); ?></a>
        </div>
		<!-- .featured-img -->
      <?php } ?>
      
      <div class="entry">
        <?php the_excerpt(); ?>
      </div>
      <!-- .entry -->

      <div class="meta clearfix">
			<?php 
                printf( __( '%3$s <time class="col" datetime="2011-09-28"><span class="ico">Published on</span>%2$s</time> ', 'sampression' ),'meta-prep meta-prep-author',
					sprintf( '<a href="%1$s" title="%2$s" rel="bookmark">%3$s</a>',
						get_permalink(),
						esc_attr( get_the_time() ),
						get_the_date('d M Y')
					),
					sprintf( '<div class="post-author col"><span class="ico hello">Author</span><a class="url fn n" href="%1$s" title="%2$s">%3$s</a></div>',
						get_author_posts_url( get_the_author_meta( 'ID' ) ),
					sprintf( esc_attr__( 'View all posts by %s', 'sampression' ), get_the_author() ),
						get_the_author()
						)
                );
            ?>

			<?php if ( comments_open() ) : ?>
            <span class="col count-comment">
            <span class="pointer"></span>
            <?php comments_popup_link(__('0', 'sampression'), __('1', 'sampression'), __('%', 'sampression')); ?>
            </span>
            <?php endif; ?>
        
        
      </div>
      <div class="meta">
        <div class="cats"><?php printf(__('<span class="ico">Categories</span><div class="overflow-hidden cat-listing">%s</div>', 'sampression'), get_the_category_list(', ')); ?></div>
      </div>
    </article>
	<?php
	endwhile;
	wp_reset_query();
	die();
}

/*=======================================================================
* Get an IP of USER
*=======================================================================*/

function sampression_get_ip() {
	if (getenv('HTTP_CLIENT_IP')) {
		$ip = getenv('HTTP_CLIENT_IP');
	}
	elseif (getenv('HTTP_X_FORWARDED_FOR')) {
		$ip = getenv('HTTP_X_FORWARDED_FOR');
	}
	elseif (getenv('HTTP_X_FORWARDED')) {
		$ip = getenv('HTTP_X_FORWARDED');
	}
	elseif (getenv('HTTP_FORWARDED_FOR')) {
		$ip = getenv('HTTP_FORWARDED_FOR');
	}
	elseif (getenv('HTTP_FORWARDED')) {
		$ip = getenv('HTTP_FORWARDED');
	}
	else {
		$ip = $_SERVER['REMOTE_ADDR'];
	}
	return $ip;
}

/*=======================================================================
* Display notification/message in admin.
*=======================================================================*/
function sampression_showMessage($message='', $errormsg = false) {
	if($message!='') {
		if ($errormsg) {
			echo '<div id="message" class="error">';
		} else {
			echo '<div id="message" class="updated fade">';
		}
		echo "<p><strong>$message</strong></p></div>";
	}
}
function sampression_showNotices() {
    if(function_exists('showMessage')) {
		showMessage();
	}
}
add_action('admin_notices', 'sampression_showNotices');

function sampression_check($opt_field){
	$use_logo = get_option($opt_field);
		if($use_logo == 'yes') 
			return ' checked="checked" ';
}

/* function to echo number of class  depending on number of social media link set */
function getnoofclass(){
		$noofclass=0;
		$class = 'socialzero';
		 if( get_option( 'opt_get_facebook' ) !=''){ $noofclass++; }
		 if( get_option( 'opt_get_twitter' ) !=''){ $noofclass++; }
		 if( get_option( 'opt_get_gplus' ) !=''){ $noofclass++; }
		 if( get_option( 'opt_get_youtube' ) !=''){ $noofclass++; }
		 switch($noofclass){
			case 1: $class='socialone'; break;
			case 2: $class='socialtwo'; break;
			case 3: $class='socialthree'; break;
			case 4: $class='socialfour'; break;
		 }
		return $class;
	  }
/**
 * Add meta tags.
 */ 
add_action( 'sampression_meta', 'sampression_add_meta' );

function sampression_add_meta() {
	?>
	<!-- Charset -->
	<meta charset="<?php bloginfo('charset'); ?>">
	<!-- Mobile Specific Metas  -->
	<meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
	<!-- <meta name="viewport" content="width=1024" />-->
	<?php
}

/**
 * Add google fonts, pingback url, etc.
 */ 
add_action( 'sampression_links', 'sampression_add_links' );

function sampression_add_links() {
	?>
	<!-- Google Fonts -->
    <link href='http://fonts.googleapis.com/css?family=Droid+Serif:700,400,400italic,700italic' rel='stylesheet' type='text/css'>
	<!-- Pingback Url -->
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
	<?php
}
/**
 * Displays title. @uses wp_title() 
 */
add_action( 'sampression_title', 'sampression_title' );

function sampression_title() {
	?>
	<title>
		<?php wp_title( '|', true, 'right' ); ?>
	</title>
	<?php
}

add_filter( 'wp_title', 'sampression_filter_wp_title' );

function sampression_filter_wp_title() {
	
	// Print the <title> tag based on what is being viewed.
	global $page, $paged;
	
	// Add the blog name.
	 bloginfo( 'name' ); 

	// Add the blog description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) ){
		echo " | $site_description"; 
	}
}
add_action('sampression_favicon','sampression_favicon');

add_action( 'wp_enqueue_scripts', 'sampression_enqueue_styles' );

function sampression_enqueue_styles(){
	global $wp_styles;
    // other style sheets...
	wp_enqueue_style('sampression-style', get_stylesheet_uri(), false, '1.4');
	wp_enqueue_style('fontello', get_template_directory_uri() . '/lib/css/fontello.css', false, false, 'screen');
    // ie-specific style sheets
    wp_register_style('ie7-only', get_template_directory_uri() . '/lib/css/fontello-ie7.css');
    $wp_styles->add_data('ie7-only', 'conditional', 'IE 7');
    wp_enqueue_style('ie7-only');
}

add_action('sampression_custom_header_style','sampression_custom_header_style');

function sampression_custom_header_style() {
	$text_color = get_header_textcolor();
	// If no custom options for text are set, do nothing
	if ( $text_color == get_theme_support( 'custom-header', 'default-text-color' ) )
		return;
	// Else, we have custom styles.
	?>
	<style type="text/css">
		<?php	// Is the text hidden?
			if ( ! display_header_text() ) :
		?>
			.site-title,
			.site-description {
				position: absolute !important;
				clip: rect(1px 1px 1px 1px); /* IE7 */
				clip: rect(1px, 1px, 1px, 1px);
			}
		<?php	// If the user has set a custom color for the text, lets use that.
			else : 
		?>
			.site-title a,
			.site-description {
				color: #<?php echo $text_color; ?> !important;
			}
		<?php endif; ?>
	</style>
	<?php
}

add_action('sampression_footer', 'sampression_enqueue_conditional_scripts');

function sampression_enqueue_conditional_scripts(){
	?>
	<!-- Enables advanced css selectors in IE, must be used with a JavaScript library (jQuery Enabled in functions.php) -->
	<!--[if lt IE 9]>
		<script src="<?php echo get_template_directory_uri(); ?>/lib/js/selectivizr.js"></script>
	<![endif]-->
	<!--[if lt IE 7 ]>
		<script src="//ajax.googleapis.com/ajax/libs/chrome-frame/1.0.3/CFInstall.min.js"></script>
		<script>window.attachEvent("onload",function(){CFInstall.check({mode:"overlay"})})</script>
	<![endif]-->
	<?php
}
?>