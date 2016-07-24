<!-- being used for vendor plugin? -->

<?php get_header(); ?>
<div class="wrapper inner test">
    <?php the_title('<h1>', '</h1>'); ?>
    <?php the_post(); ?>
    <?php the_content(); ?>
    <?php edit_post_link( __( 'Edit', 'TB2017' ), '<span class="edit-link">', '</span>' ) ?>
    <?php echo get_post_meta(get_the_ID(), 'vendor_img_widget_1', true); ?>
</div>
<?php get_footer(); ?>