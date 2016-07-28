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
    $wysiwyg_meta_1 = get_post_meta( $postId, 'wysiwyg-meta-1', true );
    $wysiwyg_meta_2 = get_post_meta( $postId, 'wysiwyg-meta-2', true );
    $wysiwyg_meta_3 = get_post_meta( $postId, 'wysiwyg-meta-3', true );
?>

<?php
if( !empty($vendor_tier)) {
?>
    <div class="wrapper inner">
        <?php 
            $taxonomies = get_the_taxonomies();
            foreach ( $taxonomies as $taxonomy ) {
                echo '<h1>' . $taxonomy . '</h1>';
            }
        ?>
        <div class="vendor-feature vendor-<?php echo $vendor_tier; ?>">

          <?php if (has_post_thumbnail() && $vendor_tier !== 'basic') { ?>
              <div class="main">
                <div class="feature-gallery">
                  <?php the_post_thumbnail(); ?>
                </div>
              </div>
          <?php } ?> 

          <div class="vendor-intro">
            <?php the_title('<h2>', '</h2>'); ?>
            <div class="vendor-details">
                <?php if (!empty($vendor_locations)) { ?>
                    <div class="vendor-location"><?php echo $vendor_locations ?></div>
                <?php } ?>
                <?php if (!empty($vendor_website_link) || !empty($vendor_phone_number)) { ?>
                    <div class="vendor-contact">
                        <?php if (!empty($vendor_website_link)) { ?>
                            <a class="vendor-web" href="<?php echo $vendor_website_link ?>" target="_blank">Website</a>
                        <?php } ?>
                        <?php if (!empty($vendor_phone_number)) { ?>
                            <span class="vendor-phone"><?php echo $vendor_phone_number; ?></span>
                        <?php } ?>
                    </div>
                <?php } ?>
            </div>
            <!-- <p><a class="btn btn-light strong" href="#">Request A Quote</a></p> -->
            <?php the_content(); ?>
            <!-- <p><a class="btn btn-light strong btn-favorite" href="#">Favorite</a></p> -->
            <?php if ($vendor_tier !== 'basic') { ?>
                <div class="socials pink">
                    <?php if (!empty($vendor_facebook)) { ?>
                        <a class="social-fb" href="<?php echo $vendor_facebook; ?>" target="_blank"></a>
                    <?php } ?>  
                    <?php if (!empty($vendor_pinterest)) { ?>
                        <a class="social-pn" href="<?php echo $vendor_pinterest; ?>" target="_blank"></a>
                    <?php } ?>  
                    <?php if (!empty($vendor_youtube)) { ?>
                        <a class="social-yt" href="<?php echo $vendor_youtube; ?>" target="_blank"></a>
                    <?php } ?>  
                    <?php if (!empty($vendor_twitter)) { ?>
                        <a class="social-tw" href="<?php echo $vendor_twitter; ?>" target="_blank"></a>
                    <?php } ?>  
                    <?php if (!empty($vendor_instagram)) { ?>
                        <a class="social-ig" href="<?php echo $vendor_instagram; ?>" target="_blank"></a>
                    <?php } ?>  
                </div>
            <?php } ?> 
          </div>
        </div>
    </div>
    <?php
        if( (!empty($wysiwyg_meta_1) || !empty($wysiwyg_meta_2) || !empty($wysiwyg_meta_3)) && ($vendor_tier === 'signature' ||  $vendor_tier === 'essentials')) {
    ?>
            <div class="action-bar vendor-content">
                <div class="wrapper inner columns">
                    <?php 
                        if(!empty($wysiwyg_meta_1)) {
                    ?>
                          <div class="col thirds">
                            <?php echo $wysiwyg_meta_1; ?>
                          </div>
                    <?php
                        }
                    ?>
                    <?php 
                        if(!empty($wysiwyg_meta_2)) {
                    ?>
                          <div class="col thirds">
                            <?php echo $wysiwyg_meta_2; ?>
                          </div>
                    <?php
                        }
                    ?>
                    <?php 
                        if(!empty($wysiwyg_meta_3)) {
                    ?>
                          <div class="col thirds">
                            <?php echo $wysiwyg_meta_3; ?>
                          </div>
                    <?php
                        }
                    ?>
                </div>
            </div> 
    <?php
        }
    ?>
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
<?php
}
?>
<?php get_footer(); ?>