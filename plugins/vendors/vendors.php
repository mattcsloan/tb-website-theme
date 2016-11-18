<?php 
/*Plugin Name: Vendor Listings
Description: Add a list of vendors to your website and create individual vendor pages.
Version: 1.1.2
License: GPLv2
*/

function vendor_category_taxonomy() {
  // set up labels
  $labels = array(
    'name'              => 'Vendor Categories',
    'singular_name'     => 'Vendor Category',
    'search_items'      => 'Search Vendor Categories',
    'all_items'         => 'All Vendor Categories',
    'edit_item'         => 'Edit Vendor Category',
    'update_item'       => 'Update Vendor Category',
    'add_new_item'      => 'Add New Vendor Category',
    'new_item_name'     => 'New Vendor Category',
    'menu_name'         => 'Vendor Categories'
  );

  // register taxonomy
  register_taxonomy( 'vendor-list', 'vendor', array(
    'hierarchical' => true,
    'labels' => $labels,
    'query_var' => true,
    'show_admin_column' => true
  ));
}
add_action( 'init', 'vendor_category_taxonomy' );


function vendor_listings() {
  // set up labels
  $labels = array(
    'name' => 'Vendors',
    'singular_name' => 'Vendor',
    'add_new' => 'Add New Vendor',
    'add_new_item' => 'Add New Vendor',
    'edit_item' => 'Edit Vendor',
    'new_item' => 'New Vendor',
    'all_items' => 'All Vendors',
    'view_item' => 'View Vendor',
    'search_items' => 'Search Vendors',
    'not_found' =>  'No Vendors Found',
    'not_found_in_trash' => 'No Vendors found in Trash', 
    'parent_item_colon' => '',
    'menu_name' => 'Vendors',
  );

  //register post type
  register_post_type( 'vendor', array(
    'labels' => $labels,
    'public' => true,
    'supports' => array( 'title', 'editor', 'thumbnail', 'page-attributes' ),
    'taxonomies' => array( 'vendor-list' ), 
    'exclude_from_search' => false,
    'capability_type' => 'post',
    'hierarchical' => true,
    'rewrite' => array( 'slug' => 'vendors' ),
    'has_archive' => true
  ));
}
add_action( 'init', 'vendor_listings' );


// ======================================================== //
// ======================================================== //
// ================ Vendor Info Meta Box ================== //
// ======================================================== //
// ======================================================== //
function tb_custom_meta() {
  add_meta_box( 'tb_meta', __( 'Vendor Information', 'tb-textdomain' ), 'tb_meta_callback', 'vendor' );
}
add_action( 'add_meta_boxes', 'tb_custom_meta' );
/**
 * Outputs the content of the meta box
 */
function tb_meta_callback( $post ) {
  wp_nonce_field( basename( __FILE__ ), 'tb_nonce' );
  $tb_stored_meta = get_post_meta( $post->ID );
  ?>
  <div class="vendor-form">
    <!-- Vendor Tier -->
    <p>
      <span class="tb-row-title"><?php _e( 'Vendor Tier', 'tb-textdomain' )?></span>
      <div class="tb-row-content">
        <label for="vendor-tier-signature">
          <input type="radio" name="vendor-tier" id="vendor-tier-signature" value="signature" <?php if ( isset ( $tb_stored_meta['vendor-tier'] ) ) checked( $tb_stored_meta['vendor-tier'][0], 'signature' ); ?>>
          <?php _e( 'Signature', 'tb-textdomain' )?>
        </label>
        <label for="vendor-tier-essentials">
          <input type="radio" name="vendor-tier" id="vendor-tier-essentials" value="essentials" <?php if ( isset ( $tb_stored_meta['vendor-tier'] ) ) checked( $tb_stored_meta['vendor-tier'][0], 'essentials' ); ?>>
          <?php _e( 'Essentials', 'tb-textdomain' )?>
        </label>
        <label for="vendor-tier-classic">
          <input type="radio" name="vendor-tier" id="vendor-tier-classic" value="classic" <?php if ( isset ( $tb_stored_meta['vendor-tier'] ) ) checked( $tb_stored_meta['vendor-tier'][0], 'classic' ); ?>>
          <?php _e( 'Classic', 'tb-textdomain' )?>
        </label>
        <label for="vendor-tier-basic">
          <input type="radio" name="vendor-tier" id="vendor-tier-basic" value="basic" <?php if ( isset ( $tb_stored_meta['vendor-tier'] ) ) checked( $tb_stored_meta['vendor-tier'][0], 'basic' ); ?>>
          <?php _e( 'Basic', 'tb-textdomain' )?>
        </label>
        <label for="vendor-tier-show-only">
          <input type="radio" name="vendor-tier" id="vendor-tier-show-only" value="show-only" <?php if ( isset ( $tb_stored_meta['vendor-tier'] ) ) checked( $tb_stored_meta['vendor-tier'][0], 'show-only' ); ?>>
          <?php _e( 'Show Only', 'tb-textdomain' )?>
        </label>
      </div>
    </p>    

    <!-- Vendor Logo -->
    <div class="vendor-media-preview">
      <img id="vendor-logo-img" src="<?php if ( isset ( $tb_stored_meta['vendor-logo'] ) ) echo $tb_stored_meta['vendor-logo'][0]; ?>" alt="" />
      <p class="tb-row-content">
        <label for="vendor-logo" class="tb-row-title"><?php _e( 'Vendor Logo', 'tb-textdomain' )?></label>
        <input type="button" id="vendor-logo-button" class="image-upload-button button" value="<?php _e( 'Choose or Upload an Image', 'tb-textdomain' )?>" />
        <input id="vendor-logo" name="vendor-logo" type="hidden" value="<?php if ( isset ( $tb_stored_meta['vendor-logo'] ) ) echo $tb_stored_meta['vendor-logo'][0]; ?>" />
        <span class="media-delete-btn" id="media-delete-btn-logo">
          <input id="vendor-logo-image-delete" type="button" class="button" value="<?php _e( 'Remove Image', 'tb-textdomain' )?>" />
        </span>
      </p>
    </div>

    <!-- Vendor Display Name -->
    <p class="tb-row-content">
      <label for="vendor-display-name" class="tb-row-title"><?php _e( 'Vendor Display Name', 'tb-textdomain' )?></label>
      <input type="text" name="vendor-display-name" id="vendor-display-name" value="<?php if ( isset ( $tb_stored_meta['vendor-display-name'] ) ) echo $tb_stored_meta['vendor-display-name'][0]; ?>" />
    </p>

    <!-- Vendor Locations -->
    <p class="tb-row-content">
      <label for="vendor-locations" class="tb-row-title"><?php _e( 'Vendor Location', 'tb-textdomain' )?></label>
      <input type="text" name="vendor-locations" id="vendor-locations" value="<?php if ( isset ( $tb_stored_meta['vendor-locations'] ) ) echo $tb_stored_meta['vendor-locations'][0]; ?>" />
    </p>

    <!-- Shortened Vendor Locations -->
    <p class="tb-row-content">
      <label for="vendor-locations-short" class="tb-row-title"><?php _e( 'Shortened Vendor Location', 'tb-textdomain' )?></label>
      <input type="text" name="vendor-locations-short" id="vendor-locations-short" value="<?php if ( isset ( $tb_stored_meta['vendor-locations-short'] ) ) echo $tb_stored_meta['vendor-locations-short'][0]; ?>" />
    </p>

    <!-- Vendor Price Range -->
    <p class="tb-row-content">
    <label for="vendor-price-range"><?php _e( 'Vendor Price Range', 'tb-textdomain' )?></label>
    <select name="vendor-price-range" id="vendor-price-range">
        <option value="">Select Vendor's Price Range</option>';
        <option value="$" <?php if ( isset ( $tb_stored_meta['vendor-price-range'] ) ) selected( $tb_stored_meta['vendor-price-range'][0], '$' ); ?>><?php _e( '$', 'tb-textdomain' )?></option>';
        <option value="$$" <?php if ( isset ( $tb_stored_meta['vendor-price-range'] ) ) selected( $tb_stored_meta['vendor-price-range'][0], '$$' ); ?>><?php _e( '$$', 'tb-textdomain' )?></option>';
        <option value="$$$" <?php if ( isset ( $tb_stored_meta['vendor-price-range'] ) ) selected( $tb_stored_meta['vendor-price-range'][0], '$$$' ); ?>><?php _e( '$$$', 'tb-textdomain' )?></option>';
        <option value="$$$$" <?php if ( isset ( $tb_stored_meta['vendor-price-range'] ) ) selected( $tb_stored_meta['vendor-price-range'][0], '$$$$' ); ?>><?php _e( '$$$$', 'tb-textdomain' )?></option>';
        <option value="$$$$$" <?php if ( isset ( $tb_stored_meta['vendor-price-range'] ) ) selected( $tb_stored_meta['vendor-price-range'][0], '$$$$$' ); ?>><?php _e( '$$$$$', 'tb-textdomain' )?></option>';
    </select>
    </p>

    <!-- Vendor Expiration Date -->
    <p class="tb-row-content">
      <label for="vendor-expiration" class="tb-row-title">
        <?php _e( 'Vendor Expiration Date', 'tb-textdomain' )?>
        <em class="description"> (Accepted Format: MM/DD/YYYY)</em>
      </label>
      <input type="text" name="vendor-expiration" id="vendor-expiration" value="<?php if ( isset ( $tb_stored_meta['vendor-expiration'] ) ) echo $tb_stored_meta['vendor-expiration'][0]; ?>" />
    </p>

    <!-- Vendor Website Link -->
    <p class="tb-row-content">
      <label for="vendor-website-link" class="tb-row-title">
        <?php _e( 'Vendor Website Link', 'tb-textdomain' )?>
        <em class="description"> (Please include 'http://' or 'https://' in link)</em>
      </label>
      <input type="text" name="vendor-website-link" id="vendor-website-link" value="<?php if ( isset ( $tb_stored_meta['vendor-website-link'] ) ) echo $tb_stored_meta['vendor-website-link'][0]; ?>" />
    </p>

    <!-- Vendor Phone Number -->
    <p class="tb-row-content">
      <label for="vendor-phone-number" class="tb-row-title"><?php _e( 'Vendor Phone Number', 'tb-textdomain' )?></label>
      <input type="text" name="vendor-phone-number" id="vendor-phone-number" value="<?php if ( isset ( $tb_stored_meta['vendor-phone-number'] ) ) echo $tb_stored_meta['vendor-phone-number'][0]; ?>" />
    </p>

    <!-- Vendor Testimonial -->
    <p class="tb-row-content">
      <label for="vendor-testimonial" class="tb-row-title"><?php _e( 'Vendor Testimonial', 'tb-textdomain' )?></label>
      <textarea name="vendor-testimonial" id="vendor-testimonial"><?php if ( isset ( $tb_stored_meta['vendor-testimonial'] ) ) echo $tb_stored_meta['vendor-testimonial'][0]; ?></textarea>
    </p>

    <!-- Add To Pickup Locations -->
    <p class="tb-row-content">
        <input type="checkbox" id="vendor-pickup-location" name="vendor-pickup-location" value="yes" <?php if ( isset ( $tb_stored_meta['vendor-pickup-location'] ) ) checked( $tb_stored_meta['vendor-pickup-location'][0], 'yes' ); ?> />
        <label for="vendor-pickup-location" style="display: inline; width: auto;">Add this vendor to Pickup Locations list</label>
    </p>

    <!-- Add To Discount Card Page -->
    <p class="tb-row-content">
        <input type="checkbox" id="vendor-discount-card" name="vendor-discount-card" value="yes" <?php if ( isset ( $tb_stored_meta['vendor-discount-card'] ) ) checked( $tb_stored_meta['vendor-discount-card'][0], 'yes' ); ?> />
        <label for="vendor-discount-card" style="display: inline; width: auto;">Add a Discount Card image and add vendor to Discount Card Page</label>
    </p>

    <!-- Add Vendor Partner badge -->
    <p class="tb-row-content">
        <input type="checkbox" id="vendor-partner-logo" name="vendor-partner-logo" value="yes" <?php if ( isset ( $tb_stored_meta['vendor-partner-logo'] ) ) checked( $tb_stored_meta['vendor-partner-logo'][0], 'yes' ); ?> />
        <label for="vendor-partner-logo" style="display: inline; width: auto;">Show Featured Partner badge on page</label>
    </p>

    <div class="tb-row-content">
      <h3>Vendor Social Links</h3>
      <!-- Vendor Facebook -->
      <p>
        <label for="vendor-facebook" class="tb-row-title"><?php _e( 'Vendor Facebook URL', 'tb-textdomain' )?></label>
        <input type="text" name="vendor-facebook" id="vendor-facebook" value="<?php if ( isset ( $tb_stored_meta['vendor-facebook'] ) ) echo $tb_stored_meta['vendor-facebook'][0]; ?>" />
      </p>
      <!-- Vendor Pinterest -->
      <p>
        <label for="vendor-pinterest" class="tb-row-title"><?php _e( 'Vendor Pinterest URL', 'tb-textdomain' )?></label>
        <input type="text" name="vendor-pinterest" id="vendor-pinterest" value="<?php if ( isset ( $tb_stored_meta['vendor-pinterest'] ) ) echo $tb_stored_meta['vendor-pinterest'][0]; ?>" />
      </p>
      <!-- Vendor YouTube -->
      <p>
        <label for="vendor-youtube" class="tb-row-title"><?php _e( 'Vendor YouTube URL', 'tb-textdomain' )?></label>
        <input type="text" name="vendor-youtube" id="vendor-youtube" value="<?php if ( isset ( $tb_stored_meta['vendor-youtube'] ) ) echo $tb_stored_meta['vendor-youtube'][0]; ?>" />
      </p>
      <!-- Vendor Twitter -->
      <p>
        <label for="vendor-twitter" class="tb-row-title"><?php _e( 'Vendor Twitter URL', 'tb-textdomain' )?></label>
        <input type="text" name="vendor-twitter" id="vendor-twitter" value="<?php if ( isset ( $tb_stored_meta['vendor-twitter'] ) ) echo $tb_stored_meta['vendor-twitter'][0]; ?>" />
      </p>
      <!-- Vendor Facebook -->
      <p>
        <label for="vendor-instagram" class="tb-row-title"><?php _e( 'Vendor Instagram URL', 'tb-textdomain' )?></label>
        <input type="text" name="vendor-instagram" id="vendor-instagram" value="<?php if ( isset ( $tb_stored_meta['vendor-instagram'] ) ) echo $tb_stored_meta['vendor-instagram'][0]; ?>" />
      </p>
    </div>

    <div class="tb-row-content">
      <h3>Bridal Show Participation</h3>
      <?php
          if(is_plugin_active( 'bridal-shows/bridal-shows.php')) { 
            $this_post = array();
            $id_pot = array();
            $i = 0;

            $query = new WP_Query(
                array(
                  'posts_per_page' => -1,
                  'post_type' => 'bridal-shows',
                  'post_status' => 'publish',
                  'orderby' => 'title',
                  'order' => 'ASC'
                )
            );
            if( $query->have_posts() ) { 
              while( $i < $query->post_count ) { 
                $post = $query->posts;
                if(!in_array($post[$i]->ID, $id_pot)){
                    $this_post['id'] = $post[$i]->ID;
                    $this_post['post_title'] = $post[$i]->post_title;
                    $id_pot[] = $post[$i]->ID;
                    $postTitle = $this_post['post_title'];
                    $post_id = $this_post['id'];
                    $showId = 'bridal-show-'.$post_id;
                  ?>
                  <p>
                      <input type="checkbox" id="<?php echo $showId; ?>" name="<?php echo $showId; ?>" value="yes" <?php if ( isset ( $tb_stored_meta[$showId] ) ) checked( $tb_stored_meta[$showId][0], 'yes' ); ?> />
                      <label for="<?php echo $showId; ?>" style="display: inline; width: auto;"><?php echo $postTitle; ?></label>
                  </p>
                  <?php
                }
                $post = '';
                $i++;
              }
            }
            wp_reset_postdata();
          }
      ?>
    </div>

    <div class="tb-row-content">
      <h3>Vendor Featured Video</h3>
      <p>Add a video from YouTube or Vimeo.</p>
      <!-- Vendor Video Platform -->
      <label for="vendor-video-type"><?php _e( 'Choose Video Platform', 'tb-textdomain' )?></label>
      <select name="vendor-video-type" id="vendor-video-type">
          <option value="">Select Video Platform</option>';
          <option value="youtube" <?php if ( isset ( $tb_stored_meta['vendor-video-type'] ) ) selected( $tb_stored_meta['vendor-video-type'][0], 'youtube' ); ?>><?php _e( 'YouTube', 'tb-textdomain' )?></option>';
          <option value="vimeo" <?php if ( isset ( $tb_stored_meta['vendor-video-type'] ) ) selected( $tb_stored_meta['vendor-video-type'][0], 'vimeo' ); ?>><?php _e( 'Vimeo', 'tb-textdomain' )?></option>';
      </select>
      <!-- Vendor Video ID -->
      <p>
        <label for="vendor-video-id" class="tb-row-title"><?php _e( 'YouTube/Vimeo Video ID', 'tb-textdomain' )?></label>
        <input type="text" name="vendor-video-id" id="vendor-video-id" value="<?php if ( isset ( $tb_stored_meta['vendor-video-id'] ) ) echo $tb_stored_meta['vendor-video-id'][0]; ?>" />
      </p>
    </div>



  </div>
<?php
}
/**
 * Saves the custom meta input
 */
function tb_meta_save( $post_id ) {
 
  // Checks save status
  $is_autosave = wp_is_post_autosave( $post_id );
  $is_revision = wp_is_post_revision( $post_id );
  $is_valid_nonce = ( isset( $_POST[ 'tb_nonce' ] ) && wp_verify_nonce( $_POST[ 'tb_nonce' ], basename( __FILE__ ) ) ) ? 'true' : 'false';
 
  // Exits script depending on save status
  if ( $is_autosave || $is_revision || !$is_valid_nonce ) {
    return;
  }
 
  // Checks for input and saves if needed
  if( isset( $_POST[ 'vendor-tier' ] ) ) {
    update_post_meta( $post_id, 'vendor-tier', $_POST[ 'vendor-tier' ] );
  }

  // Checks for input and saves if needed
  if( isset( $_POST[ 'vendor-logo' ] ) ) {
    update_post_meta( $post_id, 'vendor-logo', $_POST[ 'vendor-logo' ] );
  }

  // Checks for input and sanitizes/saves if needed
  if( isset( $_POST[ 'vendor-display-name' ] ) ) {
    update_post_meta( $post_id, 'vendor-display-name', sanitize_text_field( $_POST[ 'vendor-display-name' ] ) );
  }

  // Checks for input and sanitizes/saves if needed
  if( isset( $_POST[ 'vendor-locations' ] ) ) {
    update_post_meta( $post_id, 'vendor-locations', sanitize_text_field( $_POST[ 'vendor-locations' ] ) );
  }

  // Checks for input and sanitizes/saves if needed
  if( isset( $_POST[ 'vendor-locations-short' ] ) ) {
    update_post_meta( $post_id, 'vendor-locations-short', sanitize_text_field( $_POST[ 'vendor-locations-short' ] ) );
  }

  // Checks for input and saves if needed
  if( isset( $_POST[ 'vendor-price-range' ] ) ) {
      update_post_meta( $post_id, 'vendor-price-range', $_POST[ 'vendor-price-range' ] );
  }

  // Checks for input and sanitizes/saves if needed
  if( isset( $_POST[ 'vendor-expiration' ] ) ) {
    update_post_meta( $post_id, 'vendor-expiration', sanitize_text_field( $_POST[ 'vendor-expiration' ] ) );
  }

  // Checks for input and sanitizes/saves if needed
  if( isset( $_POST[ 'vendor-website-link' ] ) ) {
    update_post_meta( $post_id, 'vendor-website-link', sanitize_text_field( $_POST[ 'vendor-website-link' ] ) );
  }

  // Checks for input and sanitizes/saves if needed
  if( isset( $_POST[ 'vendor-phone-number' ] ) ) {
    update_post_meta( $post_id, 'vendor-phone-number', sanitize_text_field( $_POST[ 'vendor-phone-number' ] ) );
  }

  // Checks for input and sanitizes/saves if needed
  if( isset( $_POST[ 'vendor-testimonial' ] ) ) {
    update_post_meta( $post_id, 'vendor-testimonial', sanitize_text_field( $_POST[ 'vendor-testimonial' ] ) );
  }

  // Checks for presence of checkbox value
  if( isset( $_POST[ 'vendor-pickup-location' ] ) ) {
    update_post_meta( $post_id, 'vendor-pickup-location', 'yes' );
  } else {
    update_post_meta( $post_id, 'vendor-pickup-location', '' );
  }

  // Checks for presence of checkbox value
  if( isset( $_POST[ 'vendor-discount-card' ] ) ) {
    update_post_meta( $post_id, 'vendor-discount-card', 'yes' );
  } else {
    update_post_meta( $post_id, 'vendor-discount-card', '' );
  }

  // Checks for presence of checkbox value
  if( isset( $_POST[ 'vendor-partner-logo' ] ) ) {
    update_post_meta( $post_id, 'vendor-partner-logo', 'yes' );
  } else {
    update_post_meta( $post_id, 'vendor-partner-logo', '' );
  }

  // Checks for input and sanitizes/saves if needed
  if( isset( $_POST[ 'vendor-facebook' ] ) ) {
    update_post_meta( $post_id, 'vendor-facebook', sanitize_text_field( $_POST[ 'vendor-facebook' ] ) );
  }

  // Checks for input and sanitizes/saves if needed
  if( isset( $_POST[ 'vendor-pinterest' ] ) ) {
    update_post_meta( $post_id, 'vendor-pinterest', sanitize_text_field( $_POST[ 'vendor-pinterest' ] ) );
  }

  // Checks for input and sanitizes/saves if needed
  if( isset( $_POST[ 'vendor-youtube' ] ) ) {
    update_post_meta( $post_id, 'vendor-youtube', sanitize_text_field( $_POST[ 'vendor-youtube' ] ) );
  }

  // Checks for input and sanitizes/saves if needed
  if( isset( $_POST[ 'vendor-twitter' ] ) ) {
    update_post_meta( $post_id, 'vendor-twitter', sanitize_text_field( $_POST[ 'vendor-twitter' ] ) );
  }

  // Checks for input and sanitizes/saves if needed
  if( isset( $_POST[ 'vendor-instagram' ] ) ) {
    update_post_meta( $post_id, 'vendor-instagram', sanitize_text_field( $_POST[ 'vendor-instagram' ] ) );
  }

  // Checks for input and sanitizes/saves if needed
  if( isset( $_POST[ 'vendor-video-type' ] ) ) {
    update_post_meta( $post_id, 'vendor-video-type', sanitize_text_field( $_POST[ 'vendor-video-type' ] ) );
  }

  // Checks for input and sanitizes/saves if needed
  if( isset( $_POST[ 'vendor-video-id' ] ) ) {
    update_post_meta( $post_id, 'vendor-video-id', sanitize_text_field( $_POST[ 'vendor-video-id' ] ) );
  }


  if(is_plugin_active( 'bridal-shows/bridal-shows.php')) { 
    $query = new WP_Query(
        array(
          'posts_per_page' => -1,
          'post_type' => 'bridal-shows',
          'post_status' => 'publish',
          'orderby' => 'title',
          'order' => 'ASC'
        )
    );
    if( $query->have_posts() ) { 
      while( $query->have_posts() ) { 
        $query->the_post();
        $loop_post_id = get_the_ID();
        $showId = 'bridal-show-'.$loop_post_id;
        // Checks for presence of checkbox value
        if( isset( $_POST[ $showId ] ) ) {
          update_post_meta( $post_id, $showId, 'yes' );
        } else {
          update_post_meta( $post_id, $showId, '' );
        }
      }
    }
    wp_reset_postdata();
  }
}
add_action( 'save_post', 'tb_meta_save' );
/**
 * Adds the meta box stylesheet when appropriate
 */
function tb_admin_styles(){
  global $typenow;
  if( $typenow == 'vendor' ) {
    wp_enqueue_style( 'tb_meta_box_styles', plugin_dir_url( __FILE__ ) . 'meta-box-styles.css' );
  }
}
add_action( 'admin_print_styles', 'tb_admin_styles' );
/**
 * Loads the image management javascript
 */
function tb_image_enqueue() {
  global $typenow;
  if( $typenow == 'vendor' ) {
    wp_enqueue_media();
 
    // Registers and enqueues the required javascript.
    wp_register_script( 'meta-box-image', plugin_dir_url( __FILE__ ) . 'meta-box-vendor-logo.js', array( 'jquery' ) );
    wp_localize_script( 'meta-box-image', 'meta_image',
      array(
        'title' => __( 'Choose or Upload an Image', 'tb-textdomain' ),
        'button' => __( 'Use this image', 'tb-textdomain' ),
      )
    );
    wp_enqueue_script( 'meta-box-image' );
  }
}
add_action( 'admin_enqueue_scripts', 'tb_image_enqueue' );





// ======================================================== //
// ======================================================== //
// ================ Thumbnail 1 Meta Box ================== //
// ======================================================== //
// ======================================================== //

function vendor_thumbnail_1_meta() {
  add_meta_box( 'vendor_thumbnail_1_meta', __( 'Thumbnail 1 Image', 'tb-textdomain' ), 'vendor_thumbnail_1_meta_callback', 'vendor' );
}
add_action( 'add_meta_boxes', 'vendor_thumbnail_1_meta' );

function vendor_thumbnail_1_meta_callback($post) {
  wp_nonce_field( basename( __FILE__ ), 'tb_nonce' );
  $tb_stored_meta = get_post_meta( $post->ID );
  ?>
  <div class="vendor-form">
    <div class="vendor-media-preview">
      <p>
        <label for="vendor-section-headline" class="tb-row-title"><?php _e( 'Section Headline', 'tb-textdomain' )?></label>
        <input type="text" name="vendor-section-headline" id="vendor-section-headline" value="<?php if ( isset ( $tb_stored_meta['vendor-section-headline'] ) ) { echo $tb_stored_meta['vendor-section-headline'][0]; } else { echo 'Check Us Out'; } ?>" />
      </p>
      <img id="vendor-thumbnail-1-img" src="<?php if(isset($tb_stored_meta['vendor-thumbnail-1-image'])) echo $tb_stored_meta['vendor-thumbnail-1-image'][0]; ?>" alt="" />
      <!-- Thumbnail 1 Link URL -->
      <p>
        <label for="vendor-thumbnail-1-link" class="tb-row-title"><?php _e( 'Thumbnail 1 Link URL', 'tb-textdomain' )?></label>
        <input type="text" name="vendor-thumbnail-1-link" id="vendor-thumbnail-1-link" value="<?php if ( isset ( $tb_stored_meta['vendor-thumbnail-1-link'] ) ) echo $tb_stored_meta['vendor-thumbnail-1-link'][0]; ?>" />
      </p>
      <!-- Thumbnail 1 Image Upload -->
      <p>
        <label for="vendor-thumbnail-1-image" class="tb-row-title"><?php _e( 'Thumbnail 1 Image', 'tb-textdomain' )?></label>
        <input type="button" id="vendor-thumbnail-1-image-button" class="button" value="<?php _e( 'Choose or Upload an Image', 'tb-textdomain' )?>" />
        <input id="vendor-thumbnail-1-image" name="vendor-thumbnail-1-image" type="hidden" value="<?php if ( isset ( $tb_stored_meta['vendor-thumbnail-1-image'] ) ) echo $tb_stored_meta['vendor-thumbnail-1-image'][0]; ?>" />
      </p>
      <p class="media-delete-btn" id="media-delete-btn-1">
        <input id="vendor-thumbnail-1-image-delete" type="button" class="button" value="<?php _e( 'Remove Image', 'tb-textdomain' )?>" />
      </p>
    </div>
  </div>
  <?php
}

function vendor_thumbnail_1_meta_save( $post_id ) {
 
  // Checks save status
  $is_autosave = wp_is_post_autosave( $post_id );
  $is_revision = wp_is_post_revision( $post_id );
  $is_valid_nonce = ( isset( $_POST[ 'tb_nonce' ] ) && wp_verify_nonce( $_POST[ 'tb_nonce' ], basename( __FILE__ ) ) ) ? 'true' : 'false';
 
  // Exits script depending on save status
  if ( $is_autosave || $is_revision || !$is_valid_nonce ) {
    return;
  }
 
  // Checks for input and sanitizes/saves if needed
  if( isset( $_POST[ 'vendor-section-headline' ] ) ) {
    update_post_meta( $post_id, 'vendor-section-headline', sanitize_text_field( $_POST[ 'vendor-section-headline' ] ) );
  }
 
  // Checks for input and sanitizes/saves if needed
  if( isset( $_POST[ 'vendor-thumbnail-1-link' ] ) ) {
    update_post_meta( $post_id, 'vendor-thumbnail-1-link', sanitize_text_field( $_POST[ 'vendor-thumbnail-1-link' ] ) );
  }

  // Checks for input and saves if needed
  if( isset( $_POST[ 'vendor-thumbnail-1-image' ] ) ) {
    update_post_meta( $post_id, 'vendor-thumbnail-1-image', $_POST[ 'vendor-thumbnail-1-image' ] );
  }

}
add_action( 'save_post', 'vendor_thumbnail_1_meta_save' );

/**
 * Loads the image management javascript
 */
function vendor_thumbnail_1_enqueue() {
  global $typenow;
  if( $typenow == 'vendor' ) {
    wp_enqueue_media();
 
    // Registers and enqueues the required javascript.
    wp_register_script( 'meta-box-1-image', plugin_dir_url( __FILE__ ) . 'meta-box-1-image.js', array( 'jquery' ) );
    wp_localize_script( 'meta-box-1-image', 'meta_image_1',
      array(
        'title' => __( 'Choose or Upload an Image', 'tb-textdomain' ),
        'button' => __( 'Use this image', 'tb-textdomain' ),
      )
    );
    wp_enqueue_script( 'meta-box-1-image' );
  }
}
add_action( 'admin_enqueue_scripts', 'vendor_thumbnail_1_enqueue' );







// ======================================================== //
// ======================================================== //
// ================ Thumbnail 2 Meta Box ================== //
// ======================================================== //
// ======================================================== //

function vendor_thumbnail_2_meta() {
  add_meta_box( 'vendor_thumbnail_2_meta', __( 'Thumbnail 2 Image', 'tb-textdomain' ), 'vendor_thumbnail_2_meta_callback', 'vendor' );
}
add_action( 'add_meta_boxes', 'vendor_thumbnail_2_meta' );

function vendor_thumbnail_2_meta_callback($post) {
  wp_nonce_field( basename( __FILE__ ), 'tb_nonce' );
  $tb_stored_meta = get_post_meta( $post->ID );
  ?>
  <div class="vendor-form">
    <div class="vendor-media-preview">
      <img id="vendor-thumbnail-2-img" src="<?php if(isset($tb_stored_meta['vendor-thumbnail-2-image'])) echo $tb_stored_meta['vendor-thumbnail-2-image'][0]; ?>" alt="" />
      <!-- Thumbnail 2 Link URL -->
      <p>
        <label for="vendor-thumbnail-2-link" class="tb-row-title"><?php _e( 'Thumbnail 2 Link URL', 'tb-textdomain' )?></label>
        <input type="text" name="vendor-thumbnail-2-link" id="vendor-thumbnail-2-link" value="<?php if ( isset ( $tb_stored_meta['vendor-thumbnail-2-link'] ) ) echo $tb_stored_meta['vendor-thumbnail-2-link'][0]; ?>" />
      </p>
      <!-- Thumbnail 2 Image Upload -->
      <p>
        <label for="vendor-thumbnail-2-image" class="tb-row-title"><?php _e( 'Thumbnail 2 Image', 'tb-textdomain' )?></label>
        <input type="button" id="vendor-thumbnail-2-image-button" class="button" value="<?php _e( 'Choose or Upload an Image', 'tb-textdomain' )?>" />
        <input id="vendor-thumbnail-2-image" name="vendor-thumbnail-2-image" type="hidden" value="<?php if ( isset ( $tb_stored_meta['vendor-thumbnail-2-image'] ) ) echo $tb_stored_meta['vendor-thumbnail-2-image'][0]; ?>" />
      </p>
      <p class="media-delete-btn" id="media-delete-btn-2">
        <input id="vendor-thumbnail-2-image-delete" type="button" class="button" value="<?php _e( 'Remove Image', 'tb-textdomain' )?>" />
      </p>
    </div>
  </div>
  <?php
}

function vendor_thumbnail_2_meta_save( $post_id ) {
 
  // Checks save status
  $is_autosave = wp_is_post_autosave( $post_id );
  $is_revision = wp_is_post_revision( $post_id );
  $is_valid_nonce = ( isset( $_POST[ 'tb_nonce' ] ) && wp_verify_nonce( $_POST[ 'tb_nonce' ], basename( __FILE__ ) ) ) ? 'true' : 'false';
 
  // Exits script depending on save status
  if ( $is_autosave || $is_revision || !$is_valid_nonce ) {
    return;
  }
 
  // Checks for input and sanitizes/saves if needed
  if( isset( $_POST[ 'vendor-thumbnail-2-link' ] ) ) {
    update_post_meta( $post_id, 'vendor-thumbnail-2-link', sanitize_text_field( $_POST[ 'vendor-thumbnail-2-link' ] ) );
  }

  // Checks for input and saves if needed
  if( isset( $_POST[ 'vendor-thumbnail-2-image' ] ) ) {
    update_post_meta( $post_id, 'vendor-thumbnail-2-image', $_POST[ 'vendor-thumbnail-2-image' ] );
  }

}
add_action( 'save_post', 'vendor_thumbnail_2_meta_save' );

/**
 * Loads the image management javascript
 */
function vendor_thumbnail_2_enqueue() {
  global $typenow;
  if( $typenow == 'vendor' ) {
    wp_enqueue_media();
 
    // Registers and enqueues the required javascript.
    wp_register_script( 'meta-box-2-image', plugin_dir_url( __FILE__ ) . 'meta-box-2-image.js', array( 'jquery' ) );
    wp_localize_script( 'meta-box-2-image', 'meta_image_2',
      array(
        'title' => __( 'Choose or Upload an Image', 'tb-textdomain' ),
        'button' => __( 'Use this image', 'tb-textdomain' ),
      )
    );
    wp_enqueue_script( 'meta-box-2-image' );
  }
}
add_action( 'admin_enqueue_scripts', 'vendor_thumbnail_2_enqueue' );




// ======================================================== //
// ======================================================== //
// ================ Thumbnail 3 Meta Box ================== //
// ======================================================== //
// ======================================================== //

function vendor_thumbnail_3_meta() {
  add_meta_box( 'vendor_thumbnail_3_meta', __( 'Thumbnail 3 Image', 'tb-textdomain' ), 'vendor_thumbnail_3_meta_callback', 'vendor' );
}
add_action( 'add_meta_boxes', 'vendor_thumbnail_3_meta' );

function vendor_thumbnail_3_meta_callback($post) {
  wp_nonce_field( basename( __FILE__ ), 'tb_nonce' );
  $tb_stored_meta = get_post_meta( $post->ID );
  ?>
  <div class="vendor-form">
    <div class="vendor-media-preview">
      <img id="vendor-thumbnail-3-img" src="<?php if(isset($tb_stored_meta['vendor-thumbnail-3-image'])) echo $tb_stored_meta['vendor-thumbnail-3-image'][0]; ?>" alt="" />
      <!-- Thumbnail 3 Link URL -->
      <p>
        <label for="vendor-thumbnail-3-link" class="tb-row-title"><?php _e( 'Thumbnail 3 Link URL', 'tb-textdomain' )?></label>
        <input type="text" name="vendor-thumbnail-3-link" id="vendor-thumbnail-3-link" value="<?php if ( isset ( $tb_stored_meta['vendor-thumbnail-3-link'] ) ) echo $tb_stored_meta['vendor-thumbnail-3-link'][0]; ?>" />
      </p>
      <!-- Thumbnail 3 Image Upload -->
      <p>
        <label for="vendor-thumbnail-3-image" class="tb-row-title"><?php _e( 'Thumbnail 3 Image', 'tb-textdomain' )?></label>
        <input type="button" id="vendor-thumbnail-3-image-button" class="button" value="<?php _e( 'Choose or Upload an Image', 'tb-textdomain' )?>" />
        <input id="vendor-thumbnail-3-image" name="vendor-thumbnail-3-image" type="hidden" value="<?php if ( isset ( $tb_stored_meta['vendor-thumbnail-3-image'] ) ) echo $tb_stored_meta['vendor-thumbnail-3-image'][0]; ?>" />
      </p>
      <p class="media-delete-btn" id="media-delete-btn-3">
        <input id="vendor-thumbnail-3-image-delete" type="button" class="button" value="<?php _e( 'Remove Image', 'tb-textdomain' )?>" />
      </p>
    </div>
  </div>
  <?php
}

function vendor_thumbnail_3_meta_save( $post_id ) {
 
  // Checks save status
  $is_autosave = wp_is_post_autosave( $post_id );
  $is_revision = wp_is_post_revision( $post_id );
  $is_valid_nonce = ( isset( $_POST[ 'tb_nonce' ] ) && wp_verify_nonce( $_POST[ 'tb_nonce' ], basename( __FILE__ ) ) ) ? 'true' : 'false';
 
  // Exits script depending on save status
  if ( $is_autosave || $is_revision || !$is_valid_nonce ) {
    return;
  }
 
  // Checks for input and sanitizes/saves if needed
  if( isset( $_POST[ 'vendor-thumbnail-3-link' ] ) ) {
    update_post_meta( $post_id, 'vendor-thumbnail-3-link', sanitize_text_field( $_POST[ 'vendor-thumbnail-3-link' ] ) );
  }

  // Checks for input and saves if needed
  if( isset( $_POST[ 'vendor-thumbnail-3-image' ] ) ) {
    update_post_meta( $post_id, 'vendor-thumbnail-3-image', $_POST[ 'vendor-thumbnail-3-image' ] );
  }

}
add_action( 'save_post', 'vendor_thumbnail_3_meta_save' );

/**
 * Loads the image management javascript
 */
function vendor_thumbnail_3_enqueue() {
  global $typenow;
  if( $typenow == 'vendor' ) {
    wp_enqueue_media();
 
    // Registers and enqueues the required javascript.
    wp_register_script( 'meta-box-3-image', plugin_dir_url( __FILE__ ) . 'meta-box-3-image.js', array( 'jquery' ) );
    wp_localize_script( 'meta-box-3-image', 'meta_image_3',
      array(
        'title' => __( 'Choose or Upload an Image', 'tb-textdomain' ),
        'button' => __( 'Use this image', 'tb-textdomain' ),
      )
    );
    wp_enqueue_script( 'meta-box-3-image' );
  }
}
add_action( 'admin_enqueue_scripts', 'vendor_thumbnail_3_enqueue' );






// ======================================================== //
// ======================================================== //
// ========== Vendor Content Section 1 Meta Box =========== //
// ======================================================== //
// ======================================================== //

function wysiwyg_meta_1() {
  add_meta_box( 'wysiwyg_meta_1', __( 'Content Section 1', 'tb-textdomain' ), 'wysiwyg_meta_1_callback', 'vendor' );
}
add_action( 'add_meta_boxes', 'wysiwyg_meta_1' );

function wysiwyg_meta_1_callback($post) {
  wp_nonce_field( basename( __FILE__ ), 'tb_nonce' );
  $tb_stored_meta = get_post_meta( $post->ID );

  if ( isset ( $tb_stored_meta['wysiwyg-meta-1'] ) ) {
    $content = $tb_stored_meta['wysiwyg-meta-1'][0];
  } else {
    $content = '';
  }
  $editor_id = 'wysiwyg-meta-1';
  wp_editor( $content, $editor_id );
}

function wysiwyg_meta_1_save( $post_id ) {
  // Checks save status
  $is_autosave = wp_is_post_autosave( $post_id );
  $is_revision = wp_is_post_revision( $post_id );
  $is_valid_nonce = ( isset( $_POST[ 'tb_nonce' ] ) && wp_verify_nonce( $_POST[ 'tb_nonce' ], basename( __FILE__ ) ) ) ? 'true' : 'false';
 
  // Exits script depending on save status
  if ( $is_autosave || $is_revision || !$is_valid_nonce ) {
    return;
  }
 
  // Checks for input and saves if needed
  if( isset( $_POST[ 'wysiwyg-meta-1' ] ) ) {
    update_post_meta( $post_id, 'wysiwyg-meta-1', $_POST[ 'wysiwyg-meta-1' ] );
  }
}
add_action( 'save_post', 'wysiwyg_meta_1_save' );






// ======================================================== //
// ======================================================== //
// ========== Vendor Content Section 2 Meta Box =========== //
// ======================================================== //
// ======================================================== //

function wysiwyg_meta_2() {
  add_meta_box( 'wysiwyg_meta_2', __( 'Content Section 2', 'tb-textdomain' ), 'wysiwyg_meta_2_callback', 'vendor' );
}
add_action( 'add_meta_boxes', 'wysiwyg_meta_2' );

function wysiwyg_meta_2_callback($post) {
  wp_nonce_field( basename( __FILE__ ), 'tb_nonce' );
  $tb_stored_meta = get_post_meta( $post->ID );

  if ( isset ( $tb_stored_meta['wysiwyg-meta-2'] ) ) {
    $content = $tb_stored_meta['wysiwyg-meta-2'][0];
  } else {
    $content = '';
  }
  $editor_id = 'wysiwyg-meta-2';
  wp_editor( $content, $editor_id );
}

function wysiwyg_meta_2_save( $post_id ) {
  // Checks save status
  $is_autosave = wp_is_post_autosave( $post_id );
  $is_revision = wp_is_post_revision( $post_id );
  $is_valid_nonce = ( isset( $_POST[ 'tb_nonce' ] ) && wp_verify_nonce( $_POST[ 'tb_nonce' ], basename( __FILE__ ) ) ) ? 'true' : 'false';
 
  // Exits script depending on save status
  if ( $is_autosave || $is_revision || !$is_valid_nonce ) {
    return;
  }
 
  // Checks for input and saves if needed
  if( isset( $_POST[ 'wysiwyg-meta-2' ] ) ) {
    update_post_meta( $post_id, 'wysiwyg-meta-2', $_POST[ 'wysiwyg-meta-2' ] );
  }
}
add_action( 'save_post', 'wysiwyg_meta_2_save' );





// ======================================================== //
// ======================================================== //
// ========== Vendor Content Section 3 Meta Box =========== //
// ======================================================== //
// ======================================================== //

function wysiwyg_meta_3() {
  add_meta_box( 'wysiwyg_meta_3', __( 'Content Section 3', 'tb-textdomain' ), 'wysiwyg_meta_3_callback', 'vendor' );
}
add_action( 'add_meta_boxes', 'wysiwyg_meta_3' );

function wysiwyg_meta_3_callback($post) {
  wp_nonce_field( basename( __FILE__ ), 'tb_nonce' );
  $tb_stored_meta = get_post_meta( $post->ID );

  if ( isset ( $tb_stored_meta['wysiwyg-meta-3'] ) ) {
    $content = $tb_stored_meta['wysiwyg-meta-3'][0];
  } else {
    $content = '';
  }
  $editor_id = 'wysiwyg-meta-3';
  wp_editor( $content, $editor_id );
}

function wysiwyg_meta_3_save( $post_id ) {
  // Checks save status
  $is_autosave = wp_is_post_autosave( $post_id );
  $is_revision = wp_is_post_revision( $post_id );
  $is_valid_nonce = ( isset( $_POST[ 'tb_nonce' ] ) && wp_verify_nonce( $_POST[ 'tb_nonce' ], basename( __FILE__ ) ) ) ? 'true' : 'false';
 
  // Exits script depending on save status
  if ( $is_autosave || $is_revision || !$is_valid_nonce ) {
    return;
  }
 
  // Checks for input and saves if needed
  if( isset( $_POST[ 'wysiwyg-meta-3' ] ) ) {
    update_post_meta( $post_id, 'wysiwyg-meta-3', $_POST[ 'wysiwyg-meta-3' ] );
  }
}
add_action( 'save_post', 'wysiwyg_meta_3_save' );





// ======================================================== //
// ======================================================== //
// =========== Vendor Image Gallery Meta Box =========== //
// ======================================================== //
// ======================================================== //

function gallery_meta() {
  add_meta_box( 'gallery_meta', __( 'Gallery Images', 'tb-textdomain' ), 'gallery_meta_callback', 'vendor' );
}
add_action( 'add_meta_boxes', 'gallery_meta' );

function gallery_meta_callback($post) {
  wp_nonce_field( basename( __FILE__ ), 'tb_nonce' );
  $tb_stored_meta = get_post_meta( $post->ID );

  if ( isset ( $tb_stored_meta['gallery-meta'] ) ) {
    $content = $tb_stored_meta['gallery-meta'][0];
  } else {
    $content = '';
  }
  $editor_id = 'gallery-meta';
  wp_editor( $content, $editor_id );
}

function gallery_meta_save( $post_id ) {
  // Checks save status
  $is_autosave = wp_is_post_autosave( $post_id );
  $is_revision = wp_is_post_revision( $post_id );
  $is_valid_nonce = ( isset( $_POST[ 'tb_nonce' ] ) && wp_verify_nonce( $_POST[ 'tb_nonce' ], basename( __FILE__ ) ) ) ? 'true' : 'false';
 
  // Exits script depending on save status
  if ( $is_autosave || $is_revision || !$is_valid_nonce ) {
    return;
  }
 
  // Checks for input and saves if needed
  if( isset( $_POST[ 'gallery-meta' ] ) ) {
    update_post_meta( $post_id, 'gallery-meta', $_POST[ 'gallery-meta' ] );
  }
}
add_action( 'save_post', 'gallery_meta_save' );






?>