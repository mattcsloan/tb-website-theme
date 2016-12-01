<?php
/*
Template Name: Vendor Protected Page
*/
?>


<?php
  $user_roles = $current_user->roles;
  $user_role = array_shift($user_roles);

  //hide wordpress admin bar for users with the vendor role
  // if($user_role == "vendor") {
  //   show_admin_bar(false);
  //   remove_action( 'wp_head', '_admin_bar_bump_cb' );
  // }
  
  //if not a partner or admin, redirect to partner main page
  if ($user_role != "vendor"  && $user_role != "administrator") {
    wp_redirect(home_url());
    exit;
  } else {
    //show content
?>
      <?php get_header(); ?>

      <div class="action-bar breadcrumbs">
          <div class="wrapper">
            <h3>Vendor Portal</h3>
            <div class="login-out">
              <?php
                if (is_user_logged_in() && ($user_role == "vendor"  || $user_role == "administrator")) {
                  global $current_user;
                  get_currentuserinfo();
                  echo "<span>Welcome, " . $current_user->display_name . "!</span>"; 
                }
                wp_loginout();
                //   wp_loginout();
                // } else {
                //   echo '<a href="/login">Log in</a>';
                // }
              ?>
            </div>
          </div>
      </div>

      <?php
        $userGetsWeeklyLeads  = $current_user->vendorweeklyleads;
        $userGetsShowLeadsAKR = $current_user->vendorshowleadsAKR;
        $userGetsShowLeadsCLE = $current_user->vendorshowleadsCLE;

        $postId = get_the_ID();
        $postIsWeeklyLeads = get_post_meta( $postId, 'vendor_weekly_leads', true );
        $postIsShowLeadsAKR = get_post_meta( $postId, 'vendor_show_leads_akron', true );
        $postIsShowLeadsCLE = get_post_meta( $postId, 'vendor_show_leads_cleveland', true );

        if(($postIsWeeklyLeads === 'yes' && $userGetsWeeklyLeads) || ($postIsShowLeadsAKR === 'yes' && $userGetsShowLeadsAKR) || ($postIsShowLeadsCLE === 'yes' && $userGetsShowLeadsCLE) || ($postIsWeeklyLeads !== 'yes' && $postIsShowLeadsAKR !== 'yes' && $postIsShowLeadsCLE !== 'yes')) {
      ?>
            <div class="wrapper">
                <?php the_title('<h1>', '</h1>'); ?>
                <?php the_post(); ?>
                <?php the_content(); ?>
                <?php edit_post_link( __( 'Edit', 'TB2017' ), '<span class="edit-link">', '</span>' ) ?>
            </div>
            <?php get_footer(); ?>

      <?php
        } else {
      ?>
        <div class="wrapper">
          <h3>You do not have access to view this page</h3>
          <p>If you would like access, please <a href="<?php bloginfo('url'); ?>/contact">contact us</a>.</p>
        </div>
      <?php
        }
      ?>


<?php
  }
?>