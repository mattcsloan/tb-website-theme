<!-- being used for vendor plugin -->

<?php get_header(); ?>
<?php 
    the_post();
    // Retrieves the stored value from the database
    $postId = get_the_ID();
    $vendor_tier = get_post_meta( $postId, 'vendor-tier', true );
    $vendor_display_name = get_post_meta( $postId, 'vendor-display-name', true );
    $vendor_logo = get_post_meta( $postId, 'vendor-logo', true );
    $vendor_locations = get_post_meta( $postId, 'vendor-locations', true );
    $vendor_website_link = get_post_meta( $postId, 'vendor-website-link', true );
    $vendor_phone_number = get_post_meta( $postId, 'vendor-phone-number', true );
    $vendor_discount_card = get_post_meta( $postId, 'vendor-discount-card', true );
    $vendor_partner_logo = get_post_meta( $postId, 'vendor-partner-logo', true );
    // $vendor_testimonial = get_post_meta( $postId, 'vendor-testimonial', true );
    $vendor_facebook = get_post_meta( $postId, 'vendor-facebook', true );
    $vendor_pinterest = get_post_meta( $postId, 'vendor-pinterest', true );
    $vendor_youtube = get_post_meta( $postId, 'vendor-youtube', true );
    $vendor_twitter = get_post_meta( $postId, 'vendor-twitter', true );
    $vendor_instagram = get_post_meta( $postId, 'vendor-instagram', true );
    $vendor_section_headline = get_post_meta( $postId, 'vendor-section-headline', true );
    $vendor_thumbnail_1_link = get_post_meta( $postId, 'vendor-thumbnail-1-link', true );
    $vendor_thumbnail_1_image = get_post_meta( $postId, 'vendor-thumbnail-1-image', true );
    $vendor_thumbnail_2_link = get_post_meta( $postId, 'vendor-thumbnail-2-link', true );
    $vendor_thumbnail_2_image = get_post_meta( $postId, 'vendor-thumbnail-2-image', true );
    $vendor_thumbnail_3_link = get_post_meta( $postId, 'vendor-thumbnail-3-link', true );
    $vendor_thumbnail_3_image = get_post_meta( $postId, 'vendor-thumbnail-3-image', true );
    $wysiwyg_meta_1 = get_post_meta( $postId, 'wysiwyg-meta-1', true );
    $wysiwyg_meta_2 = get_post_meta( $postId, 'wysiwyg-meta-2', true );
    $wysiwyg_meta_3 = get_post_meta( $postId, 'wysiwyg-meta-3', true );
    $gallery_meta = get_post_meta( $postId, 'gallery-meta', true );
    $vendor_video_type = get_post_meta( $postId, 'vendor-video-type', true );
    $vendor_video_id = get_post_meta( $postId, 'vendor-video-id', true );
?>

<div class="action-bar">
    <div class="wrapper">
        <h3>Find a Local Vendor</h3>
        <?php
            $terms = get_terms( array( 'taxonomy' => 'vendor-list' ));

            echo '<select class="inline-dropdown vendor-category-dropdown">';
                echo '<option value="">Select Vendor Category</option>';
                foreach($terms as $taxonomy) {
                    $term_name = $taxonomy->name;
                    $term_link = get_term_link( $taxonomy, 'vendor-list' );
                    echo '<option value="'.$term_link.'">'.$term_name.'</option>';
                } //end foreach loop

            echo '</select>';
        ?>
        </div>
    </div>
</div>

<?php if( !empty($vendor_tier)) { ?>
    <div class="wrapper">
        <h1><?php echo the_taxonomies(array('template' => '% %l')); ?></h1>
        <div class="vendor-feature vendor-<?php echo $vendor_tier; ?>">

          <?php if ((!empty($gallery_meta) || has_post_thumbnail() || (!empty($vendor_video_type) && !empty($vendor_video_id))) && $vendor_tier !== 'basic') { ?>
              <div class="main">                
                <div class="feature-gallery">
                    <?php
                        if(!empty($vendor_video_type) && !empty($vendor_video_id)) {
                        ?>
                            <div class="feature-video">
                                <?php 
                                if($vendor_video_type == 'youtube') {
                                ?>
                                    <iframe width="560" height="315" src="https://www.youtube.com/embed/<?php echo $vendor_video_id; ?>?rel=0" frameborder="0" allowfullscreen></iframe>
                                <?php
                                } else if($vendor_video_type == 'vimeo') {
                                ?>
                                    <iframe src="https://player.vimeo.com/video/<?php echo $vendor_video_id; ?>?title=0&byline=0&portrait=0" width="640" height="360" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
                                <?php
                                }
                                ?>
                            </div>
                        <?php
                        }
                    ?>
                    <?php 
                        

                        if(!empty($gallery_meta)) {
                            echo $gallery_meta;
                        } else if(has_post_thumbnail()) {
                            the_post_thumbnail();
                        }
                    ?>
                </div>
              </div>
          <?php } ?> 

          <div class="vendor-intro <?php if (!has_post_thumbnail() && empty($gallery_meta)) { echo "no-media"; } ?>">
            <?php 
                if($vendor_display_name) { 
            ?>
                    <h2><?php echo $vendor_display_name; ?></h2>
            <?php
                } else {
            ?>
                <strong><?php the_title('<h2>', '</h2>'); ?></strong>
            <?php
                }
            ?>
            <div class="vendor-details">
                <?php if (!empty($vendor_locations)) { ?>
                    <div class="vendor-location"><?php echo $vendor_locations ?></div>
                <?php } ?>
                <?php if (!empty($vendor_website_link) || !empty($vendor_phone_number)) { ?>
                    <div class="vendor-contact">
                        <?php if (!empty($vendor_website_link)) { ?>
                            <a class="vendor-web <?php if (empty($vendor_phone_number)) { echo "single-link"; } ?>" href="<?php echo $vendor_website_link ?>" target="_blank">Website</a>
                        <?php } ?>
                        <?php if (!empty($vendor_phone_number)) { ?>
                            <span class="vendor-phone <?php if (empty($vendor_website_link)) { echo "single-link"; } ?>"><?php echo $vendor_phone_number; ?></span>
                        <?php } ?>
                    </div>
                <?php } ?>
            </div>
            <p><a class="btn btn-light strong" href="#">Request A Quote</a></p>
            <?php the_content(); ?>
            <p><a class="btn btn-light strong btn-favorite" href="#">Favorite</a></p>
            <?php if ($vendor_tier !== 'basic') { ?>
                <div class="socials pink">
                    <ul>
                        <?php if (!empty($vendor_facebook)) { ?>
                            <li class="social-fb">
                                <a href="<?php echo $vendor_facebook; ?>" target="_blank"></a>
                            </li>
                        <?php } ?>  
                        <?php if (!empty($vendor_pinterest)) { ?>
                            <li class="social-pn">
                                <a href="<?php echo $vendor_pinterest; ?>" target="_blank"></a>
                            </li>
                        <?php } ?>  
                        <?php if (!empty($vendor_youtube)) { ?>
                            <li class="social-yt">
                                <a href="<?php echo $vendor_youtube; ?>" target="_blank"></a>
                            </li>
                        <?php } ?>  
                        <?php if (!empty($vendor_twitter)) { ?>
                            <li class="social-tw">
                                <a href="<?php echo $vendor_twitter; ?>" target="_blank"></a>
                            </li>
                        <?php } ?>  
                        <?php if (!empty($vendor_instagram)) { ?>
                            <li class="social-ig">
                                <a href="<?php echo $vendor_instagram; ?>" target="_blank"></a>
                            </li>
                        <?php } ?> 
                    </ul> 
                </div>
            <?php } ?> 
          </div>
        </div>
    </div>
    <?php
        if( (!empty($wysiwyg_meta_1) || !empty($wysiwyg_meta_2) || !empty($wysiwyg_meta_3)) && ($vendor_tier === 'signature' ||  $vendor_tier === 'essentials' ||  $vendor_tier === 'classic')) {
    ?>
            <div class="action-bar vendor-content">
                <div class="wrapper columns">
                    <?php 
                        if(!empty($wysiwyg_meta_1)) {
                    ?>
                          <div class="col thirds">
                            <?php echo do_shortcode(wpautop($wysiwyg_meta_1)); ?>
                          </div>
                    <?php
                        }
                    ?>
                    <?php 
                        if(!empty($wysiwyg_meta_2)) {
                    ?>
                          <div class="col thirds">
                            <?php echo do_shortcode(wpautop($wysiwyg_meta_2)); ?>
                          </div>
                    <?php
                        }
                    ?>
                    <?php 
                        if(!empty($wysiwyg_meta_3)) {
                    ?>
                          <div class="col thirds">
                            <?php echo do_shortcode(wpautop($wysiwyg_meta_3)); ?>
                          </div>
                    <?php
                        }
                    ?>
                </div>
            </div> 
    <?php
        }
    ?>

    <?php if ((!empty($vendor_logo) || !empty($vendor_discount_card) || !empty($vendor_partner_logo)) && ($vendor_tier === 'signature' ||  $vendor_tier === 'essentials')) { ?>
        <div class="wrapper">
            <div class="vendor-brand columns three-wide">
                <?php if (!empty($vendor_logo)) { ?>
                    <div class="vendor-logo col">
                        <img src="<?php echo $vendor_logo; ?>" alt="" />
                    </div>
                <?php } ?>

                <?php if (!empty($vendor_partner_logo) && $vendor_partner_logo == 'yes') { ?>
                    <div class="col">
                        <img class="vendor-featured-partner" src="<?php bloginfo('template_directory'); ?>/img/vendor-featured-partner.png" alt="Today's Bride Featured Partner" />
                    </div>
                <?php } ?>

                <?php if (!empty($vendor_discount_card) && $vendor_discount_card == 'yes') { ?>
                    <div class="col">
                        <a href="<?php bloginfo('url'); ?>/wedding-deals/discount-card">
                            <img class="vendor-discount-card" src="<?php bloginfo('template_directory'); ?>/img/vendor-discount-card.png" alt="Today's Bride Discount Card" />
                        </a>
                    </div>
                <?php } ?>

                <!--
                <?php if (!empty($vendor_testimonial)) { ?>
                    <div class="vendor-brand-content">
                      <?php echo $vendor_testimonial; ?>
                    </div>
                <?php } ?>
                -->
            </div>
        </div>
    <?php } ?>

    <?php if ((!empty($vendor_thumbnail_1_link) || !empty($vendor_thumbnail_1_image) || !empty($vendor_thumbnail_2_link) || !empty($vendor_thumbnail_2_image) || !empty($vendor_thumbnail_3_link) || !empty($vendor_thumbnail_3_image)) && ($vendor_tier === 'signature' ||  $vendor_tier === 'essentials')) { ?>
        <div class="action-bar vendor-screenshots">
            <div class="wrapper">
              <?php if (!empty($vendor_section_headline)) { ?>
                  <h1><?php echo $vendor_section_headline; ?></h1>
              <?php } ?>
              <div class="columns">
                <?php if (!empty($vendor_thumbnail_1_link) || !empty($vendor_thumbnail_1_image)) { ?>
                    <div class="col thirds">
                        <a <?php if (!empty($vendor_thumbnail_1_link)) { echo 'href="' . $vendor_thumbnail_1_link . '"'; } ?> target="_blank">
                            <?php if (!empty($vendor_thumbnail_1_image)) { ?>
                                <img src="<?php echo $vendor_thumbnail_1_image; ?>" alt="" />
                            <?php } else { ?>
                                <span class="vendor-screenshot-link-only"><?php echo $vendor_thumbnail_1_link; ?></span>
                            <?php } ?>
                        </a>
                    </div>
                <?php } ?>
                <?php if (!empty($vendor_thumbnail_2_link) || !empty($vendor_thumbnail_2_image)) { ?>
                    <div class="col thirds">
                        <a <?php if (!empty($vendor_thumbnail_2_link)) { echo 'href="' . $vendor_thumbnail_2_link . '"'; } ?> target="_blank">
                            <?php if (!empty($vendor_thumbnail_2_image)) { ?>
                                <img src="<?php echo $vendor_thumbnail_2_image; ?>" alt="" />
                            <?php } else { ?>
                                <span class="vendor-screenshot-link-only"><?php echo $vendor_thumbnail_2_link; ?></span>
                            <?php } ?>
                        </a>
                    </div>
                <?php } ?>
                <?php if (!empty($vendor_thumbnail_3_link) || !empty($vendor_thumbnail_3_image)) { ?>
                    <div class="col thirds">
                        <a <?php if (!empty($vendor_thumbnail_3_link)) { echo 'href="' . $vendor_thumbnail_3_link . '"'; } ?> target="_blank">
                            <?php if (!empty($vendor_thumbnail_3_image)) { ?>
                                <img src="<?php echo $vendor_thumbnail_3_image; ?>" alt="" />
                            <?php } else { ?>
                                <span class="vendor-screenshot-link-only"><?php echo $vendor_thumbnail_3_link; ?></span>
                            <?php } ?>
                        </a>
                    </div>
                <?php } ?>
              </div>
            </div>
        </div>
    <?php } ?>

    <?php if($vendor_tier == 'basic') { ?>
        <div class="action-bar">
            <div class="wrapper">
                <h3 class="link-camo">Other <?php echo the_taxonomies(array('template' => '% %l')); ?> Vendors</h3>
                <div class="vendor-category">

                    <?php

                        $terms = get_the_terms( $post->ID, 'vendor-list' );
                        $currentTaxonomy = $terms[0]->slug;

                        $related = new WP_Query(
                            array(
                                'posts_per_page' => -1, 
                                'post_type' => 'vendor',
                                'tax_query' => array(
                                    array(
                                        'taxonomy'  => 'vendor-list',
                                        'field'    => 'slug',
                                        'terms'    => $currentTaxonomy
                                    ),
                                ),
                                'meta_key' => 'vendor-tier',
                                'orderby' => 'meta_value',
                                'order' => 'DESC'
                            )
                        );
                        if( $related->have_posts() ) { 
                          $signatureVendorCount = 0;
                          while( $related->have_posts() ) { $related->the_post(); 
                            $post_id = get_the_ID();
                            $vendorTier = get_post_meta( $post_id, 'vendor-tier', true );
                            $vendorLocations = get_post_meta( $post_id, 'vendor-locations', true );
                            $vendorPriceRange = get_post_meta( $post_id, 'vendor-price-range', true );
                            $vendorDisplayName = get_post_meta( $post_id, 'vendor-display-name', true );
                            $vendorExpirationDate = get_post_meta( $post_id, 'vendor-expiration', true );

                            $dateToCheck = new DateTime($vendorExpirationDate);
                            $now = new DateTime();
                            if($dateToCheck < $now) {
                                //vendor has expired
                                $expiredVendor = true;
                            } else {
                                //vendor is valid
                                $expiredVendor = false;
                            }

                            if($vendorTier == 'signature' && !$expiredVendor) {
                                $signatureVendorCount++;
                            ?>
                                <a class="item signature" href="<?php the_permalink(); ?>" title="<?php printf( __('%s', 'TB2017'), the_title_attribute('echo=0') ); ?>">
                                    <span class="item-content">
                                        <?php 
                                            if($vendorDisplayName) { 
                                        ?>
                                                <strong><?php echo $vendorDisplayName; ?></strong>
                                        <?php
                                            } else {
                                        ?>
                                            <strong><?php the_title(); ?></strong>
                                        <?php
                                            }
                                        ?>

                                        <?php 
                                            if($vendorLocations) { 
                                                echo '<span>'.$vendorLocations.'</span>';
                                            }

                                            if($vendorPriceRange) { 
                                                echo '<span class="price-scale">'.$vendorPriceRange.'</span>';
                                            } else {
                                                echo '<span class="price-scale">---</span>';
                                            }
                                        ?>
                                    </span>
                                    <?php 
                                        if ( (!empty($gallery_meta) || has_post_thumbnail()) && ($vendorTier == 'signature' || $vendorTier == 'essentials') ) {
                                            the_post_thumbnail();
                                        }
                                    ?>
                                </a>
                            <?php
                            }
                          }
                          if(!$signatureVendorCount) {

                            $categoryLink = get_term_link( $currentTaxonomy, 'vendor-list' );
                            echo '<a class="btn" href="'.$categoryLink.'">View All</a>';
                          }
                        }
                        wp_reset_postdata();


                    ?>

                </div>
            </div>
        </div>
    <?php } ?>
<?php } ?>
<div class="wrapper">
<?php echo do_shortcode('[ninja_form id=5]'); ?>
</div>
<?php get_footer(); ?>