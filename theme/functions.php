<?php

//Load jQuery and all external scripts
// function load_my_scripts() {
//     wp_enqueue_script('jquery');
//     $templatedir = get_bloginfo('template_directory');
//     wp_register_script('myscript', $templatedir.'/scripts/interaction.js', array('jquery'), '', true);
//     wp_enqueue_script('myscript');
// }
// add_action('init', 'load_my_scripts');

// Make Wordpress Admin content area use theme stylesheet
add_editor_style('style.css');

/**
 * Registers an editor stylesheet for the current theme.
 */
function add_editor_styles() {
    $font_url = str_replace( ',', '%2C', '//fonts.googleapis.com/css?family=Montserrat:400,700' );
    add_editor_style( $font_url );
}
add_action( 'after_setup_theme', 'add_editor_styles' );


// Get the page number
function get_page_number() {
    if ( get_query_var('paged') ) {
        print ' | ' . __( 'Page ' , 'TB2017') . get_query_var('paged');
    }
} // end get_page_number



//Set the length (in number of words) for the_excerpt
function custom_excerpt_length( $length ) {
  return 35; //35 words
}
add_filter('excerpt_length', 'custom_excerpt_length', 999);



// add more link to excerpt
function custom_excerpt_more($more) {
global $post;
// return ' <a href="'. get_permalink($post->ID) . '">Read&nbsp;More</a>';
return ' ...';
}
add_filter('excerpt_more', 'custom_excerpt_more');


// only show parent category in URL (blog or realweddings)
function remove_child_categories_from_permalinks( $category ) {
    while ( $category->parent ) {
        $category = get_term( $category->parent, 'category' );
    }

    return $category;
}
add_filter( 'post_link_category', 'remove_child_categories_from_permalinks' );


//prevent Wordpress from wrapping loose images in a p tag
function filter_ptags_on_images($content){
   return preg_replace('/<p>\s*(<a .*>)?\s*(<img .* \/>)\s*(<\/a>)?\s*<\/p>/iU', '\1\2\3', $content);
}
add_filter('the_content', 'filter_ptags_on_images');



// Register widgetized areas
function theme_widgets_init() {
    // Area 1
    register_sidebar( array (
        'name'          => 'Primary Widget Area',
        'id'            => 'primary_widget_area',
        'before_widget' => '<div>',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ) );
    // Area 2
//    register_sidebar( array (
//        'name'          => 'Secondary Widget Area',
//        'id'            => 'secondary_widget_area',
//        'before_widget' => '<div class="secondary_nav dark">',
//        'after_widget'  => '</div>',
//        'before_title'  => '<h3 class="secondary_nav_title">',
//        'after_title'   => '<span> Menu</span></h3>',
//    ) );
} // end theme_widgets_init
add_action( 'init', 'theme_widgets_init' );



//pre-set our default widgets
$preset_widgets = array (
    'primary_widget_area'   => array( 'search', 'pages', 'categories', 'archives' ),
//    'secondary_widget_area' => array( 'links', 'meta' )
);
if ( isset( $_GET['activated'] ) ) {
    update_option( 'sidebars_widgets', $preset_widgets );
}
// update_option( 'sidebars_widgets', NULL );



// Check for static widgets in widget-ready areas
function is_sidebar_active( $index ){
    global $wp_registered_sidebars;
 
    $widgetcolums = wp_get_sidebars_widgets();
 
    if ( $widgetcolums[$index] ) return true;
 
    return false;
} // end is_sidebar_active



//create support for menus
function register_my_menus() {
  register_nav_menus(
    array(
      'main-navigation' => __( 'Main Navigation' ),
      'social-navigation' => __( 'Social Networking Links' ),
      'footer-navigation' => __( 'Footer Navigation' )
    )
  );
}
add_action( 'init', 'register_my_menus' );



//add support for image thumbnails on posts
add_theme_support('post-thumbnails'); 

add_image_size( 'large-feature', 700, 509, true );
add_image_size( 'small-feature', 500, 300 );
add_image_size( 'large-square', 500, 500, true );
add_filter( 'image_size_names_choose', 'custom_image_sizes' );

function custom_image_sizes( $sizes ) {
    return array_merge( $sizes, array(
        'large-feature' => __( 'Large Feature' ),
        'small-feature' => __( 'Small Feature' ),
        'large-square' => __( 'Large Square' ),
        'vendor-feature' => __( 'Vendor Feature' )
    ) );
}

//Remove width and height attributes from thumbnail images
add_filter( 'post_thumbnail_html', 'remove_thumbnail_dimensions', 10 );
add_filter( 'image_send_to_editor', 'remove_thumbnail_dimensions', 10 );
function remove_thumbnail_dimensions( $html ) {
    $html = preg_replace( '/(width|height)=\"\d*\"\s/', "", $html );
    return $html;
}

//Custom Comments
function customComments($comment, $args, $depth) {
    $isByAuthor = false;

    if($comment->comment_author_email == get_the_author_meta('email')) {
        $isByAuthor = true;
    }

    $GLOBALS['comment'] = $comment; ?>
    <div class="comment-level">
      <div id="comment-<?php comment_ID(); ?>" class="comment<?php if($isByAuthor){ echo ' author';}?>">
        <?php echo get_avatar( $comment->comment_author_email, 64 ); ?>
        <div class="comment-info">
          <span class="article_date"><?php echo get_comment_date('F j, Y g:i a'); ?></span>
          <?php printf(__('<h3>%s</h3>'), get_comment_author()) ?>
          <?php if ($comment->comment_approved == '0') : ?>
              <?php _e('Your comment is awaiting moderation.<em>') ?></em>
          <?php endif; ?>
          <?php comment_text() ?>
          <p><?php edit_comment_link(__('(Edit) | '),'  ','') ?><?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?></p>
        </div>
      </div>
     </div>
<?php
}

//Remove website url field from comments form
// function remove_comment_url_fields($fields) {
//     if(isset($fields['url']))
//     {
//          unset($fields['url']);
//     }
//     return $fields;
// }
// add_filter('comment_form_default_fields','remove_comment_url_fields');

//Add a rel="nofollow" to the comment reply links
function add_nofollow_to_reply_link( $link ) {
    return str_replace( '")\'>', '")\' rel=\'nofollow\'>', $link );
}
add_filter( 'comment_reply_link', 'add_nofollow_to_reply_link' );

//Add classes to previous and next post links (pagination)
add_filter('next_posts_link_attributes', 'posts_link_attributes');
add_filter('previous_posts_link_attributes', 'posts_link_attributes');

function posts_link_attributes() {
    return 'class="btn btn-light strong"';
}

add_filter('next_post_link', 'post_link_attributes');
add_filter('previous_post_link', 'post_link_attributes');

function post_link_attributes($output) {
    $code = 'class="btn btn-light strong"';
    return str_replace('<a href=', '<a '.$code.' href=', $output);
}

//Add sidebar
add_action( 'widgets_init', 'add_widget_area' );
function add_widget_area() {
    register_sidebar( array(
        'name' => __( 'Blog Sidebar', 'TB2017' ),
        'id' => 'blog-sidebar',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="mod-title">',
        'after_title'   => '</h3>',
        'description' => __( 'Sidebar to show on blog page.', 'TB2017' )
    ) );
    register_sidebar( array(
        'name' => __( 'More Articles', 'TB2017' ),
        'id' => 'more-articles',
        'before_widget' => '<div id="%1$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<label>',
        'after_title'   => '</label>',
        'description' => __( 'More Articles module to hold category and archive widgets', 'TB2017' )
    ) );
}

//breadcrumb creation
function breadcrumbs() {
  global $post;
  if(is_front_page() || is_attachment()) {
    //don't include breadcrumbs on home page  
  } else {
    echo '<div class="breadcrumbs"><ul class="wrapper">';
  }

    if (!is_front_page() && !is_attachment()) {
    //get the blog page url
    $posts_page_id = get_option('page_for_posts');
    $posts_page = get_page($posts_page_id);
    $posts_page_title = $posts_page->post_title;
    if(get_option('show_on_front') == 'page') {
      $posts_page_url = get_permalink($posts_page_id);
    }
        echo '<li><a href="';
        echo get_option('home');
        echo '">';
        echo 'Home';
        echo '</a> &raquo; </li>';
    if (is_home()) {
      echo"<li>".$posts_page_title."</li>";
    } elseif (is_category() || is_single()) {
      $category = get_the_category();
      $catLink = get_category_link($category[0]->cat_ID);
      if (is_single()) {
        if(in_category('Blog')) {
          foreach (get_the_category() as $cat) {
            $self = $cat->cat_ID;
            $self_URL = get_category_link($self);
            $parent = get_category($cat->category_parent);
            $parent_name = $parent->cat_name;
            $parent_URL = get_category_link($parent->cat_ID);
            if($parent_name == "Blog") {
              echo '<li><a href="'.$posts_page_url.'">'.$posts_page_title.'</a> &raquo; </li>';
              echo '<li><a href="'.$self_URL.'">'.$cat->cat_name.'</a> &raquo; </li>';
            }
          }
          echo '<li>'.the_title().'</li>';
        }
      } else { // its a category page
        foreach (get_the_category() as $cat) {
          $self = $cat->cat_ID;
          $self_URL = get_category_link($self);
          $parent = get_category($cat->category_parent);
          $parent_name = $parent->cat_name;
          $parent_URL = get_category_link($parent->cat_ID);
          if($parent_name == "Blog") {
            echo '<li><a href="'.$posts_page_url.'">'.$posts_page_title.'</a> &raquo; </li>';
            echo '<li>'.$cat->cat_name.'</li>';
          }
        }
      }
        } elseif (is_page()) {
            if($post->post_parent){
                $anc = get_post_ancestors( $post->ID );
        $anc = array_reverse($anc);
                $title = get_the_title();
                foreach ( $anc as $ancestor ) {
          $output .= '<li><a href="'.get_permalink($ancestor).'" title="'.get_the_title($ancestor).'">'.get_the_title($ancestor).'</a> &raquo; </li>';
                }
                echo $output;
                echo $title;
            } else {
                echo the_title();
            }
        }
    elseif (is_tag()) {single_tag_title();}
    elseif (is_day()) {echo"<li>Archive for "; the_time('F jS, Y'); echo'</li>';}
    elseif (is_month()) {echo"<li>Archive for "; the_time('F, Y'); echo'</li>';}
    elseif (is_year()) {echo"<li>Archive for "; the_time('Y'); echo'</li>';}
    elseif (is_author()) {echo"<li>Posts by "; the_author(); echo'</li>';}
    elseif (isset($_GET['paged']) && !empty($_GET['paged'])) {echo "<li>Blog Archives"; echo'</li>';}
    elseif (is_search()) {echo"<li>Search Results"; echo'</li>';}
    elseif (is_404()) {echo"<li>Page Not Found"; echo'</li>';}
    }
    echo '</ul></div>';
}

//Prevent <p> and <br> tags from being added to posts
// remove_filter( 'the_content', 'wpautop' );
// remove_filter( 'the_excerpt', 'wpautop' );
// if (is_page('Home')) {
//  remove_filter('the_content', 'wpautop');
// }

// prevent wordpress from adding <p> and <br> tags from editor
remove_filter( 'the_content', 'wpautop' ); 
$br = false;
// add <p> tags from editor back in
add_filter( 'the_content', function( $content ) use ( $br ) {  
    return wpautop( $content, $br ); 
}, 10 );

// REMOVE WP EMOJI
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');

remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
remove_action( 'admin_print_styles', 'print_emoji_styles' );

// For tag lists on tag archives: Returns other tags except the current one (redundant)
// function tag_ur_it($glue) {
//     $current_tag = single_tag_title( '', '',  false );
//     $separator = "n";
//     $tags = explode( $separator, get_the_tag_list( "", "$separator", "" ) );
//     foreach ( $tags as $i => $str ) {
//         if ( strstr( $str, ">$current_tag<" ) ) {
//             unset($tags[$i]);
//             break;
//         }
//     }
//     if ( empty($tags) )
//         return false;
 
//     return trim(join( $glue, $tags ));
// } // end tag_ur_it


//Use a different single file for posts that have a "Vendors" category set
// function get_custom_cat_template($single_template) {
//      global $post;
 
//        if ( in_category('news') || in_category('press-release')) {
//           $single_template = dirname( __FILE__ ) . '/single-news.php';
//      }
//      return $single_template;
// }
// add_filter( "single_template", "get_custom_cat_template" ) ;

//change login page logo and link
function my_login_logo() { 
  $logoUrl = get_stylesheet_directory_uri() . '/img/logo.jpg';
  ?>
    <style type="text/css">

        body.login
        {
          background: #fff;
        }

        #login h1 a {
          background-image: url(<?php echo $logoUrl ?>);
          width: 280px;
          height: 80px;
          background-size: 100%;
        }
    
        body.login div#login form#loginform p.submit input#wp-submit {
          background: #ec008c;
          border-color: #bd0070;
          text-shadow: none;
          box-shadow: 0 1px 0 #bd0070;
        }
        
        body.login div#login form#loginform input#user_login:focus, body.login div#login form#loginform input#user_pass:focus {
          box-shadow: 0 0 2px rgba(0,0,0,0.4);
          padding: 4px;
          border-color: #999;
          color: #555;
        }
        
        body.login div#login a:hover {
          color: #ec008c;
        }
    </style>
<?php }
add_action( 'login_enqueue_scripts', 'my_login_logo' );

function my_login_logo_url() {
    return home_url();
}
add_filter( 'login_headerurl', 'my_login_logo_url' );

//Adding additional form fields to a User's profile
function additional_profile_fields($profile_fields) {
  // Add new fields
  $profile_fields['vendorweeklyleads'] = 'Weekly Leads';
  $profile_fields['vendorshowleadsAKR'] = 'Show Leads - Akron';
  $profile_fields['vendorshowleadsCLE'] = 'Show Leads - Cleveland';
  $profile_fields['bride-type'] = 'He/She is the';
  $profile_fields['reception-city'] = 'Reception City';
  $profile_fields['bride-address'] = 'Address';
  $profile_fields['bride-city'] = 'City';
  $profile_fields['bride-state'] = 'State';
  $profile_fields['bride-zip'] = 'Zip Code';
  $profile_fields['bride-phone'] = 'Phone Number';

  return $profile_fields;
}
add_filter('user_contactmethods', 'additional_profile_fields');

// Additional Columns to show on Users listing page (admin)
function new_modify_user_table( $column ) {
    $column['vendorweeklyleads'] = 'Weekly Leads';
    $column['vendorshowleadsAKR'] = 'Show Leads - Akron';
    $column['vendorshowleadsCLE'] = 'Show Leads - Cleveland';
    return $column;
}
add_filter( 'manage_users_columns', 'new_modify_user_table' );

function new_modify_user_table_row( $val, $column_name, $user_id ) {
    switch ($column_name) {
        case 'vendorweeklyleads' :
            return get_the_author_meta( 'vendorweeklyleads', $user_id );
            break;
        case 'vendorshowleadsAKR' :
            return get_the_author_meta( 'vendorshowleadsAKR', $user_id );
            break;
        case 'vendorshowleadsCLE' :
            return get_the_author_meta( 'vendorshowleadsCLE', $user_id );
            break;
        default:
    }
    return $val;
}
add_filter( 'manage_users_custom_column', 'new_modify_user_table_row', 10, 3 );

//Add New Meta Box for Vendor
add_action( 'add_meta_boxes', 'vendor_leads_add' );
function vendor_leads_add()
{
  foreach (array('page') as $type)
  {
      add_meta_box( 'vendor-leads', 'Vendor Leads', 'vendor_leads_render', $type, 'side' );
  }
}

//Render Meta Box for Vendor Leads in Wordpress interface
function vendor_leads_render()
{
    // $post is already set, and contains an object: the WordPress post
    global $post;
    $values = get_post_custom( $post->ID );
     
    // We'll use this nonce field later on when saving.
    wp_nonce_field( 'vendor_leads_nonce', 'vendor_leads_nonce' );
?>
    <style type="text/css">    
    #vendor-leads em
    {
      font-size: 11px;
      display: block;
      margin-top: 6px;
      color: #666;  
    }
  </style>
    <p>
        <input type="checkbox" id="vendor_weekly_leads" name="vendor_weekly_leads" value="yes" <?php if ( isset ( $values['vendor_weekly_leads'] ) ) checked( $values['vendor_weekly_leads'][0], 'yes' ); ?> />
        <label for="vendor_weekly_leads" style="display: inline; width: auto;">Weekly Leads Page</label>
    </p>
    <p>
        <input type="checkbox" id="vendor_show_leads_akron" name="vendor_show_leads_akron" value="yes" <?php if ( isset ( $values['vendor_show_leads_akron'] ) ) checked( $values['vendor_show_leads_akron'][0], 'yes' ); ?> />
        <label for="vendor_show_leads_akron" style="display: inline; width: auto;">Show Leads Page (Akron)</label>
    </p>
    <p>
        <input type="checkbox" id="vendor_show_leads_cleveland" name="vendor_show_leads_cleveland" value="yes" <?php if ( isset ( $values['vendor_show_leads_cleveland'] ) ) checked( $values['vendor_show_leads_cleveland'][0], 'yes' ); ?> />
        <label for="vendor_show_leads_cleveland" style="display: inline; width: auto;">Show Leads Page (Cleveland)</label>
    </p>
    <p><em><strong>Note:</strong> Only users that have this option selected in their User profile will be able to view this page</em></p>
<?php   
}

//Save Meta Box for Vendor Leads Module to Database
add_action( 'save_post', 'vendor_leads_save' );
function vendor_leads_save( $post_id )
{
    // Bail if we're doing an auto save
    if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
     
    // if our nonce isn't there, or we can't verify it, bail
    if(!wp_verify_nonce( $_POST['vendor_leads_nonce'], 'vendor_leads_nonce' ) ) return;
     
    // if our current user can't edit this post, bail
    if( !current_user_can( 'edit_post', $post_id ) ) return;
     
    // now we can actually save the data
    $allowed = array(
        'a' => array( // on allow a tags
            'href' => array() // and those anchors can only have href attribute
        )
    );
     
    // Checks for presence of checkbox value
    if( isset( $_POST[ 'vendor_weekly_leads' ] ) ) {
      update_post_meta( $post_id, 'vendor_weekly_leads', 'yes' );
    } else {
      update_post_meta( $post_id, 'vendor_weekly_leads', '' );
    }

    // Checks for presence of checkbox value
    if( isset( $_POST[ 'vendor_show_leads_akron' ] ) ) {
      update_post_meta( $post_id, 'vendor_show_leads_akron', 'yes' );
    } else {
      update_post_meta( $post_id, 'vendor_show_leads_akron', '' );
    }

    // Checks for presence of checkbox value
    if( isset( $_POST[ 'vendor_show_leads_cleveland' ] ) ) {
      update_post_meta( $post_id, 'vendor_show_leads_cleveland', 'yes' );
    } else {
      update_post_meta( $post_id, 'vendor_show_leads_cleveland', '' );
    }

}


// exclude any content from search results that use specific page templates
function exclude_page_templates_from_search($query) {
  global $wp_the_query;
  if ( ($wp_the_query === $query) && (is_search()) && ( ! is_admin()) ) {

    $meta_query = array(
      'relation' => 'OR',
      // remove pages with foo.php template from results
      array(
        array(
          'key' => '_wp_page_template',
          'value' => 'templates/page-bride.php',
          'compare' => '!='
        ),
        array(
          'key' => '_wp_page_template',
          'value' => 'templates/page-vendor-protected.php',
          'compare' => '!='
        )
      ),
      // show all entries that do not have a key '_wp_page_template'
      array(
        'key' => '_wp_page_template',
        'compare' => 'NOT EXISTS'
      )
    );
    $query->set('meta_query', $meta_query);
  }
}
add_filter('pre_get_posts','exclude_page_templates_from_search');

// add_action( 'ninja_forms_display_after_fields', 'custom_extra_value' );
// function custom_extra_value(){
//   global $ninja_forms_loading;
//   if($ninja_forms_loading->get_form_ID() == 5) {
//   }
// }

// add vendor email to Ninja Form - Vendor Quote Request
// add_action( 'ninja_forms_field', 'ninja_forms_change_to_address' );
// function ninja_forms_change_to_address(){
//   global $ninja_forms_loading;
//   if($ninja_forms_loading->get_form_ID() == 5) {
//     <input type="text" name="tester" value="TEST">
//     // $user_email = $ninja_forms_processing->get_field_value( 120 ); //hidden field that passes the vendor email
//     // $ninja_forms_loading->update_field_value( 120, 'sloan.782@gmail.com' );
//   }
// }

// add_filter( 'ninja_forms_render_default_value', 'my_change_nf_default_value' );
// function my_change_nf_default_value( $default_value, $field_type, $field_settings ) {
//   if( 'textbox' == $field_type ){
//     $default_value = 'foo';
//   }
//   return $default_value;
// }
// add_filter( 'ninja_forms_submit_data', 'my_ninja_forms_submit_data' );
// function my_ninja_forms_submit_data( $form_data ) {
//   foreach( $form_data[ 'fields' ] as $field ) { // Field settigns, including the field key and value.
//    if( 125 !== $field[ 'key' ] ) continue; // Check the field key to see if this is the field that I need to update.
//     $field[ 'value' ] = 'foo'; // Update the submitted field value.
//   }
//   $form_settings = $form_data[ 'settings' ]; // Form settings.
//   $extra_data = $form_data[ 'extra' ]; // Extra data included with the submission.
//   return $form_data;
// }
// add_filter( 'ninja_forms_render_default_value', 'my_change_nf_default_value' );
// function my_change_nf_default_value( $default_value, $field_type, $field_settings ) {

  // if( 'textbox' == $field_type ){
  //   $default_value = 'foo';
  // }
//   return $default_value;
// }

// add_filter( 'ninja_forms_field', 'wpm_handle_http_query_string' );
// function wpm_handle_http_query_string( $data ) {
  
//     if($data['label']=='Vendor Email') {
//       $data['default_value'] = 'test';
//     }
//     return $data;
// }
// function ninja_forms_change_to_address($form_id) {
//   global $ninja_forms_loading;
//   global $ninja_forms_processing;
//   if($ninja_forms_processing->get_form_ID() == 5) {
//     $form_field_id = 124; //hidden field that passes the vendor email
//     //Change the value that a field is pre-populated with.
//     $ninja_forms_loading->update_field_value($form_field_id, 'sloan.782@gmail.com');
//   }
// }

// add_action('ninja_forms_display_init', 'ninja_forms_change_to_address');

add_action( 'ninja_forms_after_submission', 'nf_create_new_user' );
function nf_create_new_user( $form_data ){


    $form_id = $form_data[ 'form_id' ];

    // If form ID is the one we want
    if( $form_id == 2 ){

      // Load up the fields we have for this form
      $form_fields = $form_data[ 'fields' ];
    
      // Set up variables based on form values - change the numbers below based on field IDs
      $bride_type = $form_fields[ "7" ]["value"];
      $reception_city = $form_fields[ "8" ]["value"];
      $first_name = $form_fields[ "9" ]["value"];
      $last_name = $form_fields[ "10" ]["value"];
      $u_email = $form_fields[ "11" ]["value"];
      $username = $form_fields[ "437" ]["value"];
      $password = $form_fields[ "435" ]["value"];
      $bride_address = $form_fields[ "14" ]["value"];
      $bride_city = $form_fields[ "15" ]["value"];
      $bride_state = $form_fields[ "16" ]["value"];
      $bride_zip = $form_fields[ "17" ]["value"];
      $bride_phone = $form_fields[ "19" ]["value"];
      
      // Create an array of the user data - check out the available user fields for left hand side here: https://codex.wordpress.org/Function_Reference/wp_insert_user
      $userdata = array(
        'bride-type'      =>  $bride_type,
        'reception-city'  =>  $reception_city,
        'first_name'      =>  $first_name,
        'last_name'       =>  $last_name,
        'user_email'      =>  $u_email,
        'user_login'      =>  $username,
        'user_pass'       =>  $password,
        'bride-address'   =>  $bride_address,
        'bride-city'      =>  $bride_city,
        'bride-state'     =>  $bride_state,
        'bride-zip'       =>  $bride_zip,
        'bride-phone'     =>  $bride_phone,
        'role'            =>  'bride'
      );
  
      // Create the user and remember the user id
      $user_id = wp_insert_user( $userdata ) ;
      
      //On success
      // if ( ! is_wp_error( $user_id ) ) {
      //   echo "User created : ". $user_id;
      // } else {
      //   echo 'No user created.';
      // }

      // Use the user id to log in straight away
      wp_set_auth_cookie( $user_id, true );
  
    }
}

add_action( 'init', 'blockusers_init' );
function blockusers_init() {
  if ( is_admin() && ! current_user_can( 'administrator' ) && ! ( defined( 'DOING_AJAX' ) && DOING_AJAX ) ) {
    wp_redirect( home_url() );
    exit;
  }
}

//Begin Shortcodes
function columns( $atts, $content = null ) {
  $columns = substr_count( $content, '[col' );
  if(!$columns || $columns <= 0 || $columns == 1) {
    $col_class = "";
  } else if($columns == 2) {
    $col_class = " two-wide";
  } else if($columns == 3) {
    $col_class = " three-wide";
  } else if($columns == 4 || $columns > 6) {
    $col_class = " four-wide";
  } else if($columns == 5) {
    $col_class = " five-wide";
  } else if($columns == 6) {
    $col_class = " six-wide";
  }
  return '<div class="columns'.$col_class.'">'.do_shortcode($content).'</div>';
}
add_shortcode("columns", "columns");

function col( $atts, $content = null ) {
  return '<div class="col">'.do_shortcode($content).'</div>';
}
add_shortcode("col", "col");


function checkList( $atts, $content = null ) {
    return '<div class="check-list">'.do_shortcode($content).'</div>';
}
add_shortcode("check-list", "checkList");


function inlineList( $atts, $content = null ) {
    return '<div class="dotted-list">'.do_shortcode($content).'</div>';
}
add_shortcode("inline-list", "inlineList");

function breakTag( $atts, $content = null ) {
    return '<br>';
}
add_shortcode("br", "breakTag");

function actionItems( $atts, $content = null ) {
    return '<div class="action-items">'.do_shortcode($content).'</div>';
}
add_shortcode("action-items", "actionItems");

function tbGrid( $atts, $content = null ) {
    extract(shortcode_atts(array(
        "type" => ''
    ), $atts));

    $gridString = '<div class="grid';

    if($type == 'goodies') {
      $gridString .= ' goodies';
    }

    $gridString .= '">' . do_shortcode($content) . '</div>';

    return $gridString;
}
add_shortcode("tb-grid", "tbGrid");

function tbGridItem( $atts, $content = null ) {
    extract(shortcode_atts(array(
        "image" => '',
        "title" => ''
    ), $atts));

    $gridItemString = '<div class="item">';

    if($image !== '') {
      $gridItemString .= '<img src="' . $image . '" alt="' . $title . '" />';
    }

    if($title !== '') {
      $gridItemString .= '<h4>' . $title . '</h4>';
    }

    $gridItemString .= do_shortcode($content);

    $gridItemString .= '</div>';

    return $gridItemString;
}
add_shortcode("tb-grid-item", "tbGridItem");

// function search_bar() {
//   return get_search_form();
// }
// add_shortcode( 'search-bar', 'search_bar' );

function searchBar( $atts, $content = null ) {
    extract(shortcode_atts(array(
        "placeholder" => 'Search'
    ), $atts));


    $url = get_site_url();
    $searchBar = '<form class="searchform search-bar" role="search" method="get" id="searchform" class="searchform" action="' . $url . '">';
    $searchBar .= '<input type="text" value="" name="s" placeholder="' . $placeholder . '" id="s" />';
    $searchBar .= '<input type="submit" id="searchsubmit" value="Go" />';
    $searchBar .= '</form>';
    return $searchBar;
}
add_shortcode("search-bar", "searchBar");

function button($atts, $content = null) {
    extract(shortcode_atts(array(
        "link" => '#',
        "color" => 'pink',
        "border" => '',
        "size" => 'normal'
    ), $atts));

    $addClass = '';
    if($color == 'gray') {
      $addClass .= ' btn-secondary';
    } else if($color == 'white') {
      $addClass .= ' btn-light';
    }

    if($border == 'yes') {
      $addClass .= ' strong';
    }

    if($size == 'large') {
      $addClass .= ' btn-large';
    }

    if($size == 'full') {
      $addClass .= ' btn-full';
    }

    $buttonString =  '<a class="btn';
    if($addClass) {
      $buttonString .= $addClass;
    }
    $buttonString .= '" href="'.$link.'">'.do_shortcode($content).'</a>';
    return $buttonString;
}
add_shortcode("button", "button");

function advertisement($atts, $content = null) {
    extract(shortcode_atts(array(
        "link" => '',
        "external" => false
    ), $atts));

    $adString = '';

    if($link) {
      $adString .= '<a class="advertisement" href="'.$link.'"';
      if($external) {
        $adString .= ' target="_blank"';
      }
      $adString .= '>';
    } else {
      $adString .= '<span class="advertisement">';
    }

    $adString .= do_shortcode($content);

    if($link) {
      $adString .= '</a>';
    } else {
      $adString .= '</span>';
    }

    return $adString;
}
add_shortcode("advertisement", "advertisement");

function section($atts, $content = null) {
    extract(shortcode_atts(array(
        "size" => 'normal',   // options: normal, full
        "color" => 'white',   // options: white, gray
        "type" => 'standard' // options: standard, action-bar
    ), $atts));

    $sectionString = '';

    if($type == 'action-bar') {
      $sectionString .= '<div class="action-bar">';
        $sectionString .= '<div class="wrapper">';
    } else {
      $sectionString .= '<div class="section';
      if($color == 'gray') {
        $sectionString .= ' muted';
      }
      $sectionString .= '">';
      if($size !== 'full') {
        $sectionString .= '<div class="wrapper">';
      }
    }

    $sectionString .= do_shortcode($content);

    if($type == 'action-bar' || $size == 'normal') {
      $sectionString .= '</div>'; // end wrapper
      $sectionString .= '</div>'; // end action-bar/section
    } else {
      $sectionString .= '</div>'; // end section
    }

    return $sectionString;
}
add_shortcode("section", "section");

function vendorSpotlight($atts, $content = null) {
    extract(shortcode_atts(array(
        "heading" => 'Vendor Spotlight',
        "vendor" => '',
        "image" => '',
        "link" => ''
    ), $atts));

    $spotlight = '<div class="wrapper">';

    if($image !== '') {
      $spotlight .= '<div class="card"><img src="'.$image.'" alt="'.$heading.'" />';
    } else {
      $spotlight .= '<div class="card full">';
    }

    $spotlight .= '<div class="card-content">';
    $spotlight .= '<h2>'.$heading.'</h2>';

    if($vendor !== '') {
      $spotlight .= '<h4>'.$vendor.'</h4>';
    } 

    $spotlight .= '<p>'.do_shortcode($content).'</p>';

    if($link !== '') {
      $spotlight .= '<a href="'.$link.'">Learn More &raquo;</a>';
    } 

    $spotlight .= '</div>';
    $spotlight .= '</div>';
    $spotlight .= '</div>';

    return $spotlight;
}
add_shortcode("vendor-spotlight", "vendorSpotlight");

function tbGallery( $atts, $content = null ) {
    return '<div class="gallery">'.do_shortcode($content).'</div>';
}
add_shortcode("tb-gallery", "tbGallery");

function galleryPrimary( $atts, $content = null ) {
    return '<div class="primary">'.do_shortcode($content).'</div>';
}
add_shortcode("gallery-primary", "galleryPrimary");

function gallerySecondary( $atts, $content = null ) {
    return '<div class="secondary sponsors">'.do_shortcode($content).'</div>';
}
add_shortcode("gallery-secondary", "gallerySecondary");

function galleryItem($atts, $content = null) {
    extract(shortcode_atts(array(
        "link" => '',
        "title" => ''
    ), $atts));

    if($link !== '') {
      $galleryItem = '<a class="item" href="' . $link . '">';
    } else {
      $galleryItem = '<div class="item">';
    }

    if($title !== '') {
      $galleryItem .= '<span>' . $title . '</span>';
    }

    $galleryItem .= do_shortcode($content);

    if($link !== '') {
      $galleryItem .= '</a>';
    } else {
      $galleryItem .= '</div>';
    }

    return $galleryItem;
}
add_shortcode("tb-gallery-item", "galleryItem");

//For Discount Card Page
function discountCardVendors(){
  $args = array(
      'posts_per_page' => -1,
      'post_type' => 'vendor',
      'post_status' => 'publish',
      'orderby' => 'title',
      'order' => 'ASC'
  );

  $string = '';
  $query = new WP_Query( $args );
  if( $query->have_posts() ){
      $string .= '<div class="discount-card-list">';
      $string .= '<table>';
      $string .= '<tr>';
      $string .= '<th>Company</th>';
      $string .= '<th>Website</th>';
      $string .= '<th>Phone Number</th>';
      $string .= '</tr>';
      $displayNames = [];
      while( $query->have_posts() ){
          $query->the_post();
          $post_id = get_the_ID();
          $vendorDiscountCard = get_post_meta( $post_id, 'vendor-discount-card', true );
          $vendorDisplayName = get_post_meta( $post_id, 'vendor-display-name', true );
          $vendorWebsiteLink = get_post_meta( $post_id, 'vendor-website-link', true );
          $vendorPhoneNumber = get_post_meta( $post_id, 'vendor-phone-number', true );
          if(!$vendorDisplayName) {
            $vendorDisplayName = get_the_title();
          }

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
          if($vendorDiscountCard == 'yes' && !$expiredVendor) {
            if (!in_array($vendorDisplayName, $displayNames)) {
              $string .= '<tr>';
                $string .= '<td><a href="' . get_the_permalink() . '">' . $vendorDisplayName . '</a></td>';
                if($vendorWebsiteLink) {
                $string .= '<td><a href="' . $vendorWebsiteLink . '">Website</a></td>';
                } else {
                  $string .= '<td></td>';
                }
                if($vendorPhoneNumber) {
                  $string .= '<td>' . $vendorPhoneNumber . '</td>';
                } else {
                  $string .= '<td></td>';
                }
              $string .= '</tr>';
            }
          }
          $displayNames[] = $vendorDisplayName;
      }

      $string .= '</table>';
      $string .= '</div>';
  }
  wp_reset_postdata();
  return $string;
}
add_shortcode( 'discount-card-vendors', 'discountCardVendors' );

//For Pickup Location Page
function pickupLocationList(){
  $args = array(
      'posts_per_page' => -1,
      'post_type' => 'vendor',
      'post_status' => 'publish',
      'orderby' => 'title',
      'order' => 'ASC'
  );

  $string = '';
  $query = new WP_Query( $args );
  if( $query->have_posts() ){
      $string .= '<div class="pickup-location-list">';
      $string .= '<table>';
      $string .= '<tr>';
      $string .= '<th>Company</th>';
      $string .= '<th>Phone Number</th>';
      $string .= '</tr>';
      while( $query->have_posts() ){
          $query->the_post();
          $post_id = get_the_ID();
          $vendorPickupLocation = get_post_meta( $post_id, 'vendor-pickup-location', true );
          $vendorDisplayName = get_post_meta( $post_id, 'vendor-display-name', true );
          $vendorPhoneNumber = get_post_meta( $post_id, 'vendor-phone-number', true );


          if(!$vendorDisplayName) {
            $vendorDisplayName = get_the_title();
          }
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
          if($vendorPickupLocation == 'yes' && !$expiredVendor) {
            $string .= '<tr>';
              $string .= '<td><a href="' . get_the_permalink() . '">' . $vendorDisplayName . '</a></td>';
              if($vendorPhoneNumber) {
                $string .= '<td>' . $vendorPhoneNumber . '</td>';
              } else {
                $string .= '<td></td>';
              }
            $string .= '</tr>';
          }
      }

      $string .= '</table>';
      $string .= '</div>';
  }
  wp_reset_postdata();
  return $string;
}
add_shortcode( 'pickup-locations', 'pickupLocationList' );

// Remove empty paragraph tags from all shortcode contents
function remove_p_tag_shortcodes( $content ) {
  $array = array(
    '<p>['    => '[',
    ']</p>'   => ']',
    ']<br />' => ']'
  );
  return strtr( $content, $array );
}
add_filter( 'the_content', 'remove_p_tag_shortcodes' );

//End Shortcodes

?>