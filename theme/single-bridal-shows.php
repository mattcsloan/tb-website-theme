<?php
$time = microtime();
$time = explode(' ', $time);
$time = $time[1] + $time[0];
$timestampStart = $time;
?>

<?php get_header(); ?>
<!-- being used for bridal shows plugin -->
<?php
$time = microtime();
$time = explode(' ', $time);
$time = $time[1] + $time[0];
$timestampEndHeader = $time;
?>
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
<?php
$time = microtime();
$time = explode(' ', $time);
$time = $time[1] + $time[0];
$timestampBeginContent = $time;
?>
        <?php the_content(); ?>
<?php
$time = microtime();
$time = explode(' ', $time);
$time = $time[1] + $time[0];
$timestampEndContent = $time;
?>
        <p><?php echo the_favorites_button(); ?></p>
    </div>
    <div class="secondary">
        <h5>Exhibitor List</h5>
        <div class="accordion exhibitor-list">
<?php
$time = microtime();
$time = explode(' ', $time);
$time = $time[1] + $time[0];
$timestampBeginWPQuery = $time;
?>
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
<?php
$time = microtime();
$time = explode(' ', $time);
$time = $time[1] + $time[0];
$timestampEndWPQuery = $time;
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
















<?php
$time = microtime();
$time = explode(' ', $time);
$time = $time[1] + $time[0];
$timestampBeginFooter = $time;
?>
<?php get_footer(); ?>

<?php
$time = microtime();
$time = explode(' ', $time);
$time = $time[1] + $time[0];
$finish = $time;
$total_time = round(($finish - $timestampStart), 4);
$total_header_time = round(($timestampEndHeader - $timestampStart), 4);
$total_begin_content_time = round(($timestampBeginContent - $timestampEndHeader), 4);
$total_end_content_time = round(($timestampEndContent - $timestampBeginContent), 4);
$total_begin_query_time = round(($timestampBeginWPQuery - $timestampEndContent), 4);
$total_end_query_time = round(($timestampEndWPQuery - $timestampBeginWPQuery), 4);
$total_begin_footer_time = round(($timestampBeginFooter - $timestampEndWPQuery), 4);
$total_end_footer_time = round(($finish - $timestampBeginFooter), 4);
// echo '<p>Begin Load: ' . $timestampStart . '</p>';
// echo '<p>End Header: ' . $timestampEndHeader . '</p>';
// echo '<p>End Load: ' . $finish . '</p>';

echo '<div class="wrapper">';
echo '<p>Seconds to load header: '.$total_header_time.'</p>';
echo '<p>Seconds before loading the_content: '.$total_begin_content_time.'</p>';
echo '<p>Seconds to load the_content: '.$total_end_content_time.'</p>';
echo '<p>Seconds to begin WP_Query: '.$total_begin_query_time.'</p>';
echo '<p>Seconds to complete WP_Query: '.$total_end_query_time.'</p>';
echo '<p>Seconds before loading footer: '.$total_begin_footer_time.'</p>';
echo '<p>Seconds to load footer: '.$total_end_footer_time.'</p>';
echo '<hr />';
echo '<p>Page generated in '.$total_time.' seconds.</p>';
echo '</div>';
?>