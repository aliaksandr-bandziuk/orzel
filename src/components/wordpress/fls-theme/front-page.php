<?php /* Template Name: index page template */ ?>
<?php get_header() ?>
<main class="page">
  <div data-fls-index class="index">

    <?php while (have_posts()) : the_post(); ?>
      <?php the_content(); ?>
    <?php endwhile; ?>

  </div>
</main>
<?php get_footer() ?>