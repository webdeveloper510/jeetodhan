<?php
/**
 * The template for displaying all single posts.
 *
 * @package ModelTheme
 */

get_header(); ?>

	<div class="modeltheme-breadcrumbs">
	    <div id="overlay"></div>
	    <div class="container">
	        <div class="row">
	            <div class="col-md-12">
	                <h1 class="page-title"><?php echo esc_html__('Blog', 'pomana'); ?></h1>
	            </div>
	        </div>
	    </div>
	</div>

	<div id="primary" class="content-area">
		<main id="main" class="site-main">

		<?php while ( have_posts() ) : the_post(); ?>

			<?php get_template_part( 'content', 'single' ); ?>

		<?php endwhile; // end of the loop. ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_footer(); ?>