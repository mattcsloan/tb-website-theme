<!-- being used for vendor plugin -->

<?php get_header(); ?>
<!-- <?php breadcrumbs(); ?> -->

<div class="wrapper blog">
  <div class="main">
    <?php while ( have_posts() ) : the_post(); ?>
      <div class="entry">
          <?php the_title('<h1>', '</h1>'); ?>
          <p class="entry-meta">Posted on <?php the_time( get_option( 'date_format' ) ); ?> by <a href="<?php echo get_author_link( false, $authordata->ID, $authordata->user_nicename ); ?>" title="<?php printf( __( 'View all posts by %s', 'TB2017' ), $authordata->display_name ); ?>"><?php the_author(); ?></a></p>
          <?php the_content(); ?>
          <div class="entry-tags">
            <h2 class="mono">Posted in:</h2>
            <p><?php the_category(', '); ?></p>
          </div>
          <div class="entry-tags">
            <?php the_tags('<h2 class="mono">Tagged with:</h2><p>', ', ', '</p>'); ?>
          </div>
      </div>
      <div class="pagination">
        <?php previous_post_link('%link', 'Prev Post', TRUE); ?>
        <?php next_post_link('%link', 'Next Post', TRUE); ?>
      </div>
      <?php comments_template( '/comments.php', true ); ?>
    <?php endwhile; // end of the loop. ?>
  </div>
  <div class="secondary">
    <?php get_sidebar(); ?>
  </div>
</div>
<?php get_footer(); ?>