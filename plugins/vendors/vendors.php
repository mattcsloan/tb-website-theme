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
  register_taxonomy( 'vendorcat', 'vendor', array(
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
    'supports' => array( 'title', 'editor', 'custom-fields', 'thumbnail','page-attributes' ),
    'taxonomies' => array( 'vendorcat' ), 
    'exclude_from_search' => false,
    'capability_type' => 'post',
    'hierarchical' => true,
    'rewrite' => array( 'slug' => 'vendors' ),
  ));
}
add_action( 'init', 'vendor_listings' );


function add_vendor_meta_boxes() {

  function vendor_img_widget_1() {

    wp_nonce_field(plugin_basename(__FILE__), 'vendor_img_widget_1_nonce');
     
    $html = '<p class="description">';
        $html .= 'Upload an image. Supported file types are jpg/jpeg, png, or gif.';
    $html .= '</p>';
    $html .= '<input type="file" id="vendor_img_widget_1" name="vendor_img_widget_1" value="" size="25" />';
     
    echo $html;

  }



  function save_custom_meta_data($id) {
   
    /* --- security verification --- */
    if(!wp_verify_nonce($_POST['vendor_img_widget_1_nonce'], plugin_basename(__FILE__))) {
      return $id;
    } // end if
       
    if(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
      return $id;
    } // end if
       
    if('page' == $_POST['post_type']) {
      if(!current_user_can('edit_page', $id)) {
        return $id;
      } // end if
    } else {
        if(!current_user_can('edit_page', $id)) {
            return $id;
        } // end if
    } // end if
    /* - end security verification - */
       
    // Make sure the file array isn't empty
    if(!empty($_FILES['vendor_img_widget_1']['name'])) {
         
      // Setup the array of supported file types. In this case, it's just PDF.
      $supported_types = array('image/jpeg', 'image/png', 'image/gif');
       
      // Get the file type of the upload
      $arr_file_type = wp_check_filetype(basename($_FILES['vendor_img_widget_1']['name']));
      $uploaded_type = $arr_file_type['type'];
       
      // Check if the type is supported. If not, throw an error.
      if(in_array($uploaded_type, $supported_types)) {

          // Use the WordPress API to upload the file
          $upload = wp_handle_upload($_FILES['vendor_img_widget_1']['name'], null, file_get_contents($_FILES['vendor_img_widget_1']['tmp_name']));
   
          if(isset($upload['error']) && $upload['error'] != 0) {
              wp_die('There was an error uploading your file. The error is: ' . $upload['error']);
          } else {
              add_post_meta($id, 'vendor_img_widget_1', $upload);
              update_post_meta($id, 'vendor_img_widget_1', $upload);     
          } // end if/else

      } else {
          wp_die("The file type that you've uploaded is not supported.");
      } // end if/else
         
    } // end if
  } // end save_custom_meta_data
  add_action('save_post', 'save_custom_meta_data');

  // function update_edit_form() {
  //   echo ' enctype="multipart/form-data"';
  // } // end update_edit_form
  // add_action('post_edit_form_tag', 'update_edit_form');

  // Define the custom attachment for vendor post type
  add_meta_box(
    'vendor_img_widget_1', //id
    'Vendor Image Widget', // label
    'vendor_img_widget_1', // callback
    'vendor', // post type
    'normal' // location
  );
}
add_action('add_meta_boxes', 'add_vendor_meta_boxes');
?>