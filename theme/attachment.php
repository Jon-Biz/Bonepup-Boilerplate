<?php get_header(); ?>
 
  <div id="container">
		<div id="content">
      	
			<?php the_post(); ?>
			
			<h1 class="page-title"><a href="<?php echo get_permalink($post->post_parent) ?>" title="<?php printf( __( 'Return to %s', 'your-theme' ), wp_specialchars( get_the_title($post->post_parent), 1 ) ) ?>" rev="attachment"><span class="meta-nav">&laquo; </span><?php echo get_the_title($post->post_parent) ?></a></h1>
			
			<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
        
				
				<h2 class="entry-title"><?php the_title(); ?></h2> 
					
				<div class="entry-content">
				  <div class="entry-attachment">
	
<?php if ( wp_attachment_is_image( $post->id ) ) : $att_image = wp_get_attachment_image_src( $post->id, "medium"); ?>
          <p class="attachment"><a href="<?php echo wp_get_attachment_url($post->id); ?>" title="<?php the_title(); ?>" rel="attachment"><img src="<?php echo $att_image[0];?>" width="<?php echo $att_image[1];?>" height="<?php echo $att_image[2];?>"  class="attachment-medium" alt="<?php $post->post_excerpt; ?>" /></a>
          </p>
	<?php else : ?>
          <a href="<?php echo wp_get_attachment_url($post->ID) ?>" title="<?php echo wp_specialchars( get_the_title($post->ID), 1 ) ?>" rel="attachment"><?php echo basename($post->guid) ?></a>
<?php endif; ?>
	
		        </div>
		        <div class="entry-caption"><?php if ( !empty($post->post_excerpt) ) the_excerpt() ?></div>
	 
							<?php the_content( __( 'Continue reading <span class="meta-nav">&raquo;</span>', 'your-theme' )  ); ?>
	
							<?php wp_link_pages('before=<div class="page-link">' . __( 'Pages:', 'your-theme' ) . '&after=</div>') ?>
	 
				</div><!-- .entry-content -->
									
					 <div class="entry-utility">
	
						<?php printf( __( 'This entry was posted in %1$s%2$s. Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>. Follow any comments here with the <a href="%5$s" title="Comments RSS to %4$s" rel="alternate" type="application/rss+xml">RSS feed for this post</a>.', 'your-theme' ),
						    get_the_category_list(', '),
						    get_the_tag_list( __( ' and tagged ', 'your-theme' ), ', ', '' ),
						    get_permalink(),
						    the_title_attribute('echo=0'),
						    comments_rss() ) ?>
	 
<?php if ( ('open' == $post->comment_status) && ('open' == $post->ping_status) ) : // Comments and trackbacks open ?>
		<?php printf( __( '<a class="comment-link" href="#respond" title="Post a comment">Post a comment</a> or leave a trackback: <a class="trackback-link" href="%s" title="Trackback URL for your post" rel="trackback">Trackback URL</a>.', 'your-theme' ), get_trackback_url() ) ?>
	<?php elseif ( !('open' == $post->comment_status) && ('open' == $post->ping_status) ) : // Only trackbacks open ?>
		<?php printf( __( 'Comments are closed, but you can leave a trackback: <a class="trackback-link" href="%s" title="Trackback URL for your post" rel="trackback">Trackback URL</a>.', 'your-theme' ), get_trackback_url() ) ?>
	<?php elseif ( ('open' == $post->comment_status) && !('open' == $post->ping_status) ) : // Only comments open ?>
		<?php _e( 'Trackbacks are closed, but you can <a class="comment-link" href="#respond" title="Post a comment">post a comment</a>.', 'your-theme' ) ?>
	<?php elseif ( !('open' == $post->comment_status) && !('open' == $post->ping_status) ) : // Comments and trackbacks closed ?>
		<?php _e( 'Both comments and trackbacks are currently closed.', 'your-theme' ) ?>
<?php endif; ?>
	
						<?php edit_post_link( __( 'Edit', 'your-theme' ), "\n\t\t\t\t\t<span class=\"edit-link\">", "</span>" ) ?>
				</div><!-- .entry-utility -->	
			</div><!-- #post-<?php the_ID(); ?> -->  		    

			<?php comments_template('', true); ?>
 
		</div><!-- #content -->
	</div><!-- #container -->
 
<?php get_sidebar(); ?>
<?php get_footer(); ?>