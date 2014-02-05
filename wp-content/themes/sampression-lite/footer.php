<?php
/**
 * The template for displaying the footer.
 *
 * @package Sampression-Lite
 * @since Sampression Lite 1.0
 */
?>

 </div>
</div>
<!-- #content -->

<footer id="footer">
<div class="container">
<div class="columns fourteen">
<div class="alignleft copyright"><?php esc_attr_e( 'Copyright', 'sampression' ); ?> &copy; <?php _e(date('Y')); ?> "<?php bloginfo( 'name' ); ?>".</div><?php do_action( 'sampression_credits' ); ?>
</div>

<div class="columns two footer-right">
<div id="btn-top-wrapper">
<a href="javascript:pageScroll('.top');" class="btn-top"><?php _e('Goto Top', 'sampression'); ?></a>
</div>
</div>

</div>
</footer>

<?php 
	   	/** sampression_footer hook **/
	   	do_action( 'sampression_footer' );
	   ?>	
  
<?php wp_footer(); ?>
</body>
</html>