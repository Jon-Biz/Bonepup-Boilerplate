<?php
/*
Template Name: Backbone Front Page
*/
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>

<head profile="http://gmpg.org/xfn/11">

    <title><?php { bloginfo('name'); print ' | '; bloginfo('description'); get_page_number(); }   ?></title>
 
    <meta http-equiv="content-type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />

<!-- FONTS -->

	<link href='http://fonts.googleapis.com/css?family=Bree+Serif|Henny+Penny' rel='stylesheet' type='text/css'>


<!-- LIBRARIES -->

	<script src="<?php echo get_bloginfo('template_directory');?>/assets/js/libs/jquery.js" ></script>
	<script src="<?php echo get_bloginfo('template_directory');?>/assets/js/libs/json2.js"></script>
	<script src="<?php echo get_bloginfo('template_directory');?>/assets/js/libs/underscore.js"></script>
	<script src="<?php echo get_bloginfo('template_directory');?>/assets/js/libs/backbone.js"></script>
	<script src="<?php echo get_bloginfo('template_directory');?>/assets/js/libs/backbone.marionette.js"></script>

<!-- Javascript -->

	<!-- Routing-->
		<script src="<?php echo get_bloginfo('template_directory');?>/app/main.js"></script>	

	<!-- Other backbone module pages  Go Here -->
	
<!-- Stylesheet -->

  <link rel="stylesheet" type="text/css" href="<?php echo get_bloginfo('template_directory');?>/style-bb.css" />
  
    <?php wp_head(); ?>
 
    <link rel="alternate" type="application/rss+xml" href="<?php bloginfo('rss2_url'); ?>" title="<?php printf( __( '%s latest posts', 'your-theme' ), wp_specialchars( get_bloginfo('name'), 1 ) ); ?>" />
    <link rel="alternate" type="application/rss+xml" href="<?php bloginfo('comments_rss2_url') ?>" title="<?php printf( __( '%s latest comments', 'your-theme' ), wp_specialchars( get_bloginfo('name'), 1 ) ); ?>" />
    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

<!-- Templates -->

</head>

<body>

<div id = 'wrapper' class='hfeed'>
	<div id='header'>Header
			<div id='access'>Access</div><!-- access-->		
	</div><!-- header -->

<div id="main">Main
	<div id="secondary">Secondary</div>
	<div id="primary">Primary
	</div><!--primary -->
</div><!-- main -->

<div id="footer">Footer</div>

</div><!-- wrapper -->

<script src="<?php echo get_bloginfo('template_directory'); ?>/app/launch.js"></script>


</body>
</html>