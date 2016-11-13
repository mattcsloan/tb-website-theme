<?php 
/*Plugin Name: Bridal Show Listings
Description: Create Bridal Show event pages.
Version: 1.0.0
License: GPLv2
*/

function bridal_shows() {
  // set up labels
  $labels = array(
    'name' => 'Bridal Shows',
    'singular_name' => 'Bridal Show',
    'add_new' => 'Add New Show',
    'add_new_item' => 'Add New Show',
    'edit_item' => 'Edit Bridal Show',
    'new_item' => 'New Bridal Show',
    'all_items' => 'All Bridal Shows',
    'view_item' => 'View Bridal Show',
    'search_items' => 'Search Bridal Shows',
    'not_found' =>  'No Bridal Shows Found',
    'not_found_in_trash' => 'No Bridal Shows found in Trash', 
    'parent_item_colon' => '',
    'menu_name' => 'Bridal Shows',
  );

  //register post type
  register_post_type( 'bridal-shows', array(
    'labels' => $labels,
    'public' => true,
    'supports' => array( 'title', 'editor', 'thumbnail', 'page-attributes' ),
    'exclude_from_search' => false,
    'capability_type' => 'post',
    'hierarchical' => true,
    'has_archive' => false
  ));
}
add_action( 'init', 'bridal_shows' );

// ======================================================== //
// ======================================================== //
// ============== Bridal Show Info Meta Box =============== //
// ======================================================== //
// ======================================================== //
function tb_shows_meta() {
  add_meta_box( 'tb_shows_meta', __( 'Bridal Show Information', 'tb-textdomain' ), 'tb_shows_meta_callback', 'bridal-shows' );
}
add_action( 'add_meta_boxes', 'tb_shows_meta' );
/**
 * Outputs the content of the meta box
 */
function tb_shows_meta_callback( $post ) {
  wp_nonce_field( basename( __FILE__ ), 'tb_shows_nonce' );
  $tb_shows_stored_meta = get_post_meta( $post->ID );
  ?>
  <div class="tb-form">

    <!-- Simple Date -->
    <p class="tb-row-content">
      <label for="show-simple-date" class="tb-row-title">
        <?php _e( 'Simple Date', 'tb-textdomain' )?>
        <em class="description"> (Overlays Hero Image. Example: August 28th)</em>
      </label>
      <input type="text" name="show-simple-date" id="show-simple-date" value="<?php if ( isset ( $tb_shows_stored_meta['show-simple-date'] ) ) echo $tb_shows_stored_meta['show-simple-date'][0]; ?>" />
    </p>

    <!-- Simple Locations -->
    <p class="tb-row-content">
      <label for="show-simple-location" class="tb-row-title">
        <?php _e( 'Simple Location', 'tb-textdomain' )?>
        <em class="description"> (Overlays Hero Image. Example: John S. Knight Center - Akron)</em>
      </label>
      <input type="text" name="show-simple-location" id="show-simple-location" value="<?php if ( isset ( $tb_shows_stored_meta['show-simple-location'] ) ) echo $tb_shows_stored_meta['show-simple-location'][0]; ?>" />
    </p>

    <!-- Show Time -->
    <p class="tb-row-content">
      <label for="show-time" class="tb-row-title">
        <?php _e( 'Show Time', 'tb-textdomain' )?>
        <em class="description"> (Example: 5pm-8pm)</em>
      </label>
      <input type="text" name="show-time" id="show-time" value="<?php if ( isset ( $tb_shows_stored_meta['show-time'] ) ) echo $tb_shows_stored_meta['show-time'][0]; ?>" />
    </p>

    <!-- Full Date -->
    <p class="tb-row-content">
      <label for="show-full-date" class="tb-row-title">
        <?php _e( 'Full Date', 'tb-textdomain' )?>
        <em class="description"> (Example: Friday, August 28, 2016)</em>
      </label>
      <input type="text" name="show-full-date" id="show-full-date" value="<?php if ( isset ( $tb_shows_stored_meta['show-full-date'] ) ) echo $tb_shows_stored_meta['show-full-date'][0]; ?>" />
    </p>

    <!-- Full Location -->
    <p class="tb-row-content">
      <label for="show-full-location" class="tb-row-title">
        <?php _e( 'Full Location', 'tb-textdomain' )?>
        <em class="description">
          <br />
          Example:<br />
          Cleveland Marriott East<br />
          26300 Harvard Road<br />
          Warrensville Heights, OH 44122<br />
        </em>
      </label>
      <textarea name="show-full-location" id="show-full-location"><?php if ( isset ( $tb_shows_stored_meta['show-full-location'] ) ) echo $tb_shows_stored_meta['show-full-location'][0]; ?></textarea>
    </p>
  </div>


  <?php
}
/**
 * Saves the custom meta input
 */
function tb_shows_meta_save( $post_id ) {
 
  // Checks save status
  $is_autosave = wp_is_post_autosave( $post_id );
  $is_revision = wp_is_post_revision( $post_id );
  $is_valid_nonce = ( isset( $_POST[ 'tb_shows_nonce' ] ) && wp_verify_nonce( $_POST[ 'tb_shows_nonce' ], basename( __FILE__ ) ) ) ? 'true' : 'false';
 
  // Exits script depending on save status
  if ( $is_autosave || $is_revision || !$is_valid_nonce ) {
    return;
  }
 
  // Checks for input and sanitizes/saves if needed
  if( isset( $_POST[ 'show-simple-date' ] ) ) {
    update_post_meta( $post_id, 'show-simple-date', sanitize_text_field( $_POST[ 'show-simple-date' ] ) );
  }

  // Checks for input and sanitizes/saves if needed
  if( isset( $_POST[ 'show-simple-location' ] ) ) {
    update_post_meta( $post_id, 'show-simple-location', sanitize_text_field( $_POST[ 'show-simple-location' ] ) );
  }

  // Checks for input and sanitizes/saves if needed
  if( isset( $_POST[ 'show-time' ] ) ) {
    update_post_meta( $post_id, 'show-time', sanitize_text_field( $_POST[ 'show-time' ] ) );
  }

  // Checks for input and sanitizes/saves if needed
  if( isset( $_POST[ 'show-full-date' ] ) ) {
    update_post_meta( $post_id, 'show-full-date', sanitize_text_field( $_POST[ 'show-full-date' ] ) );
  }

  // Checks for input and sanitizes/saves if needed
  if( isset( $_POST[ 'show-full-location' ] ) ) {
    update_post_meta( $post_id, 'show-full-location', sanitize_text_field( $_POST[ 'show-full-location' ] ) );
  }
}
add_action( 'save_post', 'tb_shows_meta_save' );
/**
 * Adds the meta box stylesheet when appropriate
 */
function tb_shows_admin_styles(){
  global $typenow;
  if( $typenow == 'bridal-shows' ) {
    wp_enqueue_style( 'tb_meta_box_styles', plugin_dir_url( __FILE__ ) . 'meta-box-styles.css' );
  }
}
add_action( 'admin_print_styles', 'tb_shows_admin_styles' );


// ======================================================== //
// ======================================================== //
// === Additional Meta Box for Bridal Show Sponsors/Ads === //
// ======================================================== //
// ======================================================== //

function show_sponsors_ads() {
  add_meta_box( 'show_sponsors_ads', __( 'Show Sponsors and Advertisements', 'tb-textdomain' ), 'show_sponsors_ads_callback', 'bridal-shows' );
}
add_action( 'add_meta_boxes', 'show_sponsors_ads' );

function show_sponsors_ads_callback($post) {
  wp_nonce_field( basename( __FILE__ ), 'tb_nonce' );
  $tb_shows_stored_meta = get_post_meta( $post->ID );

  if ( isset ( $tb_shows_stored_meta['show-sponsor-meta'] ) ) {
    $content = $tb_shows_stored_meta['show-sponsor-meta'][0];
  } else {
    $content = '';
  }
  $editor_id = 'show-sponsor-meta';
  wp_editor( $content, $editor_id );
}

function show_sponsors_ads_save( $post_id ) {
  // Checks save status
  $is_autosave = wp_is_post_autosave( $post_id );
  $is_revision = wp_is_post_revision( $post_id );
  $is_valid_nonce = ( isset( $_POST[ 'tb_nonce' ] ) && wp_verify_nonce( $_POST[ 'tb_nonce' ], basename( __FILE__ ) ) ) ? 'true' : 'false';
 
  // Exits script depending on save status
  if ( $is_autosave || $is_revision || !$is_valid_nonce ) {
    return;
  }
 
  // Checks for input and saves if needed
  if( isset( $_POST[ 'show-sponsor-meta' ] ) ) {
    update_post_meta( $post_id, 'show-sponsor-meta', $_POST[ 'show-sponsor-meta' ] );
  }
}
add_action( 'save_post', 'show_sponsors_ads_save' );