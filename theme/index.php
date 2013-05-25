<?php get_header(); ?>
        <div id="container">
            <div id="content">
            	
<?php /* Top post navigation */ ?>

	<?php global $wp_query; $total_pages = $wp_query->max_num_pages; if ( $total_pages > 1 ) { ?>
	
	                <div id="nav-above" class="navigation">
	                    <div class="nav-previous"><?php next_posts_link(__( '<span class="meta-nav">&laquo;</span> Older posts', 'your-theme' )) ?></div>
	                    <div class="nav-next"><?php previous_posts_link(__( 'Newer posts <span class="meta-nav">&raquo;</span>', 'your-theme' )) ?></div>
	                </div><!-- #nav-above -->
	<?php } ?>

<?php /* The Loop — with comments! */ ?>
	<?php while ( have_posts() ) : the_post() ?>

		<?php /* Create a div with a unique ID thanks to the_ID() and semantic classes with post_class() */ ?>
                <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<?php /* an h2 title */ ?>
                	<h2 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php printf( __('Permalink to %s', 'your-theme'), the_title_attribute('echo=0') ); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
 
		<?php /* Microformatted, translatable post meta */ ?>
                  <div class="entry-meta">
                        <span class="meta-prep meta-prep-author"><?php _e('By ', 'your-theme'); ?></span>
                        <span class="author vcard"><a class="url fn n" href="<?php echo get_author_link( false, $authordata->ID, $authordata->user_nicename ); ?>" title="<?php printf( __( 'View all posts by %s', 'your-theme' ), $authordata->display_name ); ?>"><?php the_author(); ?></a></span>
                        <span class="meta-sep"> | </span>
                        <span class="meta-prep meta-prep-entry-date"><?php _e('Published ', 'your-theme'); ?></span>
                        <span class="entry-date"><abbr class="published" title="<?php the_time('Y-m-d\TH:i:sO') ?>"><?php the_time( get_option( 'date_format' ) ); ?></abbr></span>
                        <?php edit_post_link( __( 'Edit', 'your-theme' ), "<span class=\"meta-sep\">|</span>\n\t\t\t\t\t\t<span class=\"edit-link\">", "</span>\n\t\t\t\t\t" ) ?>
                  </div><!-- .entry-meta -->
 
		<?php /* The entry content */ ?>
                  <div class="entry-content">
		<?php the_content( __( 'Continue reading <span class="meta-nav">&raquo;</span>', 'your-theme' )  ); ?>
		<?php wp_link_pages('before=<div class="page-link">' . __( 'Pages:', 'your-theme' ) . '&after=</div>') ?>
                  </div><!-- .entry-content -->
 
		<?php /* Microformatted category and tag links along with a comments link */ ?>
                  <div class="entry-utility">
                  	<span class="cat-links"><span class="entry-utility-prep entry-utility-prep-cat-links"><?php _e( 'Posted in ', 'your-theme' ); ?></span><?php echo get_the_category_list(', '); ?></span>
                    <span class="meta-sep"> | </span>
		<?php the_tags( '<span class="tag-links"><span class="entry-utility-prep entry-utility-prep-tag-links">' . __('Tagged ', 'your-theme' ) . '</span>', ", ", "</span>\n\t\t\t\t\t\t<span class=\"meta-sep\">|</span>\n" ) ?>
                    <span class="comments-link"><?php comments_popup_link( __( 'Leave a comment', 'your-theme' ), __( '1 Comment', 'your-theme' ), __( '% Comments', 'your-theme' ) ) ?></span>
		<?php edit_post_link( __( 'Edit', 'your-theme' ), "<span class=\"meta-sep\">|</span>\n\t\t\t\t\t\t<span class=\"edit-link\">", "</span>\n\t\t\t\t\t\n" ) ?>
                   </div><!-- #entry-utility -->
                </div><!-- #post-<?php the_ID(); ?> -->
 
		<?php /* Close up the post div and then end the loop with endwhile */ ?>     
 
	<?php endwhile; ?>

<?php /* Bottom post navigation */ ?>
<?php global $wp_query; $total_pages = $wp_query->max_num_pages; if ( $total_pages > 1 ) { ?>
                <div id="nav-below" class="navigation">
                    <div class="nav-previous"><?php next_posts_link(__( '<span class="meta-nav">&laquo;</span> Older posts', 'your-theme' )) ?></div>
                    <div class="nav-next"><?php previous_posts_link(__( 'Newer posts <span class="meta-nav">&raquo;</span>', 'your-theme' )) ?></div>
                </div><!-- #nav-below -->
<?php } ?>
            </div><!-- #content -->
        </div><!-- #container -->
 
        <div id="primary" class="widget-area">
        </div><!-- #primary .widget-area -->
 
        <div id="secondary" class="widget-area">
        </div><!-- #secondary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>