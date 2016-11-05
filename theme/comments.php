<?php
/*
 * If the current post is protected by a password and the visitor has not yet
 * entered the password we will return early without loading the comments.
 */
if ( post_password_required() ) {
  return;
}
?>

<div class="comments">
                    
  <?php if ( have_comments() ) : ?>

  <h3>
    <?php
      printf( _n( '1 Comment', '%1$s Comments', get_comments_number(), 'TB2017' ),
        number_format_i18n( get_comments_number() ) );
    ?>
  </h3>

  <?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
  <nav id="comment-nav-above" class="navigation comment-navigation" role="navigation">
    <h1 class="screen-reader-text"><?php _e( 'Comment navigation', 'TB2017' ); ?></h1>
    <div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', 'TB2017' ) ); ?></div>
    <div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', 'TB2017' ) ); ?></div>
  </nav><!-- #comment-nav-above -->
  <?php endif; // Check for comment navigation. ?>

    <?php
      wp_list_comments( array(
        'style'      => 'div',
        'short_ping' => true,
        'avatar_size'=> 34,
      ) );
    ?>

  <?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
  <nav id="comment-nav-below" class="navigation comment-navigation" role="navigation">
    <h1 class="screen-reader-text"><?php _e( 'Comment navigation', 'TB2017' ); ?></h1>
    <div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', 'TB2017' ) ); ?></div>
    <div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', 'TB2017' ) ); ?></div>
  </nav><!-- #comment-nav-below -->
  <?php endif; // Check for comment navigation. ?>

  <?php if ( ! comments_open() ) : ?>
  <p class="no-comments"><?php _e( 'Comments are closed.', 'TB2017' ); ?></p>
  <?php endif; ?>

  <?php endif; // have_comments() ?>

  <?php comment_form(); ?>


<!--       <div class="comment-form">
        <h2 class="mono">Leave a reply</h2>
        <label>Name <span class="required">*</span></label>
        <input type="text" />
        <label>Email <span class="required">*</span></label>
        <input type="text" />
        <label>Website</label>
        <input type="text" />
        <label>Comment <span class="required">*</span></label>
        <textarea></textarea>
        <p class="description required">*required field</p>
        <input type="submit" class="btn" value="Submit Comment" />
      </div>
 -->

    <!--
                        <form>
                            <h1>Leave a Comment</h1>
                            <label>Name</label>
                            <input type="text" name="name" />
                            <label>Email</label>
                            <input type="text" name="email" />
                            <label>Comment</label>
                            <textarea name="comment"></textarea>
                            <input class="btn blue" type="submit" value="Submit Comment" />
                        </form>
                        <h1>17 Comments</h1>
                        <div class="comment">
                            <span class="article_date">February 6, 2014 10:47 pm</span>
                            <h3>John Smith</h3>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed aliquam condimentum malesuada. Quisque cursus mauris a consequat sodales. Vestibulum volutpat ornare blandit. Ut iaculis, nulla ut blandit volutpat, neque dolor ornare sapien, in bibendum tellus risus ut elit.</p>
                        </div>
                        <a class="more_comments" href="#">Load More Comments</a>
                        -->
</div>
