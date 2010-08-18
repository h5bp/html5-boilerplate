<?php
/**
 * @package WordPress
 * @subpackage HTML5_Boilerplate
 */

get_header(); ?>

<div id="main" role="main">

  <?php if (have_posts()) : ?>

  <section>
    <?php $post = $posts[0]; // Hack. Set $post so that the_date() works. ?>
    <?php /* If this is a category archive */ if (is_category()) { ?>
    <h2 class="pagetitle">Archive for the &#8216;<?php single_cat_title(); ?>&#8217; Category</h2>
    <?php /* If this is a tag archive */ } elseif( is_tag() ) { ?>
    <h2 class="pagetitle">Posts Tagged &#8216;<?php single_tag_title(); ?>&#8217;</h2>
    <?php /* If this is a daily archive */ } elseif (is_day()) { ?>
    <h2 class="pagetitle">Archive for <?php the_time('F jS, Y'); ?></h2>
    <?php /* If this is a monthly archive */ } elseif (is_month()) { ?>
    <h2 class="pagetitle">Archive for <?php the_time('F, Y'); ?></h2>
    <?php /* If this is a yearly archive */ } elseif (is_year()) { ?>
    <h2 class="pagetitle">Archive for <?php the_time('Y'); ?></h2>
    <?php /* If this is an author archive */ } elseif (is_author()) { ?>
    <h2 class="pagetitle">Author Archive</h2>
    <?php /* If this is a paged archive */ } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { ?>
    <h2 class="pagetitle">Blog Archives</h2>
    <?php } ?>

    <nav>
      <div><?php next_posts_link('&laquo; Older Entries') ?></div>
      <div><?php previous_posts_link('Newer Entries &raquo;') ?></div>
    </nav>

    <?php while (have_posts()) : the_post(); ?>
    <article <?php post_class() ?>>
      <header>
        <h3 id="post-<?php the_ID(); ?>"><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h3>
        <time datetime="<?php the_time('Y-m-d')?>"><?php the_time('l, F jS, Y') ?></time>
      </header>
      <?php the_content() ?>
      <footer>
        <?php the_tags('Tags: ', ', ', '<br />'); ?>
        Posted in <?php the_category(', ') ?>
        | <?php edit_post_link('Edit', '', ' | '); ?>
        <?php comments_popup_link('No Comments &#187;', '1 Comment &#187;', '% Comments &#187;'); ?>
      </footer>
    </article>
    <?php endwhile; ?>

    <nav>
      <div><?php next_posts_link('&laquo; Older Entries') ?></div>
      <div><?php previous_posts_link('Newer Entries &raquo;') ?></div>
    </nav>
  </section>

  <?php else :

  if ( is_category() ) { // If this is a category archive
    printf("<h2>Sorry, but there aren't any posts in the %s category yet.</h2>", single_cat_title('',false));
  } else if ( is_date() ) { // If this is a date archive
    echo("<h2>Sorry, but there aren't any posts with this date.</h2>");
  } else if ( is_author() ) { // If this is a category archive
    $userdata = get_userdatabylogin(get_query_var('author_name'));
    printf("<h2>Sorry, but there aren't any posts by %s yet.</h2>", $userdata->display_name);
  } else {
    echo("<h2>No posts found.</h2>");
  }
  get_search_form();

  endif;
  ?>

</div>

<?php get_sidebar(); ?>

<?php get_footer(); ?>
