<?php 
/*Plugin Name: Vendor Listings
Description: Add a list of vendors to your website and create individual vendor pages.
Version: 1.0
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
  ));
}
add_action( 'init', 'vendor_listings' );




// ======================================================== //
// ======================================================== //
// ================ Vendor Info Meta Box ================== //
// ======================================================== //
// ======================================================== //
function prfx_custom_meta() {
  add_meta_box( 'prfx_meta', __( 'Vendor Information', 'prfx-textdomain' ), 'prfx_meta_callback', 'vendor' );
}
add_action( 'add_meta_boxes', 'prfx_custom_meta' );
/**
 * Outputs the content of the meta box
 */
function prfx_meta_callback( $post ) {
  wp_nonce_field( basename( __FILE__ ), 'prfx_nonce' );
  $prfx_stored_meta = get_post_meta( $post->ID );
  ?>
  <div class="vendor-form">
    <!-- Vendor Tier -->
    <p>
      <span class="prfx-row-title"><?php _e( 'Vendor Tier', 'prfx-textdomain' )?></span>
      <div class="prfx-row-content">
        <label for="vendor-tier-signature">
          <input type="radio" name="vendor-tier" id="vendor-tier-signature" value="signature" <?php if ( isset ( $prfx_stored_meta['vendor-tier'] ) ) checked( $prfx_stored_meta['vendor-tier'][0], 'vendor-tier-signature' ); ?>>
          <?php _e( 'Signature', 'prfx-textdomain' )?>
        </label>
        <label for="vendor-tier-essentials">
          <input type="radio" name="vendor-tier" id="vendor-tier-essentials" value="essentials" <?php if ( isset ( $prfx_stored_meta['vendor-tier'] ) ) checked( $prfx_stored_meta['vendor-tier'][0], 'vendor-tier-essentials' ); ?>>
          <?php _e( 'Essentials', 'prfx-textdomain' )?>
        </label>
        <label for="vendor-tier-classic">
          <input type="radio" name="vendor-tier" id="vendor-tier-classic" value="classic" <?php if ( isset ( $prfx_stored_meta['vendor-tier'] ) ) checked( $prfx_stored_meta['vendor-tier'][0], 'vendor-tier-classic' ); ?>>
          <?php _e( 'Classic', 'prfx-textdomain' )?>
        </label>
        <label for="vendor-tier-basic">
          <input type="radio" name="vendor-tier" id="vendor-tier-basic" value="basic" <?php if ( isset ( $prfx_stored_meta['vendor-tier'] ) ) checked( $prfx_stored_meta['vendor-tier'][0], 'vendor-tier-basic' ); ?>>
          <?php _e( 'Basic', 'prfx-textdomain' )?>
        </label>
      </div>
    </p>

    <!-- Vendor Logo -->
    <p class="prfx-row-content">
      <img id="vendor-logo-img" src="<?php if ( isset ( $prfx_stored_meta['vendor-logo'] ) ) echo $prfx_stored_meta['vendor-logo'][0]; ?>" alt="" />
      <label for="vendor-logo" class="prfx-row-title"><?php _e( 'Vendor Logo', 'prfx-textdomain' )?></label>
      <input type="button" id="vendor-logo-button" class="image-upload-button button" value="<?php _e( 'Choose or Upload an Image', 'prfx-textdomain' )?>" />
      <input id="vendor-logo" name="vendor-logo" type="hidden" value="<?php if ( isset ( $prfx_stored_meta['vendor-logo'] ) ) echo $prfx_stored_meta['vendor-logo'][0]; ?>" />
    </p>

    <!-- Vendor Locations -->
    <p class="prfx-row-content">
      <label for="vendor-locations" class="prfx-row-title"><?php _e( 'Vendor Location', 'prfx-textdomain' )?></label>
      <input type="text" name="vendor-locations" id="vendor-locations" value="<?php if ( isset ( $prfx_stored_meta['vendor-locations'] ) ) echo $prfx_stored_meta['vendor-locations'][0]; ?>" />
    </p>

    <!-- Vendor Website Link -->
    <p class="prfx-row-content">
      <label for="vendor-website-link" class="prfx-row-title">
        <?php _e( 'Vendor Website Link', 'prfx-textdomain' )?>
        <em class="description"> (Please include 'http://' or 'https://' in link)</em>
      </label>
      <input type="text" name="vendor-website-link" id="vendor-website-link" value="<?php if ( isset ( $prfx_stored_meta['vendor-website-link'] ) ) echo $prfx_stored_meta['vendor-website-link'][0]; ?>" />
    </p>

    <!-- Vendor Phone Number -->
    <p class="prfx-row-content">
      <label for="vendor-phone-number" class="prfx-row-title"><?php _e( 'Vendor Phone Number', 'prfx-textdomain' )?></label>
      <input type="text" name="vendor-phone-number" id="vendor-phone-number" value="<?php if ( isset ( $prfx_stored_meta['vendor-phone-number'] ) ) echo $prfx_stored_meta['vendor-phone-number'][0]; ?>" />
    </p>

    <!-- Vendor Testimonial -->
    <p class="prfx-row-content">
      <label for="vendor-testimonial" class="prfx-row-title"><?php _e( 'Vendor Testimonial', 'prfx-textdomain' )?></label>
      <textarea name="meta-vendor-testimonial" id="vendor-testimonial"><?php if ( isset ( $prfx_stored_meta['vendor-testimonial'] ) ) echo $prfx_stored_meta['vendor-testimonial'][0]; ?></textarea>
    </p>

    <h3>Vendor Social Links</h3>
    <!-- Vendor Facebook -->
    <p>
      <label for="vendor-facebook" class="prfx-row-title"><?php _e( 'Vendor Facebook URL', 'prfx-textdomain' )?></label>
      <input type="text" name="vendor-facebook" id="vendor-facebook" value="<?php if ( isset ( $prfx_stored_meta['vendor-facebook'] ) ) echo $prfx_stored_meta['vendor-facebook'][0]; ?>" />
    </p>
    <!-- Vendor Pinterest -->
    <p>
      <label for="vendor-pinterest" class="prfx-row-title"><?php _e( 'Vendor Pinterest URL', 'prfx-textdomain' )?></label>
      <input type="text" name="vendor-pinterest" id="vendor-pinterest" value="<?php if ( isset ( $prfx_stored_meta['vendor-pinterest'] ) ) echo $prfx_stored_meta['vendor-pinterest'][0]; ?>" />
    </p>
    <!-- Vendor YouTube -->
    <p>
      <label for="vendor-youtube" class="prfx-row-title"><?php _e( 'Vendor YouTube URL', 'prfx-textdomain' )?></label>
      <input type="text" name="vendor-youtube" id="vendor-youtube" value="<?php if ( isset ( $prfx_stored_meta['vendor-youtube'] ) ) echo $prfx_stored_meta['vendor-youtube'][0]; ?>" />
    </p>
    <!-- Vendor Twitter -->
    <p>
      <label for="vendor-twitter" class="prfx-row-title"><?php _e( 'Vendor Twitter URL', 'prfx-textdomain' )?></label>
      <input type="text" name="vendor-twitter" id="vendor-twitter" value="<?php if ( isset ( $prfx_stored_meta['vendor-twitter'] ) ) echo $prfx_stored_meta['vendor-twitter'][0]; ?>" />
    </p>
    <!-- Vendor Facebook -->
    <p>
      <label for="vendor-instagram" class="prfx-row-title"><?php _e( 'Vendor Instagram URL', 'prfx-textdomain' )?></label>
      <input type="text" name="vendor-instagram" id="vendor-instagram" value="<?php if ( isset ( $prfx_stored_meta['vendor-instagram'] ) ) echo $prfx_stored_meta['vendor-instagram'][0]; ?>" />
    </p>
  </div>


  <?php
}
/**
 * Saves the custom meta input
 */
function prfx_meta_save( $post_id ) {
 
  // Checks save status
  $is_autosave = wp_is_post_autosave( $post_id );
  $is_revision = wp_is_post_revision( $post_id );
  $is_valid_nonce = ( isset( $_POST[ 'prfx_nonce' ] ) && wp_verify_nonce( $_POST[ 'prfx_nonce' ], basename( __FILE__ ) ) ) ? 'true' : 'false';
 
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
  if( isset( $_POST[ 'vendor-locations' ] ) ) {
    update_post_meta( $post_id, 'vendor-locations', sanitize_text_field( $_POST[ 'vendor-locations' ] ) );
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
}
add_action( 'save_post', 'prfx_meta_save' );
/**
 * Adds the meta box stylesheet when appropriate
 */
function prfx_admin_styles(){
  global $typenow;
  if( $typenow == 'vendor' ) {
    wp_enqueue_style( 'prfx_meta_box_styles', plugin_dir_url( __FILE__ ) . 'meta-box-styles.css' );
  }
}
add_action( 'admin_print_styles', 'prfx_admin_styles' );
/**
 * Loads the image management javascript
 */
function prfx_image_enqueue() {
  global $typenow;
  if( $typenow == 'vendor' ) {
    wp_enqueue_media();
 
    // Registers and enqueues the required javascript.
    wp_register_script( 'meta-box-image', plugin_dir_url( __FILE__ ) . 'meta-box-image.js', array( 'jquery' ) );
    wp_localize_script( 'meta-box-image', 'meta_image',
      array(
        'title' => __( 'Choose or Upload an Image', 'prfx-textdomain' ),
        'button' => __( 'Use this image', 'prfx-textdomain' ),
      )
    );
    wp_enqueue_script( 'meta-box-image' );
  }
}
add_action( 'admin_enqueue_scripts', 'prfx_image_enqueue' );





// ======================================================== //
// ======================================================== //
// ================ Thumbnail 1 Meta Box ================== //
// ======================================================== //
// ======================================================== //

function vendor_thumbnail_1_meta() {
  add_meta_box( 'vendor_thumbnail_1_meta', __( 'Thumbnail 1 Image', 'prfx-textdomain' ), 'vendor_thumbnail_1_meta_callback', 'vendor' );
}
add_action( 'add_meta_boxes', 'vendor_thumbnail_1_meta' );

function vendor_thumbnail_1_meta_callback($post) {
  wp_nonce_field( basename( __FILE__ ), 'prfx_nonce' );
  $prfx_stored_meta = get_post_meta( $post->ID );
  ?>
  <div class="vendor-form">
    <img id="vendor-thumbnail-1-img" src="<?php if(isset($prfx_stored_meta['vendor-thumbnail-1-image'])) echo $prfx_stored_meta['vendor-thumbnail-1-image'][0]; ?>" alt="" />
    <!-- Thumbnail 1 Link URL -->
    <p>
      <label for="vendor-thumbnail-1-link" class="prfx-row-title"><?php _e( 'Thumbnail 1 Link URL', 'prfx-textdomain' )?></label>
      <input type="text" name="vendor-thumbnail-1-link" id="vendor-thumbnail-1-link" value="<?php if ( isset ( $prfx_stored_meta['vendor-thumbnail-1-link'] ) ) echo $prfx_stored_meta['vendor-thumbnail-1-link'][0]; ?>" />
    </p>
    <!-- Thumbnail 1 Image Upload -->
    <p>
      <label for="vendor-thumbnail-1-image" class="prfx-row-title"><?php _e( 'Thumbnail 1 Image', 'prfx-textdomain' )?></label>
      <input type="button" id="vendor-thumbnail-1-image-button" class="button" value="<?php _e( 'Choose or Upload an Image', 'prfx-textdomain' )?>" />
      <input id="vendor-thumbnail-1-image" name="vendor-thumbnail-1-image" type="hidden" value="<?php if ( isset ( $prfx_stored_meta['vendor-thumbnail-1-image'] ) ) echo $prfx_stored_meta['vendor-thumbnail-1-image'][0]; ?>" />
    </p>
  </div>
  <?php
}

function vendor_thumbnail_1_meta_save( $post_id ) {
 
  // Checks save status
  $is_autosave = wp_is_post_autosave( $post_id );
  $is_revision = wp_is_post_revision( $post_id );
  $is_valid_nonce = ( isset( $_POST[ 'prfx_nonce' ] ) && wp_verify_nonce( $_POST[ 'prfx_nonce' ], basename( __FILE__ ) ) ) ? 'true' : 'false';
 
  // Exits script depending on save status
  if ( $is_autosave || $is_revision || !$is_valid_nonce ) {
    return;
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
        'title' => __( 'Choose or Upload an Image', 'prfx-textdomain' ),
        'button' => __( 'Use this image', 'prfx-textdomain' ),
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
  add_meta_box( 'vendor_thumbnail_2_meta', __( 'Thumbnail 2 Image', 'prfx-textdomain' ), 'vendor_thumbnail_2_meta_callback', 'vendor' );
}
add_action( 'add_meta_boxes', 'vendor_thumbnail_2_meta' );

function vendor_thumbnail_2_meta_callback($post) {
  wp_nonce_field( basename( __FILE__ ), 'prfx_nonce' );
  $prfx_stored_meta = get_post_meta( $post->ID );
  ?>
  <div class="vendor-form">
    <img id="vendor-thumbnail-2-img" src="<?php if(isset($prfx_stored_meta['vendor-thumbnail-2-image'])) echo $prfx_stored_meta['vendor-thumbnail-2-image'][0]; ?>" alt="" />
    <!-- Thumbnail 2 Link URL -->
    <p>
      <label for="vendor-thumbnail-2-link" class="prfx-row-title"><?php _e( 'Thumbnail 2 Link URL', 'prfx-textdomain' )?></label>
      <input type="text" name="vendor-thumbnail-2-link" id="vendor-thumbnail-2-link" value="<?php if ( isset ( $prfx_stored_meta['vendor-thumbnail-2-link'] ) ) echo $prfx_stored_meta['vendor-thumbnail-2-link'][0]; ?>" />
    </p>
    <!-- Thumbnail 2 Image Upload -->
    <p>
      <label for="vendor-thumbnail-2-image" class="prfx-row-title"><?php _e( 'Thumbnail 2 Image', 'prfx-textdomain' )?></label>
      <input type="button" id="vendor-thumbnail-2-image-button" class="button" value="<?php _e( 'Choose or Upload an Image', 'prfx-textdomain' )?>" />
      <input id="vendor-thumbnail-2-image" name="vendor-thumbnail-2-image" type="hidden" value="<?php if ( isset ( $prfx_stored_meta['vendor-thumbnail-2-image'] ) ) echo $prfx_stored_meta['vendor-thumbnail-2-image'][0]; ?>" />
    </p>
  </div>
  <?php
}

function vendor_thumbnail_2_meta_save( $post_id ) {
 
  // Checks save status
  $is_autosave = wp_is_post_autosave( $post_id );
  $is_revision = wp_is_post_revision( $post_id );
  $is_valid_nonce = ( isset( $_POST[ 'prfx_nonce' ] ) && wp_verify_nonce( $_POST[ 'prfx_nonce' ], basename( __FILE__ ) ) ) ? 'true' : 'false';
 
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
        'title' => __( 'Choose or Upload an Image', 'prfx-textdomain' ),
        'button' => __( 'Use this image', 'prfx-textdomain' ),
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
  add_meta_box( 'vendor_thumbnail_3_meta', __( 'Thumbnail 3 Image', 'prfx-textdomain' ), 'vendor_thumbnail_3_meta_callback', 'vendor' );
}
add_action( 'add_meta_boxes', 'vendor_thumbnail_3_meta' );

function vendor_thumbnail_3_meta_callback($post) {
  wp_nonce_field( basename( __FILE__ ), 'prfx_nonce' );
  $prfx_stored_meta = get_post_meta( $post->ID );
  ?>
  <div class="vendor-form">
    <img id="vendor-thumbnail-3-img" src="<?php if(isset($prfx_stored_meta['vendor-thumbnail-3-image'])) echo $prfx_stored_meta['vendor-thumbnail-3-image'][0]; ?>" alt="" />
    <!-- Thumbnail 3 Link URL -->
    <p>
      <label for="vendor-thumbnail-3-link" class="prfx-row-title"><?php _e( 'Thumbnail 3 Link URL', 'prfx-textdomain' )?></label>
      <input type="text" name="vendor-thumbnail-3-link" id="vendor-thumbnail-3-link" value="<?php if ( isset ( $prfx_stored_meta['vendor-thumbnail-3-link'] ) ) echo $prfx_stored_meta['vendor-thumbnail-3-link'][0]; ?>" />
    </p>
    <!-- Thumbnail 3 Image Upload -->
    <p>
      <label for="vendor-thumbnail-3-image" class="prfx-row-title"><?php _e( 'Thumbnail 3 Image', 'prfx-textdomain' )?></label>
      <input type="button" id="vendor-thumbnail-3-image-button" class="button" value="<?php _e( 'Choose or Upload an Image', 'prfx-textdomain' )?>" />
      <input id="vendor-thumbnail-3-image" name="vendor-thumbnail-3-image" type="hidden" value="<?php if ( isset ( $prfx_stored_meta['vendor-thumbnail-3-image'] ) ) echo $prfx_stored_meta['vendor-thumbnail-3-image'][0]; ?>" />
    </p>
  </div>
  <?php
}

function vendor_thumbnail_3_meta_save( $post_id ) {
 
  // Checks save status
  $is_autosave = wp_is_post_autosave( $post_id );
  $is_revision = wp_is_post_revision( $post_id );
  $is_valid_nonce = ( isset( $_POST[ 'prfx_nonce' ] ) && wp_verify_nonce( $_POST[ 'prfx_nonce' ], basename( __FILE__ ) ) ) ? 'true' : 'false';
 
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
        'title' => __( 'Choose or Upload an Image', 'prfx-textdomain' ),
        'button' => __( 'Use this image', 'prfx-textdomain' ),
      )
    );
    wp_enqueue_script( 'meta-box-3-image' );
  }
}
add_action( 'admin_enqueue_scripts', 'vendor_thumbnail_3_enqueue' );
?>