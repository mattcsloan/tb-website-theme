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
        echo '<h1>'.$numposts.'</h1>';
        $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
        global $query_string;
        query_posts($query_string. '&posts_per_page=-1&meta_key=vendor-tier&order=ASC');

    ?>
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
            <img src="content-img/vendor-featured-bridesmaids.jpg" alt="" />
            </a>
        <?php endwhile; ?>
        </div>
        <?php /* Bottom post navigation */ 
            $total_pages = $wp_query->max_num_pages;
            if ( $total_pages > 1 ) {
        ?>
                <div class="pagination">
                    <?php previous_posts_link('Prev') ?>
                    <p><?php echo '<span>Page '.$paged.' of '. $wp_query->max_num_pages.'</span>'; ?></p>
                    <?php next_posts_link('Next') ?>
                </div>
        <?php } ?> 
    <?php } ?>
</div>
<?php get_footer(); ?>