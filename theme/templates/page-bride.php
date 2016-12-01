<?php
/*
Template Name: Bride Protected Page
*/
?>

<?php
  $user_roles = $current_user->roles;
  $user_role = array_shift($user_roles);
  $user_name = $current_user->user_nicename;

  //hide wordpress admin bar for users with the vendor role
  // if($user_role == "vendor") {
  //   show_admin_bar(false);
  //   remove_action( 'wp_head', '_admin_bar_bump_cb' );
  // }
  
  //if not a bride or admin, redirect to bride main page
  if ($user_role != "bride"  && $user_role != "administrator") {
    wp_redirect(home_url());
    exit;
  } else {
    //show content
?>

  <?php get_header(); ?>
  <div class="action-bar breadcrumbs">
      <div class="wrapper">
          <h3>
            <span class="alignleft">Welcome, <?php if($user_name) { echo $user_name; } else { echo 'Bride'; } ?>! </span>
            <?php wp_loginout(); ?></h3>
          <?php echo do_shortcode('[search-bar]'); ?>
      </div>
  </div>
  <div class="wrapper">
    <?php the_title('<h1>', '</h1>'); ?>
    <div class="main">
      <?php the_post(); ?>
      <?php the_content(); ?>
    </div>
    <div class="secondary">
      <div class="dashboard-items">
        <?php
          $vendorFilters = array(
            'post_type' => array(
              'vendor'
            )
          );
          $pageCount = get_user_favorites_count($user_id = null, $site_id = null, $vendorFilters);
          echo '<h2>Favorited Vendors <span>('.$pageCount.')</span></h2>';
          if($pageCount) {
            the_user_favorites_list($user_id = null, $site_id = null, $include_links = true, $filters = $vendorFilters);
          } else {
            echo '<p class="subtle-note">You have not favorited any vendor pages yet!</p>';
          }

          $postFilters = array(
            'post_type' => array(
              'post'
            )
          );
          $postCount = get_user_favorites_count($user_id = null, $site_id = null, $postFilters);
          echo '<h2>Favorited Posts <span>('.$postCount.')</span></h2>';
          if($postCount) {
            the_user_favorites_list($user_id = null, $site_id = null, $include_links = true, $filters = $postFilters);
          } else {
            echo '<p class="subtle-note">You have not favorited any blog posts or real weddings yet!</p>';
          }

          $pageFilters = array(
            'post_type' => array(
              'page'
            )
          );
          $pageCount = get_user_favorites_count($user_id = null, $site_id = null, $pageFilters);
          echo '<h2>Favorited Pages <span>('.$pageCount.')</span></h2>';
          if($pageCount) {
            the_user_favorites_list($user_id = null, $site_id = null, $include_links = true, $filters = $pageFilters);
          } else {
            echo '<p class="subtle-note">You have not favorited any of our pages yet!</p>';
          }

        ?>
      </div>
    </div>
  </div>
  <?php get_footer(); ?>

<?php
  }
?>