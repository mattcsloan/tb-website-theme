<!-- being used for vendor plugin -->

<?php get_header(); ?>
<div class="action-bar breadcrumbs">
    <div class="wrapper">
      <?php 
        $parentscategory ="";
        foreach((get_the_category()) as $category) {
          if ($category->category_parent == 0) {
            $parentscategory .= '<h3><a href="' . get_category_link($category->cat_ID) . '" title="' . $category->name . '">' . $category->name . '</a></h3>';
          }
        }
        echo $parentscategory; 
      ?>

      <?php echo do_shortcode('[search-bar]'); ?>
    </div>
</div>
<div class="wrapper">
  <?php while ( have_posts() ) : the_post(); ?>
    <?php the_content(); ?>
  <?php endwhile; // end of the loop. ?>
</div>
<?php get_footer(); ?>