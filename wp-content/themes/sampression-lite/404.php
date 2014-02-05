<?php
// Exit if accessed directly
if ( !defined('ABSPATH')) exit;

/**
 * The template for displaying 404 pages (Not Found).
 *
 * @package Sampression-Lite
 * @since Sampression Lite 1.0
 */

get_header(); ?>

<section id="content" class="clearfix">
  <div class="columns twelve offset-by-two">
    <div id="page-not-found-message">
      <h2><?php _e('Oops! Page not found.','sampression'); ?></h2>
      <h3 class="separator"><?php _e('Sorry but the page you looking for cannot be found.','sampression'); ?></h3>
      <h3><?php _e('Better to go','sampression'); ?> <a href="<?php echo home_url( '/' ); ?>"><?php _e('home','sampression'); ?></a></h3>
    </div>
    <!-- #page-not-found-message  --> 
  </div>
</section>
<!-- #content -->

<?php get_footer(); ?>
