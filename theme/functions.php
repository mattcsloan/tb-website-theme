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
      'social-navigation' => __( 'Social Networking Links' ),
      'footer-navigation' => __( 'Footer Navigation' )
    )
  );
}
add_action( 'init', 'register_my_menus' );



//add support for image thumbnails on posts
add_theme_support('post-thumbnails'); 

add_image_size( 'large-feature', 700, 288, true );
add_image_size( 'small-feature', 500, 300 );
add_filter( 'image_size_names_choose', 'custom_image_sizes' );

function custom_image_sizes( $sizes ) {
    return array_merge( $sizes, array(
        'large-feature' => __( 'Large Feature' ),
        'small-feature' => __( 'Small Feature' )
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
  return '<div class="col">'.$content.'</div>';
}
add_shortcode("col", "col");


function checkList( $atts, $content = null ) {
    return '<div class="check-list">'.$content.'</div>';
}
add_shortcode("check-list", "checkList");


function inlineList( $atts, $content = null ) {
    return '<div class="dotted-list">'.$content.'</div>';
}
add_shortcode("inline-list", "inlineList");

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

    $buttonString =  '<a class="btn';
    if($addClass) {
      $buttonString .= $addClass;
    }
    $buttonString .= '" href="'.$link.'">'.$content.'</a>';
    return $buttonString;
}
add_shortcode("button", "button");

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

      $string .= '</table>';
      $string .= '</div>';
  }
  wp_reset_postdata();
  return $string;
}
add_shortcode( 'discount-card-vendors', 'discountCardVendors' );





//End Shortcodes

?>