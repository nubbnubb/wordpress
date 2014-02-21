<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything untill Primary Navigation
 *
 * @package Sampression-Lite
 * @since Sampression Lite 1.0
 */
?>
<!doctype html>
<!--[if IE 6 ]> <html <?php language_attributes(); ?> class="no-js ie6"> <![endif]-->
<!--[if IE 7 ]> <html <?php language_attributes(); ?> class="no-js ie7"> <![endif]-->
<!--[if IE 8 ]> <html <?php language_attributes(); ?> class="no-js ie8"> <![endif]-->
<!--[if IE 9 ]> <html <?php language_attributes(); ?> class="no-js ie9"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--><html <?php language_attributes(); ?> class="no-js"> <!--<![endif]-->
<head>
	<?php		
		/** sampression hooks **/
		// Metas
		do_action( 'sampression_meta' );
		// Title
		do_action( 'sampression_title' );
		// Favicons
		do_action( 'sampression_favicon' );
		// CSS
		do_action( 'sampression_styles' );
		// Custom header styles
		do_action('sampression_custom_header_style');
		// Links
		do_action( 'sampression_links' );
		
		wp_head();
	?>

	
</head>

<body <?php body_class('top'); ?>>
<header id="header">
  <div class="container">
    <div class="columns nine">
	
			<?php 
				if(!get_option('opt_sam_use_logo') || get_option('opt_sam_use_logo') == 'no') { 
						do_action('sampression_logo');
				} 
			?>
			
			<div class="logo-txt">
			  <h1 class="site-title" id="site-title">
			  <a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
			  <?php bloginfo( 'name' ); ?>
			  </a>
			  </h1>
			  <h2 id="site-description" class="site-description"><?php bloginfo( 'description' ); ?></h2>
			</div>
    </div>
    <div class="columns seven">
      <nav id="top-nav">
        <?php
		//Check if the Custom Navigation is available
		if ( has_nav_menu('top-menu') ) {
			wp_nav_menu( array (
				'theme_location'    => 'top-menu',
				'container'         => '',
				'menu_class'        => 'top-menu clearfix',
				'depth'             => 0, // set to 1 to disable dropdowns
				'fallback_cb'       => false
			));
		} else {
		// Otherwise list the Pages
			 ?>
			<ul class="top-menu clearfix">
				<?php wp_list_pages('title_li=&depth=0'); ?>
			</ul>
			<?php
		} ?>
      </nav>
	  <div id="top-nav-mobile">
		
			<?php	/* $args = array(
							'depth'            => 0,
							'child_of'         => 0,
							'selected'         => 0,
							'echo'             => 1,
							'name'             => 'page_id'); 
							
						 wp_dropdown_pages( $args ); */ 
			?>
				
	  </div> 
      <!-- #top-nav -->
      <div id="interaction-sec" class="clearfix <?php echo getnoofclass(); ?>">
        
     
       <ul class="sm-top">
       <?php // Being Social 
	   //Facebook
	    if( get_option( 'opt_get_facebook' ) !=''){ ?>
          <li class="sm-top-fb"><a href="<?php echo stripslashes(get_option( 'opt_get_facebook' )); ?>" target="_blank">Facebook</a></li>
       <?php }
		// Twitter
	   if( get_option( 'opt_get_twitter' ) !='') {
	    ?>
          <li class="sm-top-tw"><a href="<?php echo stripslashes(get_option( 'opt_get_twitter') ); ?>" target="_blank">Twitter</a></li>
         <?php }
		// Google plus 
	   if( get_option( 'opt_get_gplus' ) !='') {
	    ?>
          <li class="sm-top-gplus"><a href="<?php echo stripslashes(get_option( 'opt_get_gplus') ); ?>" target="_blank">Google Plus</a></li>
          <?php } 
		// Youtube
		if( get_option( 'opt_get_youtube' ) !='' ) {
	    ?>
          <li class="sm-top-youtube"><a href="<?php echo stripslashes(get_option( 'opt_get_youtube') ); ?>" target="_blank">YouTube</a></li>
          <?php } ?> 
       </ul>
        <!-- .sm-top --> 
      </div>
      <!-- #interaction-sec -->
    </div>
	<?php $header_image = get_header_image();
		if ( ! empty( $header_image ) ) : ?>
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><img src="<?php echo esc_url( $header_image ); ?>" class="header-image" width="<?php echo get_custom_header()->width; ?>" height="<?php echo get_custom_header()->height; ?>" alt="" /></a>
		<?php endif; ?>
  </div>
</header>
<!-- #header -->
<!-- Filter the Post by Category: We are using Isotop (http://isotope.metafizzy.co/) for Filtering: An exquisite jQuery plugin for magical layouts -->
<?php if(is_home()): ?>
<span id="primary-nav-scroll"></span>
<nav id="primary-nav">
  <div class="container">
  <a href="#" id="btn-nav-opt">show/hide</a>
  <div class="columns sixteen">
    <div class="nav-label"><?php _e('Filter By:','sampression'); ?></div>
	
    <ul class="nav-listing clearfix">
        <li><a href="#" data-filter="*" class="selected"><span></span><?php _e('Show All','sampression'); ?></a></li>
        <?php
		/*to exclude some categories */ 
		$args = array();
		/* $args = array(
		'exclude'=>  array( get_cat_ID('aciform'), get_cat_ID('alignment'), get_cat_ID('antiquarianism'))  // exclude by category slug
		'exclude'=>  array( 1, 2, 3) //exclude by category id
		); */
		$categories = get_categories($args);
		
        $categories = get_categories();
        foreach($categories as $category):
        ?>
        <li><a href="javascript:void(0);" data-filter=".<?php echo $category->slug; ?>" id="<?php echo $category->slug; ?>" class="filter-data"><span></span><?php echo $category->name; ?></a></li>
        <?php
        endforeach;
        ?>
    </ul>
    
    <!-- Check Viewport: If the normal design couldn't fit with viewport, the Categories will appear via CSS with Select Menu form -->
    <select name="get-cats" id="get-cats">
        <option value="*">Show all</option>
        <?php
        foreach($categories as $category):
        ?>
        <option value=".<?php echo $category->slug; ?>"><?php echo $category->name; ?></option>
        <?php
        endforeach;
        ?>
    </select>
    
    </div>
  </div>
</nav>
<!-- #primary-nav -->
<?php endif; ?>
<div id="content-wrapper">
<div class="container">