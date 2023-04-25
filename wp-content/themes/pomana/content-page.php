<?php
/**
 * The template used for displaying page content in page.php
 *
 * @package Modeltheme
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="entry-content">
		<?php the_content(); ?>
		<div class="clearfix"></div>
		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'pomana' ),
				'after'  => '</div>',
			) );
		?>
		<div class="clearfix"></div>
	</div><!-- .entry-content -->
</article><!-- #post-## -->
