<?php get_header(); ?>
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
                'orderby' => 'meta_value',
                'order' => 'DESC'

            )
        ); 
    ?>


    <?php echo '<h1>'.$term_name.'</h1>'; ?>


    <?php if ( $wp_query->have_posts() ) { ?>
        <div class="vendor-category">
        <?php while ( $wp_query->have_posts() ) : $wp_query->the_post(); ?>
            <?php 
                $post_id = get_the_ID();
                $vendorTier = get_post_meta( $post_id, 'vendor-tier', true ); 
            ?>
            <a class="item <?php if($vendorTier) { echo ' '.$vendorTier; } ?>" href="<?php the_permalink(); ?>" title="<?php printf( __('%s', 'TB2017'), the_title_attribute('echo=0') ); ?>">
            <span class="item-content">
                <strong><?php the_title(); ?></strong>
                <?php if($vendorTier) { echo '<span>'.$vendorTier.'</span>'; } ?>
                <!--<span>Multiple Locations</span>
                <span class="price-scale">$$</span>-->
            </span>
            <?php if ( has_post_thumbnail() && ($vendorTier == 'signature' || $vendorTier == 'essentials') ) { ?>
                <?php the_post_thumbnail(); ?>
            <?php } ?>
            </a>
        <?php endwhile; ?>
        </div>
    <?php wp_reset_query(); ?>
    <?php } ?>
</div>
<?php get_footer(); ?>