<?php
/**
 * The template for displaying all single posts.
 *
 * @package ModelTheme
 */

get_header(); ?>

	<div id="primary" class="content-area single-service-template">
		<main id="main" class="site-main">

		<?php while ( have_posts() ) : the_post(); ?>

			<?php get_template_part( 'content', 'single-service' ); ?>

		<?php endwhile; // end of the loop. ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_footer(); ?>