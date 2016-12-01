<?php get_header(); ?>
    <?php
        global $numposts;
        $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

    ?>
    <?php if ( have_posts() ) : ?>
        <div class="action-bar">
            <div class="wrapper">
                <h5><span><?php _e( 'Search Results for: ', 'TB2017' ); ?></span><?php the_search_query(); ?></h5>
            </div>
        </div>
        <div class="wrapper blog">
            <div class="main">
                    <?php while ( have_posts() ) : the_post() ?>
                        <div class="entry entry-preview">
                            <h1><a href="<?php the_permalink(); ?>"  title="<?php printf( __('Permalink to %s', 'TB2017'), the_title_attribute('echo=0') ); ?>" rel="bookmark"><?php the_title(); ?></a></h1>
                            <p class="entry-meta">Posted on <?php the_time( get_option( 'date_format' ) ); ?></p>
                            <?php if ( has_post_thumbnail() ) { ?>
                                <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('large-feature', array('class' => 'feature')); ?></a>
                            <?php } ?>
                            <div><?php the_excerpt(); ?></div>
                            <a class="btn btn-light strong" href="<?php the_permalink(); ?>">Read More</a>
                        </div>
                    <?php endwhile; ?>
                    <?php /* Bottom post navigation */ ?>
                    <?php global $wp_query; $total_pages = $wp_query->max_num_pages; if ( $total_pages > 1 ) { ?>
                        <div class="pagination">
                            <?php previous_posts_link('Prev') ?>
                            <p><?php echo '<span>Page '.$paged.' of '. $wp_query->max_num_pages.'</span>'; ?></p>
                            <?php next_posts_link('Next') ?>
                        </div>
                    <?php } ?>
            </div>
            <div class="secondary">
                <?php get_sidebar(); ?>
            </div>
        </div>
    <?php else : ?>
        <div class="action-bar">
            <div class="wrapper">
                <h3><?php _e( 'Your search did not return any results', 'TB2017' ); ?></h3>
                <p><?php _e( 'Sorry, we were unable to find what you were looking for. Please try another seach term.', 'TB2017' ); ?></p>
                <?php get_search_form(); ?>
            </div>
        </div>
    <?php endif; ?> 
<?php get_footer(); ?>








