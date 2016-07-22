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

  <?php wp_head(); ?>

  <link rel="alternate" type="application/rss+xml" href="<?php bloginfo('rss2_url'); ?>" title="<?php printf( __( '%s latest posts', 'TB2017' ), wp_specialchars( get_bloginfo('name'), 1 ) ); ?>" />
  <link rel="alternate" type="application/rss+xml" href="<?php bloginfo('comments_rss2_url') ?>" title="<?php printf( __( '%s latest comments', 'TB2017' ), wp_specialchars( get_bloginfo('name'), 1 ) ); ?>" />
  <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
  <!--
  <link rel="apple-touch-icon" href="<?php bloginfo('template_directory'); ?>/img/apple-touch-icon.png" />
  <link rel="shortcut icon" href="<?php bloginfo('template_directory'); ?>/img/favicon.ico" type="image/x-icon" />
  -->
  <link href='https://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
</head>


<body>
  <div class="header">
    <div class="navigation">
      <div class="wrapper">
        <?php wp_nav_menu( array( 'theme_location' => 'main-navigation' ) ); ?>
        <?php wp_nav_menu( array( 'theme_location' => 'secondary-navigation' ) ); ?>
        <?php wp_nav_menu( array( 'theme_location' => 'tertiary-navigation' ) ); ?>
      </div>
    </div>
    <div class="wrapper">
      <a href="<?php bloginfo( 'url' ) ?>/">
        <img src="<?php bloginfo('template_directory'); ?>/img/logo.jpg" width="407" alt="<?php bloginfo('name') ?>" />
      </a>
      <!--
      <div class="socials">
        <a class="social-fb" href="#"></a>
        <a class="social-pn" href="#"></a>
        <a class="social-yt" href="#"></a>
        <a class="social-tw" href="#"></a>
        <a class="social-ig" href="#"></a>
        <a class="social-vm" href="#"></a>
      </div>
      -->
     </div>
  </div>
