<?php
/*
Template Name: Full-Width Page
*/
?>
<?php get_header(); ?>
<?php the_post(); ?>
<?php the_content(); ?>
<?php edit_post_link( __( 'Edit', 'TB2017' ), '<span class="edit-link">', '</span>' ) ?>
<?php get_footer(); ?>