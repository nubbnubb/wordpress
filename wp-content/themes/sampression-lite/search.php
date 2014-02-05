<?php
// Exit if accessed directly
if ( !defined('ABSPATH')) exit;

/**
 * The template for displaying Search Results pages.
 *
 * @package Sampression-Lite
 * @since Sampression Lite 1.0
 */
 
get_header(); ?>

<section id="content" class="clearfix">
  <?php if (have_posts()) : ?>

<header class="page-header columns sixteen">
    <h2 class="page-title quick-note search-title"><?php
        printf( __( 'Search Results for: %s', 'sampression' ), '<span>' . get_search_query() . '</span>' ); ?>
    </h2>
</header>

<div id="post-listing" class="clearfix">
  
   <?php
  	while (have_posts()) : the_post(); 
    get_template_part( 'loop', 'search' );
    endwhile;
	?>
    
</div>
<!-- #post-listing --> 
  <?php  else: ?>
    
    <article id="post-0" class="no-results not-found">
        <header class="entry-header">
            <h2 class="entry-title"><?php _e( 'Nothing Found For: ', 'sampression' ); echo '&quot;' . get_search_query() . '&quot;'; ?></h2>
        </header><!-- .entry-header -->
    
        <div class="entry-content">
            <p><?php _e( 'Apologies, but no results were found for the requested keyword. Please try another keywords..', 'sampression' ); ?></p>
            
        </div><!-- .entry-content -->
    </article><!-- #post-0 -->

<?php endif; ?>
  
</section>
<!-- #content -->
<?php get_sidebar(); ?>

<?php get_footer(); ?>