<?php 
  // Redirect Attachment page URLs to the page that they are used on
  wp_redirect( get_permalink( $post->post_parent ), 301 ); 
  exit; 
?>