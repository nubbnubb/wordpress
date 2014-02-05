<?php

// Exit if accessed directly
if ( !defined('ABSPATH')) exit;

/**
 * The Sidebar containing the main widget area.
 *
 * @package Sampression-Lite
 * @since Sampression Lite 1.0
 */
?>
<aside id="sidebar" class="clearfix" role="complementary">
	<?php
	// Showing Popular Posts untill the user put any widget in Bottom widget 1
	 if (!dynamic_sidebar('bottom-widget-1')) : ?>
            <section class="column one-third widget">
            
                <header class="widget-title"><?php _e('Most Popular Posts', 'sampression'); ?></header>
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
            
			</section><!-- end of .widget-wrapper -->
	<?php endif; //end of bottom-widget-1
			
	// Showing Latest Comments untill the user put any widget in Bottom widget 2
	 if (!dynamic_sidebar('bottom-widget-2')) : ?>
    <section class="column one-third widget">
    <header class="widget-title"><?php _e('Recent Comments', 'sampression'); ?></header>
    <div class="widget-entry">
    <ul class="widget-commentlist">
	<?php
	$args = array(
		'status' => 'approve',
		'number' => '3'
	);
	$comments = get_comments($args);
 	foreach ($comments as $comment) {
        $url = '<a href="'. get_permalink($comment->comment_post_ID).'#comment-'.$comment->comment_ID .'" title="'.$comment->comment_author .' | '.get_the_title($comment->comment_post_ID).'">';
       echo '<li class="clearfix">';
       echo $url;
       echo get_avatar( $comment->comment_author_email, 25);
       echo '</a>';
       
       echo '<div class="cmt-txt">';
	    echo 'By ';
        echo $comment->comment_author;
		echo ': ';
		echo $url;
		echo substr($comment->comment_content,0,80). '...';
		echo '</a></div>';
        echo '</li>';
    }
?>
    </ul>
   <!-- .widget-list-comments -->
    </div>
    
    </section>
    <?php endif;
	// Showing Dummy Text untill the user put any widget in Bottom widget 2
	 if (!dynamic_sidebar('bottom-widget-3')) : ?>
	 
            <!--<section class="column one-third widget">
            
                <header class="widget-title"><?php _e('About me', 'sampression'); ?></header>
                <div class="widget-entry">
				<?php _e('This is your Third Bottom Widget box (Bottom Widget 3). To edit please go to Appearance > Widgets and choose 3rd widget from the top in area second called Bottom Widget 3. Title is also manageable from widgets as well.','sampression'); ?>
				</div> -->
            
			</section>
			<!-- end of .widget-wrapper -->
			<?php endif; //end of bottom-widget-3 ?>
    
    </aside>