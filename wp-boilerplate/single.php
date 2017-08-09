<?php
/**
 * Single post template
 *
 * @package WordPress
 * @version 1.0
 */
get_header();
?>

<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
 
	<section class="post-area no-banner">

	</section>

<?php endwhile; endif; ?>

<?php get_footer();