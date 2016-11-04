<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
<head>
  <title><?php
    if ( is_single() ) { single_post_title(); }
    elseif ( is_page() ) { single_post_title(''); }
    elseif ( is_search() ) { bloginfo('name'); print ' | Search results for ' . wp_specialchars($s); get_page_number(); }
    elseif ( is_404() ) { bloginfo('name'); print ' | Not Found'; }
    else { bloginfo('name'); wp_title('|'); get_page_number(); }
  ?> | Today's Bride</title>
  <meta charset="utf-8">
  <meta http-equiv="content-type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
  <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1, maximum-scale=1">
  <link rel="stylesheet" type="text/css" href="<?php bloginfo('stylesheet_url'); ?>" />
  <link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory'); ?>/styles/responsive.css" />

  <?php wp_head(); ?>

  <link rel="alternate" type="application/rss+xml" href="<?php bloginfo('rss2_url'); ?>" title="<?php printf( __( '%s latest posts', 'TB2017' ), wp_specialchars( get_bloginfo('name'), 1 ) ); ?>" />
  <link rel="alternate" type="application/rss+xml" href="<?php bloginfo('comments_rss2_url') ?>" title="<?php printf( __( '%s latest comments', 'TB2017' ), wp_specialchars( get_bloginfo('name'), 1 ) ); ?>" />
  <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
  <!--
  <link rel="apple-touch-icon" href="<?php bloginfo('template_directory'); ?>/img/apple-touch-icon.png" />
  <link rel="shortcut icon" href="<?php bloginfo('template_directory'); ?>/img/favicon.ico" type="image/x-icon" />
  -->
  <link href='https://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <script src="<?php bloginfo('template_directory'); ?>/scripts/interaction.js"></script>
</head>


<body>
  <div class="header">
    <div class="navigation">
      <div class="wrapper">
        <a class="menu-link" href="#">Menu</a>
        <?php wp_nav_menu( array( 'theme_location' => 'main-navigation' ) ); ?>
      </div>
    </div>
    <div class="wrapper">
      <a href="<?php bloginfo( 'url' ) ?>/">
        <img src="<?php bloginfo('template_directory'); ?>/img/logo.jpg" width="350" alt="<?php bloginfo('name') ?>" />
      </a>
      <div class="socials">
        <?php wp_nav_menu( array( 'theme_location' => 'social-navigation' ) ); ?>
      </div>
     </div>
  </div>
