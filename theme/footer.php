  <div class="footer">
    <div class="wrapper">
      <div class="footer-navigation">
        <?php wp_nav_menu( array( 'theme_location' => 'footer-navigation' ) ); ?>
      </div>
      <div class="socials">
        <?php wp_nav_menu( array( 'theme_location' => 'social-navigation' ) ); ?>
      </div>
<!-- 
      <div class="socials">
        <a class="social-fb" href="#"></a>
        <a class="social-pn" href="#"></a>
        <a class="social-yt" href="#"></a>
        <a class="social-tw" href="#"></a>
        <a class="social-ig" href="#"></a>
        <a class="social-vm" href="#"></a>
      </div>
 -->      
    </div>
    <div class="section muted">
      <div class="wrapper">
        <p><strong>Today's Bride &amp; Today's Pride serves the following Northeast Ohio cities:</strong> Akron, Canton, Cleveland, North Canton, Youngstown, Ashtabula, Aurora, Chagrin Falls, Cuyahoga Falls, Dover, Eastlake, Elyria, Euclid, Hudson, Independence, Kent, Lorain, Massillon, Medina, Mentor, North Ridgeville, Parma, Ravenna, Sandusky, Solon, Stow, Strongsville, Wadsworth, Warren, Willoughby, Wooster and all of Northeast Ohio.</p>
        <p>Copyright &copy; 2017 Today's Bride. All Rights Reserved.</p>
      </div>
    </div>
  </div>
  <?php wp_footer(); ?>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <script src="<?php bloginfo('template_directory'); ?>/scripts/interaction.js"></script>
</body>
</html>