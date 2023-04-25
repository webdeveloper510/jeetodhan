<?php
/**
 * The template part for displaying a message that posts cannot be found.
 *
 * Learn more: http://codex.WordPress.org/Template_Hierarchy
 *
 */
?>

<section class="no-results not-found">
	<div class="page-content">
		<?php if ( is_home() && current_user_can( 'publish_posts' ) ) : ?>

			<h3 class="page-title"><?php printf(__( 'Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'pomana'), esc_url( admin_url( 'post-new.php' ) ) ); ?></h3>

		<?php elseif ( is_search() ) : ?>

			<h2 class="page-title"><?php esc_html_e( 'Nothing Found', 'pomana' ); ?></h2>
			<?php get_search_form(); ?>
			<p class="page-title"><?php esc_html_e( 'Try to search using another term via the form above', 'pomana' ); ?></p>

		<?php elseif ( is_author() ) : ?>

			<h2 class="page-title"><?php esc_html_e( 'Nothing Found', 'pomana' ); ?></h2>
			<p class="page-title"><?php esc_html_e( 'Try to search for posts via the form above', 'pomana' ); ?></p>
			<?php get_search_form(); ?>

		<?php else : ?>

			<p class="page-title"><?php esc_html_e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'pomana' ); ?></p>
			<?php get_search_form(); ?>

		<?php endif; ?>
	</div><!-- .page-content -->
</section><!-- .no-results -->