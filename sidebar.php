<?php
/**
 * @package WordPress
 * @subpackage HTML5_Boilerplate
 */
?>
<aside id="sidebar">
  <?php   /* Widgetized sidebar, if you have the plugin installed. */
      if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar() ) : ?>

  <section>
    <?php get_search_form(); ?>
  </section>

  <!-- Author information is disabled per default. Uncomment and fill in your details if you want to use it.
  <section>
    <h2>Author</h2>
    <p>A little something about you, the author. Nothing lengthy, just an overview.</p>
  </section>
  -->

  <?php if ( is_404() || is_category() || is_day() || is_month() || is_year() || is_search() || is_paged() ) { ?> 
  <section>
    
    <?php /* If this is a 404 page */ if (is_404()) { ?>
    <?php /* If this is a category archive */ } elseif (is_category()) { ?>
    <p>You are currently browsing the archives for the <?php single_cat_title(''); ?> category.</p>

    <?php /* If this is a daily archive */ } elseif (is_day()) { ?>
    <p>You are currently browsing the <a href="<?php bloginfo('url'); ?>/"><?php bloginfo('name'); ?></a> blog archives
    for the day <?php the_time('l, F jS, Y'); ?>.</p>

    <?php /* If this is a monthly archive */ } elseif (is_month()) { ?>
    <p>You are currently browsing the <a href="<?php bloginfo('url'); ?>/"><?php bloginfo('name'); ?></a> blog archives
    for <?php the_time('F, Y'); ?>.</p>

    <?php /* If this is a yearly archive */ } elseif (is_year()) { ?>
    <p>You are currently browsing the <a href="<?php bloginfo('url'); ?>/"><?php bloginfo('name'); ?></a> blog archives
    for the year <?php the_time('Y'); ?>.</p>

    <?php /* If this is a search result */ } elseif (is_search()) { ?>
    <p>You have searched the <a href="<?php bloginfo('url'); ?>/"><?php bloginfo('name'); ?></a> blog archives
    for <strong>'<?php the_search_query(); ?>'</strong>. If you are unable to find anything in these search results, you can try one of these links.</p>

    <?php /* If this set is paginated */ } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { ?>
    <p>You are currently browsing the <a href="<?php bloginfo('url'); ?>/"><?php bloginfo('name'); ?></a> blog archives.</p>

    <?php } ?>

  </section>
  <?php }?>
  
  <nav role="navigation">
    <?php wp_list_pages('title_li=<h2>Pages</h2>' ); ?>

    <h2>Archives</h2>
    <ul>
      <?php wp_get_archives('type=monthly'); ?>
    </ul>

    <?php wp_list_categories('show_count=1&title_li=<h2>Categories</h2>'); ?>
  </nav>

  <nav>
    <ul>
      <?php /* If this is the frontpage */ if ( is_home() || is_page() ) { ?>
        <?php wp_list_bookmarks(); ?>

        <li><h2>Meta</h2>
        <ul>
          <?php wp_register(); ?>
          <li><?php wp_loginout(); ?></li>
          <li><a href="http://validator.w3.org/check/referer" title="This page validates as XHTML 1.0 Transitional">Valid <abbr title="eXtensible HyperText Markup Language">XHTML</abbr></a></li>
          <li><a href="http://gmpg.org/xfn/"><abbr title="XHTML Friends Network">XFN</abbr></a></li>
          <li><a href="http://wordpress.org/" title="Powered by WordPress, state-of-the-art semantic personal publishing platform.">WordPress</a></li>
          <?php wp_meta(); ?>
        </ul>
        </li>
      <?php } ?>

      <?php endif; ?>
    </ul>
  </nav>
</aside>

