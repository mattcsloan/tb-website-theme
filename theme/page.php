<?php get_header(); ?>
<div class="wrapper">
    <?php the_title('<h1>', '</h1>'); ?>
    <?php the_post(); ?>
    <?php the_content(); ?>
    <p><?php echo the_favorites_button(); ?></p>
    <?php edit_post_link( __( 'Edit', 'TB2017' ), '<span class="edit-link">', '</span>' ) ?>
</div>
<?php get_footer(); ?>