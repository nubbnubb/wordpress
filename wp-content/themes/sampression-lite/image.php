<?php
// Exit if accessed directly
if ( !defined('ABSPATH')) exit;

/**
 * The template for displaying image attachments.
 *
 * @package Sampression-Lite
 * @since Sampression Lite 1.1.1
 */
 
get_header(); ?>

<?php if (have_posts()) : ?>

 <nav id="nav-above" class="post-navigation clearfix columns twelve">
            <h3 class="assistive-text hidden"><?php _e( 'Post navigation', 'sampression' ); ?></h3>
            <div class="nav-previous alignleft"><?php previous_post_link( '%link', __( '<span class="meta-nav">&larr;</span> Back to Gallery', 'sampression' ) ); ?></div>
        </nav><!-- #nav-above -->

<section id="content" class="columns twelve" role="main">
			<?php while ( have_posts() ) : the_post(); ?>
				<article <?php post_class('post'); ?> id="post-<?php the_ID(); ?>">
                
                <header class="post-header">
					<h2 class="post-title"><a href="<?php echo get_permalink( $post->post_parent ); ?>" title="<?php esc_attr( printf( 'Return to %s', get_the_title( $post->post_parent ) ) ); ?>"><?php printf( '%s', get_the_title( $post->post_parent ) ); ?></a>: <span class="img-title"><?php the_title(); ?></span></h2>
				</header>
                
                <div class="meta clearfix">
            <?php 
                printf( __( '%3$s <time class="col" datetime="2011-09-28"><span class="ico">Published on</span>%2$s</time> ', 'sampression' ),'meta-prep meta-prep-author',
					sprintf( '<a href="%1$s" title="%2$s" rel="bookmark">%3$s</a>',
						get_permalink(),
						esc_attr( get_the_time() ),
						get_the_date()
					),
					sprintf( '<div class="post-author col"><span class="ico hello">Author</span><a class="url fn n" href="%1$s" title="%2$s">%3$s</a></div>',
						get_author_posts_url( get_the_author_meta( 'ID' ) ),
					sprintf( esc_attr__( 'View all posts by %s', 'sampression' ), get_the_author() ),
						get_the_author()
						)
                );
            ?>
            
            <div class="col cats"><?php printf(__('<span class="ico">Categories</span> %s', 'sampression'), get_the_category_list(', ')); ?></div>
            
            <div class="col count-comment">
			<?php if ( comments_open() ) : ?>
            <span class="pointer"></span>
            <?php comments_popup_link(__('0', 'sampression'), __('1', 'sampression'), __('%', 'sampression')); ?>
            <?php endif; ?>
        	</div>
            
			<?php if(has_tag()) {?>
                    <div class="tags col"><span class="ico">Tags</span><?php the_tags(' ', ', '); ?> </div>
            <?php } ?>
        
        <?php if(is_user_logged_in()){ ?>
      
      	<div class="edit col"><span class="ico">Edit</span> <?php edit_post_link( __( 'Edit', 'sampression' ) ); ?> </div>
      
	  <?php } ?>
            
            </div>
            <!-- .meta -->
            
            <div class="entry clearfix">
				<?php
                    /**
                     * Grab the IDs of all the image attachments in a gallery so we can get the URL of the next adjacent image in a gallery,
                     * or the first image (if we're looking at the last image in a gallery), or, in a gallery of one, just the link to that image file
                     */
                    $attachments = array_values( get_children( array( 'post_parent' => $post->post_parent, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => 'ASC', 'orderby' => 'menu_order ID' ) ) );
                    foreach ( $attachments as $k => $attachment ) {
                        if ( $attachment->ID == $post->ID )
                            break;
                    }
                    $k++;
                    // If there is more than 1 attachment in a gallery
                    if ( count( $attachments ) > 1 ) {
                        if ( isset( $attachments[ $k ] ) )
                            // get the URL of the next image attachment
                            $next_attachment_url = get_attachment_link( $attachments[ $k ]->ID );
                        else
                            // or get the URL of the first image attachment
                            $next_attachment_url = get_attachment_link( $attachments[ 0 ]->ID );
                    } else {
                        // or, if there's only 1 image, get the URL of the image
                        $next_attachment_url = wp_get_attachment_url();
                    }
                ?>
        <a href="<?php echo esc_url( $next_attachment_url ); ?>" title="<?php the_title_attribute(); ?>" rel="attachment"><?php
        $attachment_size = apply_filters( 'simplecatch_attachment_size', 848 );
        echo wp_get_attachment_image( $post->ID, array( $attachment_size, 1024 ) ); // filterable image width with 1024px limit for image height.
        ?></a>

        <?php if ( ! empty( $post->post_excerpt ) ) : ?>
        <div class="entry-caption">
            <?php the_excerpt(); ?>
        </div>
        <?php endif; ?>

	<div class="image-description">
    <?php the_content(); ?>
    <?php wp_link_pages(array( 
        'before'			=> '<div class="pagination">',
        'after' 			=> '</div>',
        'link_before' 		=> '<span>',
        'link_after'       	=> '</span>',
        'pagelink' 			=> '%',
        'echo' 				=> 1 
    ) );?>                            
	</div><!-- .image-description -->
                            
                            
    <nav id="nav-below" class="post-navigation clearfix">
        <div class="nav-previous alignleft"><?php previous_image_link( false, __( '<span class="meta-nav">&larr;</span> Previous Image', 'sampression' ) ); ?></div>
        <div class="nav-next alignright"><?php next_image_link( false, __( 'Next Image <span class="meta-nav">&rarr;</span>', 'sampression' ) ); ?></div>
    </nav><!-- #nav-above -->
                       
	</div>
<!-- .entry -->

</article><!-- .post -->

        <?php endwhile; ?>
      
        	<?php comments_template( '', true ); ?>
 
</section>
<?php endif; ?>
<?php get_sidebar('right'); ?>
<?php get_footer(); ?>