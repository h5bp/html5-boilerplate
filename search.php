<?php
/**
 * @package WordPress
 * @subpackage HTML5_Boilerplate
 */

get_header(); ?>

  <div id="main" role="main">

  <?php if (have_posts()) : ?>

    <h2>Search Results</h2>

    <nav>
      <div><?php next_posts_link('&laquo; Older Entries') ?></div>
      <div><?php previous_posts_link('Newer Entries &raquo;') ?></div>
    </nav>

    <?php while (have_posts()) : the_post(); ?>

      <article <?php post_class() ?>>
        <h3 id="post-<?php the_ID(); ?>"><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h3>
        <time><?php the_time('l, F jS, Y') ?></time>

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

  <?php else : ?>

    <h2>No posts found. Try a different search?</h2>
    <?php get_search_form(); ?>

  <?php endif; ?>

  </div>

<?php get_sidebar(); ?>

<?php get_footer(); ?>
