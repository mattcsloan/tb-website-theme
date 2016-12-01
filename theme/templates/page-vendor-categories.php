<?php
/*
Template Name: Vendor Categories Page
*/
?>
<?php get_header(); ?>
<div class="action-bar">
    <div class="wrapper">
        <h3>Find a Local Vendor</h3>
        <?php
            $terms = get_terms( array( 'taxonomy' => 'vendor-list' ));

            echo '<select class="inline-dropdown vendor-category-dropdown">';
                echo '<option value="">Select Vendor Category</option>';
                foreach($terms as $taxonomy) {
                    $term_name = $taxonomy->name;
                    $term_link = get_term_link( $taxonomy, 'vendor-list' );
                    echo '<option value="'.$term_link.'">'.$term_name.'</option>';
                } //end foreach loop

            echo '</select>'
        ?>
        </div>
    </div>
</div>
<div class="wrapper">
  <?php the_title('<h1>', '</h1>'); ?>
  <div class="grid categories-list">
    <?php 
      $category_ids = get_all_category_ids();
      $args = array(
        'taxonomy'      => 'vendor-list',
        'orderby' => 'slug',
        'parent' => 0
      );
      $categories = get_categories( $args );
      foreach ( $categories as $category ) {

        // image id is stored as term meta
        $image_id = get_term_meta( $category->term_id, 'image', true );

        // image data stored in array, second argument is which image size to retrieve
        $image_data = wp_get_attachment_image_src( $image_id, 'full' );

        // image url is the first item in the array (aka 0)
        $image = $image_data[0];


        echo '<a class="item" href="' . get_category_link( $category->term_id ) . '"><span>' . $category->name . '</span>';

        if ( ! empty( $image ) ) {
            echo '<img src="' . esc_url( $image ) . '" />';
        }

        echo '</a>';
      }
    ?>
  </div>
  <p><?php echo the_favorites_button(); ?></p>
  <?php edit_post_link( __( 'Edit', 'TB2017' ), '<span class="edit-link">', '</span>' ) ?>
</div>
<?php get_footer(); ?>