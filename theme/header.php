<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
<head>
  <title>
    <?php
      if ( is_single() ) { single_post_title(); print ' | ';}
      elseif ( is_page() ) { single_post_title(''); print ' | ';}
      elseif ( is_search() ) { print 'Search results for ' . wp_specialchars($s); get_page_number(); print ' | ';}
      elseif ( is_404() ) { print ' | Not Found'; print ' | ';}
      else { wp_title('|', true, 'right'); get_page_number(); }
      bloginfo('name'); 
      print ' | ';
      bloginfo('description'); 
    ?>
  </title>
  <meta charset="utf-8">
  <meta http-equiv="content-type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
  <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1, maximum-scale=1">
  <link rel="stylesheet" type="text/css" href="<?php bloginfo('stylesheet_url'); ?>" />
  <link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory'); ?>/styles/responsive.css" />

  <?php wp_head(); ?>

  <link rel="alternate" type="application/rss+xml" href="<?php bloginfo('rss2_url'); ?>" title="<?php printf( __( '%s latest posts', 'TB2017' ), wp_specialchars( get_bloginfo('name'), 1 ) ); ?>" />
  <link rel="alternate" type="application/rss+xml" href="<?php bloginfo('comments_rss2_url') ?>" title="<?php printf( __( '%s latest comments', 'TB2017' ), wp_specialchars( get_bloginfo('name'), 1 ) ); ?>" />
  <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
  <link rel="apple-touch-icon" href="<?php bloginfo('template_directory'); ?>/img/apple-touch-icon.png" />
  <link rel="shortcut icon" href="<?php bloginfo('template_directory'); ?>/img/favicon.png" type="image/x-icon" />
  <link href='https://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>

<!-- Facebook Pixel Code -->
<script>
!function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?
n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;
n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;
t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,
document,'script','https://connect.facebook.net/en_US/fbevents.js');
fbq('init', '796194323844368');
fbq('track', 'PageView');
</script>
<noscript><img height="1" width="1" style="display:none"
src="https://www.facebook.com/tr?id=796194323844368&ev=PageView&noscript=1"
/></noscript>
<!-- DO NOT MODIFY -->
<!-- End Facebook Pixel Code -->
</head>


<body>
  <div class="header">
    <?php
      global $current_user;
      $user_roles = $current_user->roles;
      if($user_roles && is_array($user_roles)) { 
        $user_role = array_shift($user_roles); 
      }
      $user_name = $current_user->display_name;
    ?>
    <div class="user-action-bar">
      <div class="wrapper">
        <?php if ($user_role == "bride") { ?>
          <div class="user-login">
              <span>Welcome, <?php if($user_name) { echo $user_name; } else { echo 'Bride'; } ?>!</span>
              <?php wp_loginout(); ?>
          </div>
          <a href="<?php echo get_page_link( get_page_by_title( 'Today’s Bride Club' )->ID ); ?>">My Dashboard</a>
        <?php } else if ($user_role == "vendor") { ?>
          <div class="user-login">
              <span>Welcome, <?php if($user_name) { echo $user_name; } else { echo 'Vendor'; } ?>!</span>
              <?php wp_loginout(); ?>
          </div>
          <a href="<?php echo get_page_link( get_page_by_title( 'Vendor Portal' )->ID ); ?>">Vendor Portal</a>
        <?php } else { ?>
          <div class="user-login">
              <?php wp_loginout(); ?>
          </div>
          <a href="<?php echo get_page_link( get_page_by_title( "Join Today's Bride" )->ID ); ?>">Join Today's Bride</a>
        <?php } ?>
      </div>
    </div>
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