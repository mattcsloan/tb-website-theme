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
<!--     <?php
        $taxonomies = get_taxonomies(); 
        if ( $taxonomies ) {
          foreach ( $taxonomies  as $taxonomy ) {
            echo '<p>' . $taxonomy . '</p>';
          }
        }

        $terms = get_terms( array( 'taxonomy' => 'vendor-list' ));
        echo $terms;
        // if ( $terms ) {
        //   foreach ( $terms  as $term ) {
        //     echo '<p>' . $term . '</p>';
        //   }
        // }

$post_type = get_post_type();
if ( $post_type )
{
    $post_type_data = get_post_type_object( $post_type );
    $post_type_slug = $post_type_data->rewrite['slug'];
    echo $post_type_slug;
}

echo wp_get_post_terms();
    ?> -->

    <?php the_post(); ?>    






    <?php 
        global $numposts;
        $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
        $terms = get_terms( 'vendor-list' );
        $term_ids = wp_list_pluck( $terms, 'term_id' );

        $term = get_query_var('term');
        $term_id = get_queried_object()->term_id;
        $term_name = get_queried_object()->name;

        $wp_query = new WP_Query( 
            array(
                'posts_per_page'    => -1, // show all
                'post_type' => 'vendor',
                'tax_query' => array(
                    array(
                        'taxonomy'  => 'vendor-list',
                        'terms'     => $term_id
                    ),
                ),
                'paged'     => $paged,
                'meta_key' => 'vendor-tier',
                'orderby' => array( 'meta_value' => 'DESC', 'title' => 'ASC' )
            )
        ); 
    ?>

    <?php echo '<h1>'.$term_name.'</h1>'; ?>


    <?php if ( $wp_query->have_posts() ) { ?>
        <?php 
            // $end_of_signatures = false; 
            // $non_signature_count = 0;
        ?>
        <div class="vendor-category">
        <?php while ( $wp_query->have_posts() ) : $wp_query->the_post(); ?>
            <?php 
                $post_id = get_the_ID();
                $vendorTier = get_post_meta( $post_id, 'vendor-tier', true );
                $vendorLocations = get_post_meta( $post_id, 'vendor-locations', true );
                $vendorShortenedLocations = get_post_meta( $post_id, 'vendor-locations-short', true );
                $vendorPriceRange = get_post_meta( $post_id, 'vendor-price-range', true );
                $vendorDisplayName = get_post_meta( $post_id, 'vendor-display-name', true );
                $vendorExpirationDate = get_post_meta( $post_id, 'vendor-expiration', true );

                if($vendorShortenedLocations) {
                    $vendorLocations = $vendorShortenedLocations;
                }

                $dateToCheck = new DateTime($vendorExpirationDate);
                $now = new DateTime();
                if($dateToCheck < $now) {
                    //vendor has expired
                    $expiredVendor = true;
                } else {
                    //vendor is valid
                    $expiredVendor = false;
                }

                // if($vendorTier != 'signature') {
                //     $non_signature_count++;
                // }
                // if($non_signature_count == 1) { echo ' clear';} 
            ?>

            <?php if($vendorTier !== 'show-only' && !$expiredVendor) { ?>
                <a class="item <?php if($vendorTier) { echo ' '.$vendorTier; } ?>" href="<?php the_permalink(); ?>" title="<?php printf( __('%s', 'TB2017'), the_title_attribute('echo=0') ); ?>">
                    <span class="item-content">
                        <?php 
                            if($vendorDisplayName) { 
                        ?>
                                <strong><?php echo $vendorDisplayName; ?></strong>
                        <?php
                            } else {
                        ?>
                            <strong><?php the_title(); ?></strong>
                        <?php
                            }
                        ?>

                        <?php 
                            if($vendorLocations) { 
                                echo '<span>'.$vendorLocations.'</span>';
                            }

                            if($vendorPriceRange) { 
                                echo '<span class="price-scale">'.$vendorPriceRange.'</span>';
                            } else {
                                echo '<span class="price-scale">---</span>';
                            }
                        ?>
                    </span>
                    <?php if ( has_post_thumbnail() && ($vendorTier == 'signature' || $vendorTier == 'essentials') ) { ?>
                        <?php the_post_thumbnail('large-square'); ?>
                    <?php } ?>
                </a>
            <?php } ?>
        <?php endwhile; ?>
        </div>
    <?php wp_reset_query(); ?>
    <?php } ?>
</div>
<?php get_footer(); ?>