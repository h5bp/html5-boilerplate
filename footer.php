<?php
/**
 * @package WordPress
 * @subpackage HTML5_Boilerplate
 */
?>

  <footer>
      <p>
        <?php bloginfo('name'); ?> is proudly powered by
        <a href="http://wordpress.org/">WordPress</a>, and built using the <a href="http://html5boilerplate.com/">HTML5 Boilerplate</a>.
        <br /><a href="<?php bloginfo('rss2_url'); ?>">Entries (RSS)</a>
        and <a href="<?php bloginfo('comments_rss2_url'); ?>">Comments (RSS)</a>.
        <!-- <?php echo get_num_queries(); ?> queries. <?php timer_stop(1); ?> seconds. -->
      </p>
  </footer>
</div> <!--! end of #container -->

  <!-- Javascript at the bottom for fast page loading -->

  <!-- Grab Google CDN's jQuery. fall back to local if necessary -->
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
  <script>!window.jQuery && document.write('<script src="<?php echo $template_url; ?>/js/jquery-1.4.2.min.js"><\/script>')</script>


  <script src="<?php echo $template_url; ?>/js/plugins.js?v=1"></script>
  <script src="<?php echo $template_url; ?>/js/script.js?v=1"></script>

  <!--[if lt IE 7 ]>
    <script src="<?php echo $template_url; ?>/js/dd_belatedpng.js?v=1"></script>
  <![endif]-->


  <!-- yui profiler and profileviewer - remove for production -->
  <script src="<?php echo $template_url; ?>/js/profiling/yahoo-profiling.min.js?v=1"></script>
  <script src="<?php echo $template_url; ?>/js/profiling/config.js?v=1"></script>
  <!-- end profiling code -->


  <!-- asynchronous google analytics: mathiasbynens.be/notes/async-analytics-snippet
       change the UA-XXXXX-X to be your site's ID -->
  <script>
   var _gaq = [['_setAccount', 'UA-XXXXX-X'], ['_trackPageview']];
   (function(d, t) {
    var g = d.createElement(t),
        s = d.getElementsByTagName(t)[0];
    g.async = true;
    g.src = '//www.google-analytics.com/ga.js';
    s.parentNode.insertBefore(g, s);
   })(document, 'script');
  </script>

  <?php wp_footer(); ?>

</body>
</html>
