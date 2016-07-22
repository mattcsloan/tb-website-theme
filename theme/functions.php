<?php

//Load jQuery and all external scripts
// function load_my_scripts() {
//     wp_enqueue_script('jquery');
//     $templatedir = get_bloginfo('template_directory');
//     wp_register_script('myscript', $templatedir.'/scripts/interaction.js', array('jquery'), '', true);
//     wp_enqueue_script('myscript');
// }
// add_action('init', 'load_my_scripts');



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
return ' <a href="'. get_permalink($post->ID) . '">Read&nbsp;More</a>';
// return ' ...';
}
add_filter('excerpt_more', 'custom_excerpt_more');



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
      'secondary-navigation' => __( 'Secondary Navigation' ),
      'tertiary-navigation' => __( 'Tertiary Navigation' ),
      'footer-navigation' => __( 'Footer Navigation' )
    )
  );
}
add_action( 'init', 'register_my_menus' );



//add support for image thumbnails on posts
add_theme_support('post-thumbnails'); 



//Remove width and height attributes from thumbnail images
add_filter( 'post_thumbnail_html', 'remove_thumbnail_dimensions', 10 );
add_filter( 'image_send_to_editor', 'remove_thumbnail_dimensions', 10 );
function remove_thumbnail_dimensions( $html ) {
    $html = preg_replace( '/(width|height)=\"\d*\"\s/', "", $html );
    return $html;
}



//Remove website url field from comments form
function remove_comment_url_fields($fields) {
    if(isset($fields['url']))
    {
         unset($fields['url']);
    }
    return $fields;
}
add_filter('comment_form_default_fields','remove_comment_url_fields');

//Add a rel="nofollow" to the comment reply links
function add_nofollow_to_reply_link( $link ) {
    return str_replace( '")\'>', '")\' rel=\'nofollow\'>', $link );
}
add_filter( 'comment_reply_link', 'add_nofollow_to_reply_link' );



//Prevent <p> and <br> tags from being added to posts
//remove_filter( 'the_content', 'wpautop' );
//remove_filter( 'the_excerpt', 'wpautop' );
//if (is_page('Home')) {
//  remove_filter('the_content', 'wpautop');
//}



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



//Custom Comments



//Use a different single file for posts that have a "Vendors" category set
// function get_custom_cat_template($single_template) {
//      global $post;
 
//        if ( in_category('news') || in_category('press-release')) {
//           $single_template = dirname( __FILE__ ) . '/single-news.php';
//      }
//      return $single_template;
// }
// add_filter( "single_template", "get_custom_cat_template" ) ;



?>