<!-- being used for vendor plugin -->

<?php get_header(); ?>
<?php 
    the_post();
    // Retrieves the stored value from the database
    $postId = get_the_ID();
    $vendor_tier = get_post_meta( $postId, 'vendor-tier', true );
    $vendor_logo = get_post_meta( $postId, 'vendor-logo', true );
    $vendor_locations = get_post_meta( $postId, 'vendor-locations', true );
    $vendor_website_link = get_post_meta( $postId, 'vendor-website-link', true );
    $vendor_phone_number = get_post_meta( $postId, 'vendor-phone-number', true );
    $vendor_testimonial = get_post_meta( $postId, 'vendor-testimonial', true );
    $vendor_facebook = get_post_meta( $postId, 'vendor-facebook', true );
    $vendor_pinterest = get_post_meta( $postId, 'vendor-pinterest', true );
    $vendor_youtube = get_post_meta( $postId, 'vendor-youtube', true );
    $vendor_twitter = get_post_meta( $postId, 'vendor-twitter', true );
    $vendor_instagram = get_post_meta( $postId, 'vendor-instagram', true );
    $vendor_thumbnail_1_link = get_post_meta( $postId, 'vendor-thumbnail-1-link', true );
    $vendor_thumbnail_1_image = get_post_meta( $postId, 'vendor-thumbnail-1-image', true );
    $vendor_thumbnail_2_link = get_post_meta( $postId, 'vendor-thumbnail-2-link', true );
    $vendor_thumbnail_2_image = get_post_meta( $postId, 'vendor-thumbnail-2-image', true );
    $vendor_thumbnail_3_link = get_post_meta( $postId, 'vendor-thumbnail-3-link', true );
    $vendor_thumbnail_3_image = get_post_meta( $postId, 'vendor-thumbnail-3-image', true );

    // Checks and displays the retrieved value
    if( !empty( $vendor_tier ) && $vendor_tier == 'signature' ) {
        echo $vendor_tier;
    }
?>

<div class="wrapper inner">
    <?php 
        $taxonomies = get_the_taxonomies();
        foreach ( $taxonomies as $taxonomy ) {
            echo '<h1>' . $taxonomy . '</h1>';
        }
    ?>
    <div class="vendor-feature">
      <div class="main">
        <div class="feature-gallery">

          <?php 
            if (has_post_thumbnail()) {
                the_post_thumbnail();
            }
          ?>
          <!-- 
          <div class="feature-thumbs">
            <a href="#">
              <img src="content-img/vendor-feature.jpg" alt="" />
            </a>
            <a href="#">
              <img src="content-img/vendor-feature.jpg" alt="" />
            </a>
            <a href="#">
              <img src="content-img/vendor-feature.jpg" alt="" />
            </a>
            <a href="#">
              <img src="content-img/vendor-feature.jpg" alt="" />
            </a>
          </div>
           -->
        </div>
      </div>
      <div class="secondary">
        <?php the_title('<h2>', '</h2>'); ?>
        <div class="vendor-details">
          <div class="vendor-location"><?php echo $vendor_locations ?></div>
          <div class="vendor-contact">
            <a class="vendor-web" href="<?php echo $vendor_website_link ?>" target="_blank">Website</a>
            <span class="vendor-phone"><?php echo $vendor_phone_number; ?></span>
          </div>
        </div>
        <!-- <p><a class="btn btn-light strong" href="#">Request A Quote</a></p> -->
        <?php the_content(); ?>
        <!-- <p><a class="btn btn-light strong btn-favorite" href="#">Favorite</a></p> -->
        <div class="socials pink">
          <a class="social-fb" href="<?php echo $vendor_facebook; ?>" target="_blank"></a>
          <a class="social-pn" href="<?php echo $vendor_pinterest; ?>" target="_blank"></a>
          <a class="social-yt" href="<?php echo $vendor_youtube; ?>" target="_blank"></a>
          <a class="social-tw" href="<?php echo $vendor_twitter; ?>" target="_blank"></a>
          <a class="social-ig" href="<?php echo $vendor_instagram; ?>" target="_blank"></a>
        </div>
      </div>
    </div>
</div>
<!-- 
<div class="action-bar vendor-content">
    <div class="wrapper inner columns">
      <div class="col thirds">
        <h3>Designers</h3>
        <ul class="dotted-list">
          <li>Wedding Gowns</li>
          <li>Bridesmaid Dresses</li>
          <li>Flower Girl Dresses</li>
          <li>Mother of the Bride Dresses</li>
          <li>Dry Cleaning</li>
          <li>Dress Preservation</li>
          <li>Group Discounts</li>
          <li>QuinceaÑera Dresses</li>
          <li>Mother of the Bride Dresses</li>
          <li>Dry Cleaning</li>
          <li>Dress Preservation</li>
          <li>Group Discounts</li>
          <li>Bridesmaid Dresses</li>
          <li>Flower Girl Dresses</li>
          <li>Mother of the Bride Dresses</li>
          <li>Wedding Gowns</li>
          <li>Bridesmaid Dresses</li>
        </ul>
      </div>
      <div class="col thirds">
        <h3>Highlights</h3>
        <ul class="check-list">
          <li>Wedding Gowns</li>
          <li>Bridesmaid Dresses</li>
          <li>Flower Girl Dresses</li>
          <li>Mother of the Bride Dresses</li>
          <li>Dry Cleaning</li>
          <li>Dress Preservation</li>
          <li>Group Discounts</li>
          <li>QuinceaÑera Dresses</li>
        </ul>
      </div>
      <div class="col thirds">
        <h3>See Us</h3>
        <ul class="check-list">
          <li>Today’s Bride Magazine • Spring 2016</li>
          <li>Today’s Bride Wedding Show • 07/08/16</li>
          <li>Today’s Bride Wedding Show • 8/28/16</li>
          <li>Today’s Bride Wedding Show • 10/16/16</li>
          <li>Today’s Bride Wedding Show • 01/08/17</li>
          <li>Today’s Bride Wedding Show • 01/14-15/17</li>
        </ul>
        <h3>Location</h3>
        <p>Visit our <a href="#" target="_blank">website</a> for a location near you.</p>
      </div>
    </div>
</div> 
-->
<div class="wrapper inner">
    <div class="vendor-testimonial">
      <div class="columns">
        <div class="col thirds">
          <img class="vendor-logo" src="<?php echo $vendor_logo; ?>" alt="" />
        </div>
        <div class="col thirds two-thirds">
          <?php echo $vendor_testimonial; ?>
        </div>
      </div>
    </div>
</div>
<div class="action-bar vendor-screenshots">
    <div class="wrapper inner">
      <h1>Check Us Out</h1>
      <div class="columns">
        <div class="col thirds">
          <a href="<?php echo $vendor_thumbnail_1_link; ?>" target="_blank">
            <img src="<?php echo $vendor_thumbnail_1_image; ?>" alt="" />
          </a>
        </div>
        <div class="col thirds">
          <a href="<?php echo $vendor_thumbnail_2_link; ?>" target="_blank">
            <img src="<?php echo $vendor_thumbnail_2_image; ?>" alt="" />
          </a>
        </div>
        <div class="col thirds">
          <a href="<?php echo $vendor_thumbnail_3_link; ?>" target="_blank">
            <img src="<?php echo $vendor_thumbnail_3_image; ?>" alt="" />
          </a>
        </div>
      </div>
    </div>
</div>

<?php get_footer(); ?>