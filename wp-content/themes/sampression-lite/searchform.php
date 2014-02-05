<?php
// Exit if accessed directly
if ( !defined('ABSPATH')) exit;

/**
 * The template for displaying search forms
 *
 * @package Sampression-Lite
 * @since Sampression Lite 1.0
 */
?>
<form method="get" id="searchform" class="clearfix" action="<?php echo esc_url( home_url( '/' ) ); ?>">
    <label class="hidden" for="s"><?php _e( 'Search for:', 'sampression' ); ?></label>
    <input type="text" value="<?php the_search_query(); ?>" name="s" id="s" class="text-field" placeholder="<?php _e( 'search by keyword', 'sampression' ); ?>" />
    <input type="submit" id="searchsubmit" value="<?php _e( 'Search', 'sampression' ); ?>" />
</form>