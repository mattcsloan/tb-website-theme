<?php 
/*Plugin Name: Vendor Listings
Description: Add a list of vendors to your website and create individual vendor pages.
Version: 1.0
License: GPLv2
*/

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
    'supports' => array( 'title', 'editor', 'custom-fields', 'thumbnail','page-attributes' ),
    'taxonomies' => array( 'post_tag', 'category' ), 
    'exclude_from_search' => false,
    'capability_type' => 'post',
    'hierarchical' => true,
    'rewrite' => array( 'slug' => 'vendors' ),
  ));
}
add_action( 'init', 'vendor_listings' );
?>