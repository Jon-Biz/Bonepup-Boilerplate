<?php
/*
Template Name: Gallery
*/
?>

<?php get_header(); ?>
	<div id="description-box"></div>

<div id="display">
	<div id="content">
	<div id="product-display">
		<?php
			//global $post;
			$category =  $post->ID;
		
			//TODO determine how to add 
			// '_wp_page_template', 'meta_value' => 'my_template.php'
			// to this query
		
			$gallery_query = new WP_Query('post_parent='.$category.'&post_type=page');
		
			if($gallery_query->have_posts()):
			?>
			
			<?php while ( $gallery_query->have_posts() ) : $gallery_query->the_post(); ?>
			
			<?php	$post_thumbnail_id = get_post_thumbnail_id();
						$post_thumbnail_url = wp_get_attachment_url( $post_thumbnail_id );
			?>		
			
			<div class='image-box'>			
			<img id='image-<?php echo $post_thumbnail_id ?>' src=<?php echo $post_thumbnail_url?> />
			<div class='pointer' id='pointer-<?php echo $post_thumbnail_id ?>'></div>
			</div><!-- image-box-->

			<div class="description" id="description-<?php echo $post_thumbnail_id ?>">
			<?php $description = get_post_custom_values('Description'); 
	
				foreach ( $description as $key => $value ) {
			    echo $value; 
			  }
						?> 	
						
			</div><!-- description -->

			<script>
			// detach each description and attach to description div
			
				$('#description-<?php echo $post_thumbnail_id ?>').detach().appendTo(('#description-box'));
			
			
				// add mouseover text to each product image	
			
				$('#image-<?php echo $post_thumbnail_id ?>').mouseover(function(){

						$('#description-<?php echo $post_thumbnail_id ?>').stop(true).animate({opacity:1.0},750);
						$('#pointer-<?php echo $post_thumbnail_id ?>').stop(true).animate({opacity:1.0},750);

					}).mouseout(function(){
						
						$('#description-<?php echo $post_thumbnail_id ?>').stop(true).animate({opacity:0.0},250);
						$('#pointer-<?php echo $post_thumbnail_id ?>').stop(true).animate({opacity:0.0},250);

					});
			
			
			
			</script>

			
			<?php	endwhile; ?>
			<?php else : ?>
				<article id="post-0" class="post no-results not-found">
				<header class="entry-header">
				<h1 class="entry-title"><?php _e( 'Nothing Found', 'twentyeleven' ); ?></h1>
				</header><!-- .entry-header -->
				
				<div class="entry-content">
				<p><?php _e( 'Apologies, but no results were found for the requested category' ); ?></p>
				<?php get_search_form(); ?>
				</div>
				</article>
		
		<?php endif; ?>
		 
		
		 
	</div><!-- #content -->
	</div><!-- #content-box -->
	<div id="ruler"></div>
	<div id="description-box"></div>
</div><!-- #display -->
<?php get_footer(); ?>