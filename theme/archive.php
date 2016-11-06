<?php get_header(); ?>
<div class="wrapper">
    <div class="main">
        <?php the_post(); ?>         
 
        <?php if ( is_day() ) : ?>
                        <h1><?php printf( __( 'Daily Archives: <span>%s</span>', 'TB2017' ), get_the_time(get_option('date_format')) ) ?></h1>
        <?php elseif ( is_month() ) : ?>
                        <h1><?php printf( __( 'Monthly Archives: <span>%s</span>', 'TB2017' ), get_the_time('F Y') ) ?></h1>
        <?php elseif ( is_year() ) : ?>
                        <h1><?php printf( __( 'Yearly Archives: <span>%s</span>', 'TB2017' ), get_the_time('Y') ) ?></h1>
        <?php elseif ( is_author() ) : ?>
                        <h1><?php echo 'All posts by: <span>'.get_the_author().'</span>'; ?></h1>
        <?php elseif ( is_category() ) : ?>
                        <h1><?php echo 'All posts under the: <span>'; echo single_cat_title(); echo '</span> category'; ?></h1>
        <?php elseif ( is_tag() ) : ?>
                        <h1><?php echo 'All posts tagged with: <span>'; echo single_tag_title(); echo '</span>'; ?></h1>
        <?php elseif ( isset($_GET['paged']) && !empty($_GET['paged']) ) : ?>
                        <h1><?php _e( 'Archives', 'TB2017' ) ?></h1>
        <?php endif; ?>
        <?php 
            global $numposts;
            $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
            global $query_string;
            query_posts($query_string);
        ?>
        <?php if ( $wp_query->have_posts() ) { ?>
            <?php while ( $wp_query->have_posts() ) : $wp_query->the_post(); ?>
                <div class="entry entry-preview">
                    <h1><a href="<?php the_permalink(); ?>"  title="<?php printf( __('Permalink to %s', 'TB2017'), the_title_attribute('echo=0') ); ?>" rel="bookmark"><?php the_title(); ?></a></h1>
                    <p class="entry-meta">Posted on <?php the_time( get_option( 'date_format' ) ); ?> by <a href="<?php echo get_author_link( false, $authordata->ID, $authordata->user_nicename ); ?>" title="<?php printf( __( 'View all posts by %s', 'TB2017' ), $authordata->display_name ); ?>"><?php the_author(); ?></a></p>
                    <?php if ( has_post_thumbnail() ) { ?>
                        <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail(array('class' => 'feature')); ?></a>
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