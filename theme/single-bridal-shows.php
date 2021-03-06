<?php get_header(); ?>
<!-- being used for bridal shows plugin -->
<?php 
    the_post();
    // Retrieves the stored value from the database
    $postId = get_the_ID();
    $showSimpleDate = get_post_meta( $postId, 'show-simple-date', true );
    $showSimpleLocation = get_post_meta( $postId, 'show-simple-location', true );
    $showTime = get_post_meta( $postId, 'show-time', true );
    $showFullDate = get_post_meta( $postId, 'show-full-date', true );
    $showFullLocation = get_post_meta( $postId, 'show-full-location', true );
    $showSponsors = get_post_meta( $postId, 'show-sponsor-meta', true );
?>

<div class="action-bar">
    <div class="wrapper">
        <h3>Plan your dream wedding at a Today's Bride Wedding Show!</h3>
        </div>
    </div>
</div>

<div class="hero" id="bridal-show">
    <div class="wrapper">
        <?php 
            if (has_post_thumbnail()) { 
                the_post_thumbnail(); 
            } else {
            ?>
                <img src="<?php bloginfo('template_directory'); ?>/img/bridal-show-placeholder.png" alt="Today's Bride Bridal Shows" />
            <?php
            } 
        ?>
        <div class="hero-title">
            <?php 
                if (!empty($showSimpleDate)) { echo $showSimpleDate; }

                if (!empty($showSimpleLocation)) { 
                    echo '<span class="hero-subtitle">'.$showSimpleLocation.'</span>'; 
                }
            ?>
        </div>
    </div>
</div>
  <!--
  <div class="action-bar">
    <div class="wrapper">
      <h3>Save on tickets when you join Today's Bride!</h3>
      <div class="action-items">
        <a class="btn">Join</a>
        <a class="btn btn-secondary">Login</a>
      </div>
    </div>
  </div>
  -->
  <div class="wrapper bridal-show">
    <!--
    <div class="page-nav">
      <a href="#details">Details</a>
      <a href="#fashion-show">Fashion Show</a>
      <a href="#contest">Contest &amp; Prizes</a>
      <a href="#specials">Specials</a>
    </div>
    -->
    <div class="main">
        <?php the_content(); ?>
        <p><?php echo the_favorites_button(); ?></p>
    </div>
    <div class="secondary">
        <h5>Exhibitor List</h5>
        <div class="accordion exhibitor-list">
            <?php
              $query = new WP_Query(
                  array(
                    'posts_per_page' => -1,
                    'post_type' => 'vendor',
                    'post_status' => 'publish',
                    'orderby' => 'title',
                    'order' => 'ASC'
                  )
              );
              if( $query->have_posts() ) { 
                $showList = [];
                echo '<ul>';
                while( $query->have_posts() ) { 
                  $query->the_post();
                  $loop_post_id = get_the_ID();
                  $showId = 'bridal-show-'.$postId;
                  $bridalShowStatus = get_post_meta( $loop_post_id, $showId, true );
                  if($bridalShowStatus == 'yes') {

                      $terms = get_the_terms( $loop_post_id, 'vendor-list' );
                      $currentTaxonomy = $terms[0]->name;
                      $showList[] = array(
                        "title" => get_the_title(),
                        "permalink" => get_the_permalink(),
                        "taxonomy" => $currentTaxonomy
                      );
                  }
                }

                foreach ($showList as $key => $row) {
                  $title[$key]  = $row['title'];
                  $taxonomy[$key] = $row['taxonomy'];
                }
                array_multisort($taxonomy, SORT_ASC, $title, SORT_ASC, $showList);

                $category = '';
                foreach($showList as $vendorItem) {
                  // will only run if we are starting a new category
                  if($vendorItem['taxonomy'] != $category) {
                    $category = $vendorItem['taxonomy'];
                    echo '</ul>';
                    echo '<h4><a href="#">'.$category.'</a></h4>';
                    echo '<ul>';
                  }
                  echo '<li><a href="' . $vendorItem['permalink'] . '">' . $vendorItem['title'] . '</a><li>';
                }
                echo '</ul>';
              }
              wp_reset_postdata();
            ?>
        </div>

        <?php if (!empty($showSponsors)) { echo do_shortcode($showSponsors); } ?>
    </div>
  </div>
  <!--
  <div class="action-bar">
    <div class="wrapper">
      <h1>Exhibit With Us!</h1>
      <h3>Become part of the show!</h3>
      <div class="action-items">
        <a class="btn">Learn More</a>
      </div>
    </div>
  </div>
  -->
<?php get_footer(); ?>