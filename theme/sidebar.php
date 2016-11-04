<?php dynamic_sidebar( 'blog-sidebar' ); ?>
<?php if(is_active_sidebar('more-articles')) { ?>
  <div id="%1$s" class="mod">
    <h3 class="mod-title">More Articles</h3>
    <?php dynamic_sidebar( 'more-articles' ); ?>
  </div>
<?php } ?>