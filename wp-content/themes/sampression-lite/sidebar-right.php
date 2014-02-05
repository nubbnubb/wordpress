<?php

// Exit if accessed directly
if ( !defined('ABSPATH')) exit;

/**
 * The Sidebar containing the Right widget area.
 *
 * @package Sampression-Lite
 * @since Sampression Lite 1.0
 */
?>
<aside id="sidebar" class="columns four sidebar-right" role="complementary">

	<?php
	// Showing Default Widgets untill User put any widget in "Right Sidebar"
	 if (!dynamic_sidebar('right-sidebar')) : ?>
            <section class="widget">
                <header class="widget-title"><?php _e('Most Popular', 'sampression'); ?></header>
                <div class="widget-entry">
				<?php $args = array(
								'showposts' => 5,
								'orderby' => 'comment_count'
							);
						query_posts($args);
						if (have_posts()):
				?>
                <ul class="widget-popular-posts">
                <?php while (have_posts()) : the_post(); ?>
                <li><a href="<?php the_permalink() ?>" title="<?php echo esc_attr( get_the_title() ); ?>" rel="bookmark" ><?php the_title(); ?></a></li>

				<?php endwhile; ?>	
                </ul>
                <?php endif; ?>
				</div>
			</section><!-- end of .widget -->
            
            <section class="widget">
                <header class="widget-title"><?php _e('Categories', 'sampression'); ?></header>
                <div class="widget-entry">
                
                <ul class="widget-categories">
               <?php wp_list_categories('title_li'); ?> 
                </ul>
               </div>
			</section><!-- end of .widget -->
            
              <section class="widget">
                <header class="widget-title"><?php _e('Archive', 'sampression'); ?></header>
                <div class="widget-entry">
                
                <ul class="widget-categories">
               <?php wp_get_archives(); ?> 
                </ul>
               </div>
			</section><!-- end of .widget -->
            
			<?php endif; //end of home-widget-1 ?>
            
      
     
    
    </aside>