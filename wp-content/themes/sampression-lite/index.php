<?php
// Exit if accessed directly
if ( !defined('ABSPATH')) exit;

/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package Sampression-Lite
 */

get_header(); ?>

<section id="content" class="clearfix">
	
  <?php if (have_posts()) : ?>
  <div id="post-listing" class="clearfix">
  
	<?php 
		// Show only one Sticky Post
	$sticky = get_option( 'sticky_posts' );
	$args = array(
		'posts_per_page' => 1,
		'post__in'  => $sticky,
		'ignore_sticky_posts' => 1
	);
	query_posts( $args );
	if ( count($sticky)>0 ) {
	while (have_posts()) : the_post();
		get_template_part( 'loop', 'index' ); 
	endwhile;
	}
	wp_reset_query();
	
	// Exclude Sticky Posts and show remaining normal posts
	$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
	query_posts( array(
		'post__not_in' => get_option( 'sticky_posts' ),
		'paged' => $paged
		) );
		
		while (have_posts()) : the_post();
		get_template_part( 'loop', 'index' );
	
		endwhile;
	
	?>

     </div>
  <!-- #post-listing --> 
  <?php
	  sampression_content_nav( 'nav-below' );
	  else:
	?>
    
    <article id="post-0" class="no-results not-found">
        <header class="entry-header">
            <h2 class="entry-title"><?php _e( 'Nothing Found', 'sampression' ); ?></h2>
        </header><!-- .entry-header -->
    
        <div class="entry-content">
            <p><?php _e( 'Apologies, but no results were found for the requested archive. Perhaps searching will help find a related post.', 'sampression' ); ?></p>
        </div><!-- .entry-content -->
    </article><!-- #post-0 -->

<?php endif; ?>

  
</section>
<!-- #content -->
<?php get_sidebar(); ?>

<?php get_footer(); ?>