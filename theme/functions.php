<?php

// Add support for 'thumbnail' images - for kate's wines etc.

add_theme_support( 'post-thumbnails'); 

// THIS LINKS THE THUMBNAIL TO THE POST PERMALINK

add_filter( 'post_thumbnail_html', 'my_post_image_html', 10, 3 );

function my_post_image_html( $html, $post_id, $post_image_id ) {

	$html = '<a href="' . get_permalink( $post_id ) . '" title="' . esc_attr( get_post_field( 'post_title', $post_id ) ) . '">' . $html . '</a>';

	return $html;
}
// Add category support for pages

function add_category_box_on_page(){
	//add meta box
	add_meta_box('categorydiv', __('Categories'), 'post_categories_meta_box', 'page', 'side', 'low');
}
 
add_action('admin_menu', 'add_category_box_on_page');


// Make theme available for translation
// Translations can be filed in the /languages/ directory

load_theme_textdomain( 'your-theme', TEMPLATEPATH . '/languages' );
 
$locale = get_locale();
$locale_file = TEMPLATEPATH . "/languages/$locale.php";
if ( is_readable($locale_file) )
    require_once($locale_file);
 
// Get the page number

function get_page_number() {
    if ( get_query_var('paged') ) {
        print ' | ' . __( 'Page ' , 'your-theme') . get_query_var('paged');
    }
} // end get_page_number

// Custom callback to list comments in the your-theme style
function custom_comments($comment, $args, $depth) {
  $GLOBALS['comment'] = $comment;
    $GLOBALS['comment_depth'] = $depth;
  ?>
    <li id="comment-<?php comment_ID() ?>" <?php comment_class() ?>>
        <div class="comment-author vcard"><?php commenter_link() ?></div>
        <div class="comment-meta"><?php printf(__('Posted %1$s at %2$s <span class="meta-sep">|</span> <a href="%3$s" title="Permalink to this comment">Permalink</a>', 'your-theme'),
                    get_comment_date(),
                    get_comment_time(),
                    '#comment-' . get_comment_ID() );
                    edit_comment_link(__('Edit', 'your-theme'), ' <span class="meta-sep">|</span> <span class="edit-link">', '</span>'); ?></div>
  <?php if ($comment->comment_approved == '0') _e("\t\t\t\t\t<span class='unapproved'>Your comment is awaiting moderation.</span>\n", 'your-theme') ?>
          <div class="comment-content">
            <?php comment_text() ?>
        </div>
        <?php // echo the comment reply link
            if($args['type'] == 'all' || get_comment_type() == 'comment') :
                comment_reply_link(array_merge($args, array(
                    'reply_text' => __('Reply','your-theme'),
                    'login_text' => __('Log in to reply.','your-theme'),
                    'depth' => $depth,
                    'before' => '<div class="comment-reply-link">',
                    'after' => '</div>'
                )));
            endif;
        ?>
<?php } // end custom_comments

// Custom callback to list pings
function custom_pings($comment, $args, $depth) {
       $GLOBALS['comment'] = $comment;
        ?>
            <li id="comment-<?php comment_ID() ?>" <?php comment_class() ?>>
                <div class="comment-author"><?php printf(__('By %1$s on %2$s at %3$s', 'your-theme'),
                        get_comment_author_link(),
                        get_comment_date(),
                        get_comment_time() );
                        edit_comment_link(__('Edit', 'your-theme'), ' <span class="meta-sep">|</span> <span class="edit-link">', '</span>'); ?></div>
    <?php if ($comment->comment_approved == '0') _e('\t\t\t\t\t<span class="unapproved">Your trackback is awaiting moderation.</span>\n', 'your-theme') ?>
            <div class="comment-content">
                <?php comment_text() ?>
            </div>
<?php } // end custom_pings

// Produces an avatar image with the hCard-compliant photo class
function commenter_link() {
    $commenter = get_comment_author_link();
    if ( ereg( '<a[^>]* class=[^>]+>', $commenter ) ) {
        $commenter = ereg_replace( '(<a[^>]* class=[\'"]?)', '\\1url ' , $commenter );
    } else {
        $commenter = ereg_replace( '(<a )/', '\\1class="url "' , $commenter );
    }
    $avatar_email = get_comment_author_email();
    $avatar = str_replace( "class='avatar", "class='photo avatar", get_avatar( $avatar_email, 80 ) );
    echo $avatar . ' <span class="fn n">' . $commenter . '</span>';
} // end commenter_link

// For category lists on category archives: Returns other categories except the current one (redundant)
function cats_meow($glue) {
    $current_cat = single_cat_title( '', false );
    $separator = "\n";
    $cats = explode( $separator, get_the_category_list($separator) );
    foreach ( $cats as $i => $str ) {
        if ( strstr( $str, ">$current_cat<" ) ) {
            unset($cats[$i]);
            break;
        }
    }
    if ( empty($cats) )
        return false;
 
    return trim(join( $glue, $cats ));
} // end cats_meow

// Register widgetized areas
function theme_widgets_init() {
    // Area 1
    register_sidebar( array (
    'name' => 'Primary Widget Area',
    'id' => 'primary_widget_area',
    'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
    'after_widget' => "</li>",
    'before_title' => '<h3 class="widget-title">',
    'after_title' => '</h3>',
  ) );
 
    // Area 2
    register_sidebar( array (
    'name' => 'Secondary Widget Area',
    'id' => 'secondary_widget_area',
    'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
    'after_widget' => "</li>",
    'before_title' => '<h3 class="widget-title">',
    'after_title' => '</h3>',
  ) );
} // end theme_widgets_init
 
add_action( 'init', 'theme_widgets_init' );

$preset_widgets = array (
    'primary_widget_area'  => array( 'search', 'pages', 'categories', 'archives' ),
    'secondary_widget_area'  => array( 'links', 'meta' )
);
if ( isset( $_GET['activated'] ) ) {
    update_option( 'sidebars_widgets', $preset_widgets );
}
// update_option( 'sidebars_widgets', NULL );

// Check for static widgets in widget-ready areas
function is_sidebar_active( $index ){
  global $wp_registered_sidebars;
 
  $widgetcolums = wp_get_sidebars_widgets();
 
  if ($widgetcolums[$index]) return true;
 
    return false;
} // end is_sidebar_active

// add an action to create a 'products' post type
add_action( 'init', 'create_post_type' );

function create_post_type() {
	register_post_type( 'kate_product',
		array(
			'labels' => array(
				'name' => __( 'Products' ),
				'singular_name' => __( 'Product' ),
				),
			'supports' => array('title'
													,'editor'
													,'thumbnail'
													,'revisions'
													,'page-attributes'
													,'post-formats'
													,'custom-fields'
			),
			'hierarchical' => true,
			'public' => true,
			'has_archive' => true,
			'capability_type' => page
		)
	);
}

