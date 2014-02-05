<?php
// Exit if accessed directly
if ( !defined('ABSPATH')) exit;

 /**
 * The Template for displaying all single posts.
 *
 * @package Sampression-Lite
 * @since Sampression Lite 1.0
 */
 
get_header(); ?>
	
	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
        
        <nav id="nav-above" class="post-navigation clearfix columns twelve">
            <h3 class="assistive-text hidden"><?php _e( 'Post navigation', 'sampression' ); ?></h3>
            <div class="nav-previous alignleft"><?php previous_post_link( '%link', __( '<span class="meta-nav">&larr;</span> Previous', 'sampression' ) ); ?></div>
            <div class="nav-next alignright"><?php next_post_link( '%link', __( 'Next <span class="meta-nav">&rarr;</span>', 'sampression' ) ); ?></div>
        </nav><!-- #nav-above -->
                    
        
        <section id="content" class="columns twelve" role="main">
		
		<article <?php post_class('post'); ?> id="post-<?php the_ID(); ?>">
			
		<?php if ( has_post_thumbnail() ) { ?>
            <div class="featured-img">
            	<?php the_post_thumbnail( 'featured' ); ?>
            </div>
            <!-- .featured-img -->
        <?php } ?>
            
            <header class="post-header">
				<h2 class="post-title"><?php the_title(); ?></h2>
			</header>
            
            <div class="meta clearfix">
            
				<div class="col count-comment">
				<?php if ( comments_open() ) : ?>
				<span class="pointer"></span>
				<?php comments_popup_link(__('0', 'sampression'), __('1', 'sampression'), __('%', 'sampression')); ?>
				<?php endif; ?>
				</div>
				<?php 
					printf( __( '%3$s <time class="" datetime="2011-09-28"><span class="ico">&nbsp;</span>%2$s</time> ', 'sampression' ),'meta-prep meta-prep-author',
						sprintf( '<a href="%4$s" title="%2$s" rel="bookmark">%3$s</a>',
							get_permalink(),
							esc_attr( get_the_time() ),
							get_the_date(),
							get_month_link( get_the_time('Y'), get_the_time('m'))
						),
						sprintf( '<div class="post-author"><span class="ico hello">&nbsp;</span><a class="url fn n" href="%1$s" title="%2$s">%3$s</a></div>',
							get_author_posts_url( get_the_author_meta( 'ID' ) ),
						sprintf( esc_attr__( 'View all posts by %s', 'sampression' ), get_the_author() ),
							get_the_author()
							)
					);
				?>
				
				<div class="cats"><?php printf(__('<span class="ico">&nbsp;</span> %s', 'sampression'), get_the_category_list(', ')); ?></div>
				
				<?php if(has_tag()) {?>
						<div class="tags"><span class="ico">&nbsp;</span><?php the_tags(' ', ', '); ?> </div>
				<?php } ?>
			
				<?php if(is_user_logged_in()){ ?>
			  
				<div class="edit"><span class="ico">&nbsp;</span> <?php edit_post_link( __( 'Edit', 'sampression' ) ); ?> </div>
			  
				<?php } ?>
            
            </div>
            <!-- .meta -->
            
            <div class="entry clearfix">
				<?php the_content(); ?>
                
                <?php wp_link_pages( array( 'before' => '<div class="page-link"><span>' . __( 'Pages:', 'sampression' ) . '</span>', 'after' => '</div>' ) ); ?>
            </div>
            
		</article>
        
				<?php comments_template( '', true ); ?>
        
        </section><!-- end content -->
		
		<?php endwhile; endif; ?>
	
	<?php get_sidebar('right'); ?>

<?php get_footer(); ?>