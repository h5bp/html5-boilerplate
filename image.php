<?php
/**
 * @package WordPress
 * @subpackage HTML5_Boilerplate
 */

get_header(); ?>

  <div id="main">

  <?php if (have_posts()) : while (have_posts()) : the_post(); ?>

    <article id="post-<?php the_ID(); ?>">
      <header>
        <h2><a href="<?php echo get_permalink($post->post_parent); ?>" rev="attachment"><?php echo get_the_title($post->post_parent); ?></a> &raquo; <?php the_title(); ?></h2>
      </header>
      
      <p class="attachment"><a href="<?php echo wp_get_attachment_url($post->ID); ?>"><?php echo wp_get_attachment_image( $post->ID, 'medium' ); ?></a></p>
      <p class="caption"><?php if ( !empty($post->post_excerpt) ) the_excerpt(); // this is the "caption" ?></p>

      <?php the_content('<p class="serif">Read the rest of this entry &raquo;</p>'); ?>

      <nav>
        <div><?php previous_image_link() ?></div>
        <div><?php next_image_link() ?></div>
      </nav>
      <footer>
        <p>
          This entry was posted on <?php the_time('l, F jS, Y') ?> at <?php the_time() ?>
          and is filed under <?php the_category(', ') ?>.
          <?php the_taxonomies(); ?>
          You can follow any responses to this entry through the <?php post_comments_feed_link('RSS 2.0'); ?> feed.

          <?php if ( comments_open() && pings_open() ) {
            // Both Comments and Pings are open ?>
            You can <a href="#respond">leave a response</a>, or <a href="<?php trackback_url(); ?>" rel="trackback">trackback</a> from your own site.

          <?php } elseif ( !comments_open() && pings_open() ) {
            // Only Pings are Open ?>
            Responses are currently closed, but you can <a href="<?php trackback_url(); ?> " rel="trackback">trackback</a> from your own site.

          <?php } elseif ( comments_open() && !pings_open() ) {
            // Comments are open, Pings are not ?>
            You can skip to the end and leave a response. Pinging is currently not allowed.

          <?php } elseif ( !comments_open() && !pings_open() ) {
            // Neither Comments, nor Pings are open ?>
            Both comments and pings are currently closed.

          <?php } edit_post_link('Edit this entry.','',''); ?>
        </p>
      </footer>
    </article>

  <?php comments_template(); ?>

  <?php endwhile; else: ?>

    <p>Sorry, no attachments matched your criteria.</p>

<?php endif; ?>

  </div>

<?php get_footer(); ?>
