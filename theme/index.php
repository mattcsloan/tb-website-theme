<?php get_header(); ?>
<div class="wrapper inner">
    <?php 
        global $numposts;
        $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
        $wp_query = new WP_Query( 
            array(
              'posts_per_page' => $numposts, //posts_per_page is determined by Settings > Readings
              'paged' => $paged
            )
        ); 
    ?>
    <?php if ( $wp_query->have_posts() ) { ?>
        <?php while ( $wp_query->have_posts() ) : $wp_query->the_post(); ?>
            <div class="article intro clear">
                <?php the_time( get_option( 'date_format' ) ); ?>
                <span>by <a href="<?php echo get_author_link( false, $authordata->ID, $authordata->user_nicename ); ?>" title="<?php printf( __( 'View all posts by %s', 'TB2017' ), $authordata->display_name ); ?>"><?php the_author(); ?></a></span>
            </div>
            <?php if ( has_post_thumbnail() ) { ?>
                <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail(); ?></a>
            <?php } ?>
            <h2><a href="<?php the_permalink(); ?>" title="<?php printf( __('Permalink to %s', 'TB2017'), the_title_attribute('echo=0') ); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
            <div><?php the_excerpt(); ?></div>
            <?php edit_post_link( __( 'Edit', 'TB2017' ), '<span class="edit-link">', '</span>' ); ?>
        <?php endwhile; ?>

        <?php /* Bottom post navigation */ 
            $total_pages = $wp_query->max_num_pages;
            if ( $total_pages > 1 ) {
        ?>
            <div class="pagination">
                <?php previous_posts_link('Prev') ?>
                <?php echo '<span>Page '.$paged.' of '. $wp_query->max_num_pages.'</span>'; ?>
                <?php next_posts_link('Next') ?>
            </div>
        <?php } ?> 
    <?php } ?>
</div>
<?php get_footer(); ?>