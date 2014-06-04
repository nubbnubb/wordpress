<?php 
/**
 * @package Expound
 */
$featured_posts = expound_get_featured_posts();
?>
<?php if ( $featured_posts->have_posts() ) : // more than one? ?>
<div class="featured-content-secondary">
	<?php while ( $featured_posts->have_posts() ) : $featured_posts->the_post(); ?>

		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

			<?php if ( has_post_thumbnail() ) : ?>
			<div class="entry-thumbnail">
				<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail(); ?></a>

			</div>
			<?php endif; ?>

			<header class="entry-header">
				<h1 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permanent lenke til %s', 'expound' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h1>
			</header><!-- .entry-header -->

			<div class="entry-summary">
				<?php the_excerpt(); ?>
			</div><!-- .entry-summary -->
		</article>

		<?php if ( $featured_posts->current_post % 4 == 3 ) : ?>
			<div class="clear"></div>
		<?php endif; // % 4 ?>

	<?php endwhile; ?>
</div><!-- .featured-content-secondary -->
<?php endif; // have_posts() inner ?>
