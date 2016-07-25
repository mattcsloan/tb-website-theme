<!-- being used for vendor plugin? -->

<?php get_header(); ?>
<div class="wrapper inner test">
    <?php the_title('<h1>', '</h1>'); ?>
    <?php the_post(); ?>
    <?php the_content(); ?>
    <?php edit_post_link( __( 'Edit', 'TB2017' ), '<span class="edit-link">', '</span>' ) ?>





<?php
 
    // Retrieves the stored value from the database
    $meta_value = get_post_meta( get_the_ID(), 'meta-image', true );
 
    // Checks and displays the retrieved value
    if( !empty( $meta_value ) ) {
        echo $meta_value;
    }
 
?>
</div>
<?php get_footer(); ?>