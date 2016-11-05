<?php
/*
Template Name: Blog Posts
*/
?>
<?php get_header(); ?>
<div class="wrapper blog">
    <div class="main">
        <?php 
            global $numposts;
            $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
            $wp_query = new WP_Query( 
                array(
                    'category_name'     => 'blog',
                    'category__not_in'  => array(1962), // 'real-weddings' category ID
                    'posts_per_page'    => $numposts, //posts_per_page is determined by Settings > Readings
                    'paged'             => $paged
                )
            ); 
        ?>
        <?php if ( $wp_query->have_posts() ) { ?>
            <?php while ( $wp_query->have_posts() ) : $wp_query->the_post(); ?>
                <div class="entry entry-preview">
                    <h1><a href="<?php the_permalink(); ?>"  title="<?php printf( __('Permalink to %s', 'TB2017'), the_title_attribute('echo=0') ); ?>" rel="bookmark"><?php the_title(); ?></a></h1>
                    <p class="entry-meta">Posted on <?php the_time( get_option( 'date_format' ) ); ?> by <a href="<?php echo get_author_link( false, $authordata->ID, $authordata->user_nicename ); ?>" title="<?php printf( __( 'View all posts by %s', 'TB2017' ), $authordata->display_name ); ?>"><?php the_author(); ?></a></p>
                    <?php if ( has_post_thumbnail() ) { ?>
                        <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('large-feature', array('class' => 'feature')); ?></a>
                    <?php } ?>
                    <div><?php the_excerpt(); ?></div>
                    <a class="btn btn-light strong" href="<?php the_permalink(); ?>">Read More</a>
                </div>
            <?php endwhile; ?>

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
    <div class="secondary">
        <?php get_sidebar(); ?>
    </div>
</div>
<?php get_footer(); ?>