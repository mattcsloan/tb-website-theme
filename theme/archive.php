<?php get_header(); ?>
<?php if(is_day() || is_month() || is_year() || is_author() || is_category() || is_tag() || isset($_GET['paged']) && !empty($_GET['paged'])) { ?>
    <div class="action-bar">
        <div class="wrapper">
            <?php if ( is_day() ) : ?>
                <h5><?php printf( __( '<span>Daily Archives:</span> %s', 'TB2017' ), get_the_time(get_option('date_format')) ) ?></h5>
            <?php elseif ( is_month() ) : ?>
                <h5><?php printf( __( '<span>Monthly Archives:</span> %s', 'TB2017' ), get_the_time('F Y') ) ?></h5>
            <?php elseif ( is_year() ) : ?>
                <h5><?php printf( __( '<span>Yearly Archives:</span> %s', 'TB2017' ), get_the_time('Y') ) ?></h5>
            <?php elseif ( is_author() ) : ?>
                <h5><?php echo '<span>All posts by:</span> '.get_the_author(); ?></h5>
            <?php elseif ( is_category() ) : ?>
                <h5><?php echo '<span>All posts under the: </span>'; echo single_cat_title(); echo ' <span>category</span>'; ?></h5>
            <?php elseif ( is_tag() ) : ?>
                <h5><?php echo '<span>All posts tagged with:</span> '; echo single_tag_title(); ?></h5>
            <?php elseif ( isset($_GET['paged']) && !empty($_GET['paged']) ) : ?>
                <h5><?php _e( 'Archives', 'TB2017' ) ?></h5>
            <?php endif; ?>
        </div>
    </div>
<?php } ?>


<div class="wrapper">
    <div class="main">
        <?php 
            the_post(); 
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